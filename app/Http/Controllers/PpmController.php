<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PpmController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.ppm.index');
    }
}
