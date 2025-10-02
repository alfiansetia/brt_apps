<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OneScaniaResource;
use App\Imports\OneScaniaImport;
use App\Models\OneScania;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class OneScaniaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin'])->except(['index', 'paginate', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['name', 'unit', 'component', 'number']);
        $query = OneScania::query()->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return OneScaniaResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['name', 'unit', 'component', 'number']);
        $data = OneScania::query()->filter($filters)->paginate(intval($request->limit) ?? 10);
        return OneScaniaResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required|string|max:200',
            'unit'              => 'nullable|string|max:200',
            'component'         => 'nullable|string|max:200',
            'number'            => 'required|string|max:200',
            'satuan_map'        => 'required|string|max:100',
            'price_map'         => 'nullable|integer|gte:0',
            'satuan_vendor'     => 'required|string|max:100',
            'price_vendor'      => 'nullable|integer|gte:0',
            'vendor'            => 'nullable|string|max:200',
            'brand'             => 'nullable|string|max:200',
            'remark'            => 'nullable|string|max:200',
            'file'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);
        $file = null;
        if ($files = $request->file('file')) {
            $destinationPath = storage_path('/app/public/file/one_scania/');
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 755, true);
            }
            $file = 'one_scania_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
        }
        $one_scania = OneScania::create([
            'name'              => $request->name,
            'unit'              => $request->unit,
            'component'         => $request->component,
            'number'            => $request->number,
            'satuan_map'        => $request->satuan_map,
            'price_map'         => $request->price_map ?? 0,
            'satuan_vendor'     => $request->satuan_vendor,
            'price_vendor'      => $request->price_vendor ?? 0,
            'vendor'            => $request->vendor,
            'brand'             => $request->brand,
            'remark'            => $request->remark,
            'file'              => $file,
        ]);
        return $this->response('Sukses Tambah Data!', new OneScaniaResource($one_scania), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Onescania $one_scania)
    {
        return new OneScaniaResource($one_scania);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OneScania $one_scania)
    {
        // dd($one_scania);
        // return $this->response($request->all());
        $this->validate($request, [
            'name'              => 'required|string|max:200',
            'unit'              => 'nullable|string|max:200',
            'component'         => 'nullable|string|max:200',
            'number'            => 'required|string|max:200',
            'satuan_map'        => 'required|string|max:100',
            'price_map'         => 'nullable|integer|gte:0',
            'satuan_vendor'     => 'required|string|max:100',
            'price_vendor'      => 'nullable|integer|gte:0',
            'vendor'            => 'nullable|string|max:200',
            'brand'             => 'nullable|string|max:200',
            'remark'            => 'nullable|string|max:200',
            'file'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);
        $file = $one_scania->getRawOriginal('file');
        if ($files = $request->file('file')) {
            $destinationPath = storage_path('/app/public/file/one_scania/');
            if (!empty($file) && file_exists($destinationPath . $file)) {
                File::delete($destinationPath . $file);
            }
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 755, true);
            }
            $file = 'one_scania_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
        }
        $one_scania->update([
            'name'              => $request->name,
            'unit'              => $request->unit,
            'component'         => $request->component,
            'number'            => $request->number,
            'satuan_map'        => $request->satuan_map,
            'price_map'         => $request->price_map ?? 0,
            'satuan_vendor'     => $request->satuan_vendor,
            'price_vendor'      => $request->price_vendor ?? 0,
            'vendor'            => $request->vendor,
            'brand'             => $request->brand,
            'remark'            => $request->remark,
            'file'              => $file,
        ]);
        return $this->response('Sukses Ubah Data!', new OneScaniaResource($one_scania), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OneScania $one_scania)
    {
        $file = $one_scania->getRawOriginal('file');
        $destinationPath = storage_path('/app/public/file/ppm/');
        if (!empty($file) && file_exists($destinationPath . $file)) {
            File::delete($destinationPath . $file);
        }
        $one_scania->delete();
        return $this->response('Sukses Hapus Data!', new OneScaniaResource($one_scania), 200);
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:ppm_data,id',
        ]);
        $ids = $request->id;
        $deleted = OneScania::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->response($message, $deleted);
    }

    public function truncate()
    {
        $deleted =  OneScania::truncate();
        if (file_exists(storage_path('/app/public/file/one_scania/'))) {
            File::cleanDirectory(storage_path('/app/public/file/one_scania/'));
        }
        $message = 'Success Delete All Data !';
        return $this->response($message, $deleted);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);
        DB::beginTransaction();
        try {
            Excel::import(new OneScaniaImport, $request->file('file'));
            DB::commit();
            return $this->response('Data berhasil diimport!');
        } catch (ValidationException $e) {
            DB::rollBack();
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $messages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }

            return response()->json([
                'message' => 'Gagal import!, ' . implode(', ', $messages),
                'errors' => $messages,
            ], 422);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response('Gagal import: ' . $th->getMessage(), [], 500);
        }
    }
}
