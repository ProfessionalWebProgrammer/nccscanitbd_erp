<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use App\Models\Product;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
   
    public function index()
    {
        $clients= Client::all();
        return view('backend.client.index', compact('clients'));
      
      
    }
    public function create()
    {
         return view('backend.client.create');
    }
    public function store(Request $request)
    {
         //dd($request->all());
        $products =  new Client();
        $products->client_name = $request->client_name;
        $products->company_name = $request->company_name;
        $products->phone = $request->phone;
        $products->email = $request->email;
        $products->address = $request->address;
        $products->designations = $request->designations;
        $products->contact_person = $request->contact_person;
        $products->contract_value = $request->contract_value;
        $products->time_duration = $request->time_duration;
        $products->save();
      

       
        return redirect()->route('client.index')->with('success', 'Product Create Successfully!');
    }

 
  
  
   
  
   public function destroy(Request $request)
    {

     	$delete = Client::where('id',$request->id)->delete();
		if($delete){
        		return redirect()->back()->with('success', 'Client Delete successfully.');
        }else{
        
        	return redirect()->back()->with('error', 'Something Wrong.');
        }
        


    }
  
  
}
