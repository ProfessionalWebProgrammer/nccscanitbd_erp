<?php

namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\EmployeeLeavePolicy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeeLeavePolicyController extends Controller
{
    public function index(){
      $policyDatas = EmployeeLeavePolicy::orderby('id','desc')->get();
      return view('backend.payRoll.timeAttendance.leavePolicy.index', compact('policyDatas'));
    }

    public function create(){
      $userid = Auth::id();
      return view('backend.payRoll.timeAttendance.leavePolicy.create', compact('userid'));
    }

    public function store(Request $request){
      //dd($request->all());
      $empPolicy = new EmployeeLeavePolicy();
      $empPolicy->fill($request->all());
      if($empPolicy->save()){
         return redirect()->back()->with('success','Employee Leave Policy Create Successfully');
       }
    }

    public function delete(Request $request){
        dd($request->all());
      EmployeeLeavePolicy::where('id',$request->id)->delete();
      return redirect()->back()->with('success','Employee Leave Policy Delete Successfully');
    }


/*
    public function index(){
      $productionDatas = EmployeeProduction::orderby('id','desc')->get();
      return view('backend.payRoll.production.index', compact('productionDatas'));
    }

    public function create(){
      $urerid = Auth::id();
      $employees = Employee::orderby('emp_name','asc')->get();
      $items = EmployeeProduct::orderby('name','asc')->get();
      return view('backend.payRoll.production.create', compact('urerid','employees','items'));
    }

    public function store(Request $request){
    //  dd($request->all());
    foreach ($request->item_id as $key => $val) {
      $emp = new EmployeeProduction();
      $emp->date = $request->date;
      $emp->emp_id = $request->emp_id;
      $emp->user_id = $request->user_id;
      $emp->item_id = $request->item_id[$key];
      $emp->qty = $request->qty[$key];
      $emp->rate = $request->rate[$key];
      $emp->amount = $request->amount[$key];
      $emp->save();
    }
       return redirect()->back()->with('success','Employee Production Submit Successfully');
    }

    public function delete( Request $request){
      // dd($request->all());
      EmployeeProduction::where('id',$request->id)->delete();
      return redirect()->back()->with('success','Employee Production Delete Successfully');
    }

  public function reportIndex(){
    $employees = Employee::orderby('emp_name','asc')->get();
    return view('backend.payRoll.promotion.report', compact('employees'));
  }

  public function reportView( Request $request){
    if(isset($request->date)) {
      $dates = explode(' - ', $request->date);
      $fdate = date('Y-m-d', strtotime($dates[0]));
      $tdate = date('Y-m-d', strtotime($dates[1]));
    } else {
      $fdate = date('Y-m-d');
      $tdate = date('Y-m-d');
    }
    if(isset($request->employee)){
      $employees = EmployeePromotion::whereIn('employee_id',$request->employee)->whereBetween('date',[$fdate,$tdate])->orderBy('employee_id','asc')->get();
    } else {
        $employees = EmployeePromotion::whereBetween('date',[$fdate,$tdate])->orderBy('employee_id','asc')->get();
    }
    return view('backend.payRoll.promotion.view', compact('employees','fdate','tdate'));
  }
*/
}
