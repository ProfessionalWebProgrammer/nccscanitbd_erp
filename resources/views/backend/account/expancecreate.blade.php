@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-6" style="border-right: 2px solid black">
                    <div class="container-fluid">
                        <div class="px-3">
                            <div class="py-4">
                                <div class="text-center">
                                    <h5 class="text-uppercase font-weight-bold">Expense Group List</h5>
                                    <hr>
                                </div>
                                <table id="example5" class="table table-bordered table-striped" style="font-size: 15px;">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="10%">SI.</th>
                                            <th>Group Name</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($groups as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }} </td>
                                                <td>{{ $item->group_name }}</td>
                                                <td class="text-center align-middle">
                                                    <a class="btn btn-sm" style="background-color: #66BB6A" href="{{ URL('/expanse/group/edit/'.$item->id) }}"
                                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                            class="fas fa-edit"></i> </a>
                                                    <a class="btn btn-sm btn-danger " href="" data-toggle="modal"
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
                        <form class="floating-labels m-t-40" action="{{ route('expanse.group.store') }}" method="POST">
                            @csrf
                            <div class="px-3">
                                <div class="pt-3 text-center">
                                    <h5 class="font-weight-bolder text-uppercase">Create Expense Group</h5>
                                    <hr width="33%">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class=" col-form-label">Expense Group Name :</label>

                                        <input type="text" name="expanse_group_name" class="form-control"
                                            placeholder="Expanse Group Name" required>
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
                <div class="col-md-6">
                    <div class="container-fluid">
                        <div class="py-4">
                            <div class="text-center">
                                <h5 class="text-uppercase font-weight-bold">Expense Ledger List</h5>
                                <hr>
                            </div>
                            <table id="exampleduplicate" class="table table-bordered table-striped"
                                style="font-size: 15px;">
                                <thead>
                                    <tr class="text-center">
                                        <th width="10%">SI.</th>
                                        <th>Ledger Name</th>
                                        <th>Group Name</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subgroups as $subitem)

                                        <tr>

                                            <td>{{ $loop->iteration }} </td>
                                            <td>{{ $subitem->subgroup_name }}</td>
                                            <td>{{ $subitem->group_name }}</td>
                                            <td class="text-center align-middle">
                                                <a class="btn btn-sm" style="background-color: #66BB6A"  href="{{ URL('/expanse/subgroup/edit/'.$subitem->id) }}"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fas fa-edit"></i> </a>
                                                <a class="btn btn-sm btn-danger " href="" data-toggle="modal"
                                                    data-target="#delete2" data-myid="{{ $subitem->id }}"><i
                                                        class="far fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <form class="floating-labels m-t-40" action="{{ route('expanse.subgroup.store') }}" method="POST">
                            @csrf

                            <div class="px-3">
                                <div class="pt-3 text-center">
                                    <h5 class="font-weight-bolder text-uppercase">Create Expense Ledger</h5>
                                    <hr width="33%">
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class=" col-form-label">Expanse Ledger Name :</label>

                                        <input type="text" name="expanse_sub_group_name" class="form-control"
                                            placeholder="Expanse Ledger Name" required>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label class=" col-form-label">Expense Group Name :</label>

                                        <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                            name="group_id">
                                            <option value="">Select Expense Group</option>
                                            @foreach ($groups as $data)
                                                <option value="{{ $data->id }}">{{ $data->group_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class=" col-form-label">Opening Balance :</label>
                                        <input type="text" name="balance" class="form-control" >
                                    </div>

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

                        </form>

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
                <form action="{{ route('expanse.group.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this Group?</p>

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
    <!-- modal2 -->
    <div class="modal fade" id="delete2">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('expanse.subgroup.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this Ledger?</p>

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

		 <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })

            $('#delete2').on('show.bs.modal', function(event) {
                console.log('hello test');
                var button = $(event.relatedTarget)
                var title = button.data('mytitle')
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
