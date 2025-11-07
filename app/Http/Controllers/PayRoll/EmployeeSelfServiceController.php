<?php

namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeSelfServiceController extends Controller
{
    public function dashboard(){
      return view('backend.dashboard.employee_dashboard');
    }

    public function index(){
      return view('backend.selfService.index');
    }

    public function leaveApplicationIndex(){
      return view('backend.selfService.leave.index');
    }

    public function leaveApplicationCreate(){
      return view('backend.selfService.leave.create');
    }

    public function myAttendanceIndex(){
      return view('backend.selfService.myAttendanceIndex');
    }

    public function myAttendanceReport(Request $request){
      if (isset($request->date)) {
              $dates = explode(' - ', $request->date);
              $fdate = date('Y-m-d', strtotime($dates[0]));
              $tdate = date('Y-m-d', strtotime($dates[1]));
          }
      return view('backend.selfService.myAttendanceReport', compact('fdate','tdate'));
    }
}
