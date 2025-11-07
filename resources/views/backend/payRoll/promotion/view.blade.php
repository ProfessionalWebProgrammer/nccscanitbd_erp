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
                        <h5 class="text-uppercase font-weight-bold">Employee Promotion Report List</h5>
                      	 <p>Date: {{date('d M ,Y',strtotime($fdate))}} to {{date('d M ,Y',strtotime($tdate))}}</p>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Date</th>
                                <th>Employee Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Joining Date</th>
                                <th>Basic Salary</th>
                                <th>Issued By</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php
                          $totalBasic = 0;
                          @endphp
                            @foreach ($employees as $emp)
                            @php
                            $basicSalary = $emp->employee->empAccount->basic_salary ?? 0;
                            $totalBasic += $basicSalary;
                            @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{date('d M ,Y',strtotime($emp->date))}}</td>
                                  	<td class="text-center">{{$emp->employee->emp_name ?? ''}}</td>
                                  	<td class="text-center">{{$emp->employee->designation->designation_title ?? ''}}</td>
                                  	<td class="text-center">{{$emp->employee->department->department_title ?? ''}}</td>
                                    <td class="text-center">{{date('d-M-Y',strtotime($emp->employee->emp_joining_date))}}</td>

                                    <td class="text-right">
                                      @if($basicSalary > 1)
                                      {{number_format($basicSalary,2)}}
                                      @else  @endif
                                    </td>
                                    <td>{{$emp->user->name}}</td>
                                </tr>

                            @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="6">Total:</td>
                            <td class="text-right">{{number_format($totalBasic,2)}}</td>
                            <td></td>
                          </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
