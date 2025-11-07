@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	<a href="{{ route('purchase.damage.create') }}" class=" btn btn-success mr-2 btn-sm">Create Damage</a>
                    </div>
                </div>

                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Purchase Damage List</h5>
                        <hr>
                    </div>
                    <div class="my-3">

                    </div>
                    <table id="example1" class="table table-bordered text-light table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="table-header-fixt-top">
                              <th>SI</th>
                              <th>Warehouse</th>
                              <th>Product</th>
                              <th>Date</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Value</th>
                              <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>

                               @foreach($damages as $key=>$data)
                               @php



                               @endphp
                              <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$data->factory_name}}</td>
                                <td>{{$data->product_name}}</td>
                                <td>{{date('d-M-Y',strtotime($data->date))}}</td>
                                <td class="text-right">{{$data->quantity}}</td>
                                <td class="text-right">{{$data->rate }} </td>
                                <td class="text-right">{{$data->rate*$data->quantity }} </td>
                                <td class="text-center">
                                    {{-- <a href="{{route('purchase.damage.edit',$data->id)}}" class="btn btn-xs btn-info purchaseedit"><span
                                        class="fa fa-edit"></span></a> --}}

                                <a class="btn btn-sm btn-danger purchasedelete" href="" data-toggle="modal" data-target="#delete"
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
                    <form action="{{route('purchase.damage.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Purchase Damage?</p>

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
