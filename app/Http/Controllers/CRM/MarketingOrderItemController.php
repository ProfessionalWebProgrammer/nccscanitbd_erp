<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MarketingOrderItem;
use App\Models\MarketingProduct;
use App\Models\SalesProduct;
use App\Models\InterCompany;
use App\Models\Requisition;
use App\Models\MarketingOrderQc;
use App\Models\MarketingOrderSpecificationHead;
use App\Models\MarketingOrderSpecification;
use App\Models\MarketingOrderTraking;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MarketingOrderItemController extends Controller
{
  public function index(){
    $orders = MarketingOrderItem::select('marketing_order_items.*','m.name','m.code','m.unit','m.image','m.specification','s.category_name','ss.name as subCat')
              ->leftJoin('marketing_products as m','m.id','=','marketing_order_items.item_id')
              ->leftJoin('sales_categories as s','s.id','=','m.category_id')
              ->leftJoin('sales_sub_categories as ss','ss.id','=','m.sub_category_id')
              ->where('marketing_order_items.status','!=',100)
              ->orderBy('marketing_order_items.invoice','DESC')->get();

    return view('backend.marketingOrder.index',compact('orders'));
  }

  public function create(){
    $company = InterCompany::orderby('name','asc')->get();
    $products = MarketingProduct::orderby('name','asc')->get();
    $users = User::orderby('name','asc')->get();
    $specifications = MarketingOrderSpecificationHead::all();
    return view('backend.marketingOrder.create', compact('company','products','users','specifications'));
  }

  public function invoiceNumber(){
    $demandnumber = DB::select('SELECT id FROM `marketing_order_items` ORDER BY id DESC LIMIT 1 ');
        return response($demandnumber);
  }

  public function store( Request $request){
   //dd($request->all());

    $data = new MarketingOrderItem;

    $data->date = $request->date;
    $data->user_id = Auth::id();
    $data->item_id = $request->products_id;
    $data->company_id = $request->company_id;
    $data->invoice = 'Mt-'.$request->invoice ?? 'Mt-1001';
    $data->require_date = $request->require_date;
    //$data->unit = $request->unit;
    $data->qty   = $request->qty;
    $data->note   = $request->specification ?? '';

    $data->approved_by  =  $request->approved_by;
    $data->save();

    if($request->file('image')){
    $data1 = MarketingProduct::where('id',$request->products_id)->first();
    $image_name = $data1->image;
    if(!empty($image_name)){
        $image_path = public_path('uploads/marketing/'.$image_name);
        if(file_exists($image_path)){
          unlink($image_path);
        }
    }

    $image = $request->file('image');
    $request->validate([
         'image' => 'mimes:jpeg,jpg,png|required|max:20000' // max 10000kb
     ]);

     $name = time() . '.' . $image->getClientOriginalExtension();
     //$name = time() . '.' .$request->image->extension();
     $image->move(public_path('uploads/marketing/'), $name);
     $data1->image   = $name;
    //$data1->specification   = $request->specification ?? '';
     $data1->save();
    }

if(!empty($request->specification_id)){
  foreach($request->specification_id as $key => $value) {
    $val = new MarketingOrderSpecification;
    $val->invoice = $data->invoice;
    $val->specification_id = $request->specification_id[$key];
    $val->value = $request->value[$key];
    $val->save();
  }
}

    return redirect()->Route('marketingOrder.item.index')->with('success','Marketing Order Create Successffull');
  }
public function updateStatus(Request $request, $invoice){
  $data = MarketingOrderItem::where('invoice',$invoice)->first();
  $data->status = $request->status;
  $data->save();
  if($request->status == 1){
    return redirect()->back()->with('success','Marketing Order Accept Successffull');
  } else {
    return redirect()->back()->with('success','Marketing Order Rejected.');
  }

}

public function getSpecificationData($id)
{
 $data = MarketingOrderSpecification::select('marketing_order_specifications.*','m.name')->leftjoin('marketing_order_specification_heads as m','m.id','=','marketing_order_specifications.specification_id')->where('item_id',$id)->get();
    return response($data);
}

  public function edit($id){
    return 'ok ';
  }
  public function update(Request $request){
    return 'ok';
  }
  public function delete(Request $request){
    $data =   MarketingOrderItem::findOrFail($request->id);
    $data->status = 100;
    $data->deleted_by = Auth::id();
    $data->save();

    return redirect()->route('marketingOrder.item.index')
                    ->with('delete', 'Marketing Order Delete  successfully .');
  }

  public function invoiceNotificationView($id){
    $orderViews = MarketingOrderItem::select('marketing_order_items.*','marketing_order_items.status as orderStatus','m.*','i.name as comName','i.address','s.category_name','ss.name as subCat')
                  ->leftJoin('marketing_products as m','m.id','=','marketing_order_items.item_id')
                  ->leftJoin('inter_companies as i','i.id','=','marketing_order_items.company_id')
                  ->leftJoin('sales_categories as s','s.id','=','m.category_id')
                  ->leftJoin('sales_sub_categories as ss','ss.id','=','m.sub_category_id')
                  ->where('marketing_order_items.id',$id)
                  ->first();
    $user = User::where('id',$orderViews->approved_by)->value('name');
  return view('backend.purchaseOrder.invoiceMtOrder', compact('orderViews','user'));

  }
  public function invoiceView($id){
    $orderViews = MarketingOrderItem::select('marketing_order_items.*','m.*','i.name as comName','i.address','s.category_name','ss.name as subCat')
              ->leftJoin('marketing_products as m','m.id','=','marketing_order_items.item_id')
              ->leftJoin('inter_companies as i','i.id','=','marketing_order_items.company_id')
              ->leftJoin('sales_categories as s','s.id','=','m.category_id')
              ->leftJoin('sales_sub_categories as ss','ss.id','=','m.sub_category_id')
              ->where('marketing_order_items.invoice',$id)->first();
    $user = User::where('id',$orderViews->approved_by)->value('name');
    $specifications = MarketingOrderSpecification::select('marketing_order_specifications.*','m.name')
                    ->leftJoin('marketing_order_specification_heads as m','m.id','=','marketing_order_specifications.specification_id')
                    ->where('invoice',$id)->get();
  return view('backend.marketingOrder.view', compact('orderViews','user','specifications'));

  }
public function marketingListQc(){
  $datas = MarketingOrderQc::select('m.*','marketing_order_qcs.receive_ststus','marketing_order_qcs.qtyReceive','marketing_order_qcs.qtyNot','marketing_order_qcs.qtyFull','marketing_order_qcs.note')
          ->leftjoin('marketing_order_items as m','m.invoice','=','marketing_order_qcs.invoice')
          ->where('marketing_order_qcs.status',1)->orderby('marketing_order_qcs.invoice','DESC')->get();
  return view('backend.marketingOrder.listQc', compact('datas'));
}
public function createQc(){
  $marketingOrderInvoice = MarketingOrderItem::where('qcStatus',10)->where('purchaseOrderStatus',1)->orderby('id','DESC')->get();
  return view('backend.marketingOrder.createQc', compact('marketingOrderInvoice'));
}
public function storeQc(Request $request){
//  dd($request->all());
  $data = new MarketingOrderQc();
  $data->date = $request->date;
  $data->invoice = $request->invoice;
  $data->user_id = Auth::id();
  $data->receive_ststus = $request->receive_ststus;
  $data->qtyReceive = $request->qtyReceive;
  $data->qtyNot = $request->qtyNot;
  $data->qtyFull = $request->qtyFull;
  $data->note = $request->note;
  $data->status = 1;
  $data->save();

  $qcData = MarketingOrderItem::where('invoice',$request->invoice)->first();
  $qcData->qcStatus = 1;
  $qcData->save();

return redirect()->route('marketingQualityControlList')
                ->with('success', 'Marketing Order Q.C create successfully .');
}

public function deleteQc(Request $request){
  MarketingOrderQc::findOrFail($request->id)->Delete($request->all());
  return redirect()->route('marketingQualityControlList')
                  ->with('delete', 'Marketing Order Q.C Delete  successfully .');
}

public function marketingOrderTrackingIndex(){
  $datas = MarketingOrderTraking::where('status',1)->orderBy('id', 'DESC')->groupby('invoice')->get();
  return view('backend.orderTracking.index', compact('datas'));
}
public function marketingOrderTrackingCreate(){
  $userId = Auth::id();
  $purchaseOrder = DB::table('purchase_order_creates')->select('id','order_no')->where('status',1)->orderBy('id', 'DESC')->get();
  return view('backend.orderTracking.create', compact('purchaseOrder','userId'));
}

public function marketingOrderTrackingStore(Request $request){
  //dd($request->all());
  //$orderTrackingEntry->fill($request->all());

  foreach ($request->stage as $key => $value) {
    $oTEntry = new MarketingOrderTraking();
    $oTEntry->date = $request->date;
    //$oTEntry->order_id = $id;
    $oTEntry->user_id = Auth::id();
    $oTEntry->invoice = $request->invoice;
    $oTEntry->stage = $request->stage[$key];
    $oTEntry->value = $request->value[$key];
    $oTEntry->remarks = $request->remarks[$key];
    $oTEntry->status = 1;
    $oTEntry->save();
  }
     return redirect()->back()->with('success','Order Tracking Entry Successfully');
}

public function getPurchaseOrderTrackingId($id){
  $id = DB::table('purchase_order_creates')->where('order_no',$id)->value('id');
  return $id;
}

public function marketingOrderTrackingEdit($invoice){
  $data = MarketingOrderTraking::where('invoice',$invoice)->where('status',1)->first();
  $datas = MarketingOrderTraking::where('invoice',$invoice)->where('status',1)->get();
  $purchaseOrder = DB::table('purchase_order_creates')->select('id','order_no')->where('status',1)->orderBy('id', 'DESC')->get();
  $purchaseId = DB::table('purchase_order_creates')->where('order_no',$invoice)->value('id');
  return view('backend.orderTracking.edit', compact('purchaseOrder','data','datas','purchaseId'));
}


public function marketingOrderTrackingUpdate(Request $request){
  //dd($request->all());

  foreach ($request->stage as $key => $value) {
    if($request->id[$key] == 0){
      $oTEntry = new MarketingOrderTraking();
      $oTEntry->date = $request->date;
      //$oTEntry->order_id = $id;
      $oTEntry->user_id = Auth::id();
      $oTEntry->invoice = $request->invoice;
      $oTEntry->stage = $request->stage[$key];
      $oTEntry->value = $request->value[$key];
      $oTEntry->remarks = $request->remarks[$key];
      $oTEntry->status = 1;
      $oTEntry->save();
    } else {

    }

  }
     return redirect()->back()->with('success','Order Tracking Updated Successfully');
}

public function getMarketingOrderTrackingInvoice(Request $request){

  $invoice = $request->invoice;
  $result = substr($invoice, 0, 2);

if($result == 'Pr'){
  $requisitionData = Requisition::where('invoice',$invoice)->first();
  if(!empty($requisitionData)){
    //$rfqData = Rfq::where('pr_no',$invoice)->first();
    return view('backend.orderTracking.prOrderTracking', compact('requisitionData','invoice'));
  } else {
    return redirect()->back()->with('warning','Sorry! This Invoice No has not any Purchase Requisition, Please Try Correct Invoice No.');
  }
} else {
  $data = MarketingOrderTraking::where('invoice',$invoice)->where('status',1)->first();
  $datas = MarketingOrderTraking::where('invoice',$invoice)->where('status',1)->get();
  if(!empty($data)){
    return view('backend.orderTracking.invoice', compact('data','datas'));
  } else {
    // return 'Sorry! This Invoice No has not any Purchase Order, Please Try Correct Invoice No. <a href="{{route('home')}}" title="Dashboard">DashBoard</a>';
    return redirect()->back()->with('warning','Sorry! This Invoice No has not any Purchase Order, Please Try Correct Invoice No.');
  }
}

}

public function marketingOrderTrackingInvoice($invoice){
    $data = MarketingOrderTraking::where('invoice',$invoice)->where('status',1)->first();
    $datas = MarketingOrderTraking::where('invoice',$invoice)->where('status',1)->get();
    return view('backend.orderTracking.invoice', compact('data','datas'));
}

public function marketingReportIndex(){
  return view('backend.marketingOrder.report.index');
}

public function marketingReportView(Request $request){
//  dd($request->all());
  if(isset($request->date)) {
    $dates = explode(' - ', $request->date);
    $fdate = date('Y-m-d', strtotime($dates[0]));
    $tdate = date('Y-m-d', strtotime($dates[1]));
  }
  $reportDatas = MarketingOrderItem::whereBetween('date',[$fdate,$tdate])->get();
  return view('backend.marketingOrder.report.view',compact('reportDatas'));
}

}
