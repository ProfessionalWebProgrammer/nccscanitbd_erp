<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DealerType;

class DealerTypeController extends Controller
{
    public function getCreate()
    {
        $dealertype = DealerType::orderBy('id','desc')->get();
        return view('backend.dealer.dealer_type_create')->with('dealertype',$dealertype);
    }
  	public function deletedealertype(Request $request)
    {
      //dd($request->all());
      DealerType::where('id',$request->id)->delete();
      return redirect()->back()->with('success', 'Dealer type Deleted  successfully .');
    }

    public function postCreate(Request $request)
    {
        // dd($request);
        $dealerType = new DealerType;
        $dealerType->type_title = $request->type_title;
        $dealerType->type_description = $request->type_description;
        // dd($dealerType);
        $dealerType->save();
        return redirect()->route('dealer.type.create')
                        ->with('success', 'Dealer type Create  successfully .');
    }

    public function getedit($id)
    {
        $dealertype = DealerType::where('id',$id)->first();
        return view('backend.dealer.dealer_type_edit')->with('dealertype',$dealertype);
    }

    public function update(Request $request)
    {  
        // dd($request);
        // DealerType::findOrFail($request->id)->update($request->all());
        $dealerType = DealerType::find($request->id);
        $dealerType->type_title = $request->type_title;
        $dealerType->type_description = $request->type_description;
        // dd($dealerType);
        $dealerType->save();
        return redirect()->route('dealer.type.create')
                        ->with('success', 'Dealer type Update  successfully .');
    }

    public function destroy(Request $request, $id)
    {
        DealerType::findOrFail($request->id)->Delete($request->all());
        return redirect()->route('dealer.type.create')
                        ->with('delete', 'Dealer Type Delete  Successfully .');
    }
}
