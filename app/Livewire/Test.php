<?php

namespace App\Livewire;

use App\Models\Schoolclass;
use Livewire\Component;

class Test extends Component
{
    public $record;
    public $randomnumber;

    public function showrand()
    {
        $this->randomnumber = rand(1, 100);
    }



    public function render()
    {
        return view('livewire.test');
    }
}
