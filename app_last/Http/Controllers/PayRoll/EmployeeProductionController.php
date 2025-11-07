<?php

namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\EmployeeProduct;
use App\Models\EmployeeProduction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeeProductionController extends Controller
{
    public function productIndex(){
      $productDatas = EmployeeProduct::orderby('id','desc')->get();
      return view('backend.payRoll.product.index', compact('productDatas'));
    }

    public function productCreate(){
      return view('backend.payRoll.product.create');
    }

    public function productStore(Request $request){
      //dd($request->all());
      $emp = new EmployeeProduct();
      $emp->fill($request->all());
      if($emp->save()){
         return redirect()->back()->with('success','Employee Product Create Successfully');
       }
    }

    public function productDelete(Request $request){
      //  dd($request->all());
      EmployeeProduct::where('id',$request->id)->delete();
      return redirect()->back()->with('success','Employee Product Delete Successfully');
    }

    public function productGet($id){
      $data = [];
      $result = EmployeeProduct::where('id',$id)->first();
      $data['cat'] = $result->category;
      $data['rate'] = $result->rate;
      return response($data);
    }

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



public function pReportIndex()
{
    $employee = Employee::orderby('emp_name','asc')->get();
    return view('backend.payRoll.employeeProductionReport.index', compact('employee'));
}

public function pReportView(Request $request){

  if(isset($request->date)) {
    $dates = explode(' - ', $request->date);
    $fdate = date('Y-m-d', strtotime($dates[0]));
    $tdate = date('Y-m-d', strtotime($dates[1]));
  } else {
    $fdate = date('Y-m-d');
    $tdate = date('Y-m-d');
  }

  if(isset($request->emp_id)){
  $employees =  EmployeeProduction::whereIn('emp_id',$request->emp_id)->whereBetween('date',[$fdate, $tdate])->orderby('date','asc')->groupBy('emp_id')->get();
  } else {
  $employees = EmployeeProduction::whereBetween('date',[$fdate, $tdate])->orderby('date','asc')->groupBy('emp_id')->get();
  }
  return view('backend.payRoll.employeeProductionReport.report', compact('employees','fdate','tdate'));
}

}
