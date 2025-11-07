@extends('layouts.purchase_deshboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="row pt-3">
                  	<div class="col-md-12 text-right">
    				<a href="{{ route('purchase.transfer.create') }}" class=" btn btn-success btn-sm mr-2">Create Transfer</a>
                    </div>
                </div>

                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Purchase Transfer List</h5>
                        <hr>
                    </div>
                    <div class="my-3">

                    </div>
                    <table id="example3" class="table table-bordered text-light table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="table-header-fixt-top">
                              <th>SI</th>
                              <th>Date</th>
                              <th>Invoice</th>
                              <th>Product</th>
                              <th>Out Wirehouse</th>
                              <th>Transfer Quantity</th>
                              <th>In Wirehouse</th>
                              <th>Receive Quantity</th>
                              <th>Vehical</th>
                              <th>Fare</th>
                              <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>
                               @foreach($transfers as $key=>$transfer)

                              <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$transfer->date}}</td>
                                <td>{{$transfer->invoice}}</td>
                                <td>{{$transfer->product->product_name ?? 0}}</td>

                                <td>{{$transfer->fromWarehose->factory_name ?? 0}}</td>
                                <td>{{$transfer->qty}}</td>
                                <td>{{$transfer->toWarehose->factory_name ?? 0}}</td>
                                <td>{{$transfer->receive_qty }} </td>
                                <td>{{$transfer->vehicle }} </td>
                                <td>{{number_format($transfer->transfer_fare,2) }} </td>
                                <td>
                                    {{--<a href="{{route('purchase.transfer.edit',$transfer->id)}}" class="btn btn-xs btn-info purchaseedit"><span
                                        class="fa fa-edit"></span></a> --}}
                                        
                                        <a class="btn btn-xs btn-primary text-light "
                                          href="{{ URL::to('/purchase/transfer/chalan/view/' . $transfer->invoice) }}"
                                          data-toggle="tooltip" data-placement="top" title="Chalan View"><i
                                              class="far fa-eye"></i> </a>

                                        <a data-toggle="modal" data-target="#delete"
                                        data-myid="{{ $transfer->id }}"
                                            class="btn btn-xs btn-danger purchasedelete"><span class="fa fa-trash"></span></a>

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
            <form action="{{ route('purchase.transfer.delete') }}" method="POST">
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
