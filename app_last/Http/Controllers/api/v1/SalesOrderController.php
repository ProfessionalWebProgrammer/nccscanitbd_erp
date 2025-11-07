<?php

namespace App\Http\Controllers\api\v1;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Models\Factory;
use App\Models\Employee;
use App\Models\Sale;
use App\Models\SalesItem;
use App\Models\SalesProduct;
use App\Models\Demand_number;
use App\Models\CommissionIn;
use App\Models\SalesOrderItem;
use App\Models\SalesOrder;
use App\Models\Ctc;
use Carbon\Carbon;
use Auth;
use DB;

class SalesOrderController extends Controller
{
    public function allSalesOrder(){
      $data = DB::select('SELECT sales_orders.*,users.name,dealers.d_s_name,factories.factory_name,(select name from users where id=updated_by) as updated_by_name FROM `sales_orders`
      LEFT JOIN dealers ON dealers.id = sales_orders.dealer_id
      LEFT JOIN factories ON factories.id = sales_orders.warehouse_id
      LEFT JOIN users ON users.id = sales_orders.emp_id
      WHERE is_active=1
      order by  date desc,invoice_no desc LIMIT 5000');
      if($data){
            return response()->json(['allSalesOrder'=>$data,'status'=>201]);
        }
        else
        {
            return response()->json(['res'=>'Data Not Found','status'=>404]);
        }
    }

  public function empAllSalesOrder($id){
    /*
    $data = DB::select('SELECT sales_orders.*,users.name,dealers.d_s_name,factories.factory_name,(select name from users where id=updated_by) as updated_by_name FROM `sales_orders`
      LEFT JOIN dealers ON dealers.id = sales_orders.dealer_id
      LEFT JOIN factories ON factories.id = sales_orders.warehouse_id
       LEFT JOIN users ON users.id = sales_orders.emp_id
      where sales_orders.emp_id = $id
      WHERE is_active=1
      order by  date desc,invoice_no desc LIMIT 5000');
      */

    $data = SalesOrder::select('sales_orders.id', 'sales_orders.order_status', 'sales_orders.date', 'sales_orders.emp_id', 'sales_orders.updated_by', 'sales_orders.invoice_no', 'sales_orders.total_qty', 'sales_orders.grand_total', 'sales_orders.narration', 'users.name', 'dealers.d_s_name','factories.factory_name')
      		->leftjoin('dealers', 'sales_orders.dealer_id', '=', 'dealers.id')
           ->leftjoin('factories', 'sales_orders.warehouse_id', '=', 'factories.id')
           ->leftjoin('users', 'sales_orders.emp_id', '=', 'users.id')
      		->where('is_active',1)->where('sales_orders.emp_id', $id)->orderBy('sales_orders.date', 'desc')->take(500)->get();

      if($data){
            return response()->json(['empAllSalesOrder'=>$data,'status'=>201]);
        }
        else
        {
            return response()->json(['res'=>'Data Not Found','status'=>404]);
        }
    }


    public function getSalesProducts(){
      $data = SalesProduct::orderBy('product_name', 'ASC')->get();
      if($data){
            return response()->json(['allProducts'=>$data,'status'=>201]);
        }
        else
        {
            return response()->json(['res'=>'Data Not Found','status'=>404]);
        }
    }


    public function salesInvoiceView($invoice){
      $data = Sale::select('sales.*', 'dealers.d_s_name', 'factories.factory_name')
          ->leftjoin('dealers', 'sales.dealer_id', '=', 'dealers.id')
          ->leftjoin('factories', 'sales.warehouse_id', '=', 'factories.id')
          ->where('invoice_no', $invoice)
          ->first();
          if($data){
                return response()->json(['salesInvoice'=>$data,'status'=>201]);
            }
            else
            {
                return response()->json(['res'=>'Data Not Found','status'=>404]);
            }
    }

    public function salesInvoiceDetailsView($invoice){
      $data = SalesItem::select('sales_items.*', 'sales_products.product_name')
          ->leftjoin('sales_products', 'sales_items.product_id', '=', 'sales_products.id')
          ->where('invoice_no', $invoice)
          ->get();
          if($data){
                return response()->json(['salesInvoicedetails'=>$data,'status'=>201]);
            }
            else
            {
                return response()->json(['res'=>'Data Not Found','status'=>404]);
            }
    }

    public function add(){
      return ["result" => "Done"];
    }
    /*
    store sales data
    */
    public function storeSalesOrder(Request $request){
        
      $cyear = date('Y');
      $cmonth = date('m');
      $id = Auth::id();

      //$userName = DB::select('select users.name from users where users.id="' . $id . '"');
      if ($request->tdate) {
          $date_f = $request->tdate;
          //$date_put = $request->session()->put('my_date', $date_f);
      } else {
          $date_f = date('Y-m-d');
      }
      if ($request->warehouse_id) {
          $wr_id = $request->warehouse_id;
          //$wr_id_put = $request->session()->put('wr_id', $wr_id);
      }


      $demandInvoNumber = new Demand_number();
      $demandInvoNumber->total_qty = $request->grand_total_qty;
      $demandInvoNumber->user_id = $id;
      $demandInvoNumber->save();

      $factories = Factory::find($request->warehouse_id);

      $delaer_area_id = DB::table('dealers')->where('id', $request->dealer_id)->value('dlr_area_id');
      $delaer_area_name = DB::table('dealer_areas')->where('id', $delaer_area_id)->value('area_title');

      $dealerdata = Dealer::where('id', $request->dealer_id)->first();

      $sale = new SalesOrder();
      $sale->item_type = 'fg';
      $sale->date = $date_f;
	  $sale->emp_id = $request->emp_id;
      $sale->warehouse_id = $request->warehouse_id;
      $sale->dealer_id = $request->dealer_id;
      $sale->vendor_area_id = $delaer_area_id;
      $sale->vendor_area =  $delaer_area_name;
      $sale->invoice_no = 'Sal-'.$demandInvoNumber->id;
      $sale->total_qty = $request->grand_total_qty;
      $sale->price = $request->grand_total_value;
      //$sale->discount = $request->grand_total_discount;
      $sale->grand_total = $request->total_payable;
      //$sale->user_id = Auth::user()->id;
      $sale->narration = $request->narration;
      $sale->demand_month = $cmonth;
      $sale->demand_year = $cyear;
      $sale->save();

	foreach ($request->product_id as $key => $item){
          $product = SalesProduct::find($item);
              if(!empty($product->product_weight)){
              	$qtykg = $product->product_weight * $request->p_qty[$key];
                } else {
                 $qtykg = 0;
                }

          $sale_item = new SalesOrderItem();
          $sale_item->date = $date_f;
          $sale_item->dealer_id = $request->dealer_id;
          $sale_item->area_id = $delaer_area_id;
          $sale_item->invoice_no = 'Sal-'.$demandInvoNumber->id;
          $sale_item->item_type = 'fg';
          $sale_item->product_id = $item;
          $sale_item->product_name = $product->product_name;
          $sale_item->product_code = $product->product_code;
          $sale_item->product_weight = $product->product_weight;
          $sale_item->qty = $request->p_qty[$key];
          $sale_item->unit_price = $request->p_price[$key];
      	  $sale_item->total_price = $request->total_price_without_discount[$key];
          $sale_item->save();

          $data = Ctc::where('invoice_no',$demandInvoNumber->id)->where('category_id',$product->category_id)->first();
        //  dd($data);
          if(!empty($data)){
            $data->qty = $request->p_qty[$key] + $data->qty;
            $data->product_weight = $product->product_weight;
            $data->ton = (($request->p_qty[$key] * $product->product_weight)/1000)+$data->ton;
            $data->save();

          } else {
            $ctc = new Ctc();
            $ctc->date = $date_f;
            $ctc->dealer_id = $request->dealer_id;
            $ctc->sale_id = $sale_item->id;
            $ctc->invoice_no = $demandInvoNumber->id;
            $ctc->category_id = $product->category_id;
            $ctc->qty = $request->p_qty[$key];
            $ctc->product_weight = $product->product_weight;
            $ctc->ton = ($request->p_qty[$key] * $product->product_weight)/1000;
            $ctc->save();
          }
        }

      if($sale->save()){
            return response()->json(['success'=>'Sales Order Created Successfull','status'=>201]);
        }
        else
        {
            return response()->json(['res'=>'Data Not Store','status'=>404]);
        }

    }

    public function searchInvoice(Request $request){

      $saleslist = DB::select('SELECT sales.*,users.name,dealers.d_s_name,factories.factory_name,(select name from users where id=updated_by) as updated_by_name FROM `sales`
      LEFT JOIN dealers ON dealers.id = sales.dealer_id
      LEFT JOIN factories ON factories.id = sales.warehouse_id
      LEFT JOIN users ON users.id = sales.emp_id
      WHERE is_active=1 AND sales.date BETWEEN "'.$request->fdate.'" AND "'.$request->tdate.'"
      order by  date desc,invoice_no desc LIMIT 2000');
      return $saleslist;
    }
}
