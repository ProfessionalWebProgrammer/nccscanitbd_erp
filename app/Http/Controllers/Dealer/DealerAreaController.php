<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\DealerArea;
use App\Models\DealerSubzone;
use DB;

class DealerAreaController extends Controller
{
    public function getCreate()
    {

        $dealerarea = DealerArea::orderBy('id','desc')->get();
        $dealersubzone = DealerSubzone::orderBy('id','desc')->get();
        return view('backend.dealer.dealer_area',compact('dealerarea','dealersubzone'));
    }

    public function postCreate(Request $request)
    {
         //dd($request->all());
        $dealerArea = new DealerArea;
        $dealerArea->subzone_id = $request->subzone_id;
        $dealerArea->area_title = $request->area_title;
        $dealerArea->area_description = $request->area_description;
        // dd($dealerArea);
        $dealerArea->save();
        return redirect()->route('dealer.area.create')
                        ->with('success', 'Dealer Area Create  successfully .');
    }
    public function edit($id)
    {

        $dealerarea = DealerArea::where('id',$id)->first();
        $dealersubzone = DealerSubzone::orderBy('id','desc')->get();
        return view('backend.dealer.dealer_area_edit',compact('dealerarea','dealersubzone'));
    }

    public function update(Request $request)
    {
        // dd($request);
        // DealerType::findOrFail($request->id)->update($request->all());
        $dealerArea = DealerArea::find($request->id);
        $dealerArea->subzone_id = $request->subzone_id;
        $dealerArea->area_title = $request->area_title;
        $dealerArea->area_description = $request->area_description;
        // dd($dealerType);
        $dealerArea->save();

        DB::table('dealers')->where('dlr_area_id',$request->id)->update(['dlr_subzone_id' => $request->subzone_id]);
        DB::table('montly_sales_targets')->where('area_id',$request->id)->update(['subzone_id' => $request->subzone_id]);

        return redirect()->route('dealer.area.create')
                        ->with('success', 'Dealer Area Update  successfully .');
    }

    public function destroy(Request $request)
    {
      //dd($request->all());
        DealerArea::where('id',$request->id)->delete();
        return redirect()->route('dealer.area.create')
                        ->with('success', 'Dealer Area Delete  Successfully .');
    }
}
