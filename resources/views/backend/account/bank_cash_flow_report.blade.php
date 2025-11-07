@extends('layouts.account_dashboard')
@section('print_menu')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="contentbody">

        <!-- Main content -->
        <div class="content px-4 ">

            <div class="container"  >

              	<div class="row pt-2">
                  	<div class="col-md-12 text-right">
                         <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                           Export
                        </button>
                        <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                           Print
                        </button>
                    </div>
                </div>

                <div class="text-center pt-3">
                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>

                </div>
                <div class="pt-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Cash Flow Statement Report</h5>
                        <p class=""> From {{ date('d F Y', strtotime($fdate)) }}
                            To
                            {{ date('d F Y', strtotime($tdate)) }}</p>
                        <hr>
                    </div>

                    <table id="reporttable" class="table table-bordered table-striped" style="font-size: 12px;">

                        <thead style="border: 1px solid #515151;">

                            <tr >
                                 <th style=" font-weight: bold; text-align:center;" width="220px">Head</th>
                                 <th style=" font-weight: bold; text-align:center;">Receive Amount (Dr)</th>
                                 <th style=" font-weight: bold; text-align:center;">Payment Amount (Cr)</th>
                                 <th style=" font-weight: bold; text-align:center;">Balance</th>
                            </tr>
                            </thead>
                             <tbody>
                                @php
                                $topb = 0;
                                $grndt_rcv = 0;
                                $grndt_pym = 0;
                                $finalBalance = 0;
                                $bankdata[] = 0;
                                $cashdata[] = 0;
                                @endphp

                                 @php

                                  $totaldata = DB::table('payments')
                                  ->select('bank_id',
                                  DB::raw('sum(CASE WHEN payment_type = "RECEIVE"  AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as oprcv'),
                                  DB::raw('sum(CASE WHEN payment_type = "PAYMENT"  AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as oppay'),
                                  DB::raw('sum(CASE WHEN payment_type = "RECEIVE"  AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalrcv'),
                                  DB::raw('sum(CASE WHEN payment_type = "PAYMENT"  AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalpay'),

                                  DB::raw('sum(CASE WHEN payment_type = "OTHERS"  AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as otoprcv'),
                                  DB::raw('sum(CASE WHEN payment_type = "OTHERS"  AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as otoppay'),
                                  DB::raw('sum(CASE WHEN payment_type = "OTHERS"  AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as ottotalrcv'),
                                  DB::raw('sum(CASE WHEN payment_type = "OTHERS"  AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as ottotalpay'),

                                  DB::raw('sum(CASE WHEN payment_type = "EXPANSE"  AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as exoppay'),
                                  DB::raw('sum(CASE WHEN payment_type = "EXPANSE"  AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as extotalrcv'),

                                  DB::raw('sum(CASE WHEN payment_type = "COLLECTION"  AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as cloppay'),
                                  DB::raw('sum(CASE WHEN payment_type = "COLLECTION"  AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as cltotalrcv'),
                                  DB::raw('sum(CASE WHEN payment_type = "RETURN" AND  payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as returnPreVal'),
                                  DB::raw('sum(CASE WHEN payment_type = "RETURN" AND  payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as returnVal'),
                                )->where('status', 1)->first();

                              //  $preloandcheck = DB::table('master_banks')->whereBetween('loan_fdate',[$startdate,$predate])->where('bank_id', $bank_list->bank_id)->value('loan_amount');
                              //  $loandcheck = DB::table('master_banks')->whereBetween('loan_fdate',[$fdate,$tdate])->first();

                                $oprcv = $totaldata->oprcv+$totaldata->otoprcv+$totaldata->cltotalrcv+$totaldata->returnPreVal;
                                $oppay = $totaldata->oppay+$totaldata->otoppay+$totaldata->exoppay;
                                $totalrcv = $totaldata->totalrcv+$totaldata->ottotalrcv+$totaldata->cltotalrcv+$totaldata->returnVal;
                          		 $totalpay = $totaldata->totalpay+$totaldata->ottotalpay+$totaldata->extotalrcv;


                                if($fdate == '2023-10-01'){
                                 $opb = 9618760.53;
                                } else {
                                   $opb = 9618760.53 + $oprcv - $oppay;
                                 }


                                    $vendor_prcv = DB::select('SELECT payments.vendor_id,payments.invoice,dealers.d_s_name,payments.payment_description, SUM(payments.amount) as rcvamount, payments.payment_date FROM `payments`
                                    LEFT JOIN dealers ON dealers.id = payments.vendor_id
                                    WHERE payments.payment_type = "RECEIVE"
                                    AND payments.status = 1
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.vendor_id,payments.invoice,dealers.d_s_name,payments.payment_description ORDER BY payments.payment_date ASC ');

                                    $vendor_pay = DB::select('SELECT payments.invoice,payments.vendor_id,suppliers.supplier_name,inter_companies.name,payments.expanse_head,expanse_subgroups.subgroup_name,payments.payment_description,payments.purchase_transection_id, SUM(payments.amount) as payamount, payments.payment_date FROM `payments`
                                     LEFT JOIN suppliers ON suppliers.id = payments.supplier_id
                                     LEFT JOIN inter_companies ON inter_companies.id = payments.sister_concern_id
                                    LEFT JOIN expanse_subgroups ON expanse_subgroups.id = payments.expanse_subgroup_id
                                    WHERE payments.payment_type = "PAYMENT"
                                    AND payments.status = 1
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.vendor_id,suppliers.supplier_name,payments.expanse_head,expanse_subgroups.subgroup_name,payments.payment_description,payments.purchase_transection_id ORDER BY payments.payment_date ASC ');


                                    $trnsfer_rcv = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as rcvamount, payments.payment_date FROM `payments`
                                    WHERE payments.transfer_type = "RECEIVE"
                                    AND payments.payment_type ="TRANSFER"
                                    AND payments.status = 1
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.payment_description ORDER BY payments.payment_date ASC');

                                     $trnsfer_pay = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as payamount, payments.payment_date FROM `payments`
                                    WHERE payments.transfer_type = "PAYMENT"
                                    AND payments.payment_type ="TRANSFER"
                                    AND payments.status = 1
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.payment_description ORDER BY payments.payment_date ASC ');



                                     $others_collection_rcv = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as rcvamount, payments.payment_date FROM `payments`
                                    WHERE payments.others_type = "RECEIVE"
                                    AND payments.payment_type ="OTHERS"
                                    AND payments.status = 1
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.payment_description ORDER BY payments.payment_date ASC ');



                                     $others_collection_pmt = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as payamount, payments.payment_date FROM `payments`
                                    WHERE payments.others_type = "PAYMENT"
                                    AND payments.payment_type ="OTHERS"
                                    AND payments.status = 1
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.payment_description ORDER BY payments.payment_date ASC ');

                                $expnase_pmt = DB::select('SELECT payments.invoice,payments.vendor_id,suppliers.supplier_name,payments.expanse_head,expanse_subgroups.subgroup_name,payments.payment_description,payments.purchase_transection_id, SUM(payments.amount) as payamount, payments.payment_date FROM `payments`
                                     LEFT JOIN suppliers ON suppliers.id = payments.supplier_id
                                     LEFT JOIN expanse_subgroups ON expanse_subgroups.id = payments.expanse_subgroup_id
                                     WHERE payments.payment_type = "EXPANSE"
                                     AND payments.status = 1
                                     AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                     GROUP BY payments.invoice,payments.vendor_id,suppliers.supplier_name,payments.expanse_head,expanse_subgroups.subgroup_name,payments.payment_description,payments.purchase_transection_id ORDER BY payments.payment_date ASC ');


                                 $general_prcv = DB::select('SELECT payments.vendor_id,payments.invoice,dealers.d_s_name,payments.payment_description, SUM(payments.amount) as rcvamount, payments.payment_date FROM `payments`
                                    LEFT JOIN dealers ON dealers.id = payments.vendor_id
                                    WHERE payments.payment_type = "COLLECTION"
                                    AND payments.status = 1
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.vendor_id,payments.invoice,dealers.d_s_name,payments.payment_description ORDER BY payments.payment_date ASC ');

                               $returnRec = DB::select('SELECT payments.invoice,payments.supplier_id,suppliers.supplier_name,expanse_subgroups.subgroup_name,payments.payment_description, SUM(payments.amount) as recAmount, payments.payment_date FROM `payments`
                                     LEFT JOIN suppliers ON suppliers.id = payments.supplier_id
                                    LEFT JOIN expanse_subgroups ON expanse_subgroups.id = payments.expanse_subgroup_id
                                    WHERE payments.payment_type = "RETURN"
                                    AND payments.status = 1
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.supplier_id,suppliers.supplier_name,expanse_subgroups.subgroup_name,payments.payment_description ORDER BY payments.payment_date ASC ');

                                    $si = 1;
                                    $finalBalance+= $opb;
                                    $topb += $opb;
                                    @endphp

                                    <tr>
                                        <td style="font-weight:bold; left:50px;" >Opening Balance: </td>
                                        <td  style="font-weight:bold" align="right">{{number_format($opb, 2)}}/- (Dr)</td>
                                        <td  style="font-weight:bold" align="right"></td>
                                        <td  style="font-weight:bold" align="right">{{number_format($finalBalance, 2)}}</td>
                                    </tr>

                                    @php
                                    $subtrcv = 0;
                                    $subtpmt = 0;
                                    $dealerReceive = 0;
                                    $othersReceive = 0;
                                    $supplierPay = 0;
                                    $othersPay = 0;
                                    $totalPay = 0;
                                    @endphp

                                   @foreach($vendor_prcv as $data)
                                      @php
                                        $dealerReceive += $data->rcvamount;
                                        $subtrcv += $data->rcvamount;
                                        $grndt_rcv += $data->rcvamount;
                                        $finalBalance += $data->rcvamount;
                                       @endphp
                                     @endforeach
                                      <tr >
                                        <td>Dealer Receive</td>
                                        <td align="right">{{number_format($dealerReceive, 2)}}/-</td>
                                        <td></td>
                                        <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>


                                    @foreach($vendor_pay as $data)
                                     @php
                                      $supplierPay += $data->payamount;
                                      $subtpmt += $data->payamount;
                                      $grndt_pym += $data->payamount;
                                      $finalBalance -= $data->payamount;
                                      @endphp
                                      @endforeach
                                      <tr>
                                        <td>Supplier Payment</td>
                                        <td></td>
                                        <td align="right">{{number_format($supplierPay, 2)}}/-</td>
                                        <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>

                                       @if($others_collection_rcv)
                                    @foreach($others_collection_rcv as $data)
                                       @php
                                          $othersReceive += $data->rcvamount;
                                          $subtrcv += $data->rcvamount;
                                          $grndt_rcv += $data->rcvamount;
                                          $finalBalance += $data->rcvamount;
                                         @endphp
                                       @endforeach
                                      <tr >
                                        <td>Others Collection Receive</td>
                                         <td align="right">{{number_format($othersReceive, 2)}}/-</td>
                                         <td></td>
                                        <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>
                                       @endif

                                    @if($others_collection_pmt)
                                    @foreach($others_collection_pmt as $data)
                                     @php
                                      $othersPay += $data->payamount;
                                      $subtpmt += $data->payamount;
                                      $grndt_pym += $data->payamount;
                                      $finalBalance -= $data->payamount;
                                      @endphp
                                      @endforeach
                                      <tr >

                                       <td>Others Collection Payment</td>
                                        <td></td>
                                        <td align="right">{{number_format($othersPay, 2)}}/-</td>
                                        <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>
                                       @endif

                                       @foreach($expnase_pmt as $data)
                                         @php
                                          $totalPay += $data->payamount;
                                          $subtpmt += $data->payamount;
                                          $grndt_pym += $data->payamount;
                                          $finalBalance -= $data->payamount;
                                          @endphp
                                        @endforeach
                                      <tr >
                                        <td>Expense Payment</td>
                                         <td></td>
                                        <td align="right">{{number_format($totalPay, 2)}}/-</td>
                                        <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>

                                       @php
                                       $totalReceive = 0;
                                       @endphp
                                       @if($returnRec)
                                @foreach($returnRec as $data)
                                     @php
                                      $totalReceive += $data->recAmount;
                                      $subtrcv += $data->recAmount;
                                      $grndt_rcv += $data->recAmount;
                                      $finalBalance += $data->recAmount;
                                      @endphp
                                      @endforeach

                                      <tr style="color:red;">
                                        <td>Return Receive </td>
                                        <td align="right">{{number_format($totalReceive, 2)}}/-</td>
                                        <td></td>
                                        <td  style="font-weight:bold" align="right">{{number_format($finalBalance, 2)}}</td>
                                       </tr>
                                       @endif


                                <tr>
                                    <td style="font-weight:bold; left:50px;" colspan="1" >SubTotal</td>
                                    <td  style="font-weight:bold" align="right">{{number_format($subtrcv, 2)}}/- (Dr)</td>
                                    <td  style="font-weight:bold" align="right">{{number_format($subtpmt, 2)}}/- (Cr)</td>
                                    <td  style="font-weight:bold" align="right">{{number_format($finalBalance, 2)}}</td>
                                  </tr>
                                  <tr style="color: black;background-color: #827d789c;font-weight: bold;">
                                    <td colspan="1" style="left:50px;" >Grand Total</td>
                                    <td  style="font-weight:bold" align="right">{{number_format($grndt_rcv+$topb, 2)}}/- (Dr)</td>
                                    <td  style="font-weight:bold" align="right">{{number_format($grndt_pym, 2)}}/- (Cr)</td>
                                    <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                  </tr>


                           </tbody>


                    </table>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

<script type="text/javascript">
  $(document).ready(function(){
  $('body').mouseenter(function(){
    $('#btnExport').css("display","inline-block");
      			$('#printbtn').css("display","inline-block");
  });
});

    function printDiv(divName) {
      			$('#btnExport').css("display","none");
      			$('#printbtn').css("display","none");
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
                filename: "Cash-flow-report.xls"
            });
        });
    });
</script>
@endsection
