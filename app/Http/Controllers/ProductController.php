<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
   public function index(){
        $data['title'] = 'Service';
        $data['table'] = Product::latest()->get();
        return view('admin.product',$data);
    }
    public function post(Request $request){

        DB::beginTransaction();
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->percent = ($request->percent);
            $product->save();
            DB::commit();
            return redirect()->back()->with('success','New Product Save!');                      
       } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
       }
    }
    public function update(Request $request,$id){
       DB::beginTransaction();
       try {
            $product = Product::find($id);
            $product->name = $request->name;
            $product->percent = ($request->percent);
            $product->status = $request->status;
            $product->save();
            DB::commit();
            return redirect()->back()->with('success','Product Updated Successfully!');
       } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
       }
    }
    public function delete($id){
        dd($id);
    }
}
