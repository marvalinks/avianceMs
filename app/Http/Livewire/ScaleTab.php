<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ScaleTab extends Component
{

    public $comport = "0";
    public $weight = "0";
    public $color = "danger";
    protected $listeners = ['weightTab' => 'testPythonScript'];

    public function testPythonScript()
    {
        $this->weight = session('weight') ?? 0;
    }
    public function render()
    {
        return view('livewire.scale-tab');
    }
}
