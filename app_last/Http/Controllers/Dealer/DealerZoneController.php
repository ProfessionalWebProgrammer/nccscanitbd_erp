<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DealerZone;

class DealerZoneController extends Controller
{
    public function getCreate()
    {
        $dealerzone = DealerZone::orderBy('id','desc')->get();
        return view('backend.dealer.delaer_zone')->with('dealerzone',$dealerzone);
    }

    public function postCreate(Request $request)
    {
        // dd($request);
        $dealerZone = new DealerZone;
        $dealerZone->zone_title = $request->zone_title;
        $dealerZone->main_zone = $request->main_zone;
        $dealerZone->zone_description = $request->zone_description;
        $dealerZone->save();
        return redirect()->route('dealer.zone.create')
                        ->with('success', 'Dealer zone Create  successfully .');
    }


    public function edit($id)
    {
        $dealerzone = DealerZone::where('id',$id)->first();
        return view('backend.dealer.delaer_zone_edit')->with('dealerzone',$dealerzone);
    }



    public function update(Request $request)
    {  
        // dd($request);
        // DealerType::findOrFail($request->id)->update($request->all());
        $dealerZone = DealerZone::find($request->id);
        $dealerZone->zone_title = $request->zone_title;
        $dealerZone->main_zone = $request->main_zone;
        $dealerZone->zone_description = $request->zone_description;
        // dd($dealerType);
        $dealerZone->save();
        return redirect()->route('dealer.zone.create')
                        ->with('success', 'Dealer zone Update  successfully .');
    }


    public function destroy(Request $request)
    {
        DealerZone::where('id',$request->id)->delete();
        return redirect()->route('dealer.zone.create')
                        ->with('delete', 'Dealer Zone Delete  Successfully .');
    }

}
