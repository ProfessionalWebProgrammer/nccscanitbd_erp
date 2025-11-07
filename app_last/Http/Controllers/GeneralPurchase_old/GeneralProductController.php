<?php

namespace App\Http\Controllers\GeneralPurchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralCategory;
use App\Models\GeneralSubCategory;
use App\Models\GeneralProduct;
use Illuminate\Support\Facades\DB;

class GeneralProductController extends Controller
{
    public function generalproductcreate()
    {
        $gcategory = GeneralCategory::all();
        return view('backend.general_purchase.ganeral_product_create', compact('gcategory'));
    }

    public function generalproductstore(Request $request)
    {
        // dd($request);
        $generalproduct = new GeneralProduct();
        $generalproduct->gproduct_name = $request->product_name;
        $generalproduct->general_category_id = $request->category_id;
        $generalproduct->general_sub_category_id = $request->sub_category_id;
        $generalproduct->opening_balance = $request->opening_balance;
        $generalproduct->rate = $request->product_rate;
        $generalproduct->dimensions = $request->product_dimension;
        $generalproduct->save();

        return redirect()->route('general.product.list')->with('success', 'Product Created Successfull');
    }

    public function generalproductlist()
    {
        $productdata = DB::table('general_products')
            ->select('general_products.*', 'general_categories.gcategory_name', 'general_sub_categories.general_sub_category_name')
            ->leftJoin('general_categories', 'general_categories.id', 'general_products.general_category_id')
            ->leftJoin('general_sub_categories', 'general_sub_categories.id', 'general_products.general_sub_category_id')
            ->get();
        // dd($productdata);
        return view('backend.general_purchase.product_list', compact('productdata'));
    }



    // ajax function Get Sub category By Main Category
    public function getsubcatbymaincat($id)
    {
        $subcategorydata = GeneralSubCategory::where('general_category_id', $id)->get();
        return response()->json($subcategorydata);
    }

    public function getgproductprice($id)
    {
        $gproductprice = GeneralProduct::where('id', $id)->first();
        return response($gproductprice);
    }
   public function generalproductedit($id)
    {	
     	$gproduct = GeneralProduct::where('id',$id)->first();
     	$subcat = GeneralSubCategory::where('general_category_id',$gproduct->general_category_id)->get();
        $gcategory = GeneralCategory::all();
        return view('backend.general_purchase.general_product_edit', compact('gcategory','gproduct','subcat'));
    }
  
  	public function generalproductrestore(Request $request)
    {
        //dd($request->all());
        $generalproduct = GeneralProduct::where('id',$request->id)->first();
        $generalproduct->gproduct_name = $request->product_name;
        $generalproduct->general_category_id = $request->category_id;
        $generalproduct->general_sub_category_id = $request->sub_category_id;
        $generalproduct->opening_balance = $request->opening_balance;
        $generalproduct->rate = $request->product_rate;
        $generalproduct->dimensions = $request->product_dimension;
        $generalproduct->save();

        return redirect()->route('general.product.list')->with('success', 'Product Created Successfull');
    }
    public function destroy(Request $request)
    {
      //dd($request->all());
      GeneralProduct::where('id',$request->id)->delete();
      return redirect()->back()->with('success','General Product Deteletd Successfull!');
    }
}
