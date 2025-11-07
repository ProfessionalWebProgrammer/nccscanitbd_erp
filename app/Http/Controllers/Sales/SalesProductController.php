<?php
namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\SalesStockIn;
use App\Models\SalesProduct;
use App\Models\SalesCategory;
use App\Models\ProductUnit;
use App\Models\Factory;
use App\Models\WarehouseProduct;
use DB;

class SalesProductController extends Controller
{
    public function index()
    {
        $categories = SalesCategory::latest('id')->get();
        $products = DB::select('SELECT sales_products.*,sales_categories.category_name FROM `sales_products`
                LEFT JOIN sales_categories on sales_categories.id = sales_products.category_id
                ORDER BY `sales_products`.`id` DESC');
        return view('backend.sales_product.index',compact('products','categories'));
    }
    
  	public function deleteproduct(Request $request)
    {
    	//dd($request->all());
      	SalesProduct::where('id',$request->id)->delete();
      	WarehouseProduct::where('product_id',$request->id)->where('type','fg')->delete();
        return redirect()->back()->with('success','Product Deleted Successffull');
    }
    
    public function create()
    {
        $categories = SalesCategory::latest('id')->get();
        $units = ProductUnit::get();
        $warehous = Factory::get();
        return view('backend.sales_product.create',compact('categories','units','warehous'));
    }

    public function store(Request $request)
    {
       // dd($request->all());
       $proucts = new SalesProduct;
        $proucts->product_name  = $request->product_name ;
        $proucts->product_code  = $request->product_code ;
        $proucts->category_id  = $request->category_id ;
        $proucts->product_dimension  = $request->product_dimension ;
        $proucts->product_dimension_unit  = $request->product_dimension_unit ;
        $proucts->product_weight  = $request->product_weight ;
        $proucts->product_weight_unit  = $request->product_weight_unit ;
        $proucts->product_unit  = $request->product_unit;
        $proucts->product_barcode  = $request->product_barcode ;
        $proucts->product_dp_price  = $request->product_dp_price ;
        $proucts->product_dealer_commision  = $request->product_dealer_commision ;
        $proucts->product_mrp  = $request->product_mrp ;
        $proucts->rate  = $request->rate;
        $proucts->product_color  = $request->product_color ;
        $proucts->product_description  = $request->product_description ;
        $proucts->save();

        foreach ($request->warehouse_id as $key => $value) {
          $wOpen = new WarehouseProduct;
          $wOpen->type  = $request->type;
          $wOpen->product_id  = $proucts->id;
          $wOpen->category_id  = $request->category_id;
          $wOpen->warehouse_id  = $value;
          $wOpen->opening  = $request->opening[$key];
          $wOpen->rate  = $request->rate;
          $wOpen->save();
        }



       /* if($request->rate && $request->opening_balance){
          $stock = new SalesStockIn;
          $stock->prouct_id = $proucts->id;
          $stock->quantity = $request->opening_balance;
          $stock->total_cost = $request->opening_balance*$request->rate;
          $stock->production_rate = $request->rate;
          $stock->date = date('Y-m-d');
          $stock->referance = 'Opening Stock';
          $stock->save();

          return redirect()->Route('sales.item.index')->with('success','Product Create & Stock Successffull');
        } else {
            return redirect()->Route('sales.item.index')->with('success','Product Create Successffull But Stock not Successffull');
        }
        */
        return redirect()->Route('sales.item.index')->with('success','Product Create Successffull');
}

    public function getdpprice($id)
      {
        $dpprice = DB::select('SELECT products.product_dp_price FROM `sales_products` WHERE products.id="'.$id.'" ');
        return response($dpprice);
      }

      // Product Edit by Reza
    public function editproduct($id)
      {
        $itemdata = SalesProduct::where('id', $id)->first();
        $categories = SalesCategory::latest('id')->get();
        $units = ProductUnit::get();
        $warehous = Factory::get();
        $warehousProducts = WarehouseProduct::where('product_id',$id)->where('type','fg')->get();
        
        return view('backend.sales_product.edititems', compact('itemdata', 'categories','units','warehous','warehousProducts'));
      }

    // Product update by Reza
    public function updateItem(Request $request, $id)
    {

       $proucts = SalesProduct::where('id', $id)->first();

        /* if(empty($proucts->rate) || empty($proucts->opening_balance)){
          $stock = new SalesStockIn;
          $stock->prouct_id = $proucts->id;
          $stock->quantity = $request->opening_balance;
          $stock->total_cost = $request->opening_balance*$request->rate;
          $stock->production_rate = $request->rate;
          $stock->date = date('Y-m-d');
          $stock->referance = 'Opening Stock';
          $stock->save();
        } */

        $proucts->product_name  = $request->product_name;
        $proucts->product_code  = $request->product_code;
        $proucts->category_id  = $request->category_id;
        $proucts->product_dimension  = $request->product_dimension;
        $proucts->product_dimension_unit  = $request->product_dimension_unit;
        $proucts->product_weight  = $request->product_weight;
        $proucts->product_weight_unit  = $request->product_weight_unit;
        $proucts->product_unit  = $request->product_unit;
        $proucts->product_barcode  = $request->product_barcode;
        $proucts->product_dp_price  = $request->product_dp_price;
        $proucts->product_dealer_commision  = $request->product_dealer_commision;
        $proucts->product_mrp  = $request->product_mrp;
        //$proucts->rate  = $request->rate;
        //$proucts->opening_balance  = $request->opening_balance;
        $proucts->product_color  = $request->product_color;
        $proucts->product_description  = $request->product_description;
        $proucts->save();

        foreach ($request->warehouse_id as $key => $value) {
          $wOpen = new WarehouseProduct;
          $wOpen->type  = $request->type;
          $wOpen->product_id  = $proucts->id;
          $wOpen->category_id  = $request->category_id;
          $wOpen->warehouse_id  = $value;
          $wOpen->opening  = $request->opening[$key];
          $wOpen->rate  = $request->rate;
          $wOpen->save();
        }

        return redirect()->Route('sales.item.index')->with('success', 'Product Update Successffull');
    }

    
    
    //public function update(Request $request, $id)
    //{
        // dd($request);
     //   $request->validate([
     //       'product_name' => 'required',
     //       'product_code' => 'required',
     //   ]);
  //
 //       SalesProduct::findOrFail($request->id)->update($request->all());
//        return redirect()->route('sales.item.index')
  //                      ->with('success', 'Products Update  successfully .');
 //   }

    public function destroy(Request $request, $id)
    {
        SalesProduct::findOrFail($request->id)->Delete($request->all());
        return redirect()->route('sales.item.index')
                        ->with('delete', 'Products Delete  successfully .');
    }


      public function getproduct($category_id)
    {
        $products= DB::table('sales_products')
        				->where('category_id',$category_id)
                        ->get();

  // echo json_encode($products);
        return response($products);
    }

  //Product Unit
  	public function productunitcreate()
    {
      $units = ProductUnit::orderBy('unit_name','asc')->get();
      return view('backend.sales_product.product_unit',compact('units'));
    }

  	public function productunitstore(Request $request)
    {
      $storeunit = new ProductUnit();
      $storeunit->unit_name = $request->unit_name;
      $storeunit->unit_pcs = $request->unit_pcs;
      $storeunit->save();

      return redirect()->back()->with('success','Product Unit Created Successfull!');
    }

  	public function deleteunit(Request $request)
    {
      	ProductUnit::where('id',$request->id)->delete();
        return redirect()->back()->with('success','Product Unit Deleted Successfull!');
    }

  	public function editunit($id)
    {
    	$units = ProductUnit::where('id',$id)->first();
        return view('backend.sales_product.edit_unit',compact('units'));
    }

  	public function productunitupdate(Request $request)
    {
      $storeunit =  ProductUnit::where('id',$request->id)->first();
      $storeunit->unit_name = $request->unit_name;
      $storeunit->unit_pcs = $request->unit_pcs;
      $storeunit->save();

      return redirect()->route('product.unit.create')->with('success','Product Unit Updated Successfull!');
    }


    public function getProductApilist()
    {
        $categories = SalesCategory::latest('id')->get();
        $products = DB::select('SELECT sales_products.*,sales_categories.category_name FROM `sales_products`
                LEFT JOIN sales_categories on sales_categories.id = sales_products.category_id
                ORDER BY `sales_products`.`id` DESC');

      //return response($products);
      if($products){
            return response()->json(['post'=>$products,'status'=>201]);
        }
        else
        {
            return response()->json(['res'=>'Data Not Found','status'=>404]);
        }

        //return view('backend.sales_product.index',compact('products','categories'));
    }


}
