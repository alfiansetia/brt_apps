<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KeluhanResource;
use App\Models\Keluhan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KeluhanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['pool_id']);
        $query = Keluhan::query()->with(['unit'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
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
            'date'          => 'required|date_format:Y-m-d',
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
            'date'          => 'required|date_format:Y-m-d',
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
}
