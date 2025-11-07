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
                      	<a href="{{route('rfq.create')}}" class=" btn btn-success mr-2">Create RFQ Order</a>

                    </div>
                </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>RFQ List</h5>
                </div>
                <div class="py-4 table-responsive tableFixHead">
                    <table id="example3" class="table table-bordered table-striped table-fixed"
                        style="font-size: 13px;table-layout: inherit;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>No</th>
                                <th>Invoice</th>
                                <th>Order Date</th>
                              	<th>Response Date</th>
                                <th>Company</th>
                                <th>Contact Name</th>
                                <th>Designation</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                              	{{-- <th>Total Value</th> --}}
                              	<th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($data as $key => $val)
                            @php
                            $supplier = \App\Models\Supplier::where('id',$val->supplier_id)->first();
                            @endphp
                                <tr @if (!$val->product_id) class="color: red" @endif>
                                    <td class="tdNo">{{ ++$key }} </td>
                                    <td class="tdNo">{{ $val->invoice }} </td>
                                    <td class="tdDate">{{ date('M d, y', strtotime($val->issue_date)) }}</td>
									                  <td class="tdDate">{{ date('M d, y', strtotime($val->response_date)) }}</td>
                                    <td>{{ $supplier->supplier_name?? ''}}</td>
                                    <td class="tdSupplierName">{{ $supplier->contact_person ?? '' }}</td>
                                    <td class="tdSupplierName">{{ $supplier->desination ?? '' }}</td>
                                    <td class="tdSupplierName">{{ $supplier->phone ?? '' }}</td>
                                    <td class="tdSupplierName">{{ $supplier->email ?? '' }}</td>
                                    <td class="tdSupplierName">{{ $supplier->address ?? ''}}</td>
                                    {{-- <td class="tdProductName">{{ $val->total_amount }}</td> --}}
                                    <td class="tdProductName">{{ $val->description }}</td>

                                    <td>
                                        {{-- <a href="" target="_blank" class="btn btn-xs btn-info purchaseedit"><span
                                                class="fa fa-edit"></span></a> --}}
                                      <a href="{{route('rfq.view',$val->id)}}" class="btn btn-primary btn-xs"><span
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
                <form action="{{ route('rfq.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this Record?</p>

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
