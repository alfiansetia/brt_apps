<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'message'   => '',
            'data'      => new UserResource($user)
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100'
        ]);
        $user = $request->user();
        $user->update([
            'name' => $request->name,
        ]);
        return $this->response('Success Update Profile!', new UserResource($user));
    }

    public function password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return $this->response('Success Update Password!', new UserResource($user));
    }
}
