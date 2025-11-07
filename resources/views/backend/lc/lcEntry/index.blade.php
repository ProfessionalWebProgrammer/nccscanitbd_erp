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
                      	<a href="{{route('lcEntry.create')}}" class="btn btn-sm btn-success">LC Entry Create </a>
                      	<a href="{{route('lcGroupIndex')}}" class="btn btn-sm btn-success">LC Group </a>
                      	<a href="{{route('lcLedgerIndex')}}" class="btn btn-sm btn-success">LC Ledger</a>
                      	<a href="{{route('agentBankIndex')}}" class="btn btn-sm btn-success">Agent Bank</a>
                      	<a href="{{route('exporterLedgerIndex')}}" class="btn btn-sm btn-success">Exporter Ledger</a>
                      	<a href="{{route('cnfNnameIndex')}}" class="btn btn-sm btn-success">CNF Name</a>
                      	<a href="{{route('motherVesselIndex')}}" class="btn btn-sm btn-success">Mother Vessel</a>
                      	<a href="{{route('portOfEntryIndex')}}" class="btn btn-sm btn-success">Port Of Entry</a>
                      	<a href="{{route('portOfDischargeIndex')}}" class="btn btn-sm btn-success">Port Of Discharge</a>
                    </div>
                </div>

                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">LC Entry List</h5>
                        <hr>
                    </div>

                    <table id="example3" class="table table-bordered table-striped" style="font-size: 9px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>SI.</th>
                                <th>Date</th>
                                <th>Item Name</th>
                                <th>Group</th>
                                <th>Ledger</th>
                                <th>LC No</th>
                                <th>Issues Bank </th>
                                <th>Beneficiary Bank </th>
                                <th>Discounting Bank </th>
                                <th>Confirming  Bank </th>
                                <th>Agent  Bank </th>
                                <th>Exporter</th>
                                <th>H.S Code</th>
                                <th>Country </th>
                                <th>L.C Qty </th>
                                <th>Rate (USD)</th>
                                <th>Value (USD)</th>
                                <th>Rate (BDT)</th>
                                <th>Value (BDT)</th>
                                <th>Shipment Date</th>
                                <th>CNF Name</th>
                                <th>Mother Vessel </th>
                                <th>Port of Entry </th>
                                <th>Port of Discharge </th>
                                <th>Receive Qty</th>
                                <th>Acceptance Date</th>
                                <th>Payment  Date</th>
                                <th>Payment  Bank</th>
                                <th>Bank Charge</th>
                                <th>Remarks</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lcDatas as $val)




                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ date("d-m-Y", strtotime($val->date)) }} </td>
                                    <td>{{ $val->item->product_name }} </td>
                                    <td>{{ $val->lcGroup->name }} </td>
                                    <td>{{ $val->lcLedger->name }} </td>
                                    <td>{{ $val->lc_number }} </td>
                                    <td>{{ $val->issuesBank->bank_name ?? '' }} </td>
                                    <td>{{ $val->beneficiaryBank->bank_name ?? '' }} </td>
                                    <td>{{ $val->discountingBank->bank_name ?? '' }} </td>
                                    <td>{{ $val->confirmingBank->bank_name ?? '' }} </td>
                                    <td>{{ $val->agentBank->name ?? '' }} </td>
                                    <td>{{ $val->exporteLedger->name ?? '' }} </td>
                                    <td>{{ $val->hs_code }} </td>
                                    <td>{{ $val->country }} </td>
                                    <td>{{ $val->lc_qty }} </td>
                                    <td>{{ $val->usd_rate }} </td>
                                    <td>{{ $val->usd_value }} </td>
                                    <td>{{ $val->bdt_rate }} </td>
                                    <td>{{ $val->bdt_value }} </td>
                                    <td>{{ date("d-m-Y", strtotime($val->shipment_date)) }} </td>
                                    <td>{{ $val->cnf->name }} </td>
                                    <td>{{ $val->motherVessel->name }} </td>
                                    <td>{{ $val->portOfEntry->name }} </td>
                                    <td>{{ $val->portOfDischarge->name }} </td>
                                    <td>{{ $val->receive_qty }} </td>
                                    <td>{{ date("d-m-Y", strtotime($val->acceptance_date)) }} </td>
                                    <td>{{ date("d-m-Y", strtotime($val->payment_date)) }} </td>
                                    <td>{{ $val->paymentBank->bank_name ?? '' }} </td>
                                    <td>{{ $val->amount }} </td>
                                    <td style="font-size:9px; text-transform: capitalize;font-weight: 300;">{{ $val->remarks }}</td>
                                    <td class="text-center align-middle">
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ URL::to('lc/import/entry/invoice/' . $val->id) }}" data-toggle="tooltip"
                                            data-placement="top" title="Invoice view"><i class="fas fa-eye"></i> </a>
                                        <a class="btn btn-xs btn-danger purchasedelete" href=""  data-toggle="modal" data-target="#delete"
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
