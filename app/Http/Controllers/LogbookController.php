<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('pages.logbook.index', compact('users'));
    }
}
