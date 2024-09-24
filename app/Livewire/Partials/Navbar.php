<?php

namespace App\Livewire\Partials;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Helpers\CartManagement;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Navbar extends Component
{
    use LivewireAlert;

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

    public function signOff()
    {
        Auth::logout();
        $this->alert(message: 'Logged off successfully!', options: ['position' => 'top-start']);

        return $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
