<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SelectUld extends Component
{

    public $uld_option;
    public function render()
    {
        return view('livewire.select-uld');
    }
}
