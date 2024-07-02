<?php

namespace App\Http\Controllers;

use App\Exports\HmkmExport;
use App\Models\Pool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class HmkmController extends Controller
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
        return view('pages.hmkm.index', compact('pool'));
    }

    public function export(Request $request)
    {
        $this->validate($request, [
            'from'  => 'required|date_format:Y-m-d',
            'to'    => 'required|date_format:Y-m-d',
            'pool_id' => 'required|exists:pools,id',
        ]);
        $filters = $request->only(['from', 'to', 'pool_id']);
        $name = 'export_hmkm_' . $request->from . '_' . $request->to;
        return Excel::download(new HmkmExport($filters), $name . '.xls', ExcelExcel::XLS);
    }
}
