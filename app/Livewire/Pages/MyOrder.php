<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Component;

class MyOrder extends Component
{
    #[Title('My Order')]
    public function render()
    {
        return view('livewire.pages.my-order');
    }
}
