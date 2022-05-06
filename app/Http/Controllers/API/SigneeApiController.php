<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Signee;
use App\Models\User;
use App\Models\WeightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SigneeApiController extends Controller
{
    public $successStatus = 200;

    


    public function loginUser(Request $request)
    {
        $data = $request->validate([
            'email' => 'required', 'password' => 'required',
        ]);
        $user = User::where('email', $data['email'])->first();
        if(!$user) {
            $success['passed'] =  0;
            $success['message'] =  "User not found!";
            return response()->json(['success' => $success], $this->successStatus);
        }
        if (!Hash::check($data['password'], $user->password)) {
            $success['passed'] =  0;
            $success['message'] =  "Authentication error!";
            return response()->json(['success' => $success], $this->successStatus);
        }
        // $user->makeHidden(['id', 'roleid', 'departmentid', 'active']);
        $success['passed'] =  1;
        $success['user'] =  $user;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function store(Request $request)
    {

        $data = [
            'passcode' => $request->passcode,
            'name' => $request->name
        ];

        
        
        $data['userid'] = explode('-', strtoupper((string) Str::uuid()))[mt_rand(0, 3)];

        $user = Signee::create($data);

        $success['passed'] =  1;
        $success['user'] =  $user;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function index(Request $request)
    {
        $users = Signee::latest()->paginate(50);
        $success['passed'] =  1;
        $success['users'] =  $users;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function update(Request $request)
    {
        $user = Signee::where('userid', $request->userid)->first();
        $data = [
            'passcode' => $request->passcode,
            'name' => $request->name
        ];

        $user->update($data);

        $success['passed'] =  1;
        $success['user'] =  $user;
        return response()->json(['success' => $success], $this->successStatus);
    }
}
