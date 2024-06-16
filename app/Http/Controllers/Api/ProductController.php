<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['name', 'code', 'category_id', 'type']);
        $query = Product::query()->with('category')->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return ProductResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['name', 'code', 'category_id', 'type']);
        $data = Product::query()->with('category')->filter($filters)->paginate(intval($request->limit) ?? 10);
        return ProductResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category'  => 'required|exists:categories,id',
            'name'      => 'required|max:200',
            'code'      => 'required|unique:products,code',
            'type'      => 'required|in:oil,coolant,other',
            'desc'      => 'nullable|max:200',
        ]);
        $product = Product::create([
            'category_id'   => $request->category,
            'name'          => $request->name,
            'code'          => $request->code,
            'type'          => $request->type,
            'desc'          => $request->desc,
        ]);
        return $this->response('Sukses Tambah Data!', new ProductResource($product), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product->load('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'category'  => 'required|exists:categories,id',
            'name'      => 'required|max:200',
            'code'      => 'required|unique:products,code',
            'type'      => 'required|in:oil,coolant,other',
            'desc'      => 'nullable|max:200',
        ]);
        $product->update([
            'category_id'   => $request->category,
            'name'          => $request->name,
            'code'          => $request->code,
            'type'          => $request->type,
            'desc'          => $request->desc,
        ]);
        return $this->response('Sukses Ubah Data!', new ProductResource($product), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->response('Sukses Hapus Data!', new ProductResource($product), 200);
    }
}