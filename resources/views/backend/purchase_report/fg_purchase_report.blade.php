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
                                <th style="text-align:center; ">Date</th>
                                <th style="text-align:center; ">Supplier</th>
                                <th style="text-align:center; ">IN no</th>
                                <th style="text-align:center; ">Warehouse</th>
                                <th style="text-align:center; ">Vehicle</th>
                                <th style="text-align:center; ">Product Name</th>
                                <th style="text-align:center; ">Opening Stock</th>
                                <th style="text-align:center; ">Order Qty</th>
                                <th style="text-align:center; ">Receive Qty</th>
                                <th style="text-align:center; ">Sack</th>
                                <th style="text-align:center; ">Mois.</th>
                                <th style="text-align:center; ">DED. Qty</th>
                                <th style="text-align:center; ">Bill Qty</th>
                                <th style="text-align:center; ">Rate</th>
                                <th style="text-align:center; ">Purchase Value</th>
                                <th style="text-align:center; ">TP Fare</th>
                                <th style="text-align:center; ">Total Payable Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php


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


                                  @if($fgPurchase)
                                      @foreach ($fgPurchase as $fgValue)
                                        @php
                                        $openingQty = $fgValue->opening_balance ?? 0;
                                        $id = $fgValue->product_id;
                                        $fgStockIn = \App\Models\SalesStockIn::select(DB::raw('SUM(quantity) as qty'))->where('prouct_id',$id)->whereBetween('date',[$sdate,$pdate])->get();
                                        $salesStockOut = \App\Models\SalesStockOut::select(DB::raw('SUM(sales_stock_outs.qty) as qty'))->where('product_id',$id)->whereBetween('date',[$sdate,$pdate])->get();
                                       
                                       if($fgStockIn){
                                       $stockIn = $fgStockIn[0]->qty; 
                                       } else {
                                       $stockIn = 0; 
                                       }
                                       if($salesStockOut){
                                       $stockOut = $salesStockOut[0]->qty;
                                       } else {
                                       $stockOut = 0; 
                                       }
                                        $stock = $openingQty + $stockIn - $stockOut;

                                        $gsi = $gsi + 1;
                                        $gtotal_pv += $fgValue->net_payable_amount;
                                        $gtotal_tf += $fgValue->transport_fare;
                                        $gtotal_pay += $fgValue->net_payable_amount;
                                        $gtotal_order += $fgValue->quantity;
                                        $gtotal_recv += $fgValue->quantity;
                                        $gtotal_bill += $fgValue->quantity;

                                        @endphp
                                      <tr>
                                          <td>{{ date('d-m-Y', strtotime($fgValue->date)) }}</td>
                                          <td>{{ $fgValue->supplier->supplier_name ?? ''}}</td>
                                          <td>{{ $fgValue->invoice }}</td>
                                          <td style="text-align:center">{{ $fgValue->warehose->factory_name ?? '' }}</td>
                                          <td style="text-align:center">{{ $fgValue->transport_vehicle }}</td>
                                          <td >{{ $fgValue->product_name }}</td>
                                          <td style="text-align:center">{{$stock}}</td>
                                          <td style="text-align:right">{{ number_format($fgValue->quantity, 2) }}
                                          </td>
                                          <td style="text-align:right">
                                              {{ number_format($fgValue->quantity, 2) }}
                                          </td>
                                          <td style="text-align:right"></td>
                                          <td style="text-align:right"></td>
                                          <td style="text-align:right"></td>
                                          <td style="text-align:right">{{ number_format($fgValue->quantity, 2) }}
                                          </td>
                                          <td style="text-align:right">{{ number_format($fgValue->rate, 2) }}
                                          </td>
                                          <td style="text-align:right">
                                              {{ number_format($fgValue->quantity * $fgValue->rate, 2) }}
                                              Tk</td>
                                          <td style="text-align:right">
                                              {{ number_format($fgValue->transport_fare, 2) }}
                                              Tk (Dr)</td>
                                          <td style="text-align:right">
                                              {{ number_format($fgValue->net_payable_amount, 2) }} Tk (Cr)</td>
                                      </tr>
                                      @endforeach
                                  @endif

                            <tr>
                                <td style="font-weight: bold;"></td>
                                <td style="font-weight: bold;"><b>Grand Total ({{ $gsi }})</b></td>
                                <td style="font-weight: bold;"></td>
                                <td style="font-weight: bold;"></td>
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
