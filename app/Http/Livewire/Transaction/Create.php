<?php

namespace App\Http\Livewire\Transaction;

use App\Additional;
use App\Client;
use App\Product;
use App\Transaction;
use App\TransactionAdditional;
use App\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $client,$due_date;
    public $client_id;
    public $allProduct;
    public $service;
    public $product;
    public $price_amount;
    public $total;
    public $order_notes;
    public $dp_amount;
    public $disc_name;
    public $disc_percent;
    public $disc_amount;
    public $charge_name;
    public $charge_percent;
    public $charge_amount;
    public $fin_amount;
    public $subtotal;
    public $allType;
    public $trx;
    public $add_name;
    public $add_prercent;
    public $additionalTable = [];
    public $notes;
    public $desc;
    public $total_due;
    public $additional = null;
    public $additionalModel;

    protected $rules = [
        'service' => 'required',
        'price_amount' => 'required',
    ];

    public $table = [];
    public function mount(){
        $this->client = Client::all();
        $this->trx = trx();
        $this->allProduct = Product::where('status',1)->get();
        $this->additional == null ? false:true;
        $this->additionalModel = Additional::where('status',1)->get();
        
    }
    
    public function addProduk()
    {
        $this->validate();

        $no = count($this->table) +1;
        $product = Product::find($this->service);

        $this->table[] = [
            'no'        => $no,
            'product' => $product->name,
            'product_id' => $this->service,
            'percent'   => $product->percent,
            'price' => $this->price_amount,
            'amount' => $product->percent == 0? num(getAmount($this->price_amount)):  num((getAmount($this->price_amount) * $product->percent) / 100)
        ];
        $this->total =  $this->getTotalAmount();
        $this->fin_amount = $this->getFinAmount();
        $this->subtotal = num($this->subTotal());
        $this->product = null;
        $this->price_amount = null;
        $this->service = null;
        $this->addAditional();
    }

    public function addAditional(){
        $this->additional = true;
        $this->refreshTable();
        $this->subtotal = num($this->subTotal());
        $this->add_name = null;
        $this->add_prercent = null;
        $this->total_due = num($this->getTotalDue());
    }
    public function refreshTable(){
        $data = $this->additionalModel;
        $this->additionalTable = [];
        foreach ($data as $key => $value) {
            $this->additionalTable[] = [
                'name' => $value->name,
                'percent'=> $value->percent.'%',
                'amount' => num(($this->subTotal() / 100) * getAmount($value->percent) ),
                'type'  => $value->type
            ];
        }
    }
    public function subTotal(){
        return bulatkan($this->getTotalAmount());
    }

    public function submitOrder(){
        $client   = $this->client_id;
        $desc     = $this->desc;
        DB::beginTransaction();
        try {
            $trx = new Transaction();
            $trx->trx       = $this->trx;
            $trx->client_id = $client;
            $trx->desc      = $desc;
            $trx->total     = $this->getFinAmount();
            $trx->sub_total = $this->subTotal();
            $trx->due_total = $this->getTotalDue();
            $trx->save();

            foreach ($this->table as $item) {
                $detail = new TransactionDetail();
                $detail->trx_id = $trx->id;
                $detail->product_id = $item['product_id'];
                $detail->price      = getAmount($item['price']);
                $detail->amount      = getAmount($item['amount']);
                $detail->save();
            }
            foreach ($this->additionalTable as $val) {
                $add = new TransactionAdditional();
                $add->trx_id = $trx->id;
                $add->name = $val['name'];
                $add->percent = getAmount($val['percent']);
                $add->type = $val['type'];
                $add->total = getAmount($val['amount']);
                $add->save();
            }

            DB::commit();
            return redirect()->route('transaction.all')->with('success','Order Create');
        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th->getMessage());
            $this->emit('error',$th->getMessage());
        }
    }

    public function getTotalDue(){
        $totalDue = 0;
        foreach ($this->additionalTable as $item) {
            if ($item['type']) {
               $totalDue += getAmount($item['amount']??0);
            }else{
                $totalDue -= getAmount($item['amount']??0);
            }
            
        }
        
        return $totalDue + $this->subtotal();
    }
    public function getTotalAmount()
    {
        $totalAmount = 0;
        foreach ($this->table as $item) {
            $totalAmount += getAmount($item['amount']??0);
        }
        
        return $totalAmount;
    }
    public function getFinAmount(){
        $total = $this->getTotalAmount();
        return $total;

    }
    public function checkAmount(){

        $this->fin_amount = $this->getFinAmount();
        $this->render();
    }

    public function deleteRow($index)
    {
        unset($this->table[$index]);
        $this->fin_amount = $this->getFinAmount();
        $this->total_due =  num($this->getTotalDue());
        $this->subtotal = num($this->subtotal());
        $this->render();
    }
    public function deleteAdditional($index){
        unset($this->additionalTable[$index]);
        $this->fin_amount = $this->getFinAmount();
        $this->total_due =  num($this->getTotalDue());
        $this->render();

    }
    public function refresh($index){
        $this->additionalTable[$index] =[
            'name' => $this->additionalTable[$index]['name'],
            'percent'=> $this->additionalTable[$index]['percent'],
            'amount' =>  num($this->subtotal() * getAmount($this->additionalTable[$index]['percent']) / 100)
        ];
        $this->total_due =  num($this->getTotalDue());
    }

    protected $listeners = ['reloadClient','reloadProduk'];

    public function reloadClient()
    {
        $client = Client::orderByDesc('id')->first();
        $this->client = $client->id;
        $this->mount();
        $this->render();
    }
    public function reloadProduk(){
        $this->mount();
        $this->render();
        $this->emit('success');
    }

    public function render()
    {
        return view('livewire.transaction.create');
    }
}
