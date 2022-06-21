<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WeightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserApiController extends Controller
{
    public $successStatus = 200;

    


    public function loginUser(Request $request)
    {
        $data = $request->validate([
            'username' => 'required', 'password' => 'required',
        ]);
        $user = User::where('username', $data['username'])->first();
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
            'password' => $request->password,
            'name' => $request->name, 'email' => $request->email ?? null, 'active' => $request->active,
            'telephone' => $request->telephone ?? null, 'staffid' => $request->staffid ?? null,
            'role' => $request->role, 'username' => $request->username
        ];

        
        if (intval($data['role']) == intval(1)) {
            $data['designation'] = 'ADMIN';
        }
        if (intval($data['role']) == intval(2)) {
            $data['designation'] = 'STAFF';
        }
        $data['roleid'] = $data['role'];
        $data['userid'] = explode('-', strtoupper((string) Str::uuid()))[mt_rand(0, 3)];
        $data['password'] = Hash::make($data['password']);
        unset($data['role']);

        $user = User::create($data);

        $success['passed'] =  1;
        $success['user'] =  $user;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function index(Request $request)
    {
        $users = User::latest()->paginate(50);
        $success['passed'] =  1;
        $success['users'] =  $users;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function update(Request $request)
    {
        $user = User::findOrFail($request->userid);
        $data = [
            'name' => $request->name, 'email' => $request->email ?? null, 'active' => $request->active,
            'telephone' => $request->telephone ?? null, 'staffid' => $request->staffid ?? null,
            'role' => $request->role, 'password' => $request->password, 'username' => $request->username
        ];

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

        $success['passed'] =  1;
        $success['user'] =  $user;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function findUser(Request $request, $id)
    {
        $user = User::where('userid', $id)->first();
        $success['passed'] =  1;
        $success['user'] =  $user;
        return response()->json(['success' => $success], $this->successStatus);
    }
}
