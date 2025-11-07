@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="row pt-3">

                </div>

                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Fiscal Year Report</h5>


                </div>
                <div class="py-4 table-responsive">
                    <table id="" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top">
                              <th>Zone Name</th>
                               <th>August 2022 Sales</th>
                               <th>July 2022 Sales</th>
                               <th>August 2021 Sales</th>

                            </tr>
                            </thead>
                            <tbody>
                                @php
                               $tsale = 0;
                               $trmsale= 0;
                               $tpysale = 0;

                              @endphp
                         @foreach($zones as $key=>$data)
                              @php

                                $sale = rand(0,5000);
                               $rmsale= rand(0,5000);
                               $pysale = rand(0,5000);

                                $tsale += $sale;
                               $trmsale += $rmsale;
                               $tpysale += $pysale;


                              @endphp
                              <tr>
                                 <td>{{$data->zone_title}}</td>

                                 <td>{{$sale}}</td>
                                 <td>{{$rmsale}}</td>
                                <td>{{$pysale}}</td>
                          	</tr>
                            @endforeach
                              <tr style="font-weight:bold">
                                 <td>Total</td>

                                 <td>{{$tsale}}</td>
                                 <td>{{$trmsale}}</td>
                                 <td>{{$tpysale}}</td>

                          	</tr>



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
                    <form action="{{route('production.stock.in.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Item?</p>

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
                //console.log('hello test');
                var button = $(event.relatedTarget)
                var title = button.data('mytitle')
                var id = button.data('myid')

                var modal = $(this)

                modal.find('.modal-body #mid').val(id);
            })
        </script>

    @endpush
@endsection
