<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OilCoolantResource;
use App\Models\OilCoolant;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OilCoolantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['user_id', 'unit_id', 'product_id', 'type']);
        $query = OilCoolant::query()->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return OilCoolantResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['user_id', 'unit_id', 'product_id', 'type']);
        $data = OilCoolant::query()->filter($filters)->paginate(intval($request->limit) ?? 10);
        return OilCoolantResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OilCoolant $oil)
    {
        return new OilCoolantResource($oil);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OilCoolant $oil)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OilCoolant $oil)
    {
        $oil->delete();
        return $this->response('Sukses Hapus Data!', new OilCoolantResource($oil), 200);
    }
}
