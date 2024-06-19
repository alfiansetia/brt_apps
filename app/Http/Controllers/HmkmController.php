<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HmkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.hmkm.index');
    }
}
