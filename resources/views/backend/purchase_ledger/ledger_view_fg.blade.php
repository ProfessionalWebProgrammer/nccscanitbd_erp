@extends('layouts.purchase_deshboard')
@push('addcss')
    <style>

      .table, .table td, .table th {
          border-color: rgb(64 64 64);
        font-size:14px;
      }
      table thead tr th:nth-child(1){
      width:120px!important;
      }
      .table, .table td{
          padding:2px;
         font-size:14px;
      }
      .table td:nth-child(1){
        padding-left:10px;
        border-left: 1px solid #333;
      }
      .table td:last-child {
        padding-right:10px!important;
        border-right: 1px solid #333;
      }

      .nav-sidebar .nav-item>.nav-link {
          color: #52CD9F !important;
      }
      
        .table thead tr th{
            font-size:14px;
            font-weight:bold;
            background: #f8f9fa !important;
            color:#000;
        }
    
    .table thead tr th:nth-child(1){
        border-left: 1px solid #333;
      }
      .table thead tr th:last-child {
        border-right: 1px solid #333;
      }
      
      .table_grand_total td{
          border-bottom: 1px solid #333;
          font-size:16px;
          color: #000;
      }
      
      .table_sub_total td{
          font-size:16px;
          color: #000;
      }

    </style>
@endpush
@section('print_menu')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row">
            <div class="col-md-1"></div>
                  <div class="col-md-5 text-left">
						 <a href="{{route('purchase.ledger.index')}}" class="btn btn-sm btn-success mt-1" id="btnExport"> Purchase Ledger</a>
						 {{-- <a href="{{route('purchase.stock.ledger.index')}}" class="btn btn-sm btn-success mt-1" id="btnExport"> Purchase Stock Ledger  </a>
						 <a href="{{route('purchase.bag.stock.ledger.index')}}" class="btn btn-sm btn-success mt-1" id="btnExport"> Purchase Bag Stock Ledger  </a> --}}
                  </div>
                <div class="col-md-6 text-right">
					<button class="btn btn-sm  btn-success mt-1" id="btnExport"  > Export  </button>
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  > Print  </button>
                    <button class="btn btn-sm btn-info mt-1"  onclick="printland()"><i class="fa fa-print" aria-hidden="true"> </i> Landscape</button>
                </div>
              </div>
            <div class="container-fluid mt-2" id="contentbody" style="min-width: 100% !important;">
              <div class="row pt-2 print_heading_info">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">F.G Purchase Ledger</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>
                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care </h3>
                  			<p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>

                <div class="py-4 table-responsive">
                  @if($groupcount > 0)
                    <table id="datatablecustom" class="table pl-3 pr-3" style="font-size: 13px;color: #333 !important; font-weight: 400; font-family: inherit;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>IN. NO</th>
                                <th>Warehouse/Bank</th>
                                <th>Vehicle</th>
                                <th>Product</th>
                                <th>Receive Qty</th>
                                <th>Rate</th>
                                <th>Purchase Value</th>
                                <th>TP Fare</th>
                                <th style="text-align:right">Debit</th>
                                <th style="text-align:right">Credit</th>
                                <th style="text-align:right">Balance BDT</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php
                          $Gbalance = 0;
                          $gQty = 0;
                          $gTotalValue = 0;
                          $gTransFare = 0;
                          $gDebit = 0;
                          $gCredit = 0;
                          @endphp
                          @foreach($supplier as $sgropub)
                          <tr>
                                <td colspan="100%" >Group- {{$sgropub->group_name}} </td>
                            </tr>
                            @if(!empty($sgropub->suppliers))
                           @foreach($sgropub->suppliers as $sdata)
                           @php
                          $supop  = DB::table('purchase_ledgers as t1')->select('t1.supplier_id',
                           DB::raw('sum(CASE WHEN t1.date BETWEEN   "'.$sdate.'" AND "'.$pdate.'" THEN `debit` ELSE null END) as debit'),
                           DB::raw('sum(CASE WHEN t1.date BETWEEN   "'.$sdate.'" AND "'.$pdate.'" THEN `credit` ELSE null END) as credit'))
                           ->where('supplier_id',$sdata->id)->where('t1.type',1)
                           ->groupBy('supplier_id')
                           ->first();

                           if($supop){
                               $opbalance = ($sdata->opening_balance +$supop->credit) - $supop->debit;
                             }else{
                               $opbalance = $sdata->opening_balance;
                              }
                            $Gbalance +=  $opbalance;
                           @endphp
                            <tr>
                                <td colspan="7"> {{$sdata->supplier_name}}</td>
                                <td colspan="4"> Opening Balance</td>
                                <td style="text-align:right">{{  $opbalance }} @if ( $opbalance >= 0) (Cr) @else (Dr) @endif
                                </td>
                            </tr>

                            @php

                            $ledgers = DB::table('purchase_ledgers')
                                ->select('purchase_ledgers.*', 'finish_goods_purchases.transport_vehicle','finish_goods_purchases.transport_fare','factories.factory_name as wirehouse_name','f_g_purchase_detailes.*')
                                ->leftJoin('finish_goods_purchases', 'purchase_ledgers.purcahse_id', '=', 'finish_goods_purchases.id')
                                ->leftJoin('factories', 'finish_goods_purchases.warehouse_id', '=', 'factories.id')
                                ->leftJoin('f_g_purchase_detailes', 'finish_goods_purchases.id', '=', 'f_g_purchase_detailes.purchase_id')
                                ->where('purchase_ledgers.supplier_id', $sdata->id)->where('purchase_ledgers.type',1)
                                ->whereBetween('purchase_ledgers.date', [$fdate, $tdate])
                                ->orderBy('purchase_ledgers.date', 'asc')
                                ->get();


                                $subQty = 0;
                                $subTotalValue = 0;
                                $subTransFare = 0;
                                $subDebit = 0;
                                $subCredit = 0;
                                $balance = $opbalance;
                            @endphp

                              @foreach($ledgers as $val)
                              @php
                                $product = \App\Models\SalesProduct::where('id',$val->product_id)->first();
                                $balance += $val->total_value - $val->debit;
                                $subQty += $val->quantity;
                                $subTotalValue += $val->total_value;
                                $subTransFare += $val->transport_fare;
                                $subDebit += $val->debit;
                                $subCredit += $val->total_value;
                                $gQty += $val->quantity;
                                $gTotalValue += $val->total_value;
                                $gTransFare += $val->transport_fare;
                                $gDebit += $val->debit;
                                $gCredit += $val->total_value;
                                $Gbalance += $val->total_value - $val->debit;
                               // $Gbalance += $val->credit - $val->debit;
                              @endphp
                              <tr @if($val->debit > 0) style="color:red;" @else  @endif>
                                <td>{{ date('d-m-Y', strtotime($val->date)) }}</td>
                                <td>{{ $val->invoice_no }}</td>
                                <td>{{$val->wirehouse_name ?? $val->warehouse_bank_name}}</td>
                                <td>{{$val->transport_vehicle}}</td>
                                <td>{{$product->product_name ?? ''}}</td>
                                <td>{{$val->quantity}} {{$product->unit->unit_name ?? ''}}</td>
                                <td>{{$val->rate}}</td>
                                <td>{{ number_format($val->total_value,2)}}</td>
                                <td>{{ number_format($val->transport_fare,2)}}</td>
                                <td align="right">{{ number_format($val->debit,2) }}</td>
                                <td align="right">{{ number_format($val->total_value,2)}}</td>
                                <td align="right">{{ number_format($balance,2)}}</td>
                              </tr>
                              @endforeach
                              <tr class="table_sub_total">
                                <td><strong>Sub Total: </strong></td>
                                <td colspan="4"></td>
                                <td>{{ number_format($subQty,2)}}</td>
                                <td></td>
                                <td>{{ number_format($subTotalValue,2)}}</td>
                                <td>{{ number_format($subTransFare,2)}}</td>
                                <td align="right">{{ number_format($subDebit,2)}}</td>
                                <td align="right">{{ number_format($subCredit,2)}}</td>
                                <td align="right">{{ number_format($balance,2)}}</td>
                              </tr>
                            @endforeach
                            @endif
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr class="table_grand_total">
                          <td><strong>Grand Total: </strong> </td>
                          <td colspan="4"></td>
                          <td>{{ number_format($gQty,2)}}</td>
                          <td></td>
                          <td>{{ number_format($gTotalValue,2)}}</td>
                          <td>{{ number_format($gTransFare,2)}}</td>
                          <td align="right">{{ number_format($gDebit,2)}}</td>
                          <td align="right">{{ number_format($gCredit,2)}}</td>
                          <td align="right">{{ number_format($Gbalance,2)}}</td>
                        </tr>
                        </tfoot>
                    </table>
                    @else
                    <h1>Data Not Found</h1>
                    @endif
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
                style: ' @page  { size: A4 landscape; height:100%; width:100%; } .print_heading_info{min-width:100% !important; display:block;}  .table-responsive{min-width:100% !important; min-height:100% !important; display:block;} .table{min-width:100% !important; min-height:100% !important; display:block;} #contentbody{height:100%; width:100%;}  table, th, td {border: 1px solid black; font-size:16px!important; border-collapse: collapse; padding: 0px 3px;min-width:100%;} h3{margin: 0!important;padding: 0 !important; text-align:center;} h5{margin: 0!important;padding: 0 !important; text-align:center;} p{margin: 0!important;padding: 0 !important; text-align:center;} h6{margin: 0!important;padding: 0 !important; text-align:center;} .cominfo{text-align:center;margin-left:12rem;} .pageinfo{text-align:center;margin-left:12rem;margin-bottom:2rem;padding: 0 !important;} .dt-buttons{display:none !important;} .dataTables_filter{display:none !important;} .dataTables_paginate{display:none !important;} .dataTables_info{display:none !important;}'
              })

        }
</script>



<script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#datatablecustom").table2excel({
                filename: "FG-PurchaseLedger.xls"
            });
        });
    });
</script>

@endsection
