@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper  accountscontent">
        <div class="content">

            <div class="row" style="min-height: 85vh">
                <div class="col-md-4" style="border-right: solid #003B46">
                    <div class="container-fluid">
                        <form class="floating-labels m-t-40" action="{{ route('store.asset.group') }}" method="POST">
                            @csrf
                                <div class="pt-4 text-center">
                                    <h4 class="font-weight-bolder text-uppercase">Create Asset Group</h4>
                                    <hr width="33%">
                                </div>

                                <div class="row pt-3">
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <label class=" col-form-label">Asset Category Name:</label>
                                          <select name="category_id" class="form-control select2">
                                              <option value="">== Select Category ==</option>
                                              @foreach ($assetcat as $data)
                                                  <option value="{{ $data->id }}">
                                                      {{ $data->name }}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
                                    <div class="form-group col-md-12">
                                        <label class=" col-form-label">Asset Group Name :</label>

                                        <input type="text" name="name" class="form-control" placeholder="Group Name">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class=" col-form-label">Asset Group Description :</label>

                                        <input type="text" name="description" class="form-control"
                                            placeholder="Group description">
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
                                <h3 class="text-uppercase font-weight-bold">Asset Group List</h3>
                                <hr>
                            </div>
                            <table id="example5" class="table table-bordered table-striped" style="font-size: 15px;">
                                <thead>
                                    <tr class="text-center">
                                        <th width="10%">SI. No</th>
                                        <th>Asset Category</th>
                                        <th>Asset Group Name</th>
                                        <th>Description</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assetgroups as $item)
                                        <tr>
                                            <td class="align-middle">{{ $loop->iteration }}</td>
                                            <td>{{ $item->category->name ?? '' }} </td>
                                            <td>{{ $item->name }} </td>
                                            <td>{{ $item->description }} </td>
                                            <td class="text-center align-middle">
                                                {{-- <a class="btn btn-sm text-light accountsedit" style="background-color: #66BB6A"
                                                        href="" data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                            class="fas fa-edit"></i> </a> --}}

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
                <form action="{{ route('delete.asset.group') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this?</p>

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

@endsection

@push('end_js')

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })


        $('#delete').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('myid')

            var modal = $(this)

            modal.find('.modal-body #mid').val(id);
        });
    </script>

@endpush
