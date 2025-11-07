<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Models\OthersType;
use App\Models\Dealer;

class OthersController extends Controller
{
    
    public function othersTypeindex()
    {
        $otherstypes = OthersType::all();
        return view('backend.others.otherstype',compact('otherstypes'));
    }

    public function othersTypestor(Request $request)
    {
        // dd($request);
        $OthersType = new OthersType;
        $OthersType->name = $request->name;
        $OthersType->description = $request->description;
        $OthersType->save();
        return redirect()->back()
                        ->with('success', 'Others type Create  successfully .');
    }

	public function othersTypedelete(Request $request)
    {
      	OthersType::where('id',$request->id)->delete();
        return redirect()->back()->with('success', 'Others type Deleted  successfully .');
    }
  
   public function specialrateIndex()
    {
        $specialrate = DB::table('special_rates')->get();
     $dealers = Dealer::all();
        return view('backend.others.special_rate',compact('specialrate','dealers'));
    }

    public function specialrateStore(Request $request)
    {
        // dd($request);
         DB::table('special_rates')->insert([
         'dealer_id' => $request->dealer_id,
         'rate_kg' => $request->rate
         ]);
        return redirect()->back()
                        ->with('success', 'Special Rate Create  successfully .');
    }

	public function specialrateDelete(Request $request)
    {
      	DB::table('special_rates')->where('id',$request->id)->delete();
        return redirect()->back()->with('success', 'Special Rate Deleted  successfully .');
    }
}
