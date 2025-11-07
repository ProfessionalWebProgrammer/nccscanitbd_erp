@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                   <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Purchase List</h5>
                </div>
                <div class="py-4 table-responsive">
                    <table id="datatablecustom" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>No</th>
                                <th>Date</th>
                                <th>Inv No</th>
                                <th>Supplier Name</th>
                                <th>Depo</th>

                                <th>Product</th>
                                <th>Rate</th>
                                <th>Purchase Value</th>
                                <th>Fare</th>
                                <th>Total Amount</th>
                                <th>User</th>
                                <th>Action</th>
                                
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($purchases as $key => $purchase)
                                @php
                                    $username = DB::table('users')
                                        ->where('id', $purchase->user_id)
                                        ->value('name');
                                @endphp
                                <tr @if (!$purchase->product_name) class="color: red" @endif>
                                    <td class="tdNo">{{ ++$key }} </td>
                                    <td class="tdDate">{{ date('d-m-y', strtotime($purchase->date)) }}</td>
                                    <td>{{ $purchase->invoice }}</td>

                                    <td class="tdSupplierName">{{ $purchase->supplier_name }}</td>
                                    <td>{{ $purchase->factory_name }}</td>

                                    <td class="tdVehicle">{{ $purchase->product_name }} </td>
                                    <td class="tdVehicle">{{ $purchase->purchase_rate }} </td>
                                    <td>{{ number_format($purchase->purchase_value) }} Tk (Dr)</td>
                                    <td>{{ number_format($purchase->transport_fare) }} Tk (Dr)</td>
                                    <td>{{ number_format($purchase->total_payable_amount) }}
                                        Tk</td>
                                        <td> {{ $username }} ({{ $purchase->created_at }})</td>

                                    <td>
                                        {{-- <a href="{{route('purchase.bag.edit',$purchase->purchase_id)}}" target="_blank" class="btn btn-xs btn-info purchaseedit"><span
                                                class="fa fa-edit"></span></a> --}}

                                                <a data-toggle="modal" data-target="#delete"
                                                data-myid="{{ $purchase->purchase_id }}"
                                                    class="btn btn-xs btn-danger purchasedelete"><span class="fa fa-trash"></span></a>
                                                <a href="{{route('purchase.bag.details',$purchase->purchase_id)}}" class="btn btn-primary btn-xs" href="#">Details</a>
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
