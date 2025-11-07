@extends('layouts.account_dashboard')
@section('header_menu')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ URL('/asset/notification') }}" class=" btn btn-success btn-sm mr-2 mt-1">Crate New Notification</a>
    </li>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Asset Notification</h5>

                </div>
                <div class="py-4">
                    <table id="example1" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                 <th>Product Name</th>
                                <th>Category</th>
                                <th>Notification Type</th>
                                <th>Warranty Date</th>
                                <th>Lisence Date</th>
                                <th>Notification Before</th>
                                <th>Status</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($notifications as $key=> $data)
                                <tr>

                                    <td class="text-left">{{ $key +1 }}</td>
                                    <td class="text-left">{{ $data->product_name }}</td>
                                    <td class="text-left">{{ $data->catname }}</td>
                                    <td class="text-left">{{ $data->type }}</td>
                                    <td class="text-left">{{ $data->warranty_date }}</td>
                                    <td class="text-left"></td>
                                    <td class="text-left">{{ $data->before_day }} Day</td>
                                  <td class="text-left">@if($data->status == 0)<span>Unseen</span>@else<span>Seen</span>@endif</td>
                                    <td class="text-left">

                                    {{--<a class="btn btn-sm accountsedit"
                                            style="background-color: mediumaquamarine;                                                                                                                                                                                                                                                                    color: white;"
                                            href="{{route('asset.product.view',$data->id)}}" data-toggle="tooltip" data-placement="top" title="View Product Details"><i
                                                class="far fa-eye"></i></a>  --}}

                                                  <a class="btn btn-xs btn-danger accountsdelete" href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{ $data->id }}"><i class="far fa-trash-alt"></i></a>
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
                    <form action="{{ route('asset.notification.delete')}}" method="POST">
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
