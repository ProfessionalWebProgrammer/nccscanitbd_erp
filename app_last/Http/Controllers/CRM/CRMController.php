<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use App\Models\Product;
use App\Models\Client;
use App\Models\Progresses;
use App\Models\ProgressDatas;
use App\Models\ClientRequirementDatas;
use App\Models\ClientRequirement;
use App\Models\Employee;

use Illuminate\Http\Request;
use DB;
class CRMController extends Controller
{
   
    public function index()
    {
        $progressess= DB::table('progresses')
          ->select('progresses.*','clients.client_name')
          ->leftJoin('clients','clients.id','progresses.client_id')
          ->get();
      
      
        return view('backend.progress.index', compact('progressess'));
      
      
    }
  
   public function create()
    {
        $clients= Client::all();
        return view('backend.progress.create', compact('clients'));
    }
   public function progressStore(Request $request)
   {
   	//dd($request->all());
     $progressStore = new Progresses();
     $progressStore->date = $request->date;
     $progressStore->client_id = $request->dealer_id;
     $progressStore->contacts_person = $request->contact_person;
     $progressStore->reference = $request->reference;
     $progressStore->description = $request->description;
     $progressStore->feedback = $request->feedback;
     $progressStore->converted_ratio = $request->converted_percent;
     $progressStore->deal_status = $request->deal_status;
     $progressStore->save();
     $progressId = $progressStore->id;
     
     foreach($request->subject as $key => $value){
     	$progressdatastore = new ProgressDatas;
     	$progressdatastore->progress_id = $progressId;
     	$progressdatastore->subject = $request->subject[$key];
     	$progressdatastore->note = $request->note[$key];
     	$progressdatastore->save();
     }
     return redirect()->back()->with('success','Progress Stored Success');
     
   }
  
  public function deleteProgress(Request $request)
  {
  	//dd($request->all());
    Progresses::where('id',$request->id)->delete();
    ProgressDatas::where('progress_id',$request->id)->delete();
    return redirect()->back()->with('success','Progress Deleted Successfull');
  }
  
  public function viewprogress($id)
  {
    $progressData = DB::table('progresses')
          ->select('progresses.*','clients.client_name')
          ->leftJoin('clients','clients.id','progresses.client_id')
      	  ->where('progresses.id',$id)
          ->first();
    $multipedata = ProgressDatas::where('progress_id',$id)->get();
    return view('backend.progress.view_progress',compact('progressData','multipedata'));
  }
  
  public function progressReportIndex()
  {
    $clients= Client::all();  	
    return view('backend.progress.progress_report_index',compact('clients'));
      
  }
  
  public function viewprogressReport(Request $request)
  {
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
    
    if($request->dealer_id){
      $reportData = DB::table('progresses')
          ->select('progresses.*','clients.client_name')
          ->leftJoin('clients','clients.id','progresses.client_id')
          ->whereBetween('progresses.date', [$fdate, $tdate])
      	  ->where('progresses.client_id',$request->dealer_id) 
          ->get();
      $client= Client::where('id',$request->dealer_id)->first();
    }else{
    	$reportData = DB::table('progresses')
          ->select('progresses.*','clients.client_name')
          ->leftJoin('clients','clients.id','progresses.client_id')
          ->whereBetween('progresses.date', [$fdate, $tdate])
          ->get();
    }
    
    
        return view('backend.progress.progress_report_view', compact('reportData','client'));
      
  }
  
   public function CRindex()
    {
        $crdata= DB::table('client_requirements')
          ->select('client_requirements.*','clients.client_name','employees.emp_name')
          ->leftJoin('clients','clients.id','client_requirements.client_id')
          ->leftjoin('employees', 'client_requirements.assign_user', '=', 'employees.id')
          ->get();
     
           $emps   =   Employee::latest('id')->get();
//dd($emps);
      
     
        return view('backend.client_requirement.index', compact('crdata','emps'));
      
      
    }
  
   public function CRcreate()
    {
        $clients= Client::all();
        return view('backend.client_requirement.create', compact('clients'));
    }
  
  
   public function CRstore(Request $request)
   {
   	//dd($request->all());
     $progressStore = new ClientRequirement();
     $progressStore->date = $request->date;
     $progressStore->client_id = $request->dealer_id;
     $progressStore->contacts_person = $request->contact_person;
     $progressStore->subject = $request->reference;
     $progressStore->description = $request->description;
     $progressStore->department = $request->department;
     $progressStore->save();
     $cr_id = $progressStore->id;
     
     foreach($request->subject as $key => $value){
     	$progressdatastore = new ClientRequirementDatas;
     	$progressdatastore->cr_id = $cr_id;
     	$progressdatastore->subject = $request->subject[$key];
     	$progressdatastore->note = $request->note[$key];
     	$progressdatastore->save();
     }
     return redirect()->route('client.requirement.index')->with('success','Requirement Stored Success');
     
   }
  
  
    public function viewrequirement($id)
  {
    $crdata= DB::table('client_requirements')
          ->select('client_requirements.*','clients.client_name')
          ->leftJoin('clients','clients.id','client_requirements.client_id')
      	  ->where('client_requirements.id',$id)
          ->first();
    $multipedata = ClientRequirementDatas::where('cr_id',$id)->get();
    return view('backend.client_requirement.viewrequirement',compact('crdata','multipedata'));
  }
  
  public function CRdestroy(Request $request)
  {
  	//dd($request->all());
    ClientRequirement::where('id',$request->id)->delete();
    ClientRequirementDatas::where('cr_id',$request->id)->delete();
    return redirect()->back()->with('success','Requirement Deleted Successfull');
  }
  
  
    public function CRassign(Request $request)
   {
   //	dd($request->all());
     $progressStore =  ClientRequirement::where('id',$request->id)->first();
   
     $progressStore->assign_user = $request->assign_user;
     $progressStore->save();
   
     return redirect()->route('client.requirement.index')->with('success','User Assign Successfullay');
     
   }
  
   public function CRfeedback(Request $request)
   {
   //	dd($request->all());
     $progressStore =  ClientRequirement::where('id',$request->id)->first();
   
     $progressStore->feedback = $request->feedback;
     $progressStore->save();
   
     return redirect()->route('client.requirement.index')->with('success','User Feedback Added Successfullay');
     
   }
  
  
  
  
   public function requirementReportIndex()
  {
    $clients= Client::all();  	
    return view('backend.client_requirement.report_index',compact('clients'));
      
  }
  
  public function viewrequirementReport(Request $request)
  {
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
    
    if($request->dealer_id){
      $reportData = DB::table('client_requirements')
          ->select('client_requirements.*','clients.client_name')
          ->leftJoin('clients','clients.id','client_requirements.client_id')
          ->whereBetween('client_requirements.date', [$fdate, $tdate])
      	  ->where('client_requirements.client_id',$request->dealer_id) 
          ->get();
      $client= Client::where('id',$request->dealer_id)->first();
    }else{
    	$reportData = DB::table('client_requirements')
          ->select('client_requirements.*','clients.client_name')
          ->leftJoin('clients','clients.id','client_requirements.client_id')
          ->whereBetween('client_requirements.date', [$fdate, $tdate])
          ->get();
    }
    
    
        return view('backend.client_requirement.report_view', compact('reportData','client'));
      
  }
  
  
  
  
  
  
  
  
}
