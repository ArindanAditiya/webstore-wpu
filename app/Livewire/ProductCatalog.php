<?php
declare(strict_types=1);

namespace App\Livewire;

use App\Data\ProductCollectionData;
use App\Data\ProductData;
use App\Models\Product;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;
        
class ProductCatalog extends Component
{
    use WithPagination;

    public $queryString = [
        "select_collections"    => ["exept" => []],
        "sort_by"               => ["exept" => "newest"],
        "search"                => ["exept" => []]
    ];

    public array $select_collections = [];
    
    public string $search = "";

    public string $sort_by = "newest"; // latest, price_asc, price_desc, 

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->select_collections = [];
        $this->search = "";
        $this->sort_by = "newest";
        $this->resetPage();
    }

    public function render()
    {
        $collection_result = Tag::query()->withType("collection")->withCount("products")->get();
        //$result = Product::paginate(9); //-> eloquent : connect ke database dan container jadi tanggungjawabnya terlalu besar
        $query = Product::query();

        // search by name
        if($this->search){
            $query->where("name", "LIKE", "%$this->search%");
        }

        // search collection
        if(!empty($this->select_collections)){
            $query->whereHas("tags", function ($query) {
                $query->whereIn("id", $this->select_collections);
            });
        }

        // sort by
        switch($this->sort_by){
            case "latest":
                $query->oldest();
                break;
            case "price_asc":
                $query->orderBy("price", "asc");
                break;
            case "price_desc":
                $query->orderBy("price", "desc");
                break;
            default:
                $query->latest();
                break;
        }

        $products = ProductData::collect(
            $query->paginate(9)
        );
        $collections = ProductCollectionData::collect($collection_result);
        
        return view('livewire.product-catalog', compact("products", "collections"));
    }
}

