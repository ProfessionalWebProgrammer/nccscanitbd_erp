@extends('layouts.crm_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background: #ffffff; padding: 0px 40px;">
              	<div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      {{--	<a href="{{route('product.unit.create')}}" class="btn btn-sm btn-success">Product Unit</a>
                      	<a href="{{route('sales.category.index')}}" class="btn btn-sm btn-success">Product Category</a> --}}
                        <a href="{{route('marketing.item.create')}}" class="btn btn-sm btn-success">Create Product </a>
                        <a href="{{route('specification.head.index')}}" class="btn btn-sm btn-success mr-2">Specification Head</a>
                    </div>
                </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Product List</h5>
                        <hr>
                    </div>
                    <div class="my-3">

                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>SI. No</th>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th>Product Unit</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Image</th>
                                <th>Description</th>

                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $data)

                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ $data->name }} </td>
                                    <td>{{ $data->code }}</td>
                                    <td>{{ $data->unit }}</td>
                                    <td>{{ $data->category_name }}</td>
                                    <td>{{ $data->subCat }}</td>
									                   <td ><a href="{{URL::to('/public/uploads/marketing/')}}/{{$data->image}}" target="_blank"><img class="gallery" style="height:50px;" src="{{URL::to('/public/uploads/marketing/')}}/{{$data->image}}" alt="Image"></a> </td>
                                    <td>{{$data->specification}}</td>
                                    <td>
                                       <a class="btn btn-xs marketingedit" style="background-color: #66BB6A"
                                            href="{{ URL::to('/marketing/item/edit/' . $data->id) }}" data-toggle="tooltip"
                                            data-placement="top" title="Return"><i class="fas fa-edit"></i> </a>
                                        <a class="btn btn-xs btn-danger marketingdelete" href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{ $data->id }}"><i class="far fa-trash-alt"></i>
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
                    <form action="{{route('marketing.item.delete')}}" method="POST">
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
    <!-- /.modal -->
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
