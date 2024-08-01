<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DmcrItemResource;
use App\Models\DmcrItem;
use App\Models\DmcrItemManpower;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DmcrItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['dmcr_id', 'desc']);
        $query = DmcrItem::query()->with(['dmcr', 'component', 'man_powers.user'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return DmcrItemResource::make($item)->resolve();
        })->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'dmcr'          => 'required|exists:dmcrs,id',
            'component'     => 'required|exists:components,id',
            'desc'          => 'required|max:200',
            'action'        => 'required|max:200',
            'users'         => 'nullable|array',
            'users.*'       => 'exists:users,id',
            'part_number'   => 'nullable|max:200',
            'part_name'     => 'nullable|max:200',
            'part_qty'      => 'integer|gte:0',
        ]);
        $dmcr_item = DmcrItem::create([
            'dmcr_id'       => $request->dmcr,
            'component_id'  => $request->component,
            'desc'          => $request->desc,
            'action'        => $request->action,
            'part_number'   => $request->part_number,
            'part_name'     => $request->part_name,
            'part_qty'      => $request->part_qty,
        ]);

        $manpowersData = [];
        foreach ($request->users ?? [] as $userId) {
            $manpowersData[] = new DmcrItemManpower([
                'dmcr_item_id'  => $dmcr_item->id,
                'user_id'       => $userId,
            ]);
        }
        $dmcr_item->man_powers()->saveMany($manpowersData);

        return $this->response('Sukses Tambah Data!', new DmcrItemResource($dmcr_item), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(DmcrItem $dmcr_item)
    {
        return new DmcrItemResource($dmcr_item->load(['dmcr', 'component', 'man_powers.user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DmcrItem $dmcr_item)
    {
        $this->validate($request, [
            'component'     => 'required|exists:components,id',
            'desc'          => 'nullable|max:200',
            'action'        => 'nullable|max:200',
            'users'         => 'nullable|array',
            'users.*'       => 'exists:users,id',
            'part_number'   => 'nullable|max:200',
            'part_name'     => 'nullable|max:200',
            'part_qty'      => 'integer|gte:0',
        ]);
        $dmcr_item->update([
            'component_id'  => $request->component,
            'desc'          => $request->desc,
            'action'        => $request->action,
            'part_number'   => $request->part_number,
            'part_name'     => $request->part_name,
            'part_qty'      => $request->part_qty,
        ]);
        foreach ($dmcr_item->man_powers ?? [] as $item) {
            $item->delete();
        }

        $manpowersData = [];
        foreach ($request->users ?? [] as $userId) {
            $manpowersData[] = new DmcrItemManpower([
                'dmcr_item_id'  => $dmcr_item->id,
                'user_id'       => $userId,
            ]);
        }
        $dmcr_item->man_powers()->saveMany($manpowersData);
        return $this->response('Sukses Ubah Data!', new DmcrItemResource($dmcr_item), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DmcrItem $dmcr_item)
    {
        $dmcr_item->delete();
        return $this->response('Sukses Hapus Data!', new DmcrItemResource($dmcr_item), 200);
    }
}
