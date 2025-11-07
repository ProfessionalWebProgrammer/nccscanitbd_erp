@extends('layouts.account_dashboard')
@section('header_menu')
    <li class="nav-item d-none d-sm-inline-block">

    </li>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row pt-2">
                  	<div class="col-md-12 text-right">
                      <a href="{{route('asset.group')}}" class=" btn btn-info btn-sm mr-2 mt-1">Asset Group</a>
                       <a href="{{ URL('/asset/product/create') }}" class=" btn btn-success btn-sm mr-2 mt-1">Create New Asset Head</a>
                    </div>
                </div>
            <div class="container-fluid">
                <div class="text-center pt-3">
                   <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		           <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Asset Product</h5>

                </div>
                <div class="py-4">
                    <table id="example3" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                 <th>Date</th>
                                 <th>Name</th>
                                <th>Group</th>
                                <th class="text-right">Balance</th>
                                <th>D Rate </th>
                                <th>D Year </th>
                                <th>Description</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($assetproduct as $key=> $data)
                                <tr>

                                    <td class="text-left">{{ $key +1 }}</td>
                                    <td class="text-left">{{ date('d-m-Y',strtotime($data->date)) }}</td>
                                    <td class="text-left">{{ $data->product_name }}</td>
                                    <td class="text-left">{{ $data->name }}</td>
                                    <td class="text-right"> @if($data->balance) {{ number_format($data->balance,2) }}  @else   @endif </td>
                                    <td class="text-left">{{ $data->depreciation_rate }}</td>
                                    <td class="text-left">{{ $data->depreciation_year }}</td>
                                    <td class="text-left">{{ $data->description }}</td>
                                    <td class="text-left">
                                      <a href="#" class="btn btn-xs btn-success accountsedit " data-toggle="modal" data-target="#editBalance"
                                            data-myid="{{ $data->id }}"><i
                                                   class="fas fa-edit"></i></a> 
                                    <a class="btn btn-xs btn-primary" href="{{route('asset.product.view',$data->id)}}" data-toggle="tooltip" data-placement="top" title="View Product Details"><i
                                                class="far fa-eye"></i></a>

                                                  <a class="btn btn-xs btn-danger accountsdelete" href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{ $data->id }}"  ><i class="far fa-trash-alt"></i></a>
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
                    <form action="{{ route('delete.asset.product') }}" method="POST">
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

 <!-- modal -->
    <div class="modal fade" id="editBalance">
            <div class="modal-dialog">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title">Set Opening Balance, Depreciation Amount</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('update.asset.product') }}" method="POST">
                        @csrf

                        <div class="modal-body">
                            <h5>Opening Balance</h5>

                            <input type="hidden" id="mid" name="id">

                            <input type="number" name="balance" class="form-control">
                            <h5 class="mt-2">Depreciation Amount</h5>
                            <input type="number" name="dep_amount" class="form-control">
                        </div>
                        <div class="modal-footer justify-content-between bg-info">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-light">Update</button>
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
              //  console.log('hello test');
                var button = $(event.relatedTarget)
                //var title = button.data('mytitle')
                var id = button.data('myid')

                var modal = $(this)

                modal.find('.modal-body #mid').val(id);
            });

            $('#editBalance').on('show.bs.modal', function(event) {
                //console.log('hello test');
                var button = $(event.relatedTarget)
                var id = button.data('myid')

                var modal = $(this)
                modal.find('.modal-body #mid').val(id);

            });
        </script>

    @endpush
