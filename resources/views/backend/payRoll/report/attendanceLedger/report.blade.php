@extends('layouts.hrPayroll_dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">

                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 ">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Attendance @if($type == 1)  Compliance Report @elseif($type == 2)  Non Compliance Report @else  @endif List</h5>
                      	 <p>Date: {{date('d M ,Y',strtotime($fdate))}} to {{date('d M ,Y',strtotime($tdate))}}</p>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <!-- <th>Employee Name</th>
                                <th>Designation</th>
                                <th>Department</th> -->
                                <td>Date</td>
                               {{-- @if($report == 1)
                                <th>Present </br>(8 am - 5 pm) </th>
                                @elseif($report == 2)
                                <th>Absent</th>
                                @elseif($report == 3)
                                <th>Late</th>
                                @else
                                <th>Present </br>(8 am - 5 pm)</th>
                                <th>Absent</th>
                                <th>Late</th>
                                @endif 
                                <th>Over Time </br> @if($type == 1) (5 pm - 7 pm) @elseif($type == 2) (5 pm - 12 pm) @else  @endif</th>
                                --}}
                                <th>Attendance</th>
                                <th>Over Time</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php
                          $totalPresent = 0;
                          $totalAbsent = 0;
                          $totalLate = 0;
                          $totalOverTime = 0;

                          @endphp
                            @foreach ($employees as $emp)
                            @php
                            /*if($type == 1) {
                              $datas = DB::table('employee_attendances')->select(
                              'date','present','late','absent','entry_time','exit_time','overTime')->where('employee_id',$emp->employee_id)->where('exit_time','<=', $exit_time)->get();
                            } else {
                              $datas = DB::table('employee_attendances')->select(
                              'date','present','late','absent','entry_time','exit_time','overTime')->where('employee_id',$emp->employee_id)->where('exit_time','>', $exit_time)->get();
                            } */
                            
                            $datas = DB::table('employee_attendances')->select(
                              'date','present','late','absent','entry_time','exit_time','overTime')->where('employee_id',$emp->employee_id)->get();
                              
                            $subTotalPresent = 0;
                            $subTotalAbsent = 0;
                            $subTotalLate = 0;
                            $subTotalOverTime = 0;

                            @endphp
                            <tr>
                              <td colspan="100%">{{$emp->employee->emp_name ?? ''}}, {{$emp->employee->designation->designation_title ?? ''}}, {{$emp->employee->department->department_title ?? ''}}</td>
                            </tr>
                          @foreach ($datas as $val)
                          @php
                          $subTotalPresent += $val->present;
                          $subTotalAbsent += $val->absent;
                          $subTotalLate += $val->late;
                          $subTotalOverTime += $val->overTime;

                          $totalPresent += $val->present;
                          $totalAbsent += $val->absent;
                          $totalLate += $val->late;
                          $totalOverTime += $val->overTime;
                          @endphp
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">{{date('d M ,Y',strtotime($val->date))}}</td>
                           {{--  @if($report == 1)
                            <td class="text-center">@if($val->present == 1) Present @endif</td>
                            @elseif($report == 2)
                            <td class="text-center">{{$val->absent}}</td>
                            @elseif($report == 3)
                            <td class="text-center">{{$subTotalLate}}</td>
                            @else
                            <td class="text-center">{{$val->present}}</td>
                            <td class="text-center">{{$val->absent}}</td>
                            <td class="text-center">{{$subTotalLate}}</td>
                            @endif --}}
                            <td>@if($val->present == 1) <span style="color: Green;">Present</span>
                               @elseif($val->absent == 1) <span style="color: red;"> Absent  </span>
                               @elseif($val->late == 1) <span style="color: orange;"> Late Present  </span>
                               @else  Holiday  @endif 
                            </td>
                            <td class="text-center">{{$val->overTime}}</td>
                          </tr>
                          @endforeach
                                <tr>
                                  {{--	<td colspan="2">Sub Total: </td>
                                    @if($report == 1)
                                    <td class="text-center">{{$subTotalPresent}}</td>
                                    @elseif($report == 2)
                                    <td class="text-center">{{$subTotalAbsent}}</td>
                                    @elseif($report == 3)
                                    <td class="text-center">{{$subTotalLate}}</td>
                                    @else
                                  	<td class="text-center">{{$subTotalPresent}}</td>
                                    <td class="text-center">{{$subTotalAbsent}}</td>
                                  	<td class="text-center">{{$subTotalLate}}</td>
                                    @endif
                                    <td class="text-center">{{$subTotalOverTime}}</td> --}}
                                    <td colspan="100%" style="font-size:16px;">Sub Total: <span style="color: Green;"> Present : {{$subTotalPresent}}</span> , <span style="color: red;"> Absent: {{$subTotalAbsent}}</span> , <span style="color: orange;"> Late Present: {{$subTotalLate}} </span> ,  <span style="color: blue;">Over Time: {{$subTotalOverTime}} Hours</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                         <tr>
                           {{-- <td colspan="2">Grand Total: </td>
                            @if($report == 1)
                            <td class="text-center">{{$totalPresent}} @if($totalPresent > 1) Days @elseif($totalPresent = 1) Day  @else ''  @endif </td>
                            @elseif($report == 2)
                            <td class="text-center">{{$totalAbsent}} @if($totalAbsent > 1) Days @elseif($totalAbsent = 1) Day  @else ''  @endif</td>
                            @elseif($report == 3)
                            <td class="text-center">{{$totalLate}} @if($totalLate > 1) Days @elseif($totalLate = 1) Day  @else  '' @endif</td>
                            @else
                            <td class="text-center">{{$totalPresent}} @if($totalPresent > 1) Days @elseif($totalPresent = 1) Day  @else  '' @endif</td>
                            <td class="text-center">{{$totalAbsent}} @if($totalAbsent > 1) Days @elseif($totalAbsent = 1) Day  @else  '' @endif</td>
                            <td class="text-center">{{$totalLate}} @if($totalLate > 1) Days @elseif($totalLate = 1) Day  @else ''  @endif</td>
                            @endif
                            <td class="text-center">{{$totalOverTime}}  @if($totalOverTime > 1) Hours @elseif($totalOverTime = 1) Hour  @else  '' @endif</td>
                            --}}
                            <td colspan="100%" style="font-size:18px;">Grand Total: <span style="color: Green;"> Present : {{ $totalPresent }}</span> , <span style="color: red;"> Absent: {{$totalAbsent}}</span> , <span style="color: orange;"> Late Present: {{$totalLate}}</span>, <span style="color: blue;">Over Time: {{$totalOverTime}} Hours</span> </td>
                          </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
