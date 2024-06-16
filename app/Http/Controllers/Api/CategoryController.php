<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['name']);
        $query = Category::query()->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return CategoryResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['name']);
        $data = Category::query()->filter($filters)->paginate(intval($request->limit) ?? 10);
        return CategoryResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:200',
            'desc'      => 'nullable|max:200',
        ]);
        $category = Category::create([
            'name'          => $request->name,
            'desc'          => $request->desc,
        ]);
        return $this->response('Sukses Tambah Data!', new CategoryResource($category), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name'      => 'required|max:200',
            'desc'      => 'nullable|max:200',
        ]);
        $category->update([
            'name'          => $request->name,
            'desc'          => $request->desc,
        ]);
        return $this->response('Sukses Ubah Data!', new CategoryResource($category), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->response('Sukses Hapus Data!', new CategoryResource($category), 200);
    }
}
