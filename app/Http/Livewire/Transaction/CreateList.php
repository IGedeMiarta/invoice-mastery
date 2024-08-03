<?php

namespace App\Http\Livewire\Transaction;

use App\Additional;
use App\Client;
use App\Transaction;
use App\TransactionAdditional;
use App\TransactionDetailList;
use Illuminate\Http\Request;
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
    public $modelEdit;

    public function mount(Request $request){
        $this->client = Client::all();
        $this->trx = trx();
        $this->additional == null ? false:true;
        $this->additionalModel = Additional::where('status',1)->get();

        if ($request->edit) {
            $this->setEdit($request->edit);
        }
    }

    private function setEdit($id){
        $trx = Transaction::find($id);
        $trx_detail = TransactionDetailList::where('trx_id',$trx->id)->get();
        $trx_add    = TransactionAdditional::where('trx_id',$trx->id)->get();

        $this->sub_total = num($trx->sub_total);
        $this->total_due = num($trx->due_total);
        $this->trx = $trx->trx;
        $this->client_id = $trx->client_id;
        $this->desc = $trx->desc;
        $this->dates = $trx->dates;

        foreach ($trx_detail as $key => $detail) {
           $this->table[] = [
                'id'    => $detail->id,
                'date' => $detail->date,
                'start' => $detail->start,
                'end' => $detail->end,
                'who' => $detail->who,
                'description' => $detail->description,
                'cost' => num($detail->cost)
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
        $this->modelEdit = $trx;
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
    private function addTable(){
        
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
    private function addAditional(){
        $this->additional = true;
        $this->refreshTable();
        $this->subtotal = num($this->subTotal());
        $this->add_name = null;
        $this->add_prercent = null;
    }
    private function refreshTable(){
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
    private function getFinnAmount(){
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
    private function subTotal(){
        return $this->change?getAmount($this->sub_total):bulatkan($this->getFinnAmount());
    }
    private function getTotalDue(){
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
            if ($this->modelEdit) {
                $this->editTrx();
                $msg = 'Invoice Updated';
            }else{
                $this->createTrx();
                $msg = 'Invoice Created';
            }

            DB::commit();
            return redirect()->route('transaction.all')->with('success',$msg);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            $this->emit('error',$th->getMessage());
        }
    }

    private function editTrx(){
        $trx = $this->modelEdit;
        $trx->trx       = $this->trx;
        $trx->client_id = $this->client_id;
        $trx->desc      = $this->desc;
        $trx->total     = $this->getFinnAmount();
        $trx->sub_total = $this->subTotal();
        $trx->due_total = $this->getTotalDue();
        $trx->dates     = $this->dates;
        $trx->save();

        $existingDetailIds = TransactionDetailList::where('trx_id', $trx->id)->pluck('id')->toArray();
        $newDetailIds = [];

        foreach ($this->table as $item) {
            if (isset($item['id'])) {
                // Update existing detail
                $detail = TransactionDetailList::find($item['id']);
                $detail->date   = $item['date'];
                $detail->start   = $item['start'];
                $detail->end   = $item['end'];
                $detail->who   = $item['who'];
                $detail->description   = $item['description'];
                $detail->cost   = getAmount($item['cost']);
                $detail->save();
                
                $newDetailIds[] = $item['id'];
            } else {
                // Insert new detail
                $detail = new TransactionDetailList();
                $detail->trx_id = $trx->id;
                $detail->date   = $item['date'];
                $detail->start   = $item['start'];
                $detail->end   = $item['end'];
                $detail->who   = $item['who'];
                $detail->description   = $item['description'];
                $detail->cost   = getAmount($item['cost']);
                $detail->save();
                
                $newDetailIds[] = $detail->id; // Ensure new inserted IDs are tracked
            }
        }
        // Delete any details that were not included in the new data
        $detailsToDelete = array_diff($existingDetailIds, $newDetailIds);
        TransactionDetailList::whereIn('id', $detailsToDelete)->delete();


        
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

    private function createTrx(){
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
        return view('livewire.transaction.create-list');
    }
}
