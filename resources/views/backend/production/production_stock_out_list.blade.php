@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="row">
                      <div class="col-md-12 text-right pt-3">
                          <a href="{{route('production.process.loss.list')}}" class="btn btn-sm btn-danger">Production Process Loss</a>
                          <a href="{{route('wpf.list')}}" class="btn btn-sm btn-primary">Weekly Production Forcasting</a>
                          <a href="{{route('production.fg.set.list')}}" class="btn btn-sm btn-success">Finised Good Set</a>
                          <a href="{{route('auto.production.stock.out.create')}}" class="btn btn-sm btn-warning">Autometic Production </a>
                          <a href="{{route('manual.production.stock.out.list')}}" class="btn btn-sm btn-success">Manual Production</a>
                           <a href="{{route('reprocess.production.stock.out.list')}}" class="btn btn-sm btn-info">Reprocess FG</a>
                          <a href="{{route('production.packing.consumption.list')}}" class="btn btn-sm btn-primary">Packing Consumption</a>
                      </div>
                  </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Production Stock Out List</h5>


                </div>
                <div class="py-2 table-responsive">
                    <table id="example3" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top">
                              <th>No</th>
                              <th>Date</th>
                              <th>Invoice Number</th>
                              <th>Wirehouse Name</th>
                              <th>Qty</th>
                              <th>Finished Goods</th>
                              <th>F.G. In Qty</th>
                              <th>F.G. Out Qty</th>

                            <!--    <th>Rate</th>
                              <th>Total Amount</th> -->
                              <th width="250px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stock_out as $key=>$data)
                              <tr>
                                <td>{{++$key}}</td>
                                <td>{{$data->date}}</td>
                                <td>{{$data->sout_number}}</td>
                                <td>{{$data->wirehouse_name}}</td>
                                <td>{{$data->qty + $data->temp_qty ?? 0 }}</td>

                                <td>{{$data->product_name}}</td>
                                <td>{{$data->fg_qty}}</td>
								<td>{{$data->fg_out_qty}}</td>

                                <td>
                                 <a href="{{route('production.stock.out.invoice.view',$data->sout_number)}}" class="btn btn-xs btn-primary">Invoice View</span></a>
                                 <a href="{{route('production.stock.out.checkout',$data->sout_number)}}" class="btn btn-xs btn-info purchaseedit">Checkout Invoice</span></a>
                                 <a href="{{route('production.stock.out.edit',$data->sout_number)}}" class="btn btn-xs btn-primary purchaseedit">Edit</span></a>
                                  {{-- <a href="#" class="btn btn-xs btn-danger purchasedelete" data-myid="{{ $data->sout_number }}"
                                    data-mytitle="" data-toggle="modal" data-target="#delete"
                                    style="margin-bottom:2px"><i class="ti-trash"></i>Delete</a> --}}
                   				 <a href="{{route('production.stock.out.deleteNew',$data->sout_number)}}" target="_blank" class="btn btn-xs btn-danger purchasedelete"><i class="ti-trash"></i>Delete</a>
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
            <form action="{{ route('production.stock.out.delete') }}" method="POST">
                {{ method_field('delete') }}
                @csrf

                <div class="modal-body">
                    <p>Are you sure to delete this?</p>

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
       // console.log('hello test');
        var button = $(event.relatedTarget);
        var id = button.data('myid');

        var modal = $(this);

        modal.find('.modal-body #minvoice').val(id);
    })
</script>

@endpush
