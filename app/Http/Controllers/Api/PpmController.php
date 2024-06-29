<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PpmResource;
use App\Models\Ppm;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PpmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['name']);
        $query = Ppm::query()->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return PpmResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['name']);
        $data = Ppm::query()->filter($filters)->paginate(intval($request->limit) ?? 10);
        return PpmResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:200|unique:ppms,name'
        ]);
        $ppm = Ppm::create([
            'name' => $request->name
        ]);
        return $this->response('Sukses Tambah Data!', new PpmResource($ppm), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ppm $ppm)
    {
        return new PpmResource($ppm);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ppm $ppm)
    {
        $this->validate($request, [
            'name' => 'required|max:200|unique:ppms,name,' . $ppm->id
        ]);
        $ppm->update([
            'name' => $request->name
        ]);
        return $this->response('Sukses Ubah Data!', new PpmResource($ppm), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ppm $ppm)
    {
        //
    }
}
