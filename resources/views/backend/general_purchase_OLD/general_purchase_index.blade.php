@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                    <h5>General Purchase List</h5>
                </div>
                <div class="py-4">
                    <table id="example1" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Reference</th>
                                <th>Wirehouse</th>
                                <th>Supplier</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">

                            @foreach ($data as $pdata)
                                @php
                                    $invouicedata = DB::table('general_purchases')
                                        ->select('general_purchases.*', 'general_suppliers.supplier_name', 'general_wirehouses.wirehouse_name')
                                        ->leftJoin('general_suppliers', 'general_suppliers.id', 'general_purchases.supplier_id')
                                        ->leftJoin('general_wirehouses', 'general_wirehouses.wirehouse_id', 'general_purchases.warehouse_id')
                                        ->where('invoice_no', $pdata->invoice_no)
                                        ->first();
                                    // dd($invouicedata);
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ date('d-F-Y', strtotime($invouicedata->date)) }}</td>
                                    <td class="text-center">{{ $pdata->invoice_no }}</td>
                                    <td class="text-center">
                                        @if ($invouicedata->reference)
                                            {{ $invouicedata->reference }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="text-left">{{ $invouicedata->wirehouse_name }}</td>
                                    <td class="text-left">{{ $invouicedata->supplier_name }}</td>


                                    <td class="text-center align-middle">
                                        <a class="btn btn-sm purchaseedit"
                                            style="background-color: mediumaquamarine;                                                                                                                                                                                                                                                                    color: white;"
                                            href="{{ URL('/general/purchase/edit/' . $pdata->invoice_no) }}"
                                            data-toggle="tooltip" data-placement="top" title="CheckOut Invoice"><i
                                                class="fas fa-spinner"></i></a>
                                        <a class="btn btn-sm btn-primary " href="{{ URL('/general/purchase/view/' . $pdata->invoice_no) }}" data-toggle="tooltip"
                                            data-placement="top" title="View Invoice"><i class="far fa-eye"></i> </a>
                                        <a class="btn btn-sm btn-danger purchasedelete" href="" data-toggle="modal" data-target="#delete"
                                            data-myid="{{ $pdata->invoice_no }}"><i class="far fa-trash-alt"></i>
                                        </a>
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
                <form action="{{ route('generalpurchase.invoice.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this invoice?</p>

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
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
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

                modal.find('.modal-body #minvoice').val(id);
            })
        </script>

    @endpush
@endsection
