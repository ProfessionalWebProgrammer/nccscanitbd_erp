@extends('layouts.hrPayroll_dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">
                  <div class="col-md-12 text-right">
                    <a href="{{route('hrpayroll.time.attendance.employeePartialLeave.create')}}" class="btn btn-sm btn-success">Employee CL Leave Create </a>
                    <a href="{{route('hrpayroll.time.attendance.employeeFractionalLeave.list')}}" class="btn btn-sm btn-success">Employee SL Leave</a>
                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                      <h5 class="text-uppercase font-weight-bold">Employee CL Leave List</h5>
                      <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                          <tr class="text-center">
                              <th>SL.</th>
                              <th>Date</th>
                              <th>Name</th>
                              <th>CL Leave</th>
                              <th>Description</th>
                              <th>Issue By</th>
                              <!-- <th>Status</th> -->
                              <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($results as $val)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{date('d M ,Y',strtotime($val->date))}}</td>
                                    <td>{{$val->employee->emp_name}}</td>
                                    <td>{{$val->cl_day}}</td>
                                    <td>{{$val->note}}</td>
                                    <td>{{$val->user->name}}</td>
                                    <!-- <td><span class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Approved">Approved</span></td> -->
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
                <form action="{{ route('hrpayroll.time.attendance.employeePartialLeave.delete') }}" method="POST">
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
