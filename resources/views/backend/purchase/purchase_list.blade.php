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
                <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ URL('/purchase/delete/log') }}" class=" btn btn-success mr-2">Delete Log</a>
	</li>


                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  	<p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Purchase List</h5>
                </div>
             <table id="example3" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                 <th>No</th>
                                <th>Date</th>
                                <th>Inv No</th>
                                <th>Supplier Name</th>
                                <th>Item</th>
                                <th>Depo</th>
                                <th>Chln Qty</th>
                                <th>Rcv Qty</th>
                                <th>Dt Qty</th>
                                <th>Ivntry Rcv</th>
                                <th>Bill Qty</th>
                                <th>Rate</th>
                                <th>Purchase Value</th>
                                <th>Vehicle</th>
                                <th>Fare</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
							@php 
                            $total = 0;
                            @endphp
                           @foreach ($purchases as $key => $purchase)
                                @php
                                    $username = DB::table('users')->where('id', $purchase->user_id)->value('name');
                          			$temp = $purchase->bill_quantity * $purchase->purchase_rate - $purchase->transport_fare;
                          			$total += $temp;
                                @endphp
                                <tr>
                                   <td >{{ ++$key }} </td>
                                    <td >{{ date('d-m-y', strtotime($purchase->date)) }}</td>
                                    <td>{{ $purchase->invoice }}</td>

                                    <td >{{ $purchase->supplier_name }}</td>
                                    <td >{{ $purchase->product_name }}</td>
                                    <td>{{ $purchase->factory_name }}</td>
                                   
                                    <td>{{ $purchase->supplier_chalan_qty }} KG</td>
                                 
                                   <td>{{ $purchase->receive_quantity }} KG </td>

                                    

                                    <td>{{ $purchase->deduction_quantity }} KG</td>
                                    <td>{{ number_format($purchase->inventory_receive) }} KG</td>
                                     <td>{{ number_format($purchase->bill_quantity, 2) }} KG</td>

                                    <td>{{ $purchase->purchase_rate }} </td>
                                    <td>{{ number_format($purchase->purchase_value) }} Tk</td>
                                    <td >{{ $purchase->transport_vehicle }} </td>
                                    <td>{{ number_format($purchase->transport_fare, 2) }} Tk (Dr)</td>
                                    <td>{{ number_format($temp, 2) }}
                                        Tk</td>
                                  <td></td>
                                    <td> {{ $username }} ({{ $purchase->created_at }})</td>
                                </tr>
                          
                              <tr>
                                <td colspan="15"> Total :</td>
                                <td>{{ number_format($total, 2) }} Tk</td>
                                <td></td><td></td>
                              </tr>
                                @endforeach
                          
                        </tbody>
                    </table>  
                <div class="py-4 ">
                    <table id="example" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>No</th>
                                <th>Date</th>
                                <th>Inv No</th>
                                <th>Supplier Name</th>
                                <th>Item</th>
                                <th>Depo</th>
                                <th>Chln Qty</th>
                                <th>Rcv Qty</th>
                                {{-- <th>Chot</th>
                                <th>Plastic</th>
                                <th>Sack</th> --}}
                                <th>Dt Qty</th>
                                <th>Ivntry Rcv</th>
                                <th>Bill Qty</th>
                                <th>Rate</th>
                                <th>Purchase Value</th>
                                <th>Vehicle</th>
                                <th>Fare</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                                <th>User</th>
                            </tr>
                        </thead>

                        <tbody>
                          @php 
                          $total = 0;
                          @endphp 
                            @foreach ($purchases as $key => $purchase)
                                @php
                                    $username = DB::table('users')->where('id', $purchase->user_id)->value('name');
                          			$temp = $purchase->bill_quantity * $purchase->purchase_rate - $purchase->transport_fare;
                          			$total += $temp;
                                @endphp
                                <tr @if (!$purchase->product_name) class="color: red" @endif>
                                    <td class="tdNo">{{ ++$key }} </td>
                                    <td class="tdDate">{{ date('d-m-y', strtotime($purchase->date)) }}</td>
                                    <td>INV-{{ $purchase->purchase_id }}</td>

                                    <td class="tdSupplierName">{{ $purchase->supplier_name }}</td>
                                    <td class="tdProductName">{{ $purchase->product_name }}</td>
                                    <td>{{ $purchase->factory_name }}</td>
                                    <!--    <td>{{ $purchase->order_quantity }} KG</td> -->
                                    <td>{{ $purchase->supplier_chalan_qty }} KG</td>
                                  {{--  @if ($purchase->receive_quantity > $purchase->supplier_chalan_qty)
                                        <td>{{ $purchase->supplier_chalan_qty }} KG</td>
                                    @else
                                        <td>{{ $purchase->receive_quantity }} KG </td>
                                    @endif  --}}
                                   <td>{{ $purchase->receive_quantity }} KG </td>

                                    {{-- <td>{{ $purchase->chot_qty }} </td>
                                    <td>{{ $purchase->plastic_qty }} </td>
                                    <!--    <td>{{ $purchase->remain_quantity }} KG</td> -->
                                    <td>{{ $purchase->sack_purchase }} Bag Pieces</td> --}}

                                    <td>{{ $purchase->deduction_quantity }} KG</td>
                                    <td>{{ number_format($purchase->inventory_receive) }} KG</td>
                                     <td>{{ number_format($purchase->bill_quantity, 2) }} KG</td>

                                    <td>{{ $purchase->purchase_rate }} </td>
                                    <td>{{ number_format($purchase->purchase_value) }} Tk</td>
                                    <td class="tdVehicle">{{ $purchase->transport_vehicle }} </td>
                                    <td>{{ number_format($purchase->transport_fare, 2) }} Tk (Dr)</td>
                                    <td>{{ number_format($temp, 2) }}
                                        Tk</td>

                                    <td>
                                        <a href="{{route('purchase.edit',$purchase->purchase_id)}}" target="_blank" class="btn btn-xs btn-info purchaseedit"><span
                                                class="fa fa-edit"></span></a>

                                        <a data-toggle="modal" data-target="#delete"
                                        data-myid="{{ $purchase->purchase_id }}"
                                            class="btn btn-xs btn-danger purchasedelete"><span class="fa fa-trash"></span></a>
                                        <a href="{{route('purchase.view',$purchase->purchase_id)}}" class="btn btn-primary btn-xs" href="#">Details</a>
                                    </td>

                                    <td> {{ $username }} ({{ $purchase->created_at }})</td>
                                </tr>
                          <tr>
                          	<td colspan="15"> Total :</td>
                            <td>{{ number_format($total, 2) }} Tk</td>
                            <td></td><td></td>
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
      $(document).ready(function() {
          var table = $('#example3').DataTable( {
              scrollX:        true,      
              paging:         true,
              fixedColumns:   {
                  left: 2
              }
          } );
      } );
      
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
