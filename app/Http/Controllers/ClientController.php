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
        $client->company_name = $request->company_name;
        $client->name = $request->name;
        $client->position = $request->position;
        $client->company_address = $request->company_address;
        $client->save();
        return redirect()->back()->with('success','New Client Created');
    }
    public function update(Request $request,$id){
        $client = Client::find($id);
        $client->company_name = $request->company_name;
        $client->name = $request->name;
        $client->position = $request->position;
        $client->company_address = $request->company_address;
        $client->save();
        return redirect()->back()->with('success','Client Updated Successfully');
    }
}
