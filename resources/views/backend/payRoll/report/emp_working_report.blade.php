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
                        <h5 class="text-uppercase font-weight-bold">Employee Working Report</h5>
                      	 <p>Date: {{ $fdate }} To {{ $tdate }}</p>
                        <hr>
                    </div>
                    <table class="table table-bordered table-striped text-center" style="font-size: 15px;">
                        <thead>
                            <tr>
                               <th>Employee Name</th>
                               <th>Designation</th>
                               <th>Week One</th>
                               <th>Week Two</th>
                               <th>Week Three</th>
                               <th>Week Four</th>
                               <th>Week Five</th>
                               <th>OT One</th>
                               <th>OT Two</th>
                               <th>OT Three</th>
                               <th>OT Four</th>
                               <th>OT Five</th>
                               <th>Total Hour</th>
                               <th>Comment</th>
                            </tr>
                       </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                @php
                                    $totalOne = isset($employee->weeklyWorkingHours[0]) && $employee->weeklyWorkingHours[0]['week_name'] == 'week_1' ? $employee->weeklyWorkingHours[0]['total_hours'] : 0 ;
                                    $totalTwo = isset($employee->weeklyWorkingHours[1]) && $employee->weeklyWorkingHours[1]['week_name'] == 'week_2' ? $employee->weeklyWorkingHours[1]['total_hours'] : 0 ;
                                    $totalThree = isset($employee->weeklyWorkingHours[2]) && $employee->weeklyWorkingHours[2]['week_name'] == 'week_3' ? $employee->weeklyWorkingHours[2]['total_hours'] : 0 ; 
                                    $totalFour = isset($employee->weeklyWorkingHours[3]) && $employee->weeklyWorkingHours[3]['week_name'] == 'week_4' ? $employee->weeklyWorkingHours[3]['total_hours'] : 0 ;
                                    $totalFive = isset($employee->weeklyWorkingHours[4]) && $employee->weeklyWorkingHours[4]['week_name'] == 'week_5' ? $employee->weeklyWorkingHours[4]['total_hours'] : 0;
                                    $totalFinal = intVal($totalOne) + intVal($totalTwo) + intVal($totalThree) + intVal($totalFour) + intVal($totalFive);
                                   
                                   
                                @endphp
                                <tr>
                                    <td>{{ $employee->emp_name }}</td>
                                    <td>{{ $employee->designation?->designation_title ?? '-' }}</td>
                                    <td >{{$totalOne > 0 ? min($totalOne, 54).' h' : '-'}}</td>
                                    <td >{{$totalTwo > 0 ? min($totalTwo , 54).' h' : '-'}}</td>
                                    <td >{{$totalThree > 0 ? min($totalThree , 54).' h' : '-'}}</td>
                                    <td >{{$totalFour > 0 ? min($totalFour , 54).' h' : '-'}}</td>
                                    <td >{{$totalFive > 0 ? min($totalFive , 54).' h' : '-'}}</td>
                                    <td >{{ $totalOne > 0 ? max(0, $totalOne - 54) > 0 ? max(0, $totalOne - 54).' h' : '-' :'-' }}</td>
                                    <td >{{ $totalTwo > 0 ? max(0, $totalTwo - 54) > 0 ? max(0, $totalTwo - 54).' h' : '-' :'-' }}</td>
                                    <td >{{ $totalThree > 0 ? max(0, $totalThree - 54) > 0 ? max(0, $totalThree - 54).' h' : '-' :'-' }}</td>
                                    <td >{{ $totalFour > 0 ? max(0, $totalFour - 54) > 0 ? max(0, $totalFour - 54).' h' : '-' :'-' }}</td>
                                    <td >{{ $totalFive > 0  ? max(0, $totalFive - 54) > 0 ? max(0, $totalFive - 54).' h' : '-' :'-' }}</td>
                                    <td> <strong> {{ $totalFinal.' h' }}</strong></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                          <tr>

                          </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
