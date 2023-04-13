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
        // $url = $this->routePath.'/users';
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     'X-Requested-With' => 'XMLHttpRequest'
        // ])->get($url);

        // $users = $response->json()['success']['users']['data'];
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
            'name' => 'required', 'email' => '',
            'telephone' => '', 'role' => 'required', 'staffid' => '',
            'active' => 'required', 'password' => 'required', 'username' => 'required'
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
        $url = $this->routePath.'/users/find/'.$id;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->get($url);
        $user = $response->json()['success']['user'];
        // dd($user);
        return view('backend.pages.users.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $url2 = $this->routePath.'/users/find/'.$id;
        $response2 = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->get($url2);
        $user = $response2->json()['success']['user'];
        $data = $request->validate([
            'name' => 'required', 'email' => '',
            'telephone' => '', 'role' => 'required', 'staffid' => '',
            'active' => 'required', 'password' => '', 'username' => 'required'
        ]);
        $data['userid'] = $user['userid'];

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
