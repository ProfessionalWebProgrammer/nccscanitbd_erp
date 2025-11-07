<?php

namespace App\Http\Controllers\Purchase;

use DB;

use Auth;
use Session;
use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Sale;
use App\Models\SalesProduct;
use App\Models\ProductUnit;
use App\Models\FinishGoodsPurchase;
use App\Models\SalesStockIn;
use App\Models\FGPurchaseDetailes;
use App\Models\User;
use App\Models\Batch;
use App\Models\Scale;
use App\Models\Dealer;
use App\Models\Ledger;
use App\Models\Factory;
use App\Models\Product;
use App\Models\Vehicle;
use App\Models\Employee;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\ReturnItem;
use App\Models\Returnstbl;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Ddl_check_out;
use App\Models\Dealer_demand;
use App\Models\Demand_number;
use App\Models\SupplierGroup;
use App\Models\PurchaseDetail;
use App\Models\PurchaseLedger;
use App\Models\DeliveryConfirm;
use App\Models\ScaleRowMaterial;
use App\Models\RowMaterialsProduct;
use App\Models\PurchaseDelete;
use App\Models\Account\ChartOfAccounts;
use App\Traits\ChartOfAccount;

use App\Http\Controllers\Controller;


class PurchaseController extends Controller
{
     use ChartOfAccount;

    public function index()
    {

        $invoice = DB::select('SELECT purchases.purchase_id FROM `purchases` WHERE purchases.purchas_unit IS NULL ORDER BY purchases.purchase_id desc');


        $vehicle = DB::select('SELECT purchases.transport_vehicle FROM `purchases` WHERE purchases.purchas_unit IS NULL GROUP BY purchases.transport_vehicle ORDER BY purchases.transport_vehicle asc');
        $factoryes = Factory::latest('id')->get();
        // dd($factoryes);
        $rm_products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();

        return view('backend.purchase.index', compact('invoice', 'vehicle', 'rm_products', 'factoryes', 'suppliers'));
    }
  
    public function detailsview($id)
    {
       $purchase_details = Purchase::select('purchases.*', 'suppliers.supplier_name', 'row_materials_products.product_name', 'factories.factory_name')
            ->leftjoin('suppliers', 'suppliers.id', '=', 'purchases.raw_supplier_id')
            ->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchases.product_id')
            ->leftjoin('factories', 'factories.id', '=', 'purchases.wirehouse_id')
         	->where('purchase_id', $id)->first();
        return view('backend.purchase.purchase_details_view', compact('purchase_details'));
    }



    public function purchaseList(Request $request)
    {
       // dd($request->all());
        $list = '';

        $purchases = Purchase::select('purchases.*', 'suppliers.supplier_name', 'row_materials_products.product_name', 'factories.factory_name')
            ->leftjoin('suppliers', 'suppliers.id', '=', 'purchases.raw_supplier_id')
            ->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchases.product_id')
            ->leftjoin('factories', 'factories.id', '=', 'purchases.wirehouse_id')
            ->where('purchases.purchas_unit','kg');



        if ($request->invoice) {
            $purchases = $purchases->whereIn('purchases.purchase_id', $request->invoice);

            $fdate = '';
            $tdate = '';
        } else {

            if ($request->date) {
                $dates = explode(' - ', $request->date);
                $fdate = date('Y-m-d', strtotime($dates[0]));
                $tdate = date('Y-m-d', strtotime($dates[1]));


                $purchases = $purchases->whereBetween('purchases.date', [$fdate, $tdate]);
            }

            if ($request->supplier_id) {
                $purchases = $purchases->whereIn('purchases.raw_supplier_id', $request->supplier_id);
            }
            if ($request->wirehouse_id) {
                $purchases = $purchases->whereIn('purchases.wirehouse_id', $request->wirehouse_id);
            }
            if ($request->product_id) {
                $purchases = $purchases->whereIn('purchases.product_id', $request->product_id);
            }
            if ($request->transport_vehicle) {
                $purchases = $purchases->whereIn('purchases.transport_vehicle', $request->transport_vehicle);
            }
        }




        //urchases = $purchases->orderBy('purchases.date', 'desc')->orderBy('purchases.purchase_id', 'desc')->take(10)->get();
		$purchases = $purchases->orderBy('purchases.date', 'desc')->orderBy('purchases.purchase_id', 'desc')->get();
        //($purchases);

        return view('backend.purchase.purchase_index', compact('purchases', 'fdate', 'tdate'));
    }


    public function entry()
    {
        
        $sclas = ScaleRowMaterial::where('purchase_status', 0)->get();
        $factoryes = Factory::latest('id')->get();
        $rm_products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();
        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();
      
		$poDatas = DB::table('purchase_order_creates')
          			->select('purchase_order_creates.*','suppliers.supplier_name')->leftjoin('suppliers', 'suppliers.id', '=', 'purchase_order_creates.supplier_id')
          			->where('status',1)->get();
      
        return view('backend.purchase.purchase_entry', compact('sclas', 'rm_products', 'factoryes', 'suppliers','poDatas'));
    }
    
    public function getPurchaseOrderRate($no){
      $data = array();
      $purchaseOrder = DB::table('purchase_order_creates')->select('id','order_no')->where('order_no',$no)->first();
      if($purchaseOrder){
        $PODetails = DB::table('purchase_order_create_details')->where('purchase_order_id', $purchaseOrder->id)->get();
        $count = count($PODetails);
      //  dd($purchaseOrder->id);
        if($count == 1){
          $purchaseOrderData = DB::table('purchase_order_create_details')->select('row_materials_products.product_name','purchase_order_create_details.*')->leftJoin('row_materials_products','purchase_order_create_details.product_id','=','row_materials_products.id')->where('purchase_order_id', $purchaseOrder->id)->first();
          //dd($purchaseOrderData);
          $data['prodcut'] = $purchaseOrderData->product_name;
          $data['prodcutId'] = $purchaseOrderData->product_id;
          $data['rate'] = $purchaseOrderData->rate;
          return response($data);
        } else {
          $data['prodcut'] = '';
          $data['rate'] = 0;
          return response($data);
        }
      } else {
        $data['prodcut'] = '';
        $data['rate'] = 0;
        return response($data);
      }
    }
    
    public function store(Request $request)
    {
         //dd($request->all());

        $uid = Auth::id();

        if ($request->purchas_unit == "bag") {
            $orderId = 0;
        } else {
            //             $orders = DB::select('SELECT orders.id,products.product_name,orders.order_qty FROM `orders`
            // LEFT JOIN products ON products.product_id = orders.product_id
            // WHERE orders.product_id="' . $request->product_id . '" AND orders.wirehouse_id="' . $request->wirehouse_id . '" AND orders.status = 0 LIMIT 1');
            //             $orderId = $orders[0]->id;

            $orderId = '';
        }


        $supplier_group_id = Supplier::where('id', $request->raw_supplier_id)->value('group_id');

        $unit = RowMaterialsProduct::where('id', $request->rm_product_id)->value('unit');

        $rate = (($request->purchase_rate * $request->bill_quantity) + $request->all_total_cost) / $request->bill_quantity ;

        // dd($supplier_group_id); DB::table('posts')-> | Purchase::insertGetId
        $savePurchase = DB::table('purchases')->insertGetId([
            'po_no' => $request->po_no,
            'raw_supplier_id' => $request->raw_supplier_id,
            'supplier_group_id' => $supplier_group_id,
            'reference' => $request->reference,
            'product_id'  => $request->rm_product_id,
            'month'=>date('F', strtotime($request->date)),
            'year'=>date('Y', strtotime($request->date)),
            'wirehouse_id' => $request->wirehouse_id,
            'date' => $request->date,
            'order_quantity' => $request->order_quantity,
            'order_id' => $orderId,
            'supplier_chalan_qty' => $request->supplier_chalan_qty,
            'receive_quantity' => $request->receive_quantity,
            'weight_quantity' => $request->weight_quantity,
            'inventory_receive' => $request->receive_quantity - $request->weight_quantity,
            'remain_quantity' => $request->remain_quantity,
            'sack_purchase' => $request->sack_purchase,
            'moisture' => $request->moisture,
            'deduction_quantity' => $request->deduction_quantity,
            'bill_quantity' => $request->bill_quantity,
            'rate' => $request->purchase_rate,
            'purchase_rate' => $rate,
            'purchas_unit' => $unit,
            'purchase_value' => $rate * $request->bill_quantity,
            'transport_vehicle' => $request->transport_vehicle,
            'transport_fare' => $request->transport_fare,
            'chot_qty' => $request->chot_qty,
            'plastic_qty' => $request->plastic_qty,
            'chot_waight' => $request->chot_waight,
            'chot_waight_w' => $request->chot_waight_w,
            'plastic_waight_w' => $request->plastic_waight_w,
            'total_payable_amount' => $request->total_payable_amount + $request->all_total_cost,
            'scale_id' => $request->scale_id,
            'user_id' => $uid,
            'created_at' => Carbon::now(),

        ]);

        $invoice = 'P-INV-'.+1000+$savePurchase;

        Purchase::where('purchase_id',$savePurchase)->update([
           'invoice' => $invoice,
       ]);

        if ($savePurchase) {

            $this->createCreditForPurchase($request->raw_supplier_id , $request->total_payable_amount,$request->date,$request->reference, $invoice);
            $this->createDebitForPurchase($request->raw_supplier_id , $request->total_payable_amount,$request->date,$request->reference, $invoice);

            //   $previous_ledger = \App\Ledger::where('supplier_id',$request->raw_supplier_id)->orderBy('id','desc')->first();
            $ledger = new PurchaseLedger;
            $ledger->supplier_id = $request->raw_supplier_id;
            $ledger->supplier_group_id = $supplier_group_id;
            $ledger->date = $request->date;
            $ledger->invoice_no = $invoice;
            $ledger->purcahse_id = $savePurchase;
            $ledger->credit = $request->total_payable_amount;
            $ledger->balance = $request->total_payable_amount;
            // $ledger->balance = $previous_ledger->balance +$request->total_payable_amount;
            $ledger->save();

            if($request->ad_supplier_id[0] != null){
                foreach($request->ad_supplier_id as $key=>$supplier){

                  $ledgerM = new PurchaseLedger;
                  $ledgerM->supplier_id = $supplier;
                  $ledgerM->supplier_group_id = $supplier_group_id;
                  $ledgerM->date = $request->date;
                  $ledgerM->invoice_no = $invoice;
                  $ledgerM->purcahse_id = $savePurchase;
                  $ledgerM->credit = $request->ad_total_price[$key];
                  $ledgerM->balance = $request->ad_total_price[$key];
                  $ledgerM->ledger_id = 1;
                  $ledgerM->save();

                  $this->createCreditForPurchase($supplier , $request->ad_total_price[$key],$request->date,$request->reference, $invoice);
                  $this->createDebitForPurchase($supplier , $request->ad_total_price[$key],$request->date,$request->reference, $invoice);

              }
            }


            if ($request->scale_id != null) {
                $sclas = ScaleRowMaterial::where('id', $request->scale_id)->first();
                $sclas->purchase_status = 1;
                $sclas->save();
            }

            return redirect()->back()->with('success', 'Purchase Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went Wrong!!');
        }

    }



    public function edit($id)
    {

        $purchasedata = Purchase::where('purchase_id', $id)->first();

        $sclas = ScaleRowMaterial::where('purchase_status', 0)->get();

        $factoryes = Factory::latest('id')->get();
        $rm_products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();
		$poDatas = DB::table('purchase_order_creates')->where('status',1)->get();
      
        return view('backend.purchase.purchase_edit', compact('purchasedata', 'sclas', 'rm_products', 'factoryes', 'suppliers','poDatas'));
    }


    public function update(Request $request)
    {
        // dd($request->all());




        $supplier_group_id = Supplier::where('id', $request->raw_supplier_id)->value('group_id');

        $purchase_id = $request->purchase_id;

        //  dd(Carbon::now());

        // dd($supplier_group_id);
        $savePurchase = Purchase::where('purchase_id', $purchase_id)->update([
          	'po_no' => $request->po_no,
            'raw_supplier_id' => $request->raw_supplier_id,
            'supplier_group_id' => $supplier_group_id,
            'reference' => $request->reference,
            'product_id'  => $request->rm_product_id,
            'wirehouse_id' => $request->wirehouse_id,
            'date' => $request->date,
            'order_quantity' => $request->order_quantity,
            'supplier_chalan_qty' => $request->supplier_chalan_qty,
            'receive_quantity' => $request->receive_quantity,
            'weight_quantity' => $request->weight_quantity,
            'inventory_receive' => $request->receive_quantity - $request->weight_quantity,
            'remain_quantity' => $request->remain_quantity,
            'sack_purchase' => $request->sack_purchase,
            'moisture' => $request->moisture,
            'deduction_quantity' => $request->deduction_quantity,
            'bill_quantity' => $request->bill_quantity,
            'purchase_rate' => $request->purchase_rate,
            'purchas_unit' => $request->purchas_unit ?? 'kg',
            'purchase_value' => $request->purchase_rate * $request->bill_quantity,
            'transport_vehicle' => $request->transport_vehicle,
            'transport_fare' => $request->transport_fare,
            'chot_qty' => $request->chot_qty,
            'plastic_qty' => $request->plastic_qty,
            'chot_waight' => $request->chot_waight,
            'chot_waight_w' => $request->chot_waight_w,
            'plastic_waight_w' => $request->plastic_waight_w,
            'total_payable_amount' => $request->total_payable_amount,
            'updated_at' => Carbon::now(),

        ]);


        if ($savePurchase) {
            //   $previous_ledger = \App\Ledger::where('supplier_id',$request->raw_supplier_id)->orderBy('id','desc')->first();
            $ledger = PurchaseLedger::where('purcahse_id', $purchase_id)->first();

            // dd($ledger);

            $ledger->supplier_id = $request->raw_supplier_id;
            $ledger->supplier_group_id = $supplier_group_id;
            $ledger->date = $request->date;
            $ledger->credit = $request->total_payable_amount;
            $ledger->balance = $request->total_payable_amount;
            // $ledger->balance = $previous_ledger->balance +$request->total_payable_amount;
            $ledger->save();

            return redirect()->back()->with('success', 'Purchase Update Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went Wrong!!');
        }
    }
    

    public function deletePurchase(Request $request)
    {

      // dd($request->all());
      $purchaseData = Purchase::where('purchase_id',$request->id)->first();

      $uid = Auth::id();
       $purchaseData = $purchaseData->makeHidden(['rate','created_at','updated_at'])->toArray();

            $pdid = PurchaseDelete::insertGetId($purchaseData);
          	$pddata = PurchaseDelete::where('id',$pdid)->first();
          	$pddata -> deleted_by = $uid;
          	$pddata -> save();
       $purchase = Purchase::where('purchase_id', $request->id)->delete();


                $ledger = PurchaseLedger::where('purcahse_id', $request->id)->delete();

                PurchaseDetail::where('purchase_id',$request->id)->delete();
                ChartOfAccounts::where('invoice',$purchaseData['invoice'])->delete();
                return redirect()->route('purchase.index')->with('success', 'Purchase Delete Successfully');

            }
            
    public function getScaleData($scale_no)
    {
        $scaledata = ScaleRowMaterial::where('id', $scale_no)->first();



        return response($scaledata);
    }



    public function bagindex()
    {

        $invoice = DB::select('SELECT purchases.purchase_id FROM `purchases` WHERE purchases.purchas_unit = "bag" ORDER BY purchases.purchase_id desc');


        $vehicle = DB::select('SELECT purchases.transport_vehicle FROM `purchases` WHERE purchases.purchas_unit = "bag" GROUP BY purchases.transport_vehicle ORDER BY purchases.transport_vehicle asc');
        $factoryes = Factory::latest('id')->get();
        // dd($factoryes);
        $rm_products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();

        return view('backend.purchase.bag_index', compact('invoice', 'vehicle', 'rm_products', 'factoryes', 'suppliers'));
    }


    public function bagpurchaseList(Request $request)
    {
        //dd($request->all());
        $list = '';

        $purchases = Purchase::select('purchases.*', 'suppliers.supplier_name', 'row_materials_products.product_name', 'factories.factory_name')
            ->leftjoin('suppliers', 'suppliers.id', '=', 'purchases.raw_supplier_id')
            ->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchases.product_id')
            ->leftjoin('factories', 'factories.id', '=', 'purchases.wirehouse_id')
            ->where('purchases.purchas_unit',"bag");



        if ($request->invoice) {
            $purchases = $purchases->whereIn('purchases.purchase_id', $request->invoice);

            $fdate = '';
            $tdate = '';
        } else {

            if ($request->date) {
                $dates = explode(' - ', $request->date);
                $fdate = date('Y-m-d', strtotime($dates[0]));
                $tdate = date('Y-m-d', strtotime($dates[1]));


                $purchases = $purchases->whereBetween('purchases.date', [$fdate, $tdate]);
            }

            if ($request->supplier_id) {
                $purchases = $purchases->whereIn('purchases.raw_supplier_id', $request->supplier_id);
            }
            if ($request->wirehouse_id) {
                $purchases = $purchases->whereIn('purchases.wirehouse_id', $request->wirehouse_id);
            }
            if ($request->product_id) {
                $purchases = $purchases->whereIn('purchases.product_id', $request->product_id);
            }
            if ($request->transport_vehicle) {
                $purchases = $purchases->whereIn('purchases.transport_vehicle', $request->transport_vehicle);
            }
        }




        $purchases = $purchases->orderBy('purchases.date', 'desc')->orderBy('purchases.purchase_id', 'desc')->get();

        // dd($purchases);

        return view('backend.purchase.bag_purchase_list', compact('purchases', 'fdate', 'tdate'));
    }

     public function bagpurchaseDetails($id)
    {

        $purchaseinfo = PurchaseDetail::where('purchase_id',$id)->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchase_details.product_id')->get();
        
        $purchases = Purchase::leftjoin('suppliers', 'suppliers.id', '=', 'purchases.raw_supplier_id')
        ->leftjoin('factories', 'factories.id', '=', 'purchases.wirehouse_id')
        ->where('purchase_id',$id)
        ->first();

        //dd($purchases);

        return view('backend.purchase.bag_purchase_details', compact('purchaseinfo', 'purchases'));
    }



    public function bagentry()
    {

       

        $factoryes = Factory::latest('id')->get();
        $rm_products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();
		$poDatas = DB::table('purchase_order_creates')
          			->select('purchase_order_creates.*','suppliers.supplier_name')->leftjoin('suppliers', 'suppliers.id', '=', 'purchase_order_creates.supplier_id')
          			->where('status',1)->get();
        return view('backend.purchase.bag_purchase_entry', compact('rm_products', 'factoryes', 'suppliers','poDatas'));
    }




    public function bagstore(Request $request)
    {
        //dd($request->all());

        $supplier_group_id = Supplier::where('id', $request->raw_supplier_id)->value('group_id');

        $uid = Auth::id(); 
     /* $savePurchase = Purchase::insertGetId([
            'raw_supplier_id'=>$request->raw_supplier_id,
            'supplier_group_id'=>$supplier_group_id,
            'reference'=>$request->reference,
            'month'=>date('F', strtotime($request->date)),
            'year'=>date('Y', strtotime($request->date)), 
            'wirehouse_id'=>$request->wirehouse_id,
            'date'=>$request->date,                           
            'purchas_unit'=>"bag",
            'purchase_value'=>$request->total_purchase_value,
            'transport_vehicle'=>$request->transport_vehicle,
            'transport_fare'=>$request->transport_fare,                           
            'total_payable_amount'=>$request->total_payable_amount,
            'user_id'=>$uid,
            'created_at'=>Carbon::now(),
              ]); */
      	foreach($request->product_id as $key=>$product_ids){
        $savePurchase = Purchase::insertGetId([
          	'product_id'=>$request->product_id[$key],
          	'po_no' =>$request->po_no,
            'raw_supplier_id'=>$request->raw_supplier_id,
            'supplier_group_id'=>$supplier_group_id,
            'reference'=>$request->reference,
            'month'=>date('F', strtotime($request->date)),
            'year'=>date('Y', strtotime($request->date)),
          	'order_quantity' => $request->p_qty[$key],
          	'supplier_chalan_qty' => $request->p_qty[$key],
          	'receive_quantity' => $request->p_qty[$key],
          	'inventory_receive' => $request->p_qty[$key],
          	'bill_quantity' => $request->p_qty[$key],
            'wirehouse_id'=>$request->wirehouse_id,
            'date'=>$request->date,                           
            'purchas_unit'=>"bag",
          	'purchase_rate' => $request->p_price[$key],
            'purchase_value'=>$request->total_price[$key],
            'transport_vehicle'=>$request->transport_vehicle,
            'transport_fare'=>$request->transport_fare,                           
            'total_payable_amount'=>$request->total_price[$key],
            'user_id'=>$uid,
              ]);
            
            if($savePurchase){
               
               $invoice = 'PBAG-'. $savePurchase;
               $bagPurchase = Purchase::where('purchase_id',$savePurchase)->update([
                  'invoice' => $invoice,
              ]);

                $this->createCreditForBagPurchase($request->raw_supplier_id , $request->total_price[$key],$request->date,$request->reference, $invoice);
                $this->createDebitForBagPurchase('Bag' , $request->total_price[$key],$request->date,$request->reference, $invoice);

                
                    $pd = new PurchaseDetail();
                    $pd->purchase_id =$savePurchase;
                    $pd->invoice =$invoice;
                    $pd->product_id=$request->product_id[$key];                         
                    $pd->bill_quantity=$request->p_qty[$key];                        
                    $pd->purchase_rate=$request->p_price[$key];                       
                    $pd->amount=$request->total_price[$key];                        
                    $pd->save(); 
                       
                }
       
	
                $ledger = new PurchaseLedger();

                $ledger->supplier_id =$request->raw_supplier_id;
                $ledger->supplier_group_id =$supplier_group_id;
                $ledger->date =$request->date;
                $ledger->invoice_no = $invoice;
                $ledger->purcahse_id = $savePurchase;
          		$ledger->credit = $request->total_price[$key];
                $ledger->balance = $request->total_price[$key];
                /*$ledger->credit = $request->total_payable_amount;
                $ledger->balance =$request->total_payable_amount; */
                // $ledger->balance = $previous_ledger->balance +$request->total_payable_amount;
                $ledger->save();

            }

            return redirect()->route('purchase.bag.index')->with('success', 'Bag Purchase Successfully');


    }



    public function bagedit($id)
    {


        $purchaseinfo = PurchaseDetail::where('purchase_id',$id)->get();

        $purchases = Purchase::where('purchase_id',$id)->first();

        //dd($purchases);
        $factoryes = Factory::latest('id')->get();
        $rm_products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();

        return view('backend.purchase.bag_purchase_edit', compact('purchaseinfo','purchases','rm_products', 'factoryes', 'suppliers'));
    }




    public function bagupdate(Request $request)
    {
       // dd($request->all());

        $supplier_group_id = Supplier::where('id', $request->raw_supplier_id)->value('group_id');

        $uid = Auth::id();
        $savePurchase = Purchase::where('purchase_id',$request->purchase_id)->update([
            'raw_supplier_id'=>$request->raw_supplier_id,
            'supplier_group_id'=>$supplier_group_id,
            'reference'=>$request->reference,
            'month'=>date('F', strtotime($request->date)),
            'year'=>date('Y', strtotime($request->date)), 
            'wirehouse_id'=>$request->wirehouse_id,
            'date'=>$request->date,                           
            'purchas_unit'=>"bag",
            'purchase_value'=>$request->total_purchase_value,
            'transport_vehicle'=>$request->transport_vehicle,
            'transport_fare'=>$request->transport_fare,                           
            'total_payable_amount'=>$request->total_payable_amount,
            'updated_at'=>Carbon::now(),
              ]);
            
            if($savePurchase){
                PurchaseDetail::where('purchase_id',$request->purchase_id)->delete();
                
                foreach($request->product_id as $key=>$product_ids){
                    $pd = new PurchaseDetail();
                    $pd->purchase_id =$request->purchase_id;                        
                    $pd->product_id=$request->product_id[$key];                         
                    $pd->bill_quantity=$request->p_qty[$key];                        
                    $pd->purchase_rate=$request->p_price[$key];                       
                    $pd->amount=$request->total_price[$key];                        
                    $pd->save(); 
                       
                }


                $ledger = PurchaseLedger::where('purcahse_id',$request->purchase_id)->first();

                $ledger->supplier_id =$request->raw_supplier_id;
                $ledger->supplier_group_id =$supplier_group_id;
                $ledger->date =$request->date;
               $ledger->credit = $request->total_payable_amount;
                $ledger->balance =$request->total_payable_amount;
                // $ledger->balance = $previous_ledger->balance +$request->total_payable_amount;
                $ledger->save();

            }

            return redirect()->route('purchase.bag.index')->with('success', 'Bag Purchase Edit Successfully');


    }
  
    public function deleteLog(Request $request)
    {
    
  //  $pdata = DB::table('purchases')->whereNotNull('bill_quantity')->get();
    
    
    
  //  foreach($pdata as $data){
  //  	$pp = Ledger::where('purcahse_id',$data->purchase_id)->first();
  //      $pp->credit =  round(($data->bill_quantity*$data->purchase_rate)-$data->transport_fare,2);
   //     $pp->save();
   // }
  //   dd($pdata);

   $purchasedelete = PurchaseDelete::leftjoin('suppliers', 'suppliers.id', '=', 'purchase_deletes.raw_supplier_id')
            ->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchase_deletes.product_id')
            ->leftjoin('factories', 'factories.id', '=', 'purchase_deletes.wirehouse_id')
        ->select('purchase_deletes.*', 'suppliers.supplier_name', 'row_materials_products.product_name', 'factories.factory_name')
        ->orderBy('purchase_deletes.created_at', 'desc')
        ->get();
       // dd($purchasedelete);
     return view('backend.purchase.delete_log',compact('purchasedelete'));
    }
  
	public function finishgoodspurchasecreate()
    {
      	$units = ProductUnit::orderBy('unit_name', 'ASC')->get();
      	$factoryes = Factory::latest('id')->get();
        $products = SalesProduct::orderBy('product_name', 'ASC')->get();
        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();
      
      return view('backend.purchase.finish_goods_purchase_create', compact('products', 'factoryes', 'suppliers','units'));
    }
      public function finishGoodUnit($id){
      $data = [];
      $products = SalesProduct::where('id', $id)->first();
      $data['unit'] = $products->unit->unit_name;
      $data['id'] = $products->product_unit;
      return response($data);
    }
  		public function finishgoodpurstore(Request $request)
    {
    //   return $request->all();
     /* $inv = FinishGoodsPurchase::orderBy('id','desc')->first();
      if($inv->id){
        $invoice = 'FGP-INV-1000'.$inv->id;
      } else {
          $invoice = 'FGP-INV-1000';
      }*/

      $finishgoodpurdata = new FinishGoodsPurchase();
      $finishgoodpurdata->date = $request->date;

      $finishgoodpurdata->supplier_id = $request->raw_supplier_id;
      $finishgoodpurdata->warehouse_id = $request->wirehouse_id;
      $finishgoodpurdata->transport_vehicle = $request->transport_vehicle;
      $finishgoodpurdata->total_purchase_amount = $request->total_purchase_value;
      $finishgoodpurdata->transport_fare = $request->transport_fare;
      $finishgoodpurdata->net_payable_amount = $request->total_payable_amount;
      $finishgoodpurdata->narration = $request->narration;
      $finishgoodpurdata->save();
       $invoice = 'FGP-INV-1000'.$finishgoodpurdata->id;
       $finishgoodpurdata->invoice = $invoice;
       $finishgoodpurdata->save();

      $this->createCreditForFGPurchase($request->raw_supplier_id , $request->total_purchase_value,$request->date, $description = '', $invoice);
      $this->createDebitForFGPurchase($request->raw_supplier_id , $request->total_purchase_value,$request->date,  $description = '', $invoice);

      $finishgood_purchase_id = $finishgoodpurdata->id;
      $totalPurchaseCostOfFg = 0;
      foreach($request->product_id as $key => $value){
      	$finishgoodpurdetailes = new FGPurchaseDetailes();
      	$finishgoodpurdetailes->purchase_id = $finishgood_purchase_id;
      	$finishgoodpurdetailes->product_id = $request->product_id[$key];
      	$finishgoodpurdetailes->unit_id = $request->unit_id[$key];
      	$finishgoodpurdetailes->quantity = $request->p_qty[$key];
      	$finishgoodpurdetailes->rate = $request->p_price[$key];
      	$finishgoodpurdetailes->total_value = $request->total_price[$key];
      	$finishgoodpurdetailes->save();


          $stockin =   new SalesStockIn;
          $stockin->date = $request->date;
          $stockin->prouct_id = $request->product_id[$key];
          $stockin->quantity = $request->p_qty[$key];
          $stockin->factory_id = $request->wirehouse_id;
          $stockin->fg_purchase_id = $finishgood_purchase_id;
          $stockin->total_cost = $request->total_price[$key];
          $stockin->production_rate = $request->p_price[$key];
          $stockin->referance = $invoice;
          $stockin->note = $request->narration;
          $stockin->save();
          $totalPurchaseCostOfFg += $request->total_price[$key];
      }


            $ledger = new PurchaseLedger;
            $ledger->supplier_id = $request->raw_supplier_id;
            $ledger->date = $request->date;
            $ledger->type = 1;
            $ledger->invoice_no = $invoice;
            $ledger->purcahse_id = $finishgoodpurdata->id;
            $ledger->credit = $request->total_payable_amount;
            $ledger->balance = $request->total_payable_amount;
            $ledger->narration = $request->narration;
            $ledger->save();


    /*  $this->createCreditForRawMaterials('FG' , $totalPurchaseCostOfFg , $request->date, $description = '', $invoice);
      $this->createDebitForFinishedGoods('Work-in-Progress (WIP)' ,  $totalPurchaseCostOfFg , $request->date, $description = '', $invoice);
      $this->createCreditForRawMaterials('Work-in-Progress (WIP)' , $totalPurchaseCostOfFg , $request->date, $description = '', $invoice);
      $this->createDebitForFinishedGoods('Finished Goods' ,  $totalPurchaseCostOfFg , $request->date, $description = '', $invoice);
      */
      $this->createDebitForFinishedGoods('Finished Goods' ,  $totalPurchaseCostOfFg , $request->date, $request->narration, $invoice);
      $this->createCreditForRawMaterials('FG' , $totalPurchaseCostOfFg , $request->date, $request->narration, $invoice);

      return redirect()->back()->with('success','Finish Good Purchase Stored Success!');

    }

    
  public function finishgoodpurchaselist()
  {
     $factoryes = Factory::latest('id')->get();
     $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();
  	return view('backend.purchase.finish_goods_purchase_list_index',compact('factoryes','suppliers'));
  }
  
  public function finishgoodpurchaselistview(Request $request)
  {
    if ($request->date) {
                $dates = explode(' - ', $request->date);
                $fdate = date('Y-m-d', strtotime($dates[0]));
                $tdate = date('Y-m-d', strtotime($dates[1]));
      
            }	
    
    

    //dd($factories);
    //dd($request->all());
    $finishgoodslist = DB::table('finish_goods_purchases')
      ->select('finish_goods_purchases.*','factories.factory_name','suppliers.supplier_name')
      ->leftJoin('suppliers','suppliers.id','finish_goods_purchases.supplier_id')
      ->leftJoin('factories','factories.id','finish_goods_purchases.warehouse_id')
      ->whereBetween('finish_goods_purchases.date', [$fdate, $tdate]);    
    
      if ($request->supplier_id) {
         $finishgoodslist = $finishgoodslist->whereIn('finish_goods_purchases.supplier_id', $request->supplier_id);
      }
   
    
      if ($request->wirehouse_id) {
      	$finishgoodslist = $finishgoodslist->whereIn('finish_goods_purchases.warehouse_id', $request->wirehouse_id);
       }
    
     $finishgoodslist = $finishgoodslist->get();
    
    	 
            
    return view('backend.purchase.finish_goods_purchase_list_view',compact('finishgoodslist'));
  }
	
   public function finishgoodpurchasedetailes($id)
   {
     
      $fgpurchasedetailes = DB::table('finish_goods_purchases')
      ->select('finish_goods_purchases.*','factories.factory_name','suppliers.supplier_name')
      ->leftJoin('suppliers','suppliers.id','finish_goods_purchases.supplier_id')
      ->leftJoin('factories','factories.id','finish_goods_purchases.warehouse_id')
       ->where('finish_goods_purchases.id',$id)
      ->first();
     //dd($fgpurchasedetailes);
     $fgpurchaseitems = DB::table('f_g_purchase_detailes')
       ->select('f_g_purchase_detailes.*','sales_products.product_name','product_units.unit_name')
       ->leftJoin('sales_products','sales_products.id','f_g_purchase_detailes.product_id')
       ->leftJoin('product_units','product_units.id','f_g_purchase_detailes.unit_id')
       ->where('purchase_id',$id)
       ->get();
     
   	  return view('backend.purchase.finish_goods_purchase_detailes',compact('fgpurchasedetailes','fgpurchaseitems'));
   }
   public function finishgoodspurchaseedit($id)
   {
     	$units = ProductUnit::orderBy('unit_name', 'ASC')->get();
      	$factoryes = Factory::latest('id')->get();
        $products = SalesProduct::orderBy('product_name', 'ASC')->get();
        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();
     	$purchase = FinishGoodsPurchase::where('id',$id)->first();
   		$purchaseitems = FGPurchaseDetailes::where('purchase_id',$id)->get();
     
     return view('backend.purchase.finish_goods_purchase_edit',compact('products', 'factoryes', 'suppliers','units','purchase','purchaseitems'));
   }
  
   public function finishgoodpurchasedelete(Request $request)
   {
     $fgInvoice = 	FinishGoodsPurchase::where('id',$request->id)->first();

   		FinishGoodsPurchase::where('id',$request->id)->delete();
   		FGPurchaseDetailes::where('purchase_id',$request->id)->delete();
        PurchaseLedger::where('invoice_no',$fgInvoice->invoice)->delete();
        SalesStockIn::where('fg_purchase_id',$request->id)->delete();
        ChartOfAccounts::where('invoice',$fgInvoice->invoice)->delete();

     	return redirect()->route('finish.goods.manual.purchse.list')->with('success','Finish Good Purchase Deleted Success!');
   }
	
   public function finishgoodpurchaseupdate(Request $request)
   {
    // dd($request->all());
   	  $finishgoodpurdata = FinishGoodsPurchase::where('id',$request->id)->first();
      $finishgoodpurdata->date = $request->date;
      $finishgoodpurdata->supplier_id = $request->raw_supplier_id;
      $finishgoodpurdata->warehouse_id = $request->wirehouse_id;
      $finishgoodpurdata->transport_vehicle = $request->transport_vehicle;
      $finishgoodpurdata->total_purchase_amount = $request->total_purchase_value;
      $finishgoodpurdata->transport_fare = $request->transport_fare;
      $finishgoodpurdata->net_payable_amount = $request->total_payable_amount;
      $finishgoodpurdata->save();
      
      $finishgood_purchase_id = $finishgoodpurdata->id;
     $fdata=  FGPurchaseDetailes::where('purchase_id',$request->id)->get(); 
     foreach($fdata as $d){
     	SalesStockIn::where('fg_purchase_id',$d->id)->delete();
     
     }
      FGPurchaseDetailes::where('purchase_id',$request->id)->delete(); 
     
      foreach($request->product_id as $key => $value){
        
      	$finishgoodpurdetailes = new FGPurchaseDetailes();
      	$finishgoodpurdetailes->purchase_id = $finishgood_purchase_id;
      	$finishgoodpurdetailes->product_id = $request->product_id[$key];
      	$finishgoodpurdetailes->unit_id = $request->unit_id[$key];
      	$finishgoodpurdetailes->quantity = $request->p_qty[$key];
      	$finishgoodpurdetailes->rate = $request->p_price[$key];
      	$finishgoodpurdetailes->total_value = $request->p_price[$key]*$request->p_qty[$key];
      	$finishgoodpurdetailes->save();
        
        
        
         $stockin =   new SalesStockIn;
          $stockin->date = $request->date;
          $stockin->prouct_id = $request->product_id[$key];
          $stockin->quantity = $request->p_qty[$key];
          $stockin->factory_id = $request->wirehouse_id;
          $stockin->fg_purchase_id = $finishgoodpurdetailes->id;
          $stockin->total_cost = $request->p_price[$key]*$request->p_qty[$key];
          $stockin->production_rate = $request->p_price[$key];

          $stockin->save();
      }
      return redirect()->route('finish.goods.manual.purchse.list')->with('success','Finish Good Purchase Update Success!');
   }
}
