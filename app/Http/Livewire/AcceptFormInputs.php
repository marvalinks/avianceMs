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

    protected $routePath = "http://159.223.238.21/api/v1";

    public function mount()
    {
        // $this->agents = Signee::latest()->get();
        $url = $this->routePath.'/signees';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->get($url);

        $this->agents = $response->json()['success']['users']['data'];
    }
    public function sign()
    {
        // dd($this->agentid, $this->passcode);
        // $agent = Signee::where('userid', $this->agentid)->first();
        $agent = collect($this->agents)->where('userid', $this->agentid)->first();
        if($agent['passcode'] === $this->passcode) {
            $this->sbm = true;
            $this->err = false;
        }else{
            $this->err = true;
            $this->sbm = false;
            $this->passcode = null;
        }
    }
    public function render()
    {
        return view('livewire.accept-form-inputs');
    }
}