<?php

namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payroll\EmployeeLeavePolicySystem;
use App\Models\LeaveOfAbsent;

class EmployeeLeaveSystemController extends Controller
{
    public function empLeavePolicyList(){
        $employeeLeavePolicySystems = EmployeeLeavePolicySystem::orderBy('id' , 'desc')->paginate(10);
        return view('backend.payRoll.employee_leave_policy_system.index',[
            'employeeLeavePolicySystems' =>  $employeeLeavePolicySystems
        ]);
    }

    public function empLeavePolicyCreate(){
        return view('backend.payRoll.employee_leave_policy_system.create');
    }

    public function empLeavePolicyStore(Request $request){
        $employeeLeavePolicySystem = new EmployeeLeavePolicySystem();
        $employeeLeavePolicySystem->fill($request->all());
        $employeeLeavePolicySystem->created_by = auth()->user()->id;
        $employeeLeavePolicySystem->save();
        return redirect()->route('emp.leave.policy.list')->with('success','Data inserted successfully');
    }

    public function empLeavePolicyEdit($id){
        $employeeLeavePolicySystem = EmployeeLeavePolicySystem::findOrFail($id);
        return view('backend.payRoll.employee_leave_policy_system.edit',[
             'employeeLeavePolicySystem' => $employeeLeavePolicySystem
        ]);
    }

    public function empLeavePolicyUpdate(Request $request , $id){
        $employeeLeavePolicySystem = EmployeeLeavePolicySystem::findOrFail($id);
        $employeeLeavePolicySystem->fill($request->all());
        $employeeLeavePolicySystem->updated_by = auth()->user()->id;
        $employeeLeavePolicySystem->save();
        return redirect()->route('emp.leave.policy.list')->with('success','Data updated successfully');
    }

    public function empLeavePolicyDelete(Request $request){
        $employeeLeavePolicySystem = EmployeeLeavePolicySystem::findOrFail($request->id);
        $employeeLeavePolicySystem->delete();
        return redirect()->route('emp.leave.policy.list')->with('success','Data deleted successfully');
    }

    public function empLeaveOfAbsenceStatusApprove(Request $request){
        $leaveOfAbsent = LeaveOfAbsent::findOrFail($request->id);
        $leaveOfAbsent->status = 1;
        $leaveOfAbsent->save();
        return redirect()->back()->with('success','Leave Application Approved Successfully');

    }
}
