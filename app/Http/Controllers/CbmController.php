<?php

namespace App\Http\Controllers;

use App\Models\Cbm;
use Illuminate\Http\Request;

class CbmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.cbm.index');
    }
}
