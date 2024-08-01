<?php

namespace App\Http\Controllers\Api;

use App\Exports\SpeedExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpeedResource;
use App\Models\Pool;
use App\Models\Speed;
use App\Models\SpeedItem;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class SpeedController extends Controller
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
        $filters = $request->only(['date']);
        $query = Speed::query()->with('items.unit')->filter($filters);
        return DataTables::eloquent($query)->filterColumn('date', function ($query, $keyword) {
            try {
                $date = Carbon::createFromFormat('d/m/Y', $keyword)->format('Y-m-d');
                $query->whereDate('date', $date);
            } catch (\Exception $e) {
                // 
            }
        })->setTransformer(function ($item) {
            return SpeedResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['date', 'pool_id']);
        $data = Speed::query()->with('items.unit')->filter($filters)->paginate(intval($request->limit) ?? 10);
        return SpeedResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                // 'date'      => 'required|date_format:d/m/Y|unique:speeds,date',
                'date'      => 'required|date_format:d/m/Y',
                'pool_id'   => 'required|exists:pools,id',
                'units'     => 'array',
                'values'    => 'array',
                'units.*'   => 'exists:units,id|distinct',
                'values.*'  => 'integer|gte:0',
            ]
        );
        $speed = Speed::create([
            'date'      => $request->date,
            'pool_id'   => $request->pool_id,
        ]);
        foreach ($request->units ?? [] as $item) {
            $speeditem = SpeedItem::create([
                'speed_id'  => $speed->id,
                'unit_id'   => $item,
                'value'     => $request->values[$item],
            ]);
        }
        return $this->response('Sukses Tambah Data!', new SpeedResource($speed), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Speed $speed)
    {
        return new SpeedResource($speed->load('items.unit.pool'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Speed $speed)
    {
        $this->validate(
            $request,
            [
                // 'date'      => 'required|date_format:d/m/Y|unique:speeds,date,' . $speed->id,
                'date'      => 'required|date_format:d/m/Y',
                'units'     => 'array',
                'values'    => 'array',
                'units.*'   => 'exists:units,id',
                'values.*'  => 'integer|gte:0',
            ]
        );
        $speed->update([
            'date'      => $request->date,
        ]);
        foreach ($speed->items  as $item) {
            $item->delete();
        }
        foreach ($request->units ?? [] as $item) {
            $speeditem = SpeedItem::create([
                'speed_id'  => $speed->id,
                'unit_id'   => $item,
                'value'     => $request->values[$item],
            ]);
        }
        return $this->response('Sukses Ubah Data!', new SpeedResource($speed), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Speed $speed)
    {
        $speed->delete();
        return $this->response('Sukses Hapus Data!', new SpeedResource($speed), 200);
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:speeds,id',
        ]);
        $ids = $request->id;
        $deleted = Speed::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->response($message, $deleted);
    }

    public function truncate(Request $request)
    {
        $this->validate($request, [
            'pool_id'   => 'required|exists:pools,id',
        ]);
        $pool = Pool::find($request->pool_id);
        $deleted =  Speed::where('pool_id', $pool->id)->delete();
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
        $units = Unit::filter($filters)->get();

        $results['column'] = ['Unit'];
        $results['row'] = [];

        $speeds = Speed::filter($filters)->with('items.unit')->orderBy('date', 'ASC')->get();
        $results['column'] = array_merge($results['column'], $speeds->pluck('date')->toArray());
        foreach ($units as $key => $unit) {
            $data = [];
            $data[] = $unit->code;
            foreach ($speeds  as $item) {
                $data[] = $item->items()->where('unit_id', $unit->id)->first()->value ?? 0;
            }
            $results['row'][$key] = $data;
        }
        $name = Str::slug('export_speeds_' . $request->from . '_' . $request->to);
        return Excel::download(new SpeedExport($results), $name . '.xls', ExcelExcel::XLS);
    }
}
