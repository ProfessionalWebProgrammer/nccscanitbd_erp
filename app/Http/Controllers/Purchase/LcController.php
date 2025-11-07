<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\LcEntry;
use App\Models\LcGroup;
use App\Models\LcLedger;
use App\Models\AgentBank;
use App\Models\ExporterLedger;
use App\Models\CnfName;
use App\Models\MotherVessel;
use App\Models\PortOfEntry;
use App\Models\PortOfDischarge;
use App\Models\MasterBank;
use App\Models\RowMaterialsProduct;
// use App\Models\Payment;
// use App\Models\Payment_number;

class LcController extends Controller
{

public function lcEntryIndex(){
  $lcDatas = LcEntry::get();
  return view('backend.lc.lcEntry.index',compact('lcDatas'));
}

public function lcEntryCreate(){
  $data = array();
  $data['lcGroup'] = LcGroup::orderBy('name', 'ASC')->get();
  $data['lcLedger'] = LcLedger::orderBy('name', 'ASC')->get();
  $data['agentBank'] = AgentBank::orderBy('name', 'ASC')->get();
  $data['masterBank'] = MasterBank::orderBy('bank_name', 'ASC')->get();
  $data['exporterLedger'] = ExporterLedger::orderBy('name', 'ASC')->get();
  $data['cnfName'] = CnfName::orderBy('name', 'ASC')->get();
  $data['motherVessel'] = MotherVessel::orderBy('name', 'ASC')->get();
  $data['portOfEntry'] = PortOfEntry::orderBy('name', 'ASC')->get();
  $data['portOfDischarge'] = PortOfDischarge::orderBy('name', 'ASC')->get();
  $data['rawItem'] = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();
  $data['user_id'] = Auth::id();
    return view('backend.lc.lcEntry.create',compact('data'));
}

public function lcEntryStore(Request $request){

      $lcEntry = new LcEntry();
      $lcEntry->fill($request->all());
      if($lcEntry->save()){
        /*$payment = new Payment();
        //$total = 	$request->bdt_value;
        $paymentInvoNumber = new Payment_number();
        $paymentInvoNumber->amount = $amount;
        $paymentInvoNumber->user_id = $usid;
        $paymentInvoNumber->save();
        $bankdetails = MasterBank::where('bank_id', $request->bank_id[$key])->first();

        $bank_receieve = new Payment();
        $bank_receieve->bank_id = $request->bank_id[$key];
        $bank_receieve->bank_name = $bankdetails->bank_name;
        $bank_receieve->supplier_id = $request->supplier_id[$key];
        $bank_receieve->amount = $amount;
        $bank_receieve->payment_date = $request->payment_date;
        $bank_receieve->payment_type = 'PAYMENT';
        $bank_receieve->type = 'BANK';
        $bank_receieve->invoice = 'Pay-'.$paymentInvoNumber->id;
        $bank_receieve->created_by =  $usid;
        // $bank_receieve->ledger_status = 1;
        $bank_receieve->payment_description = $request->payment_description;
        */
         return redirect()->back()->with('success','L.C Entry Created Successfully');
     }
}
public function lcEntryInvoice($id){
  $val = LcEntry::where('id',$id)->first();
  return view('backend.lc.lcEntry.invoice',compact('val'));
}
public function lcEntryDelete(Request $request){
  LcEntry::where('id',$request->id)->delete();
  return redirect()->back()->with('success','L.C Entry Deleted Successfully');
}
public function lcEntryReportIndex(){
  return view('backend.lcReport.lcReportIndex');
}

public  function lcEntryReportView(Request $request){
  //dd($request->all());
  if ($request->date) {
      $dates = explode(' - ', $request->date);
      $fdate = date('Y-m-d', strtotime($dates[0]));
      $tdate = date('Y-m-d', strtotime($dates[1]));
  } else {
    $fdate =  date('Y-m-d');
    $tdate =  date('Y-m-d');
  }
  $lcReports = LcEntry::whereBetween('date',[$fdate,$tdate])->get();
  //dd($lcReports);
    return view('backend.lcReport.lcReportView',compact('lcReports','fdate','tdate'));
}
  public function lcGroupIndex()
  {
    $data = LcGroup::orderBy('id', 'DESC')->get();
    return view('backend.lc.lcGroup.index',compact('data'));
  }
  public function lcGroupStore(Request $request){
    //dd($request->all());
    $lcGroup = new LcGroup();
       $lcGroup->fill($request->all());
       if($lcGroup->save()){
           return redirect()->back()->with('success','L.C Group Created Successfully');
       }
  }
  public function lcGroupDelete(Request $request){
       LcGroup::where('id',$request->id)->delete();
       return redirect()->back()->with('success','L.C Group Deleted Successfully');

   }

   public function lcLedgerIndex()
   {
      $groups  = LcGroup::orderBy('id', 'DESC')->get();
      $dataLedger = LcLedger::orderBy('id', 'DESC')->get();
      //dd($data);
     return view('backend.lc.lcLedger.index',compact('dataLedger','groups'));
   }

   public function lcLedgerStore(Request $request){
     //dd($request->all());
     $lcLedger = new LcLedger();
        $lcLedger->fill($request->all());
        if($lcLedger->save()){
            return redirect()->back()->with('success','L.C Ledger Created Successfully');
        }
   }

   public function lcLedgerDelete(Request $request){
        LcLedger::where('id',$request->id)->delete();
        return redirect()->back()->with('success','L.C Ledger Deleted Successfully');
    }

// agentBank

public function agentBankIndex()
{
  $data = AgentBank::orderBy('id', 'DESC')->get();
  return view('backend.lc.agentBank.index',compact('data'));
}
public function agentBankStore(Request $request){
  //dd($request->all());
      $agentBank = new AgentBank();
     $agentBank->fill($request->all());
     if($agentBank->save()){
         return redirect()->back()->with('success','Agent Bank Created Successfully');
     }
}
public function agentBankDelete(Request $request){
     AgentBank::where('id',$request->id)->delete();
     return redirect()->back()->with('success','Agent Bank Deleted Successfully');
 }

 //exporterLedger
 public function exporterLedgerIndex()
 {
   $data = ExporterLedger::orderBy('id', 'DESC')->get();
   return view('backend.lc.exporterLedger.index',compact('data'));
 }
 public function exporterLedgerStore(Request $request){
   //dd($request->all());
      $exporterLedger = new ExporterLedger();
      $exporterLedger->fill($request->all());
      if($exporterLedger->save()){
          return redirect()->back()->with('success','Exporter Ledger Created Successfully');
      }
 }
 public function exporterLedgerDelete(Request $request){
      ExporterLedger::where('id',$request->id)->delete();
      return redirect()->back()->with('success','Exporter Ledger Deleted Successfully');
  }

// cnfNname
public function cnfNnameIndex()
{
  $data = CnfName::orderBy('id', 'DESC')->get();
  return view('backend.lc.cnfNname.index',compact('data'));
}
public function cnfNnameStore(Request $request){
  //dd($request->all());
     $cnfName = new CnfName();
     $cnfName->fill($request->all());
     if($cnfName->save()){
         return redirect()->back()->with('success','CNF Name Created Successfully');
     }
}
public function cnfNnameDelete(Request $request){
     CnfName::where('id',$request->id)->delete();
     return redirect()->back()->with('success','CNF Name Deleted Successfully');
 }

 // motherVessel
 public function motherVesselIndex()
 {
   $data = MotherVessel::orderBy('id', 'DESC')->get();
   return view('backend.lc.motherVessel.index',compact('data'));
 }
 public function motherVesselStore(Request $request){
      $motherVessel = new MotherVessel();
      $motherVessel->fill($request->all());
      if($motherVessel->save()){
          return redirect()->back()->with('success','Mother Vessel Created Successfully');
      }
 }
 public function motherVesselDelete(Request $request){
      MotherVessel::where('id',$request->id)->delete();
      return redirect()->back()->with('success','Mother Vessel Deleted Successfully');
  }

  // portOfEntry
  public function portOfEntryIndex()
  {
    $data = PortOfEntry::orderBy('id', 'DESC')->get();
    return view('backend.lc.portOfEntry.index',compact('data'));
  }
  public function portOfEntryStore(Request $request){
       $portOfEntry = new PortOfEntry();
       $portOfEntry->fill($request->all());
       if($portOfEntry->save()){
           return redirect()->back()->with('success','Port Of Entry Created Successfully');
       }
  }
  public function portOfEntryDelete(Request $request){
       PortOfEntry::where('id',$request->id)->delete();
       return redirect()->back()->with('success','Port Of Entry Deleted Successfully');
   }
   // PortOfDischarge
   public function portOfDischargeIndex(){
     $data = PortOfDischarge::orderBy('id', 'DESC')->get();
     return view('backend.lc.portOfDischarge.index',compact('data'));
   }
   public function portOfDischargeStore(Request $request){
        $portOfDischarge = new PortOfDischarge();
        $portOfDischarge->fill($request->all());
        if($portOfDischarge->save()){
            return redirect()->back()->with('success','Port Of Discharge Created Successfully');
        }
   }
   public function portOfDischargeDelete(Request $request){
        PortOfDischarge::where('id',$request->id)->delete();
        return redirect()->back()->with('success','Port Of Discharge Deleted Successfully');
    }
}
