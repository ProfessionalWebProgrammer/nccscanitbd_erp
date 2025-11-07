@extends('layouts.sales_dashboard')

@push('addcss')

@endpush

@section('header_menu')

@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background: #ffffff; padding: 0px 40px;">

                <div class="text-center pt-3">


                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Cash Receivable Report</h5>
                   <h6 style="margin-top:5px; font-size:13px;font-weight: bold;">From: {{$fdate}} To: {{$tdate}}</h6>
                </div>
                <div class="py-4 table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                         <thead>
                                <tr align="center">
                                    <th style="font-weight: bold;">Vendor Name</th>
                                    <th style="font-weight: bold;">Sales Date</th>
                                    <th style="font-weight: bold;">Payment Date</th>
                                    <th style="font-weight: bold;">Sales Invoice</th>

                                    <th style="font-weight: bold;">Sales Amount</th>
                                   <th style="font-weight: bold;">Receive Amount</th>
                                    <th style="font-weight: bold;">Due Amount</th>

                                </tr>
                            </thead>
                            <tbody>

 								 @php
                                        $tsalesamount = 0;
                                        $treceiveamount = 0;
                                @endphp

                                    @foreach ($dealers as $deler)
                                        @php

                               $saleslist = DB::table('sales')->where('dealer_id',$deler->dealer_id)
                                      ->whereNotNull('payment_date')
                              		   ->whereBetween('payment_date', [$fdate, $tdate])
                                       ->orderby('date','asc')
                                      ->get();
                            //  dd($saleslist)
                                            @endphp
                               <tr style="background: #bbf5ac;">
                                        <td colspan="100%">{{ $deler->d_s_name }}</td>
                                    </tr>


                                          @foreach ($saleslist as $idata)

                              					@php
                              						$receivedamount = DB::table('payments')->where('sales_invoice',$idata->invoice_no)->where('status',1)->sum('amount');
                              					$dueamount = $idata->grand_total-$receivedamount;

                                        $tsalesamount += $idata->grand_total;
                                        $treceiveamount += $receivedamount;
                              				@endphp

                                              <tr>
                                                  <td> </td>
                                                  <td class="text-right">{{$idata->date}}</td>
                                                  <td class="text-right">{{$idata->payment_date}}</td>
                                                @if($dueamount >0)
                                                <td class="text-right text-danger"  )>{{$idata->invoice_no}}</td>
                                                @else
                                                <td class="text-right text-success"  )>{{$idata->invoice_no}}</td>
                                                @endif

                                                  <td class="text-right">{{number_format($idata->grand_total,2)}}</td>
                                                  <td class="text-right">{{number_format($receivedamount, 2)}}</td>
                                                  <td class="text-right">{{number_format($dueamount,2)}}</td>

                                              </tr>
                               			@endforeach

                                    @endforeach
                                    <tr style="background: #86efc8;">

                                        <td>Total</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                        <td class="text-right">{{ number_format($tsalesamount, 2) }}</td>
                                        <td class="text-right">{{ number_format($treceiveamount, 2) }}</td>
                                          <td class="text-right">
                                            {{ number_format($tsalesamount - $treceiveamount , 2) }}
                                        </td>
                                    </tr>


                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- /.modal -->

    <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('sales.invoice.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this invoice?</p>

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



@endsection

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

            modal.find('.modal-body #minvoice').val(id);
        })
    </script>

@endpush
