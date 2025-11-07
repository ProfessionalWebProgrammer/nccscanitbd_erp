<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Models\DealerArea;
use App\Models\DealerZone;
use App\Models\Factory;
use App\Models\TransportCost;
use Carbon\Carbon;
use Auth;
use DB;

class DealerController extends Controller
{
  public function getDealer(){
  $data = Dealer::all();
  if($data){
        return response()->json(['allDealer'=>$data,'status'=>201]);
    }
    else
    {
        return response()->json(['res'=>'Data Not Found','status'=>404]);
    }
}
  public function getWarehouse(){
    $data = Factory::get();
    if($data){
          return response()->json(['allWarehouse'=>$data,'status'=>201]);
      }
      else
      {
          return response()->json(['res'=>'Data Not Found','status'=>404]);
      }
  }

  public function dealerArea(){
    $data = DealerArea::get();
    if($data){
          return response()->json(['allDealerArea'=>$data,'status'=>201]);
      }
      else
      {
          return response()->json(['res'=>'Data Not Found','status'=>404]);
      }
  }

  public function dealerZone(){
    $data = DealerZone::get();
    if($data){
          return response()->json(['allDealerZone'=>$data,'status'=>201]);
      }
      else
      {
          return response()->json(['res'=>'Data Not Found','status'=>404]);
      }
  }

    public function dealerCreate(Request $request){
      $dealer = new Dealer;
      $dealer->d_s_name = $request->d_s_name;
      $dealer->dlr_spo_id = $request->dlr_spo_id;
      $dealer->dlr_lm_id = $request->dlr_lm_id;
      $dealer->d_proprietor_name = $request->d_proprietor_name;
      $dealer->d_s_code = $request->d_s_code;
      $dealer->dlr_code = $request->dlr_code;
      $dealer->dlr_type_id = $request->dlr_type_id;
      $dealer->dlr_op_date = $request->dlr_op_date;
      $dealer->dlr_op_month = $request->dlr_op_month;
      $dealer->dlr_police_station = $request->dlr_police_station;
      $dealer->dlr_area_id = $request->dlr_area_id;
      $dealer->dlr_mobile_no = $request->dlr_mobile_no;
      $dealer->dlr_base = $request->dlr_base;
      $dealer->dlr_dsm = $request->dlr_dsm;
      $dealer->dlr_subzone_id = $request->dlr_subzone_id;
      $dealer->dlr_zone_id = $request->dlr_zone_id;
      $dealer->monthly_target = $request->monthly_target;
      $dealer->dlr_commission = $request->dlr_commission;
      $dealer->dlr_address = $request->dlr_address;
      $dealer->dlr_mail = $request->dlr_mail;
      $dealer->dlr_tin_number = $request->dlr_tin_number;
      $dealer->save();

      if($dealer->save()){
         if($request->warehouse){
               $transportCost = new TransportCost();
                $transportCost->dealer_id = $dealer->id;
                $transportCost->warehouse_id = $request->warehouse;
                $transportCost->transport_cost = $request->trasport_cost;
                $transportCost->commission_per_ton = $request->commission_per_ton;
                $transportCost->commission_per_bag = $request->commission_per_bag;
                $transportCost->save();
          }

      }
      if($transportCost->save()){
            return response()->json(['success'=>'Dealer Created Successfull','status'=>201]);
        }
        else
        {
            return response()->json(['res'=>'Data Not Found','status'=>404]);
        }
    }
}
