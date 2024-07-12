<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KeluhanResource;
use App\Models\Keluhan;
use App\Models\Pool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KeluhanController extends Controller
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
        $filters = $request->only(['pool_id', 'date', 'name', 'responsible', 'status', 'activity']);
        $query = Keluhan::query()->with(['unit'])->filter($filters);
        return DataTables::eloquent($query)->filterColumn('date', function ($query, $keyword) {
            try {
                $date = Carbon::createFromFormat('d/m/Y', $keyword)->format('Y-m-d');
                $query->whereDate('date', $date);
            } catch (\Exception $e) {
                // 
            }
        })->setTransformer(function ($item) {
            return KeluhanResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['pool_id']);
        $data = Keluhan::query()->with(['unit'])->filter($filters)->paginate(intval($request->limit) ?? 10);
        return KeluhanResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date'          => 'required|date_format:d/m/Y',
            'name'          => 'required|max:200',
            'unit'          => 'required|exists:units,id',
            'km'            => 'required|integer|gte:0',
            'keluhan'       => 'required|max:200',
            'responsible'   => 'required|in:UT,MB,TJ',
            'status'        => 'required|in:pending,done',
            'activity'      => 'nullable|max:200',
        ]);
        $keluhan = Keluhan::create([
            'date'          => $request->date,
            'name'          => $request->name,
            'unit_id'       => $request->unit,
            'km'            => $request->km,
            'keluhan'       => $request->keluhan,
            'responsible'   => $request->responsible,
            'status'        => $request->status,
            'activity'      => $request->activity,
        ]);
        return $this->response('Sukses Tambah Data!', new KeluhanResource($keluhan), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Keluhan $keluhan)
    {
        return new KeluhanResource($keluhan->load('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keluhan $keluhan)
    {
        $this->validate($request, [
            'date'          => 'required|date_format:d/m/Y',
            'name'          => 'required|max:200',
            'unit'          => 'required|exists:units,id',
            'km'            => 'required|integer|gte:0',
            'keluhan'       => 'required|max:200',
            'responsible'   => 'required|in:UT,MB,TJ',
            'status'        => 'required|in:pending,done',
            'activity'      => 'nullable|max:200',
        ]);
        $keluhan->update([
            'date'          => $request->date,
            'name'          => $request->name,
            'unit_id'       => $request->unit,
            'km'            => $request->km,
            'keluhan'       => $request->keluhan,
            'responsible'   => $request->responsible,
            'status'        => $request->status,
            'activity'      => $request->activity,
        ]);
        return $this->response('Sukses Ubah Data!', new KeluhanResource($keluhan), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keluhan $keluhan)
    {
        $keluhan->delete();
        return $this->response('Sukses Hapus Data!', new KeluhanResource($keluhan), 200);
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:keluhans,id',
        ]);
        $ids = $request->id;
        $deleted = Keluhan::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->response($message, $deleted);
    }

    public function truncate(Request $request)
    {
        $this->validate($request, [
            'pool_id'   => 'required|exists:pools,id',
        ]);
        $pool = Pool::find($request->pool_id);
        $deleted =  Keluhan::whereRelation('unit', 'pool_id', $pool->id)->delete();
        $message = 'Success Delete All Data On Pool ' . $pool->name;
        return $this->response($message, $deleted);
    }
}
