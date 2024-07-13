<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use App\Models\User;
use Illuminate\Http\Request;

class DmcrController extends Controller
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
        $users = User::where('role', 'user')->get();
        return view('pages.dmcr.index', compact('pool', 'users'));
    }
}
