<?php

namespace App\Livewire\Pages;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

class Home extends Component
{
    #[Title('Home')]
    public function render()
    {
        $brands = Brand::where('is_active', 1)->get();
        $categories = Category::where('is_active', 1)->get();

        return view('livewire.pages.home', [
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }
}