<?php

namespace App\Http\Controllers;

use App\Exports\PpmDataExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class PpmDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.ppm_data.index');
    }

    public function export(Request $request)
    {
        $this->validate($request, [
            'from'      => 'required|date_format:Y-m-d',
            'to'        => 'required|date_format:Y-m-d',
        ]);
        $filters = $request->only(['from', 'to']);
        $name = 'export_ppmdata_' . $request->from . '_' . $request->to;
        return Excel::download(new PpmDataExport($filters), $name . '.xls', ExcelExcel::XLS);
    }
}
