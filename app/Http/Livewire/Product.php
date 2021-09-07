<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Product;

class Product extends Component
{
    public $action;
    public $selectedItem;

    public function render()
    {
        return view('Admin.produk');
    }

    public function selectItem($id, $action)
    {
        $this->selectedItem = $id;

        if($action == 'delete'){
            $this->dispatchBrowserEvent('modalFormDelete');
        }
    }

    public function delete ()
    {
        Product::destroy($this->selectedItem);
    }
}
