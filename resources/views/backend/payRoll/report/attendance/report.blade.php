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
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Attendance @if($type == 1)  Compliance Report @elseif($type == 2)  Non Compliance Report @else  @endif List</h5>
                      	 <p>Date: {{date('d M ,Y',strtotime($fdate))}} to {{date('d M ,Y',strtotime($tdate))}}</p>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Employee Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                @if($report == 1)
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
                                @if($report != 2)
                                <th>Over Time </br> @if($type == 1) (5 pm - 7 pm) @elseif($type == 2) (5 pm - 12 pm) @else  @endif</th>
                                @endif
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
                            if($type == 1) {
                              $data = DB::table('employee_attendances')->select(
                              'employee_id',
                              DB::raw('SUM(CASE WHEN present = 1 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `present` ELSE null END) as total_present'),
                              DB::raw('SUM(CASE WHEN late = 1 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `late` ELSE null END) as total_late'),
                              DB::raw('SUM(CASE WHEN overTime > .1 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `overTime` ELSE null END) as total_overTime')
                              )->where('employee_id',$emp->employee_id)->where('exit_time','<=', $exit_time)->first();
                            } else {
                              $data = DB::table('employee_attendances')->select(
                              'employee_id',
                              DB::raw('SUM(CASE WHEN present = 1 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `present` ELSE null END) as total_present'),
                              DB::raw('SUM(CASE WHEN late = 1 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `late` ELSE null END) as total_late'),
                              DB::raw('SUM(CASE WHEN overTime > .1 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `overTime` ELSE null END) as total_overTime')
                              )->where('employee_id',$emp->employee_id)->where('exit_time','>', $exit_time)->first();
                            }
                            
                            $absentDay = \App\Models\EmployeeAttendance::where('employee_id',$emp->employee_id)->whereBetween('date',[$fdate,$tdate])->sum('absent');
                            
                            $totalPresent += $data->total_present;
                            $totalAbsent += $absentDay;
                            $totalLate += $data->total_late;
                            $totalOverTime += $data->total_overTime;
                            @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                  	<td class="text-center">{{$emp->employee->emp_name ?? ''}}</td>
                                  	<td class="text-center">{{$emp->employee->designation->designation_title ?? ''}}</td>
                                  	<td class="text-center">{{$emp->employee->department->department_title ?? ''}}</td>
                                    @if($report == 1)
                                    <td class="text-center">{{$data->total_present}}</td>
                                    @elseif($report == 2)
                                    <td class="text-center">{{$absentDay}}</td>
                                    @elseif($report == 3)
                                    <td class="text-center">{{$data->total_late}}</td>
                                    @else
                                  	<td class="text-center">{{$data->total_present}}</td>
                                    <td class="text-center">{{$absentDay}}</td>
                                  	<td class="text-center">{{$data->total_late}}</td>
                                    @endif
                                    @if($report != 2)
                                    <td class="text-center">{{$data->total_overTime}}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="4">Total: </td>
                            @if($report == 1)
                            <td class="text-center">{{$totalPresent}} Days</td>
                            @elseif($report == 2)
                            <td class="text-center">{{$totalAbsent}} Days</td>
                            @elseif($report == 3)
                            <td class="text-center">{{$totalLate}} Days</td>
                            @else
                            <td class="text-center">{{$totalPresent}} Days</td>
                            <td class="text-center">{{$totalAbsent}} Days</td>
                            <td class="text-center">{{$totalLate}} Days</td>
                            @endif
                            @if($report != 2)
                            <td class="text-center">{{$totalOverTime}} Hours</td>
                            @endif
                          </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
