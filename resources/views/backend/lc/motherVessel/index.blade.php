@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper salescontent">
	<div class="container-fluid" style="background: #ffffff;padding: 0px 40px; min-height:40vh;">
    <div class="row pt-3 mb-4">
      <div class="col-md-3"></div>
          <div class="col-md-9 text-right">
              <a href="{{route('lcEntryIndex')}}" class="btn btn-sm btn-success">LC Entry </a>
              <a href="{{route('lcGroupIndex')}}" class="btn btn-sm btn-success">LC Group </a>
              <a href="{{route('lcLedgerIndex')}}" class="btn btn-sm btn-success">LC Ledger</a>
              <a href="{{route('agentBankIndex')}}" class="btn btn-sm btn-success">Agent Bank</a>
              <a href="{{route('exporterLedgerIndex')}}" class="btn btn-sm btn-success">Exporter Ledger</a>
              <a href="{{route('cnfNnameIndex')}}" class="btn btn-sm btn-success">CNF Name</a>
              <a href="{{route('portOfEntryIndex')}}" class="btn btn-sm btn-success">Port Of Entry</a>
              <a href="{{route('portOfDischargeIndex')}}" class="btn btn-sm btn-success">Port Of Discharge</a>
          </div>
      </div>
        <div class="row">
            <div class="col-md-6" style="border-right: 2px solid black">

                <div class="content px-4 ">

                    <form class="floating-labels " action="{{ route('motherVessel.store') }}" method="POST">
                        @csrf

                        <div class="container-fluid">
                            <div class="pt-2 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Mother Vessel Name</h4>
                                <hr width="33%">
                            </div>

                            <div class="row pt-1">
                                <div class="form-group col-md-12">
                                    <label class=" col-form-label"> Name :</label>

                                    <input type="text" name="name" class="form-control"
                                        placeholder=" Name">
                                </div>
                            </div>
                        </div>
                        <div class="row pb-5">
                            <div class="col-md-6  ">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary custom-btn-sbms-submit"> Submit </button>
                                </div>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>

                    </form>

                </div>
            </div>



            <div class="col-md-6">

                <div class="content px-4 ">
                    <div class="container-fluid">
                        <div class="py-4">
                            <div class="text-center">
                                <h5 class="text-uppercase font-weight-bold">Mother Vessel List</h5>
                                <hr>
                            </div>
                            <table id="example5" class="table table-bordered table-striped" style="font-size: 15px;">
                                <thead>
                                    <tr class="text-center table-header-fixt-top">
                                        <th width="15%">SI. No</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sl = 0;
                                    @endphp

                                    @foreach ($data as $val)

                                        <tr>
                                            <td>{{ $loop->iteration }} </td>
                                            <td>{{ $val->name }} </td>
                                            <td align="center"> <span class="badge badge-success p-2"> Active </span> </td>

                                            <td>
                                              {{-- <a class="btn btn-xs purchaseedit" style="background-color: #66BB6A"
                                                    href="{{ URL::to('/inter/company/edit/' . $data->id) }}" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i class="fas fa-edit"></i> </a> --}}
                                                <a class="btn btn-xs btn-danger purchasedelete" href="" data-toggle="modal" data-target="#delete"
                                                                data-myid="{{ $val->id }}"><i class="far fa-trash-alt"></i>
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
                    <form action="{{route('motherVessel.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Mother Vessel?</p>

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
