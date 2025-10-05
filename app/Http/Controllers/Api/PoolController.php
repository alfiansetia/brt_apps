<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PoolResource;
use App\Models\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class PoolController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin'])->only(['destroy', 'store', 'update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['name']);
        $query = Pool::query()->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return PoolResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['name']);
        $data = Pool::query()->filter($filters)->latest('id')->paginate(intval($request->limit) ?? 10);
        return PoolResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:200',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ]);
        $img = null;
        if ($files = $request->file('image')) {
            $destinationPath = storage_path('/app/public/img/pool/');
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 755, true);
            }
            $img = 'pool_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
            // $files->move($destinationPath, $img);
            $image = scaleDown($files);
            $image->save($destinationPath . $img, 80);
        }
        $pool = Pool::create([
            'name'  => $request->name,
            'image' => $img,
        ]);
        return $this->response('Sukses Tambah Data!', new PoolResource($pool), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pool $pool)
    {
        return new PoolResource($pool);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pool $pool)
    {
        $this->validate($request, [
            'name'      => 'required|max:200',
            'image'     => 'required|max:200',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ]);
        $img = $pool->getRawOriginal('image');
        if ($files = $request->file('image')) {
            $destinationPath = storage_path('/app/public/img/pool/');
            if (!empty($img) && file_exists($destinationPath . $img)) {
                File::delete($destinationPath . $img);
            }
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 755, true);
            }
            $img = 'pool_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
            // $files->move($destinationPath, $img);
            $image = scaleDown($files);
            $image->save($destinationPath . $img, 80);
        }
        $pool->update([
            'name'      => $request->name,
            'image'     => $img,
        ]);
        return $this->response('Sukses Ubah Data!', new PoolResource($pool), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pool $pool)
    {
        $img = $pool->getRawOriginal('image');
        $destinationPath = storage_path('/app/public/img/pool/');
        if (!empty($img) && file_exists($destinationPath . $img)) {
            File::delete($destinationPath . $img);
        }
        $pool->delete();
        return $this->response('Sukses Hapus Data!', new PoolResource($pool), 200);
    }
}
