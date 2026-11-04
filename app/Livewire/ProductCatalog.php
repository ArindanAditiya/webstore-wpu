<?php
declare(strict_types=1);

namespace App\Livewire;

use App\Data\ProductData;
use App\Models\Product;
use Livewire\Component;

class ProductCatalog extends Component
{
    public function render()
    {
        $result = Product::paginate(9); //-> eloquent : connect ke database dan container jadi tanggungjawabnya terlalu besar
        $products = ProductData::collect($result);
        // TODO Make a DTO
        // alasan kenapa menggunakan DTO
        // 1. clean code (Data & Logic)
        // 2. Validaion & Typing
        // 3. Fleksibel

        // Kalau misalnya mau ambil hanya 1 data saja
        // $product = Product::first();
        // dd(ProductData::fromModel($product));
        
        return view('livewire.product-catalog', compact("products"));
    }
}
