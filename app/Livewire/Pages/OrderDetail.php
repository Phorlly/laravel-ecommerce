<?php

namespace App\Livewire\Pages;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Title;

class OrderDetail extends Component
{
    public $slug = '';
    public function mount($slug)
    {
        $this->slug = $slug;
    }

    #[Title('Order Detail')]
    public function render()
    {
        return view('livewire.pages.order-detail',[
            'model' => Order::where('slug', $this->slug)->firstOrFail(),
        ]);
    }
}
