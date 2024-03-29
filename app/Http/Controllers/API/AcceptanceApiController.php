<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AcceptancePool;
use App\Models\Airline;
use App\Models\ConfigurationModule;
use App\Models\HandlingCode;
use App\Models\WeightLog;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AcceptanceApiController extends Controller
{
    public $successStatus = 200;


    protected $cargoKey = 'iNNa2ZZDikD7IYLrfvyfqVd5en5vN5cN';
    // protected $cargoKey = 'RoPgFWG3Pv2ymLF19VyHuGVfUnluDo3x';
    protected $stationCode = 'ACC';
    protected $routePath = "http://159.223.238.21/api/v1";
    // protected $routePath = "http://localhost:9000/api/v1";
    public $configurations;

    public function __construct()
    {
        // $configurations = ConfigurationModule::first();
        // if(!$configurations) {
        //     $success['passed'] =  0;
        //     return response()->json(['success' => $success], $this->successStatus);
        // }
        // $this->configurations = $configurations;
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
        $bills = AcceptancePool::where('is_signed', 1)->latest()->paginate(250);

        $success['passed'] =  1;
        $success['bills'] =  $bills;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function pendingJobs(Request $request)
    {
        $bills = AcceptancePool::where('is_signed', 0)->latest()->paginate(250);

        $success['passed'] =  1;
        $success['bills'] =  $bills;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function openJobs(Request $request, $id)
    {
        $bill = AcceptancePool::where('airWaybill', $id)->first();

        $success['passed'] =  1;
        $success['bill'] =  $bill;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function acceptanceDetails(Request $request, $id)
    {
        $bill = AcceptancePool::with(['shipper', 'agent', 'security'])->where('airWaybill', $id)->first();

        if(!$bill) {
            $success['passed'] =  0;
            return response()->json(['success' => $success], $this->successStatus);
        }

        $success['passed'] =  1;
        $success['bill'] =  $bill;
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

        $code = \Illuminate\Support\Str::random(5);
        

        $bb = array(
            "airWaybill" => [
                "prefix" => $data['prefix'],
                "serial" => $data['serial'],
                "originCode" => $this->stationCode,
                "destinationCode" => strtoupper($data['destinationCode']),
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


        // $reqURL = "https://api-gateway-dev.champ.aero/csp/acceptance/v1/airwaybills/acceptance-requests";
        $reqURL = "https://api-gateway.champ.aero/csp/acceptance/v1/airwaybills/acceptance-requests";
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
                // 'shipper_agent' =>  $data['shipper_agent'] ?? null,
                // 'aviance_security' =>  $data['aviance_security'] ?? null,
                // 'aviance_agent' =>  $data['aviance_agent'] ?? null,
                'flight_no' => $data['flight_no'],
                'uld_option' =>  $data['uld_option'] ?? null,
                'code' => $code
                // 'uld_number' =>  $data['uld_number'] ?? null,
            ]);
            // if($bill) {
            //     $bill2 = AcceptancePool::with(['shipper', 'agent', 'security'])->where('airWaybill', $airwayBill)->first();
            //     $pdf = SnappyPdf::loadView('backend.pages.pdfs.airwaybill', ['bill' => $bill2]);

            //     $orientation = 'portrait';
            //     $paper = 'A4';
            //     $pdf->setOrientation($orientation)
            //     ->setOption('page-size', $paper)
            //     ->setOption('margin-bottom', '0mm')
            //     ->setOption('margin-top', '8.7mm')
            //     ->setOption('margin-right', '0mm')
            //     ->setOption('margin-left', '0mm')
            //     ->setOption('enable-javascript', true)
            //     ->setOption('no-stop-slow-scripts', true)
            //     ->setOption('enable-smart-shrinking', true)
            //     ->setOption('javascript-delay', 1000)
            //     ->setTimeout(120);

            //     $name = mt_rand(10000, 9999999999999);
            //     $pdf->save(storage_path('pdfs/'.$name.'.pdf'));
                
            //     $doc = storage_path('pdfs/' . $name. '.pdf');
            //     $file = new UploadedFile($doc, 'file');
            //     $dfd = Storage::disk('do')->put('pdfs', $file, 'public');

            //     $bill2->pdf_path = env('DO_URL').'/'.$dfd;
            //     $bill2->save();
            // }

            $success['passed'] =  1;
            $success['code'] =  $code;
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

    public function generatePDF(Request $request, $id)
    {

        // $url = 'http://localhost:8001/api/v1/acceptance/details/'.$id;
        // dd($url);
        $url = $this->routePath.'/acceptance/details/'.$id;
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     'X-Requested-With' => 'XMLHttpRequest'
        // ])->get($url);

        // dd($response->json());
        // $bill = $response->json()['success']['bill'];

        $bill = AcceptancePool::where('airWaybill', $id)->first();

        // $aa = SnappyPdf::loadHTML('<h1>hello</h1>');
        // return $aa->download('airway.pdf');
        // dd($bill);

        $pdf = SnappyPdf::loadView('backend.pages.pdfs.airwaybill', ['bill' => $bill]);

        $orientation = 'portrait';
        $paper = 'A4';
        $pdf->setOrientation($orientation)
        ->setOption('page-size', $paper)
        ->setOption('margin-bottom', '0mm')
        ->setOption('margin-top', '8.7mm')
        ->setOption('margin-right', '0mm')
        ->setOption('margin-left', '0mm')
        ->setOption('enable-javascript', true)
        ->setOption('no-stop-slow-scripts', true)
        ->setOption('enable-smart-shrinking', true)
        ->setOption('javascript-delay', 1000)
        ->setTimeout(120);

        $name = mt_rand(10000, 9999999999999);
        $pdf->save(storage_path('pdfs/'.$name.'.pdf'));
        
        $doc = storage_path('pdfs/' . $name. '.pdf');
        $file = new UploadedFile($doc, 'file');
        // dd($file);
        $dfd = Storage::disk('do')->put('pdfs', $file, 'public');

        $bill->pdf_path = env('DO_URL').'/'.$dfd;
        $bill->save();

        $success['passed'] =  1;
        $success['path'] =  env('DO_URL').'/'.$dfd;
        return response()->json(['success' => $success], $this->successStatus);
        
        // return $pdf->download('airway.pdf');
    }
}
