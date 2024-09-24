<?php

namespace App\Livewire\Pages;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('My Order')]
class MyOrder extends Component
{
    use WithPagination;

    public function render()
    {
        $models = Order::where('user_id', Auth::id())->latest()->paginate(10);

        return view('livewire.pages.my-order', compact('models'));
    }
}
