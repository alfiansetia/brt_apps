<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpeedResource;
use App\Models\Speed;
use App\Models\SpeedItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SpeedController extends Controller
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
        $filters = $request->only(['date', 'pool_id']);
        $query = Speed::query()->with('items.unit')->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return SpeedResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['date', 'pool_id']);
        $data = Speed::query()->with('items.unit')->filter($filters)->paginate(intval($request->limit) ?? 10);
        return SpeedResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                // 'date'      => 'required|date_format:d/m/Y|unique:speeds,date',
                'date'      => 'required|date_format:d/m/Y',
                'units'     => 'array',
                'values'    => 'array',
                'units.*'   => 'exists:units,id|distinct',
                'values.*'  => 'integer|gte:0',
            ]
        );
        $speed = Speed::create([
            'date'      => $request->date,
        ]);
        foreach ($request->units ?? [] as $item) {
            $speeditem = SpeedItem::create([
                'speed_id'  => $speed->id,
                'unit_id'   => $item,
                'value'     => $request->values[$item],
            ]);
        }
        return $this->response('Sukses Tambah Data!', new SpeedResource($speed), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Speed $speed)
    {
        return new SpeedResource($speed->load('items.unit.pool'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Speed $speed)
    {
        $this->validate(
            $request,
            [
                // 'date'      => 'required|date_format:d/m/Y|unique:speeds,date,' . $speed->id,
                'date'      => 'required|date_format:d/m/Y',
                'units'     => 'array',
                'values'    => 'array',
                'units.*'   => 'exists:units,id',
                'values.*'  => 'integer|gte:0',
            ]
        );
        $speed->update([
            'date'      => $request->date,
        ]);
        foreach ($speed->items  as $item) {
            $item->delete();
        }
        foreach ($request->units ?? [] as $item) {
            $speeditem = SpeedItem::create([
                'speed_id'  => $speed->id,
                'unit_id'   => $item,
                'value'     => $request->values[$item],
            ]);
        }
        return $this->response('Sukses Ubah Data!', new SpeedResource($speed), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Speed $speed)
    {
        $speed->delete();
        return $this->response('Sukses Hapus Data!', new SpeedResource($speed), 200);
    }
}
