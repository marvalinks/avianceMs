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

class AcceptanceModuleController extends Controller
{

    protected $cargoKey = 'RoPgFWG3Pv2ymLF19VyHuGVfUnluDo3x';
    // protected $cargoKey = 'iNNa2ZZDikD7IYLrfvyfqVd5en5vN5cN';
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
        // dd($request->all());
        $data = $request->validate([
            'prefix' => 'required', 'serial' => 'required', 'originCode' => 'required',
            'destinationCode' => 'required', 'pieces' => 'required', 'natureOfGoods' => '', 'weight' => 'required',
            'volume' => '', 'specialHandlingCodes' => '', 'securityStatus' => '', 'x-ray' => '', 'remarks' => '',
            'blockedForManifesting' => '', 'aviance_agent' => 'required', 'aviance_security' => 'required',
            'shipper_agent' => 'required', 'uld_option' => 'required', 'flight_no' => 'required'
        ]);
        // ddd($data);

        $data['author_name'] = session()->get('user')['name'];
        $data['author_id'] = session()->get('user')['id'];

        // dd($data);

        if (floatval($data['weight']) == floatval(0)) {
            $request->session()->flash('alert-danger', 'Incorrect weight scale readings..');
            return back();
        }

        $url = $this->routePath.'/acceptance-request';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->post($url, $data);

        if($response->json()['success']['passed'] == 0) {
            $request->session()->flash('alert-danger', 'Error submitting request...');
            return back();
        }

        $request->session()->flash('alert-success', 'Acceptance form data successfully processed');
        return back();

        $tranx = json_decode($response, true);
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

        // $url = 'http://localhost:8001/api/v1/acceptance/details/'.$id;
        // dd($url);
        $url = $this->routePath.'/acceptance/details/'.$id;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->get($url);

        if($response->json()['success']['passed'] == 0) {
            $request->session()->flash('alert-danger', 'Error loading acceptance request...');
            return back();
        }

        $bill = $response->json()['success']['bill'];


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

        return $pdf->inline();
        // return view('backend.pages.pdfs.airwaybill');
    }

    public function export(Request $request)
    {
        dd('io');
        // return Excel::download(new AirbillExport, 'records.xlsx');
        // $pdf = SnappyPdf::loadView('pages.pdfs.payment', []);
    }
}
