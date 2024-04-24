<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;


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
}
