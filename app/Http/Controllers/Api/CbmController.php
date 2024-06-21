<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CbmResource;
use App\Models\Cbm;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CbmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['date', 'unit_id', 'component_id', 'pool_id']);
        $query = Cbm::query()->with(['unit', 'component'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
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
            'date'      => 'required|date_format:Y-m-d',
            'unit'      => 'required|exists:units,id',
            'component' => 'required|exists:components,id',
            'km'        => 'required|integer|gte:0',
            'desc'      => 'nullable|max:200',
        ]);
        $cbm = Cbm::create([
            'date'          => $request->date,
            'unit_id'       => $request->unit,
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
            'date'      => 'required|date_format:Y-m-d',
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
}
