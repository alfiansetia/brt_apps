<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('pages.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required|max:100',
            'nrp'   => 'required|max:100',
        ]);
        $user = auth()->user();
        $user->update([
            'name'  => $request->name,
            'nrp'   => $request->nrp,
        ]);
        return redirect()->route('profile.index')->with('success', 'Success Update Profile');;
    }

    public function password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = auth()->user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('profile.index')->with('success', 'Success Update Password');
    }
}
