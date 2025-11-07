<?php

namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeAccount;
use App\Models\EmployeePayment;
use App\Models\EmployeeAttendance;


class SalaryReportController extends Controller
{
    public function index(){
      $employees = Employee::orderby('emp_name','asc')->get();
      return view('backend.payRoll.report.salaryReport.index', compact('employees'));
    }


    public function report(Request $request){
      //dd($request->all());
      if(isset($request->date)) {
        $dates = explode(' - ', $request->date);
        $fdate = date('Y-m-d', strtotime($dates[0]));
        $tdate = date('Y-m-d', strtotime($dates[1]));
      } else {
        $fdate = date('Y-m-d');
        $tdate = date('Y-m-d');
      }

      if(isset($request->employee)){
        $employees = EmployeePayment::whereIn('emp_id',$request->employee)->whereBetween('date',[$fdate,$tdate])->orderBy('emp_id','asc')->get();
      } else {
          $employees = EmployeePayment::whereBetween('date',[$fdate,$tdate])->orderBy('emp_id','asc')->get();
      }

      return view('backend.payRoll.report.salaryReport.report',compact('fdate','tdate','employees'));
    }

    public function productSalaryIndex(){
      $employees = Employee::orderby('emp_name','asc')->get();
      return view('backend.payRoll.report.productSalaryReport.index', compact('employees'));
    }

    public function productSalaryReport(Request $request){
      //dd($request->all());
      if(isset($request->date)) {
        $dates = explode(' - ', $request->date);
        $fdate = date('Y-m-d', strtotime($dates[0]));
        $tdate = date('Y-m-d', strtotime($dates[1]));
      } else {
        $fdate = date('Y-m-d');
        $tdate = date('Y-m-d');
      }

      if(isset($request->employee)){
        $employees = EmployeePayment::whereIn('emp_id',$request->employee)->whereBetween('date',[$fdate,$tdate])->orderBy('emp_id','asc')->get();
      } else {
          $employees = EmployeePayment::whereBetween('date',[$fdate,$tdate])->orderBy('emp_id','asc')->get();
      }

      return view('backend.payRoll.report.productSalaryReport.report',compact('fdate','tdate','employees'));
    }
}
