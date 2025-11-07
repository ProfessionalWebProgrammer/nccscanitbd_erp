@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Monthly Deductions Report View</h5>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>Sl</th>
                                <th>Employee Name</th>
                                <th>Employee Designation</th>
                                <th>Late Fine</th>
                                <th>Absent Fine</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                           @php

                            @endphp
                          @foreach($emp_acc as $emp)
                          	@php


                          		$employee = DB::table('employees')
                                          ->select('employees.*','designations.designation_title')
                                          ->leftJoin('designations','designations.id','employees.emp_designation_id')
                                          ->where('employees.id',$emp->emp_id)
                                          ->orderBy('emp_name','asc')
                                          ->first();

                          		$totalpresent = DB::table('employee_attendances')
                          					->whereBetween('date', [$fdate, $tdate])
                          					->where('employee_id',$emp->emp_id)
                          					->where('present',1)
                          					->count('id');

                          		$totalabsent = DB::table('employee_attendances')
                          					->whereBetween('date', [$fdate, $tdate])
                          					->where('employee_id',$emp->emp_id)
                          					->where('absent',1)
                          					->count('id');

                          		$totallofa = DB::table('employee_attendances')
                          					->whereBetween('date', [$fdate, $tdate])
                          					->where('employee_id',$emp->emp_id)
                          					->where('leave_of_absent',1)
                          					->count('id');

                                  $eadvance = DB::table('employee_other_amounts')
                                              ->where('month',date('Y-m', strtotime($fdate)))
                                              ->where('emp_id',$emp->emp_id)
                                              ->where('type',"Advance")
                                              ->sum('amount');


                          		$fineday = $totalabsent - $totallofa;
                          		$findfineamount = DB::table('leave_of_absents')
                          			->where('employee_id',$emp->emp_id)
                          			->orderBy('id','desc')
                          			->first();

                          		if($findfineamount){
                          			$fineamount = $findfineamount->exceed_fine_amount;
                          			$totalfineamount =$fineday*$fineamount;
                          		}else{
                          			$totalfineamount =0;
                          		}


                          		$period = \Carbon\CarbonPeriod::create($fdate, $tdate);
                          		$emp_perdaysalary = round($emp->net_salary_after_EPF/30);

                          		$entrytime = DB::table('employee_attendances')
                          					->where('employee_id',$emp->emp_id)
                          					->whereBetween('date',[$fdate, $tdate])
                          					->orderby('date','asc')
                          					->get();
                         // dd($entrytime);
                          $latetotal = 0;
                          $lateday = 0;
                                foreach ($entrytime as $key => $data) {


                          			if($data->late_status == 1){
                                      	$lateday += 1;




                                     } else{
                          				$lateday = 0;
                          			}



                         		 		if($lateday >= 3){
                                            	$latetotal += 1;
                          			   }
                             }

                        	$totallatefineamount = $latetotal*$emp_perdaysalary;
                            $totaldiduction =$totallatefineamount+$totalfineamount;
                          	@endphp
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $employee->emp_name }}</td>
                              <td>{{ $employee->designation_title }}</td>
                              <td class="text-right">{{$totallatefineamount}}</td>
                              <td class="text-right">{{number_format($totalfineamount,2)}}</td>
                              <td class="text-right">{{number_format($totaldiduction,2)}}</td>


                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
