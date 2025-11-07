<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Dealer;
use App\Models\AssetType;
use App\Models\MasterBank;
use App\Models\MasterCash;
use App\Models\IndirectCost;
use App\Models\SalesProduct;
use Illuminate\Http\Request;
use App\Models\DirectLabourCost;
use App\Models\ManufacturingCost;
use App\Models\Payment;
use App\Models\Payment_number;
use Illuminate\Support\Facades\DB;
use App\Models\longTermLibilitiesClient;
use App\Models\ShortTermLibilitiesClient;
use Illuminate\Support\Facades\Auth;

class CostController extends Controller
{
    public function labourcostlist()
    {
        //$data = DirectLabourCost::leftjoin('sales_products', 'direct_labour_costs.fg_id', '=', 'sales_products.id')->get();
      	$data = DB::table('direct_labour_costs')
          		->select('direct_labour_costs.*','sales_products.product_name')
          		->leftjoin('sales_products', 'direct_labour_costs.fg_id', '=', 'sales_products.id')
      			->orderBy('id','DESC')->get();

        return view('backend.cost.labour_cost_index', compact('data'));
    }
	public function labourcostdelete(Request $request)
    {
    	//dd($request->all());
        DirectLabourCost::where('id',$request->id)->delete();
      	return redirect()->back()->with('success','Direct Labour cost deleted!');
    }
    public function labourcostcreate()
    {
        $fgs = SalesProduct::all();
        return view('backend.cost.labour_cost_create', compact('fgs'));
    }
  
    public function labourcoststore(Request $request)
    {

       // dd($request->all());
		$count = 0;
      	$count = count($request->fg_id);
      
      	$invoice = DirectLabourCost::latest('id')->first();
            if($invoice){
                $innumber = 10000 + $invoice->id +1;
            }
            else{
                $innumber = 10000;
            }
      
     	foreach ($request->fg_id as $sl => $id) {
	
            foreach ($request->head as $key => $head) {
              
                $string = str_replace(' ', '', $request->head[$key]);
                $head_id = substr($string,0,5);
              
                $dlc = new DirectLabourCost();
                $dlc->chalan_no = $request->chalan_no; 
                $dlc->head_id = $head_id;
                $dlc->head = $request->head[$key];
                $dlc->date = $request->date;
                $dlc->invoice = $innumber;
                $dlc->labour_qty = $request->labour_qty[$key];
                $dlc->per_person_cost = $request->per_person_cost[$key];
                $dlc->day = $request->day[$key] ?? '';
                $dlc->total_cost = $request->total_cost[$key]/$count;
                $dlc->fg_id = $request->fg_id[$sl];
                $dlc->save();
            }
       }
      
        return redirect()->route('direct.labour.cost.list')->with('success', 'Direct Labour Cost Create  successfully .');
    }

	public function labourcostEdit($id)
    {
        $fgs = SalesProduct::all();
      	$fg_ids = DirectLabourCost::select('fg_id')->where('chalan_no',$id)->groupBy('fg_id')->get();
      	/*$array = [];
        foreach($fg_ids as $val){
			array_push($array,$val->fg_id);
        }
       $convertData = [];
       $convertData = implode(',', $array);
       $r = explode(",", $convertData);
       $sub_fgs = SalesProduct::whereNotIn('id', [$array])->get();

      */
      	$datas = DirectLabourCost::where('chalan_no',$id)->groupBy('head_id')->get();
        $data = DirectLabourCost::where('chalan_no',$id)->first();
       //dd($data);
        return view('backend.cost.labour_cost_edit', compact('fgs','fg_ids','datas','data'));
    }
  
  	public function labourcostUpdate(Request $request){
    	//dd($request->all());
      $chalanid = $request->chalan_no;
      $count = 0;
      $count = count($request->fg_id);
      
      foreach ($request->fg_id as $sl => $id) {
      		foreach ($request->head as $key => $head) {
            	$dlc = DirectLabourCost::where('chalan_no',$chalanid)->where('head_id',$request->head_id[$key])->where('fg_id',$request->fg_id[$sl])->first();
              if(!empty($dlc)){
                $dlc->chalan_no = $chalanid; 
                $dlc->head_id = $request->head_id[$key];
                $dlc->head = $request->head[$key];
                $dlc->date = $request->date;
                $dlc->labour_qty = $request->labour_qty[$key];
                $dlc->per_person_cost = $request->per_person_cost[$key];
                $dlc->day = $request->day[$key] ?? '';
                $dlc->previour_total_cost = $dlc->total_cost;
                $dlc->total_cost = $request->total_cost[$key]/$count;
                $dlc->fg_id = $request->fg_id[$sl];
                $dlc->save();
              } else {
                $string = str_replace(' ', '', $request->head[$key]);
                $head_id = substr($string,0,5);
                
                $dlcNew = new DirectLabourCost();
                $dlcNew->chalan_no = $chalanid; 
                $dlcNew->head_id = $request->head_id[$key];
                $dlcNew->head = $request->head[$key];
                $dlcNew->date = $request->date;
                $dlcNew->invoice = $dlc->invoice;
                $dlcNew->labour_qty = $request->labour_qty[$key];
                $dlcNew->per_person_cost = $request->per_person_cost[$key];
                $dlcNew->day = $request->day[$key] ?? '';
                $dlcNew->total_cost = $request->total_cost[$key]/$count;
                $dlcNew->fg_id = $request->fg_id[$sl];
                $dlcNew->save();
              }
            }
      }
      return redirect()->route('direct.labour.cost.list')->with('success', 'Direct Labour Cost Update  successfully .');
    }
  
    public function indirectcostlist()
    {
        //$data = IndirectCost::leftjoin('sales_products', 'indirect_costs.fg_id', '=', 'sales_products.id')->get();
      	$data = DB::table('indirect_costs')
          ->select('indirect_costs.*','sales_products.product_name')
          ->leftjoin('sales_products', 'indirect_costs.fg_id', '=', 'sales_products.id')
          ->get();
        return view('backend.cost.indirect_cost_index', compact('data'));
      	
    }
	public function indirectcostdelete(Request $request)
    {
      //dd($request->all());
      IndirectCost::where('id',$request->id)->delete();
      return redirect()->back()->with('success', 'Indirect Labour Cost Deleted  successfully .');
    }
    public function indiretccostcreate()
    {
        $fgs = SalesProduct::all();
        return view('backend.cost.indirect_cost_create', compact('fgs'));
    }
  
    public function indirectcoststore(Request $request)
    {

        //dd($request->all());
      $count = 0;
      $count = count($request->fg_id);
      
	foreach ($request->fg_id as $sl => $id) {

        $invoice = IndirectCost::latest('id')->first();
        if($invoice){
        	$innumber = 100000 + $invoice->id +1;
        }
        else{
        	$innumber = 100000;
        }

        foreach ($request->head as $key => $head) {
            $dlc = new IndirectCost();
            $dlc->date = $request->date;
            $dlc->invoice = $innumber;
            $dlc->head = $request->head[$key];
            $dlc->fg_id = $request->fg_id[$sl];
            $dlc->total_cost = $request->total_cost[$key]/$count;
            $dlc->save();
        	}
    	}     
        return redirect()->route('indirect.cost.list')
                        ->with('success', 'Indirect Cost Create  successfully .');
    }


    public function manufacturingcostlist()
    {
        //$data = ManufacturingCost::leftjoin('sales_products', 'manufacturing_costs.fg_id', '=', 'sales_products.id')->get();
      
        $data = DB::table('manufacturing_costs')
          ->select('manufacturing_costs.*','sales_products.product_name')
          ->leftjoin('sales_products', 'manufacturing_costs.fg_id', '=', 'sales_products.id')
          ->get();
        return view('backend.cost.manufacturing_index', compact('data'));
    }
	
  	public function manufacturingcostdelete(Request $request)
    {
    	//dd($request->all());
      	ManufacturingCost::where('id',$request->id)->delete();
      	return redirect()->back()->with('success', 'Indirect Labour Cost Deleted  successfully .');
    }
  
    public function manufacturingcostcreate()
    {
        $fgs = SalesProduct::all();
        return view('backend.cost.manufacturing_create', compact('fgs'));
    }
  
    public function manufacturingcoststore(Request $request)
    {

      //dd($request->all());
      $count = 0;
      $count = count($request->fg_id);
     // dd($count);
      $invoice = ManufacturingCost::latest('id')->first();
        if($invoice){
        	$innumber = 100000 + $invoice->id +1;
        }
        else{
        	$innumber = 100000;
        }
     // dd($innumber);
	foreach ($request->fg_id as $sl => $id) {
        
        foreach ($request->head as $key => $head) {
           	$string = str_replace(' ', '', $request->head[$key]);
            $head_id = substr($string,0,5);
          
            $dlc = new ManufacturingCost();
            $dlc->date = $request->date;
            $dlc->invoice = $innumber;
            $dlc->head = $request->head[$key];
            $dlc->head_id = $head_id;
            $dlc->qty = $request->qty[$key];
            $dlc->rate = $request->rate[$key]/$count;
            $dlc->total_cost = $request->total_cost[$key]/$count;
            $dlc->fg_id = $request->fg_id[$sl];
            $dlc->save();
        }
  
        }
      
        return redirect()->route('manufacturing.cost.list')->with('success', 'Manufacturing Cost Create  successfully .');
    }
  
  public function manufacturingcostEdit($id){
   		$fgs = SalesProduct::all();
      	$fg_ids = ManufacturingCost::select('fg_id')->where('invoice',$id)->groupBy('fg_id')->get();
      	$datas = ManufacturingCost::where('invoice',$id)->groupBy('head_id')->get();
        $data = ManufacturingCost::where('invoice',$id)->first();
       //dd($datas);
        return view('backend.cost.manufacturingEdit', compact('fgs','fg_ids','datas','data'));
    
  }
  
  public function manufacturingcostUpdate(Request $request){
	  //dd($request->all());
      $count = 0;
      $count = count($request->fg_id);
    
      foreach ($request->fg_id as $sl => $id) {
      		foreach ($request->head as $key => $head) {
            	$dlc = ManufacturingCost::where('invoice',$request->invoice)->where('head_id',$request->head_id[$key])->where('fg_id',$request->fg_id[$sl])->first();
              if(!empty($dlc)){
                $dlc->date = $request->date;
                $dlc->head = $request->head[$key];
                $dlc->head_id = $request->head_id[$key];
                $dlc->qty = $request->qty[$key];
                $dlc->rate = $request->rate[$key]/$count;
                $dlc->previour_total_cost = $dlc->total_cost;
                $dlc->total_cost = $request->total_cost[$key]/$count;
                $dlc->fg_id = $request->fg_id[$sl];
                $dlc->save();
              } else {
               	$string = str_replace(' ', '', $request->head[$key]);
                $head_id = substr($string,0,5);
                
                $dlcNew = new ManufacturingCost();
                $dlcNew->date = $request->date;
                $dlcNew->invoice = $dlc->invoice;
                $dlcNew->head = $request->head[$key];
                $dlcNew->head_id = $head_id;
                $dlcNew->qty = $request->qty[$key];
                $dlcNew->rate = $request->rate[$key]/$count;
                $dlcNew->total_cost = $request->total_cost[$key]/$count;
                $dlcNew->fg_id = $request->fg_id[$sl];
                $dlcNew->save();
              }
            }
      }
      return redirect()->route('manufacturing.cost.list')->with('success', 'Manufacturing Cost Update  successfully.');
  }
  
  //new costing method by shariar ->leftjoin('sales_products', 'direct_labour_costs.fg_id', '=', 'sales_products.id')
  public function productionCost(){
  	$data = DB::table('direct_labour_costs')->where('status',1)->orderBy('id','DESC')->get();
        return view('backend.newCost.labour_cost_index', compact('data'));
  }
  
  public function labournewCostcreate(){
     $leadger = DB::table('expanse_subgroups')->get();
     $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
     $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
  	 return view('backend.newCost.labour_cost_create', compact('leadger','allcashs','allBanks'));
  }
  
  public function labournewCoststore(Request $request){
  		//dd($request->all());
      	$usid = Auth::id();
    	if ($request->bank_id != null) {
            $bankname = MasterBank::where('bank_id', $request->bank_id)->value('bank_name');
            $cashdetails = '';
            $type = 'BANK';
        } else {
            $cashdetails = MasterCash::where('wirehouse_id', $request->wirehouse_id)->value('wirehouse_name');
            $bankname = '';
            $type = 'CASH';
        }
      	$invoice = DirectLabourCost::latest('id')->first();
            if($invoice){
                $innumber = 10000 + $invoice->id +1;
            }
            else{
                $innumber = 10000;
            }
      
	
            foreach ($request->head as $key => $head) {
              $head = DB::table('expanse_subgroups')->where('id',$request->head[$key])->value('subgroup_name');
                /* $string = str_replace(' ', '', $request->head[$key]);
                $head_id = substr($string,0,5); */

                $dlc = new DirectLabourCost();
                $dlc->chalan_no = $request->chalan_no; 
                $dlc->head_id = $request->head[$key];
                $dlc->head = $head;
                $dlc->date = $request->date;
              	$dlc->quantity = $request->quantity;
                $dlc->invoice = $innumber;
                $dlc->labour_qty = $request->labour_qty[$key];
                $dlc->per_person_cost = $request->per_person_cost[$key];
                $dlc->day = $request->day[$key] ?? '';
                $dlc->total_cost = $request->total_cost[$key];
              	$dlc->status = 1;
                $dlc->save();
              	
                $paymentInvoNumber = new Payment_number();
                $paymentInvoNumber->amount = $request->total_cost[$key];
                $paymentInvoNumber->user_id = $usid;
                $paymentInvoNumber->save();

                $cash_receieve = new Payment();
                $cash_receieve->bank_id = $request->bank_id;
                $cash_receieve->wirehouse_id = $request->wirehouse_id;
               
                $cash_receieve->expanse_rate = $request->total_cost[$key];
                $cash_receieve->expanse_subgroup_id = $request->head[$key];
                $cash_receieve->bank_name = $bankname;
                $cash_receieve->wirehouse_name = $cashdetails;
                /*$cash_receieve->supplier_id = $request->supplier_id; */
                $cash_receieve->amount = $request->total_cost[$key];
                $cash_receieve->payment_date = $request->date;
                $cash_receieve->payment_type = 'EXPANSE';
                $cash_receieve->type = $type;
                $cash_receieve->invoice = $paymentInvoNumber->id;
              	$cash_receieve->expanse_type_id = $dlc->id;
               	$cash_receieve->expanse_status = 1;
                $cash_receieve->status = 1;
                $cash_receieve->created_by =  $usid;
                $cash_receieve->payment_description = $head;        
                $cash_receieve->save();
            }
      
        return redirect()->route('production.cost.menu')->with('success', 'Direct Labour Cost Create  successfully .');
  }
  
  public function labournewCostEdit($id){
  		$datas = DirectLabourCost::where('chalan_no',$id)->groupBy('head_id')->get();
        $data = DirectLabourCost::where('chalan_no',$id)->first();
    	$leadger = DB::table('expanse_subgroups')->get();
        return view('backend.newCost.labour_cost_edit', compact('datas','data','leadger'));
  }
  
  public function labournewCostUpdate(Request $request){
  		//dd($request->all());
      	$chalanid = $request->chalan_no;
      
      		foreach ($request->head as $key => $head) {
            	$dlc = DirectLabourCost::where('chalan_no',$chalanid)->where('head_id',$head)->first();
              	$head = DB::table('expanse_subgroups')->where('id',$request->head[$key])->value('subgroup_name');
              
                if(!empty($dlc)){
                  $dlc->chalan_no = $chalanid; 
                  $dlc->head = $head;
                  $dlc->date = $request->date;
                  $dlc->quantity = $request->quantity;
                  $dlc->labour_qty = $request->labour_qty[$key];
                  $dlc->per_person_cost = $request->per_person_cost[$key];
                  $dlc->day = $request->day[$key] ?? '';
                  $dlc->previour_total_cost = $dlc->total_cost;
                  $dlc->total_cost = $request->total_cost[$key];
                  $dlc->save();
                } else {
                 /* $string = str_replace(' ', '', $request->head[$key]);
                  $head_id = substr($string,0,5); */
					$head = DB::table('expanse_subgroups')->where('id',$request->head[$key])->value('subgroup_name');
                  $dlcNew = new DirectLabourCost();
                  $dlcNew->chalan_no = $chalanid; 
                  $dlcNew->head_id = $request->head[$key];
                  $dlcNew->head = $head;
                  $dlcNew->date = $request->date;
                  $dlcNew->quantity = $request->quantity;
                  $dlcNew->invoice = $dlc->invoice;
                  $dlcNew->labour_qty = $request->labour_qty[$key];
                  $dlcNew->per_person_cost = $request->per_person_cost[$key];
                  $dlcNew->day = $request->day[$key] ?? '';
                  $dlcNew->total_cost = $request->total_cost[$key];
                  $dlcNew->status = 1;
                  $dlcNew->save();
                }
      }
      return redirect()->route('production.cost.menu')->with('success', 'Direct Labour Cost Update  successfully.');
  }
  
  public function labournewCostdelete(Request $request){
    	//dd($request->id);
  	 	DirectLabourCost::where('id',$request->id)->delete();
    	Payment::where('expanse_type_id',$request->id)->delete();
      	return redirect()->back()->with('success','Direct Labour cost deleted!');
  }
  
  public function manufacturingnewCostlist(){
  	 $data = DB::table('manufacturing_costs')->where('status',1)->orderBy('id','DESC')->get();
        return view('backend.newCost.manufacturing_index', compact('data'));
  }
  
  public function manufacturingnewCostcreate(){
    $leadger = DB::table('expanse_subgroups')->get();
    $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
    $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
     return view('backend.newCost.manufacturing_create', compact('allcashs','allBanks','leadger'));
  }
  
  public function manufacturingnewCoststore(Request $request){
   	//dd($request->all());
    	$usid = Auth::id();
    
    	if ($request->bank_id != null) {
            $bankname = MasterBank::where('bank_id', $request->bank_id)->value('bank_name');
            $cashdetails = '';
            $type = 'BANK';
        } else {
            $cashdetails = MasterCash::where('wirehouse_id', $request->wirehouse_id)->value('wirehouse_name');
            $bankname = '';
            $type = 'CASH';
        }
      	$invoice = ManufacturingCost::latest('id')->first();
        if($invoice){
        	$innumber = 100000 + $invoice->id +1;
        }
        else{
        	$innumber = 100000;
        }
     // dd($innumber);

        foreach ($request->head as $key => $head) {
           	/*$string = str_replace(' ', '', $request->head[$key]);
            $head_id = substr($string,0,5); */
          
          $head = DB::table('expanse_subgroups')->where('id',$request->head[$key])->value('subgroup_name');
            $dlc = new ManufacturingCost();
            $dlc->date = $request->date;
          	$dlc->quantity = $request->quantity;
            $dlc->invoice = $innumber;
            $dlc->head = $head;
            $dlc->head_id = $request->head[$key];
            $dlc->qty = $request->qty[$key];
            $dlc->rate = $request->rate[$key];
            $dlc->total_cost = $request->total_cost[$key];
          	$dlc->status = 1;
            $dlc->save();
          
          		$paymentInvoNumber = new Payment_number();
                $paymentInvoNumber->amount = $request->total_cost[$key];
                $paymentInvoNumber->user_id = $usid;
                $paymentInvoNumber->save();

                $cash_receieve = new Payment();
                $cash_receieve->bank_id = $request->bank_id;
                $cash_receieve->wirehouse_id = $request->wirehouse_id;
               
                $cash_receieve->expanse_rate = $request->total_cost[$key];
                $cash_receieve->expanse_subgroup_id = $request->head[$key];
                $cash_receieve->bank_name = $bankname;
                $cash_receieve->wirehouse_name = $cashdetails;
                /*$cash_receieve->supplier_id = $request->supplier_id; */
                $cash_receieve->amount = $request->total_cost[$key];
                $cash_receieve->payment_date = $request->date;
                $cash_receieve->payment_type = 'EXPANSE';
                $cash_receieve->type = $type;
                $cash_receieve->invoice = $paymentInvoNumber->id;
                $cash_receieve->expanse_type_id = $dlc->id;
                $cash_receieve->expanse_status = 1;
                $cash_receieve->status = 1;
                $cash_receieve->created_by =  $usid;
                $cash_receieve->payment_description = $head;        
                $cash_receieve->save();
        }
      
        return redirect()->route('manufacturing.newCost.list')->with('success', 'Manufacturing Cost Create  successfully .');
  }
  
  public function manufacturingnewCostEdit($id){
  		$datas = ManufacturingCost::where('invoice',$id)->groupBy('head_id')->get();
        $data = ManufacturingCost::where('invoice',$id)->first();
       //dd($datas);
        return view('backend.newCost.manufacturingEdit', compact('datas','data'));
  }
  
  public function manufacturingnewCostUpdate(Request $request){
  		//dd($request->all());

      		foreach ($request->head as $key => $head) {
            	$dlc = ManufacturingCost::where('invoice',$request->invoice)->where('head_id',$request->head_id[$key])->first();
              if(!empty($dlc)){
                $dlc->date = $request->date;
                $dlc->quantity = $request->quantity;
                $dlc->head = $request->head[$key];
                $dlc->head_id = $request->head_id[$key];
                $dlc->qty = $request->qty[$key];
                $dlc->rate = $request->rate[$key];
                $dlc->previour_total_cost = $dlc->total_cost;
                $dlc->total_cost = $request->total_cost[$key];
                
                $dlc->save();
              } else {
               	$string = str_replace(' ', '', $request->head[$key]);
                $head_id = substr($string,0,5);
                
                $dlcNew = new ManufacturingCost(); 
                $dlcNew->date = $request->date;
                $dlcNew->quantity = $request->quantity;
                $dlcNew->invoice = $dlc->invoice;
                $dlcNew->head = $request->head[$key];
                $dlcNew->head_id = $head_id;
                $dlcNew->qty = $request->qty[$key];
                $dlcNew->rate = $request->rate[$key];
                $dlcNew->total_cost = $request->total_cost[$key];
                $dlcNew->status = 1;
                $dlcNew->save();
              }
      }
      return redirect()->route('manufacturing.newCost.list')->with('success', 'Manufacturing Cost Update  successfully.');
  }
  
  public function manufacturingnewCostdelete(Request $request){
        //dd($request->id);
        ManufacturingCost::where('id',$request->id)->delete();
        Payment::where('expanse_type_id',$request->id)->delete();
      	return redirect()->back()->with('success', 'Indirect Labour Cost Deleted  successfully .');
  }    
}
