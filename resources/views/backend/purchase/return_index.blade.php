@extends('layouts.purchase_deshboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="row pt-2">
                  	<div class="col-md-12 text-right">
                      	 <a href="{{ route('purchase.return.create') }}" class=" btn btn-success mr-2">Create Return</a>
                    </div>
                </div>

                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Purchase Return List</h5>
                        <hr>
                    </div>
                    <div class="my-3">

                    </div>
                    <table id="example1" class="table table-bordered text-light table-striped" style="font-size: 15px;">

                                    <thead>
                                        <tr class="table-header-fixt-top">
                                          <th>No</th>
                                          <th>Date</th>
                                          <th>Supplier Name</th>
                                          <th>Product Name</th>
                                          <th>Vehicle No</th>
                                          <th>Transport Fare</th>
                                          <th>Wirehouse Name</th>
                                          <th>Return Qty</th>
                                          <th>Rate</th>
                                          <th>Return Value</th>
                                          <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $trqty = 0;
                                            $tamount =  0;
                                            @endphp
                                           @foreach($returns as $key=>$return)
                                           @php
                                            $trqty += $return->return_quantity;
                                            $tamount += $return->total_amount;
                                            @endphp
                                          <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$return->date}}</td>
                                            <td>{{$return->supplier_name}}</td>
                                            <td>{{$return->product_name}}</td>
                                            <td>{{$return->vehicle_no}}</td>
                                            <td>{{$return->transport_fare}}</td>
                                            <td>{{$return->factory_name}}</td>
                                            <td>{{$return->return_quantity}}</td>
                                            <td>{{$return->return_rate}}</td>
                                            <td>{{number_format($return->total_amount, 2)}} </td>
                                            <td>
                                                {{-- <a href="{{route('purchase.return.edit',$return->id)}}" class="btn btn-xs btn-info purchaseedit"><span
                                                    class="fa fa-edit"></span></a> --}}

                                            <a data-toggle="modal" data-target="#delete"
                                            data-myid="{{ $return->id }}"
                                                class="btn btn-xs btn-danger purchasedelete"><span class="fa fa-trash"></span></a>

                                            </td>
                                      </tr>
                                      @endforeach
                                         </tbody>
                                         <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><b>Total Value</b></td>
                                                <td></td>
                                                <td><b>{{$trqty}}</b></td>
                                                <td></td>
                                                <td><b>{{number_format($tamount, 2)}}</b></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
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
            <form action="{{ route('purchase.return.delete') }}" method="POST">
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
