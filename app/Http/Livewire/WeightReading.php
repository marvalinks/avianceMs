<?php

namespace App\Http\Livewire;

use Livewire\Component;
use robertogallea\LaravelPython\Services\LaravelPython;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class WeightReading extends Component
{
    public $comport = "COM";
    public $weight;
    public function render()
    {
        return view('livewire.weight-reading');
    }

    public function testPythonScript()
    {

        if ($this->comport == '') {
            return false;
        }
        $path = app_path('PythonScripts');
        $service = new LaravelPython();
        $result = $service->run($path . '/weight.py', [$this->comport]);
        $this->weight = $result;
        // dd($result);
    }
}
