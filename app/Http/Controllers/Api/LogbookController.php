<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LogbookResource;
use App\Models\Logbook;
use App\Models\LogbookManpower;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class LogbookController extends Controller
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
        $filters = $request->only(['unit_id', 'component_id', 'pool_id', 'date']);
        $query = Logbook::query()->with(['unit', 'component', 'man_powers.user'])->filter($filters);
        return DataTables::eloquent($query)->filterColumn('date', function ($query, $keyword) {
            try {
                $date = Carbon::createFromFormat('d/m/Y', $keyword)->format('Y-m-d');
                $query->whereDate('date', $date);
            } catch (\Exception $e) {
                // 
            }
        })->setTransformer(function ($item) {
            return LogbookResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['name']);
        $data = Logbook::query()->with(['unit', 'component', 'man_powers.user'])->filter($filters)->paginate(intval($request->limit) ?? 10);
        return LogbookResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date'      => 'required|date_format:d/m/Y',
            'unit'      => 'required|exists:units,id',
            'component' => 'required|exists:components,id',
            'location'  => 'nullable|max:200',
            'pre'       => 'required|date_format:H:i:s',
            'start'     => 'required|date_format:H:i:s',
            'finish'    => 'required|date_format:H:i:s',
            'problem'   => 'nullable|max:200',
            'action'    => 'nullable|max:200',
            'status'    => 'required|in:pending,TKA,BA02',
            'desc'      => 'nullable|max:200',
            'users'     => 'nullable|array',
            'users.*'   => 'exists:users,id',
            'km_rfu'    => 'required|integer|gte:0',
            'respon'    => 'required|in:UT,TJ,MB',
        ]);
        $logbook = Logbook::create([
            'date'          => $request->date,
            'unit_id'       => $request->unit,
            'component_id'  => $request->component,
            'location'      => $request->location,
            'pre'           => $request->pre,
            'start'         => $request->start,
            'finish'        => $request->finish,
            'problem'       => $request->problem,
            'action'        => $request->action,
            'status'        => $request->status,
            'desc'          => $request->desc,
            'km_rfu'        => $request->km_rfu,
            'respon'        => $request->respon,
        ]);

        $manpowersData = [];
        foreach ($request->users ?? [] as $userId) {
            $manpowersData[] = new LogbookManpower([
                'user_id' => $userId,
            ]);
        }
        $logbook->man_powers()->saveMany($manpowersData);

        return $this->response('Sukses Tambah Data!', new LogbookResource($logbook), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Logbook $logbook)
    {
        return new LogbookResource($logbook->load(['unit', 'component', 'man_powers.user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Logbook $logbook)
    {
        $this->validate($request, [
            'date'      => 'required|date_format:d/m/Y',
            'unit'      => 'required|exists:units,id',
            'component' => 'required|exists:components,id',
            'location'  => 'nullable|max:200',
            'pre'       => 'required|date_format:H:i:s',
            'start'     => 'required|date_format:H:i:s',
            'finish'    => 'required|date_format:H:i:s',
            'problem'   => 'nullable|max:200',
            'action'    => 'nullable|max:200',
            'status'    => 'required|in:pending,TKA,BA02',
            'desc'      => 'nullable|max:200',
            'users'     => 'nullable|array',
            'users.*'   => 'distinct|exists:users,id',
            'km_rfu'    => 'required|integer|gte:0',
            'respon'    => 'required|in:UT,TJ,MB',
        ]);

        $logbook->update([
            'date'          => $request->date,
            'unit_id'       => $request->unit,
            'component_id'  => $request->component,
            'location'      => $request->location,
            'pre'           => $request->pre,
            'start'         => $request->start,
            'finish'        => $request->finish,
            'problem'       => $request->problem,
            'action'        => $request->action,
            'status'        => $request->status,
            'desc'          => $request->desc,
            'km_rfu'        => $request->km_rfu,
            'respon'        => $request->respon,
        ]);

        foreach ($logbook->man_powers ?? [] as $item) {
            $item->delete();
        }

        $manpowersData = [];
        foreach ($request->users ?? [] as $userId) {
            $manpowersData[] = new LogbookManpower([
                'user_id' => $userId,
            ]);
        }

        $logbook->man_powers()->saveMany($manpowersData);
        return $this->response('Sukses Ubah Data!', new LogbookResource($logbook), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logbook $logbook)
    {
        $logbook->delete();
        return $this->response('Sukses Hapus Data!', new LogbookResource($logbook), 200);
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:hmkms,id',
        ]);
        $ids = $request->id;
        $deleted = Logbook::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->response($message, $deleted);
    }

    public function truncate()
    {
        Schema::disableForeignKeyConstraints();
        $man_powers =  LogbookManpower::truncate();
        $deleted =  Logbook::truncate();
        Schema::enableForeignKeyConstraints();
        $message = 'Success Delete All Data !';
        return $this->response($message, $deleted);
    }
}
