<?php

namespace App\Http\Livewire;

use App\Models\Signee;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class AcceptFormInputs extends Component
{
    public $agents;
    public $passcode;
    public $agentid;
    public $sbm = false;
    public $err = false;

    public $aa;
    public $as;
    public $sa;

    public $aaid;
    public $aa_code;

    public $asid;
    public $as_code;
    
    public $said;
    public $sa_code;

    public $sign_count = 1;

    protected $routePath = "http://159.223.238.21/api/v1";

    public function mount()
    {
        // $this->agents = Signee::latest()->get();
        $url = $this->routePath.'/signees/in';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->get($url);

        $this->aa = $response->json()['success']['aa']['data'];
        $this->as = $response->json()['success']['as']['data'];
        $this->sa = $response->json()['success']['sa']['data'];

    }
    public function sign()
    {
        // dd($this->aaid, $this->aa_code);
        // $agent = Signee::where('userid', $this->agentid)->first();

        if($this->sign_count == intval(1)) {
            $agent = collect($this->aa)->where('userid', $this->aaid)->first();
            if($agent['passcode'] === $this->aa_code) {
                $this->sbm = false;
                $this->err = false;

                $this->sign_count = 2;

                return false;
            }else{
                $this->err = true;
                $this->sbm = false;
                $this->aaid = null;
                $this->aa_code = null;
            }
        }
        if($this->sign_count == intval(2)) {
            $agent = collect($this->as)->where('userid', $this->asid)->first();
            if($agent['passcode'] === $this->as_code) {
                $this->sbm = false;
                $this->err = false;

                $this->sign_count = 3;

                return false;
            }else{
                $this->err = true;
                $this->sbm = false;
                $this->asid = null;
                $this->as_code = null;
            }
        }
        if($this->sign_count == intval(3)) {
            $agent = collect($this->sa)->where('userid', $this->said)->first();
            // dd($this->sa,$this->said, $agent);
            if($agent['passcode'] === $this->sa_code) {
                $this->sbm = true;
                $this->err = false;

                $this->sign_count = 3;
            }else{
                $this->err = true;
                $this->sbm = false;
                $this->said = null;
                $this->sa_code = null;
            }
        }
    }
    public function render()
    {
        return view('livewire.accept-form-inputs');
    }
}
