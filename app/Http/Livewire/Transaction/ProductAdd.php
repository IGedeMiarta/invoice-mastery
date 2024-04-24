<?php

namespace App\Http\Livewire\Transaction;

use App\Product;
use Livewire\Component;

class ProductAdd extends Component
{
    public $name,$percent;

    public function save(){
        $product = new Product();
        $product->name = $this->name;
        $product->percent = $this->percent;
        $product->save();

        $this->reset();
        $this->emit('closeModal');
        $this->emit('reloadProduk');
        $this->emit('success');
    }
    public function render()
    {
        return view('livewire.transaction.product-add');
    }
}
