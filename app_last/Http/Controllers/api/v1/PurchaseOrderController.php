<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use DB;

class PurchaseOrderController extends Controller
{
    /* test
    public function allAsset(){
      $assets = Asset::select('assets.*','asset_types.asset_type_name','asset_clints.name','asset_categories.name as category_name')
        ->leftJoin('asset_categories', 'asset_categories.id', 'assets.asset_category_id')
          ->leftJoin('asset_types', 'asset_types.id', 'assets.asset_type')
            ->leftJoin('asset_clints', 'asset_clints.id', 'assets.client_id')
            ->where('intangible',0)->where('investment',0)
            ->get();
            if($assets){
                  return response()->json(['assets'=>$assets,'status'=>201]);
              }
              else
              {
                  return response()->json(['res'=>'Data Not Found','status'=>404]);
              }
    }
    test end */
    public function allPurchaseOrder(){
      $data = DB::table('purchase_order_creates as p')
        ->leftJoin('purchase_order_create_details as pd', 'p.id', '=', 'pd.purchase_order_id')
        ->select('p.id','p.date','p.supplier_id','p.deliveryDate','p.description', 'pd.id as pid','pd.product_id','pd.category_id','pd.unit','pd.rate','pd.quantity','pd.amount')
        ->where('p.status',1)->get();

        if($data){
              return response()->json(['allPurchaseOrder'=>$data,'status'=>201]);
          }
          else
          {
              return response()->json(['res'=>'Data Not Found','status'=>404]);
          }
    }
}
