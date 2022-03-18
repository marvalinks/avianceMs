<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserModuleController extends Controller
{

    public function index(Request $request)
    {
        $users = User::latest()->paginate(50);
        return view('backend.pages.users.index', compact('users'));
    }
    public function create(Request $request)
    {
        return view('backend.pages.users.add');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required', 'email' => 'required|unique:users',
            'telephone' => '', 'role' => 'required', 'staffid' => '',
            'active' => 'required', 'password' => 'required'
        ]);

        if (intval($data['role']) == intval(1)) {
            $data['designation'] = 'ADMIN';
        }
        if (intval($data['role']) == intval(2)) {
            $data['designation'] = 'STAFF';
        }
        $data['roleid'] = $data['role'];
        $data['password'] = Hash::make($data['password']);
        unset($data['role']);

        User::create($data);
        $request->flash('alert-success', 'User Successfully created');
        return back();
    }
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('backend.pages.users.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'name' => 'required', 'email' => 'required',
            'telephone' => '', 'role' => 'required', 'staffid' => '',
            'active' => 'required'
        ]);

        if (intval($data['role']) == intval(1)) {
            $data['designation'] = 'ADMIN';
        }
        if (intval($data['role']) == intval(2)) {
            $data['designation'] = 'STAFF';
        }
        $data['roleid'] = $data['role'];
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        unset($data['role']);

        $user->update($data);
        $request->flash('alert-success', 'User Successfully updated');
        return redirect()->route('backend.users.list');
    }
}
