<?php

namespace App\Http\Controllers;

use App\Models\AcceptancePool;
use App\Models\Airline;
use App\Models\HandlingCode;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AcceptanceModuleController extends Controller
{

    protected $cargoKey = 'RoPgFWG3Pv2ymLF19VyHuGVfUnluDo3x';
    protected $stationCode = 'ACC';

    public function index(Request $request)
    {
        $bills = AcceptancePool::latest()->paginate(250);
        return view('backend.pages.acceptance.index', compact('bills'));
    }
    public function show(Request $request, $id)
    {
        $bill = $this->getAirwayBill($id, false);
        return view('backend.pages.acceptance.details', compact('bill'));
    }

    public function create(Request $request)
    {
        $code = $this->stationCode;
        $handling_codes = HandlingCode::latest()->get();
        $airlines = Airline::latest()->get();
        return view('backend.pages.acceptance.forms', compact('code', 'handling_codes', 'airlines'));
    }

    public function edit(Request $request, $id)
    {
        $code = $this->stationCode;
        $acc = AcceptancePool::findOrFail($id);
        return view('backend.pages.acceptance.edit', compact('code', 'acc'));
    }

    public function submitForms(Request $request)
    {
        $data = $request->validate([
            'prefix' => 'required', 'serial' => 'required', 'originCode' => 'required',
            'destinationCode' => 'required', 'pieces' => 'required', 'natureOfGoods' => '', 'weight' => 'required',
            'volume' => '', 'specialHandlingCodes' => '', 'securityStatus' => '', 'x-ray' => '', 'remarks' => '',
            'blockedForManifesting' => ''
        ]);

        if (floatval($data['weight']) == floatval(0)) {
            $request->session()->flash('alert-danger', 'Incorrect weight scale readings..');
            return back();
        }

        // dd($data);

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $SecKey = $this->cargoKey;
        $airwayBill = $data['prefix'] . '-' . $data['serial'];

        $reqData = array(
            'airWaybill' => [
                "prefix" => intval($data['prefix']),
                "serial" => intval($data['serial']),
                "originCode" => $this->stationCode,
                "destinationCode" => $data['destinationCode'],
                "pieces" => intval($data['pieces']),
                "weight" => [
                    "amount" => intval($data['weight']),
                    "unit" => "KG"
                ],
                "natureOfGoods" => $data['natureOfGoods'] ?? null

            ],
            'part' => [
                "pieces" => $data['pieces'],
                "weight" => [
                    "amount" => intval($data['weight']),
                    "unit" => "KG"
                ],

                "volume" => [
                    "amount" => intval($data['volume']) ?? 0,
                    "unit" => "MC"
                ],
                "specialHandlingCodes" => $data['specialHandlingCodes'] ?? [],
                "securityStatus" => $data['securityStatus'],
                "x-ray" => $data['x-ray'] ?? null,
                "remarks" => $data['remarks'] ?? null,
                "blockedForManifesting" => $data['blockedForManifesting'] ?? null


            ]
        );

        $bb = array(
            "airWaybill" => [
                "prefix" => $data['prefix'],
                "serial" => $data['serial'],
                "originCode" => $this->stationCode,
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




        // dd($bb);

        $curl = curl_init();

        $reqURL = "https://api-gateway-dev.champ.aero/csp/acceptance/v1/airwaybills/acceptance-requests";

        // dd($this->cargoKey, $this->stationCode);
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
            $request->session()->flash('alert-danger', 'Global error processing request');
        }
        if ($httpcode == 201) {
            $this->getAirwayBill($airwayBill, true);
        }

        $request->session()->flash('alert-success', 'Acceptance form data successfully processed');
        return redirect()->route('backend.acceptance.list');

        $tranx = json_decode($response, true);
    }

    protected function getAirwayBill($bill, $persit)
    {
        $curl = curl_init();
        $reqURL = "https://api-gateway-dev.champ.aero/csp/acceptance/v1/airwaybills";

        curl_setopt_array($curl, array(
            CURLOPT_URL => $reqURL . '/' . $bill,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => [],
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

        $dataResponse = json_decode($response);

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
                    'author_name' =>  auth()->user()->name,
                    'author_id' =>  auth()->user()->id
                ]);
                if (env('APP_ENV') == 'local') {
                    $req = array(
                        'airWaybill' =>  $dataResponse->airWaybill->prefix . '-' . $dataResponse->airWaybill->serial,
                        'pieces' =>  $dataResponse->airWaybill->pieces,
                        'weight' =>  $dataResponse->airWaybill->weight->amount,
                        'volume' =>  $dataResponse->airWaybill->volume->amount,
                        'origin' =>  $dataResponse->airWaybill->origin->code,
                        'destination' =>  $dataResponse->airWaybill->destination->code,
                        'statusCode' =>  $dataResponse->parts[0]->statusCode,
                        'author_name' =>  auth()->user()->name,
                        'author_id' =>  auth()->user()->id
                    );
                    // $callback_url = "localhost:8000";
                    $callback_url = "159.223.238.21";

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $callback_url . '/api/v1/acceptance-request',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => json_encode($req),
                        CURLOPT_HTTPHEADER => [
                            "content-type: application/json",
                            "cache-control: no-cache"
                        ],
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    if ($err) {
                        // there was an error contacting the Paystack API
                        die('Curl returned error: ' . $err);
                    }

                    $tranx = json_decode($response, true);
                    dd($tranx);
                }
            }
        }
    }

    public function export(Request $request)
    {
        dd('io');
        // return Excel::download(new AirbillExport, 'records.xlsx');
        // $pdf = SnappyPdf::loadView('pages.pdfs.payment', []);
    }
}
