@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Monthly Salary And Attendance Report View</h5>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>Sl</th>
                                <th>Em Name</th>
                                <th>Deg</th>
                                <th>Pres</th>
                                <th>Absn</th>
                                <th>Leave of Absent</th>
                                <th>Holiday</th>
                                <th>Ovt</th>
                                <th>Holiday A.</th>
                                <th>Pfb</th>
                                <th>Fine</th>
                                <th>Netsal</th>
                                <th>Advn</th>
                                <th>This Month Salary</th>
                                <th>Paym</th>
                                <th>bal</th>
                                <th>remark</th>
                            </tr>
                        </thead>
                        <tbody>
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
                          		$totalholyday = DB::table('employee_attendances')
                          					->whereBetween('date', [$fdate, $tdate])
                          					->where('employee_id',$emp->emp_id)
                          					->where('holyday',1)
                          					->count('id');



                          	$epfb = DB::table('employee_other_amounts')
                          				->where('month',date('Y-m', strtotime($fdate)))
                          				->where('emp_id',$emp->emp_id)
                          				->where('type',"PerformanceB")
                          				->sum('amount');



                          $eholidayamount = DB::table('employee_other_amounts')
                          				->where('month',date('Y-m', strtotime($fdate)))
                          				->where('emp_id',$emp->emp_id)
                          				->where('type',"Holiday")
                          				->sum('amount');
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


                          		$entrytime = \Carbon\Carbon::createFromFormat('H:i', '3:30');
                                $exittime = \Carbon\Carbon::createFromFormat('H:i', '4:32');

                                $diff_in_hours = $exittime->diffInHours($entrytime);
                                $diff_in_minutes = $exittime->diffInMinutes($entrytime);

                          		$period = \Carbon\CarbonPeriod::create($fdate, $tdate);
                          		$totalmunite = 0;

                                foreach ($period as $date) {
                          			$odate = date('Y-m-d',strtotime($date));
                                    $overtime = DB::table('employee_overtimes')
                          					->where('employee_id',$emp->emp_id)
                          					->where('date',$odate)
                          					->first();
                          			if($overtime){
                                      $entrytime = \Carbon\Carbon::createFromFormat('H:i', $overtime->ovt_start);
                                      $exittime = \Carbon\Carbon::createFromFormat('H:i', $overtime->ovt_end);

                                      $diff_in_hours = $exittime->diffInHours($entrytime);
                                      $diff_in_minutes = $exittime->diffInMinutes($entrytime);

                                      $totalmunite += $diff_in_minutes;
                                     }
                                }
                          		$overtimehour = $totalmunite/60;
                          		$overtimeamount = $emp->overtime_per_houre*$overtimehour;
                          		$netsalary = $emp->net_salary_after_EPF;


                          //late fine code start
                          	$entrytime = DB::table('employee_attendances')
                          					->where('employee_id',$emp->emp_id)
                          					->whereBetween('date',[$fdate, $tdate])
                          					->orderby('date','asc')
                          					->get();
                          //dd($entrytime);
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
                         	$emp_perdaysalary = round($emp->net_salary_after_EPF/30);
                        	$totallatefineamount = $latetotal*$emp_perdaysalary;
                          //late fine code end
                          $finalfine= $totallatefineamount+$totalfineamount;
                          $finalnetsalary = $netsalary+$overtimeamount - $finalfine + $epfb + $eholidayamount - $eadvance;
                          	$payments = DB::table('employee_payments')
                          					->whereBetween('date', [$fdate, $tdate])
                          					->where('emp_id',$emp->emp_id)
                          					->sum('payment_amount');

                          $balancee= $finalnetsalary-$payments;

                          	@endphp
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $employee->emp_name }}</td>
                              <td>{{ $employee->designation_title }}</td>
                              <td class="text-right">{{ $totalpresent }}</td>
                              <td class="text-right">{{ $totalabsent }}</td>
                              <td class="text-right">{{ $totallofa }}</td>
                              <td class="text-right">{{ $totalholyday }}</td>
                              <td class="text-right">{{ $overtimeamount}}</td>
                              <td class="text-right">{{ $eholidayamount}}</td>
                              <td class="text-right">{{$epfb}}</td>
                              <td class="text-right">{{$finalfine}}</td>
                              <td class="text-right">{{number_format($netsalary,2)}}</td>
                              <td class="text-right">{{$eadvance}}</td>
                              <td class="text-right">{{number_format($finalnetsalary,2)}}</td>
                              <td class="text-right">{{$payments}}</td>
                              <td class="text-right">{{$balancee}}</td>
                              <td class="text-right"></td>


                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
