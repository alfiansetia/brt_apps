<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ComponentResource;
use App\Models\Component;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['name']);
        $query = Component::query()->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return ComponentResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['name']);
        $data = Component::query()->filter($filters)->latest('id')->paginate(intval($request->limit) ?? 10);
        return ComponentResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:200|unique:components,name',
            'desc'      => 'nullable|max:200',
        ]);
        $component = Component::create([
            'name'          => $request->name,
            'desc'          => $request->desc,
        ]);
        return $this->response('Sukses Tambah Data!', new ComponentResource($component), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Component $component)
    {
        return new ComponentResource($component);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Component $component)
    {
        $this->validate($request, [
            'name'      => 'required|max:200|unique:components,name,' . $component->id,
            'desc'      => 'nullable|max:200',
        ]);
        $component->update([
            'name'          => $request->name,
            'desc'          => $request->desc,
        ]);
        return $this->response('Sukses Ubah Data!', new ComponentResource($component), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Component $component)
    {
        $component->delete();
        return $this->response('Sukses Hapus Data!', new ComponentResource($component), 200);
    }
}
