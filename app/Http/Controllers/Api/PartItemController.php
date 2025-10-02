<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartItemResource;
use App\Models\Part;
use App\Models\PartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class PartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['part_id', 'type']);
        $query = PartItem::query()->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return PartItemResource::make($item)->resolve();
        })->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'part'          => 'required|exists:parts,id',
            'type'          => 'required|in:new,old',
            'image'         => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);
        $part = PartItem::query()->where('part_id', $request->part)
            ->where('type', $request->type)->count();
        if ($part >= 8) {
            return response()->json(['message' => 'Image Part ' . ($request->type == 'new' ? 'BARU' : 'BEKAS') . ' Tidak boleh lebih dari 8!'], 403);
        }
        $img = null;
        if ($files = $request->file('image')) {
            $destinationPath = storage_path('/app/public/img/part/');
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 755, true);
            }
            $img = 'part_' . $request->service . '_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $img);
        }
        $part_item = PartItem::create([
            'part_id'   => $request->part,
            'type'      => $request->type,
            'image'     => $img,
        ]);
        return $this->response('Sukses Tambah Data!', new PartItemResource($part_item), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PartItem $part_item)
    {
        $img = $part_item->getRawOriginal('image');
        $destinationPath = storage_path('/app/public/img/part/');
        if (!empty($img) && file_exists($destinationPath . $img)) {
            File::delete($destinationPath . $img);
        }
        $part_item->delete();
        return $this->response('Sukses Hapus Data!', new PartItemResource($part_item), 200);
    }
}
