<?php

namespace App\Http\Livewire\Transaction;

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

    protected $rules = [
        'service' => 'required',
        'price_amount' => 'required',
    ];

    public $table = [];
    public function mount(){
        $this->client = Client::all();
        $this->trx = trx();
        $this->allProduct = Product::all();
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
            'amount' => num((getAmount($this->price_amount) * $product->percent) / 100)
        ];
        $this->total =  $this->getTotalAmount();
        $this->fin_amount = $this->getFinAmount();
        $this->subtotal = num($this->subTotal());
        $this->product = null;
        $this->price_amount = null;
        $this->service = null;
    }

    public function addAditional(){
        $this->additionalTable[] =[
            'name' => $this->add_name,
            'percent'=> $this->add_prercent.'%',
            'amount' => num($this->subTotal() * $this->add_prercent / 100)
        ];
        $this->subtotal = num($this->subTotal());
        $this->add_name = null;
        $this->add_prercent = null;
        $this->total_due = num($this->getTotalDue());
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
                $add->total = getAmount($val['amount']);
                $add->save();
            }

            DB::commit();
            return redirect()->route('product')->with('success','Order Create');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            $this->emit('error',$th->getMessage());
        }
    }

    // public function submitOrder(){
    //     $client = $this->client_id;
    //     $trx = trx(); 
    //     $due = $this->due_date;
    //     $notes = $this->order_notes;
    //     $cashier_id = auth()->user()->id;
    //     $charge_name = $this->charge_name;
    //     $charge_percent = $this->charge_percent??0;
    //     $charge_amount = getAmount($this->charge_amount??0);

    //     $disc_name = $this->disc_name;
    //     $disc_percent = getAmount($this->disc_percent);
    //     $disc_amount = getAmount($this->disc_amount??0);

    //     $dp_amount = getAmount($this->dp_amount);


    //     // $desain_front = $this->desain_front->store('order');
    //     if ($this->desain_front) {
    //         $desainFrontPath = $this->desain_front->store('public/images/order');
    //         $desainFrontUrl = Storage::url($desainFrontPath);
    //         // Use $desainFrontUrl as needed
    //         $desain_front =   $desainFrontUrl;
    //     } else {
    //         $desain_front = null;
    //     }
    //     if ($this->desain_back) {
    //         $desainBackPath = $this->desain_back->store('public/images/order');
    //         $desainBackUrl = Storage::url($desainBackPath);
    //         // Use $desainBackUrl as needed
    //         $desain_back =   $desainBackUrl;
    //     } else {
    //         $desain_back = null;
    //     }
    
       
    //     DB::beginTransaction();
    //     try {
    //         $order = new Order();
    //         $order->client      = $client;
    //         $order->trx         = $trx;
    //         $order->due_date    = $due;
    //         $order->desain_front = $desain_front;
    //         $order->desain_back = $desain_back;
    //         $order->notes       = $notes;
    //         $order->dp_amount   = $dp_amount;
    //         $order->total       = $this->getTotalAmount();
    //         $order->charge_name = $charge_name;
    //         $order->charge_percent = $charge_percent;
    //         $order->charge_amount   = $charge_amount;
    //         $order->disc_name       = $disc_name;
    //         $order->disc_percent    = $disc_percent;
    //         $order->disc_amount     = $disc_amount;
    //         $order->fin_amount      = $this->getFinAmount();
    //         $order->status          = 1;
    //         $order->cashier_id      = $cashier_id;
    //         $order->save();

    //         foreach ($this->table as $item) {
    //             $detail = new OrderDetail();
    //             $detail->order_id = $order->id;
    //             $detail->product_id = $item['produk_id'];
    //             $detail->order      = $item['produk_jml'];
    //             $detail->notes      = $item['produk_notes'];
    //             $detail->save();
    //         }
    //         DB::commit();
    //         return redirect()->route('admin.order.all')->with('success','Order Create');
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         $this->emit('error',$th->getMessage());
    //     }

    // }
    public function getTotalDue(){
        $totalDue = 0;
        foreach ($this->additionalTable as $item) {
            $totalDue += getAmount($item['amount']??0);
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
        // //cek diskon %;
        // if($this->disc_percent != 0||$this->disc_percent != null){
        //     $disc_percen = $total * $this->disc_percent/100;
        // }else{
        //     $disc_percen = 0;
        // }
        // // total dikurangi diskon;
        // $total -= $disc_percen;
        // $total -= getAmount($this->disc_amount);

        // if($this->charge_percent != 0 || $this->charge_percent != null){
        //     $charge_percent = $total * $this->charge_percent/100;
        // }else{
        //     $charge_percent = 0;
        // }

        // $total += $charge_percent;
        // $total += getAmount($this->charge_amount);

        return $total;

    }
    public function checkAmount(){

        $this->fin_amount = $this->getFinAmount();
        $this->render();
    }

    public function deleteRow($index)
    {
        unset($this->table[$index]);
        $this->total =  $this->getTotalAmount();
    }
    public function deleteAdditional($index){
        unset($this->additionalTable[$index]);
        $this->total =  $this->getTotalAmount();
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
