<?php

namespace App\Http\Controllers\Api;

use App\Exports\CbmExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\CbmResource;
use App\Models\Cbm;
use App\Models\Pool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class CbmController extends Controller
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
        $filters = $request->only(['date', 'unit_id', 'component_id', 'pool_id']);
        $query = Cbm::query()->with(['unit', 'component'])->filter($filters);
        return DataTables::eloquent($query)->filterColumn('date', function ($query, $keyword) {
            try {
                $date = Carbon::createFromFormat('d/m/Y', $keyword)->format('Y-m-d');
                $query->whereDate('date', $date);
            } catch (\Exception $e) {
                // 
            }
        })->filterColumn('unit_id', function ($query, $keyword) {
            $query->whereRelation('unit', 'code', 'like', "%$keyword%");
        })->filterColumn('component_id', function ($query, $keyword) {
            $query->whereRelation('component', 'code', 'like', "%$keyword%");
        })->setTransformer(function ($item) {
            return CbmResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['date', 'unit_id', 'component_id', 'pool_id']);
        $data = Cbm::query()->with(['unit', 'component'])->filter($filters)->paginate(intval($request->limit) ?? 10);
        return CbmResource::collection($data);
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
            'component' => 'required|exists:components,id',
            'km'        => 'required|integer|gte:0',
            'desc'      => 'nullable|max:200',
        ]);
        $cbm = Cbm::create([
            'date'          => $request->date,
            'unit_id'       => $request->unit,
            'pool_id'       => $request->pool_id,
            'component_id'  => $request->component,
            'km'            => $request->km,
            'desc'          => $request->desc,
        ]);
        return $this->response('Sukses Tambah Data!', new CbmResource($cbm), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cbm $cbm)
    {
        return new CbmResource($cbm->load(['unit', 'component']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cbm $cbm)
    {
        $this->validate($request, [
            'date'      => 'required|date_format:d/m/Y',
            'unit'      => 'required|exists:units,id',
            'component' => 'required|exists:components,id',
            'km'        => 'required|integer|gte:0',
            'desc'      => 'nullable|max:200',
        ]);
        $cbm->update([
            'date'          => $request->date,
            'unit_id'       => $request->unit,
            'component_id'  => $request->component,
            'km'            => $request->km,
            'desc'          => $request->desc,
        ]);
        return $this->response('Sukses Ubah Data!', new CbmResource($cbm), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cbm $cbm)
    {
        $cbm->delete();
        return $this->response('Sukses Hapus Data!', new CbmResource($cbm), 200);
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:cbms,id',
        ]);
        $ids = $request->id;
        $deleted = Cbm::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->response($message, $deleted);
    }

    public function truncate(Request $request)
    {
        $this->validate($request, [
            'pool_id'   => 'required|exists:pools,id',
        ]);
        $pool = Pool::find($request->pool_id);
        $deleted =  Cbm::where('pool_id', $pool->id)->delete();
        $message = 'Success Delete All Data On Pool ' . $pool->name;
        return $this->response($message, $deleted);
    }


    public function export(Request $request)
    {
        $this->validate($request, [
            'from'      => 'required|date_format:d/m/Y',
            'to'        => 'required|date_format:d/m/Y',
            'pool_id'   => 'required|exists:pools,id',
        ]);
        $filters = $request->only(['from', 'to', 'pool_id']);
        $name = Str::slug('export_cbm_' . $request->from . '_' .  $request->to);
        return Excel::download(new CbmExport($filters), $name . '.xls', ExcelExcel::XLS);
    }
}
