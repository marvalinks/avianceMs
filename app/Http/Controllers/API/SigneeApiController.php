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
            'name' => $request->name, 'signature' => $request->signature,
            'roleid' => $request->roleid, 'staff_no' => $request->staff_no
        ];
        
        if(intval($data['roleid']) == intval(1)) {
            $data['designation'] = 'Aviance Agent';
        }
        if(intval($data['roleid']) == intval(2)) {
            $data['designation'] = 'Aviance Security Agent';
        }
        if(intval($data['roleid']) == intval(3)) {
            $data['designation'] = 'Shipping Agent';
        }

        $data['userid'] = explode('-', strtoupper((string) Str::uuid()))[mt_rand(0, 3)];

        $user = Signee::create($data);

        $success['passed'] =  1;
        $success['user'] =  $user;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function index(Request $request)
    {
        $users = Signee::latest()->paginate(100);
        $success['passed'] =  1;
        $success['users'] =  $users;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function indexapi(Request $request)
    {
        $users = Signee::query();
        $aa = $users->where('roleid', 1)->latest()->paginate(100);
        $as = $users->where('roleid', 2)->latest()->paginate(100);
        $sa = $users->where('roleid', 3)->latest()->paginate(100);
        $success['passed'] =  1;
        $success['aa'] =  $aa;
        $success['as'] =  $as;
        $success['sa'] =  $sa;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function update(Request $request)
    {
        $user = Signee::where('userid', $request->userid)->first();
        $data = [
            'passcode' => $request->passcode,
            'name' => $request->name,
            'roleid' => $request->roleid, 'staff_no' => $request->roleid
        ];

        if($data['roleid'] == 1) {
            $data['designation'] = 'Aviance Agent';
        }
        if($data['roleid'] == 2) {
            $data['designation'] = 'Aviance Security Agent';
        }
        if($data['roleid'] == 3) {
            $data['designation'] = 'Shipping Agent';
        }

        $user->update($data);

        $success['passed'] =  1;
        $success['user'] =  $user;
        return response()->json(['success' => $success], $this->successStatus);
    }
}
