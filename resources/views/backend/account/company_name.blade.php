@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content px-4 ">

            <div class="row">
                <div class="col-md-6" style="border-right: 2px solid black">


                    <form class="floating-labels m-t-40" action="{{ Route('company.name.store') }}" method="POST">
                        @csrf

                        <div class="container-fluid">
                            <div class="pt-3 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Company Create</h4>
                                <hr width="33%">
                            </div>

                            <div class="row pt-4">
                                <div class="form-group col-md-12">
                                    <label class=" col-form-label">Name :</label>

                                    <input type="text" name="name" class="form-control" placeholder="Name">
                                </div>



                                <div class="form-group col-md-12">
                                    <label class="col-form-label">Address :</label>
                                    <input type="text" name="address" class="form-control" placeholder="Description">
                                </div>

                            </div>
                            <div class="row pb-5">
                                <div class="col-md-6 mt-3">
                                    <div class="text-right">
                                        <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
    
                                </div>
                            </div>
                        </div>

                    </form>

                </div>



                <div class="col-md-6">

                    <div class="content px-4 ">
                        <div class="container-fluid">
                            <div class="py-4">
                                <div class="text-center">
                                    <h5 class="text-uppercase font-weight-bold">Company List</h5>
                                    <hr>
                                </div>
                                <table id="example5" class="table table-bordered table-striped" style="font-size: 15px;">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="10%">SI. No</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sl = 0;
                                        @endphp

                                        @foreach ($datas as $item)



                                            @php
                                                $sl++;
                                            @endphp
                                            <tr>
                                                <td class="align-middle">{{ $sl }}</td>
                                                <td>{{ $item->name }} </td>
                                                <td>{{ $item->address }} </td>
                                                <td class="text-center align-middle">
                                                    <a class="btn btn-sm mb-1" style="background-color: #66BB6A" href=""
                                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                            class="fas fa-edit"></i> </a>
                                                    <a class="btn btn-sm btn-danger " href="" data-toggle="modal"
                                                        data-target="#delete" data-myid="{{ $item->id }}"><i
                                                            class="far fa-trash-alt"></i> </a>
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
    </div>
    <!-- /.content-wrapper -->
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
                <form action="{{ route('company.name.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this Main Bank?</p>

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
