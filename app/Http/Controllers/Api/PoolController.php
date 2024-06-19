<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PoolResource;
use App\Models\Pool;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['name']);
        $query = Pool::query()->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return PoolResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['name']);
        $data = Pool::query()->filter($filters)->paginate(intval($request->limit) ?? 10);
        return PoolResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required|max:200',
            'image' => 'required|max:200',
        ]);
        $pool = Pool::create([
            'name'  => $request->name,
            'image' => $request->image,
        ]);
        return $this->response('Sukses Tambah Data!', new PoolResource($pool), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pool $pool)
    {
        return new PoolResource($pool);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pool $pool)
    {
        $this->validate($request, [
            'name'  => 'required|max:200',
            'image' => 'required|max:200',
        ]);
        $pool->update([
            'name'      => $request->name,
            'image'     => $request->image,
        ]);
        return $this->response('Sukses Ubah Data!', new PoolResource($pool), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pool $pool)
    {
        $pool->delete();
        return $this->response('Sukses Hapus Data!', new PoolResource($pool), 200);
    }
}
