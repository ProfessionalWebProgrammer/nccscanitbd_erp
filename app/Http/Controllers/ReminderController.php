<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\Rfq;
use App\Models\Cs;
use App\Models\Dealer;
use App\Models\NewReminder;
use App\Models\Supplier;
use App\Models\SalesCategory;
use App\Models\SalesProduct;
use App\Models\Purchase;
use App\Models\SalesItem;
use App\Models\RowMaterialsProduct;
use App\Models\MarketingOrderItem;

class ReminderController extends Controller
{
    public function remindercreate()
    {
      $dealers = Dealer::orderBy('d_s_name','asc')->get();
      return view('backend.reminder_create',compact('dealers'));
    }

  	public function submitreminder(Request $request)
    {
    	//dd($request->all());
      	$storereminder = new NewReminder();
      	$storereminder->date = $request->date;
      	$storereminder->subject = $request->subject;
      	$storereminder->vendor_id = $request->dlr_id;
      	$storereminder->created_by = Auth::id();
      	$storereminder->save();

      	return redirect()->back()->with('success','Reminder Set Successfully!');
    }

  	public function deletereminder($id)
    {
    	NewReminder::where('id',$id)->update(['status'=>0,'updated_by'=>Auth::id()]);
        return redirect()->back();
    }

    public function reminderarchivelist()
    {
      $datas = DB::table('new_reminders')
                    ->select('new_reminders.*', 'dealers.d_s_name','users.name')
                    ->leftJoin('dealers', 'new_reminders.vendor_id', '=', 'dealers.id')
                    ->leftJoin('users', 'new_reminders.updated_by', '=', 'users.id')
                  ->where('status',0)
                     ->get();

      $invoicenotification = DB::table('sales')
                 ->select('sales.*', 'dealers.d_s_name')
                    ->leftJoin('dealers', 'sales.dealer_id', '=', 'dealers.id')
         		     ->where('is_active', 1)
                    ->where('payment_status', 0)
                    ->whereNotNull('payment_date')
                    ->get();
     // dd($invoicenotification);
      return view('backend.notification_archive_list',compact('datas','invoicenotification'));
    }

  public function invoiceBillList(){
    $invoices = DB::table('invoice_bills')->where('status',1)->get();
    return view('backend.invoiceBillList', compact('invoices'));
  }

  public function invoiceBillCreate(){
    //dd('Invoice Bill Create');

  	return view('backend.invoiceBillCreate');
  }

  public function invoiceBillEdit($id){
    $val = DB::table('invoice_bills')->where('id',$id)->first();
  	return view('backend.invoiceBillEdit', compact('val'));
  }

  public function invoiceBillStore(Request $request){
    $in = DB::table('invoice_bills')->latest('id')->first();
        if ($in) {
            $invoice = 10000 + $in->id + 1;
        } else {
            $invoice = 10000;
        }

	DB::table('invoice_bills')->insert([
      'date' => $request->date,
      'invoice' => $invoice,
      'f_company' => $request->f_company,
      'f_address' => $request->f_address,
      'f_phone' => $request->f_phone,
      'f_email' => $request->f_email,
      'f_bankname' => $request->f_bankname,
      'f_account' => $request->f_account,
      'f_accountno' => $request->f_accountno,
      't_company' => $request->t_company,
      't_address' => $request->t_address,
      't_phone' => $request->t_phone,
      't_email' => $request->t_email,
      'p_name1' => $request->p_name1,
      'p_type1' => $request->p_type1,
      'p_rate1' => $request->p_rate1,
      'p_qty1' => $request->p_qty1,
      'p_amount1' => $request->p_amount1,
      'p_name2' => $request->p_name2,
      'p_type2' => $request->p_type2,
      'p_rate2' => $request->p_rate2,
      'p_qty2' => $request->p_qty2,
      'p_amount2' => $request->p_amount2,
      'p_total' => $request->p_total,
      'pay_total_bill' => $request->pay_total_bill,
      'pay_total_bill_remark' => $request->pay_total_bill_remark,
      'pay_advn_amount' => $request->pay_advn_amount,
      'pay_advn_amount_remark' => $request->pay_advn_amount_remark,
      'status' => 1,
             ]);
   return redirect()->route('invoiceBillList')->with('success', 'Invoice Bill Added Successfully');
  }


  public function invoiceBillUpdate(Request $request, $id){
    $invoice = DB::table('invoice_bills')->where('id', $id)->value('invoice');

	DB::table('invoice_bills')->update([
      'date' => $request->date,
      'invoice' => $invoice,
      'f_company' => $request->f_company,
      'f_address' => $request->f_address,
      'f_phone' => $request->f_phone,
      'f_email' => $request->f_email,
      'f_bankname' => $request->f_bankname,
      'f_account' => $request->f_account,
      'f_accountno' => $request->f_accountno,
      't_company' => $request->t_company,
      't_address' => $request->t_address,
      't_phone' => $request->t_phone,
      't_email' => $request->t_email,
      'p_name1' => $request->p_name1,
      'p_type1' => $request->p_type1,
      'p_rate1' => $request->p_rate1,
      'p_qty1' => $request->p_qty1,
      'p_amount1' => $request->p_amount1,
      'p_name2' => $request->p_name2,
      'p_type2' => $request->p_type2,
      'p_rate2' => $request->p_rate2,
      'p_qty2' => $request->p_qty2,
      'p_amount2' => $request->p_amount2,
      'p_total' => $request->p_total,
      'pay_total_bill' => $request->pay_total_bill,
      'pay_total_bill_remark' => $request->pay_total_bill_remark,
      'pay_advn_amount' => $request->pay_advn_amount,
      'pay_advn_amount_remark' => $request->pay_advn_amount_remark,
      'status' => 1,
             ]);
   return redirect()->route('invoiceBillList')->with('success', 'Invoice Bill Updated Successfully');
  }

  public function invoiceBillView($id){
  $data = DB::table('invoice_bills')->where('id',$id)->first();
  $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
        $amountInWords=$f->format($data->p_total ?? 0);

  	return view('backend.invoiceBillView', compact('data','amountInWords'));
  }

  public function invoiceBillDelete(Request $request){
    //dd('Delete');
  		DB::table('invoice_bills')->where('id',$request->id)->delete();
     	return redirect()->back()->with('success','Invoice Deleted Successfull');
  }

  /*
  Purchase Orde Controller
  */

  public function purchaseOrderList(){

    $orderList = DB::table('purchase_order_creates as p')
      ->leftJoin('purchase_order_create_details as pd', 'p.id', '=', 'pd.purchase_order_id')
      ->select('p.id','p.order_no','p.date','p.supplier_id','p.deliveryDate','p.reference_no','p.description', 'pd.id as pid','pd.product_id','pd.category_id','pd.specification','pd.unit','pd.rate','pd.quantity','pd.amount')
      ->where('p.status',1)->orderBy('p.id', 'DESC')->get();

	return view('backend.purchaseOrder.index', compact('orderList'));
  }

 public function purchaseOrderCreate(){
   $categorys 	= SalesCategory::orderBy('id','desc')->get();
   $rawMaterials = RowMaterialsProduct::orderBy('id','desc')->get();
   //$rawMaterials = SalesProduct::orderBy('id','desc')->get();
   $suppliers 	= Supplier::orderBy('id','desc')->get();
   //$cs_no = Cs::select('invoice')->whereNotNull('invoice')->whereNotNull('pr_no')->whereNotNull('rfq_no')->get();
   $cs_no = Cs::select('invoice')->whereNotNull('invoice')->get();
   $marketingInvoice = MarketingOrderItem::select('invoice')->whereNotNull('invoice')->where('purchaseOrderStatus',10)->get();
   return view('backend.purchaseOrder.create', compact('categorys','rawMaterials','suppliers','cs_no','marketingInvoice'));
  }

  public function getRawCategory($id){
  $data = [];
  $product = RowMaterialsProduct::where('id',$id)->first();

  //dd($date);
  //$product = SalesProduct::where('id',$id)->first();
  $cat = SalesCategory::where('id',$product->category_id)->first();

  //$data['unit'] = $product->product_weight_unit;
  $tdate = date('Y-m-d');
  $fdate =  date("Y-m-d ",strtotime("-2 month"));

  $sdate =  "2023-07-01";

/*  if($fdate <= "2023-07-01"){
    $pdate =  "2023-07-01";
    $fdate = "2023-07-01";
  } else {
    $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
  } */

$pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
  //Stock & Remaining Day  start
  $stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
              where purchases.product_id="'.$id.'"  and  purchases.date between "'.$fdate.'" and "'.$tdate.'" ');
  if($product->unit == 'PCS'){
    $stockoutBag = DB::table('packing_consumptions')->where('product_id',$id)->whereBetween('date',[$fdate, $tdate])->sum('qty');
    $openingbalance = $product->opening_balance ?? 0;
    $receive = $stocktotal[0]->srcv ?? 0;
    $consumption = $stockoutBag ?? 0;
    $stock = ($openingbalance+  $receive) - $consumption;

  } else {

  /*  $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
                where purchases.product_id="'.$id.'" and   purchases.date between "'.$sdate.'" and "'.$pdate.'" ');

    $return = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
              WHERE purchase_returns.product_id="'.$id.'" and purchase_returns.date between "'.$fdate.'" and "'.$tdate.'"');
     $pre_return = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
                    WHERE purchase_returns.product_id="'.$id.'" and purchase_returns.date between "'.$sdate.'" and "'.$pdate.'"');

   $transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
                    WHERE  purchase_transfers.product_id="'.$id.'"  and purchase_transfers.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
    $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
                  WHERE  purchase_transfers.product_id="'.$id.'"  and purchase_transfers.date BETWEEN "'.$sdate.'" and "'.$pdate.'"');

    $transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
                  WHERE  purchase_transfers.product_id="'.$id.'"  and purchase_transfers.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
    $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
                  WHERE purchase_transfers.product_id="'.$id.'"  and purchase_transfers.date BETWEEN "'.$sdate.'" and "'.$pdate.'"'); */

    $stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
                    WHERE purchase_stockouts.product_id ="'.$id.'" and purchase_stockouts.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
    /* $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
                    WHERE purchase_stockouts.product_id ="'.$id.'" and purchase_stockouts.date BETWEEN "'.$sdate.'" and "'.$pdate.'"');

    $damage = DB::select('SELECT SUM(purchase_damages.quantity) as quantity FROM `purchase_damages`
                  WHERE  purchase_damages.warehouse_id="'.$id.'"  and purchase_damages.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
    $pre_damage = DB::select('SELECT SUM(purchase_damages.quantity) as quantity FROM `purchase_damages`
                  WHERE  purchase_damages.product_id="'.$id.'"  and purchase_damages.date BETWEEN "'.$sdate.'" and "'.$pdate.'"');

    $otherRawStockOut = DB::table('service_stock_outs')->where('product_id',$pdata->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
*/
    $openingbalance = $product->opening_balance ?? 0;
    $receive = $stocktotal[0]->srcv ?? 0;
    $consumption = $stock_out[0]->stockout ?? 0;
    $stock = ($openingbalance+  $receive) - $consumption;

}
/*
    if($fdate == '2023-07-01'){
                         $openingbalance = $product->opening_balance;
                        } elseif($fdate < '2023-07-01') {
                                       $openingbalance = 0;
                                           } else {
                           $openingbalance = $product->opening_balance+ $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty- $pre_damage[0]->quantity + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;
                        }


                                if(!empty($otherRawStockOut)){
                                $clsingbalance = $openingbalance + $stocktotal[0]->srcv - $return[0]->return_qty + $transfer_to[0]->transfers_qty - $damage[0]->quantity - $transfer_from[0]->transfers_qty - $stock_out[0]->stockout - $otherRawStockOut;
                                } else {
                                      $clsingbalance = $openingbalance + $stocktotal[0]->srcv - $return[0]->return_qty + $transfer_to[0]->transfers_qty - $damage[0]->quantity - $transfer_from[0]->transfers_qty - $stock_out[0]->stockout;
                                       }

*/

  //Stock & Remaining Day end


  $totalDays =   round(abs(strtotime($tdate) - strtotime($fdate)) / (60 * 60 * 24));
  if($consumption > 0){
    $perDay = $consumption/$totalDays;
  } else {
    $perDay = 1;
  }


  $data['days'] = round(($stock/$perDay),2);

  $data['unit'] = $product->unit;
  $data['liveDay'] = $product->days;
  $data['cat'] = $cat->category_name;
  $data['cat_id'] = $cat->id;


  /*
  $sales = DB::table('sales_items')->where('product_id', $id)->sum('qty');
  $purchase = Purchase::where('product_id',$id)->value('inventory_receive');
  $data['stock'] = $purchase - $sales;
  */
  $data['stock'] = $stock;

  /*$cid = $product->category_id;
  $cat = SalesCategory::where('id',$cid)->first();
  $data['cat_id'] = $cat->id;
  $data['cat'] = $cat->category_name;
  */
  return response($data);
}

public function getRawPUnit($id){
  $data = [];
  $product = RowMaterialsProduct::where('id',$id)->first();
  $data['unit'] = $product->unit;
  return response($data);
}

  public function purchaseOrderStore(Request $request){
     //$data = $request->all();
     // dd($data);
    if(!empty($request->cs_no)){
    $value = Cs::select('pr_no','rfq_no','invoice')->where('invoice',$request->cs_no)->first();
    } else {
    	$value = ' ';
    }
      $in = DB::table('purchase_order_creates')->latest('id')->first();
      $temp = 0;
          if ($in) {
              $temp = 10000 + $in->id;
              $orderNo = 'Po-'.$temp;
          } else {
              $orderNo = 'Po-10000';
          }

     //$orderNo = Carbon::now()->format('y').Carbon::now()->format('m').mt_rand('10000','99999');
		$now = new Carbon();
       	$ctime = date("Y-m-d H:i:s", strtotime($now));
        $id =  DB::table('purchase_order_creates')->insertGetId([
        'pr_no' => $value->pr_no ?? '',
        'rfq_no' => $value->rfq_no ?? '',
        'cs_no' => $value->invoice ?? '' ,
        'mtInvoice_no' => $request->mtInvoice_no ?? '' ,
        'date' => $request->date,
        'supplier_id' => $request->supplier_id,
        'deliveryDate' => $request->deliveryDate,
        'reference_no' => $request->reference_no,
        'description' => $request->description,
        'totalAmount' => $request->total_amount,
        'order_no' => $orderNo,
        'created_at' => $ctime,
          ]);


          if($request->mtInvoice_no){
            $data = MarketingOrderItem::where('invoice',$request->mtInvoice_no)->first();
            $data->purchaseOrderStatus = 1;
            $data->save();
          }


    foreach($request->product_id as $key=> $data){
    	DB::table('purchase_order_create_details')->insert([
        'purchase_order_id' => $id,
        'product_id' => $request->product_id[$key],
        'category_id' => $request->category_id[$key],
        'specification' => $request->specification[$key],
        'unit' => $request->unit[$key],
        'rate' => $request->rate[$key],
        'quantity' => $request->quantity[$key],
        'amount' => $request->amount[$key],
        'created_at' => $ctime,
        ]);
    }
    return redirect()->back()->with('success','Purchase Order Create Successfull');
  }

  public function purchaseOrderEdit($id){
  	$purchaseOrder = DB::table('purchase_order_creates')->where('id',$id)->first();
    $purchaseOrderDetails = DB::table('purchase_order_create_details')->where('purchase_order_id',$id)->get();
    //$categorys 	= SalesCategory::orderBy('id','desc')->get();
    $rawMaterials = RowMaterialsProduct::orderBy('id','desc')->get();
    $suppliers 	= Supplier::orderBy('id','desc')->get();
    $cs_no = Cs::select('invoice')->whereNotNull('invoice')->get();
    //dd($purchaseOrder);
    return view('backend.purchaseOrder.edit', compact('purchaseOrder','purchaseOrderDetails','rawMaterials','suppliers','cs_no'));
  }

  public function purchaseOrderUpdate(Request $request){
    //dd($request->all());
    $now = new Carbon();
    $ctime = date("Y-m-d H:i:s", strtotime($now));
    $totalAmount = 0;

    foreach($request->pdID as $key=> $data){
      $totalAmount += $request->amount[$key];
    	DB::table('purchase_order_create_details')->where('id',$data)->update([
        'purchase_order_id' => $request->id,
        'product_id' => $request->product_id[$key],
        'category_id' => $request->category_id[$key],
        'specification' => $request->specification[$key],
        'unit' => $request->unit[$key],
        'rate' => $request->rate[$key],
        'quantity' => $request->quantity[$key],
        'amount' => $request->amount[$key],
        'updated_at' => $ctime,
        ]);
    }


    if(!empty($request->cs_no)){
    $value = Cs::select('pr_no','rfq_no','invoice')->where('invoice',$request->cs_no)->first();
    } else {
    	$value = ' ';
    }



  	 DB::table('purchase_order_creates')->where('id',$request->id)->update([
     'pr_no' => $value->pr_no ?? '',
         'rfq_no' => $value->rfq_no ?? '',
         'cs_no' => $value->invoice ?? '' ,
        'date' => $request->date,
        'supplier_id' => $request->supplier_id,
        'deliveryDate' => $request->deliveryDate,
        'reference_no' => $request->reference_no,
        'description' => $request->description,
        'totalAmount' => $totalAmount,
        'updated_at' => $ctime,
     ]);

     return redirect()->route('purchaseOrderList')->with('success','Purchase Order Updated Successfull');
  }

  public function purchaseOrderView($id){
  	$order = DB::table('purchase_order_creates as p')
      ->select('p.id','p.pr_no','p.rfq_no','p.cs_no','p.date','p.supplier_id','p.deliveryDate','p.reference_no','p.totalAmount','p.order_no','p.description')
      ->where('p.id',$id)->first();

    //dd($orders);
    // $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
    //     $amountInWords=$f->format($order->totalAmount ?? 0);

    $term = DB::table('terms')->where('id',1)->first();
    return view('backend.purchaseOrder.invoice', compact('order', 'term'));
  }
  public function purchaseOrderDelete(Request $request){
    $id = $request->id;
      $i = 1;
      $n = DB::table('purchase_order_create_details')->where('purchase_order_id',$id)->count('purchase_order_id');
		for($i = 1; $n >= $i; $i++){
           DB::table('purchase_order_create_details')->where('purchase_order_id',$id)->delete();
        }

    if($n = 1){
      DB::table('purchase_order_creates')->where('id',$id)->delete();
    }

     	return redirect()->back()->with('success','Purchase Order Deleted Successfull');
  }
  public function purchaseTermCreate($id){
    $data = DB::table('terms')->where('id',$id)->first();
    return view('backend.purchaseOrder.term', compact('data'));
  }

  public function purchaseTermUpdate(Request $request, $id ){
  	$term = $request->term;
    $now = new Carbon();
    $utime = date("Y-m-d H:i:s", strtotime($now));
    DB::table('terms')->update([
      'id' => $id,
      'term' => $term,
      'updated_at' => $utime
      ]);
    return redirect()->back()->with('success','Terms & Conditions Updated Successfull');
  }
}
