<?php

namespace App\Livewire\Pages;

use App\Http\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product as Model;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Product extends Component
{
    use WithPagination;
    use LivewireAlert;

    #[Url]
    public $selectedCategories = [],
        $selectedBrands = [],
        $featured = 0,
        $onSale = 0,
        $priceRange = 1000,
        $sort = 'latest';

    //add product to cart
    public function addToCart($productId)
    {
        $countTotal = CartManagement::addItemToCart($productId);
        $this->dispatch('modify-cart-count', countTotal: $countTotal)->to(Navbar::class);

        $this->alert(message: 'Added product to cart!', options: ['position' => 'top-start']);
    }

    #[Title('Product')]
    public function render()
    {
        $brands = Brand::where('is_active', 1)->get(['id', 'name', 'slug']);
        $categories = Category::where('is_active', 1)->get(['id', 'name', 'slug']);
        $models = Model::orderBy('created_at', 'desc')->where('is_active', 1);

        //filter by category id
        if ($this->selectedCategories) {
            $models = $models->whereIn('category_id', $this->selectedCategories);
        }

        //filter by brand id
        if ($this->selectedBrands) {
            $models = $models->whereIn('brand_id', $this->selectedBrands);
        }

        //filter by featured
        if ($this->featured) {
            $models = $models->where('is_featured', $this->featured);
        }

        //filter by on sale
        if ($this->onSale) {
            $models = $models->where('on_sale', $this->onSale);
        }

        //filter by price range
        if ($this->priceRange) {
            $models = $models->whereBetween('price', [0, $this->priceRange]);
        }

        //sort by selected option
        switch ($this->sort) {
            case 'latest':
                $models = $models->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $models = $models->orderBy('created_at', 'asc');
                break;
            case 'price_high':
                $models = $models->orderBy('price', 'desc');
                break;
            case 'price_low':
                $models = $models->orderBy('price', 'asc');
                break;
            default:
                $models = $models->orderBy('created_at', 'desc');
                break;
        }

        return view('livewire.pages.product', [
            'brands' => $brands,
            'categories' => $categories,
            'models' => $models->paginate(6),
        ]);
    }
}
