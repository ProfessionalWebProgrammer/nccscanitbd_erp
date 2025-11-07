@extends('layouts.purchase_deshboard')


@push('addcss')
<style>
    .tableFixHead          { overflow: auto; height: 600px; }
    .tableFixHead thead th { position: sticky; top: 0; z-index: 1; }
</style>

@endpush




@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  	<p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Purchase Deleted List</h5>
                </div>
                <div class="py-4 table-responsive tableFixHead">
                    <table id="datatablecustom" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                <thead>
                	<tr>
                    <th id="thNo">No</th>
                    <th id="thDate">Date</th>
                    <th>Invoice No</th>
                    <th>Deleted By</th>
                    <th id="thSupplierName">Supplier Name</th>
                    <th id="thProductName">Product Name</th>
                    <th>Wirehouse Name</th>

                    <th>Bill Qty</th>
                    <th>Rate</th>
                    <th>Purchase Value</th>

                    <th>Total Amount</th>
                  </tr>

                </thead>
                <tbody>
                  @foreach($purchasedelete as $key=>$purchase)
                  @php
                  	$username = DB::table('users')->where('id',$purchase->user_id)->value('name');
                  	$deletename = DB::table('users')->where('id',$purchase->deleted_by)->value('name');
                  @endphp
                  <tr @if(!$purchase->product_name) class="color: red" @endif>
                    <td class="tdNo">{{++$key}} </td>
                    <td class="tdDate">{{$purchase->date}}</td>
                    <td>INV-{{$purchase->purchase_id}}</td>
                    <td>{{$deletename}}</td>
                    <td class="tdSupplierName">{{$purchase->supplier_name}}</td>
                    <td class="tdProductName">{{$purchase->product_name ? $purchase->product_name: "(BAG)" }}</td>
                    <td>{{$purchase->factory_name}}</td>

                      <td>{{number_format($purchase->bill_quantity,2)}} KG</td>


                    <td>{{number_format($purchase->purchase_rate)}} Tk</td>
                    <td>{{number_format($purchase->bill_quantity*$purchase->purchase_rate)}} Tk</td>

                    <td>{{number_format($purchase->total_payable_amount)}} TK</td>

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
                <form action="{{ route('purchase.delete') }}" method="POST">
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
