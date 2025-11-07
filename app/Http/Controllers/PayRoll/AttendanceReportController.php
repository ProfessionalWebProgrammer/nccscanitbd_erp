<?php

namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeAccount;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AttendanceReportController extends Controller
{
  public function index(){
    $employees = Employee::orderby('emp_name','asc')->get();
    $departments = Department::orderby('department_title','asc')->get();
    return view('backend.payRoll.report.attendance.index', compact('employees','departments'));
  }



  public function attendanceReport( Request $request){
  //dd($request->all());
  $exit_time = 0;
if($request->type == 1){
  $exit_time = '19:00';
  if(isset($request->year)){
       $employees = EmployeeAttendance::select('employee_id')->whereYear('date', $request->year);
       $fdate = date('Y-m-d');
       $tdate = date('Y-m-d');
     } elseif(isset($request->monthYear)){
       $mY = explode('-', $request->monthYear);
       $employees = EmployeeAttendance::select('employee_id')->where('exit_time','<=',$exit_time)->whereMonth('date',$mY[1])->whereYear('date', $mY[0]);
       $fdate = date('Y-m-d');
       $tdate = date('Y-m-d');

     } elseif(isset($request->date)) {
       $dates = explode(' - ', $request->date);
       $fdate = date('Y-m-d', strtotime($dates[0]));
       $tdate = date('Y-m-d', strtotime($dates[1]));
       $employees = EmployeeAttendance::select('employee_id','exit_time')->where('exit_time','<=', $exit_time)->whereBetween('date',[$fdate,$tdate]);
     } else {
       $employees = EmployeeAttendance::select('employee_id')->where('date',date('Y-m-d'));
       $fdate = date('Y-m-d');
       $tdate = date('Y-m-d');
     }
} else {
  $exit_time = '19:00';
  if(isset($request->year)){
       $employees = EmployeeAttendance::select('employee_id')->whereYear('date', $request->year);
       $fdate = date('Y-m-d');
       $tdate = date('Y-m-d');
     } elseif(isset($request->monthYear)){
       $mY = explode('-', $request->monthYear);
       $employees = EmployeeAttendance::select('employee_id')->where('exit_time','>',$exit_time)->whereMonth('date',$mY[1])->whereYear('date', $mY[0]);
       $fdate = date('Y-m-d');
       $tdate = date('Y-m-d');

     } elseif(isset($request->date)) {
       $dates = explode(' - ', $request->date);
       $fdate = date('Y-m-d', strtotime($dates[0]));
       $tdate = date('Y-m-d', strtotime($dates[1]));
       $employees = EmployeeAttendance::select('employee_id','exit_time')->where('exit_time','>',$exit_time)->whereBetween('date',[$fdate,$tdate]);
     } else {
       $employees = EmployeeAttendance::select('employee_id')->where('date',date('Y-m-d'));
       $fdate = date('Y-m-d');
       $tdate = date('Y-m-d');
     }

}

    if($request->employee){
      $employees = $employees->whereIn('employee_id',$request->employee);
    }

    if($request->department){
        $employees = $employees->whereIn('department_id',$request->department);
    }

    $employees = $employees->distinct()->groupby('employee_id')->get();

    //dd($employees);
    $report = $request->report;
    $type = $request->type;
     return view('backend.payRoll.report.attendance.report',compact('employees','report','fdate','tdate','type','exit_time'));
  }

  public function ledgerIndex(){
    $employees = Employee::orderby('emp_name','asc')->get();
    $departments = Department::orderby('department_title','asc')->get();
    return view('backend.payRoll.report.attendanceLedger.index', compact('employees','departments'));
  }

  public function attendanceLedgerReport( Request $request){
  //dd($request->all());

  $exit_time = 0;
if($request->type == 1){
  $exit_time = '19:00';
  if(isset($request->year)){
       $employees = EmployeeAttendance::select('employee_id')->whereYear('date', $request->year);
       $fdate = date('Y-m-d');
       $tdate = date('Y-m-d');
     } elseif(isset($request->monthYear)){
       $mY = explode('-', $request->monthYear);
       $employees = EmployeeAttendance::select('employee_id')->where('exit_time','<=',$exit_time)->whereMonth('date',$mY[1])->whereYear('date', $mY[0]);
       $fdate = date('Y-m-d');
       $tdate = date('Y-m-d');

     } elseif(isset($request->date)) {
       $dates = explode(' - ', $request->date);
       $fdate = date('Y-m-d', strtotime($dates[0]));
       $tdate = date('Y-m-d', strtotime($dates[1]));
       $employees = EmployeeAttendance::select('employee_id','exit_time')->where('exit_time','<=', $exit_time)->whereBetween('date',[$fdate,$tdate]);
     } else {
       $employees = EmployeeAttendance::select('employee_id')->where('date',date('Y-m-d'));
       $fdate = date('Y-m-d');
       $tdate = date('Y-m-d');
     }
} else {
  $exit_time = '19:00';
  if(isset($request->year)){
       $employees = EmployeeAttendance::select('employee_id')->whereYear('date', $request->year);
       $fdate = date('Y-m-d');
       $tdate = date('Y-m-d');
     } elseif(isset($request->monthYear)){
       $mY = explode('-', $request->monthYear);
       $employees = EmployeeAttendance::select('employee_id')->where('exit_time','>',$exit_time)->whereMonth('date',$mY[1])->whereYear('date', $mY[0]);
       $fdate = date('Y-m-d');
       $tdate = date('Y-m-d');

     } elseif(isset($request->date)) {
       $dates = explode(' - ', $request->date);
       $fdate = date('Y-m-d', strtotime($dates[0]));
       $tdate = date('Y-m-d', strtotime($dates[1]));
       $employees = EmployeeAttendance::select('employee_id','exit_time')->where('exit_time','>',$exit_time)->whereBetween('date',[$fdate,$tdate]);
     } else {
       $employees = EmployeeAttendance::select('employee_id')->where('date',date('Y-m-d'));
       $fdate = date('Y-m-d');
       $tdate = date('Y-m-d');
     }

}

    if($request->employee){
      $employees = $employees->whereIn('employee_id',$request->employee);
    }

    if($request->department){
        $employees = $employees->whereIn('department_id',$request->department);
    }

    $employees = $employees->distinct()->groupby('employee_id')->get();

    //dd($employees);
    $report = $request->report;
    $type = $request->type;
     return view('backend.payRoll.report.attendanceLedger.report',compact('employees','report','fdate','tdate','type','exit_time'));
  }

public function leftyIndex(){
  $employees = Employee::orderby('emp_name','asc')->get();
  $departments = Department::orderby('department_title','asc')->get();
  return view('backend.payRoll.report.lefty.index', compact('employees','departments'));
}

public function leftyReport(Request $request){
  //dd($request->all());
  if(isset($request->monthYear)){
    $mY = explode('-', $request->monthYear);
    $employees = EmployeeAttendance::select('employee_id', DB::raw('sum(absent) as empAbsent'))->where('absent', 1)->whereMonth('date',$mY[1])->whereYear('date', $mY[0]);
  }

  if($request->employee){
    $employees = $employees->whereIn('employee_id',$request->employee);
  }

  if($request->department){
      $employees = $employees->whereIn('department_id',$request->department);
  }

  $employees = $employees->distinct()->groupby('employee_id')->get();

   //dd($employees);

  $month = $request->monthYear.'-01';
  $day = $request->monthYear;
  $year = $mY[0];

$count = cal_days_in_month(CAL_GREGORIAN,$mY[1],$mY[0]);

return view('backend.payRoll.report.lefty.report',compact('employees','count','day','month','year'));

}


public function earnLeaveIndex(){
  $employees = Employee::orderby('emp_name','asc')->get();
  $departments = Department::orderby('department_title','asc')->get();
  return view('backend.payRoll.report.earnLeave.index', compact('employees','departments'));
}

public function earnLeaveReport(Request $request){
  //dd($request->all());
  if(isset($request->year)){
    $employees = EmployeeAttendance::select('employee_id', DB::raw('sum(present) as empWorkDay'))->where('present','1')->whereYear('date', $request->year);
  }

  if($request->employee){
    $employees = $employees->whereIn('employee_id',$request->employee);
  }

  if($request->department){
      $employees = $employees->whereIn('department_id',$request->department);
  }

  $employees = $employees->distinct()->groupby('employee_id')->get();

  //dd($employees);

  $year = $request->year;

return view('backend.payRoll.report.earnLeave.report',compact('employees','year'));

}

}
