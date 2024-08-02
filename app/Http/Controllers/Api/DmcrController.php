<?php

namespace App\Http\Controllers\Api;

use App\Exports\DmcrExport;
use App\Exports\DmcrItemExport;
use App\Exports\NewDmcrExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\DmcrResource;
use App\Models\Dmcr;
use App\Models\DmcrManpower;
use App\Models\Pool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class DmcrController extends Controller
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
        $filters = $request->only(['pool_id', 'date']);
        $query = Dmcr::query()->with(['unit'])->filter($filters);
        return DataTables::eloquent($query)->filterColumn('date', function ($query, $keyword) {
            try {
                $date = Carbon::createFromFormat('d/m/Y', $keyword)->format('Y-m-d');
                $query->whereDate('date', $date);
            } catch (\Exception $e) {
                // 
            }
        })->filterColumn('unit_id', function ($query, $keyword) {
            $query->whereRelation('unit', 'code', 'like', "%$keyword%");
        })->setTransformer(function ($item) {
            return DmcrResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['pool_id']);
        $data = Dmcr::query()->with(['unit'])->filter($filters)->paginate(intval($request->limit) ?? 10);
        return DmcrResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'unit'          => 'required|exists:units,id',
            'pool_id'       => 'required|exists:pools,id',
            // 'component'     => 'required|exists:components,id',
            'type'          => 'required|in:schedule,unschedule',
            'shift'         => 'required|in:day,night',
            'date'          => 'required|date_format:d/m/Y',
            'start'         => 'required|date_format:d/m/Y H:i',
            'finish'        => 'required|date_format:d/m/Y H:i',
            // 'desc'          => 'nullable|max:200',
            // 'action'        => 'nullable|max:200',
            // 'users'         => 'nullable|array',
            // 'users.*'       => 'exists:users,id',
            // 'part_number'   => 'nullable|max:200',
            // 'part_name'     => 'nullable|max:200',
            // 'part_qty'      => 'integer|gte:0',
        ]);
        $dmcr = Dmcr::create([
            'unit_id'       => $request->unit,
            'pool_id'       => $request->pool_id,
            // 'component_id'  => $request->component,
            'shift'         => $request->shift,
            'type'          => $request->type,
            'date'          => $request->date,
            'start'         => $request->start,
            'finish'        => $request->finish,
            // 'desc'          => $request->desc,
            // 'action'        => $request->action,
            // 'part_number'   => $request->part_number,
            // 'part_name'     => $request->part_name,
            // 'part_qty'      => $request->part_qty,
        ]);

        // $manpowersData = [];
        // foreach ($request->users ?? [] as $userId) {
        //     $manpowersData[] = new DmcrManpower([
        //         'user_id' => $userId,
        //     ]);
        // }
        // $dmcr->man_powers()->saveMany($manpowersData);

        return $this->response('Sukses Tambah Data!', new DmcrResource($dmcr), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dmcr $dmcr)
    {
        return new DmcrResource($dmcr->load(['unit', 'items.component', 'items.man_powers.user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dmcr $dmcr)
    {
        $this->validate($request, [
            'unit'          => 'required|exists:units,id',
            // 'component'     => 'required|exists:components,id',
            'type'          => 'required|in:schedule,unschedule',
            'shift'         => 'required|in:day,night',
            'date'          => 'required|date_format:d/m/Y',
            'start'         => 'required|date_format:d/m/Y H:i',
            'finish'        => 'required|date_format:d/m/Y H:i',
            // 'desc'          => 'nullable|max:200',
            // 'action'        => 'nullable|max:200',
            // 'users'         => 'nullable|array',
            // 'users.*'       => 'exists:users,id',
            // 'part_number'   => 'nullable|max:200',
            // 'part_name'     => 'nullable|max:200',
            // 'part_qty'      => 'integer|gte:0',
        ]);
        $dmcr->update([
            'unit_id'       => $request->unit,
            // 'component_id'  => $request->component,
            'shift'         => $request->shift,
            'type'          => $request->type,
            'date'          => $request->date,
            'start'         => $request->start,
            'finish'        => $request->finish,
            // 'desc'          => $request->desc,
            // 'action'        => $request->action,
            // 'part_number'   => $request->part_number,
            // 'part_name'     => $request->part_name,
            // 'part_qty'      => $request->part_qty,
        ]);
        // foreach ($dmcr->man_powers ?? [] as $item) {
        //     $item->delete();
        // }

        // $manpowersData = [];
        // foreach ($request->users ?? [] as $userId) {
        //     $manpowersData[] = new DmcrManpower([
        //         'user_id' => $userId,
        //     ]);
        // }

        // $dmcr->man_powers()->saveMany($manpowersData);

        return $this->response('Sukses Ubah Data!', new DmcrResource($dmcr), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dmcr $dmcr)
    {
        $dmcr->delete();
        return $this->response('Sukses Hapus Data!', new DmcrResource($dmcr), 200);
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:dmcrs,id',
        ]);
        $ids = $request->id;
        $deleted = Dmcr::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->response($message, $deleted);
    }

    public function truncate(Request $request)
    {
        $this->validate($request, [
            'pool_id'   => 'required|exists:pools,id',
        ]);
        $pool = Pool::find($request->pool_id);
        $deleted =  Dmcr::where('pool_id', $pool->id)->delete();
        $message = 'Success Delete All Data On Pool ' . $pool->name;
        return $this->response($message, $deleted);
    }

    public function export(Request $request)
    {
        $this->validate($request, [
            'from'      => 'required|date_format:d/m/Y',
            'to'        => 'required|date_format:d/m/Y',
            'pool_id'   => 'required|exists:pools,id',
        ]);
        $filters = $request->only(['from', 'to', 'pool_id']);
        $name = Str::slug('export_dmcr_' . $request->from . '_' .  $request->to);
        $data = Dmcr::with(['items.man_powers.user', 'items.component', 'unit'])->filter($filters)->get();
        // return response()->json($data);
        $result = [];
        foreach ($data as $item) {
            if (count($item->items ?? []) < 1) {
                $result[] = [
                    'date'          => $item->date,
                    'shift'         => $item->shift,
                    'unit'          => $item->unit,
                    'type'          => $item->type,
                    'start'         => $item->start,
                    'finish'        => $item->finish,
                    'desc'          => null,
                    'action'        => null,
                    'component'     => null,
                    'part_number'   => null,
                    'part_name'     => null,
                    'part_qty'      => null,
                    'man_powers'    => [],
                ];
            } else {
                foreach ($item->items as $newitem) {
                    $result[] = [
                        'date'          => $item->date,
                        'shift'         => $item->shift,
                        'unit'          => $item->unit,
                        'type'          => $item->type,
                        'start'         => $item->start,
                        'finish'        => $item->finish,
                        'desc'          => $newitem->desc,
                        'action'        => $newitem->action,
                        'component'     => $newitem->component,
                        'part_number'   => $newitem->part_number,
                        'part_name'     => $newitem->part_name,
                        'part_qty'      => $newitem->part_qty,
                        'man_powers'    => $newitem->man_powers,
                    ];
                }
            }
        }
        // return response()->json($data);
        return Excel::download(new NewDmcrExport($result), $name . '.xls', ExcelExcel::XLS);
        // return Excel::download(new DmcrItemExport($filters), $name . '.xls', ExcelExcel::XLS);
    }
}
