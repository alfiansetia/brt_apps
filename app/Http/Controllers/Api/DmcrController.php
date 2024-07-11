<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DmcrResource;
use App\Models\Dmcr;
use App\Models\DmcrManpower;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DmcrController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['pool_id', 'date']);
        $query = Dmcr::query()->with(['unit', 'component', 'man_powers.user'])->filter($filters);
        return DataTables::eloquent($query)->filterColumn('date', function ($query, $keyword) {
            try {
                $date = Carbon::createFromFormat('d/m/Y', $keyword)->format('Y-m-d');
                $query->whereDate('date', $date);
            } catch (\Exception $e) {
                // 
            }
        })->setTransformer(function ($item) {
            return DmcrResource::make($item)->resolve();
        })->toJson();
    }

    public function paginate(Request $request)
    {
        $filters = $request->only(['pool_id']);
        $data = Dmcr::query()->with(['unit', 'component', 'man_powers.user'])->filter($filters)->paginate(intval($request->limit) ?? 10);
        return DmcrResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'unit'      => 'required|exists:units,id',
            'component' => 'required|exists:components,id',
            'type'      => 'required|in:schedule,unschedule',
            'shift'     => 'required|in:day,night',
            'date'      => 'required|date_format:d/m/Y',
            'start'     => 'required|date_format:d/m/Y H:i',
            'finish'    => 'required|date_format:d/m/Y H:i',
            'desc'      => 'nullable|max:200',
            'action'    => 'nullable|max:200',
            'users'     => 'nullable|array',
            'users.*'   => 'exists:users,id',
        ]);
        $dmcr = Dmcr::create([
            'unit_id'       => $request->unit,
            'component_id'  => $request->component,
            'shift'         => $request->shift,
            'type'          => $request->type,
            'date'          => $request->date,
            'start'         => $request->start,
            'finish'        => $request->finish,
            'desc'          => $request->desc,
            'action'        => $request->action,
        ]);

        $manpowersData = [];
        foreach ($request->users ?? [] as $userId) {
            $manpowersData[] = new DmcrManpower([
                'user_id' => $userId,
            ]);
        }
        $dmcr->man_powers()->saveMany($manpowersData);

        return $this->response('Sukses Tambah Data!', new DmcrResource($dmcr), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dmcr $dmcr)
    {
        return new DmcrResource($dmcr->load(['unit', 'component', 'man_powers.user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dmcr $dmcr)
    {
        $this->validate($request, [
            'unit'      => 'required|exists:units,id',
            'component' => 'required|exists:components,id',
            'type'      => 'required|in:schedule,unschedule',
            'shift'     => 'required|in:day,night',
            'date'      => 'required|date_format:d/m/Y',
            'start'     => 'required|date_format:d/m/Y H:i',
            'finish'    => 'required|date_format:d/m/Y H:i',
            'desc'      => 'nullable|max:200',
            'action'    => 'nullable|max:200',
            'users'     => 'nullable|array',
            'users.*'   => 'exists:users,id',
        ]);
        $dmcr->update([
            'unit_id'       => $request->unit,
            'component_id'  => $request->component,
            'shift'         => $request->shift,
            'type'          => $request->type,
            'date'          => $request->date,
            'start'         => $request->start,
            'finish'        => $request->finish,
            'desc'          => $request->desc,
            'action'        => $request->action,
        ]);
        foreach ($dmcr->man_powers ?? [] as $item) {
            $item->delete();
        }

        $manpowersData = [];
        foreach ($request->users ?? [] as $userId) {
            $manpowersData[] = new DmcrManpower([
                'user_id' => $userId,
            ]);
        }

        $dmcr->man_powers()->saveMany($manpowersData);

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
}
