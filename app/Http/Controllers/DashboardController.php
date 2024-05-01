<?php

namespace App\Http\Controllers;

use App\Client;
use App\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data['title'] = 'Dashboard';
        $data['client'] = Client::count();
        $data['trx'] = Transaction::count();
        $data['due'] = Transaction::sum('due_total');
        return view('dashboard',$data);
    }
}
