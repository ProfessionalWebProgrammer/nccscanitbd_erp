@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper  accountscontent">
        <div class="content">
            <div class="row" style="min-height: 85vh">
                <div class="col-md-4" style="border-right: solid #003B46">
                    <div class="container-fluid">
                        <form class="floating-labels m-t-40" action="{{ route('store.asset.type') }}" method="POST">
                            @csrf

                            <div class="pt-4 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Create Asset Type</h4>
                                <hr width="33%">
                            </div>

                            <div class="row pt-3">
                                <div class="form-group col-md-12">
                                    <label class=" col-form-label">Asset Type Name :</label>

                                    <input type="text" name="asset_type" class="form-control" placeholder="Type Name">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="text-center">
                                        <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>



                <div class="col-md-8">
                    <div class="container-fluid">
                        <div class="py-4">
                            <div class="text-center">
                                <h3 class="text-uppercase font-weight-bold">Asset Type List</h3>
                                <hr>
                            </div>
                            <table id="example5" class="table table-bordered table-striped" style="font-size: 15px;">
                                <thead>
                                    <tr class="text-center">
                                        <th width="10%">SI. No</th>
                                        <th>Asset Type Name</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assettype as $item)
                                        <tr>
                                            <td class="align-middle">{{ $loop->iteration }}</td>
                                            <td>{{ $item->asset_type_name }} </td>
                                            <td class="text-center align-middle">
                                                <a class="btn btn-xs text-light accountsedit"
                                                    style="background-color: #66BB6A" href="" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i class="fas fa-edit"></i>
                                                </a>

                                                <a class="btn btn-xs btn-danger accountsdelete" href="" data-toggle="modal"
                                                    data-target="#delete" data-myid="{{ $item->id }}"><i
                                                        class="far fa-trash-alt"></i>
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
                <form action="{{ url('/asset/type/delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this Asset Type?</p>

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
