<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin'])->only(['destroy', 'store', 'update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['pool_id', 'code', 'type']);
        $query = Unit::query()->with('pool')->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return UnitResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['pool_id', 'code', 'type']);
        $data = Unit::query()->filter($filters)->latest('id')->with('pool')->paginate(intval($request->limit) ?? 10);
        return UnitResource::collection($data);
    }

    public function findcode(Unit $unit)
    {
        return new UnitResource($unit->load('pool'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pool'  => 'required|exists:pools,id',
            'code'  => 'required|unique:units,code',
            'type'  => 'required|in:maxi,artic,low entry',
            'desc'  => 'nullable|max:200',
        ]);
        $unit = Unit::create([
            'pool_id'   => $request->pool,
            'code'      => $request->code,
            'type'      => $request->type,
            'desc'      => $request->desc,
        ]);
        return $this->response('Sukses Tambah Data!', new UnitResource($unit), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return new UnitResource($unit->load('pool'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $this->validate($request, [
            'pool'  => 'required|exists:pools,id',
            'code'  => 'required|unique:units,code,' . $unit->id,
            'type'  => 'required|in:maxi,artic,low entry',
            'desc'  => 'nullable|max:200',
        ]);
        $unit->update([
            'pool_id'   => $request->pool,
            'code'      => $request->code,
            'type'      => $request->type,
            'desc'      => $request->desc,
        ]);
        return $this->response('Sukses Ubah Data!', new UnitResource($unit), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return $this->response('Sukses Hapus Data!', new UnitResource($unit), 200);
    }
}
