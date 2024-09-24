<?php

namespace App\Livewire\Pages;

use App\Models\Order;
use App\Models\Address;
use Livewire\Component;
use App\Models\OrderItem;
use Livewire\Attributes\Title;

#[Title('Order Detail')]
class OrderDetail extends Component
{
    public $order_id;
    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }

    public function render()
    {
        $items = OrderItem::with('product')->where('order_id', $this->order_id)->get();
        $order = Order::where('id', $this->order_id)->first();
        $address = Address::where('order_id', $this->order_id)->first();

        return view('livewire.pages.order-detail', compact('items', 'order', 'address'));
    }
}
