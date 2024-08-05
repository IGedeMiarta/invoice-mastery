<?php

namespace App\Http\Livewire\Transaction;

use App\Additional;
use App\Client;
use App\Product;
use App\Transaction;
use App\TransactionAdditional;
use App\TransactionDetail;
use Illuminate\Http\Request;
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
    public $dates;
    public $sub_total;
    public $change = false;

    public $modelEdit;


    public $table = [];
    public function mount(Request $request){
        
        $this->client = Client::all();
        $this->trx = trx();
        $this->allProduct = Product::where('status',1)->get();
        $this->additional == null ? false:true;
        $this->additionalModel = Additional::where('status',1)->get();

        if ($request->edit) {
            $this->onEditFunction($request->edit);
        }
    }


    private function onEditFunction($id){
        $trx = Transaction::find($id);
        $trx_detail = TransactionDetail::with('getProduct')->where('trx_id',$trx->id)->get();
        $trx_add    = TransactionAdditional::where('trx_id',$trx->id)->get();

        $this->total    = $trx->total;
        $this->sub_total = num($trx->sub_total);
        $this->total_due = num($trx->due_total);
        $this->trx = $trx->trx;
        $this->client_id = $trx->client_id;
        $this->desc = $trx->desc;
        $this->dates = $trx->dates;
        foreach ($trx_detail as $i => $detail) {
            $this->table[] = [
                'id'        => $detail->id,
                'no'        => $i+1,
                'product' => $detail->getProduct->name,
                'product_id' => $detail->product_id,
                'percent'   => $detail->getProduct->percent,
                'price' =>num($detail->price),
                'amount' => num($detail->amount)
            ];
        }
        foreach ($trx_add as $key => $add) {
            $this->additionalTable[] = [
                'id'        => $add->id,
                'name'      => $add->name,
                'percent'   => $add->percent.'%',
                'amount'    => num(($this->subTotal() / 100) * getAmount($add->percent) ),
                'type'      => $add->type
            ];
        }

        $this->fin_amount = $this->getFinAmount();
        $this->modelEdit = $trx;
    }


    public function changeSubtotal(){
        $this->subtotal = $this->sub_total;
        $this->change = true;
        $this->refreshTable();
        $this->addAditional();
        $this->total_due = num($this->getTotalDue());

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
        $this->sub_total = num($this->subTotal());
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
        return $this->change?getAmount($this->sub_total):bulatkan($this->getTotalAmount());
    }

    protected $rules = [
        'client_id' => 'required',
        'desc' => 'required',
        'dates' => 'required',
    ];
    public function submitOrder(){
        $this->validate();
        
        DB::beginTransaction();
        try {
           
            if ($this->modelEdit) {
                $this->updateTransaction();
                $msg = 'Invoice Updated';

            }else{
                $this->submitTransaction();
                $msg = 'Invoice Create';
            }

            DB::commit();
            return redirect()->route('transaction.all')->with('success',$msg);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            $this->emit('error',$th->getMessage());
        }
    }

    private function updateTransaction()
    {
        $trx = $this->modelEdit;
        $trx->trx       = $this->trx;
        $trx->client_id = $this->client_id;
        $trx->desc      = $this->desc;
        $trx->total     = $this->getFinAmount();
        $trx->sub_total = $this->subTotal();
        $trx->due_total = $this->getTotalDue();
        $trx->dates     = $this->dates;
        $trx->save();

        $existingDetailIds = TransactionDetail::where('trx_id', $trx->id)->pluck('id')->toArray();
        $newDetailIds = [];

        foreach ($this->table as $item) {
            if (isset($item['id'])) {
                // Update existing detail
                $detail = TransactionDetail::find($item['id']);
                $detail->product_id = $item['product_id'];
                $detail->price = getAmount($item['price']);
                $detail->amount = getAmount($item['amount']);
                $detail->save();
                
                $newDetailIds[] = $item['id'];
            } else {
                // Insert new detail
                $detail = new TransactionDetail();
                $detail->trx_id = $trx->id;
                $detail->product_id = $item['product_id'];
                $detail->price = getAmount($item['price']);
                $detail->amount = getAmount($item['amount']);
                $detail->save();
                
                $newDetailIds[] = $detail->id; // Ensure new inserted IDs are tracked
            }
        }
        // Delete any details that were not included in the new data
        $detailsToDelete = array_diff($existingDetailIds, $newDetailIds);
        TransactionDetail::whereIn('id', $detailsToDelete)->delete();


        
        // Handling additionalTable
        $existingAdditionalIds = TransactionAdditional::where('trx_id', $trx->id)->pluck('id')->toArray();
        $newAdditionalIds = [];

        foreach ($this->additionalTable as $val) {
            if (isset($val['id'])) {
                // Update existing additional
                $add = TransactionAdditional::find($val['id']);
                $add->name = $val['name'];
                $add->percent = getAmount($val['percent']);
                $add->type = $val['type'];
                $add->total = getAmount($val['amount']);
                $add->save();

                $newAdditionalIds[] = $val['id'];
            } else {
                // Insert new additional
                $add = new TransactionAdditional();
                $add->trx_id = $trx->id;
                $add->name = $val['name'];
                $add->percent = getAmount($val['percent']);
                $add->type = $val['type'];
                $add->total = getAmount($val['amount']);
                $add->save();

                $newAdditionalIds[] = $add->id; // Ensure new inserted IDs are tracked
            }
        }

        // Delete any additionals that were not included in the new data
        $additionalsToDelete = array_diff($existingAdditionalIds, $newAdditionalIds);
        TransactionAdditional::whereIn('id', $additionalsToDelete)->delete();
    }

    private function submitTransaction(){
        $trx = new Transaction();
        $trx->trx       = $this->trx;
        $trx->client_id = $this->client_id;
        $trx->desc      = $this->desc;
        $trx->total     = $this->getFinAmount();
        $trx->sub_total = $this->subTotal();
        $trx->due_total = $this->getTotalDue();
        $trx->dates     = $this->dates;
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
        
        $total = $totalDue + $this->subtotal();
        return $total;
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

    public function reloadClient(Request $request)
    {
        $client = Client::orderByDesc('id')->first();
        $this->client = $client->id;
        $this->mount($request);
        $this->render();
    }
    public function reloadProduk(Request $request){
        $this->mount($request);
        $this->render();
        $this->emit('success');
    }

    public function render()
    {
        return view('livewire.transaction.create');
    }
}
