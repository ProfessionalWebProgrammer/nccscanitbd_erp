@extends('layouts.employee_dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">
                  <div class="col-md-12 text-right">
                      	<!-- <a href="{{ route('employee.attendance.form') }}" class="btn btn-sm btn-success">Employee Attendance</a> -->
                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="row mt-5">
                  <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-header bg-info text-center h5 ">Warking Day</div>
                        <div class="card-body">
                          <h4 class="text-center">24 <span style="font-size:14px;">Days</span> </h4>
                        </div>
                  </div>
                  </div>

                  <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-center h5 ">Ontime Day</div>
                        <div class="card-body">
                          <h4 class="text-center">20 <span style="font-size:14px;">Days</span></h4>
                        </div>
                  </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-header bg-danger text-center h5 ">Late Count</div>
                        <div class="card-body">
                          <h4 class="text-center">4 <span style="font-size:14px;">Days</span></h4>
                        </div>
                  </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-header bg-success text-center h5 ">Over Time</div>
                        <div class="card-body">
                          <h4 class="text-center">30 <span style="font-size:14px;">Hours</span></h4>
                        </div>
                  </div>
                  </div>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">My Attendance Time List</h5>
                      	<p>Date Range : {{date('d M ,Y',strtotime($fdate))}} to  {{date('d M ,Y',strtotime($tdate))}}</p>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Date</th>
                                <th>Attendance</th>
                                <th>Entry Time</th>
                                <th>Exit Time</th>
                            </tr>
                        </thead>
                        <tbody>

{{--                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->employee->emp_name }}</td>
                                  	<td class="text-center">
                                      @if($item->present == 1)
                                      	Present
                                      @elseif($item->absent == 1)
                                      	Absent
                                      @elseif($item->leave_of_absent == 1)
                                      	Leave of Absent
                                      @elseif($item->holyday == 1)
                                      	Holyday
                                      @endif
                                  	</td>

                                  <td class="text-center"> @if($item->entry_time ==null) N/A @else {{ date('g:i a',strtotime($item->entry_time))}} @endif </td>

                                  <td class="text-center"> @if($item->exit_time ==null) N/A @else {{ date('g:i a',strtotime($item->exit_time))}} @endif </td>

                                </tr>
                          --}}
                          <tr>
                            <td>1</td>
                            <td>02-09-2023</td>
                            <td>Present</td>
                            <td>9.00 am</td>
                            <td>6.00 pm</td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>03-09-2023</td>
                            <td>Present</td>
                            <td>9.00 am</td>
                            <td>6.00 pm</td>
                          </tr>
                          <tr>
                            <td>3</td>
                            <td>04-09-2023</td>
                            <td>Present</td>
                            <td>9.00 am</td>
                            <td>6.00 pm</td>
                          </tr>
                          <tr>
                            <td>4</td>
                            <td>05-09-2023</td>
                            <td>Present</td>
                            <td>9.00 am</td>
                            <td>6.00 pm</td>
                          </tr>
                          <tr>
                            <td>5</td>
                            <td>06-09-2023</td>
                            <td>Present</td>
                            <td>9.00 am</td>
                            <td>6.00 pm</td>
                          </tr>
                          <tr>
                            <td>6</td>
                            <td>07-09-2023</td>
                            <td>Present</td>
                            <td>9.00 am</td>
                            <td>6.00 pm</td>
                          </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
