<?php

namespace App\Livewire\Partials;

use App\Http\Helpers\CartManagement;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public $countTotal = 0;

    public function mount()
    {
        $this->countTotal = count(CartManagement::getItems());
    }

    #[On('modify-cart-count')]
    public function modifyCartCount($countTotal)
    {
        $this->countTotal = $countTotal;
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
