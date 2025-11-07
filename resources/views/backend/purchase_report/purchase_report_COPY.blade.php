@extends('layouts.purchase_deshboard')
@push('addcss')
    <style>
        .text_sale {
            color: #1fb715;
        }
        .text_credit{
            color: #f90b0b;
        }
          .tableFixHead          { overflow: auto; height: 600px; }
    	.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }

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
          <div class="row pt-2">
                  	<div class="col-md-12 text-right">
                      	 <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
              		<button class="btn btn-sm btn-info mt-1"  onclick="printland()"><i class="fa fa-print" aria-hidden="true"> </i> Landscape</button>

                    </div>
                </div>
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh; max-width:100% !important" id="contentbody">

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Purchase Report</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>

                <div class="py-4 table-responsive tableFixHead">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed"
                        style="font-size: 10px;table-layout: inherit;">


                        <thead>
                            <tr class="table-header-fixt-top" style="font-size: 16px;font-weight: bold;color: rgb(0, 0, 0);top: -25px;">
                                <th style="text-align:center;top: -35px; ">Date</th>
                                <th style="text-align:center;top: -35px; ">IN no</th>
                                <th style="text-align:center;top: -35px; ">Warehouse</th>
                                <th style="text-align:center;top: -35px; ">Vehicle</th>
                                <th style="text-align:center;top: -35px; ">Product Name</th>
                                <th style="text-align:center;top: -35px; ">Order Qty</th>
                                <th style="text-align:center;top: -35px; ">Receive Qty</th>
                                <th style="text-align:center;top: -35px; ">Sack</th>
                                <th style="text-align:center;top: -35px; ">Mois.</th>
                                <th style="text-align:center;top: -35px; ">DED. Qty</th>
                                <th style="text-align:center;top: -35px; ">Bill Qty</th>
                                <th style="text-align:center;top: -35px; ">Rate</th>
                                <th style="text-align:center;top: -35px; ">Purchase Value</th>
                                <th style="text-align:center;top: -35px; ">TP Fare</th>
                                <th style="text-align:center;top: -35px; ">Total Payable Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $bln = 0;
                                $tcra = 0;
                                $tdeb = 0;
                                $topb = 0;
                                $newblns = 0;
                                $purchaseall = 0;
                                $total_sack = 0;
                                $total_m = 0;

                                $gtotal_pv = 0;
                                $gtotal_tf = 0;
                                $gtotal_pay = 0;
                                $gtotal_order = 0;
                                $gtotal_recv = 0;
                                $gtotal_did = 0;
                                $gtotal_bill = 0;
                                $gstotal_sack = 0;
                                $gstotal_m = 0;
                                $gsi = 0;
                            @endphp
                            @foreach ($supplier as $supplier_data)

                                <tr>
                                    <td colspan="15" style="color: rgb(4, 126, 30);font-size: initial;font-weight: bold;">
                                        <b>{{ $supplier_data->supplier_name }}</b>
                                    </td>
                                </tr>
                                @php
                                    $pur = DB::table('purchases')
                                        ->select('purchases.*', 'suppliers.supplier_name', 'row_materials_products.product_name', 'factories.factory_name as wirehouse_name')
                                        ->leftjoin('suppliers', 'suppliers.id', '=', 'purchases.raw_supplier_id')
                                        ->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchases.product_id')
                                        ->leftjoin('factories', 'factories.id', '=', 'purchases.wirehouse_id')
                                        //->whereNull('purchases.purchas_unit')
                                        ->where('purchases.raw_supplier_id',$supplier_data->raw_supplier_id)
                                        ->whereBetween('purchases.date', [$fdate, $tdate]);

                                    if ($pro) {
                                        $pur = $pur->whereIn('purchases.product_id', $pro);
                                    }
                                    if ($wir) {
                                        $pur = $pur->whereIn('purchases.wirehouse_id', $wir);
                                    }

                                    $pur = $pur->get();




                                   // dd($pro);

                                    $total_pv = 0;
                                    $total_tf = 0;
                                    $total_pay = 0;
                                    $total_order = 0;
                                    $total_recv = 0;
                                    $total_did = 0;
                                    $total_bill = 0;
                                    $stotal_sack = 0;
                                    $stotal_m = 0;
                                    $ssi = 0;

                                @endphp



                                @foreach ($pur as $purchas_data)
                                    @php
                                        $ssi = $ssi + 1;
                                        $gsi = $gsi + 1;
                                       // $total_pv += $purchas_data->bill_quantity * $purchas_data->purchase_rate;
                                        $total_tf += $purchas_data->transport_fare;
                                        $total_pay += $purchas_data->total_payable_amount;

                                        $total_order += $purchas_data->order_quantity;
                                        $total_recv += $purchas_data->receive_quantity;
                                        $total_did += $purchas_data->deduction_quantity;
                                       // $total_bill += $purchas_data->bill_quantity;
                                        $stotal_sack += $purchas_data->sack_purchase;
                                        $stotal_m += ($purchas_data->receive_quantity * $purchas_data->moisture) / 100;

                                        $gtotal_pv += $purchas_data->bill_quantity * $purchas_data->purchase_rate;
                                        $gtotal_tf += $purchas_data->transport_fare;
                                        $gtotal_pay += $purchas_data->total_payable_amount;
                                        $gtotal_order += $purchas_data->order_quantity;
                                        $gtotal_recv += $purchas_data->receive_quantity;
                                        $gtotal_did += $purchas_data->deduction_quantity;
                                        $gtotal_bill += $purchas_data->bill_quantity;
                                        $gstotal_sack += $purchas_data->sack_purchase;
                                        $gstotal_m += ($purchas_data->receive_quantity * $purchas_data->moisture) / 100;
                                   @endphp

                          @if($purchas_data->purchas_unit == "bag")

                          @php
                           			         $purchasebag = DB::table('purchase_details')
                                                ->leftJoin('row_materials_products', 'purchase_details.product_id', '=', 'row_materials_products.id')
                                                ->where('purchase_id', $purchas_data->purchase_id)
                                                ->get();

                          @endphp
                           @foreach ($purchasebag as $pbdata)

                          @php
                          					$total_bill += $pbdata->bill_quantity;
                                                $total_pv += $pbdata->purchase_rate * $pbdata->bill_quantity;

                                                //$gtotal_bill += $pbdata->bill_quantity;
                                               // $gtotal_pv += $pbdata->purchase_rate * $pbdata->bill_quantity;
                           @endphp
                           <tr>
                                        <td>{{ date('d-m-y', strtotime($purchas_data->date)) }}</td>
                                        <td><a href="#">INV-{{ $purchas_data->purchase_id }}</a></td>
                                        <td style="text-align:center">-</td>
                                        <td style="text-align:center">-</td>
                                        <td style="text-align:center">{{ $pbdata->product_name }}</td>
                                        <td style="text-align:right">-</td>
                                        <td style="text-align:right">-</td>
                                        <td style="text-align:right">-</td>
                                        <td style="text-align:right">- </td>
                                        <td style="text-align:right">-</td>
                                        <td style="text-align:right">{{ number_format($pbdata->bill_quantity, 2) }}
                                        </td>
                                        <td style="text-align:right">{{ number_format($pbdata->purchase_rate, 2) }}
                                        </td>
                                        <td style="text-align:right">
                                            {{ number_format($pbdata->bill_quantity * $pbdata->purchase_rate, 2) }}
                                            Tk</td>
                                        <td style="text-align:right">-</td>
                                        <td style="text-align:right">-</tr>

                           @endforeach

                          @endif


                                    <tr>
                                        <td>{{ date('d-m-y', strtotime($purchas_data->date)) }}</td>
                                        <td><a href="#">INV-{{ $purchas_data->purchase_id }}</a></td>
                                        <td style="text-align:center">{{ $purchas_data->wirehouse_name }}</td>
                                        <td style="text-align:center">{{ $purchas_data->transport_vehicle }}</td>
                                        <td style="text-align:center">{{ $purchas_data->product_name }}</td>
                                        <td style="text-align:right">{{ number_format($purchas_data->order_quantity, 2) }}
                                        </td>
                                        <td style="text-align:right">
                                            {{ number_format($purchas_data->receive_quantity, 2) }}
                                        </td>
                                        <td style="text-align:right">{{ number_format($purchas_data->sack_purchase, 2) }}
                                        </td>
                                        <td style="text-align:right">
                                            {{ number_format(($purchas_data->receive_quantity * $purchas_data->moisture) / 100, 2) }}
                                        </td>
                                        <td style="text-align:right">
                                            {{ number_format($purchas_data->deduction_quantity, 2) }}</td>
                                        <td style="text-align:right">{{ number_format($purchas_data->bill_quantity, 2) }}
                                        </td>
                                        <td style="text-align:right">{{ number_format($purchas_data->purchase_rate, 2) }}
                                        </td>
                                        <td style="text-align:right">
                                            {{ number_format($purchas_data->bill_quantity * $purchas_data->purchase_rate, 2) }}
                                            Tk</td>
                                        <td style="text-align:right">
                                            {{ number_format($purchas_data->transport_fare, 2) }}
                                            Tk (Dr)</td>
                                        <td style="text-align:right">
                                            {{ number_format($purchas_data->total_payable_amount, 2) }} Tk (Cr)</td>
                                    </tr>
                                @endforeach
                                {{-- <tr>
                                    <td colspan="100%" style="border-color: rgb(125, 125, 255);"></td>
                                </tr> --}}
                                <tr style="color: rgb(3, 110, 3);">
                                    @php
                                        $total_sack += $stotal_sack;
                                        $total_m += $stotal_m;
                                    @endphp
                                    <td></td>
                                    <td><b> Sub Total ({{ $ssi }})</b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align:right"><b>{{ number_format($total_recv, 2) }}</b></td>
                                    <td style="text-align:right"><b>{{ number_format($stotal_sack, 2) }}</b></td>
                                    <td style="text-align:right"><b>{{ number_format($stotal_m, 2) }}</b></td>
                                    <td style="text-align:right"><b>{{ number_format($total_did, 2) }}</b></td>
                                    <td style="text-align:right"><b>{{ number_format($total_bill, 2) }}</b></td>
                                    <td></td>
                                    <td style="text-align:right"><b>{{ number_format($total_pv, 2) }} Tk </b></td>
                                    <td style="text-align:right"><b>{{ number_format($total_tf, 2) }} TK (Dr) </b></td>
                                    <td style="text-align:right"><b>{{ number_format($total_pay, 2) }} Tk (Cr) </b></td>
                                </tr>
                                {{-- <tr>
                                    <td colspan="100%" style="border-color: rgb(255, 119, 119);"></td>
                                </tr> --}}

                            @endforeach

                            <tr>
                                <td style="font-weight: bold;"></td>
                                <td style="font-weight: bold;"><b>Grand Total ({{ $gsi }})</b></td>
                                <td style="font-weight: bold;"></td>
                                <td style="font-weight: bold;"></td>
                                <td style="font-weight: bold;"></td>
                                <td style="font-weight: bold;"></td>
                                <td style="font-weight: bold; text-align:right">
                                    <b>{{ number_format($gtotal_recv, 2) }}</b>
                                </td>
                                <td style="font-weight: bold; text-align:right">
                                    <b>{{ number_format($gstotal_sack, 2) }}</b>
                                </td>
                                <td style="font-weight: bold; text-align:right"><b>{{ number_format($gstotal_m, 2) }}</b>
                                </td>
                                <td style="font-weight: bold; text-align:right">
                                    <b>{{ number_format($gtotal_did, 2) }}</b>
                                </td>
                                <td style="font-weight: bold; text-align:right">
                                    <b>{{ number_format($gtotal_bill, 2) }}</b>
                                </td>
                                <td style="font-weight: bold; text-align:right"></td>
                                <td style="font-weight: bold; text-align:right"><b>{{ number_format($gtotal_pv, 2) }} Tk
                                    </b></td>
                                <td style="font-weight: bold; text-align:right"><b>{{ number_format($gtotal_tf, 2) }} TK
                                        (Dr) </b></td>
                                <td style="font-weight: bold; text-align:right"><b>{{ number_format($gtotal_pay, 2) }} Tk
                                        (Cr) </b></td>
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
    function printDiv(divName) {
             var printContents = document.getElementById(divName).innerHTML;
             var originalContents = document.body.innerHTML;

             document.body.innerHTML = printContents;

             window.print();

             document.body.innerHTML = originalContents;
        }
  function printland() {

            	printJS({
                printable: 'contentbody',
                type: 'html',
                 font_size: '16px;',
                style: ' @page  { size: A4 landscape; max-height:100%; max-width:100%} table, th, td {border: 1px solid black; font-size:16px!important; border-collapse: collapse; padding: 0px 3px} h3{margin: 0!important;padding: 0 !important; text-align:center;} h5{margin: 0!important;padding: 0 !important; text-align:center;} p{margin: 0!important;padding: 0 !important; text-align:center;} h6{margin: 0!important;padding: 0 !important; text-align:center;} .cominfo{text-align:center;margin-left:8rem;} .pageinfo{text-align:center;margin-left:8rem;margin-bottom:2rem;padding: 0 !important;}'
              })

        }
</script>

<script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#reporttable").table2excel({
                filename: "PurchaseReport.xls"
            });
        });
    });
</script>
@endsection
