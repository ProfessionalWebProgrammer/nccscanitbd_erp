<?php

namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeReward;
use App\Models\EmployeeAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeeRewardController extends Controller
{
  public function index(){
    $rewardDatas = EmployeeReward::orderby('id','desc')->get();
    return view('backend.payRoll.reward.index', compact('rewardDatas'));
  }

  public function create(){
    $urerid = Auth::id();
    $employees = Employee::orderby('emp_name','asc')->get();
    return view('backend.payRoll.reward.create', compact('urerid','employees'));
  }

  public function store( Request $request){
//  dd($request->all());
  $emp = new EmployeeReward();
  $emp->fill($request->all());
  if($emp->save()){
     return redirect()->back()->with('success','Employee Reward Submit Successfully');
  }
  }

  public function delete( Request $request){
    // dd($request->all());
    EmployeeReward::where('id',$request->id)->delete();
    return redirect()->back()->with('success','Employee Reward Delete Successfully');
  }
}
