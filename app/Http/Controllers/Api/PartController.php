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
        $filters = $request->only(['pool_id', 'unit_id']);
        $query = Part::query()->with(['unit', 'pool', 'new_parts', 'old_parts'])->filter($filters);
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
            'pool_id'       => 'required|exists:pools,id',
            'unit'          => 'required|exists:units,id',
            'unit_detail'   => 'required|max:100',
            'sn'            => 'required|max:100',
            'hm'            => 'required|integer|gte:0',
            'km'            => 'required|integer|gte:0',
            'start_date'    => 'required|date_format:d/m/Y',
            'finish_date'   => 'required|date_format:d/m/Y',
        ]);
        $part = Part::create([
            'pool_id'       => $request->pool_id,
            'unit_id'       => $request->unit,
            'unit_detail'   => $request->unit_detail,
            'sn'            => $request->sn,
            'hm'            => $request->hm,
            'km'            => $request->km,
            'start_date'    => $request->start_date,
            'finish_date'   => $request->finish_date,
        ]);
        return $this->response('Sukses Tambah Data!', new PartResource($part), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Part $part)
    {
        return new PartResource($part->load(['unit', 'pool', 'new_parts', 'old_parts']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Part $part)
    {
        $this->validate($request, [
            'unit'          => 'required|exists:units,id',
            'unit_detail'   => 'required|max:100',
            'sn'            => 'required|max:100',
            'hm'            => 'required|integer|gte:0',
            'km'            => 'required|integer|gte:0',
            'start_date'    => 'required|date_format:d/m/Y',
            'finish_date'   => 'required|date_format:d/m/Y',
        ]);
        $part->update([
            'unit_id'       => $request->unit,
            'unit_detail'   => $request->unit_detail,
            'sn'            => $request->sn,
            'hm'            => $request->hm,
            'km'            => $request->km,
            'start_date'    => $request->start_date,
            'finish_date'   => $request->finish_date,
        ]);
        return $this->response('Sukses Ubah Data!', new PartResource($part), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Part $part)
    {
        $part = $part->load('all_parts');
        $items = $part->all_parts;
        foreach ($items as $item) {
            $img = $item->getRawOriginal('image');
            $destinationPath = public_path('/assets/img/part/');
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
            'id.*'      => 'integer|exists:parts,id',
        ]);
        $ids = $request->id;
        $deleted = Part::with('all_parts')->whereIn('id', $ids)->get();
        foreach ($deleted as $items) {
            foreach ($items->items as $item) {
                $img = $item->getRawOriginal('image');
                $destinationPath = public_path('/assets/img/part/');
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
