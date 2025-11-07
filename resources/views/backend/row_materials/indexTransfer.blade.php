@extends('layouts.purchase_deshboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	<a href="{{ URL('/product/row/materials/create') }}" class=" btn btn-success mr-2 btn-sm">Create New Raw Materials</a>
                    </div>
                </div>

                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Raw Materials Product List</h5>
                        <hr>
                    </div>
                    <table id="example3" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>SI. No</th>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th>Category Name</th>
                                <th>Unit</th>
                                <th>Department</th>
                              	<th align="right">Product Rate</th>
                                <th align="right">Opening Balance</th>
                                <th align="center">Delivery Days</th>
                                <th align="center">Min Stock</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($products as $item)
                                <tr>
                                    <td class="align-middle">{{  $loop->iteration }}</td>
                                    <td>{{$item->product_name}}</td>
                                    <td>{{$item->code}}</td>
                                    <td>{{$item->cat->category_name ?? ''}} </td>
                                    <td> {{$item->unit}} </td>
                                    <td> {{$item->department->department_title ?? ''}} </td>
                                    <td align="right"> {{number_format($item->rate,2)}} </td>
                                    <td align="right"> {{$item->opening_balance}} </td>
                                  <td align="center"> {{$item->days ?? ''}} </td>
                                  <td align="center"> {{$item->min_stock ?? ''}} </td>
                                    <td class="text-center align-middle">
                                        <a class="btn btn-xs purchaseedit" style="background-color: #66BB6A" href="{{route('row.materials.edit', $item->id)}}"
                                            data-toggle="tooltip" data-placement="top" title="Edit Raw Materials"><i
                                                class="fas fa-edit"></i> </a>
                                        <a class="btn btn-xs btn-danger purchasedelete" href="" data-toggle="modal" data-target="#delete" data-myid="{{$item->id}}"><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  <!-- modal -->
    <div class="modal fade" id="delete">
                <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('row.materials.product.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete Raw Materials Product?</p>
                            <input type="hidden" id="myid" name="id">
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

    @push('end_js')
        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })


            $('#delete').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('myid')
                var modal = $(this)

                modal.find('.modal-body #myid').val(id);
            })
        </script>

    @endpush
@endsection
