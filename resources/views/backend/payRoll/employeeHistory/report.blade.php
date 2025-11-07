@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class=" row pt-3">
                  <div class="col-md-12 text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">All Employee History List</h5>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Join Date</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Email</th>
                                <th>Phone No</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Religion</th>
                                <th>Address</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($employees as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('d-M-Y',strtotime($item->emp_joining_date))}}</td>
                                    <td>{{ $item->emp_name }}</td>
                                    <td>{{ $item->designation->designation_title ?? ''}}</td>
                                    <td>{{ $item->department->department_title ?? '' }}</td>
                                    <td>{{ $item->emp_mail_id }}</td>
                                    <td>{{ $item->emp_mobile_number }}</td>
                                    <td>{{ $item->emp_age }}</td>
                                    <td>@if($item->emp_gender == 2) Male  @else Female @endif </td>
                                    <td>{{ $item->emp_religion }}</td>
                                    <td>{{ $item->emp_present_address }}</td>
                                    <td align="center">@if($item->status == 1) <span class="badge badge-info p-2" data-toggle="tooltip" data-placement="top" title="Active"><i class="fa fa-check-circle" aria-hidden="true"></i> Active</span> @else <span class="badge badge-danger p-2" data-toggle="tooltip" data-placement="top" title="InActive"><i class="fa fa-times" aria-hidden="true"></i> Inactive</span> @endif </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
