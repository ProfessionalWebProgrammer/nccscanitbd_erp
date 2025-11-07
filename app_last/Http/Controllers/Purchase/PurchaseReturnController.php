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
use App\Models\PurchaseReturn;
use App\Models\ScaleRowMaterial;
use App\Models\RowMaterialsProduct;
use App\Http\Controllers\Controller;
use App\Traits\ChartOfAccount;
use App\Models\Account\ChartOfAccounts;

class PurchaseReturnController extends Controller
{
    use ChartOfAccount;

    public function index()
    {

        $tlist = '';
        $returns = PurchaseReturn::select('purchase_returns.*', 'row_materials_products.product_name', 'suppliers.supplier_name', 'factories.factory_name')
            ->leftjoin('suppliers', 'suppliers.id', '=', 'purchase_returns.raw_supplier_id')
            ->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchase_returns.product_id')
            ->leftjoin('factories', 'factories.id', '=', 'purchase_returns.wirehouse_id')->orderby('purchase_returns.date', 'desc')->get();
        //  dd($returns);
        return view('backend.purchase.return_index', compact('returns'));
    }

      public function getPurchaseVal($id,$supplier){
      $data = array();
      $val = Purchase::select('bill_quantity', 'purchase_rate')->where('raw_supplier_id',$supplier)->where('product_id',$id)->orderBy('purchase_id','DESC')->first();
      $data['qty'] = $val->bill_quantity ?? 0;
      $data['rate'] = $val->purchase_rate ?? 0;

      return response($data);
    }

    public function create()
    {

        $product = RowMaterialsProduct::all();
        $factoryes = Factory::all();
        $suppliers = Supplier::all();

        return view('backend.purchase.return_create', compact('product', 'factoryes', 'suppliers'));
    }
    public function store(Request $request)
    {

        //  dd($request->all());

        // dd($request->return_rate * $request->return_quantity - $request->transport_fare);
        $returns = new PurchaseReturn;
        $returns->date                 = $request->date;
        $returns->raw_supplier_id      = $request->raw_supplier_id;
        $returns->wirehouse_id         = $request->wirehouse_id;
        $returns->product_id           = $request->product_id;
        $returns->return_quantity      = $request->return_quantity;
        $returns->return_rate          = $request->return_rate;
        $returns->total_amount         = $request->return_rate * $request->return_quantity - $request->transport_fare;
        $returns->vehicle_no           = $request->vehicle_no;
        $returns->transport_fare       = $request->transport_fare;
        $returns->save();
        $invoice = 'PRetn-'.$returns->id + 1000;
        $returns->invoice =  $invoice;
        $returns->save();
        
        $this->createCreditForPurchaseReturn('Accounts Payable (Return)' ,$returns->total_amount , $returns->date, $invoice);
        $this->createDebitForPurchaseReturn($returns->raw_supplier_id , $returns->total_amount ,  $returns->date, $invoice);

        $this->createCreditForPurchaseReturnAccount('Purchase' ,$returns->total_amount , $returns->date, $invoice);
        $this->createDebitForPurchaseReturnAccount( 'Purchase Return',$returns->total_amount ,  $returns->date, $invoice);


          $ledger = new PurchaseLedger();

        $ledger->supplier_id = $request->raw_supplier_id;
        $ledger->date = $request->date;
        $ledger->invoice_no = $invoice;
        $ledger->return_id = $returns->id;
        $ledger->warehouse_bank_id = $request->wirehouse_id;
        $ledger->debit = $request->return_rate * $request->return_quantity - $request->transport_fare;
        $ledger->balance = $request->return_rate * $request->return_quantity - $request->transport_fare;
        $ledger->save();

        return redirect()->route('purchase.return.index')->with('success', 'Return Successfully');
    }

    public function edit($id)
    {


        $trdetails = PurchaseReturn::where('id', $id)->first();

        // dd($trdetails);
        $suppliers = Supplier::all();

        $product = RowMaterialsProduct::all();
        $factoryes = Factory::all();

        return view('backend.purchase.return_edit', compact('product', 'factoryes', 'trdetails', 'suppliers'));
    }

    public function update(Request $request)
    {

        // dd($request->all());

        $returns = PurchaseReturn::where('id', $request->id)->first();
        $returns->date                 = $request->date;
        $returns->raw_supplier_id      = $request->raw_supplier_id;
        $returns->wirehouse_id         = $request->wirehouse_id;
        $returns->product_id           = $request->product_id;
        $returns->return_quantity      = $request->return_quantity;
        $returns->return_rate          = $request->return_rate;
        $returns->total_amount         = ($request->return_rate * $request->return_quantity) - $request->transport_fare;
        $returns->vehicle_no           = $request->vehicle_no;
        $returns->transport_fare       = $request->transport_fare;
        $returns->save();


        $ledger = PurchaseLedger::where('return_id', $request->id)->first();

        $ledger->supplier_id = $request->raw_supplier_id;
        $ledger->date = $request->date;
        $ledger->debit = ($request->return_rate * $request->return_quantity) - $request->transport_fare;
        $ledger->balance = ($request->return_rate * $request->return_quantity) - $request->transport_fare;
        $ledger->save();

        return redirect()->route('purchase.return.index')->with('success', 'return Update Successfully');
    }


    public function delete(Request $request)
      {
       $returndelete =  PurchaseReturn::where('id', $request->id)->first();
        $invoice = $returndelete->invoice;

       if ($returndelete) {
            PurchaseLedger::where('invoice_no',$invoice)->delete();
            ChartOfAccounts::where('invoice',$invoice)->delete();
            PurchaseReturn::where('id', $request->id)->delete();
           return redirect()->back()->with('success', 'Purchase Return Delete Successfully');
       }else{
        return redirect()->back()->with('error', 'Something Wrong');
       }
    }
    
}
