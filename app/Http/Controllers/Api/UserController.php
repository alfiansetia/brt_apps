<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['name', 'nrp']);
        $query = User::query()->with('pool')->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return UserResource::make($item)->resolve();
        })->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name'      => 'required',
                'email'     => 'required|unique:users,email',
                'role'      => 'required|in:user,admin',
                'password'  => 'required|min:5',
                'pool'      => 'required|exists:pools,id',
            ]
        );
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'pool_id'   => $request->pool,
        ]);
        return $this->response('Sukses Tambah Data!', new UserResource($user), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->response('', new UserResource($user->load('pool')), 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->validate(
            $request,
            [
                'name'      => 'required',
                'email'     => 'required|unique:users,email,' . $user->id,
                'role'      => 'required|in:user,admin',
                'password'  => 'nullable|min:5',
                'pool'      => 'required|exists:pools,id',
            ]
        );
        $param = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'pool_id'   => $request->pool,
        ];
        if ($request->filled('password')) {
            $param['password'] = Hash::make($request->password);
        }
        $user->update($param);
        return $this->response('Sukses Ubah Data!', new UserResource($user), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->response('Sukses Hapus Data!', new UserResource($user), 200);
    }
}
