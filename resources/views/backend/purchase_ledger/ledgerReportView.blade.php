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
         font-size:12px;
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
                  </div>
                <div class="col-md-6 text-right">

                         <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  > Print  </button>

                  </div>
              </div>
            <div class="container-fluid mt-2" id="contentbody" style="min-width: 100% !important;">


              <div class="row pt-2">
                <div class="col-md-3 pt-3">

                </div>
                  	<div class="col-md-3 pt-3 text-left">
                      <h5 class="text-uppercase font-weight-bold">Purchase Ledger</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  			<p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                    <div class="col-md-2 pt-3">

                    </div>
                </div>

                <div class="py-4 table-responsive">
                    <table id="" class="table table-bordered table-striped table-fixed  pl-3 pr-3"
                        style="font-size: 13px;color: #333 !important; font-weight: 400; font-family: inherit; width:50%; margin:0 auto;">
                        <thead>
                            <tr>
                                <th width="70%">Supplier Name</th>
                                <th width="30%" class="text-right">Balance BDT</th>
                            </tr>
                        </thead>
                        <tbody>
                           @php
                                $gtotalcb =  0;
                            @endphp

                          @foreach($supplier as $sgropub)

                           @php
                                $totalcb =  0;
                            @endphp

                           @foreach($sgropub->suppliers as $sdata)

                            @php
                           $supop  = DB::table('purchase_ledgers as t1')->select('t1.supplier_id',
                            DB::raw('sum(CASE WHEN t1.date BETWEEN   "'.$sdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
                            DB::raw('sum(CASE WHEN t1.date BETWEEN   "'.$sdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit'))
                            ->where('supplier_id',$sdata->id)
                            ->groupBy('supplier_id')
                            ->first();

                            if($supop){
                                      $opbalance = $sdata->opening_balance-$supop->debit+$supop->credit;
						                        }else{
                                      $opbalance = $sdata->opening_balance;
                                    }
                            @endphp


                            @php
                                $ledger = DB::table('purchase_ledgers')
                                    ->select('purchase_ledgers.*', 'purchases.wirehouse_id')
                                    ->leftJoin('purchases', 'purchase_ledgers.purcahse_id', '=', 'purchases.purchase_id')
                                    ->where('purchase_ledgers.supplier_id', $sdata->id)
                                    ->whereBetween('purchase_ledgers.date', [$fdate, $tdate])
                                    ->orderBy('purchase_ledgers.date', 'asc')
                                    ->get();


                                $stotalcb = $opbalance;


                                $totalcb += $opbalance;

                            @endphp

                            @if($stotalcb > 0)

                              <tr style="color:#333; padding-left:10px; padding-right: 10px; ">

                                  <th class="chalan_qty"  >{{$sdata->supplier_name}}</th>
                                  <th style="text-align:right">{{number_format($totalcb,2)}} @if($totalcb >= 0) (Cr) @else (Dr) @endif</th>
                              </tr>
                            @endif
                       @endforeach
                      </tbody>


                      @php
                        $gtotalcb +=  $totalcb;
                      @endphp

                        @endforeach
                      @if($groupcount >1)
                      <tfoot>
                            <tr style="color: rgb(10 10 10);">
                            <th>Grand Total</th>
                            <th style="text-align:right">{{number_format($gtotalcb,2)}} @if($gtotalcb >= 0) (Cr) @else (Dr) @endif</th>
                          </tr>
                        </tfoot>

                      @endif
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
                style: ' @page  { size: A4 landscape; max-height:100%; max-width:100%} table, th, td {border: 1px solid black; font-size:16px!important; border-collapse: collapse; padding: 0px 3px} h3{margin: 0!important;padding: 0 !important; text-align:center;} h5{margin: 0!important;padding: 0 !important; text-align:center;} p{margin: 0!important;padding: 0 !important; text-align:center;} h6{margin: 0!important;padding: 0 !important; text-align:center;} .cominfo{text-align:center;margin-left:12rem;} .pageinfo{text-align:center;margin-left:12rem;margin-bottom:2rem;padding: 0 !important;} .dt-buttons{display:none !important;} .dataTables_filter{display:none !important;} .dataTables_paginate{display:none !important;} .dataTables_info{display:none !important;}'
              })

        }
</script>

<script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#datatablecustom").table2excel({
                filename: "PurchaseLedger.xls"
            });
        });
    });
</script>

@endsection
