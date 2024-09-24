<?php

namespace App\Livewire\Pages;

use App\Models\Brand;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Title;

#[Title('Home')]
class Home extends Component
{
    public function render()
    {
        $brands = Brand::where('is_active', 1)->get();
        $categories = Category::where('is_active', 1)->get();

        return view('livewire.pages.home', compact('brands', 'categories'));
    }
}
