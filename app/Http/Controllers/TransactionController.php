<?php

namespace App\Http\Controllers;

use App\Transaction;
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
        $data['trx'] = Transaction::with('getClient','getAdditional','getDetails','getDetails.getProduct','getDetailList')->find($id);
        $data['title'] = 'INV: '. $data['trx']->trx;
        return view('print.invoice',$data);
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
