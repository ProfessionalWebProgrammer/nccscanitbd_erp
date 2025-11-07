@extends('layouts.settings_dashboard')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Trip  List</h5>
                </div>
                <div class="py-4 table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Driver</th>
                                <th>Vechicle Number</th>
                                <th>Trip Note</th>
                                <th>Trip Value</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">

                           @foreach ($trips as $date)

                             <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('d M, Y',strtotime($date->date)) }} </td>
                                    <td>{{ $date->invoice }} </td>
                                    <td>{{ $date->driver_name }}</td>
                                    <td>{{ $date->vehicle_number }}</td>
                                    <td>{{ $date->note }}</td>
                               		<td class="text-right">{{ number_format($date->trip_value) }}</td>


                                    <td class="text-center align-middle">
                                      		<a class="btn btn-sm btn-info mr-1" href="{{URL::to('/view/trip/expanse/'.$date->invoice)}}" ><i class="far fa-eye"></i></a>
                                            <a class="btn btn-sm btn-danger salesdelete mr-1" href="" data-toggle="modal" data-target="#delete"
                                            data-myid="{{ $date->id }}"><i class="far fa-trash-alt"></i>
                                              <a class="btn btn-sm btn-info" href="{{URL::to('/add/trip/expanse/'.$date->invoice)}}" >E + </a>
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
                <form action="{{ route('trip.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this?</p>

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



@endsection


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
