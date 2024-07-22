<?php

namespace App\Http\Controllers;

use App\Models\CbmProject;
use App\Models\Dmcr;
use App\Models\Pool;
use Illuminate\Http\Request;

class CbmProjectController extends Controller
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
        $pns = Dmcr::filter(['pool_id', $pool->id])->whereNotNull('part_number')->get()->pluck('part_number')->unique();
        return view('pages.cbm_project.index', compact('pool', 'pns'));
    }
}
