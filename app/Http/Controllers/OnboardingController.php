<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index()
    {
        $data = Pool::all();
        return view('pages.onboarding', compact('data'));
    }
}
