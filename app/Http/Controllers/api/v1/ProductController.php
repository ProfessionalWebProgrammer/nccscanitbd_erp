<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesProduct;
use App\Models\SalesCategory;
use App\Models\ProductUnit;
use DB;


class ProductController extends Controller
{
  public function productCategory(){
    $data = SalesCategory::get();
    if($data){
            return response()->json(['category'=>$data,'status'=>201]);
        }
        else
        {
            return response()->json(['res'=>'Data Not Found','status'=>404]);
        }
  }

  public function productUnit(){
    $data = ProductUnit::get();
    if($data){
            return response()->json(['units'=>$data,'status'=>201]);
        }
        else
        {
            return response()->json(['res'=>'Data Not Found','status'=>404]);
        }
  }
  
    public function productCreate(Request $request){

      $proucts = new SalesProduct;
      $proucts->product_name  = $request->product_name ;
      $proucts->product_code  = $request->product_code ;
      $proucts->category_id  = $request->category_id ;
      $proucts->product_dimension  = $request->product_dimension ;
      $proucts->product_dimension_unit  = $request->product_dimension_unit ;
      $proucts->product_weight  = $request->product_weight ;
      $proucts->product_weight_unit  = $request->product_weight_unit ;
      $proucts->product_barcode  = $request->product_barcode ;
      $proucts->product_dp_price  = $request->product_dp_price ;
      $proucts->product_dealer_commision  = $request->product_dealer_commision ;
      $proucts->product_mrp  = $request->product_mrp ;
      $proucts->product_color  = $request->product_color ;
      $proucts->product_description  = $request->product_description ;

      $proucts->save();
      if($proucts->save()){
            return response()->json(['success'=>'Product Created Successfull','status'=>201]);
        }
        else
        {
            return response()->json(['res'=>'Data Not Found','status'=>404]);
        }
    }


}
