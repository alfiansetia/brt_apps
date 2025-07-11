<?php

namespace App\Http\Controllers;

use App\Models\OneScania;
use Illuminate\Http\Request;

class OneScaniaController extends Controller
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
        return view('pages.one_scania.index');
    }
}
