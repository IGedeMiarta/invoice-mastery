<?php

namespace App\Http\Livewire\Transaction;

use App\Client;
use Livewire\Component;

class ClientCreate extends Component
{
    public $company_name,$name,$position,$company_address;

    
    public function save()
    {
        Client::create([
            'company_name'=> $this->company_name,
            'name'=> $this->name,
            'position'=> $this->position,
            'company_address'=> $this->company_address,
        ]);
        $this->emit('closeModal');
        $this->emit('reloadClient');
        $this->emit('success');
    }
    public function render()
    {
        return view('livewire.transaction.client-create');
    }
}
