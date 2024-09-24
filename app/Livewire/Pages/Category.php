<?php

namespace App\Livewire\Pages;

use App\Models\Category as Model;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Category')]
class Category extends Component
{
    public function render()
    {
        $models = Model::where('is_active', 1)->get();

        return view('livewire.pages.category', compact('models'));
    }
}
