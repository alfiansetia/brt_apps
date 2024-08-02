<?php

namespace App\Http\Controllers\Api;

use App\Exports\PpmDataExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\PpmDataResource;
use App\Models\PpmData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class PpmDataController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin'])->only(['destroy', 'destroyBatch', 'truncate']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['unit_id', 'pool_id', 'ppm_id', 'date']);
        $query = PpmData::query()->with(['unit', 'ppm'])->filter($filters);
        return DataTables::eloquent($query)->filterColumn('unit_id', function ($query, $keyword) {
            $query->whereRelation('unit', 'code', 'like', "%$keyword%");
        })->filterColumn('ppm_id', function ($query, $keyword) {
            $query->whereRelation('ppm', 'name', 'like', "%$keyword%");
        })->filterColumn('date', function ($query, $keyword) {
            try {
                $date = Carbon::createFromFormat('d/m/Y', $keyword)->format('Y-m-d');
                $query->whereDate('date', $date);
            } catch (\Exception $e) {
                // 
            }
        })->setTransformer(function ($item) {
            return PpmDataResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['name']);
        $data = PpmData::query()->with(['unit', 'ppm'])->filter($filters)->paginate(intval($request->limit) ?? 10);
        return PpmDataResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date'      => 'required|date_format:d/m/Y',
            'unit'      => 'required|exists:units,id',
            'ppm'       => 'required|exists:ppms,id',
            'file'      => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);
        $file = null;
        if ($files = $request->file('file')) {
            $destinationPath = public_path('/assets/file/ppm/');
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 755, true);
            }
            $file = 'ppm_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
        }
        $ppmdata = PpmData::create([
            'date'      => $request->date,
            'unit_id'   => $request->unit,
            'ppm_id'    => $request->ppm,
            'file'      => $file,
        ]);
        return $this->response('Sukses Tambah Data!', new PpmDataResource($ppmdata), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(PpmData $ppmdata)
    {
        return new PpmDataResource($ppmdata->load(['unit', 'ppm']));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PpmData $ppmdata)
    {
        $this->validate($request, [
            'date'      => 'required|date_format:d/m/Y',
            'unit'      => 'required|exists:units,id',
            'ppm'       => 'required|exists:ppms,id',
            'file'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);
        $file = $ppmdata->getRawOriginal('file');
        if ($files = $request->file('file')) {
            $destinationPath = public_path('/assets/file/ppm/');
            if (!empty($file) && file_exists($destinationPath . $file)) {
                File::delete($destinationPath . $file);
            }
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 755, true);
            }
            $file = 'ppm_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
        }
        $ppmdata->update([
            'date'      => $request->date,
            'unit_id'   => $request->unit,
            'ppm_id'    => $request->ppm,
            'file'      => $file,
        ]);
        return $this->response('Sukses Ubah Data!', new PpmDataResource($ppmdata), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PpmData $ppmdata)
    {
        $file = $ppmdata->getRawOriginal('file');
        $destinationPath = public_path('/assets/file/ppm/');
        if (!empty($file) && file_exists($destinationPath . $file)) {
            File::delete($destinationPath . $file);
        }
        $ppmdata->delete();
        return $this->response('Sukses Hapus Data!', new PpmDataResource($ppmdata), 200);
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:ppm_data,id',
        ]);
        $ids = $request->id;
        $deleted = PpmData::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->response($message, $deleted);
    }

    public function truncate()
    {
        $deleted =  PpmData::truncate();
        if (file_exists(public_path('/assets/file/ppm/'))) {
            File::cleanDirectory(public_path('/assets/file/ppm/'));
        }
        $message = 'Success Delete All Data !';
        return $this->response($message, $deleted);
    }

    public function export(Request $request)
    {
        $this->validate($request, [
            'from'      => 'required|date_format:d/m/Y',
            'to'        => 'required|date_format:d/m/Y',
        ]);
        $filters = $request->only(['from', 'to']);
        $name = Str::slug('export_ppmdata_' . $request->from . '_' . $request->to);
        return Excel::download(new PpmDataExport($filters), $name . '.xls', ExcelExcel::XLS);
    }
}
