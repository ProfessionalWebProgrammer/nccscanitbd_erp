@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper salescontent">
	<div class="container-fluid" style="background: #ffffff;padding: 0px 40px; min-height:40vh;">
        <div class="row">
            <div class="col-md-4" style="border-right: 2px solid black">

                <div class="content px-4 ">

                    <form class="floating-labels " action="{{ route('hrpayroll.time.attendance.complianceNonCompliance.store') }}" method="POST">
                        @csrf

                        <div class="container-fluid">
                            <div class="pt-2 text-center">
                                <h6 class="font-weight-bolder text-uppercase">Employee compliance Non Compliance Set</h6>
                                <hr width="33%">
                            </div>

                            <div class="row pt-1">
                                <div class="form-group col-md-12">
                                    <label class=" col-form-label"> compliance Time :</label>
                                    <div class="row">
                                      <div class="col-md-6">
                                        <input type="time" name="complianceStartTime" class="form-control"
                                            placeholder=" Set Time">
                                      </div>
                                      <div class="col-md-6">
                                        <input type="time" name="complianceEndTime" class="form-control"
                                            placeholder=" Set Time">
                                      </div>
                                    </div>

                                </div>
                                <div class="form-group col-md-12">
                                    <label class=" col-form-label"> Non Compliance Time :</label>

                                    <div class="row">
                                      <div class="col-md-6">
                                        <input type="time" name="nonComplianceStartTime" class="form-control"
                                            placeholder=" Set Time">
                                      </div>
                                      <div class="col-md-6">
                                        <input type="time" name="nonComplianceEndTime" class="form-control"
                                            placeholder=" Set Time">
                                      </div>
                                    </div>

                                </div>
                                <div class="form-group col-md-12">
                                    <label class=" col-form-label"> Description :</label>

                                    <textarea name="note" class="form-control" rows="3" cols="45" placeholder="Description"></textarea>
                                </div>
                                <input type="hidden" name="status" value="1">
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



            <div class="col-md-8">

                <div class="content px-4 ">
                    <div class="container-fluid">
                        <div class="py-4">
                            <div class="text-center">
                                <h6 class="text-uppercase font-weight-bold">Employee compliance Non Compliance List</h6>
                                <hr>
                            </div>
                            <table id="example5" class="table table-bordered table-striped" style="font-size: 15px;">
                                <thead>
                                    <tr class="text-center table-header-fixt-top">
                                        <th width="15%">SI. No</th>
                                        <th colspan="2">Compliance Time</th>
                                        <th colspan="2">Non Compliance Time</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($datas as $val)

                                        <tr>
                                            <td>{{ $loop->iteration }} </td>
                                            <td width="15%">{{date('g:i a',strtotime($val->complianceStartTime))}} </td>
                                            <td width="15%">{{ date('g:i a',strtotime($val->complianceEndTime)) }} </td>
                                            <td width="15%">{{ date('g:i a',strtotime($val->nonComplianceStartTime)) }} </td>
                                            <td width="15%">{{ date('g:i a',strtotime($val->nonComplianceEndTime)) }} </td>
                                            <td>{{ $val->note }} </td>
                                            <td align="center"> @if($val->status == 1) <span class="badge badge-success p-2"> Active </span> @else <span class="badge badge-danger p-2"> Inactive </span> @endif  </td>

                                            <td>
                                              {{-- <a class="btn btn-xs salesedit" style="background-color: #66BB6A"
                                                    href="{{ URL::to('/inter/company/edit/' . $data->id) }}" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i class="fas fa-edit"></i> </a> --}}
                                                <a class="btn btn-xs btn-danger marketingdelete" href="" data-toggle="modal" data-target="#delete"
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
                    <form action="{{route('hrpayroll.time.attendance.complianceNonCompliance.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Specification Head?</p>

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
