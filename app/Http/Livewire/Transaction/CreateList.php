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
    public $dates;
    public $sub_total;
    public $change = false;

    public function mount(){
        $this->client = Client::all();
        $this->trx = trx();
        $this->additional == null ? false:true;
        $this->additionalModel = Additional::where('status',1)->get();
    }
    public function submitTable(){
        $file = $this->excelInpt->store('excelInpt');
    
        $data = Excel::toArray([], $file);
    
        $rows = $data[0];
        // validation format
        //  $this->emit('error', 'Error Info');
    
        foreach (array_slice($rows, 1) as $row) {
            // Validate each cell
            if (!isset($row[0]) || !preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $row[0])) {
                $this->emit('error', 'Invalid date format in row: ' . json_encode($row));
                continue;
            }
    
            if (!isset($row[1]) || !strtotime($row[1])) {
                $this->emit('error', 'Invalid start time in row: ' . json_encode($row));
                continue;
            }
    
            if (!isset($row[2]) || !strtotime($row[2])) {
                $this->emit('error', 'Invalid end time in row: ' . json_encode($row));
                continue;
            }
    
            if (!isset($row[3]) || empty(trim($row[3]))) {
                $this->emit('error', 'Invalid who in row: ' . json_encode($row));
                continue;
            }
    
            if (!isset($row[4]) || empty(trim($row[4]))) {
                $this->emit('error', 'Invalid description in row: ' . json_encode($row));
                continue;
            }
    
            if (!isset($row[5]) || !is_numeric($row[5])) {
                $this->emit('error', 'Invalid cost in row: ' . json_encode($row));
                continue;
            }
    
            // Add validated row to the table
            $this->table[] = [
                'date' => $row[0],
                'start' => date('h:i', strtotime($row[1])),
                'end' => date('h:i', strtotime($row[2])),
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
    
    
    public function changeSubtotal(){
        $this->subtotal = $this->sub_total;
        $this->change = true;
        $this->refreshTable();
        $this->addAditional();
        $this->total_due = num($this->getTotalDue());

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
        return $this->change?getAmount($this->sub_total):bulatkan($this->getFinnAmount());
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
    protected $rules = [
        'client_id' => 'required',
        'desc' => 'required',
        'dates' => 'required',
    ];
     public function submitOrder(){
        $this->validate();
        
        DB::beginTransaction();
        try {
            $trx = new Transaction();
            $trx->trx       = $this->trx;
            $trx->client_id = $this->client_id;
            $trx->desc      = $this->desc;
            $trx->total     = $this->getFinnAmount();
            $trx->sub_total  = $this->subTotal();
            $trx->due_total = $this->getTotalDue();
            $trx->dates     = $this->dates;
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
            dd($th->getMessage());
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
