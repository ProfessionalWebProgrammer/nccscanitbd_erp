@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                    <h5>Notification Archive List</h5>
                </div>
                <div class="py-4">
                    <table id="example1" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>Data</th>
                                <th>Vendor</th>
                                <th>Subject</th>
                                <th>Seen by</th>

                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">
						@php
                          $si = 0
                          @endphp
                            @foreach ($datas as $data)

                                <tr>
                                    <td>{{ $si++ }}</td>
                                    <td>{{ $data->date }} </td>
                                    <td>{{ $data->d_s_name }} </td>
                                    <td>{{ $data->subject }} </td>
                                    <td>{{ $data->name }} <br> ({{$data->updated_at}}) </td>
                                  </tr>
                            @endforeach
                           @foreach ($invoicenotification as $data)

                                <tr>
                                    <td>{{ $si++ }}</td>
                                    <td>{{ $data->payment_date }} </td>
                                    <td>{{ $data->d_s_name }} </td>
                                    <td>{{ $data->invoice_no }} </td>
                                    <td> ({{$data->updated_at}}) </td>
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
                <form action="{{ route('user.setting.delete') }}" method="POST">
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
            //console.log(id);
            var modal = $(this)

            modal.find('.modal-body #mid').val(id);
        })
    </script>

@endpush
