@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class=" pt-3">
                  <div class="col-md-12 text-right">
                      	<a href="{{ route('employee.overtime.create') }}" class="btn btn-sm btn-success">Employee Extra Overtime Create</a>
                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>
                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Extra Overtime List</h5>

                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Entry Time</th>
                                <th>Exit Time</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($overTimeEmployees as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{date('d M ,Y',strtotime($item->date))}}</td>
                                    <td>{{ $item->employee->emp_name }}</td>
                                    <td class="text-center"> @if($item->ovt_start ==null) N/A @else {{ date('g:i a',strtotime($item->ovt_start))}} @endif </td>
                                    <td class="text-center"> @if($item->ovt_end ==null) N/A @else {{ date('g:i a',strtotime($item->ovt_end))}} @endif </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
