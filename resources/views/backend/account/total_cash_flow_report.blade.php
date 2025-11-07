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
    <div class="content-wrapper"  >


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

            <div class="container-fluid" id="contentbody">

 				<div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Cash Flow Report</h5>
                      <p>From {{date('d F, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    	<p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                  <hr style="background: #ffffff78;">
                </div>

                <div class="py-4 row">


                    <div class="py-4 col-md-3 table-responsive">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 14px;table-layout: inherit;">
                            <thead>
                              <tr class="text-center" style="background:#FA621C; color:#fff">
                                    <th>Income Statement</th>
                                    <th>{{$year}}</th>


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
                                    <td align="right">{{ number_format($data['sales'],2) }}</td>

                                </tr>
                                <tr>
                                    @php
                                        $net_income -= $data['purchase_amount'];
                                    @endphp
                                    <td >Purchase </td>
                                    <td align="right" class="text-danger">{{ number_format($data['purchase_amount'],2) }}</td>

                                </tr>
                               <tr  style="font-weight: bold;color:blue">

                                    <td >Gross Profit </td>
                                    <td align="right" >{{ number_format($data['sales'] - $data['purchase_amount'],2) }}</td>

                                </tr>
                              <tr>
                                    @php
                                        $net_income -= $data['allexpasne'];
                                   @endphp
                                    <td> Expanse</td>
                                    <td align="right" class="text-danger">{{ number_format($data['allexpasne'],2)}}</td>

                                </tr>



                              @if($data['asset_depreciations'])
                               <tr>
                                   @php
                                 $net_income -= $data['asset_depreciations'];
                                     @endphp

                                    <td > Depreciation </td>
                                    <td align="right" class="text-danger">{{$data['asset_depreciations']}}</td>

                                </tr>

                              @endif
                              <tr style="font-weight:bold">
                                    <th>Earnings before tax</th>
                                    <td align="right">{{ number_format($net_income, 2) }}</td>

                                </tr>
                               <tr>
                                 @php
                                  $taxamount = ($net_income/100)*$data['tax'];
                                 @endphp
                                    <th>Tax ({{$data['tax']}}%)</th>
                                    <td align="right" class="text-danger">{{number_format(($net_income/100)*$data['tax'], 2)}}</td>

                                </tr>
                               @php
                                 $net_income -=($net_income/100)*$data['tax'];
                                     @endphp


                               <tr style="color:red; font-weight:bold">
                                    <th>Net Profit</th>
                                    <td align="right">{{ number_format($net_income,2) }}</td>

                                </tr>
                              <tr style="color:red; font-weight:bold">
                                    <th colspan="100%"></th>

                                </tr>
                               <tr style=" font-weight:bold">
                                    <th colspan="100%">Retained earnings note</th>

                                </tr>
                               <tr >
                                    <th>Net Profit</th>
                                    <td align="right">{{ number_format($net_income, 2) }}</td>

                                </tr>
                                <tr >
                                    <th>Dividend</th>
                                    <td align="right" class="text-denger">{{number_format($data['dividend'],2)}}</td>

                                </tr>
                               <tr style="color:red; font-weight:bold">
                                    <th >Retained earning</th>
                                    <td align="right" >{{ number_format($net_income-$data['dividend'],2)}}</td>
                                </tr>




                            </tbody>
						 </table>
                    </div>


                  <div class="py-4 col-md-6 ">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 14px;table-layout: inherit;">
                            <thead>
                              <tr class="text-center" style="background:#1E8496; color:#fff">
                                    <th >Balance Sheet</th>
                                    <th>{{$year-1}}</th>
                                    <th>{{$year}}</th>
                                    <th>Difference</th>

                                </tr>

                            </thead>
                          <tbody>
                             <tr style=" font-weight:bold">
                                    <td colspan="100%">Current Asset</td>

                                </tr>
                            	<tr >
                                  @php
                                  $total_asset = $data['receive_amount']-$data['payment_amount']+$data['borrow_from']+$data['non_borrow'];
                                  $pretotal_asset = $predata['receive_amount']-$predata['payment_amount']+$predata['borrow_from']+$predata['non_borrow'];
                                  @endphp
                                    <td >Cash</td>
                                    <td >{{number_format($predata['receive_amount']-$predata['payment_amount']+$predata['borrow_from']+$predata['non_borrow'], 2)}}</td>
                                    <td >{{number_format($data['receive_amount']-$data['payment_amount']+$data['borrow_from']+$data['non_borrow'], 2)}}</td>
                                    <td >{{number_format($total_asset-$pretotal_asset, 2)}}</td>

                                </tr>
                            <tr >
                               @php
                                  $total_asset += $data['sales'] - $data['receive_amount'];
                                  $pretotal_asset += $predata['sales'] - $predata['receive_amount'];
                                  @endphp

                                    <td >Receiveable</td>
                                    <td >{{ number_format($predata['sales'] - $predata['receive_amount'], 2)}}</td>
                                    <td >{{ number_format($data['sales'] - $data['receive_amount'], 2) }}</td>
                                    <td >{{ number_format(($data['sales'] - $data['receive_amount'])-($predata['sales'] - $predata['receive_amount']),2) }}</td>

                                </tr>
                            <tr >
                               @php
                                  $total_asset += $data['inventory_sales']+$data['inventory_purchase'];
                                  $pretotal_asset += $predata['inventory_sales']+$predata['inventory_purchase'];
                                  @endphp

                                    <td >Inventory</td>
                                     <td >{{number_format($predata['inventory_sales']+$predata['inventory_purchase'], 2)}}</td>
                                     <td >{{number_format($data['inventory_sales']+$data['inventory_purchase'], 2)}}</td>
                                    <td >{{number_format(($data['inventory_sales']+$data['inventory_purchase'])-($predata['inventory_sales']+$predata['inventory_purchase']),2)}}</td>


                                </tr>
                             <tr style=" font-weight:bold">
                                    <td colspan="100%">Non Current Assets</td>

                                </tr>
                            <tr >
                              @php
                                  $total_asset += $data['assets_amount'];
                                  $pretotal_asset += $predata['assets_amount'];
                                  @endphp

                                    <td>PPE</td>
                                   <td >{{number_format($predata['assets_amount'],2)}}</td>
                                   <td >{{number_format($data['assets_amount'],2)}}</td>
                                    <td >{{number_format(($data['assets_amount'])-($predata['assets_amount']),2)}}</td>

                                </tr>

                            <tr style=" font-weight:bold">
                                     <td >Total Asset</td>
                                    <td >{{number_format($pretotal_asset, 2)}}</td>
                                    <td >{{number_format($total_asset, 2)}}</td>
                                    <td ></td>

                                </tr>
                            <tr style=" font-weight:bold">
                                    <td colspan="100%"></td>

                                </tr>
                             <tr style=" font-weight:bold">
                                    <td colspan="100%">Current Liabilities</td>

                                </tr>
                            <tr >
                              @php
                                  $total_cl = $data['purchase_amount'] - $data['payment_amount'];
                                  $pretotal_cl = $predata['purchase_amount'] - $predata['payment_amount'];
                                  @endphp

                                    <td>Payable</td>
                                    <td >{{number_format($predata['purchase_amount'] - $predata['payment_amount'],2)}}</td>
                                    <td >{{number_format($data['purchase_amount'] - $data['payment_amount'],2)}}</td>
                                    <td >{{number_format(($data['purchase_amount'] - $data['payment_amount'])-($predata['purchase_amount'] - $predata['payment_amount']),2)}}</td>

                                </tr>

                              <tr >
                              @php
                                  $total_cl += $data['loan_amount']+$data['borrow_from'];
                                  $pretotal_cl += $predata['loan_amount']+$predata['borrow_from'];
                                  @endphp

                                    <td>Loan Borrow </td>
                                    <td >{{number_format($predata['loan_amount']+$predata['borrow_from'],2)}}</td>
                                    <td >{{number_format($data['loan_amount']+$data['borrow_from'],2)}}</td>
                                    <td >{{number_format(($data['loan_amount']+$data['borrow_from'])-($predata['loan_amount']+$predata['borrow_from']),2)}}</td>

                                </tr>
                             <tr>
                                  <td>Tax Payable</td>
                                  @php
                                 $total_cl += $taxamount-$data['tax_payment_amount'];
                                  $pretotal_cl += $predata['tax_payment_amount'];
                                 @endphp
                                     <td >{{number_format($predata['tax_payment_amount'],2)}}</td>
                                    <td >{{number_format($taxamount-$data['tax_payment_amount'],2)}}</td>
                                    <td >{{number_format(($taxamount-$data['tax_payment_amount']- $predata['tax_payment_amount']), 2)}}</td>

                                </tr>

                            <tr style=" font-weight:bold">
                                    <td colspan="100%">Non Current Liabilities</td>

                                </tr>
                             <tr >
                              @php
                                  $total_cl += $data['non_borrow'];
                                  $pretotal_cl += $predata['non_borrow'];
                                  @endphp

                                    <td>Long term borrowing</td>
                                   <td >{{number_format($predata['non_borrow'],2)}}</td>
                                   <td >{{number_format($data['non_borrow'],2)}}</td>
                                    <td >{{number_format(($data['non_borrow'] - $predata['non_borrow']), 2)}}</td>

                                </tr>
                             <tr style="font-weight:bold">
                                     <td colspan="100%">Equity</td>



                                </tr>

                             <tr >
                              @php
                                  $total_cl += $data['equitiy'];
                                  $pretotal_cl += $predata['equitiy'];
                                  @endphp

                                    <td>Common Stock</td>
                                    <td >{{number_format($predata['equitiy'],2)}}</td>
                                    <td >{{number_format($data['equitiy'],2)}}</td>
                                   <td >{{number_format($data['equitiy'] - $predata['equitiy'], 2)}}</td>

                                </tr>
                            <tr >
                              @php
                                  $total_cl += $data['sales']-$data['cogs']-$data['expanse_amount'];
                                  $pretotal_cl += $predata['sales']-$predata['cogs']-$predata['expanse_amount'];
                                  @endphp

                                    <td>Retained Earning</td>
                                    <td >{{number_format($predata['sales']-$predata['cogs']-$predata['expanse_amount'],2)}}</td>
                                    <td >{{number_format($data['sales']-$data['cogs']-$data['expanse_amount'],2)}}</td>
                                   <td >{{number_format(($data['sales']-$data['cogs']-$data['expanse_amount'])-($predata['sales']-$predata['cogs']-$predata['expanse_amount']),2)}}</td>

                                </tr>

                            <tr style=" font-weight:bold">
                                     <td >Total Current Liabilies</td>
                                     <td >{{number_format($pretotal_cl,2)}}</td>
                                     <td >{{number_format($total_cl,2)}}</td>
                                    <td ></td>

                                </tr>

                          </tbody>


						 </table>
                    </div>

                   <div class="py-4 col-md-3 ">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 14px;table-layout: inherit;">
                            <thead>
                              <tr class="text-center" style="background:#c641cf; color:#fff">
                                    <th colspan="100%">Cash Flow Statement</th>


                                </tr>

                            </thead>
                          <tbody>
                            <tr style=" font-weight:bold">
                                      <td colspan="100%">Total Operating Cash Flow</td>


                                </tr>
                          <tr >
                             @php
                                 $operating_cash_flow = $net_income;
                                     @endphp

                                    <td>Net Income</td>
                                    <td align="right">{{ number_format($net_income ,2)}}</td>

                                </tr>
                            <tr>
                                   @php
                                 $operating_cash_flow += $data['asset_depreciations'];
                                     @endphp

                                    <td > Depreciation </td>
                                    <td align="right" >{{number_format($data['asset_depreciations'],2)}}</td>

                                </tr>
                            <tr>

                              <tr>
                                   @php
                                 $operating_cash_flow += ($taxamount-$data['tax_payment_amount'])-($predata['tax_payment_amount']);
                                     @endphp

                                    <td > Unpaid Tax </td>
                                    <td align="right" class="text-danger">{{number_format(($taxamount-$data['tax_payment_amount'])-($predata['tax_payment_amount']), 2)}}</td>

                                </tr>
                            <tr>


                                   @php
                                 $operating_cash_flow -= ($data['inventory_sales']+$data['inventory_purchase'])-($predata['inventory_sales']+$predata['inventory_purchase']);
                                     @endphp

                                    <td >Increase in receivables </td>
                                    <td align="right" class="text-danger">{{number_format(($data['inventory_sales']+$data['inventory_purchase'])-($predata['inventory_sales']+$predata['inventory_purchase']),2)}}</td>



                                </tr>
                            <tr>
                                   @php
                                 $operating_cash_flow -= ($data['sales'] - $data['receive_amount'])-($predata['sales'] - $predata['receive_amount']);
                                     @endphp

                                    <td >Increase in Inventory </td>
                                    <td align="right" class="text-danger">{{ number_format(($data['sales'] - $data['receive_amount'])-($predata['sales'] - $predata['receive_amount']),2) }}</td>

                                </tr>
                            <tr>
                                   @php
                                 $operating_cash_flow += ($data['purchase_amount'] - $data['payment_amount'])-($predata['purchase_amount'] - $predata['payment_amount']);
                                     @endphp

                                    <td >Increase in payables </td>
                                    <td align="right">{{number_format(($data['purchase_amount'] - $data['payment_amount'])-($predata['purchase_amount'] - $predata['payment_amount']), 2)}}</td>

                                </tr>
                             <tr style=" font-weight:bold">
                                      <td >Total Operating Cash Flow</td>
                                      <td >{{number_format($operating_cash_flow, 2)}}</td>


                                </tr>

                            <tr style=" font-weight:bold">
                                      <td colspan="100%"></td>
                             </tr>

                            <tr style=" font-weight:bold">
                                      <td colspan="100%">Investing Cash Flow</td>


                                </tr>
                             <tr >
                                      <td >Net capex</td>
                                      <td >{{number_format($predata['assets_amount'] - ($data['asset_depreciations'] + $data['assets_amount']),2)}}</td>


                                </tr>

                            <tr style=" font-weight:bold">
                                      <td colspan="100%"></td>
                             </tr>
                             <tr style=" font-weight:bold">
                                      <td colspan="100%">Financing cash flows</td>


                                </tr>
                            <tr >
                                      <td >Repayment of short term loans</td>
                                      <td align="right" class="text-danger">{{number_format(($data['loan_amount']+$data['borrow_from'])-($predata['loan_amount']+$predata['borrow_from']),2)}}</td>


                                </tr>
                             <tr >
                                      <td >Repayment of long term loans</td>
                                      <td align="right" class="text-danger">{{number_format(($data['non_borrow'])-($predata['non_borrow']),2)}}</td>


                                </tr>
                            <tr >
                                      <td >Dividend payment</td>
                                      <td align="right" class="text-danger">{{number_format(($data['loan_amount']+$data['borrow_from'])-($predata['loan_amount']+$predata['borrow_from'])-($data['non_borrow'])-($predata['non_borrow'])-$data['dividend'],2)}}</td>


                                </tr>
                             <tr >
                                      <td ></td>
                                      <td align="right" class="text-danger">{{number_format($data['dividend'],2)}}</td>


                                </tr>

                              <tr style=" font-weight:bold">
                                      <td colspan="100%"></td>
                             </tr>
                             <tr >
                                      <td >Changing In Cash</td>
                                      <td align="right" class="text-danger">{{number_format(($data['receive_amount']-$data['payment_amount']+$data['borrow_from']+$data['non_borrow'])-($predata['receive_amount']-$predata['payment_amount']+$predata['borrow_from']+$predata['non_borrow']),2)}}</td>


                                </tr>
                             <tr >
                                      <td >Cash In Start of year</td>
                                      <td align="right" class="text-danger">{{number_format($predata['receive_amount']-$predata['payment_amount']+$predata['borrow_from']+$predata['non_borrow'], 2)}}</td>


                                </tr>
                             <tr >
                                      <td >Cash In End of year</td>
                                      <td align="right" class="text-danger">{{number_format($data['receive_amount']-$data['payment_amount']+$data['borrow_from']+$data['non_borrow'], 2)}}</td>


                                </tr>

                            </tbody>
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
