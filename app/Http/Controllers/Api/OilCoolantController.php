<?php

namespace App\Http\Controllers\Api;

use App\Exports\OilCoolantExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\OilCoolantResource;
use App\Models\OilCoolant;
use App\Models\Pool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class OilCoolantController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin'])->only(['destroy', 'destroyBatch', 'truncate']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['user_id', 'unit_id', 'product_id', 'type', 'pool_id', 'date']);
        $query = OilCoolant::query()->with(['user', 'product', 'unit'])->filter($filters);
        return DataTables::eloquent($query)->filterColumn('date', function ($query, $keyword) {
            try {
                $date = Carbon::createFromFormat('d/m/Y', $keyword)->format('Y-m-d');
                $query->whereDate('date', $date);
            } catch (\Exception $e) {
                // 
            }
        })->filterColumn('unit_id', function ($query, $keyword) {
            $query->whereRelation('unit', 'code', 'like', "%$keyword%");
        })->filterColumn('product_id', function ($query, $keyword) {
            $query->whereRelation('product', 'name', 'like', "%$keyword%");
        })->filterColumn('user_id', function ($query, $keyword) {
            $query->whereRelation('user', 'name', 'like', "%$keyword%");
        })->setTransformer(function ($item) {
            return OilCoolantResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['user_id', 'unit_id', 'product_id', 'type', 'pool_id']);
        $data = OilCoolant::query()->with(['user', 'product', 'unit'])->filter($filters)->paginate(intval($request->limit) ?? 10);
        return OilCoolantResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date'      => 'required|date_format:d/m/Y',
            'user'      => 'required|exists:users,id',
            'unit'      => 'required|exists:units,id',
            'pool_id'   => 'required|exists:pools,id',
            'product'   => 'required|exists:products,id',
            'amount'    => 'required|numeric|gte:0',
            'type'      => 'required|in:service,levelling',
            'desc'      => 'nullable|max:200',
        ]);
        $oil = OilCoolant::create([
            'date'          => $request->date,
            'user_id'       => $request->user,
            'unit_id'       => $request->unit,
            'pool_id'       => $request->pool_id,
            'product_id'    => $request->product,
            'amount'        => $request->amount,
            'type'          => $request->type,
            'desc'          => $request->desc,
        ]);
        return $this->response('Sukses Tambah Data!', new OilCoolantResource($oil), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(OilCoolant $oil)
    {
        return new OilCoolantResource($oil->load(['user', 'product', 'unit']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OilCoolant $oil)
    {
        $this->validate($request, [
            'date'      => 'required|date_format:d/m/Y',
            'user'      => 'required|exists:users,id',
            'unit'      => 'required|exists:units,id',
            'product'   => 'required|exists:products,id',
            'amount'    => 'required|numeric|gte:0',
            'type'      => 'required|in:service,levelling',
            'desc'      => 'nullable|max:200',
        ]);
        $oil->update([
            'date'          => $request->date,
            'user_id'       => $request->user,
            'unit_id'       => $request->unit,
            'product_id'    => $request->product,
            'amount'        => $request->amount,
            'type'          => $request->type,
            'desc'          => $request->desc,
        ]);
        return $this->response('Sukses Ubah Data!', new OilCoolantResource($oil), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OilCoolant $oil)
    {
        $oil->delete();
        return $this->response('Sukses Hapus Data!', new OilCoolantResource($oil), 200);
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:oil_coolants,id',
        ]);
        $ids = $request->id;
        $deleted = OilCoolant::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->response($message, $deleted);
    }

    public function truncate(Request $request)
    {
        $this->validate($request, [
            'pool_id'   => 'required|exists:pools,id',
        ]);
        $pool = Pool::find($request->pool_id);
        $deleted =  OilCoolant::where('pool_id', $pool->id)->delete();
        $message = 'Success Delete All Data On Pool ' . $pool->name;
        return $this->response($message, $deleted);
    }

    public function export(Request $request)
    {
        $this->validate($request, [
            'from'      => 'required|date_format:d/m/Y',
            'to'        => 'required|date_format:d/m/Y',
            'pool_id'   => 'required|exists:pools,id',
            'unit_id'   => 'nullable|exists:units,id',
        ]);
        $filters = $request->only(['from', 'to', 'pool_id']);
        $name = Str::slug('export_oilcoolant_' . $request->from . '_' . $request->to);
        return Excel::download(new OilCoolantExport($filters), $name . '.xls', ExcelExcel::XLS);
    }
}
