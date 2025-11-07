<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\EmployeeAttendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;
use Carbon\CarbonPeriod;
use Carbon\Carbon;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
  
  
    public function allEmployees(){
      $data = Employee::get();
      if($data){
            return response()->json(['allEmployees'=>$data,'status'=>201]);
        }
        else
        {
            return response()->json(['res'=>'Data Not Found','status'=>404]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function employeeAttendance(Request $request){
      $myid = Auth::id();
      if(empty($request->date)){
        $date = date('Y-m-d');
        
      } else {
          $date = date('Y-m-d',strtotime($request->date));
      }

      	$day = date('D',strtotime($date));
        if($day == 'Fri'){
          $holyday = 1;
        } else {
          $holyday = '';
        }
      	$mytime = Carbon::now();
        $time = date('g:i a',strtotime($mytime));
      
      	$emp =  EmployeeAttendance::where('employee_id',$request->employee_id)->where('date',$date)->first();
      
      if(!empty($emp)){
        $emp->employee_id = $request->employee_id ?? $emp->employee_id;
        $emp->entry_time = $time ?? $emp->entry_time;
        /*
        $emp->break_time = $request->break_time ?? $emp->break_time;
        $emp->break_back_time = $request->break_back_time ?? $emp->break_back_time;
        $emp->exit_time = $request->exit_time ?? $emp->exit_time;
        */
        $emp->date = $date ?? $emp->date;
        $emp->location = $emp->location;
        $emp->late_status = $lateday ?? $emp->late_status;
        $emp->present = $emp->present;
        $emp->absent = $emp->absent;
        $emp->holyday = $holyday ?? $emp->holyday;
        $emp->save();
        $save = 2;
      } else {
        if($request->entry_time!= null) {
            $entrytime = \Carbon\Carbon::createFromFormat('H:i', $request->entry_time);
            $fixtime = \Carbon\Carbon::createFromFormat('H:i', '9:15');
            $present = 1;
            $absent = 0;
            if($entrytime > $fixtime){
              $lateday =1;
              } else {
              $lateday =0;
              }
         } else {
           $lateday =0;
           $present = 0;
           $absent = 1;
         }
        
       $val = $request->location;
       $location = explode(",",$val);
       $data =  unserialize(file_get_contents('http://www.geoplugin.net/extras/nearby.gp?lat='.$location[0].'&long='.$location[1].'&output=json'));
       $place = $data[0]['geoplugin_place'].', '.$data[0]['geoplugin_region'];
        
        $empatt = new EmployeeAttendance();
        $empatt->employee_id = $request->employee_id;
        $empatt->entry_time = $time;
        
        /*
        $empatt->break_time = $request->break_time ?? '';
        $empatt->break_back_time = $request->break_back_time ?? '';
        $empatt->exit_time = $request->exit_time ?? '';
        */
        
        $empatt->date = $date;
        $empatt->location = $place;
        $empatt->late_status = $lateday;
        $empatt->present = $present;
        $empatt->absent = $absent;
        $empatt->holyday = $holyday;
        $empatt->save();
        $save = 1;
      }

         if($save == 1){
               return response()->json(['success'=>'Employee Attebdance Successfull','status'=>201]);
           } elseif($save == 2){
              return response()->json(['success'=>'Employee Attebdance Updated Successfull','status'=>201]);
           }
           else
           {
               return response()->json(['res'=>'Data Not Store','status'=>404]);
           }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
