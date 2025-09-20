<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartResource;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class PartController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin'])->only(['destroy', 'destroyBatch']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['pool_id', 'type', 'unit_id']);
        $query = Part::query()->with(['unit', 'pool', 'items'])->filter($filters);
        return DataTables::eloquent($query)->filterColumn('date', function ($query, $keyword) {
            try {
                $date = Carbon::createFromFormat('d/m/Y', $keyword)->format('Y-m-d');
                $query->whereDate('date', $date);
            } catch (\Exception $e) {
                // 
            }
        })->filterColumn('last_date', function ($query, $keyword) {
            try {
                $date = Carbon::createFromFormat('d/m/Y', $keyword)->format('Y-m-d');
                $query->whereDate('last_date', $date);
            } catch (\Exception $e) {
                // 
            }
        })->filterColumn('unit_id', function ($query, $keyword) {
            $query->whereRelation('unit', 'code', 'like', "%$keyword%");
        })->setTransformer(function ($item) {
            return PartResource::make($item)->resolve();
        })->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type'      => 'required|in:S,M,L',
            'pool_id'   => 'required|exists:pools,id',
            'date'      => 'required|date_format:d/m/Y',
            'unit'      => 'required|exists:units,id',
            'km'        => 'required|integer|gte:0',
            'last_date' => 'required|date_format:d/m/Y',
            'last_km'   => 'required|integer|gte:0',
        ]);
        $part = Part::create([
            'type'      => $request->type,
            'date'      => $request->date,
            'unit_id'   => $request->unit,
            'pool_id'   => $request->pool_id,
            'km'        => $request->km,
            'last_date' => $request->last_date,
            'last_km'   => $request->last_km,
        ]);
        return $this->response('Sukses Tambah Data!', new PartResource($part), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Part $part)
    {
        return new PartResource($part->load(['unit', 'pool', 'items']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Part $part)
    {
        $this->validate($request, [
            'type'      => 'required|in:S,M,L',
            'date'      => 'required|date_format:d/m/Y',
            'unit'      => 'required|exists:units,id',
            'km'        => 'required|integer|gte:0',
            'last_date' => 'required|date_format:d/m/Y',
            'last_km'   => 'required|integer|gte:0',
        ]);
        $part->update([
            'type'      => $request->type,
            'date'      => $request->date,
            'unit_id'   => $request->unit,
            'km'        => $request->km,
            'last_date' => $request->last_date,
            'last_km'   => $request->last_km,
        ]);
        return $this->response('Sukses Ubah Data!', new PartResource($part), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Part $part)
    {
        $part = $part->load('items');
        $items = $part->items;
        foreach ($items as $item) {
            $img = $item->getRawOriginal('image');
            $destinationPath = public_path('/assets/img/service/');
            if (!empty($img) && file_exists($destinationPath . $img)) {
                File::delete($destinationPath . $img);
            }
            $item->delete();
        }
        $part->delete();
        return $this->response('Sukses Hapus Data!', new PartResource($part), 200);
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:oil_coolants,id',
        ]);
        $ids = $request->id;
        $deleted = Part::with('items')->whereIn('id', $ids)->get();
        foreach ($deleted as $items) {
            foreach ($items->items as $item) {
                $img = $item->getRawOriginal('image');
                $destinationPath = public_path('/assets/img/service/');
                if (!empty($img) && file_exists($destinationPath . $img)) {
                    File::delete($destinationPath . $img);
                }
                $item->delete();
            }
            $items->delete();
        }
        $message = 'Success Delete Data!';
        return $this->response($message, $deleted);
    }
}
