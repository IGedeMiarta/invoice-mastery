<?php

namespace App\Http\Livewire\Transaction;

use App\Additional;
use App\Client;
use App\Transaction;
use App\TransactionAdditional;
use App\TransactionDetailList;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CreateList extends Component
{
    use WithFileUploads;
    public $client_id;
    public $client,$trx,$fin_amount,$total_due,$subtotal,$add_name,$add_prercent;
    public $date,$start,$end,$who,$desc,$cost,$description;
    public $excelInpt;
    public $table = [];
    public $additionalTable = [];
    public $additional = null;
    public $additionalModel;

    public function mount(){
        $this->client = Client::all();
        $this->trx = trx();
        $this->additional == null ? false:true;
        $this->additionalModel = Additional::where('status',1)->get();
    }
    public function submitTable(){
        // dd($this->excelInpt);
        $file = $this->excelInpt->store('excelInpt');

        $data = Excel::toArray([],$file);


        $rows = $data[0];

        // dd($rows);
        foreach (array_slice($rows, 1) as $row) {
           $this->table[] = [
                'date' => $row[0],
                'start' => date('h:i',strtotime($row[1])),
                'end' => date('h:i',strtotime($row[2])),
                'who' => $row[3],
                'description' => $row[4],
                'cost' => num(getAmount($row[5])),
           ];
        }
        $this->dispatchBrowserEvent('closeModal');
        $this->getFinnAmount();
         $this->addAditional();
        return 1;

    }
    public function addTable(){
        
        $this->table[] = [
                'date' => date('d/m/Y',strtotime($this->date)),
                'start' => date('h:i',strtotime($this->start)),
                'end' => date('h:i',strtotime($this->end)),
                'who' => $this->who,
                'description' => $this->description,
                'cost' => num(getAmount($this->cost)),
        ];
        $this->date = null;
        $this->start = null;
        $this->end = null;
        $this->who = null;
        $this->description = null;
        $this->cost = null;
        $this->getFinnAmount();
        $this->dispatchBrowserEvent('closeModalAdd');
        $this->render();
        $this->addAditional();
    }
    public function addAditional(){
        $this->additional = true;
        if (count($this->additionalTable) >=1) {
            $this->subtotal = num($this->subTotal());
            $this->add_name = null;
            $this->add_prercent = null;
            $this->total_due = num($this->getTotalDue());
            return true;
        };
        $data = $this->additionalModel;
        foreach ($data as $key => $value) {
            $this->additionalTable[] = [
                'name' => $value->name,
                'percent'=> $value->percent.'%',
                'amount' => num($this->subTotal() * $value->percent / 100),
                'type'  => $value->type
            ];
        }
        $this->subtotal = num($this->subTotal());
        $this->add_name = null;
        $this->add_prercent = null;
        $this->total_due = num($this->getTotalDue());
    }
    public function getFinnAmount(){
        $finAmount = 0;
        foreach ($this->table as $key => $value) {
            $finAmount +=  getAmount($value['cost']);
        }
        $this->fin_amount = $finAmount;
        return $finAmount;
    }
    public function deleteRow($index)
    {
        unset($this->table[$index]);
        $this->fin_amount = $this->getFinnAmount();
        $this->render();
    }
     public function deleteAdditional($index){
        unset($this->additionalTable[$index]);
        $this->fin_amount = $this->getFinnAmount();
        $this->subtotal = $this->subTotal();
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
     public function subTotal(){
        return bulatkan($this->getFinnAmount());
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
     public function submitOrder(){
        $client   = $this->client_id;
        $desc     = $this->desc;
        DB::beginTransaction();
        try {
            $trx = new Transaction();
            $trx->trx       = $this->trx;
            $trx->client_id = $client;
            $trx->desc      = $desc;
            $trx->total     = $this->getFinnAmount();
            $trx->sub_total  = $this->subTotal();
            $trx->due_total = $this->getTotalDue();
            $trx->type      = 2;
            $trx->save();

            foreach ($this->table as $item) {
                $detail = new TransactionDetailList();
                $detail->trx_id = $trx->id;
                $detail->date   = $item['date'];
                $detail->start   = $item['start'];
                $detail->end   = $item['end'];
                $detail->who   = $item['who'];
                $detail->description   = $item['description'];
                $detail->cost   = getAmount($item['cost']);
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
        return view('livewire.transaction.create-list');
    }
}
