@extends('layouts.account_dashboard')

@push('addcss')
    <style>
        .text_sale {
            color: #f7ee79;
        }

        .text_credit {
            color: lime;
        }

    </style>
@endpush

@section('print_menu')

			<li class="nav-item">

                </li>

@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	<button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                    </div>
                </div>

            <div class="container-fluid" id="contentbody" >


 				<div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Operating Cash Flow Report</h5>
                      <p>From {{date('d F, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    	<p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                  <hr style="background: #ffffff78;">
                </div>

                <div class="py-4 row">


                    <div class="py-4 col-md-4 table-responsive">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 14px;table-layout: inherit;">
                            <thead>
                              <tr class="text-center" style="background:#FA621C !important; color:#fff">
                                    <th colspan="100%">Income Statement</th>


                                </tr>
                                <tr class="text-center">
                                    <th>Head </th>
                                    <th>Amount (BDT)</th>

                                </tr>
                            </thead>
                            <tbody >
                                @php
                                    $net_income = 0;
                                @endphp


                                <tr>
                                    @php
                                        $net_income += $data['sales'];
                                    @endphp
                                    <td>Sales Revenues</td>
                                    <td align="right">{{ number_format($data['sales'], 2) }}</td>

                                </tr>
                                <tr>
                                    @php
                                        $net_income -= $data['cogs'];
                                  $cogs = 0;
                                    @endphp
                                    <td >C.O.G.S (Direct Operating Cost)</td>
                                    <td align="right">{{ number_format($data['cogs'], 2) }}</td> {{--colspan="100%" --}}

                                </tr>

                            {{--   <tr >
                                    @php
                                        $cogs += $data['opening_inventory_sales'];
                                   @endphp
                                    <td>Opening Inventory</td>
                                    <td align="right" class="pr-5">{{$data['opening_inventory_sales']}}</td>

                                </tr>
                              <tr >
                                    @php
                                        $cogs += $data['purchase_amount'];
                                   @endphp
                                    <td>Purchase</td>
                                    <td align="right" class="pr-5">{{$data['purchase_amount']}}</td>

                                </tr>
                               <tr >
                                    @php
                                        $cogs -= $data['inventory_sales'];
                                   @endphp
                                    <td>Closing Inventory</td>
                                    <td align="right" class="pr-5">{{$data['inventory_sales']}}</td>

                                </tr>
                               <tr style="font-weight: bold">
                                   @php
                                        $net_income -= $data['inventory_sales'];
                                   @endphp

                                    <td>C.O.G.S Amount </td>
                                    <td align="right" >{{ $cogs }} </td>

                                </tr> --}}



                              <tr style="font-weight: bold;color:blue">
                                    @php
                                        $net_income -= $allexpasne;
                                   @endphp
                                    <td>Total Expanse</td>
                                    <td align="right">{{number_format($allexpasne, 2)}}</td>

                                </tr>



                              @if($data['asset_depreciations'])
                               <tr>
                                   @php
                                 $net_income -= $data['asset_depreciations'];
                                     @endphp

                                    <td >Total Depreciation </td>
                                    <td align="right">{{$data['asset_depreciations']}}</td>

                                </tr>

                              @endif
                          </tbody>

                            <tfoot>
                                <tr style="color:red; font-weight:bold">
                                    <th>Net Profit</th>
                                    <td align="right">{{ number_format($net_income, 2) }}</td>

                                </tr>

                            </tfoot>
						 </table>
                    </div>


                  <div class="py-4 col-md-4 ">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 14px;table-layout: inherit;">
                            <thead>
                              <tr class="text-center" style="background:#1E8496 !important; color:#fff">
                                    <th colspan="100%">Cash Flow</th>


                                </tr>
                                <tr class="text-center">
                                    <th>Head </th>
                                    <th>Amount (BDT)</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp


                                <tr>
                                    @php
                                        $total += $data['receive_amount'];
                                    @endphp
                                    <td>Total Receive Amount</td>
                                    <td align="right">{{ number_format($data['receive_amount'], 2) }}</td>

                                </tr>
                                <tr>
                                    @php
                                        $total -= $data['payment_amount'];
                                    @endphp
                                    <td>Total Payment Amount</td>
                                    <td align="right">{{ number_format($data['payment_amount'], 2) }}</td>

                                </tr>
                               <tr style="font-weight: bold;">
                                    @php
                                        $total -= $allexpasne;
                                   @endphp
                                    <td>Total Expanse</td>
                                    <td align="right">{{number_format($allexpasne, 2)}}</td>

                                </tr>


                          </tbody>

                            <tfoot>
                                <tr style="color:red; font-weight:bold">
                                    <th>Change In Cash</th>
                                    <td align="right">{{ number_format($total, 2) }}</td>

                                </tr>

                            </tfoot>
						 </table>
                    </div>

                   <div class="py-4 col-md-4 ">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 14px;table-layout: inherit;">
                            <thead>
                              <tr class="text-center" style="background:#c641cf !important; color:#fff">
                                    <th colspan="100%">Reconciliation</th>


                                </tr>
                                <tr class="text-center">
                                    <th>Head </th>
                                    <th>Amount (BDT)</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp


                                <tr>
                                    @php
                                        $total += $net_income;
                                    @endphp
                                    <td>Net Income</td>
                                    <td align="right">{{ number_format($net_income, 2) }}</td>

                                </tr>
                               <tr>
                                    @php
                                        $total += $data['sales'] - $data['receive_amount'];
                                    @endphp
                                    <td>Account Receiveable </td>
                                    <td align="right">{{ number_format($data['sales'] - $data['receive_amount'], 2) }}</td>

                                </tr>
                                <tr>
                                    @php
                                        $total += $data['purchase_amount'] - $data['payment_amount'];
                                    @endphp
                                    <td>Account Payable</td>
                                    <td align="right">{{ number_format($data['purchase_amount'] - $data['payment_amount'], 2) }}</td>

                                </tr>

                              <tr>
                                    @php
                                        $total -= $data['inventory_sales'];
                                    @endphp
                                    <td>Inventory</td>
                                    <td align="right">{{ number_format($data['inventory_sales'], 2) }}</td>

                                </tr>



                              @if($data['asset_depreciations'])
                               <tr>
                                   @php
                                 $total += $data['asset_depreciations'];
                                     @endphp

                                    <td >Total Depreciation </td>
                                    <td align="right">{{number_format($data['asset_depreciations'], 2)}}</td>

                                </tr>

                              @endif


                          </tbody>

                            <tfoot>
                                <tr style="color:red; font-weight:bold">
                                    <th>Change In Cash</th>
                                    <td align="right">{{ number_format($total, 2)}}</td>

                                </tr>

                            </tfoot>
						 </table>
                    </div>



                </div>
            </div>
        </div>
    </div>


@endsection

@push('end_js')

<script type="text/javascript">
    function printDiv(divName) {
             var printContents = document.getElementById(divName).innerHTML;
             var originalContents = document.body.innerHTML;

             document.body.innerHTML = printContents;

             window.print();

             document.body.innerHTML = originalContents;
        }
</script>

<script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#reporttable").table2excel({
                filename: "Income_statement.xls"
            });
        });
    });
</script>

@endpush
