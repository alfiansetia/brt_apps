<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
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
        $query = Service::query()->with(['unit', 'pool', 'items'])->filter($filters);
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
            return ServiceResource::make($item)->resolve();
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
        $service = Service::create([
            'type'      => $request->type,
            'date'      => $request->date,
            'unit_id'   => $request->unit,
            'pool_id'   => $request->pool_id,
            'km'        => $request->km,
            'last_date' => $request->last_date,
            'last_km'   => $request->last_km,
        ]);
        return $this->response('Sukses Tambah Data!', new ServiceResource($service), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return new ServiceResource($service->load(['unit', 'pool', 'items']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $this->validate($request, [
            'type'      => 'required|in:S,M,L',
            'date'      => 'required|date_format:d/m/Y',
            'unit'      => 'required|exists:units,id',
            'km'        => 'required|integer|gte:0',
            'last_date' => 'required|date_format:d/m/Y',
            'last_km'   => 'required|integer|gte:0',
        ]);
        $service->update([
            'type'      => $request->type,
            'date'      => $request->date,
            'unit_id'   => $request->unit,
            'km'        => $request->km,
            'last_date' => $request->last_date,
            'last_km'   => $request->last_km,
        ]);
        return $this->response('Sukses Ubah Data!', new ServiceResource($service), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service = $service->load('items');
        $items = $service->items;
        foreach ($items as $item) {
            $img = $item->getRawOriginal('image');
            $destinationPath = public_path('/assets/img/service/');
            if (!empty($img) && file_exists($destinationPath . $img)) {
                File::delete($destinationPath . $img);
            }
            $item->delete();
        }
        $service->delete();
        return $this->response('Sukses Hapus Data!', new ServiceResource($service), 200);
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:services,id',
        ]);
        $ids = $request->id;
        $deleted = Service::with('items')->whereIn('id', $ids)->get();
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
