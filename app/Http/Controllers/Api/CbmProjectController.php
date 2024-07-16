<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CbmProjectResource;
use App\Models\CbmProject;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CbmProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['pn', 'name', 'pool_id']);
        $query = CbmProject::query()->with(['pool'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return CbmProjectResource::make($item)->resolve();
        })->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pool_id'       => 'required|exists:pools,id',
            'part_number'   => 'required|max:200',
            'name'          => 'required|max:200',
            'target'        => 'required|integer|gte:0',
        ]);
        $cbm_project = CbmProject::create([
            'pool_id'       => $request->pool_id,
            'pn'            => $request->part_number,
            'name'          => $request->name,
            'target'        => $request->target,
        ]);
        return $this->response('Sukses Tambah Data!', new CbmProjectResource($cbm_project), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(CbmProject $cbm_project)
    {
        return new CbmProjectResource($cbm_project->load(['pool']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CbmProject $cbm_project)
    {
        $this->validate($request, [
            'part_number'   => 'required|max:200',
            'name'          => 'required|max:200',
            'target'        => 'required|integer|gte:0',
        ]);
        $cbm_project->update([
            'pn'            => $request->part_number,
            'name'          => $request->name,
            'target'        => $request->target,
        ]);
        return $this->response('Sukses Ubah Data!', new CbmProjectResource($cbm_project), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CbmProject $cbm_project)
    {
        $cbm_project->delete();
        return $this->response('Sukses Hapus Data!', new CbmProjectResource($cbm_project), 200);
    }
}
