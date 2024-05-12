<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\TransactionDetailList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TransactionController extends Controller
{
    public function index(){
        $data['title'] = 'Create Invoice';
        return view('admin.transaction',$data);
    }
    public function createTwo(){
        $data['title'] = 'Create Invoice II';
        return view('admin.transaction2',$data);
    }

    public function all(){
        $data['title'] = 'All Transaction';
        $data['table'] = Transaction::with('getClient')->latest()->get();
        return view('admin.alltransaction',$data);
    }
    
    public function inv($id){
        $trx = Transaction::find($id);
        $data['title'] = 'INV: '. $trx->trx;
        if ($trx->type == 1) {
            $data['trx'] = Transaction::with('getClient','getAdditional','getDetails','getDetails.getProduct','getDetailList')->find($id);
            return view('print.invoice',$data);
        }else{
            $data['trx'] = Transaction::with('getClient','getAdditional','getDetails','getDetails.getProduct','getDetailList')->find($id);

            $trx = TransactionDetailList::where('trx_id', $id)->get();  
            
            $list = [];
            $batchSize = 9;
            $totalRecords = $trx->count();
            $totalLists = ceil($totalRecords / $batchSize);

            // Memisahkan array pertama dan sisanya
            $firstBatchSize = 9;
            $firstBatch = $trx->take($firstBatchSize);
            $remainingBatch = $trx->slice($firstBatchSize);

            // Memasukkan array pertama ke dalam list
            $list[] = $firstBatch;

            // Memecah sisa rekaman menjadi batch
            $remainingRecords = $remainingBatch->count();
            $totalRemainingLists = ceil($remainingRecords / $batchSize);

            for ($i = 0; $i < $totalRemainingLists; $i++) {
                $start = $i * $batchSize;
                $end = min(($i + 1) * $batchSize, $remainingRecords);
                $list[] = $remainingBatch->slice($start, $end - $start);
            }
            $data['list']  = $list;
            return view('print.invoice2',$data);
        }
    }
    public function downloadExcel(){
        $file = public_path('upload/formatUpload.xlsx');
        // Check if the file exists
        if (file_exists($file)) {
            // Return the file as a response
            return Response::download($file, 'formatUpload.xlsx');
        } else {
            // Return a 404 response if the file doesn't exist
            abort(404);
        }
    }
}
