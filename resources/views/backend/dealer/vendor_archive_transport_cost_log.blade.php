@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">
        <!-- Main content -->
        <div class="content px-4 ">
             <div class="container-fluid" style="background: #ffffff; padding: 0px 40px;">
               <div class="row pt-3">
                	
                 
                </div>
               
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It </h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Vendor Transport Cost Archive List</h5>
                        <hr>
                    </div>
                    <div class="my-3">
                     
                      
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th>SI. No</th>
                                <th>Name</th>
                                <th>Warehouse</th>
                                <th>Transport Cost</th>
                                <th>Com. Per Ton</th>
                                <th>Com. Per Bag</th>
                                <th>Edited Time</th>
                            </tr>
                        </thead>
                        <tbody>
                      
                        @foreach($data as $dlr)
                        @php
                        @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$dlr->d_s_name}}</td>
                                <td>{{$dlr->factory_name}}</td>
                                <td>{{$dlr->transport_cost}}</td>
                                <td>{{$dlr->commission_per_ton}}</td>
                                <td>{{$dlr->commission_per_bag}}</td>
                                  <td>{{$dlr->updated_at}}
                              
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
