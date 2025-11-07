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
use App\Models\Test;
use App\Models\Employee;
use App\Models\SalesItem;
use App\Models\SalesLedger;
use App\Models\SalesStockIn;
use App\Models\User;

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
use App\Models\Account\ChartOfAccounts;
use App\Traits\ChartOfAccount;

class DamageController extends Controller
{
  use ChartOfAccount;
    public function index()
    {
        $id = Auth::id();
        // dd($emp_id[0]->id);
        $authid = $id = Auth::id();
        $dealerid = DB::select('SELECT dealers.id as did FROM dealers
        WHERE dealers.user_id ="' . $authid . '" ');
        // dd($dealerid[0]->did);
        // if(Auth::user()->user_role->role_id==1)
        // {
        $damagelist = DB::select('SELECT sales_damages.*,sales_products.product_name,factories.factory_name FROM `sales_damages`
                      LEFT JOIN sales_products ON sales_products.id = sales_damages.product_id
                      LEFT JOIN factories ON factories.id = sales_damages.warehouse_id
                      order by  date desc,invoice desc');
        // dd($returnslist);

        return view('backend.sales_damage.index', compact('damagelist'));
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
              $temp = 10000 + $in->id;
            	$invoice = 'D-'.$temp;
            }else{
            	$invoice = 'D-10000';
            }
            $totalAmount = 0;
        foreach ($request->product_id as $key => $product) {
                  $product_rate = DB::table('sales_products')->where('id', $product)->first();
                  $stockPro = SalesStockIn::where('prouct_id',$product)->orderBy('id','DESC')->first();

                  if($stockPro){
                    $tempQty = $stockPro->quantity;
                    $tempAmount = $stockPro->total_cost;
                    if($product_rate->rate){
                      $tempAmount += $product_rate->rate*$request->product_qty[$key];
                      $tempQty += $request->product_qty[$key];
                      $rate = round($tempAmount/$tempQty,2);
                      $amount = round($rate*$request->product_qty[$key],2);
                    } else {
                      $amount = round($stockPro->production_rate*$request->product_qty[$key],2);
                      $rate = $stockPro->production_rate;
                    }
                  } else {
                    $amount = round($product_rate->rate*$request->product_qty[$key],2);
                    $rate = $product_rate->rate;
                  }

                  $totalAmount += $amount;

                 $damage = new SalesDamage();
                 $damage->date = $request->date;
                 $damage->invoice = $invoice;
                 $damage->warehouse_id = $request->warehouse_id;
                 $damage->product_id = $product;
                 $damage->category_id = $product_rate->category_id;
                 $damage->rate=$rate;
                 $damage->quantity = $request->product_qty[$key];
                 $damage->amount = $amount;
                 $damage->save();
            }

            $this->createCreditForRawMaterials('Finished Goods' , $totalAmount , $request->date, $des = 'Damage F G', $invoice);
            $this->debitJournalForDelaer('Retained Earning' , $totalAmount, $request->date , $des = 'Damage F G', $invoice);


        return redirect()->route('sales.damage.index')->with('success', 'Damage Create  Successfull.');
    }



    public function damageedit($id)
    {
        $salesProducts = SalesProduct::orderBy('product_name', 'ASC')->get();
        $factoryes = Factory::latest('id')->get();
        $damage = SalesDamage::where('id',$id)->first();
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
    
    public function damageInvoiceView($id)
    {
        $damage = SalesDamage::leftJoin('sales_products', 'sales_damages.product_id', '=', 'sales_products.id')->where('sales_damages.id',$id)->select('sales_damages.*', 'sales_products.product_name')->first();
        return view('backend.sales_damage.invoice', compact('damage'));
    }

    public function damageDelete(Request $request){
        //dd($request->all());
        $uid = Auth::id();
        $damage = SalesDamage::where('id', $request->id)->first();

        ChartOfAccounts::where('invoice',$damage->invoice)->delete();
        SalesDamage::where('id', $request->id)->delete();
        return redirect()->back()->with('success', 'Damage Delete Successfull.');
    }
}
