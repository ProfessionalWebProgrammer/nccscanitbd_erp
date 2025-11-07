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
              <button class="btn btn-sm btn-info mt-1"  onclick="printland()"><i class="fa fa-print" aria-hidden="true"> </i> Landscape</button>
                    </div>
                </div>
            <div class="container-fluid" style="max-width: 1475px !important;" id="contentbody">

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Yearly Purchase Report</h5>
                      <p>{{ $cyear}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  		<p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>



                <div class="py-4 table-responsive tableFixHead">
                    <table id="datatablecustom" class="table table-bordered table-striped table-fixed"
                        style="font-size: 6;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top" style="font-size: 16px;font-weight: bold;color: rgb(0, 0, 0);top: -25px;">
                              <th style="text-align:center;top: -35px;">S-Name</th>
                              <th style="text-align:center;top: -35px;">Product</th>
                              <th style="text-align:center;top: -35px;">Quantity</th>
                              <th style="text-align:center;top: -35px;">Avg Rate</th>
                              <th style="text-align:center;top: -35px;">Total Value</th>
                               @if($iswarehouse == 1)

                               @foreach($wirehouseslist as $key => $wdata)
                               @php
                               $wvalue[$key] = 0;
                                @endphp
                                <th style="text-align:center;top: -35px;">{{$wdata->factory_name}}</th>
                                @endforeach

                                @endif

                            </tr>
                            </thead>
                            <tbody>
                                @php
                                $tpm = 0;
                                $tcm = 0;
                                $tbl = 0;

                                @endphp

                                @foreach($wirehouses as $data)

                                @php


                                $tcm += round($data->cqty/1000,3);
                                $tbl += round(((($data->cqty)*($data->avg_rate))+$data->opening_balance),3);

                              // dd($wirehouses);
                                   @endphp

                                <tr>
                                    <td>{{$data->supplier_name}}</td>
                                    <td>{{$data->product_name}}</td>
                                    <td>{{round($data->cqty/1000,3)}}</td>
                                    <td>{{$data->avg_rate}}</td>
                                    <td>{{number_format(($data->cqty)*($data->avg_rate),2)}}</td>
                                  @if($iswarehouse == 1)
                                    @foreach($wirehouseslist as $key =>  $wdata)
                                    @php

                                    $w1 = DB::select('SELECT SUM(purchases.bill_quantity) as total_qty FROM `purchases`
                                WHERE  purchases.wirehouse_id = "'.$wdata->id.'"
                                    AND  purchases.product_id = "'.$data->product_id.'"
                                    AND purchases.raw_supplier_id = "'.$data->raw_supplier_id.'"
                                    AND purchases.year = "'.$cyear.'" ');

                                    $wvalue[$key] += $w1[0]->total_qty/1000;
                                        @endphp
                                    <th>{{number_format($w1[0]->total_qty/1000,3)}}</th>
                                    @endforeach
								  @endif

                                </tr>
                                @endforeach
                            </tbody>

                                <tfoot>
                                    <tr style="background: rgba(243, 164, 164, 0.534)">
                                        <td>Total</td>
                                        <td></td>
                                        <td>{{$tcm}}</td>
                                        <td></td>
                                        <td>{{number_format($tbl, 2)}}</td>
							 @if($iswarehouse == 1)
                                        @foreach($wirehouseslist as $key => $wdata)
                                        <th>{{number_format($wvalue[$key],3)}}</th>
                                        @endforeach
                                        @endif
                                    </tr>
                                </tfoot>

                            </tbody>
                            <tfoot>
                                <tr>

                                </tr>
                            </tfoot>
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
                style: ' @page  { size: A4 landscape; max-height:100%; max-width:100%} table, th, td {border: 1px solid black; font-size:16px!important; border-collapse: collapse; padding: 0px 3px} h3{margin: 0!important;padding: 0 !important; text-align:center;} h5{margin: 0!important;padding: 0 !important; text-align:center;} p{margin: 0!important;padding: 0 !important; text-align:center;} h6{margin: 0!important;padding: 0 !important; text-align:center;} .cominfo{text-align:center;margin-left:20rem !important;} .pageinfo{text-align:center;margin-left:35rem !important; margin-bottom:2rem;padding: 0 !important;} .dt-buttons{display:none !important;} .dataTables_filter{display:none !important;} .dataTables_paginate{display:none !important;} .dataTables_info{display:none !important;}'
              })

        }
</script>

<script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#reporttable").table2excel({
                filename: "YearlyPUrchaseReprot.xls"
            });
        });
    });
</script>
@endsection
