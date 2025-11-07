@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content">

            <div class="container-fluid" style="min-height: 85vh;">
                <div class="row">
                    <div class="col-md-12">
                            <div class="py-4">
                                <div class="">
                                    <div class=" row">
                                        <div class="col-md-6">
                                            <h3 class="text-uppercase font-weight-bold">General Products List</h3>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <a href="{{ route('general.product.create') }}"
                                                class="btn btn-sm btn-primary">
                                                Create Product</a>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="8%">SI. No</th>
                                            <th>Product Name</th>
                                            <th>Category Name</th>
                                            <th>Sub-Cat Name</th>
                                            <th>Price</th>
                                            <th>OP Balance</th>
                                            <th>Dimensions</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sl = 0;
                                        @endphp

                                        @foreach ($productdata as $item)
                                            @php
                                                $sl++;
                                            @endphp
                                            <tr>
                                                <td class="align-middle text-center">{{ $sl }}</td>
                                                <td>{{ $item->gproduct_name }} </td>
                                                <td>{{ $item->gcategory_name }} </td>
                                                <td>{{ $item->general_sub_category_name }} </td>
                                                <td class="text-right">{{ number_format($item->rate, 2) }} </td>
                                                <td class="text-right">{{ number_format($item->opening_balance) }}
                                                <td class="text-left">{{ $item->dimensions }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    <a class="btn btn-sm text-light purchaseedit"
                                                        style="background-color: #66BB6A"
                                                        href="{{ URL::to('/general/purchase/general/product/edit/' . $item->id) }}"
                                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                            class="fas fa-edit"></i> </a>
                                                    <a class="btn btn-sm btn-danger purchasedelete" href=""
                                                        data-toggle="modal" data-target="#delete"
                                                        data-myid="{{ $item->id }}"><i class="far fa-trash-alt"></i>
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
                <form action="{{ route('general.product.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this Product?</p>

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
    <!-- /.content-wrapper -->
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
