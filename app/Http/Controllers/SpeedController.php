<?php

namespace App\Http\Controllers;

use App\Exports\SpeedExport;
use App\Models\Pool;
use App\Models\Speed;
use App\Models\Unit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class SpeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pool = Pool::find($request->pool);
        if (!$pool) {
            return redirect()->route('onboarding.index')->with('error', 'Silahkan Pilih Pool!');
        }
        return view('pages.speed.index', compact('pool'));
    }

    public function export(Request $request)
    {
        $this->validate($request, [
            'from'      => 'required|date_format:Y-m-d',
            'to'        => 'required|date_format:Y-m-d',
            'pool_id'   => 'required|exists:pools,id',
        ]);
        $filters = $request->only(['from', 'to', 'pool_id']);
        $units = Unit::filter($filters)->get();

        $results['column'] = ['Unit'];
        $results['row'] = [];

        $speeds = Speed::filter($filters)->with('items.unit')->orderBy('date', 'ASC')->get();
        $results['column'] = array_merge($results['column'], $speeds->pluck('date')->toArray());
        foreach ($units as $key => $unit) {
            $data = [];
            $data[] = $unit->code;
            foreach ($speeds  as $item) {
                $data[] = $item->items()->where('unit_id', $unit->id)->first()->value ?? 0;
            }
            $results['row'][$key] = $data;
        }
        $name = 'export_speeds_' . $request->from . '_' . $request->to;
        return Excel::download(new SpeedExport($results), $name . '.xls', ExcelExcel::XLS);
    }
}
