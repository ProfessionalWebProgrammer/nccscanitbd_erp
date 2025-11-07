<?php

namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\EmployeePromotion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeePromotionController extends Controller
{
    public function index(){
      $promotionDatas = EmployeePromotion::orderby('id','desc')->get();
      return view('backend.payRoll.promotion.index', compact('promotionDatas'));
    }

    public function create(){
      $urerid = Auth::id();
      $employees = Employee::orderby('emp_name','asc')->get();
      $departments = Department::orderby('department_title','asc')->get();
      $designations = Designation::orderby('designation_title','asc')->get();
      return view('backend.payRoll.promotion.create', compact('urerid','employees','departments','designations'));
    }

    public function store( Request $request){
    //  dd($request->all());
    $emp = new EmployeePromotion();
    $emp->fill($request->all());
    if($emp->save()){
      $employees = Employee::where('id', $request->employee_id)->first();
      $employees->emp_designation_id = $request->designation_id;
      $employees->emp_department_id = $request->department_id;
      $employees->save();
       return redirect()->back()->with('success','Employee Promotion Submit Successfully');
    }
    }

    public function delete( Request $request){
      // dd($request->all());
      EmployeePromotion::where('id',$request->id)->delete();
      return redirect()->back()->with('success','Employee Promotion Delete Successfully');
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

}
