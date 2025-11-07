@extends('layouts.hrPayroll_dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">
                  <div class="col-md-12 text-right">
                    <a href="{{route('hrpayroll.time.attendance.maternityLeavePolicy.create')}}" class="btn btn-sm btn-success">Employee Maternity Leave Policy Create </a>
                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                      <h5 class="text-uppercase font-weight-bold">Employee Maternity Leave List</h5>
                      <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
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
                              <th>Status</th>
                              <th>Action</th>
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
                                    <td align="center">@if($val->status == 1) <span class="badge badge-info p-2" data-toggle="tooltip" data-placement="top" title="Approved"><i class="fa fa-check-circle" aria-hidden="true"></i> Approved</span> @else <span class="badge badge-danger p-2" data-toggle="tooltip" data-placement="top" title="Cencel"><i class="fa fa-times" aria-hidden="true"></i> Cencel</span> @endif </td>
                                    <td class="text-center">
                                        <!-- <a href="#" class="btn btn-xs btn-info my-1" data-toggle="tooltip" data-placement="top" title="Employee Edit"><i class="far fa-edit "></i></a> -->

                                        <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{$val->id}}"><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- /.modal -->
    <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('hrpayroll.time.attendance.maternityLeavePolicy.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure to delete this?</p>

                        <input type="hidden" id="mid" name="id">
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

@endsection

@push('end_js')

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        })


        $('#delete').on('show.bs.modal', function(event) {
            //console.log('hello test');
            var button = $(event.relatedTarget);
            var id = button.data('myid');
            //console.log(id);
            var modal = $(this);
            modal.find('.modal-body #mid').val(id);
        })
    </script>

@endpush
