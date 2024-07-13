<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use Illuminate\Http\Request;

class SpeedController extends Controller
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
        return view('pages.speed.index', compact('pool'));
    }
}
