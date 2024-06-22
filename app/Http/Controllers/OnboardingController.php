<?php

namespace App\Http\Controllers;

use App\Models\Cbm;
use App\Models\Hmkm;
use App\Models\Logbook;
use App\Models\OilCoolant;
use App\Models\Pool;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index()
    {
        $data = Pool::all();
        $datas['hmkm'] = Hmkm::count();
        $datas['logbook'] = Logbook::count();
        $datas['oil'] = OilCoolant::count();
        $datas['cbm'] = Cbm::count();
        return view('pages.onboarding', compact('data', 'datas'));
    }

    public function menu(Request $request)
    {
        $pool = Pool::find($request->pool);
        if (!$pool) {
            return redirect()->route('onboarding.index')->with('error', 'Silahkan Pilih Pool!');
        }
        $pool_id = $pool->id;
        $datas['hmkm'] = Hmkm::whereRelation('unit', 'pool_id', $pool_id)->count();
        $datas['oil'] = OilCoolant::whereRelation('unit', 'pool_id', $pool_id)->count();
        $datas['cbm'] = Cbm::whereRelation('unit', 'pool_id', $pool_id)->count();
        return view('pages.onboarding_menu', compact('pool', 'datas'));
    }
}
