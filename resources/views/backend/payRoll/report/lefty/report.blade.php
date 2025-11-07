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
                        <h5 class="text-uppercase font-weight-bold">Employee Lefty Report List</h5>
                      	 <p>Date: {{date('F',strtotime($month))}}, {{$year}} </p>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Employee Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Absent Count</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php

                          @endphp
                            @foreach ($employees as $emp)
                            @php
                            $i = 1;
                            $x = 0;
                            $friDay = '';
                            while($i <= $count) {
                              $date = $day.'-'.$i;
                                    $absent = DB::table('employee_attendances')
                                            ->where('employee_id',$emp->employee_id)
                                            ->where('date','=', $date)
                                            ->where('absent','=',1)->first();

                                    $friDay =  date('D',strtotime($date));
                                    $presentDay = (int) date('d',strtotime($date));
                                    $abc = $absent->absent ?? 0;
                                          if($abc == 1 || $friDay == 'Fri'){
                                            $i += 1;
                                            $x += 1;
                                          /*  echo 'I='.$i.'</br>';
                                            echo 'X='.$x.'</br>';
                                            */
                                          } elseif( $presentDay < 22 && $x < 10) {
                                              $i += 1;
                                              $x = 0;
                                            } else {
                                              $i = $count + 1;
                                            }
                                          }


                                /*
                                dump($x);
                                if($presentDay < 21){
                                  $i+= 1;

                                } else {
                                    $i = $count + 1;
                                }

                                if($presentDay < 22){
                                  $i += 1;
                                  $x = 0;
                                } else {
                                  $i = $count + 1;
                                }
                                */

                            @endphp
                              @if($x >= 10)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                  	<td class="text-center">{{$emp->employee->emp_name ?? ''}}</td>
                                  	<td class="text-center">{{$emp->employee->designation->designation_title ?? ''}}</td>
                                  	<td class="text-center">{{$emp->employee->department->department_title ?? ''}}</td>
                                  	<td class="text-center">{{$x}}</td>
                                </tr>
                                @else

                                @endif
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
