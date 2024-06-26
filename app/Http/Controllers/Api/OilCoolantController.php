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
        $filters = $request->only(['user_id', 'unit_id', 'product_id', 'type', 'pool_id']);
        $query = OilCoolant::query()->with(['user', 'product', 'unit'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return OilCoolantResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['user_id', 'unit_id', 'product_id', 'type', 'pool_id']);
        $data = OilCoolant::query()->with(['user', 'product', 'unit'])->filter($filters)->paginate(intval($request->limit) ?? 10);
        return OilCoolantResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date'      => 'required|date_format:Y-m-d',
            'user'      => 'required|exists:users,id',
            'unit'      => 'required|exists:units,id',
            'product'   => 'required|exists:products,id',
            'amount'    => 'required|numeric|gte:0',
            'type'      => 'required|in:service,levelling',
            'desc'      => 'nullable|max:200',
        ]);
        $oil = OilCoolant::create([
            'date'          => $request->date,
            'user_id'       => $request->user,
            'unit_id'       => $request->unit,
            'product_id'    => $request->product,
            'amount'        => $request->amount,
            'type'          => $request->type,
            'desc'          => $request->desc,
        ]);
        return $this->response('Sukses Tambah Data!', new OilCoolantResource($oil), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(OilCoolant $oil)
    {
        return new OilCoolantResource($oil->load(['user', 'product', 'unit']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OilCoolant $oil)
    {
        $this->validate($request, [
            'date'      => 'required|date_format:Y-m-d',
            'user'      => 'required|exists:users,id',
            'unit'      => 'required|exists:units,id',
            'product'   => 'required|exists:products,id',
            'amount'    => 'required|numeric|gte:0',
            'type'      => 'required|in:service,levelling',
            'desc'      => 'nullable|max:200',
        ]);
        $oil->update([
            'date'          => $request->date,
            'user_id'       => $request->user,
            'unit_id'       => $request->unit,
            'product_id'    => $request->product,
            'amount'        => $request->amount,
            'type'          => $request->type,
            'desc'          => $request->desc,
        ]);
        return $this->response('Sukses Ubah Data!', new OilCoolantResource($oil), 200);
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
