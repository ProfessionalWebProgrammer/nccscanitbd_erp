<?php

namespace App\Http\Controllers\Sales;

use Auth;


use Session;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Dealer;
use App\Models\Factory;
// use App\Models\Dealer_demand;
// use App\Models\Ddl_check_out;
// use App\Models\Transaction;
use App\Models\Employee;
use App\Models\SalesItem;
use App\Models\SalesLedger;

use App\Models\SalesReturn;
use App\Models\SalesProduct;
// use App\Models\Batch;
// use App\Models\DeliveryConfirm;
// use App\Models\Vehicle;
use Illuminate\Http\Request;
// use App\Models\User;
use App\Models\Demand_number;
use App\Models\SalesReturnItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SalesDamage;
use App\Models\SalesCategory;
use App\Models\YearlyIncentive;
use App\Models\CommissionIn;

class IncentiveController extends Controller
{
    public function montly()
    {

      $montlyins = CommissionIn::get();
      $categories = SalesCategory::whereNotIn('id',[31,32])->get();
      //dd($montlyins);
      return view('backend.sales_incentive.monthly_incentive', compact('montlyins','categories'));
    }

    public function montlystore(Request $request)
    {
    	//dd($request->all());
      	$incentivedata = new  CommissionIn();
      	$incentivedata->category_id = $request->category_id;
        $incentivedata->target_amount = $request->min_target;
        $incentivedata->max_target_amount = $request->max_target;
        $incentivedata->achive_commision = $request->achive_commission;
        $incentivedata->description = $request->description;
      	$incentivedata->save();
      return redirect()->back()->with('success','New Monthly Incentive Set Successfully!');
    }

  	public function editmonthlyincentive($id)
    {
      $monthlyedit = CommissionIn::where('id', $id)->first();
      $categories = SalesCategory::whereNotIn('id',[31,32])->get();
      return view('backend.sales_incentive.edit_monthly_incentive',compact('monthlyedit','categories'));
    }

  	public function updatemincentive(Request $request)
    {
    	//dd($request->all());

      	$incentivedata = CommissionIn::where('id',$request->id)->first();
      	$incentivedata->category_id = $request->category_id;
        $incentivedata->target_amount = $request->min_target;
        $incentivedata->max_target_amount = $request->max_target;
        $incentivedata->achive_commision = $request->achive_commission;
        $incentivedata->description = $request->description;
      	$incentivedata->save();
      return redirect()->route('sales.monthly.incentive')->with('success',' Monthly Incentive Update Successfully!');
    }

	public function deletemonthlyincentive(Request $request)
    {
      CommissionIn::where('id',$request->id)->delete();
      return redirect()->back()->with('success',' Monthly Incentive Deleted Successfully!');
    }

	public function yearly()
    {

      $yearlyincentives = YearlyIncentive::get();
      $categories = SalesCategory::whereNotIn('id',[31,32])->get();
      //dd($montlyins);
      return view('backend.sales_incentive.yearly_incentive', compact('yearlyincentives','categories'));
    }

  	public function edityearlyincentive($id)
    {
    	//dd($id)
        $yearlyedit = YearlyIncentive::where('id',$id)->first();
      	$categories = SalesCategory::whereNotIn('id',[31,32])->get();
        return view('backend.sales_incentive.yearly_incentive_edit',compact('yearlyedit','categories'));
    }

  	public function yearlyincentiveupdate(Request $request)
    {
    	//dd($request->all());

      	$incentivedata = YearlyIncentive::where('id',$request->id)->first();
      	$incentivedata->category_id = $request->category_id;
      	$incentivedata->title = $request->type_title;
        $incentivedata->min_target_amount = $request->min_target;
        $incentivedata->max_target_amount = $request->max_target;
        $incentivedata->incentive = $request->incentive;
        $incentivedata->description = $request->description;
      	$incentivedata->save();
      return redirect()->route('sales.yearly.incentive')->with('success','New Yearly Incentive Set Successfully!');
    }

    public function yearlystore(Request $request)
    {
    	//dd($request->all());
      	$incentivedata = new  YearlyIncentive();
        $incentivedata->category_id = $request->category_id;
      	$incentivedata->title = $request->type_title;
        $incentivedata->min_target_amount = $request->min_target;
        $incentivedata->max_target_amount = $request->max_target;
        $incentivedata->incentive = $request->incentive;
        $incentivedata->description = $request->description;
      	$incentivedata->save();
      return redirect()->back()->with('success','New Yearly Incentive Set Successfully!');
    }

  public function deleteyearlyincentive(Request $request)
    {
      YearlyIncentive::where('id',$request->id)->delete();
      return redirect()->back()->with('success','Yearly Incentive Deleted Successfully!');
    }

    public function damagecreate(Request $request)
    {

        $id = Auth::id();
        $dealerlogid = Dealer::latest('id')->where('user_id', '=', $id)->get();
        $salesProducts = SalesProduct::orderBy('product_name', 'ASC')->get();
        $dealers = Dealer::orderBy('d_s_name', 'ASC')->get();
        $employees = Employee::latest('id')->get();
        $factoryes = Factory::latest('id')->get();
        // $vehicles = Vehicle::all();
        $vehicles = '';

        return view('backend.sales_damage.create', compact('salesProducts', 'factoryes', 'dealers', 'dealerlogid', 'employees', 'vehicles'));
    }



    public function damagegenerate(Request $request)
    {
        //dd($request->all());

        $in = SalesDamage::latest('id')->first();
            if($in){
            	$invoice = 10000 + $in->id + 1;
            }else{
            	$invoice = 10000;
            }
        foreach ($request->product_id as $key => $product) {
            $product_rate = DB::table('sales_products')->where('id', $product)->first();
            $p_rate = $product_rate->product_dp_price;
            $p_value = $product_rate->product_dp_price*$request->product_qty[$key];

               $damage = new SalesDamage();
                $damage->date=$request->date;
                $damage->invoice_no=$invoice;
                $damage->warehouse_id=$request->warehouse_id;
                 $damage->product_id=$product;
              // $damage->rate=$p_rate;
                $damage->quantity=$request->product_qty[$key];
                $damage->save();

            }

        return redirect()->route('sales.damage.index')->with('success', 'Damage Create  Successfull.');
    }




    public function damageedit($id)
    {
        $salesProducts = SalesProduct::orderBy('product_name', 'ASC')->get();
        $factoryes = Factory::latest('id')->get();

        $damage = SalesDamage::where('id',$id)->first();

       // dd( $id);
        return view('backend.sales_damage.edit', compact('salesProducts', 'factoryes','damage'));
    }


    public function damageupdate(Request $request)
    {
       //  dd($request->all());
         $product_rate = DB::table('sales_products')->where('id', $request->product_id)->first();
         $p_rate = $product_rate->product_dp_price;
         $p_value = $product_rate->product_dp_price*$request->product_qty;

            $damage = SalesDamage::where('id',$request->id)->first();
             $damage->date=$request->date;
             $damage->warehouse_id=$request->warehouse_id;
              $damage->product_id=$request->product_id;
           // $damage->rate=$p_rate;
             $damage->quantity=$request->product_qty;
             $damage->save();
             return redirect()->route('sales.damage.index')->with('success', 'Damage Update  Successfull.');;
        // ->with('success','Product Sales Successfull');

    }

    public function damageDelete(Request $request){
        //dd($request->all());

        $uid = Auth::id();

        SalesDamage::where('id', $request->id)->delete();
        return redirect()->back()->with('success', 'Damage Delete Successfull.');
    }

	public function daily(){
    $products = DB::table('sales_products')->select('id','product_name')->get();
    //$products = DB::table('sales_products')->select('id','product_name','category_id')->WhereNotNull('category_id')->get();
    $data = DB::table('product_commissions')->get();
    return view('backend.sales_incentive.daily_incentive', compact('products','data'));
    }
    public function  dailyStore(Request $request){
    //dd($request->all());
      $cat = DB::table('sales_products')->where('id', $request->product_id)->value('category_id');


      DB::table('product_commissions')->insert([
      'product_id' => $request->product_id,
      'category_id' => $cat,
      'min_target' => $request->min_target,
      'max_target' => $request->max_target,
      'achive_commision' => $request->achive_commission,
      'description' => $request->description,
      ]);

      return redirect()->back()->with('success','New Daily Incentive Set Successfully!');
    }
  public function editDailyIncentive($id){

  	$data = DB::table('product_commissions')->where('id', $id)->first();
    $products = DB::table('sales_products')->select('id','product_name','category_id')->WhereNotNull('category_id')->get();
    //dd($data);
     return view('backend.sales_incentive.edit_daily_incentive',compact('data','products'));
  }
  public function updateIncentive(Request $request){
    //dd($request->all());
    $cat = DB::table('sales_products')->where('id', $request->product_id)->value('category_id');

    DB::table('product_commissions')->where('id',$request->id)->update(
      [
       'product_id' => $request->product_id,
      'category_id' => $cat,
      'min_target' => $request->min_target,
      'max_target' => $request->max_target,
      'achive_commision' => $request->achive_commision,
      'description' => $request->description,
      ]);
    return redirect()->route('sales.daily.incentive')->with('success', 'Daily Incentive Update Successfully');
  }

  public function deleteDailyIncentive(Request $request)
    {
    //dd($request->id);
      DB::table('product_commissions')->where('id',$request->id)->delete();
      return redirect()->back()->with('success',' Daily Incentive Deleted Successfully!');
    }

}
