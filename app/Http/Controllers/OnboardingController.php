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
}
