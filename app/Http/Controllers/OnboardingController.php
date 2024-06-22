<?php

namespace App\Http\Controllers;

use App\Models\Cbm;
use App\Models\Dmcr;
use App\Models\Hmkm;
use App\Models\Keluhan;
use App\Models\OilCoolant;
use App\Models\Pool;
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
        return view('pages.onboarding_menu', compact('pool', 'datas'));
    }
}
