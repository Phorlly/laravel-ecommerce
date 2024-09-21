<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Component;

class Success extends Component
{
    #[Title('Success')]
    public function render()
    {
        return view('livewire.pages.success');
    }
}
