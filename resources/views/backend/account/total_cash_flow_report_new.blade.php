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


                                    @php
                  $net_income = 0;
                                        $net_income += $data['sales'];

                                        $net_income -= $data['purchase_amount'];

                                        $net_income -= $data['allexpasne'];

                                 $net_income -= $data['asset_depreciations'];

                                  $taxamount = ($net_income/100)*$data['tax'];

                                 $net_income -=($net_income/100)*$data['tax'];
                 // dd($net_income);
                                     @endphp







                   <div class="py-4 col-md-8 m-auto">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 14px;table-layout: inherit;">
                            <thead>
                              <tr style="background:#c641cf; color:#fff">
                                    <th colspan="100%">Cash Flow Statement</th>


                                </tr>

                            </thead>
                          <tbody>
                           <tr style=" font-weight:bold">
                                      <td colspan="100%">Cash Flow from Operating Activities:</td>


                                </tr>
                          <tr >
                             @php
                                 $operating_cash_flow = $net_income;
                                     @endphp

                                    <td>Net Profit/ (Loss) before Tax for the year </td>
                                    <td align="right">{{ number_format($net_income,2) }}</td>

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

                                    <td > Amortization </td>
                                    <td align="right" >0</td>

                                </tr>
                            <tr>


                                <tr style="color:red">


                                    <td > Operating Profit/ (Loss) before Working Capital Changes </td>
                                    <td align="right" >{{number_format($operating_cash_flow, 2)}}</td>

                                </tr>
                            <tr>


                            {{--  <tr>
                                   @php
                                 $operating_cash_flow += ($taxamount-$data['tax_payment_amount'])-($predata['tax_payment_amount']);
                                     @endphp

                                    <td > Unpaid Tax </td>
                                    <td align="right" class="text-danger">{{($taxamount-$data['tax_payment_amount'])-($predata['tax_payment_amount'])}}</td>

                                </tr>
                            <tr>  --}}

                                 <tr>
                                   @php
                                 $operating_cash_flow -= ($data['sales'] - $data['receive_amount'])-($predata['sales'] - $predata['receive_amount']);
                                     @endphp

                                    <td >Increase/Decrease in Inventory </td>
                                    <td align="right" class="text-danger">{{ number_format(($data['sales'] - $data['receive_amount'])-($predata['sales'] - $predata['receive_amount']),2) }}</td>

                                </tr>
                            <tr>


                                   @php
                                 $operating_cash_flow -= ($data['inventory_sales']+$data['inventory_purchase'])-($predata['inventory_sales']+$predata['inventory_purchase']);
                                     @endphp

                                    <td >Increase/Decrease in Account receivables </td>
                                    <td align="right" class="text-danger">{{number_format(($data['inventory_sales']+$data['inventory_purchase'])-($predata['inventory_sales']+$predata['inventory_purchase']),2)}}</td>
                                </tr>

                                <tr>



                                    <td >Increase/Decrease in  Receivable Reconciliation</td>
                                    <td align="right">0</td>

                                </tr>

                                @foreach($data['assets_type'] as $dataex)
                                <tr>
                                       <td>Increase/Decrease in {{$dataex->asset_type_name}}</td>
                                     <td align="right">{{number_format($dataex->asset_value, 2)}}</td>

                                </tr>

                              @endforeach


                            <tr>


                                   @php
                                 $operating_cash_flow += ($data['purchase_amount'] - $data['payment_amount'])-($predata['purchase_amount'] - $predata['payment_amount']);
                                     @endphp

                                    <td >Increase/Decrease in Accounts payables </td>
                                    <td align="right">{{number_format(($data['purchase_amount'] - $data['payment_amount'])-($predata['purchase_amount'] - $predata['payment_amount']), 2)}}</td>

                                </tr>
                                 <tr>

                                    <td >Increase/Decrease in Others Payable</td>
                                    <td align="right">0</td>

                                </tr>
                              <tr>
                                <td colspan="100%"></td>
                                </tr>

                             <tr>

                                    <td >Adjustment for Changes in Working Capital</td>
                                    <td align="right">0</td>

                                </tr>
                              <tr>

                                    <td >Income Tax Paid </td>
                                    <td align="right">0</td>

                                </tr>
                              <tr>

                                    <td >Prior year Adjustment with  Retained Earnings </td>
                                    <td align="right">0</td>

                                </tr>




                             <tr style=" font-weight:bold; color:red">
                                      <td >Net cash used in operating activities</td>
                                      <td  align="right">{{number_format($operating_cash_flow, 2)}}</td>


                                </tr>

                            <tr style=" font-weight:bold">
                                      <td colspan="100%"></td>
                             </tr>

                               <tr style=" font-weight:bold">
                                      <td colspan="100%">Cash Flow from investing activities:</td>


                                </tr>


                             <tr >
                                   @php
                                 $operating_cash_flow += $predata['assets_amount'];
                                     @endphp
                                      <td >Increase in Property, Plant & Equipment</td>
                                      <td align="right">{{number_format($predata['assets_amount'], 2)}}</td>


                                </tr>
                                <tr >
                                      <td >Increase in Capital Work in Progress</td>
                                      <td align="right">0</td>


                                </tr>
                             <tr >
                                      <td >Increase in Investment</td>
                                      <td align="right">0</td>


                                </tr>
                               <tr >
                                      <td >Sale in Property, Plant & Equipment</td>
                                      <td align="right">0</td>


                                </tr>

                              <tr style=" font-weight:bold; color:red">
                                      <td >Net cash used in investing activities</td>
                                      <td  align="right">{{number_format($operating_cash_flow, 2)}}</td>


                                </tr>




                            <tr style=" font-weight:bold">
                                      <td colspan="100%"></td>
                             </tr>

                               <tr style=" font-weight:bold">
                                      <td colspan="100%">Cash Flow from financing activities:</td>


                                </tr>

                              <tr >
                                      <td >Paid up Capital Increase</td>
                                      <td align="right" >0</td>


                                </tr>



                            <tr >
                                      <td >Short term loans Receive</td>
                                      <td align="right" >{{number_format(($data['loan_amount']+$data['borrow_from'])-($predata['loan_amount']+$predata['borrow_from']), 2)}}</td>


                                </tr>
                             <tr >
                                      <td >Long term loans Receive</td>
                                      <td align="right">{{number_format(($data['non_borrow'])-($predata['non_borrow']), 2)}}</td>


                                </tr>
                            <tr >
                                      <td >Dividend payment</td>
                                      <td align="right" >{{number_format(($data['loan_amount']+$data['borrow_from'])-($predata['loan_amount']+$predata['borrow_from'])-($data['non_borrow'])-($predata['non_borrow'])-$data['dividend'], 2)}}</td>


                                </tr>
                             <tr >
                                      <td >Loan From Sister Concern</td>
                                      <td align="right" ></td>


                                </tr>

                             <tr style=" font-weight:bold; color:red">
                                      <td >Net cash provided by financing activities</td>
                                      <td  align="right">0</td>


                                </tr>

                              <tr style=" font-weight:bold">
                                      <td colspan="100%"></td>
                             </tr>
                             <tr style=" font-weight:bold; color:red" >
                                      <td >Net increase/(decrease) in Cash and Cash Equivalents</td>
                                      <td align="right" >{{number_format(($data['receive_amount']-$data['payment_amount']+$data['borrow_from']+$data['non_borrow'])-($predata['receive_amount']-$predata['payment_amount']+$predata['borrow_from']+$predata['non_borrow']), 2)}}</td>


                                </tr>
                             <tr  style=" font-weight:bold; color:red">
                                      <td >Cash and Cash Equivalents at the beginning of the period</td>
                                      <td align="right" >{{number_format($predata['receive_amount']-$predata['payment_amount']+$predata['borrow_from']+$predata['non_borrow'], 2)}}</td>


                                </tr>
                             <tr style=" font-weight:bold; color:red">
                                      <td >Cash and Cash Equivalents at the end of the year </td>
                                      <td align="right" >{{number_format($data['receive_amount']-$data['payment_amount']+$data['borrow_from']+$data['non_borrow'], 2)}}</td>

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
