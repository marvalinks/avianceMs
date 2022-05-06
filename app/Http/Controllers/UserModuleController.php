<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserModuleController extends Controller
{

    protected $routePath = "http://159.223.238.21/api/v1";

    public function index(Request $request)
    {
        $url = $this->routePath.'/users';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->get($url);

        $users = $response->json()['success']['users']['data'];
        return view('backend.pages.users.index', compact('users'));
    }
    public function create(Request $request)
    {
        return view('backend.pages.users.add');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required', 'email' => 'required',
            'telephone' => '', 'role' => 'required', 'staffid' => '',
            'active' => 'required', 'password' => 'required'
        ]);

        $url = $this->routePath.'/users/store';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->post($url, $data);

        // dd($response->json());

        if($response->json()['success']['passed'] == 0) {
            $request->session()->flash('alert-danger', 'Error processing');
            return back();
        }

        $request->session()->flash('alert-success', 'User Successfully created');
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
            'active' => 'required', 'password' => ''
        ]);
        $data['userid'] = $user->id;

        $url = $this->routePath.'/users/update';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->post($url, $data);

        // dd($response->json());

        if($response->json()['success']['passed'] == 0) {
            $request->session()->flash('alert-danger', 'Error processing');
            return back();
        }
        $request->session()->flash('alert-success', 'User Successfully updated');
        return redirect()->route('backend.users.list');
    }
}
