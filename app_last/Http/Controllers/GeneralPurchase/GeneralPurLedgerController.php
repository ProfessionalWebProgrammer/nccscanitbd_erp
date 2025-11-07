<?php

namespace App\Http\Controllers\GeneralPurchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\GeneralPurchaseSupplierLedger;
use App\Models\GeneralSupplier;
use App\Models\GeneralProduct;
use App\Models\GeneralPurchase;
use Illuminate\Support\Facades\DB;

class GeneralPurLedgerController extends Controller
{
    public function ledgerindex()
    {
      	$supplier = GeneralSupplier::orderBy('supplier_name', 'asc')->get();
        return view('backend.general_purchase.general_purchase_ledger_index', compact('supplier'));
    }

    public function viewgeneralledger(Request $request)
    {
         //dd($request->all());
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
      	$supplier = $request->supplier_id;

        // dd($fdate, $tdate);
		if($request->supplier_id){
        	$generalpurchase = DB::table('general_purchase_supplier_ledgers')
              			->select('supplier_id')
              			->whereIn('supplier_id',$request->supplier_id)
              			->whereBetween('date', [$fdate, $tdate])
              			->groupby('supplier_id')
              			->get();
          //dd($generalpurchase);
        }else{
        	$generalpurchase = DB::table('general_purchase_supplier_ledgers')
              			->select('supplier_id')
              			->whereBetween('date', [$fdate, $tdate])
              			->groupby('supplier_id')
              			->get();
          //dd($generalpurchase);
        }
        //dd($ledgerdata); compact('generalpurchase', 'fdate', 'tdate')
        return view('backend.general_purchase.general_purchase_ledger_view', compact('generalpurchase','supplier','fdate', 'tdate'));
    }
}
