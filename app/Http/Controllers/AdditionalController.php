<?php

namespace App\Http\Controllers;

use App\Additional;
use Illuminate\Http\Request;

class AdditionalController extends Controller
{
    public function index(){
        $data['title'] ='Additional';
        $data['table'] = Additional::all();
        return view('admin.additional',$data);
    }
    public function save(Request $request){
        Additional::create([
            'name' => $request->name,
            'percent' => $request->percent,
            'type'    => $request->type == "1" ? true:false
        ]);

        return redirect()->back()->with('success','New Additional Save!');      
    }
    public function update(Request $request,$id)
    {
        Additional::find($id)->update([
            'name' => $request->name,
            'percent' => $request->percent,
            'type'    => $request->type == "1" ? true:false
        ]);
        return redirect()->back()->with('success','Additional Updated!');      
    }
    public function delete($id)
    {
        Additional::find($id)->delete();
        return redirect()->back()->with('success','Additional Updated!');      

    }
}
