<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SalesProduct;
use App\Models\WeeklyProductionForcasting as WeeklyProduction;
use App\Models\WeeklyProductionForcastingDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonPeriod;
use Carbon\Carbon;

class WeeklyProductionForcasting extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data = WeeklyProduction::all();
      return view('backend.WeeklyProductionForcasting.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $products = SalesProduct::all();
      $suppliers = Supplier::all();
      return view('backend.WeeklyProductionForcasting.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //dd($request->all());

      if (isset($request->date)) {
          $dates = explode(' - ', $request->date);
          $fdate = date('Y-m-d', strtotime($dates[0]));
          $tdate = date('Y-m-d', strtotime($dates[1]));
      }
      $in = DB::table('weekly_production_forcastings')->latest('id')->first();
    //  $in = WeeklyProductionForcasting::latest('id')->first();

        if(!empty($in)){
          $temp = 10000 + $in->id;
          $invoice = 'Wpf-'.$temp;
        }
        else{
        	$invoice = 'Wpf-10001';
        }
        $wpf = new WeeklyProduction;
        $wpf->invoice = $invoice;
        $wpf->issue_date = date('Y-m-d');
        $wpf->f_date = $fdate;
        $wpf->t_date = $tdate;
        $wpf->supplier_id = $request->supplier_id;
        $wpf->note = $request->note;
        $wpf->total = $request->total;
        $wpf->save();
        if($wpf->save()){
          foreach($request->product_id as $key=> $data){
            $wpfs = new WeeklyProductionForcastingDetail;
             $wpfs->wpf_id = $wpf->id;
             $wpfs->product_id = $request->product_id[$key];
             //$wpfs->category_id = $request->category_id[$key];
             $wpfs->qty = $request->qty[$key];
             $wpfs->save();
          }
        }
        if($wpfs->save()){
          return redirect()->back()->with('success','Weekly Production Forcasting Order Create Successfull');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $data = WeeklyProduction::where('id', $id)->first();
      return view('backend.WeeklyProductionForcasting.invoice',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      //dd($request->id);
      $del = WeeklyProduction::where('id', $request->id)->delete();
      $delSub = WeeklyProductionForcastingDetail::where('wpf_id', $request->id)->delete();
      if($del && $delSub){
        return redirect()->route('wpf.list')->with('success', 'Weekly Production Forcasting Delete Successfully');
      }
    }
}
