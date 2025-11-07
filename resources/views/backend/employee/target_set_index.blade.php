@extends('layouts.hrPayroll_dashboard')

@section('header_menu')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ URL('/employee/terget/set/create') }}" class=" btn btn-sm  btn-success mt-1 mr-2">Set Target</a>
    @endsection


    @section('content')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content px-4 ">
                <div class="container-fluid">
                    <div class="text-center pt-3">
                      <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                    <div class="py-4">
                        <div class="text-center">
                            <h5 class="text-uppercase font-weight-bold">Employee Sales Target</h5>
                            <hr>
                        </div>
                        <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                            <thead>
                                <tr class="text-center">
                                    <th>SL.</th>
                                    <th>Name</th>
                                    <th>Area</th>
                                    <th>Target Month</th>

                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($lmtargets as $lmtar)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $lmtar->emp_name }}</td>
                                        <td>{{ $lmtar->area_title }}</td>
                                        <td> {{ date('F, Y', strtotime($lmtar->from_date)) }}</td>


                                        <td>



                                            <form action="{{ Route('employee.target.set.view') }}" method="POST">
                                                @csrf

                                                <a href="{{ route('employee.target.set.add', $lmtar->emp_id) }}"
                                                    class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                    data-placement="top" title="Add more"><i class="fas fa-plus-circle"></i> </a>

                                                <input type="hidden" name="mr_id" value="{{ $lmtar->emp_id }}">
                                                <input type="hidden" name="target_month" value="{{ $lmtar->from_date }}">
                                                <button class="btn btn-success submit-btn btn-sm"  type="submit" data-toggle="tooltip"
                                                data-placement="top" title="View Targets"><i class="far fa-eye"></i> </a></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
    @endsection
