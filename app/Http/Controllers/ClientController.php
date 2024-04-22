<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(){
        $data['title'] = 'Client';
        $data['table'] = Client::all();
        return view('admin.client',$data);
    }
    public function post(Request $request){
        $client = new Client();
        $client->name = $request->name;
        $client->address = $request->address;
        $client->phone = $request->phone;
        $client->save();
        return redirect()->back()->with('success','New Client Created');
    }
    public function update(Request $request,$id){
        $client = Client::find($id);
        $client->name = $request->name;
        $client->address = $request->address;
        $client->phone = $request->phone;
        $client->save();
        return redirect()->back()->with('success','Client Updated Successfully');
    }
}
