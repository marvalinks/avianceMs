<?php

namespace App\Http\Livewire;

use Livewire\Component;
use robertogallea\LaravelPython\Services\LaravelPython;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class WeightReading extends Component
{
    public $comport = "0";
    public $weight = "0";
    public $color = "danger";

    protected $listeners = ['readWeight' => 'testPythonScript'];

    public function mount()
    {
        // $this->testPythonScript();
    }

    public function render()
    {
        return view('livewire.weight-reading');
    }

    public function testPythonScript()
    {
        $path = app_path('PythonScripts');
        // dd($path . '/weight.py');
        // $service = new LaravelPython();
        // $result = $service->run($path . '/weight.py');
        // $result = \Python::run($path . '/weight.py');
        $result = shell_exec("python " . $path . "/weight.py" . " 2>&1");

        // dd(trim($result));
        if (trim($result) == trim("error")) {
            $this->weight = 0;
            $this->color = "danger";
        } else {
            $this->weight = $result;
            $this->color = "success";
        }
    }
}
