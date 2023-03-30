<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackendController extends Controller
{

    public function dashboard(Request $request)
    {
        if(env('APP_ENV') == 'local'){

            $userSession = session()->get('user');
            if (!$userSession) {
                return redirect()->route('login');
            }
        }

        return redirect()->route('backend.acceptance.list');
    }
}
