<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductCatalog extends Component
{
    public function render()
    {
        $products = Product::paginate(9); //-> eloquent : connect ke database dan container jadi tanggungjawabnya terlalu besar
        // TODO Make a DTO
        // alasan kenapa menggunakan DTO
        // 1. clean code (Data & Logic)
        // 2. Validaion & Typing
        // 3. Fleksibel
        return view('livewire.product-catalog', compact("products"));
    }
}
