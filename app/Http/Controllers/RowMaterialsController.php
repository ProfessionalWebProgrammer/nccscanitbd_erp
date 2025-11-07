<?php

namespace App\Http\Controllers;

use DB;
use App\Models\RowMaterialsProduct;
use App\Models\Department;
use App\Models\Supplier;
use App\Models\Factory;
use App\Models\WarehouseProduct;
use App\Models\SalesCategory;
use Illuminate\Http\Request;


class RowMaterialsController extends Controller
{
     public function index()
    {
        $products = RowMaterialsProduct::all();
       //$products = RowMaterialsProduct::where('id',3)->get();
       //dd($products);
        return view('backend.row_materials.index',compact('products'));
    }

      public function create()
    {
       	$categorys = SalesCategory::orderBy('id','desc')->get();
        $departments = Department::all();
        $warehous = Factory::get();
        return view('backend.row_materials.create', compact('categorys','departments','warehous'));
        //
    }

   public function store(Request $request)
    {
        //dd($request->all());
        $supplier = new RowMaterialsProduct;
        $supplier->product_name = $request->product_name;
        $supplier->code = $request->code;
        $supplier->unit = $request->unit;
        $supplier->category_id = $request->category_id;
        $supplier->rate = $request->rate;
        $supplier->department_id = $request->department_id;
      //  $supplier->opening_balance = $request->opening_balance;
        $supplier->days = $request->days;
        $supplier->min_stock = $request->min_stock;
        $supplier->save();

        foreach ($request->warehouse_id as $key => $value) {
          $wOpen = new WarehouseProduct;
          $wOpen->type  = $request->type;
          $wOpen->product_id  = $supplier->id;
          $wOpen->category_id  = $request->category_id;
          $wOpen->warehouse_id  = $value;
          $wOpen->opening  = $request->opening[$key];
          $wOpen->rate  = $request->rate;
          $wOpen->save();
        }
        return redirect()->route('row.materials.index')->with('success','Raw Materials Create Successfull');
    }

  public function edit($id){
  	//dd($id);
    $data = RowMaterialsProduct::findOrFail($id);
    $categorys = SalesCategory::orderBy('id','desc')->get();
    $departments = Department::all();
    $warehous = Factory::get();
   $warehousProducts = WarehouseProduct::where('product_id',$id)->where('type','raw')->get();
   return view('backend.row_materials.edit', compact('categorys','data','departments','warehous','warehousProducts'));
  }

 public function update(Request $request, $id)
    {
       //dd($id);
        RowMaterialsProduct::findOrFail($id)->update($request->all());
        foreach ($request->warehouse_id as $key => $value) {
          $wOpen = new WarehouseProduct;
          $wOpen->type  = $request->type;
          $wOpen->product_id  = $id;
          $wOpen->category_id  = $request->category_id;
          $wOpen->warehouse_id  = $value;
          $wOpen->opening  = $request->opening[$key];
          $wOpen->rate  = $request->rate;
          $wOpen->save();
        }
        return redirect()->route('row.materials.index')->with('success', 'Raw Materials Update  successfully .');
    }

   public function delete(Request $request)
    {
     	//dd($request->all());
        
        WarehouseProduct::where('product_id',$request->id)->where('type','raw')->delete();
        RowMaterialsProduct::where('id',$request->id)->delete();
        return redirect()->back()->with('success', 'Raw Materials Data Deleted successfully .');
    }


  public function rmIssuesList(){
      $data = DB::table('service_stock_outs')->select('service_stock_outs.*','suppliers.supplier_name','factories.factory_name','row_materials_products.product_name')
         		->leftjoin('suppliers', 'service_stock_outs.dealer_id', '=', 'suppliers.id')
            	->leftjoin('factories', 'service_stock_outs.warehouse_id', '=', 'factories.id')
        		->leftjoin('row_materials_products', 'service_stock_outs.product_id', '=', 'row_materials_products.id')
        		->get();
      //dd($data);
      return view('backend.rmIssue.index', compact('data'));
  }

  public function rmIssuesCreate(){
    $data = RowMaterialsProduct::whereNotIn('unit',['Kg','PCS'])->get();
    $dealers = Supplier::orderBy('supplier_name', 'ASC')->get();
    $factoryes = Factory::get();

	return view('backend.rmIssue.create', compact('data','dealers','factoryes'));
  }

  public function rmIssuesStore(Request $request){

    //dd($request->all());

	 $in = DB::table('service_stock_outs')->latest('id')->first();
      $temp = 0;
          if ($in) {
              $temp = 10000 + $in->id;
              $invoice = 'Sout-'.$temp;
          } else {
              $invoice = 'Sout-10000';
          }

    foreach($request->products_id as $key=> $data){
      DB::table('service_stock_outs')->insert([
        'date' => $request->date,
         'invoice' => $invoice,
        'dealer_id' => $request->dealer_id,
        'warehouse_id' => $request->warehouse_id,
        'product_id' =>  $request->products_id[$key],
        'unit' => $request->unit[$key],
        'qty' => $request->qty[$key],
        'issued_by' => $request->issued_by,
        'note' => $request->note,
        'status' => '1',
        ]);

    }

    return redirect()->back()->with('success','Purchase Raw Materials Issue Entry Successfull');
  }

  public function rmIssuesView($id){
  		$data = DB::table('service_stock_outs')->select('service_stock_outs.*','suppliers.supplier_name','factories.factory_name','row_materials_products.product_name')
         		->leftjoin('suppliers', 'service_stock_outs.dealer_id', '=', 'suppliers.id')
            	->leftjoin('factories', 'service_stock_outs.warehouse_id', '=', 'factories.id')
          		->leftjoin('row_materials_products', 'service_stock_outs.product_id', '=', 'row_materials_products.id')
        		->where('service_stock_outs.id',$id)->first();

     	return view('backend.rmIssue.invoice', compact('data'));
  }

  public function rmIssuesEdit($id){
   	$rawData = DB::table('rm_issues')->where('id',$id)->first();
    $data = RowMaterialsProduct::get();
   return view('backend.rmIssue.edit', compact('rawData','data'));
  }

  public function rmIssuesUpdate(Request $request, $id){
  //dd($request->all());
    foreach($request->product_id as $key=> $data){
      if(!empty($request->id[$key])){
        DB::table('rm_issues')->where('id',$request->id[$key])->update([
        'date' => $request->date,
        'product_id' => $request->product_id[$key],
        'unit' => $request->unit[$key],
        'qty' => $request->quantity[$key],
        'note' => $request->note,
         'issued_by' => $request->issued_by,
        ]);
      } else {
    	DB::table('rm_issues')->insert([
        'date' => $request->date,
        'product_id' => $request->product_id[$key],
        'unit' => $request->unit[$key],
        'qty' => $request->quantity[$key],
        'note' => $request->note,
         'issued_by' => $request->issued_by,
        ]);
        }
    }
    return redirect()->back()->with('success','Raw Materials Issue Updated Successfull');
  }

  public function rmIssuesDelete(Request $request){
    //dd($request->id);

    DB::table('service_stock_outs')->where('id',$request->id)->delete();
        return redirect()->back()->with('success', 'Stock Out Issue Data Deleted successfully .');
  }
}
