@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
              <div class=" pt-3">
                <div class="col-md-12 text-right">
                  	<a href="{{route('employee.leave.of.absent.form')}}" class="btn btn-sm btn-success">Leave form </a>
                  	<a href="{{route('emp.leave.policy.list')}}" class="btn btn-sm btn-info">Leave Policy </a>
                </div>
                <div class="text-center">
                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                </div>

              </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Leave Of Absent List</h5>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Name</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Leave Type</th>
                                <th>Description</th>
                                <th>Leave of Absent For</th>
                                <th>Exceed Fine Amount</th>
                                <th>Approved Status</th>
                                {{-- <th>Approved By</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lofabsents as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->employee?->emp_name }}</td>
                                 	<td>{{date('d M, Y',strtotime( $item->absent_from ))}}</td>
                                  	<td>{{ date('d M, Y',strtotime($item->absent_to)) }}</td>
                                    <td>{{ $item->employeeLeavePolicySystem?->leave_category_name }}</td>
                                  	<td>{{ $item->description }}</td>
                                  	<td class="text-center">{{$item->leave_of_absent}} Days</td>
                                  	<td class="text-right">{{ $item->exceed_fine_amount }}/{{ $item->per_day }} Day</td>
                                    <td class="text-center">
                                        @if ($item->status == 1)
                                        <span class="badge p-2 badge-success">Approved</span>
                                        @else
                                        <span class="badge p-2 badge-danger">Pending</span>
                                        @endif
                                    </td> 
                                    {{-- <td>
                                        {{  }}
                                    </td> --}}
                                    <td class="text-center">
                                        @if ($item->status != 1)
                                        <a class="btn btn-sm btn-primary " href="" data-toggle="modal" data-target="#delete"
                                        data-myid="{{ $item->id }}"><i class="fa fa-check-square"></i></a>
                                        @endif
                                      
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
                <div class="modal-content bg-success">
                    <div class="modal-header">
                        <h4 class="modal-title">Approve Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('emp.leave.of.absence.approve')}}" method="GET">
                      

                        <div class="modal-body">
                            <p>Are you sure to approve this Employee Leave Application?</p>

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
