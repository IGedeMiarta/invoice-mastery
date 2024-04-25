<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
class TranactionController extends Controller
{
    public function index(){
        $data['title'] = 'Create Transaction';
        return view('admin.transaction',$data);
    }

    public function all(){
        $data['title'] = 'All Transaction';
        $data['table'] = Transaction::with('getClient')->latest()->get();
        return view('admin.alltransaction',$data);
    }
    
    public function inv($id){
        // $data['title'] = 
        $data['trx'] = Transaction::find($id);
        $data['title'] = 'INV: '. $data['trx']->trx;
        return view('print.invoice',$data);
        // $dompdf = new Dompdf();
        // $dompdf->loadHtml(view('print.invoice',$data)->render());
        // $dompdf->render();
        // return $dompdf->stream('document.pdf');
        // $pdf = PDF::loadview('print.invoice',$data)->setPaper('A4','potrait');
        //     return $pdf->stream();

        // $pdf = Pdf::loadView('print.invoice', $data);
        // return $pdf->download('invoice.pdf');
    }
}
