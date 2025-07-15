<?php

namespace App\Http\Controllers;

use App\Models\OneScania;
use Illuminate\Http\Request;

class OneScaniaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->role == 'user') {
            return view('pages.one_scania.index_user',);
        }
        return view('pages.one_scania.index');
    }
}
