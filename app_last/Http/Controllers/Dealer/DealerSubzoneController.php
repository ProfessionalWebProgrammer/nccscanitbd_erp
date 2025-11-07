<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\DealerSubzone;
use App\Models\DealerZone;

class DealerSubzoneController extends Controller
{
    public function getCreate()
    {
        $dealersubzone = DealerSubzone::orderBy('id','desc')->get();
        $dealerzone = DealerZone::all();
        return view('backend.dealer.dealer_subzone',compact('dealersubzone','dealerzone'));
    }

    public function postCreate(Request $request)
    {
        // dd($request);
        $dealerSubZone = new DealerSubzone;
        
        $dealerSubZone->subzone_title = $request->subzone_title;
        $dealerSubZone->subzone_description = $request->subzone_description;
        $dealerSubZone->save();
        return redirect()->route('dealer.subzone.create')
                        ->with('success', 'Dealer Subzone Create  successfully .');
    }

    public function edit($id)
    {
        $dealersubzone = DealerSubzone::where('id',$id)->first();
        $dealerzone = DealerZone::all();
        return view('backend.dealer.dealer_subzone_edit',compact('dealersubzone','dealerzone'));
    }


    public function update(Request $request)
    {  
        
        $dealerSubZone = DealerSubzone::find($request->id);
        $dealerSubZone->subzone_title = $request->subzone_title;
        $dealerSubZone->subzone_description = $request->subzone_description;
        // dd($dealerType);
        $dealerSubZone->save();
        return redirect()->route('dealer.subzone.create')
                        ->with('success', 'Dealer Subzone Update  successfully .');
    }


    public function destroy(Request $request)
    {
      	//dd($request->all());
        DealerSubzone::where('id',$request->id)->delete();
        return redirect()->route('dealer.subzone.create')
                        ->with('success', 'Dealer Subzone Delete  Successfully!');
    }

}
