<?php

namespace App\Http\Controllers;

use App\Exports\OilCoolantExport;
use App\Models\Pool;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class OilCoolantController extends Controller
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
        return view('pages.oil.index', compact('pool'));
    }

    public function export(Request $request)
    {
        $this->validate($request, [
            'from'      => 'required|date_format:Y-m-d',
            'to'        => 'required|date_format:Y-m-d',
            'pool_id'   => 'required|exists:pools,id',
        ]);
        $filters = $request->only(['from', 'to', 'pool_id']);
        $name = 'export_oilcoolant_' . $request->from . '_' . $request->to;
        return Excel::download(new OilCoolantExport($filters), $name . '.xls', ExcelExcel::XLS);
    }
}
