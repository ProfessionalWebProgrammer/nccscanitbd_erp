@extends('layouts.purchase_deshboard')


@push('addcss')
<style>
    .tableFixHead          { overflow: auto; height: 600px; }
    .tableFixHead thead th { position: sticky; top: 0; z-index: 1; }
</style>

@endpush

@section('header_menu')

@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">

        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh;min-width: 100% !important;">
              <div class="row pt-3">
				<div class="col-md-12 text-right">
                      	<a href="{{route('purchaseOrderCreate')}}" class=" btn btn-success mr-2">Create Purchase Order</a>
                  		<a href="{{route('purchaseTerm.create',1)}}" class=" btn btn-success mr-2">Terms & Condition</a>
                    </div>
                </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Purchase Order List</h5>
                </div>
                <div class="py-4 table-responsive tableFixHead">
                    <table id="example3" class="table table-bordered table-striped table-fixed"
                        style="font-size: 10px;table-layout: inherit;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>No</th>
                                <th>Order Date</th>
                                <th>Invoice No</th>
                                <th>Supplier Name</th>
                              	<th>Delivery Date</th>
                                <th>Reference</th>
                                <th>Item</th>
                                <th>Specification</th>
                                <th>Category</th>
                                <th>UOM (Kg)</th>
                                <th>Rate</th>
                                <th>Qty</th>
                                <th>Amount</th>
                              	<th>Description</th>
                                <th style="width:100px; text-align:center;">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($orderList as $key => $val)
                                @php
                                    $supplierName = DB::table('suppliers')
                                        ->where('id', $val->supplier_id)
                                        ->value('supplier_name');

                          			$product = DB::table('row_materials_products')
                                        ->where('id', $val->product_id)
                                        ->value('product_name');

                          			$cat = DB::table('sales_categories')
                                        ->where('id', $val->category_id)
                                        ->value('category_name');

                                @endphp
                                <tr @if (!$val->product_id) class="color: red" @endif>
                                    <td class="tdNo">{{ ++$key }} </td>
                                    <td class="tdDate">{{ date('M d, y', strtotime($val->date)) }}</td>
                                  <td>{{ $val->order_no }}</td>
                                    <td>{{ $supplierName }}</td>
									<td class="tdDate">{{ date('M d, y', strtotime($val->deliveryDate)) }}</td>
                                    <td class="tdSupplierName">{{ $val->reference_no }}</td>
                                    <td class="tdSupplierName">{{ $product }}</td>
                                    <td class="tdSupplierName">{{ $val->specification }}</td>
                                    <td class="tdProductName">{{ $cat }}</td>
                                    <td class="tdProductName">{{ $val->unit }}</td>
                                    <td class="tdProductName">{{ $val->rate }}</td>
                                    <td class="tdProductName">{{ $val->quantity }}</td>
                                	   <td class="tdProductName">{{ $val->amount }}</td>
                                    <td class="tdProductName">{{$val->description != 'null' ? $val->description  : ''}}</td>
                                    <td align="center">
                                       <a href="{{route('purchaseOrder.edit',$val->id)}}" target="_blank" class="btn btn-xs btn-info purchaseedit"><span
                                                class="fa fa-edit"></span></a>
                                      <a href="{{route('purchaseOrder.view',$val->id)}}" class="btn btn-primary btn-xs"><span
                                                class="fa fa-eye"></span></a>
                                        <a data-toggle="modal" data-target="#delete"
                                        data-myid="{{ $val->id }}"
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
                <form action="{{ route('purchaseOrderDelete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this?</p>

                        <input type="hidden" id="mid" name="id" value="">
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
            var button = $(event.relatedTarget)
            var title = button.data('mytitle')
            var id = button.data('myid')

            var modal = $(this)

            modal.find('.modal-body #mid').val(id);
        })
    </script>

@endpush
