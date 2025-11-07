<?php

namespace App\Http\Controllers\GeneralPurchase;

use App\Http\Controllers\Controller;
use App\Models\GeneralCategory;
use App\Models\GeneralProduct;
use App\Models\GeneralSubCategory;
use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Models\GeneralWirehouse;
use App\Models\GeneralPurchaseSupplierLedger;
use App\Models\GeneralSupplier;
use App\Models\Factory;
use App\Models\Supplier;
use App\Models\GeneralPurchase;
use Auth;

class GeneralPurchaseController extends Controller
{
  public function generalPurchasePageIndex()
    {
    	return view('backend.general_purchase.general_purchase_page_index');
    }
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = GeneralPurchase::groupBy('invoice_no')->orderby('date','desc')->get('invoice_no');
        return view('backend.general_purchase.general_purchase_index', compact('data'));
    }
	
  	public function viewganarelpurchase($id){
       $purchasedata = GeneralPurchase::where('invoice_no',$id)->first();
       return view('backend.general_purchase.general_purchase_view', compact('purchasedata'));
    }
    public function creategenerelpurchase()
    {
        $gproducts = GeneralProduct::all();
        $gcategory = GeneralCategory::all();
        $gsubcategory = GeneralSubCategory::all();
        $suppliers = GeneralSupplier::orderBy('supplier_name', 'ASC')->get();
        $wirehouses = GeneralWirehouse::orderBy('wirehouse_name','asc')->get();
        return view('backend.general_purchase.ganeral_purchase_create', compact('gproducts', 'gcategory', 'gsubcategory', 'suppliers', 'wirehouses'));
    }

    public function storegenerelpurchase(Request $request)
    {
      //dd($request->all());
        if ($request->products_id != null) {
            foreach ($request->products_id as $key => $product_id) {
				$productinfo = GeneralProduct::where('id', $request->products_id[$key])->first();
              if($productinfo->dimensions == null){
                $productdimention = GeneralProduct::where('id', $request->products_id[$key])->update(['dimensions' => $request->p_dimention[$key]]);
              }
                $gpurchasdata = new GeneralPurchase();
                $gpurchasdata->invoice_no = $request->invoice;
                $gpurchasdata->reference = $request->referance;
                $gpurchasdata->product_id = $request->products_id[$key];
                $gpurchasdata->warehouse_id = $request->factory_id;
                $gpurchasdata->supplier_id = $request->delar_id;
                $gpurchasdata->date = $request->date;
                $gpurchasdata->quantity = $request->p_qty[$key];
                $gpurchasdata->rate = $request->rate[$key];
                $gpurchasdata->total_value = $request->rate[$key]*$request->p_qty[$key];
                $gpurchasdata->dimensions =  $request->p_dimention[$key];
                $gpurchasdata->created_by = Auth::User()->id;
                $gpurchasdata->save();
              
              	$generelledger = new GeneralPurchaseSupplierLedger();
              	$generelledger->supplier_id =  $request->delar_id;
              	$generelledger->date =  $request->date;
              	$generelledger->debit = $request->rate[$key]*$request->p_qty[$key];
              	$generelledger->invoice_no = $request->invoice;
              	$generelledger->save(); 
              
            }
        }

        if ($request->newporoduct_name != null) {
            foreach ($request->newporoduct_name as $key => $name) {

                $generalproduct = new GeneralProduct();
                $generalproduct->gproduct_name = $request->newporoduct_name[$key];
                $generalproduct->general_category_id = $request->main_cat[$key];
                $generalproduct->general_sub_category_id = $request->sub_cat[$key];
                $generalproduct->opening_balance = 0;
                $generalproduct->rate = $request->pnew_rate[$key];
                $generalproduct->dimensions = $request->dimensions[$key];
              	
                $generalproduct->save();
                $lastid = $generalproduct->id;

                $gpurchasdata = new GeneralPurchase();
                $gpurchasdata->invoice_no = $request->invoice;
                $gpurchasdata->reference = $request->referance;
                $gpurchasdata->product_id = $lastid;
                $gpurchasdata->warehouse_id = $request->factory_id;
                $gpurchasdata->supplier_id = $request->delar_id;
                $gpurchasdata->date = $request->date;
                $gpurchasdata->quantity = $request->pnew_qty[$key];
                $gpurchasdata->rate = $request->pnew_rate[$key];
                $gpurchasdata->total_value = $request->pnew_rate[$key]*$request->pnew_qty[$key];
                $gpurchasdata->dimensions = $request->dimensions[$key];
              	$gpurchasdata->created_by = Auth::User()->id;
                $gpurchasdata->save();
              
              	$generelledger = new GeneralPurchaseSupplierLedger();
              	$generelledger->supplier_id =  $request->delar_id;
              	$generelledger->date =  $request->date;
              	$generelledger->debit = $request->pnew_rate[$key]*$request->pnew_qty[$key];
              	$generelledger->invoice_no = $request->invoice;
              	$generelledger->save();
            }
        }
        return redirect()->back()->with('success', 'Purchase Create Successfull');
    }

    public function editgpurchase($id)
    {
        // dd($id);
        $gproducts = GeneralProduct::all();
        $gcategory = GeneralCategory::all();
        $gsubcategory = GeneralSubCategory::all();
        $suppliers = GeneralSupplier::orderBy('supplier_name', 'ASC')->get();
        $factoryes = Factory::latest('id')->get();
        $editabledata = GeneralPurchase::where('invoice_no', $id)->get();

        return view('backend.general_purchase.ganeral_purchase_edit', compact('gproducts', 'gcategory', 'gsubcategory', 'suppliers', 'factoryes', 'editabledata', 'id'));
    }

    public function updategpurchase(Request $request)
    {
        // dd($request->all());
        if ($request->products_id != null) {
          	GeneralPurchaseSupplierLedger::where('invoice_no', $request->invoice)->delete();
            foreach ($request->products_id as $key => $product_id) {

                $gpurchasdata = GeneralPurchase::where('id', $request->item_id[$key])->first();
                // dd($gpurchasdata);
                $productdimention = GeneralProduct::where('id', $request->products_id[$key])->value('dimensions');

                $gpurchasdata->invoice_no = $request->invoice;
                $gpurchasdata->reference = $request->referance;
                $gpurchasdata->product_id = $request->products_id[$key];
                $gpurchasdata->warehouse_id = $request->factory_id;
                $gpurchasdata->supplier_id = $request->delar_id;
                $gpurchasdata->date = $request->date;
                $gpurchasdata->quantity = $request->p_qty[$key];
                $gpurchasdata->rate = $request->rate[$key];
                
                $gpurchasdata->total_value = $request->rate[$key]*$request->p_qty[$key];
                $gpurchasdata->dimensions = $productdimention;
                $gpurchasdata->save();
              
              	$generelledger = new GeneralPurchaseSupplierLedger();
              	$generelledger->supplier_id =  $request->delar_id;
              	$generelledger->date =  $request->date;
              	$generelledger->debit = $request->rate[$key]*$request->p_qty[$key];
              	$generelledger->invoice_no = $request->invoice;
              	$generelledger->save();
            }
        } else {
            dd("Nothing for update!");
        }

        if ($request->newporoduct_name != null) {
            foreach ($request->newporoduct_name as $key => $name) {

                $generalproduct = new GeneralProduct();
                $generalproduct->gproduct_name = $request->newporoduct_name[$key];
                $generalproduct->general_category_id = $request->main_cat[$key];
                $generalproduct->general_sub_category_id = $request->sub_cat[$key];
                $generalproduct->opening_balance = 0;
                $generalproduct->rate = $request->pnew_rate[$key];
                $generalproduct->dimensions = $request->dimensions[$key];
                $gpurchasdata->total_value = $request->pnew_rate[$key]*$request->pnew_qty[$key];
                $generalproduct->save();
                $lastid = $generalproduct->id;

                $gpurchasdata = new GeneralPurchase();
                $gpurchasdata->invoice_no = $request->invoice;
                $gpurchasdata->reference = $request->referance;
                $gpurchasdata->product_id = $lastid;
                $gpurchasdata->warehouse_id = $request->factory_id;
                $gpurchasdata->supplier_id = $request->delar_id;
                $gpurchasdata->date = $request->date;
                $gpurchasdata->quantity = $request->pnew_qty[$key];
                $gpurchasdata->rate = $request->pnew_rate[$key];
                $gpurchasdata->total_value = $request->pnew_rate[$key]*$request->pnew_qty[$key];
                $gpurchasdata->dimensions = $request->dimensions[$key];
                $gpurchasdata->save();
              
              	$generelledger = new GeneralPurchaseSupplierLedger();
              	$generelledger->supplier_id =  $request->delar_id;
              	$generelledger->date =  $request->date;
              	$generelledger->debit = $request->pnew_rate[$key]*$request->pnew_qty[$key];
              	$generelledger->invoice_no = $request->invoice;
              	$generelledger->save();
            }
        }
        return redirect()->route('general.purchase.index')->with('success', 'Purchase Update Successfull');
    }
  
  	public function deletegeneralpurchase(Request $request){
      //dd($request->all());
      GeneralPurchase::where('invoice_no',$request->invoice)->delete();
      GeneralPurchaseSupplierLedger::where('invoice_no',$request->invoice)->delete();
      return redirect()->back()->with('success', 'Invoice Delete Successfull.');
    }

    // Last Purchase Invoice
    public function getlastinvoice()
    {
        // $demandnumber = DB::select('SELECT demand_numbers.id as invoice_no FROM `demand_numbers` ORDER BY demand_numbers.id DESC LIMIT 1 ');
        $lastinvoice = GeneralPurchase::orderBy('id', 'DESC')->first();
        return response($lastinvoice);
    }
  	
    public function generalpurchasesuppliercreate()
    {
           return view('backend.general_purchase.general_purchase_supplier_create');
    } 
  	public function storegeneralpurchasedata(Request $request)
    {
      $supplinerdata =  new GeneralSupplier();
      $supplinerdata->supplier_name = $request->supplier_name;
      $supplinerdata->opening_balance = $request->opening_balance;
      $supplinerdata->phone = $request->phone;
      $supplinerdata->address = $request->address;
      $supplinerdata->save();
      
      return redirect()->back()->with('success', 'Supplier Created Successfull.');
    }
  	
  	public function generalpurchasesupplierindex()
    {
      $suppliers = GeneralSupplier::all();
      return view('backend.general_purchase.general_purchase_supplier_index',compact('suppliers'));
    } 
  	
  	public function generalsupplierdelete(Request $request)
    {
      GeneralSupplier::where('id',$request->id)->delete();
      return redirect()->back()->with('success', 'Supplier Deleted Successfull.');      
    }
  	
  	public function generalsupplieredit($id)
    {
      $supplieredit=GeneralSupplier::where('id',$id)->first();
      return view('backend.general_purchase.general_purchase_supplier_edit',compact('supplieredit'));
    }
  	
  	public function generalpurchasesupplierupdate(Request $request)
    {
      $supplinerdata =  GeneralSupplier::where('id',$request->id)->first();
      $supplinerdata->supplier_name = $request->supplier_name;
      $supplinerdata->opening_balance = $request->opening_balance;
      $supplinerdata->phone = $request->phone;
      $supplinerdata->address = $request->address;
      $supplinerdata->save();
      return redirect()->route('general.purchase.supplier.index')->with('success', 'Supplier Updated Successfull.');      
      
    }
  	
  	public function generalwirehouseindex()
    {
      	$wirehouses = GeneralWirehouse::orderBy('wirehouse_name','asc')->get();
    	return view('backend.general_purchase.general_wirehouse_index',compact('wirehouses'));
    }
  	
  	public function deletegeneralwirehouse(Request $request)
    {
    	GeneralWirehouse::where('wirehouse_id',$request->id)->delete();
      	return redirect()->back()->with('success', 'Wirehouse Deleted Successfull.'); 
      
    }
  	public function generalpurchasewirehousecreate()
    {
    	 return view('backend.general_purchase.general_wirehouse_create');
    }
  	
  	public function generalpurchasewirehousestore(Request $request)
    {
    	//dd($request->all());
      	$wirehousedata = new GeneralWirehouse();
      	$wirehousedata->wirehouse_name = $request->wirehouse_name;
        $wirehousedata->wirehouse_opb = $request->wirehouse_opb;
        $wirehousedata->wirehouse_address = $request->wirehouse_address;
        $wirehousedata->save();
      return redirect()->route('general.purchase.general.wirehouse.index')->with('success', 'Wirehouse Created Successfull.'); 
    }
}
