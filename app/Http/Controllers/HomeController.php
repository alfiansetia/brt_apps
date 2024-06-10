<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['jumlah'] = 1;
        $data['nilai'] = 1;
        $data['terpakai'] = 1;
        $data['tidak_terpakai'] = 1;
        $data['baik'] = 1;
        $data['rusak'] = 1;
        return view('home', compact('data'));
    }
}
