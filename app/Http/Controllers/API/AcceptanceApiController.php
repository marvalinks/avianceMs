<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AcceptancePool;
use App\Models\Airline;
use App\Models\ConfigurationModule;
use App\Models\HandlingCode;
use App\Models\WeightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AcceptanceApiController extends Controller
{
    public $successStatus = 200;


    // protected $cargoKey = 'iNNa2ZZDikD7IYLrfvyfqVd5en5vN5cN';
    protected $cargoKey = 'RoPgFWG3Pv2ymLF19VyHuGVfUnluDo3x';
    protected $stationCode = 'ACC';
    protected $routePath = "http://159.223.238.21/api/v1";
    // protected $routePath = "http://localhost:9000/api/v1";
    public $configurations;

    public function __construct()
    {
        $configurations = ConfigurationModule::first();
        if(!$configurations) {
            $success['passed'] =  0;
            return response()->json(['success' => $success], $this->successStatus);
        }
        $this->configurations = $configurations;
    }
    public function configurations()
    {
        $configurations = ConfigurationModule::first();
        if(!$configurations) {
            $success['passed'] =  0;
            return response()->json(['success' => $success], $this->successStatus);
        }else{
            $success['passed'] =  1;
            $success['configurations'] = $configurations;
        }
        return response()->json(['success' => $success], $this->successStatus);
    }


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

    public function index(Request $request)
    {
        $bills = AcceptancePool::latest()->paginate(250);

        $success['passed'] =  1;
        $success['bills'] =  $bills;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function getRequirements(Request $request)
    {
        $code = $this->stationCode;
        $handling_codes = HandlingCode::latest()->get();
        $airlines = Airline::latest()->get();

        $success['passed'] =  1;
        $success['acc_code'] =  $code;
        $success['handling_codes'] =  $handling_codes;
        $success['airlines'] =  $airlines;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function acceptanceRequest(Request $request)
    {

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $data = $request->all();

        // $success['passed'] =  1;
        // $success['data'] =  $data;
        // return response()->json(['success' => $success], $this->successStatus);

        $SecKey = $this->cargoKey;
        $airwayBill = $data['prefix'] . '-' . $data['serial'];
        

        $bb = array(
            "airWaybill" => [
                "prefix" => $data['prefix'],
                "serial" => $data['serial'],
                "originCode" => $this->configurations->stationCode,
                "destinationCode" => $data['destinationCode'],
                "pieces" => intval($data['pieces']),
                "weight" => [
                    "amount" => intval($data['weight']),
                    "unit" => "KG"
                ],
                "natureOfGoods" => $data['natureOfGoods'] ?? null
            ],
            "part" => [
                "pieces" => intval($data['pieces']),
                "weight" => [
                    "amount" => intval($data['weight']),
                    "unit" => "KG"
                ],
                "volume" => [
                    "amount" => intval($data['volume']),
                    "unit" => "MC"
                ],
                "specialHandlingCodes" => $data['specialHandlingCodes'],
                "securityStatus" => $data['securityStatus'],
                "x-ray" => intval($data['x-ray']) == 1 ? true : false,
                "remarks" => $data['remarks'],
                "blockedForManifesting" => intval($data['blockedForManifesting']) == 1 ? true : false
            ]
        );

        $curl = curl_init();


        $reqURL = "https://api-gateway-dev.champ.aero/csp/acceptance/v1/airwaybills/acceptance-requests";
        // $reqURL = $this->configurations->apiPath."/acceptance-requests";

        curl_setopt_array($curl, array(
            CURLOPT_URL => $reqURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($bb),
            CURLOPT_HTTPHEADER => [
                'Apikey: ' . $this->cargoKey,
                'Stationcode: ' . $this->stationCode,
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($err) {
            die('Curl returned error: ' . $err);
        }

        // dd($response, $httpcode);



        if ($httpcode == 422) {
            $success['passed'] =  0;
            return response()->json(['success' => $success], $this->successStatus);
        }
        if ($httpcode == 201) {
            // $this->getAirwayBill($airwayBill, $data['author_name'], $data['author_id']);
            $bill = AcceptancePool::create([
                'airWaybill' =>  $airwayBill,
                'pieces' =>  intval($data['pieces']),
                'weight' =>  intval($data['weight']),
                'volume' =>  intval($data['volume']),
                'origin' =>  $this->stationCode,
                'destination' =>  $data['destinationCode'],
                'statusCode' =>  "200",
                'author_name' =>  $data['author_name'],
                'author_id' =>  $data['author_id'],
                'shipper_agent' =>  $data['shipper_agent'],
                'aviance_security' =>  $data['aviance_security'],
                'aviance_agent' =>  $data['aviance_agent']
            ]);

            $success['passed'] =  1;
            return response()->json(['success' => $success], $this->successStatus);
        }

        $success['passed'] =  0;
        return response()->json(['success' => $success], $this->successStatus);
    }

    protected function getAirwayBill($bill,$name, $id)
    {
        $curl = curl_init();
        $reqURL = "https://api-gateway-dev.champ.aero/csp/acceptance/v1/airwaybills";
        // $reqURL = $this->configurations->apiPath;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $reqURL . '/' . $bill,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => [],
            CURLOPT_HTTPHEADER => [
                'Apikey: ' . $this->configurations->apiKey,
                'Stationcode: ' . $this->stationCode,
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $dataResponse = json_decode($response);

        if ($err) {
            die('Curl returned error: ' . $err);
        }

        if ($httpcode == 422) {
            die('Global error processing request');
        }

        if ($httpcode == 200) {
            $aib = AcceptancePool::where('airWaybill', $dataResponse->airWaybill->prefix . '-' . $dataResponse->airWaybill->serial)->first();

            if (!$aib) {
                $bill = AcceptancePool::create([
                    'airWaybill' =>  $dataResponse->airWaybill->prefix . '-' . $dataResponse->airWaybill->serial,
                    'pieces' =>  $dataResponse->airWaybill->pieces,
                    'weight' =>  $dataResponse->airWaybill->weight->amount,
                    'volume' =>  $dataResponse->airWaybill->volume->amount,
                    'origin' =>  $dataResponse->airWaybill->origin->code,
                    'destination' =>  $dataResponse->airWaybill->destination->code,
                    'statusCode' =>  $dataResponse->parts[0]->statusCode,
                    'author_name' =>  $name,
                    'author_id' =>  $id
                ]);
            }
        }
    }
}
