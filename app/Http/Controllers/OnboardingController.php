<?php

namespace App\Http\Controllers;

use App\Models\Cbm;
use App\Models\CbmProject;
use App\Models\Dmcr;
use App\Models\Hmkm;
use App\Models\Keluhan;
use App\Models\OilCoolant;
use App\Models\Part;
use App\Models\Pool;
use App\Models\Service;
use App\Models\Speed;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index()
    {
        $data = Pool::all();
        return view('pages.onboarding', compact('data'));
    }

    public function menu(Request $request)
    {
        $pool = Pool::find($request->pool);
        if (!$pool) {
            return redirect()->route('onboarding.index')->with('error', 'Silahkan Pilih Pool!');
        }
        $pool_id = $pool->id;
        $filters = ['pool_id' => $pool_id];
        $datas['hmkm'] = Hmkm::filter($filters)->count();
        $datas['oil'] = OilCoolant::filter($filters)->count();
        $datas['cbm'] = Cbm::filter($filters)->count();
        $datas['dmcr'] = Dmcr::filter($filters)->count();
        $datas['keluhan'] = Keluhan::filter($filters)->count();
        $datas['speed'] = Speed::filter($filters)->count();
        $datas['cbm_project'] = CbmProject::filter($filters)->count();
        $datas['service'] = Service::filter($filters)->count();
        $datas['parts'] = Part::filter($filters)->count();
        return view('pages.onboarding_menu', compact('pool', 'datas'));
    }

    // public function tes(Request $request)
    // {
    //     $filters =  $request->only(['pool_id']);
    //     $speeds = Speed::filter($filters)->with('items.unit')->orderBy('date', 'ASC')->get();
    //     $units = Unit::filter($filters)->get();
    //     return view('tes', compact('speeds', 'units'));
    // }

    public function tes(Request $request)
    {
        abort(404);
    }
}
