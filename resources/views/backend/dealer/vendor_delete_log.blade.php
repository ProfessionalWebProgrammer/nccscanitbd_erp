@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">
        <!-- Main content -->
        <div class="content px-4 ">
             <div class="container-fluid" style="background: #ffffff; padding: 0px 40px;">
                <div class="text-center pt-3">
                   <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Vendor Delete List</h5>
                        <hr>
                    </div>
                    <div class="my-3">


                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th>SI. No</th>
                                <th>Name</th>
                                <th>Zone</th>
                                <th>Area</th>
                                <th>Proprietor Name</th>
                                <th>Mobile</th>
                                <th>Adddress</th>
                                <th>Deleted By</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($dealer as $dlr)
                        @php
                        $deletename = DB::table('users',$dlr->deleted_by)->value('name');
                        @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$dlr->d_s_name}}</td>
                                <td>{{$dlr->zone_title}}</td>
                                <td>{{$dlr->area_title}}</td>
                                <td>{{$dlr->d_proprietor_name}}</td>
                                <td>{{$dlr->dlr_mobile_no}}</td>
                                <td>{{$dlr->dlr_address}}</td>
                                <td>{{$dlr->updated_at}}
                               <b> ({{$deletename}}) </b>
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
                    <form action="{{route('dealer.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Vendor?</p>

                            <input type="hidden" id="mid" name="id">
                            <input type="hidden" id="minvoice" name="invoice">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-light ">Confirm</button>
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
