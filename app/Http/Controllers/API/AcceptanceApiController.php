<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AcceptancePool;
use App\Models\Airline;
use App\Models\HandlingCode;
use App\Models\WeightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AcceptanceApiController extends Controller
{
    public $successStatus = 200;
    protected $cargoKey = 'RoPgFWG3Pv2ymLF19VyHuGVfUnluDo3x';
    protected $stationCode = 'ACC';


    public function postWeight(Request $request)
    {
        // $data = $request->validate([
        //     'uld_number' => 'required', 'station_code' => 'required', 'destination_code' => 'required',
        //     'carrier_code' => 'required', 'transport_number' => 'required', 'weight' => '', 'userid' => 'required'
        // ]);
        // $data['logid'] = explode('-', strtoupper((string) Str::uuid()))[mt_rand(0,2)];
        // $data['unit'] = 'KG';
        // $data['date'] = date('Y-m-d');
        // $data['weight'] = 3;

        // $log = WeightLog::create($data);

        $success['passed'] =  1;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function getRequirements(Request $request)
    {
        $code = $this->stationCode;
        $handling_codes = HandlingCode::latest()->pluck('code');
        $airlines = Airline::latest()->pluck('prefix');

        $success['passed'] =  1;
        $success['acc_code'] =  $code;
        $success['handling_codes'] =  $handling_codes;
        $success['airlines'] =  $airlines;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function acceptanceRequest(Request $request)
    {
        dd($request->all());
        $data = $request->validate([
            'airWaybill' => 'required', 'pieces' => 'required', 'weight' => 'required', 'volume' => 'required', 'origin' => 'required', 'destination' => 'required', 'statusCode' => 'required',
            'author_name' => 'required', 'author_id' => 'required'
        ]);
        AcceptancePool::create($data);
        $success['passed'] =  1;
        return response()->json(['success' => $success], $this->successStatus);
    }
}
