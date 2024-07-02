<?php

namespace App\Http\Controllers;

use App\Exports\DmcrExport;
use App\Models\Dmcr;
use App\Models\Pool;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class DmcrController extends Controller
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
        return view('pages.dmcr.index', compact('pool'));
    }

    public function export(Request $request)
    {
        $this->validate($request, [
            'from'      => 'required|date_format:Y-m-d',
            'to'        => 'required|date_format:Y-m-d',
            'pool_id'   => 'required|exists:pools,id',
        ]);
        $filters = $request->only(['from', 'to', 'pool_id']);
        $name = 'export_dmcr_' . $request->from . '_' . $request->to;
        return Excel::download(new DmcrExport($filters), $name . '.xls', ExcelExcel::XLS);
    }
}
