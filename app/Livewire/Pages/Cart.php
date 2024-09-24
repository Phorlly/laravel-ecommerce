<?php

namespace App\Livewire\Pages;

use App\Http\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart')]
class Cart extends Component
{
    public $items = [],
        $grandTotal;

    public function mount()
    {
        $this->items = CartManagement::getItems();
        $this->grandTotal = CartManagement::calculateGrandTotal($this->items);
    }

    public function removeItem($productId)
    {
        $this->items = CartManagement::removeItem($productId);
        $this->grandTotal = CartManagement::calculateGrandTotal($this->items);
        $this->dispatch('modify-cart-count', countTotal: count($this->items))->to(Navbar::class);
    }

    public function decrement($productId)
    {
        $this->items = CartManagement::decrementQuantity($productId);
        $this->grandTotal = CartManagement::calculateGrandTotal($this->items);
    }

    public function increment($productId)
    {
        $this->items = CartManagement::incrementQuantity($productId);
        $this->grandTotal = CartManagement::calculateGrandTotal($this->items);
    }

    public function render()
    {
        return view('livewire.pages.cart');
    }
}
