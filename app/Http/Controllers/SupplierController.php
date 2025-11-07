<?php

namespace App\Http\Controllers;

use App\Models\SupplierGroup;
use App\Department;
use App\Models\Supplier;
use Illuminate\Http\Request;
use DB;
use App\Traits\AccountInfoAdd;

class SupplierController extends Controller
{
    use AccountInfoAdd;

     public function index()
    {
        $supplier = Supplier::orderBy('id','asc')->get();
        return view('backend.supplier.index',compact('supplier'));
    }
	public function deletesuppliergroup(Request $request)
   {
		//dd($request->all());
     	SupplierGroup::where('id',$request->id)->delete();
     	return redirect()->back()->with('success','Supplier Deleted Successfull');
   }

     public function create()
    {
        $suppliergroups = SupplierGroup::orderBy('id','asc')->get();
        return view('backend.supplier.create',compact('suppliergroups'));
        //
    }

   public function store(Request $request)
    {
        // dd($request);
        $supplier = new Supplier;
        $supplier->supplier_name = $request->supplier_name;
        $supplier->group_category_id = $request->group_category;
        $supplier->group_id = $request->group_id;
        $supplier->opening_balance = $request->opening_balance;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->save();

        $this->createSupplierForCoa($request->supplier_name);
        return redirect()->route('supplier.index')
                        ->with('success','Supplier Create Successfull');
    }

   public function deletesupplier(Request $request)
   {
		//dd($request->all());
     	Supplier::where('id',$request->id)->delete();
     	return redirect()->back()->with('success','Supplier Deleted Successfull');
   }
  	public function editsupplier($id)
    {
      	$suppliergroups = SupplierGroup::orderBy('id','asc')->get();
    	$supplier = Supplier::where('id',$id)->first();
        return view('backend.supplier.supplier_edit',compact('supplier','suppliergroups'));
    }
 	public function update(Request $request)
    {
        $supplier = Supplier::where('id',$request->id)->first();
        $this->updateSupplierForCoa($supplier->supplier_name, $request->supplier_name);
        $supplier->supplier_name = $request->supplier_name;
        $supplier->group_category_id = $request->group_category;
        $supplier->group_id = $request->group_id;
        $supplier->opening_balance = $request->opening_balance;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->save();
        return redirect()->route('supplier.index')
                        ->with('success','Supplier Create Successfull');
    }

     //public function destroy(Request $request, $id)
     //{
     //   Supplier::findOrFail($request->id)->Delete($request->all());
     //   return redirect()->route('supplier.index')
     //                    ->with('delete', 'Supplier Delete  successfully .');
     // }

    public function groupindex()
    {
        $supplier = Supplier::orderBy('id','asc')->get();
        $suppliergroups = SupplierGroup::orderBy('id','asc')->get();
        return view('backend.supplier.groupindex',compact('supplier','suppliergroups'));
    }

    public function groupcreate()
    {
        return view('backend.supplier.groupcreate');
        //
    }

    public function groupstore(Request $request)
    {
        // dd($request);
        $supplier = new SupplierGroup;
        $supplier->group_name = $request->group_name;
        $supplier->proprietor_name = $request->proprietor_name;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->save();
        return redirect()->route('supplier.group.index')
                        ->with('success','Supplier Group Create Successfull');
    }

  public function suppliergroupedit($id)
  {
    $supliergroupdata =  SupplierGroup::where('id',$id)->first();
    return view('backend.supplier.supplier_group_edit',compact('supliergroupdata'));
  }

  public function suppliergroupupdate(Request $request)
  {
      	$supplier = SupplierGroup::where('id',$request->id)->first();
        $supplier->group_name = $request->group_name;
        $supplier->proprietor_name = $request->proprietor_name;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->save();
        return redirect()->route('supplier.group.index')
                        ->with('success','Supplier Group Create Successfull');

  }
  public function categorygroupcreate()
    {

        $cats = DB::table('supplier_categories')->get();

        return view('backend.supplier.group_category',compact('cats'));
        //
    }

   public function categorygroupstore(Request $request)
    {
        // dd($request);
     DB::table('supplier_categories')->insert([
     'category_name' => $request->category_name

     ]);

        return redirect()->route('supplier.category.group.create')
                        ->with('success','Supplier Create Successfull');
    }


     public function getsupplierbalance($id)
    {

         $purchaseamount = DB::table('purchases')
            ->where('raw_supplier_id',$id)
            ->sum('total_payable_amount');

       $purchasereturnamount = DB::table('purchase_returns')
            ->where('raw_supplier_id',$id)
            ->sum('total_amount');

      $purchase_amount  = $purchaseamount -  $purchasereturnamount;

        $payment_amount = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'PAYMENT')
            ->where('supplier_id',$id)
            ->sum('amount');

          $opb = DB::table('suppliers')

            ->where('id',$id)
            ->value('opening_balance');


        $current_blns = (($opb + $purchase_amount)-($payment_amount)) ;

        return $current_blns;

    }

public function agentIndex(){

  return view('backend.supplier.agent.index');
}

public function agentCreate(){
  return view('backend.supplier.agent.create');
}

}
