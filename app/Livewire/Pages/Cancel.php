<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Component;

class Cancel extends Component
{
    #[Title('Cancel')]
    public function render()
    {
        return view('livewire.pages.cancel');
    }
}
