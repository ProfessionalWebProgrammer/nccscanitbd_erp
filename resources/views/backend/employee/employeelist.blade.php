@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class=" row pt-3">
                  <div class="col-md-12 text-right">
                      	<a href="{{route('employee.create')}}" class="btn btn-sm btn-success">Employee Create</a>
                      	<a href="{{route('employee.departments.create')}}" class="btn btn-sm btn-success">Employee Department</a>
                      	<a href="{{route('employee.designation.create')}}" class="btn btn-sm btn-success">Employee Designation</a>
                      	<a href="{{route('employee.stafcategory.create')}}" class="btn btn-sm btn-success">Employee Staff Category</a>
                      	<a href="{{route('employee.team.list')}}" class="btn btn-sm btn-success">Employee Team</a>
                      	<a href="{{route('employee.team.report.list')}}" class="btn btn-sm btn-success">E. Daily Report Entry</a>
                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee List</h5>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Name</th>
                                <th>Phone No</th>
                                <th>Join Date</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Email</th>
                                <th>Religion</th>
                                <th>Age</th>
                                {{--<th>Area</th>
                                <th>Zone</th> --}}
                                <th>Salary</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th width="13%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 0;
                            @endphp
                            @foreach ($employeeData as $item)
                                @php
                                    $sl++;
                                @endphp
                                <tr>
                                    <td>{{ $sl }}</td>
                                    <td>{{ $item->emp_name }}</td>
                                    <td>{{ $item->emp_mobile_number }}</td>
                                    <td>{{ $item->emp_joining_date }}</td>
                                    <td>{{ $item->department->department_title ?? '' }}</td>
                                    <td>{{ $item->designation->designation_title ?? ''}}</td>
                                    <td>{{ $item->emp_mail_id }}</td>
                                    <td>{{ $item->emp_religion }}</td>
                                    <td>{{ $item->emp_age }}</td>
                                    {{--<td>{{ $item->area->area_title ?? '' }}</td>
                                    <td>{{ $item->zone->zone_title ?? ''}}</td> --}}
                                    <td class="text-right">{{ number_format($item->emp_salary) }}</td>
                                    <td>{{ $item->emp_present_address }}</td>
                                    <td align="center">@if($item->status == 1) <span class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Active"><i class="fa fa-check-circle" aria-hidden="true"></i></span> @else <span class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="PR Approved Reject"> <i class="fa fa-times" aria-hidden="true"></i> </span> @endif </td>
                                    <td class="text-center">
                                       <a href="{{ URL::to('/employee/accounts/index/' . $item->id) }}"
                                            class="btn btn-xs btn-dark mb-1" data-toggle="tooltip" data-placement="top" title="Account View"><i class="fas fa-eye"></i></a>


                                       <a href="{{ URL::to('/employee/accounts/edit/' . $item->id) }}"
                                            class="btn btn-xs btn-warning " data-toggle="tooltip" data-placement="top" title="Account Edit"><i class="fas fa-user-cog"></i></a>

                                        <a href="{{ URL::to('edit/employee/' . $item->id) }}"
                                            class="btn btn-xs btn-info my-1" data-toggle="tooltip" data-placement="top" title="Employee Edit"><i class="far fa-edit "></i></a>

                                        <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{ $item->id }}"><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
       <!-- modal -->
    <div class="modal fade" id="delete">
            <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('employee.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Employee?</p>

                            <input type="hidden" id="mid" name="id">
                            <input type="hidden" id="minvoice" name="invoice">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-light">Confirm</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    <!-- /.modal -->
    @push('end_js')

        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })


            $('#delete').on('show.bs.modal', function(event) {
                console.log('hello test');
                var button = $(event.relatedTarget)
                var title = button.data('mytitle')
                var id = button.data('myid')

                var modal = $(this)

                modal.find('.modal-body #mid').val(id);
            })
        </script>

    @endpush
@endsection
