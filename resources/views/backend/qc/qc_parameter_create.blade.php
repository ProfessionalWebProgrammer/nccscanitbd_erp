@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper ml-3">
        <div class="content ml-5">
            <div class="row">
                <div class="col-md-6" style="border-right: 2px solid black">
                    <div class="container-fluid">
                        <form class="floating-labels m-t-40" action="{{ route('qc.parameter.store') }}" method="POST">
                            @csrf
                            <div class="px-3">
                                <div class="pt-3 text-center">
                                    <h5 class="font-weight-bolder text-uppercase">Create Q C Parameter</h5>
                                    <hr width="33%">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class=" col-form-label">Name :</label>
										<input type="hidden" name="item_type" value="2">
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Q C Parameter Name" required>
                                    </div>
                                   <div class="form-group col-md-12">
                                        <label class=" col-form-label">Standard Value:</label>

                                        <input type="number" name="standard" class="form-control"
                                            placeholder="Q C Parameter Standard Value" >
                                    </div>
                                </div>
                            </div>
                            <div class="row pb-5">
                                <div class="col-md-6 mt-3">
                                    <div class="text-right">
                                        <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end -->
                <div class="col-md-6">
                    <div class="container-fluid">
                        <div class="px-3">
                            <div class="py-4">
                                <div class="text-center">
                                    <h5 class="text-uppercase font-weight-bold">Q C Parameter List</h5>
                                    <hr>
                                </div>
                                <table id="example5" class="table table-bordered table-striped" style="font-size: 15px;">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="10%">SI.</th>
                                            <th>Group Name</th>
                                          	<th>Value</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($qcParameters as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }} </td>
                                                <td>{{ $item->name }}</td>
                                              	<td>{{ $item->standard }}</td>
                                                <td class="text-center align-middle">
                                                    <a class="btn btn-xs purchaseedit" style="background-color: #66BB6A" href="{{ route('qc.parameter.edit', $item->id) }}"
                                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                            class="fas fa-edit"></i> </a>
                                                    <a class="btn btn-xs btn-danger purchasedelete" href="" data-toggle="modal"
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
                <form action="{{  route('qc.parameter.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this Q C Parameter?</p>

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
    <!-- /.content-wrapper -->
    <script>
        $(function() {

            $('#exampleduplicate').DataTable({
                "searching": true,
                "lengthMenu": [5, 10, 50]

            });
        });
    </script>

@endsection
