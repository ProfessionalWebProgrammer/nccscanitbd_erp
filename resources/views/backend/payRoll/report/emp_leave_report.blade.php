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
                        <h5 class="text-uppercase font-weight-bold">Employee Leave Report</h5>
                      	 <p>Date: {{ $fdate }} TO {{ $tdate }}</p>
                        <hr>
                    </div>
                    <table class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>Employee Name</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Leave Of Absent</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                         @foreach ($leaveOfAbsents as $leaveOfAbsent)
                          
                            <tr class="text-center">
                                <th>{{ $leaveOfAbsent->employee?->emp_name ?? '-' }}</th>
                                <th>{{ $leaveOfAbsent->employee?->department?->department_title ?? '-' }}</th>
                                <th>{{ $leaveOfAbsent->employee?->designation?->designation_title ?? '-'  }}</th>
                                <th>{{ $leaveOfAbsent->total_leave_of_absent }} {{$leaveOfAbsent->total_leave_of_absent > 1 ? 'days' : 'day'}}</th>
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
