<?php

namespace App\Http\Livewire;

use App\Models\Signee;
use Livewire\Component;

class AcceptFormInputs extends Component
{
    public $agents;
    public $passcode;
    public $agentid;
    public $sbm = false;
    public $err = false;

    public function mount()
    {
        $this->agents = Signee::latest()->get();
    }
    public function sign()
    {
        // dd($this->agentid, $this->passcode);
        $agent = Signee::where('userid', $this->agentid)->first();
        if($agent->passcode === $this->passcode) {
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
