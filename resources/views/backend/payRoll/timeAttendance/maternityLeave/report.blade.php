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
                      <h5 class="text-uppercase font-weight-bold">Employee Maternity Leave Report</h5>
                      <p class="pb-3">Date: {{date('d-m-Y',strtotime($fdate))}} to {{date('d-m-Y',strtotime($tdate))}}</p>
                      <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 13px;">
                        <thead>
                          <tr class="text-center">
                              <th>SL.</th>
                              <th>Issue Date</th>
                              <th>Name</th>
                              <th>Designation</th>
                              <th>Department</th>
                              <th>Execute Date</th>
                              <th>End Date</th>
                              <th>Duration</th>
                              <th>Remarks</th>
                              <th>Issue By</th>
                              <th>Status</th>

                          </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $val)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{date('d-m-Y',strtotime($val->date))}}</td>
                                    <td>{{$val->employee->emp_name}}</td>
                                    <td class="text-center">{{$val->employee->designation->designation_title ?? ''}}</td>
                                  	<td class="text-center">{{$val->employee->department->department_title ?? ''}}</td>
                                    <td>{{date('d-m-Y',strtotime($val->executeDate))}}</td>
                                    <td>{{date('d-m-Y',strtotime($val->endDate))}}</td>
                                    <td>{{$val->duration }} Months</td>
                                    <td>{{$val->note}}</td>
                                    <td>{{$val->user->name}}</td>
                                    <td align="center">@if($val->status == 1) <span class="badge badge-info p-2" data-toggle="tooltip" data-placement="top" title="Approved"><i class="fa fa-check-circle" aria-hidden="true"></i> Approved</span> @else <span class="badge badge-danger p-2" data-toggle="tooltip" data-placement="top" title="Cencel"><i class="fa fa-times" aria-hidden="true"></i> Cencel</span> @endif </td>
                                </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('end_js')


@endpush
