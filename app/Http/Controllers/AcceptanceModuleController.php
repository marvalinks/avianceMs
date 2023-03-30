<?php

namespace App\Http\Controllers;

use App\Models\AcceptancePool;
use App\Models\Airline;
use App\Models\ConfigurationModule;
use App\Models\HandlingCode;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AcceptanceModuleController extends Controller
{

    // protected $cargoKey = 'RoPgFWG3Pv2ymLF19VyHuGVfUnluDo3x';
    protected $cargoKey = 'iNNa2ZZDikD7IYLrfvyfqVd5en5vN5cN';
    protected $stationCode = 'ACC';
    protected $routePath = "http://159.223.238.21/api/v1";
    // protected $routePath = "http://localhost:9000/api/v1";
    public $configurations;

    public function fetchCongifurations()
    {
        $url = $this->routePath.'/configurations';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->get($url);

        // dd($response->json());
        
        
        if($response->json()['success']['passed'] == 0) {
            redirect()->route('backend.configurations.index')->send();
        }

        $configurations = $response->json()['success']['configurations'];
        $this->configurations = $configurations;
    }

    public function index(Request $request)
    {
        // $bills = AcceptancePool::latest()->paginate(250);
        $this->fetchCongifurations();
        $url = $this->routePath.'/acceptance';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->get($url);
        $bills = $response->json()['success']['bills']['data'];
        // dd($bills);
        return view('backend.pages.acceptance.index', compact('bills'));
    }
    public function show(Request $request, $id)
    {
        $bill = $this->getAirwayBill($id, false);
        return view('backend.pages.acceptance.details', compact('bill'));
    }

    public function create(Request $request)
    {

        $this->fetchCongifurations();

        $url = $this->routePath.'/requirements';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->get($url);


        // dd($response->json());
        $code = $response->json()['success']['acc_code'];
        $handling_codes = $response->json()['success']['handling_codes'];
        $airlines = $response->json()['success']['airlines'];

        return view('backend.pages.acceptance.forms', compact('code', 'handling_codes', 'airlines'));
    }

    public function edit(Request $request, $id)
    {
        $this->fetchCongifurations();
        $code = $this->stationCode;
        $acc = AcceptancePool::findOrFail($id);
        return view('backend.pages.acceptance.edit', compact('code', 'acc'));
    }

    public function submitForms(Request $request)
    {
        $this->fetchCongifurations();
        // dd(\Illuminate\Support\Str::random(5));
        // dd($request->all());
        $data = $request->validate([
            'prefix' => 'required', 'serial' => 'required', 'originCode' => 'required',
            'destinationCode' => 'required', 'pieces' => 'required', 'natureOfGoods' => '', 'weight' => 'required',
            'volume' => '', 'specialHandlingCodes' => '', 'securityStatus' => '', 'x-ray' => '', 'remarks' => '',
            'blockedForManifesting' => '', 'aviance_agent' => '', 'aviance_security' => '',
            'shipper_agent' => '', 'uld_option' => 'required', 'flight_no' => 'required', 'uld_number' => ''
        ]);
        
        $data['author_name'] = session()->get('user')['name'];
        $data['author_id'] = session()->get('user')['id'];
        // dd($data);

        // dd($data);
        // 071-89201843

        if (floatval($data['weight']) == floatval(0)) {
            $request->session()->flash('alert-danger', 'Incorrect weight scale readings..');
            return back();
        }

        // $this->acceptanceRequest($data);

        $url = $this->routePath.'/acceptance-request';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->post($url, $data);

        if($response->json()['success']['passed'] == 0) {
            $request->session()->flash('alert-danger', 'Error submitting request...');
            return back();
        }

        $tranx = json_decode($response, true);
        $request->session()->flash('alert-success', 'Acceptance form data successfully processed');
        return back();
    }

    public function acceptanceRequest($data)
    {

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // dd($data['prefix']);

        // $success['passed'] =  1;
        // $success['data'] =  $data;
        // return response()->json(['success' => $success], $this->successStatus);

        $SecKey = $this->cargoKey;
        $airwayBill = $data['prefix'] . '-' . $data['serial'];
        

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

        // dd($bb);

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

        dd($response, $httpcode);



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
                'shipper_agent' =>  $data['shipper_agent'] ?? null,
                'aviance_security' =>  $data['aviance_security'] ?? null,
                'aviance_agent' =>  $data['aviance_agent'] ?? null,
                'flight_no' => $data['flight_no'],
                'uld_option' =>  $data['uld_option'],
                'uld_number' =>  $data['uld_number'],
            ]);
            dd($bill);
        }

        $success['passed'] =  0;
        return response()->json(['success' => $success], $this->successStatus);
    }

    protected function getAirwayBill($bill, $persit)
    {
        $curl = curl_init();
        $reqURL = $this->configurations->apiPath;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $reqURL . '/' . $bill,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => [],
            CURLOPT_HTTPHEADER => [
                'Apikey: ' . $this->configurations->apiKey,
                'Stationcode: ' . $this->configurations->stationCode,
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $dataResponse = json_decode($response);

        // dd($dataResponse, $httpcode);

        if ($err) {
            die('Curl returned error: ' . $err);
        }

        if ($httpcode == 422) {
            die('Global error processing request');
        }

        if ($httpcode == 200 && !$persit) {
            return $dataResponse;
        }

        if ($httpcode == 200 && $persit) {
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
                    'author_name' =>  'test',
                    'author_id' =>  2
                ]);
            }
        }
    }

    public function generatePDF(Request $request, $id)
    {
        $url = $this->routePath.'/acceptance/details/'.$id;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->get($url);
    }

    public function generatePDF2(Request $request, $id)
    {

        // $url = 'http://localhost:8001/api/v1/acceptance/details/'.$id;
        // dd($url);
        $url = $this->routePath.'/acceptance/details/'.$id;
        $url2 = $this->routePath.'/acceptance/generatepdf/'.$id;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->get($url);
        
        if($response->json()['success']['passed'] == 0) {
            $request->session()->flash('alert-danger', 'Error loading acceptance request...');
            return back();
        }
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->get($url2);
        dd($response->json());
        return $response->json();

        // $bill = $response->json()['success']['bill'];


        // $pdf = SnappyPdf::loadView('backend.pages.pdfs.airwaybill', ['bill' => $bill]);

        // $orientation = 'portrait';
        // $paper = 'A4';
        // $pdf->setOrientation($orientation)
        // ->setOption('page-size', $paper)
        // ->setOption('margin-bottom', '0mm')
        // ->setOption('margin-top', '8.7mm')
        // ->setOption('margin-right', '0mm')
        // ->setOption('margin-left', '0mm')
        // ->setOption('enable-javascript', true)
        // ->setOption('no-stop-slow-scripts', true)
        // ->setOption('enable-smart-shrinking', true)
        // ->setOption('javascript-delay', 1000)
        // ->setTimeout(120);

        // return $pdf->inline();
        // return view('backend.pages.pdfs.airwaybill');
    }

    public function scale(Request $request) 
    {
        return view('backend.pages.acceptance.scale');
    }
    public function export(Request $request)
    {
        dd('io');
        // return Excel::download(new AirbillExport, 'records.xlsx');
        // $pdf = SnappyPdf::loadView('pages.pdfs.payment', []);
    }
    public function pendingJobs(Request $request)
    {
        // $this->fetchCongifurations();
        // $url = $this->routePath.'/pending-jobs';
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     'X-Requested-With' => 'XMLHttpRequest'
        // ])->get($url);
        // $bills = $response->json()['success']['bills']['data'];
        $bills = AcceptancePool::where('is_signed', 0)->latest()->paginate(250);
        return view('jobs.pending-jobs', compact('bills'));
        
    }
    public function openJobs(Request $request, $id)
    {
        // $this->fetchCongifurations();
        // $url = $this->routePath.'/open-jobs/'.$id;
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     'X-Requested-With' => 'XMLHttpRequest'
        // ])->get($url);
        // $bill = $response->json()['success']['bill'];

        $bill = AcceptancePool::where('airWaybill', $id)->first();


        if(!$bill) {
            return back();
        }
        
        return view('jobs.open-job', compact('bill'));
        
    }
    public function postOpenJobs(Request $request, $id)
    {
        $bill = AcceptancePool::where('airWaybill', $id)->first();


        if(!$bill) {
            return back();
        }

        $data = $request->validate([
            'shipper_agent' => 'required', 'shipper_agent_sign' => 'required',
            'aviance_security' => 'required', 'aviance_security_sign' => 'required',
            'aviance_agent' => 'required', 'aviance_agent_sign' => 'required'
        ]);

        $data['shipper_agent_sign'] = $this->createImageFromBase64('a',$request->shipper_agent_sign, 'av_cg_sig');
        $data['aviance_security_sign'] = $this->createImageFromBase64('b',$request->aviance_security_sign, 'av_cg_sig');
        $data['aviance_agent_sign'] = $this->createImageFromBase64('c',$request->aviance_agent_sign, 'av_cg_sig');
        $data['is_signed'] = 1;

        // dd($data);
        $bill->update($data);

        $request->session()->flash('alert-success', 'Signature Processed');
        return redirect()->route('pending.jobs');
    }

    public function createImageFromBase64($prix, $image_64, $route)
    {

        $file_name = $prix.'_image_'.time().'.png';
        $path = $route.'/'.$file_name;
        @list($type, $image_64) = explode(';', $image_64);
        @list(, $image_64)      = explode(',', $image_64);
        if($image_64!=""){
               // storing image in storage/app/public Folder
                //   Storage::disk('public')->put($route.'/' . $file_name,base64_decode($image_64));
            $storage = Storage::disk('do')->put($route.'/'.$file_name, base64_decode($image_64), 'public');
            return $path;

        }

    }
}
