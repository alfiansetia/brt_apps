<?php

namespace App\Http\Controllers\Api;

use App\Exports\HmkmExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\HmkmResource;
use App\Models\Hmkm;
use App\Models\Pool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class HmkmController extends Controller
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
        $filters = $request->only(['pool_id', 'unit_id']);
        $query = Hmkm::query()->with('unit')->filter($filters);
        return DataTables::eloquent($query)->filterColumn('date', function ($query, $keyword) {
            try {
                $date = Carbon::createFromFormat('d/m/Y', $keyword)->format('Y-m-d');
                $query->whereDate('date', $date);
            } catch (\Exception $e) {
                // 
            }
        })->filterColumn('unit_id', function ($query, $keyword) {
            $query->whereRelation('unit', 'code', 'like', "%$keyword%");
        })->setTransformer(function ($item) {
            return HmkmResource::make($item)->resolve();
        })->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date'      => 'required|date_format:d/m/Y',
            'unit'      => 'required|exists:units,id',
            'pool_id'   => 'required|exists:pools,id',
            'hm'        => 'required|integer|gte:0',
            'km'        => 'required|integer|gte:0',
            'hm_ac'     => 'required|integer|gte:0',
            'desc'      => 'nullable|max:200',
            'breakpad1' => 'required|integer|gte:0',
            'breakpad2' => 'required|integer|gte:0',
            'breakpad3' => 'required|integer|gte:0',
            'breakpad4' => 'required|integer|gte:0',
            'breakpad5' => 'required|integer|gte:0',
            'breakpad6' => 'required|integer|gte:0',
        ]);
        $hmkm = Hmkm::create([
            'date'      => $request->date,
            'unit_id'   => $request->unit,
            'pool_id'   => $request->pool_id,
            'hm'        => $request->hm,
            'km'        => $request->km,
            'hm_ac'     => $request->hm_ac,
            'desc'      => $request->desc,
            'breakpad1' => $request->breakpad1,
            'breakpad2' => $request->breakpad2,
            'breakpad3' => $request->breakpad3,
            'breakpad4' => $request->breakpad4,
            'breakpad5' => $request->breakpad5,
            'breakpad6' => $request->breakpad6,
        ]);
        return $this->response('Sukses Tambah Data!', new HmkmResource($hmkm), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hmkm $hmkm)
    {
        return new HmkmResource($hmkm->load('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hmkm $hmkm)
    {
        $this->validate($request, [
            'date'      => 'required|date_format:d/m/Y',
            'unit'      => 'required|exists:units,id',
            'hm'        => 'required|integer|gte:0',
            'km'        => 'required|integer|gte:0',
            'hm_ac'     => 'required|integer|gte:0',
            'desc'      => 'nullable|max:200',
            'breakpad1' => 'required|integer|gte:0',
            'breakpad2' => 'required|integer|gte:0',
            'breakpad3' => 'required|integer|gte:0',
            'breakpad4' => 'required|integer|gte:0',
            'breakpad5' => 'required|integer|gte:0',
            'breakpad6' => 'required|integer|gte:0',
        ]);
        $hmkm->update([
            'date'      => $request->date,
            'unit_id'   => $request->unit,
            'hm'        => $request->hm,
            'km'        => $request->km,
            'hm_ac'     => $request->hm_ac,
            'desc'      => $request->desc,
            'breakpad1' => $request->breakpad1,
            'breakpad2' => $request->breakpad2,
            'breakpad3' => $request->breakpad3,
            'breakpad4' => $request->breakpad4,
            'breakpad5' => $request->breakpad5,
            'breakpad6' => $request->breakpad6,
        ]);
        return $this->response('Sukses Ubah Data!', new HmkmResource($hmkm), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hmkm $hmkm)
    {
        $hmkm->delete();
        return $this->response('Sukses Hapus Data!', new HmkmResource($hmkm), 200);
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:hmkms,id',
        ]);
        $ids = $request->id;
        $deleted = Hmkm::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->response($message, $deleted);
    }

    public function truncate(Request $request)
    {
        $this->validate($request, [
            'pool_id'   => 'required|exists:pools,id',
        ]);
        $pool = Pool::find($request->pool_id);
        $deleted =  Hmkm::where('pool_id', $pool->id)->delete();
        $message = 'Success Delete All Data On Pool ' . $pool->name;
        return $this->response($message, $deleted);
    }


    public function export(Request $request)
    {
        $this->validate($request, [
            'from'      => 'required|date_format:d/m/Y',
            'to'        => 'required|date_format:d/m/Y',
            'pool_id'   => 'required|exists:pools,id',
            'unit_id'   => 'nullable|exists:units,id',
        ]);
        $filters = $request->only(['from', 'to', 'pool_id', 'unit_id']);
        $name = Str::slug('export_hmkm_' . $request->from . '_' . $request->to);
        return Excel::download(new HmkmExport($filters), $name . '.xls', ExcelExcel::XLS);
    }
}
