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
                    <p>Date : {{ $fdate }} To {{ $tdate }}</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Attendence Card report</h5>
                      	 {{-- <p>Date: </p> --}}
                        <hr>
                    </div>
                    <table class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>Date</th>
                                <th>Present</th>
                                <th>Entry Time</th>
                                <th>Exit Time</th>
                                <th>Over Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <th colspan="5" class="table-warning">
                                        Employee Name : <span style="font-weight: normal;">{{ $employee?->emp_name }} </span><br/>
                                        Department : <span style="font-weight: normal;">{{ $employee?->department?->department_title ?? '---' }} </span><br/>
                                        Designation : <span style="font-weight: normal;">{{ $employee?->designation?->designation_title ?? '---' }} </span>
                                    </th>
                                </tr>
                                @foreach ($employee->empAttendanceInfo()->whereBetween('date' , [ $fdate , $tdate])->get() as $attendence)
                                    <tr class="text-center">
                                        <td class="text-left">{{ $attendence->date }}</td>
                                        <td>{{ $attendence->present == 1 ? 'Yes' : 'NO' }}</td>
                                        <td>{{ $attendence->present == 1 ? \Carbon\Carbon::parse($attendence->entry_time)->format('h:i A') : '---' }}</td>
                                        <td>{{ $attendence->present == 1 ? \Carbon\Carbon::parse($attendence->exit_time)->format('h:i A') : '---'  }}</td>
                                        @php
                                            if($attendence->present == 1){
                                                if($attendence->entry_time && $attendence->exit_time){
                                                    $entryTime = \Carbon\Carbon::createFromFormat('H:i', $attendence->entry_time);
                                                    $exitTime = \Carbon\Carbon::createFromFormat('H:i', $attendence->exit_time);
                                                   
                                                    $timeDifference = $entryTime->diff($exitTime);
                                                    if ($timeDifference->h >= 9) {
                                                        // $timeDifference->subHours(8);
                                                        $hours = $timeDifference->h - 9;
                                                        $minutes = $timeDifference->i;
                                                        $ot = $hours.':'.$minutes.' h';
                                                    }else{
                                                        $ot = '-';
                                                    }
                                                   
                                                    
                                                }
                                            }
                                        @endphp
                                        <td>{{$attendence->present == 1 ? $ot : '---' }}</td>
                                    </tr>
                                @endforeach
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
