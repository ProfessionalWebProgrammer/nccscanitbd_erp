<?php

namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeIncrement;
use App\Models\EmployeeAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeeIncrementController extends Controller
{
  public function index(){
    $promotionDatas = EmployeeIncrement::orderby('id','desc')->get();
    return view('backend.payRoll.increment.index', compact('promotionDatas'));
  }

  public function create(){
    $urerid = Auth::id();
    $employees = Employee::orderby('emp_name','asc')->get();
    return view('backend.payRoll.increment.create', compact('urerid','employees'));
  }

  public function store( Request $request){
  // dd($request->all());
  $year = date('Y');
  $date = '01-'.$request->month.'-'.$year;
  //dd(date("F", strtotime($date)));
//  $grossSaalry =
  $id = $request->employee_id;
  $empSalary = EmployeeAccount::where('emp_id',$id)->first();
  $emp = new EmployeeIncrement();
  $emp->fill($request->all());
  if($emp->save()){
    $emp->month = $date;
    $emp->save();

    $empSalary->increment = $request->amount;
    $empSalary->total_gross_salary = $empSalary->total_gross_salary + $request->amount;
    $empSalary->save();

    // $employees = Employee::where('id', $request->employee_id)->first();
    // $employees->emp_designation_id = $request->designation_id;
    // $employees->emp_department_id = $request->department_id;
    // $employees->save();
     return redirect()->back()->with('success','Employee Increment Submit Successfully');
  }
  }

  public function delete( Request $request){
    // dd($request->all());
    EmployeeIncrement::where('id',$request->id)->delete();
    return redirect()->back()->with('success','Employee Increment Delete Successfully');
  }

  public function reportIndex(){
    $employees = Employee::orderby('emp_name','asc')->get();
    return view('backend.payRoll.increment.report', compact('employees'));
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
      $employees = EmployeeIncrement::whereIn('employee_id',$request->employee)->whereBetween('date',[$fdate,$tdate])->orderBy('employee_id','asc')->get();
    } else {
        $employees = EmployeeIncrement::whereBetween('date',[$fdate,$tdate])->orderBy('employee_id','asc')->get();
    }
    return view('backend.payRoll.increment.view', compact('employees','fdate','tdate'));
  }
}
