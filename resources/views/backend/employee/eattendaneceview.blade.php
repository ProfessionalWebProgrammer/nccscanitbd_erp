@extends('layouts.hrPayroll_dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">
                  <div class="col-md-12 text-right">
                      	<a href="{{ route('employee.attendance.form') }}" class="btn btn-sm btn-success">Employee Attendance</a>
                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Attendance Time List</h5>
                      	<p>Date: {{date('d M ,Y',strtotime($date))}}</p>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Name</th>
                                <th>Attendance</th>
                                <th>Entry Time</th>
                                {{-- <th>Break Time</th>
                                <th>Break Back Time</th> --}}
                                <th>Exit Time</th>
                              	<th>In Location</th>
                              <th>Out Location</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($lists as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->employee->emp_name ?? '' }}</td>
                                  	<td class="text-center">
                                      @if($item->present == 1)
                                      	Present
                                      	  @elseif($item->late == 1)
                                      	Late Present
                                      @elseif($item->absent == 1)
                                      	Absent
                                      @elseif($item->leave_of_absent == 1)
                                      	Leave of Absent
                                      @elseif($item->holyday == 1)
                                      	Holyday
                                      @endif
                                  	</td>

                                {{-- print_r($item->break_time) --}}
                                  <td class="text-center"> @if($item->entry_time ==null) N/A @else {{ date('g:i a',strtotime($item->entry_time))}} @endif </td>
                                 {{--  <td class="text-center"> @if($item->break_time ==null) N/A @else {{ date('h:i A',strtotime($item->break_time)) }} @endif </td>
                                  <td class="text-center"> @if($item->break_back_time ==null) N/A @else {{ date('h:i A',strtotime($item->break_back_time)) }} @endif </td> --}}
                                  <td class="text-center"> @if($item->exit_time ==null) N/A @else {{ date('g:i a',strtotime($item->exit_time))}} @endif </td>
                                  <td>{{ $item->location }}</td>
                                  <td>{{ $item->exit_location }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
