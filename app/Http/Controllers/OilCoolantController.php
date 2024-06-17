<?php

namespace App\Http\Controllers;

use App\Models\OilCoolant;
use Illuminate\Http\Request;

class OilCoolantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.oil.index');
    }
}
