@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	<a href="{{ URL('/production/stock/in/create') }}" class=" btn btn-sm btn-success mr-2">Manual Stock In Entry</a>

                    </div>
                </div>

                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Stock In List</h5>


                </div>
                <div class="py-4 table-responsive">
                    <table id="datatablecustom" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top">
                              <th>No</th>
                              <th>Date</th>
                              <th>Wirehouse Name</th>
                              <th>Product Name</th>
                              <th>Bach No.</th>


                            <th>Qty</th>

                            <th>Rate</th>
                            <!--      <th>Total Amount</th> -->
                              <th class="text-center" >Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stock_ins as $key=>$data)
                              <tr>
                                <td>{{++$key}}</td>
                                <td>{{$data->date}}</td>
                                <td>{{$data->factory_name}}</td>
                                <td>{{$data->product_name}}</td>
                                <td>{{$data->batch_id}}</td>
                                <td>{{$data->quantity}}</td>
                                <td>{{$data->production_rate}}</td>


                                <td class="text-center">
                                  <a class="btn btn-xs btn-danger salesdelete" href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{ $data->id }}"><i class="far fa-trash-alt"></i></a>
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
