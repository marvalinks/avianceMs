<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthenticationController extends Controller
{

    protected $routePath = "http://159.223.238.21/api/v1";


    public function login(Request $request)
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $data = $request->validate([
            'username' => 'required', 'password' => 'required'
        ]);

        $email = User::where('username', $data['username'])->first()->email;

        if(env('APP_ENV') == 'production'){
            if (Auth::attempt(['email' => $email, 'password' => $request->password])) {
                $request->session()->regenerate();
                return redirect()->route('backend.dashboard');
            }
    
            return redirect()->route('backend.dashboard');
        }

        
        $url = $this->routePath.'/login';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->post($url, [
            'username' => $data['username'],
            'password' => $data['password'],
        ]);
        if($response->json()['success']['passed'] == 0) {
            $request->session()->flash('alert-danger', 'Error logging in');
            return redirect()->route('login');
        }
        $user = $response->json()['success']['user'];

        $userSession = session()->get('user');

        // dd($userSession);

        // if($userSession) {
        //     session()->flush();
        // }
        
        session()->put('user', $user);

        // dd(session()->get('user'));
        // dd('$user');
        return redirect()->route('backend.dashboard');
    }

    public function logout(Request $request)
    {
        session()->flush();
        // Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
