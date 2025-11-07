<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Margin;
use DB;

class SatMarginController extends Controller
{
   
    
    public function index()
    {
        
        $categorys = Margin::where('head','Sales')->get();

        return view('backend.sales.set_margin',compact('categorys'));
    }

    
   
   
    public function store(Request $request)
    {
        // dd($request);
        
        $categorys = new Margin();
        $categorys->head = "Sales";
        $categorys->amount = $request->amount;
        // dd($categorys);
        $categorys->save();
        return redirect()->route('sales.set_margin.index')->with('success','Margin Add Successful');
    }

    public function destroy(Request $request)
    {
      //dd($request->all());
        Margin::where('id',$request->id)->delete();
        return redirect()->route('sales.set_margin.index')
                        ->with('delete', 'Margin Delete  successfully .');
    }
  
  
  
  
    
    public function purchaseindex()
    {
        
        $categorys = Margin::where('head','Purchase')->get();

        return view('backend.purchase.set_margin',compact('categorys'));
    }

    
   
   
    public function purchasestore(Request $request)
    {
        // dd($request);
        
        $categorys = new Margin();
        $categorys->head = "Purchase";
        $categorys->amount = $request->amount;
        // dd($categorys);
        $categorys->save();
        return redirect()->route('purchase.set_margin.index')->with('success','Margin Add Successful');
    }

    public function purchasedestroy(Request $request)
    {
      //dd($request->all());
        Margin::where('id',$request->id)->delete();
        return redirect()->route('purchase.set_margin.index')
                        ->with('delete', 'Margin Delete  successfully .');
    }
  
  
  
  
  
    public function expanseindex()
    {
        
        $categorys = Margin::where('head','Expanse')->get();

        return view('backend.payment.expanse_set_margin',compact('categorys'));
    }

    
   
   
    public function expansestore(Request $request)
    {
        // dd($request);
        
        $categorys = new Margin();
        $categorys->head = "Expanse";
        $categorys->amount = $request->amount;
        // dd($categorys);
        $categorys->save();
        return redirect()->route('expanse.set_margin.index')->with('success','Margin Add Successful');
    }

    public function expansedestroy(Request $request)
    {
      //dd($request->all());
        Margin::where('id',$request->id)->delete();
        return redirect()->route('expanse.set_margin.index')
                        ->with('delete', 'Margin Delete  successfully .');
    }
  
}
