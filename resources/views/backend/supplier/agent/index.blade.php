@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	<a href="{{ route('supplier.agent.create') }}" class=" btn btn-success mr-2">Agent Profile Create</a>
                      	<a href="{{ route('supplier.group.index') }}" class=" btn btn-success mr-2">Supplier Group</a>
                      	<a href="{{ URL('/supplier/index') }}" class=" btn btn-success mr-2">Supplier</a>
                    </div>
                </div>

                <div class="text-center pt-3">
                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Supplier Agent List</h5>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>SI. No</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Area</th>
                                <th>Address</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                                <tr>
                                    <td class="align-middle">1</td>
                                    <td>Agent Name </td>
                                    <td>01745874574 </td>
                                    <td> Dhaka</td>
                                    <td> Dhaka</td>
                                    <td class="text-center align-middle">
                                        <!-- <a class="btn btn-xs purchaseedit" style="background-color: #66BB6A" href="{{URL('/supplier/edit/')}}"
                                            data-toggle="tooltip" data-placement="top" title="Return"><i
                                                class="fas fa-edit"></i> </a> -->
                                        <a class="btn btn-xs btn-danger purchasedelete" href="" data-toggle="modal" data-target="#delete"
                                                        data-myid=""><i class="far fa-trash-alt"></i>
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
                    <form action="{{ route('supplier.delete') }}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Supplier?</p>
                            <input type="hidden" id="mid" name="id">
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
                //console.log('hello test');
                var button = $(event.relatedTarget)
                var id = button.data('myid')
                var modal = $(this)
                modal.find('.modal-body #mid').val(id);
            })
        </script>

    @endpush
@endsection
