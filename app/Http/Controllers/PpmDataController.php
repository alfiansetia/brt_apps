<?php

namespace App\Http\Controllers;

use App\Exports\PpmDataExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

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
            'from'      => 'required|date_format:d/m/Y',
            'to'        => 'required|date_format:d/m/Y',
        ]);
        $filters = $request->only(['from', 'to']);
        $name = Str::slug('export_ppmdata_' . $request->from . '_' . $request->to);
        return Excel::download(new PpmDataExport($filters), $name . '.xls', ExcelExcel::XLS);
    }
}
