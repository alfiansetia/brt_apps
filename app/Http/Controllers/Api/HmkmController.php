<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HmkmResource;
use App\Models\Hmkm;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HmkmController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['pool_id']);
        $query = Hmkm::query()->with('unit')->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
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
}
