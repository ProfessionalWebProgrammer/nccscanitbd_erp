<?php
namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\DealerArea;
// use App\DealerLineManager;
// use App\DealerSpo;
use App\Models\DealerType;
use App\Models\DealerZone;
use App\Models\DealerSubzone;
use App\Models\Dealer;
use App\Models\Employee;
use App\Models\DealerDelete;
use App\Models\TransportCost;
use App\Models\Factory;
use App\Models\DealerArchive;
use App\Models\SalesLedger;
use App\Models\SalesCategory;
use App\Models\Sale;
use App\Models\MontlySalesTarget;
use App\Models\Payment;
use App\Models\TransportCostArchive;
use Carbon\Carbon;
use App\Traits\AccountInfoAdd;


use Auth;
use DB;



class DealerController extends Controller
{
  use AccountInfoAdd;
    public function index(Request $request)
    {
         $rdarea = $request->dlr_area_id;
      $rdzone = $request->dlr_zone_id;
      $dealerzone = DealerZone::All();
      $dealerarea = DealerArea::All();

      if (!($rdarea) && !($rdzone)) {
        $dealer = DB::select('select dealers.id,dealers.d_s_name,dealers.d_proprietor_name,dealers.d_s_code,dealers.dlr_code,dealers.dlr_op_date,dealers.dlr_police_station,dealers.dlr_base,dealers.dlr_address,
        dealers.dlr_mobile_no, dealer_spos.sop_name ,dealer_areas.area_title,dealer_subzones.subzone_title,dealer_zones.zone_title,dealer_types.type_title
        from dealers
        left join dealer_spos on dealers.dlr_spo_id = dealer_spos.id
        LEFT JOIN dealer_areas on dealers.dlr_area_id = dealer_areas.id
        LEFT JOIN dealer_subzones ON dealers.dlr_subzone_id = dealer_subzones.id
        LEFT JOIN dealer_zones ON dealers.dlr_zone_id = dealer_zones.id
        LEFT JOIN dealer_types ON dealer_types.id = dealers.dlr_type_id');
      }else{
        if (($rdarea) && !($rdzone)) {
          $dealer = DB::select('select dealers.id,dealers.d_s_name,dealers.d_proprietor_name,dealers.d_s_code,dealers.dlr_code,dealers.dlr_op_date,dealers.dlr_police_station,dealers.dlr_base,dealers.dlr_address,
        dealers.dlr_mobile_no, dealer_spos.sop_name ,dealer_areas.area_title,dealer_subzones.subzone_title,dealer_zones.zone_title,dealer_types.type_title
        from dealers
        left join dealer_spos on dealers.dlr_spo_id = dealer_spos.id
        LEFT JOIN dealer_areas on dealers.dlr_area_id = dealer_areas.id
        LEFT JOIN dealer_subzones ON dealers.dlr_subzone_id = dealer_subzones.id
        LEFT JOIN dealer_zones ON dealers.dlr_zone_id = dealer_zones.id
        LEFT JOIN dealer_types ON dealer_types.id = dealers.dlr_type_id
        WHERE dealer_areas.id="'.$rdarea.'"');

        }elseif(!($rdarea) && ($rdzone)){
          $dealer = DB::select('select dealers.id,dealers.d_s_name,dealers.d_proprietor_name,dealers.d_s_code,dealers.dlr_code,dealers.dlr_op_date,dealers.dlr_police_station,dealers.dlr_base,dealers.dlr_address,
        dealers.dlr_mobile_no, dealer_spos.sop_name ,dealer_areas.area_title,dealer_subzones.subzone_title,dealer_zones.zone_title,dealer_types.type_title
        from dealers
        left join dealer_spos on dealers.dlr_spo_id = dealer_spos.id
        LEFT JOIN dealer_areas on dealers.dlr_area_id = dealer_areas.id
        LEFT JOIN dealer_subzones ON dealers.dlr_subzone_id = dealer_subzones.id
        LEFT JOIN dealer_zones ON dealers.dlr_zone_id = dealer_zones.id
        LEFT JOIN dealer_types ON dealer_types.id = dealers.dlr_type_id
        WHERE dealer_zones.id="'.$rdzone.'"');
        }else{
          $dealer = DB::select('select dealers.id,dealers.d_s_name,dealers.d_proprietor_name,dealers.d_s_code,dealers.dlr_code,dealers.dlr_op_date,dealers.dlr_police_station,dealers.dlr_base,dealers.dlr_address,
        dealers.dlr_mobile_no, dealer_spos.sop_name ,dealer_areas.area_title,dealer_subzones.subzone_title,dealer_zones.zone_title,dealer_types.type_title
        from dealers
        left join dealer_spos on dealers.dlr_spo_id = dealer_spos.id
        LEFT JOIN dealer_areas on dealers.dlr_area_id = dealer_areas.id
        LEFT JOIN dealer_subzones ON dealers.dlr_subzone_id = dealer_subzones.id
        LEFT JOIN dealer_zones ON dealers.dlr_zone_id = dealer_zones.id
        LEFT JOIN dealer_types ON dealer_types.id = dealers.dlr_type_id
        WHERE dealer_zones.id="'.$rdzone.'" And dealer_zones.id="'.$rdzone.'"');
        }

      }

      if($request->vendor_id){
       $dealer = DB::select('select dealers.id,dealers.d_s_name,dealers.d_proprietor_name,dealers.d_s_code,dealers.dlr_code,dealers.dlr_op_date,dealers.dlr_police_station,dealers.dlr_base,dealers.dlr_address,
        dealers.dlr_mobile_no, dealer_spos.sop_name ,dealer_areas.area_title,dealer_subzones.subzone_title,dealer_zones.zone_title,dealer_types.type_title
        from dealers
        left join dealer_spos on dealers.dlr_spo_id = dealer_spos.id
        LEFT JOIN dealer_areas on dealers.dlr_area_id = dealer_areas.id
        LEFT JOIN dealer_subzones ON dealers.dlr_subzone_id = dealer_subzones.id
        LEFT JOIN dealer_zones ON dealers.dlr_zone_id = dealer_zones.id
        LEFT JOIN dealer_types ON dealer_types.id = dealers.dlr_type_id
        WHERE dealers.id="'.$request->vendor_id.'" ');
      }
        return view('backend.dealer.index',compact('dealer','dealerzone','dealerarea','rdarea','rdzone'));
    }

    // public function Search(Request $request){


    // }
    public function getcreate()
    {
        $dealerlm = Employee::All();
        $dealerspo = Employee::All();
        $dealertype = DealerType::All();
        $dealerzone = DealerZone::All();
        $dealersubzone = DealerSubzone::All();
        $dealerarea = DealerArea::All();
        $factory = Factory::all();
      	$category = SalesCategory::whereNotIn('id',[31,32])->get();
     
        return view('backend.dealer.create',compact('dealerlm','dealerspo','dealertype','dealerzone','dealerarea','factory','dealersubzone','category'));
    }



    public function postcreate(Request $request)
    {
      //dd($request->all());
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
        // $dealer->save();
        if($dealer->save()){
           $this->createDealerForCoa($request->d_s_name);
         //   $ledger = new SalesLedger();
         //   $ledger->vendor_id = $dealer->id;
         //   $ledger->area_id = $dealer->dlr_area_id;
         //   $ledger->warehouse_bank_name = 'Opening Balance';
          //  $ledger->ledger_date = '2020-01-01 00:00:00';
         //   $ledger->closing_balance = $request->dlr_base;
         //   $ledger->credit_limit = $request->dlr_police_station;
         //   $ledger->save();
          if($request->category_id){
             foreach($request->category_id as $key=>$data){
          	 DB::table('fixed_dealer_comissions')->insert([
               'dealer_id' => $dealer->id,
               'category_id' => $request->category_id[$key],
               'commission' => $request->commission[$key]
             ]);
             }
          }
           if($request->warehouse){
            foreach($request->warehouse as $key=>$warehouse){
                 $transportCost = new TransportCost();
                  $transportCost->dealer_id = $dealer->id;
                  $transportCost->warehouse_id = $warehouse;
                  $transportCost->transport_cost = $request->trasport_cost[$key];
              	  $transportCost->commission_per_ton = $request->commission_per_ton[$key];
                  $transportCost->commission_per_bag = $request->commission_per_bag[$key];
                  $transportCost->save();
            }

           }


        }
        return redirect()->Route('dealer.index')
                            ->with('success', 'Vendor Create Successfull');
        // dd($dealer);
    }

        public function eidtDealer($id)
          {
            $vendorData = Dealer::where('id', $id)->first();
            $dealerlm = Employee::All();
            $dealerspo = Employee::All();
            $dealertype = DealerType::All();
            $dealerzone = DealerZone::All();
            $dealersubzone = DealerSubzone::All();
            $dealerarea = DealerArea::All();
            $factory = Factory::all();
			$category = SalesCategory::whereNotIn('id',[31,32])->get();
            $trscost = DB::table('transport_costs')->where('dealer_id',$id)->get();
			$fixedCom = DB::table('fixed_dealer_comissions')->where('dealer_id',$id)->get();
          
          $c = 0;
          $c = count($fixedCom);
            return view('backend.dealer.editdealer', compact('vendorData','trscost', 'dealerlm', 'dealerspo', 'dealertype', 'dealerzone', 'dealerarea', 'factory', 'dealersubzone','category','fixedCom'));
          }


    public function editAll(){
      $dealer =  DB::table('dealers')->get();
       //  $dealer = DB::select('select dealers.id,dealers.d_s_name,dealers.dlr_police_station, dealers.dlr_base from dealers')->paginate(300);
      return view('Dealer.editAll',compact('dealer'));
   }

    public function posteditAll(Request $request)
   {
        // dd($request);
       foreach($request->id as $key => $id){

           $dealer = DB::table('dealers')->where('id', $id)->update([
               'dlr_police_station' => $request->dlr_police_station[$key],
               'dlr_base' => $request->dlr_base[$key]
           ]);
           // dd($dealer);
             if($dealer){
          // $ledger =  SalesLedger::where('vendor_id',$id)->where('warehouse_bank_name','Opening Balance')->first();

         //  $ledger->closing_balance = $request->dlr_base[$key];
          // $ledger->credit_limit = $request->dlr_police_station[$key];
         //  $ledger->save();


              $ledger =  SalesLedger::where('vendor_id',$id)->where('warehouse_bank_name','Opening Balance')->first();
     // dd($ledger);
               $ledger->vendor_id = $id;

               $ledger->closing_balance = $request->dlr_base[$key];
               $ledger->credit_limit = $request->dlr_police_station[$key];
               $balance_amount_opening = $request->dlr_base[$key] - $ledger->closing_balance;
               $balance_amount_credit_limit = $request->dlr_police_station[$key] - $ledger->credit_limit;
               $ledger->save();
               $ledgers = SalesLedger::where('vendor_id',$ledger->vendor_id)->where('id','>',$ledger->id)->get();
                 foreach ($ledgers as $key => $value) {
                     $ledger_update = SalesLedger::find($value->id);
                     $ledger_update->closing_balance = $ledger_update->closing_balance + $balance_amount_opening; //dlr_base means closing Balance previous developer did it
                     $ledger_update->credit_limit = $ledger_update->credit_limit + $balance_amount_credit_limit;
                     $ledger_update->save();
                 }

           }
       }

       return redirect()->Route('dealer.index')
                           ->with('success', 'Saved Successfull');

   }




   public function postdealeredit(Request $request)
   {	
     //dd($request->all());
       $uid = Auth::id();

    	$dlrdata = Dealer::where('id',$request->id)->first();
        $dlrdata = $dlrdata->makeHidden(['id','updated_at'])->toArray();

	   $pdid = DealerArchive::insertGetId($dlrdata);
     	//dd($pdid);
     
          	$pddata = DealerArchive::where('id',$pdid)->first();
          	$pddata->dealer_id = $request->id;
          	$pddata->updated_user = $uid;
          $pddata-> save();

    
       $id=$request->id;
       $dealer = Dealer::find($id);
       
       $this->updateDealerForCoa($dealer->d_s_name,$request->d_s_name);
       
        //dd($id);
       $dealer->d_s_name = $request->d_s_name;
       $dealer->dlr_spo_id = $request->dlr_spo_id;
       $dealer->dlr_lm_id = $request->dlr_lm_id;
       $dealer->d_proprietor_name = $request->d_proprietor_name;
       $dealer->d_s_code = $request->d_s_code;
       $dealer->dlr_code = $request->dlr_code;
       $dealer->dlr_type_id = $request->dlr_type_id;
       $dealer->dlr_op_date = $request->dlr_op_date;
       $dealer->dlr_cl_date = $request->dlr_cl_date;
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
       $dealer->updated_user = $uid;

      $dealer->extra_credit_limit = $request->extra_credit_limit;
        if($request->extra_credit_limit != null && $request->extra_credit_limit >0){
            $date = $request->date;

            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));

			$dealer->cl_fdate = $fdate;
			$dealer->cl_tdate = $tdate;
        }


     $openigBalance = null;
     if($request->dlr_cl_date != null){

       $opdata =  DB::table('sales_ledgers as t1')->select(
            'vendor_id',
            DB::raw('sum(CASE WHEN t1.ledger_date  < "'.$request->dlr_cl_date.'" THEN `debit` ELSE null END) as debit_a'),
            DB::raw('sum(CASE WHEN t1.ledger_date <"'.$request->dlr_cl_date.'" THEN `credit` ELSE null END) as credit_a')
           )->where('vendor_id',$id)->first();

        $openigBalance = $request->dlr_base+$opdata->debit_a-$opdata->credit_a;

        $ledger =  SalesLedger::where('vendor_id',$id)->where('priority',9)->first();
     	if($ledger){

          		$ledger->vendor_id = $id;
				$ledger->ledger_date = $request->dlr_cl_date;
                $ledger->closing_balance = $openigBalance;

               $ledger->save();

        }else{
        		$ledger = new SalesLedger;
          		$ledger->vendor_id = $id;
          		$ledger->ledger_date = $request->dlr_cl_date;

               $ledger->warehouse_bank_name = "New Year Start";
               $ledger->closing_balance = $openigBalance;
           $ledger->priority = 9;

               $ledger->save();
        }

    // dd($openigBalance);
     }

     $dealer->dlr_cb = $openigBalance;

       if($dealer->save()){

          $sales =  \App\Models\Sale::where('dealer_id',$dealer->id)->update([
                  'vendor_area_id' => $request->dlr_area_id
               ]);


             //  dd($dealer->dlr_subzone_id);
                $mm =  DB::table('montly_sales_targets')->where('dealer_id',$dealer->id)->update([
                  'area_id' => $request->dlr_area_id,
                  'subzone_id' => $dealer->dlr_subzone_id,
                  'zone_id' => $dealer->dlr_zone_id
               ]);

         //  $ledger =  SalesLedger::where('vendor_id',$dealer->id)->where('warehouse_bank_name','Opening Balance')->first();
          // dd($ledger);
         //  $ledger->vendor_id = $dealer->id;

         //  $ledger->closing_balance = $request->dlr_base;
         //  $ledger->credit_limit = $request->dlr_police_station;
         //  $balance_amount_opening = $request->dlr_base - $ledger->closing_balance;
        //   $balance_amount_credit_limit = $request->dlr_police_station - $ledger->credit_limit;
        //   $ledger->save();
        //   $ledgers = SalesLedger::where('vendor_id',$ledger->vendor_id)->where('id','>',$ledger->id)->get();
   //    foreach ($ledgers as $key => $value) {
     //      $ledger_update = SalesLedger::find($value->id);
       //    $ledger_update->closing_balance = $ledger_update->closing_balance + $balance_amount_opening; //dlr_base means closing Balance previous developer did it
      //     $ledger_update->credit_limit = $ledger_update->credit_limit + $balance_amount_credit_limit;
     //      $ledger_update->save();
     //  }

          $transport_data = TransportCost::where('dealer_id',$id)
               ->get();
         foreach ($transport_data as $key=>$tdata){
          $olddata = $tdata->makeHidden(['id','updated_at'])->toArray();

            $tcaid =  TransportCostArchive::insertGetId($olddata);
        	$tddata = TransportCostArchive::where('id',$tcaid)->first();
            $tddata->updated_at = Carbon::now();
         	$tddata->save();
      		 }

		DB::table('fixed_dealer_comissions')->where('dealer_id',$id)->delete();
		if($request->category_id){
             foreach($request->category_id as $key=>$data){
          	 DB::table('fixed_dealer_comissions')->insert([
               'dealer_id' => $id,
               'category_id' => $request->category_id[$key],
               'commission' => $request->commission[$key]
             ]);
             }
          }

      // dd($transport_data);

       $transport_delete = TransportCost::where('dealer_id',$id)
               ->delete();
       foreach ($request->warehouse as $key=>$warehouse){

               $transport = new TransportCost();
                 $transport->dealer_id = $id;
                $transport->warehouse_id = $warehouse;
                 $transport->transport_cost = $request->trasport_cost[$key];
         			$transport->commission_per_ton = $request->commission_per_ton[$key];
                  $transport->commission_per_bag = $request->commission_per_bag[$key];
                 $transport->save();

       }

       }
       return redirect()->Route('dealer.index')
                           ->with('success', 'Edit  Successfull Updated');
   }

  
   public function DealerLedger(){
       $dealers = Dealer::all();
       foreach($dealers as $dealer){
          $ledger = new SalesLedger();
          $ledger->ledger_date = $dealer->created_at;
          $ledger->vendor_id = $dealer->id;
          $ledger->warehouse_bank_name = 'OPENING BALANCE';
          $ledger->is_bank = 3;
           $ledger->closing_balance = (isset($dealer->dlr_base) and is_numeric($dealer->dlr_base))?$dealer->dlr_base:0;
           $ledger->credit_limit = (isset($dealer->dlr_police_station) and is_numeric($dealer->dlr_police_station))?$dealer->dlr_police_station:0;
           $ledger->save();

       }

   }


    public function destroy(Request $request)
    {
		//dd($request->id);
        $dlrdetils = Dealer::where('id',$request->id)->first();

         //$op_b = $dlrdetils->dlr_base;

         $debit_a = SalesLedger::where('vendor_id', $request->id)->sum('debit');
         $cretid_a = SalesLedger::where('vendor_id', $request->id)->sum('credit');

         $c_balane = $debit_a - $cretid_a;

        //dd($c_balane+$op_b);
      //  if($c_balane+$op_b == 0){
     //    Dealer::findOrFail($request->id)->Delete($request->all());
      //   return redirect()->route('dealer.index')
     //                   ->with('delete', 'Dealer Delete  successfully .');
      //  }else{
      //  return redirect()->route('dealer.index')
     //                   ->with('delete', 'Dealer Delete  Faild! Please Check Ledger. And Clear ALL Balance');
     //   }



      $uid = Auth::id();

    	$dlrdata = Dealer::where('id',$request->id)->first();
        $dlrdata = $dlrdata->makeHidden(['created_at','updated_at'])->toArray();
        //dd($dlrdata);
	   $pdid = DealerDelete::insertGetId($dlrdata);
          	$pddata = DealerDelete::where('id',$pdid)->first();
          	$pddata -> deleted_by = $uid;
          	$pddata -> save();

         $delereDelete =  Dealer::findOrFail($request->id)->Delete($request->all());

       if($delereDelete){

         $tdata = SalesLedger::where('vendor_id',$request->id)->get();
       $mdata = MontlySalesTarget::where('dealer_id',$request->id)->get();



          foreach($tdata as $t){
            $olddata = $t->makeHidden(['id'])->toArray();

            DB::table('sales_ledger_archives')->insert($olddata);
         }
          foreach($mdata as $p){
            $olddata = $p->makeHidden(['id'])->toArray();

            DB::table('montly_sales_terget_archives')->insert($olddata);
         }


         $sdata = Sale::where('dealer_id',$request->id)->update(['is_active'=>0]);
      	 $tdata = SalesLedger::where('vendor_id',$request->id)->delete();
       	 $mdata = MontlySalesTarget::where('dealer_id',$request->id)->delete();
       	 $pdata =Payment::where('vendor_id',$request->id)->update(['status'=>0]);


       }
        return redirect()->route('dealer.index')->with('success', 'Dealer Delete  successfully .');
    }

    public function passwordset()
    {
        $dealers = Dealer::latest('id')->where('user_id','=',null)->get();
        return view('Dealer.passwordset',compact('dealers'));
    }

    public function password(Request $request)
    {
        // dd($readdir()quest);
        $password=trim($request->dealer_password);

        $dlid = $request->dealer_id;
        $user = new User;
            $user->name                                 = $request->dealer_name;
            $user->email                                = $request->dealer_mail;
            $user->password                             = bcrypt($password);
            $user->save();

        $userrole = new Role_user;
            $userrole->role_id      = 4;
            $userrole->user_id      = $user->id;
            $userrole->save();


           $finddlid = Dealer::find($dlid);
           $finddlid ->user_id=$user->id;
           $finddlid ->save();
           return back()->with('success','Password set Successfully');
    }
    public function dealerAreaSugestion(Request $request){
        $searchTerm = $request->term;
        $dealer_area = DealerArea::where('area_title', 'LIKE', "%{$searchTerm}%")->get();
        $arealist = array();
         foreach($dealer_area as $area){

            $arealist[] = array(
                'id'=>$area->id,
                'label'=>  $area->area_title,
                'value'=>$area->area_title,
            );
        }
        return json_encode($arealist);
    }

  public function transferindex()
    {
        $dealerrrr = DB::select('select DISTINCT dealers.dlr_zone_id,dealer_zones.zone_title, COUNT(dealers.id) as dealerId
        from dealers
        LEFT JOIN dealer_zones ON dealers.dlr_zone_id = dealer_zones.id
        GROUP BY dealers.dlr_zone_id,dealer_zones.zone_title');

         $dealer = DB::select('select DISTINCT dealers.dlr_area_id,dealer_areas.area_title, dealers.dlr_zone_id,dealer_zones.zone_title, COUNT(dealers.id) as dealerId
        from dealers
        LEFT JOIN dealer_areas on dealers.dlr_area_id = dealer_areas.id
        LEFT JOIN dealer_zones ON dealers.dlr_zone_id = dealer_zones.id
        GROUP BY dealers.dlr_area_id,dealer_areas.area_title,dealers.dlr_zone_id,dealer_zones.zone_title');


       // dd($dealerarea);

       $zones = DealerZone::all();
       $areas = DealerArea::all();
        return view('DealerSettings.DealerTransfer.index',compact('zones','areas'));
    }
     public function postvendortransfer(Request $request){

     // dd($request->all());

       if($request->from_zone_id != null && $request->to_zone_id != null){
        $update1 = Dealer::where('dlr_zone_id',$request->from_zone_id)->update(['dlr_zone_id' => $request->to_zone_id]);
        		DB::table('montly_sales_targets')->where('zone_id',$request->from_zone_id)->update([
                    'zone_id' => $request->to_zone_id
                ]);
        }

      if($request->from_area_id != null && $request->to_area_id != null ){

       $subzoneid = DealerArea::where('id',$request->to_area_id)->value('subzone_id');
       //dd($subzoneid);
       $update2 = Dealer::where('dlr_area_id',$request->from_area_id)->update([
       		'dlr_area_id' => $request->to_area_id,
       		'dlr_subzone_id' => $subzoneid
       ]);

         $mm =  DB::table('montly_sales_targets')->where('area_id',$request->from_area_id)->update([
                   'area_id' => $request->to_area_id,
                   'subzone_id' => $subzoneid
                ]);
      }


      if($request->a_to_z_area_id != null && $request->a_to_z_zone_id != null ){
       $update3 = Dealer::where('dlr_area_id',$request->a_to_z_area_id)->update(['dlr_zone_id' => $request->a_to_z_zone_id]);
       			DB::table('montly_sales_targets')->where('area_id',$dealer->a_to_z_area_id)->update([
                    'zone_id' => $request->a_to_z_zone_id
                ]);
      }



     return back()->with('success','Update Successfully');


    }

      public function vendordeletelog()
    {





        $dealer = DB::select('select dealer_deletes.*, dealer_spos.sop_name ,dealer_areas.area_title,dealer_zones.zone_title,dealer_areas.area_title
        from dealer_deletes
        left join dealer_spos on dealer_deletes.dlr_spo_id = dealer_spos.id
        left join dealer_zones on dealer_deletes.dlr_zone_id = dealer_zones.id
        LEFT JOIN dealer_areas on dealer_deletes.dlr_area_id = dealer_areas.id');


        return view('backend.dealer.vendor_delete_log',compact('dealer'));
    }

   public function vendorarchivelog()
    {





        $dealer = DB::select('select dealer_archives.*, dealer_spos.sop_name ,dealer_areas.area_title,dealer_zones.zone_title,dealer_areas.area_title
        from dealer_archives
        left join dealer_spos on dealer_archives.dlr_spo_id = dealer_spos.id
        left join dealer_zones on dealer_archives.dlr_zone_id = dealer_zones.id
        LEFT JOIN dealer_areas on dealer_archives.dlr_area_id = dealer_areas.id');


        return view('backend.dealer.vendor_archive_log',compact('dealer'));
    }

   public function vendorTCarchivelog()
    {





        $data = DB::select('select transport_cost_archives.*, dealers.d_s_name,factories.factory_name
        from transport_cost_archives
        left join dealers on transport_cost_archives.dealer_id = dealers.id
        left join factories on transport_cost_archives.warehouse_id = factories.id
       ');
      // dd($data);

        return view('backend.dealer.vendor_archive_transport_cost_log',compact('data'));
    }

    public function getdealerinfo($id)
    {
        $data =Dealer::where('id',$id)->first();
        //return response($data);
        if($data){
            return response()->json(['dealer'=>$data,'status'=>201]);
        }
        else
        {
            return response()->json(['res'=>'Data Not Found','status'=>404]);
        }
    }


    public function getwarehouse($id)
    {

        $data =TransportCost::leftJoin('factories', 'factories.id', '=', 'transport_costs.warehouse_id')->where('dealer_id',$id)->get();

        return response($data);
    }



}
