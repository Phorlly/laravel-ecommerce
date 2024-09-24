<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cancel')]
class Cancel extends Component
{
    public function render()
    {
        return view('livewire.pages.cancel');
    }
}
