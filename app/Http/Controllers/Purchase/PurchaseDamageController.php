<?php

namespace App\Http\Controllers\Purchase;

use DB;

use Auth;
use Session;
use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Sale;
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
use App\Models\PurchaseDamage;
use App\Models\ScaleRowMaterial;
use App\Models\RowMaterialsProduct;
use App\Http\Controllers\Controller;

class PurchaseDamageController extends Controller
{
    public function index()
    {

      $tlist = '';
      $damages = PurchaseDamage::select('purchase_damages.*','row_materials_products.product_name','factories.factory_name')
      ->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchase_damages.product_id')
      ->leftjoin('factories', 'factories.id', '=', 'purchase_damages.warehouse_id')
      ->orderby('purchase_damages.date','desc')->get();
     //dd($damages);
        return view('backend.purchase.damage_index', compact('damages'));
    }


    public function create()
    {

      $product = RowMaterialsProduct::all();
      $factoryes = Factory::all();

        return view('backend.purchase.damage_create', compact('product','factoryes'));
    }
    public function store(Request $request)
    {
        // $lastid = PurchaseDamage::orderBy('id','desc')->first();

        // if ($lastid) {
        //     $trno = $lastid->id+100001;
        // }else{
        //     $trno = 100001;
        // }
       // dd($request->all());

        foreach ($request->product_id as $key => $product_id) {
                $damage = new PurchaseDamage;
                $damage->warehouse_id = $request->warehouse_id ;
                $damage->date = $request->date ;
                $damage->product_id = $product_id ;
                $damage->quantity = $request->quantity[$key] ;
                 $damage->rate = $request->rate[$key] ;
                $damage->save();

        }

        return redirect()->route('purchase.damage.index')->with('success', 'Damage Create Successfully');
    }

    public function edit($id)
    {

        
        $trdetails = PurchaseDamage::where('id',$id)->first();

        // dd($trdetails);

      $product = RowMaterialsProduct::all();
      $factoryes = Factory::all();

        return view('backend.purchase.damage_edit', compact('product','factoryes','trdetails'));
    }

    public function update(Request $request)
    {

        //dd($request->all());

          $damage = PurchaseDamage::where('id',$request->id)->first();
                $damage->from_wirehouse_id = $request->from_wirehouse_id ;
                $damage->to_wirehouse_id = $request->to_wirehouse_id ;
                $damage->date = $request->date ;
                $damage->product_id = $request->product_id ;
                $damage->qty = $request->qty ;
                $damage->receive_qty = $request->receive_qty ;
                $damage->save();

   
        return redirect()->route('purchase.damage.index')->with('success', 'damage Update Successfully');
    }

	public function deletepardamage(Request $request)
    {
      //dd($request->all());
      PurchaseDamage::where('id',$request->id)->delete();
      return redirect()->back()->with('success', 'Damage Delete Successfully');
    }
   



}
