<?php

namespace App\Http\Controllers;

use App\Models\Signee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SigneeController extends Controller
{

    protected $routePath = "http://159.223.238.21/api/v1";
    
    public function create(Request $request)
    {
        return view('backend.pages.signees.add');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required', 'passcode' => 'required',
            'signature' => '', 
        ]);

        $url = $this->routePath.'/signees/store';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->post($url, $data);

        // dd($response->json());

        if($response->json()['success']['passed'] == 0) {
            $request->session()->flash('alert-danger', 'Error processing');
            return back();
        }

        $request->session()->flash('alert-success', 'Signee Successfully created');
        return back();
    }
    public function index(Request $request)
    {
        $url = $this->routePath.'/signees';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->get($url);

        $users = $response->json()['success']['users']['data'];
        return view('backend.pages.signees.index', compact('users'));
    }
    public function edit(Request $request, $id)
    {
        $user = Signee::where('userid', $id)->first();
        return view('backend.pages.signees.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = Signee::where('userid', $id)->first();
        $data = $request->validate([
            'name' => 'required', 'passcode' => 'required',
            'signature' => '', 
        ]);
        $data['userid'] = $user->userid;

        $url = $this->routePath.'/signees/update';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->post($url, $data);

        // dd($response->json());

        if($response->json()['success']['passed'] == 0) {
            $request->session()->flash('alert-danger', 'Error processing');
            return back();
        }
        $request->session()->flash('alert-success', 'Signee Successfully updated');
        return redirect()->route('backend.signees.list');
    }

}
