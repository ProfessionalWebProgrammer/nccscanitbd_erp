@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper salescontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background: #ffffff; padding: 0px 40px;">
              <div class="row pt-3">
                <div class="col-md-3"></div>
                  	<div class="col-md-9 text-right">
                      	<a href="{{route('rentalProfileIndex')}}" class="btn btn-sm btn-success">Rental Profile </a>
                      	<a href="{{route('rental.rentalGoodsReceived.create')}}" class="btn btn-sm btn-success">Create Received </a>
                      	<a href="{{route('rentalGoodsDeliveryIndex')}}" class="btn btn-sm btn-success">Rental Goods Delivery</a>
                      	<a href="{{route('rentalGoodsDeliveryCollectionIndex')}}" class="btn btn-sm btn-success">Delivery Collection</a>
                    </div>
                </div>

                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Rental Goods Received List</h5>
                        <hr>
                    </div>

                    <table id="example3" class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>SI.</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Bag Type</th>
                                <th>Quantity</th>
                                
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                                <tr>
                                    <td>1</td>
                                    <td>19-09-2023</td>
                                    <td>R-10001</td>
                                    <td>Mr Abdul Karim</td>
                                    <td>PP Bag </td>
                                    <td align="center">5000 </td>
                                    <td class="text-center align-middle">
                                        <a class="btn btn-xs btn-primary"
                                            href="#" data-toggle="tooltip"
                                            data-placement="top" title="Edit"><i class="fas fa-edit"></i> </a>
                                        <a class="btn btn-xs btn-danger purchasedelete" href=""  data-toggle="modal" data-target="#delete"
                                                        data-myid="#"><i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>


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
                    <form action="{{route('lcEntry.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this LC Entry?</p>

                            <input type="hidden" id="mid" name="id">

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-light ">Confirm</button>
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
              //  console.log('hello test');
                var button = $(event.relatedTarget)
                var title = button.data('mytitle')
                var id = button.data('myid')

                var modal = $(this)

                modal.find('.modal-body #mid').val(id);
            })
        </script>

    @endpush
@endsection
