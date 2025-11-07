<?php

namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComplianceNonCompliance;
use App\Models\EmployeePartialLeave;
use App\Models\EmployeeMaternityLeave;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class TimeAttendanceController extends Controller
{
    public function lateEmployeeListIndex(){
      return view('backend.payRoll.timeAttendance.lateEmployee.index');
    }

    public function lateManageListIndex(){
      return view('backend.payRoll.timeAttendance.lateManage.index');
    }
    public function lateManageCreate(){
      return view('backend.payRoll.timeAttendance.lateManage.create');
    }


    public function lateManageDeductedProrityIndex(){
      return view('backend.payRoll.timeAttendance.lateManage.deductedProrityIndex');
    }
    public function lateManageDeductedProrityCreate(){
      return view('backend.payRoll.timeAttendance.lateManage.deductedProrityCreate');
    }

    public function shiftManageListIndex(){
      return view('backend.payRoll.timeAttendance.shiftManage.index');
    }
    public function shiftManageCreate(){
      return view('backend.payRoll.timeAttendance.shiftManage.create');
    }


    public function maternityLeavePolicyIndex(){
      $employees = EmployeeMaternityLeave::where('status',1)->orderby('id','desc')->get();
      return view('backend.payRoll.timeAttendance.maternityLeave.index',compact('employees'));
    }
    public function maternityLeavePolicyCreate(){
      $employees = Employee::where('emp_gender',1)->orderby('emp_name','asc')->get();
      $userId = Auth::id();
      return view('backend.payRoll.timeAttendance.maternityLeave.create',compact('employees','userId'));
    }

    public function maternityLeavePolicyStore(Request $request){
      //dd($request->all());
      $temp = $request->duration;
      $endDate = date("Y-m-d", strtotime("+".$temp." month", strtotime($request->executeDate)));
      $emLeave = new EmployeeMaternityLeave();
      $emLeave->fill($request->all());
      $emLeave->save();
        $emLeave->endDate = $endDate;
        if($emLeave->save()){
          return redirect()->back()->with('success', 'Employee Maternity Leave Create Successfull');
      }
    }

    public function maternityLeavePolicyDelete(Request $request){
      //dd($request->all());
        $emp = EmployeeMaternityLeave::where('id',$request->id)->first();
        $emp->status = 0;
        return redirect()->back()->with('success', 'Employee Maternity Leave Deleted Successfull');
    }

    public function maternityLeaveReportIndex(){
      $employees = Employee::where('emp_gender',1)->orderby('emp_name','asc')->get();
      return view('backend.payRoll.timeAttendance.maternityLeave.reportIndex',compact('employees'));
    }

    public function maternityLeaveReportView(Request $request){
      if(isset($request->date)) {
        $dates = explode(' - ', $request->date);
        $fdate = date('Y-m-d', strtotime($dates[0]));
        $tdate = date('Y-m-d', strtotime($dates[1]));
      } else {
        $fdate = date('Y-m-d');
        $tdate = date('Y-m-d');
      }
      if(isset($request->emp_id)){
          $employees = EmployeeMaternityLeave::whereIn('emp_id',$request->emp_id)->whereBetween('date',[$fdate,$tdate])->get();
      } else {
          $employees = EmployeeMaternityLeave::whereBetween('date',[$fdate,$tdate])->get();
      }
    return view('backend.payRoll.timeAttendance.maternityLeave.report',compact('employees','fdate','tdate'));
    }

    public function paternityLeavePolicyIndex(){
      return view('backend.payRoll.timeAttendance.paternityLeave.index');
    }
    public function paternityLeavePolicyCreate(){
      return view('backend.payRoll.timeAttendance.paternityLeave.create');
    }

    public function billingProcessingMPIndex(){
      return view('backend.payRoll.timeAttendance.billingProcessing.index');
    }
    public function billingProcessingMPCreate(){
        $employees = Employee::orderby('emp_name','asc')->get();
      return view('backend.payRoll.timeAttendance.billingProcessing.create',compact('employees'));
    }

    public function employeeWisePolicyAssignIndex(){
      return view('backend.payRoll.timeAttendance.eWisePolicyAssign.index');
    }
    public function employeeWisePolicyAssignCreate(){
        $employees = Employee::orderby('emp_name','asc')->get();
      return view('backend.payRoll.timeAttendance.eWisePolicyAssign.create',compact('employees'));
    }

    public function employeeHolidayCalenderIndex(){
      return view('backend.payRoll.timeAttendance.holidayCalender.index');
    }
    public function employeeHolidayCalenderCreate(){
      return view('backend.payRoll.timeAttendance.holidayCalender.create');
    }

    public function employeePartialLeaveIndex(){
      $results = EmployeePartialLeave::whereNotNull('cl_day')->get();
      //dd($datas);
      return view('backend.payRoll.timeAttendance.partialLeave.index',compact('results'));
    }
    public function employeePartialLeaveCreate(){
        $userId = Auth::id();
        $employees = Employee::orderby('emp_name','asc')->get();
      return view('backend.payRoll.timeAttendance.partialLeave.create',compact('employees','userId'));
    }


    public function employeePartialLeaveStore(Request $request){
    //  dd($request->all());
      $pLeave = new EmployeePartialLeave();
      $pLeave->fill($request->all());
      if($pLeave->save()){
          return redirect()->back()->with('success', 'Employee CL Leave Create Successfull');
      }
    }

  public function employeePartialLeaveDelete(Request $request){
    //dd($request->all());
    EmployeePartialLeave::where('id',$request->id)->delete();
    return redirect()->back()->with('success', 'Employee CL Leave Deleted Successfull');
  }

    public function employeeFractionalLeaveIndex(){
        $results = EmployeePartialLeave::whereNotNull('sl_day')->get();
      return view('backend.payRoll.timeAttendance.fractionalLeave.index',compact('results'));
    }
    public function employeeFractionalLeaveCreate(){
        $userId = Auth::id();
        $employees = Employee::orderby('emp_name','asc')->get();
      return view('backend.payRoll.timeAttendance.fractionalLeave.create',compact('employees','userId'));
    }

    public function employeeFractionalLeaveStore(Request $request){
    //  dd($request->all());
      $pLeave = new EmployeePartialLeave();
      $pLeave->fill($request->all());
      if($pLeave->save()){
          return redirect()->back()->with('success', 'Employee SL Leave Create Successfull');
      }
    }

  public function employeeFractionalLeaveDelete(Request $request){
    //dd($request->all());
    EmployeePartialLeave::where('id',$request->id)->delete();
    return redirect()->back()->with('success', 'Employee SL Leave Deleted Successfull');
  }


    public function complianceNonComplianceIndex(){
      $datas = ComplianceNonCompliance::get();
      return view('backend.payRoll.timeAttendance.complianceNonCompliance.index',compact('datas'));
    }
    public function complianceNonComplianceStore(Request $request){
      //dd($request->all());
      $emp = new ComplianceNonCompliance();
      $emp->fill($request->all());
      if($emp->save()){
         return redirect()->back()->with('success','Employee Compliance Non-Compliance Data Store Successfully');
      }
    }

    public function complianceNonComplianceDelete(Request $request){
      // dd($request->id);
      ComplianceNonCompliance::where('id',$request->id)->delete();
      return redirect()->back()->with('success','Employee Compliance Non-Compliance Data Delete Successfully');
    }

}
