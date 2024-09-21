<?php

namespace App\Livewire\Pages;

use App\Http\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProductDetail extends Component
{
    use LivewireAlert;

    public $slug = '',
        $quantity = 1;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function increase()
    {
        $this->quantity++;
    }

    public function decrease()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    //add product to cart
    public function addToCart($productId)
    {
        $countTotal = CartManagement::addItemToCartWithQuantity($productId, $this->quantity);
        $this->dispatch('modify-cart-count', countTotal: $countTotal)->to(Navbar::class);

        $this->alert(message: 'Added product to cart!', options: ['position' => 'top-start']);
    }

    #[Title('Product Detail')]
    public function render()
    {
        return view('livewire.pages.product-detail', [
            'model' => Product::where('slug', $this->slug)->first(),
        ]);
    }
}
