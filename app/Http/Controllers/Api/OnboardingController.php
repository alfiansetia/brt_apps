<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cbm;
use App\Models\Dmcr;
use App\Models\Hmkm;
use App\Models\Logbook;
use App\Models\OilCoolant;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['pool_id']);
        $data['hmkm'] = Hmkm::filter($filters)->count();
        $data['logbook'] = Logbook::filter($filters)->count();
        $data['oil'] = OilCoolant::filter($filters)->count();
        $data['cbm'] = Cbm::filter($filters)->count();
        $data['dmcr'] = Dmcr::filter($filters)->count();
        return response()->json(['data' => $data]);
    }
}
