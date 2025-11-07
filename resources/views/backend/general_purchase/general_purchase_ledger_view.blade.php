@extends('layouts.purchase_deshboard')

@push('addcss')
    <style>

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
                      <button class="btn btn-sm  btn-success mt-1" id="btnExport">
                       Export
                    </button>
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
              		<button class="btn btn-sm btn-info mt-1"  onclick="printland()"><i class="fa fa-print" aria-hidden="true"> </i> Landscape</button>
                    </div>
                </div>

        <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh" id="contentbody">
            <div class="py-4">

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">General Purchase Ledger</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>



                <table id="datatablecustom" class="table table-bordered table-striped mt-4" style="font-size: 15px;">
                    <thead>
                        <tr class="text-center">
                            <th>Date</th>
                            <th>Inv No</th>
                            <th>Wirehouse</th>
                            <th>Product</th>
                            <th>Qty </th>
                            <th>Rate</th>
                            <th>Value</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>
                        </tr>
                    </thead>

                    <tbody style="font-size: 14px;">
						@php
                             $totalbalance = 0;
                        @endphp
                        @foreach ($generalpurchase as $sup)
                            @php
                                $supplierdata = DB::table('general_suppliers')
                                ->where('id',$sup->supplier_id)
                                ->first();
                            @endphp
                            <tr style="background: aquamarine;">
                                <td colspan="9">{{ $supplierdata->supplier_name }}</td>
                                <td class="text-right">{{ $supplierdata->opening_balance }}</td>
                            </tr>
                            @php
                                $generalpurchase = DB::table('general_purchase_supplier_ledgers')
                      			->select('invoice_no')
                                ->where('supplier_id',$sup->supplier_id)
                                ->whereBetween('date', [$fdate, $tdate])
                      			->groupBy('invoice_no')
                                ->get();
                      			$balance = $supplierdata->opening_balance;
                            @endphp

                            @foreach ($generalpurchase as $item)
                      			@php
                                    $inv = DB::table('general_purchase_supplier_ledgers')
                                      ->where('invoice_no',$item->invoice_no)
                                      ->first();
                            	@endphp

                      			@if($inv->warehouse_bank_id == null)

                      			@php
                                  $purchasedata = DB::table('general_purchases')
                      				->select('general_purchases.*','general_wirehouses.wirehouse_name','general_products.gproduct_name')
                                    ->leftJoin('general_wirehouses','general_wirehouses.wirehouse_id','general_purchases.warehouse_id')
                                    ->leftJoin('general_products','general_products.id','general_purchases.product_id')
                                    ->where('invoice_no',$item->invoice_no)
                                    ->get();
                      				$pqntty = 0;
                      				$totaldebit = 0;
                            	@endphp

                      			 @foreach ($purchasedata as $pdata)
                      				@php
                                     	$pqntty += $pdata->quantity;
                      					$totaldebit += $pdata->total_value;
                                    @endphp
                                  <tr>
                                      <td class="text-center">{{ date('d M, Y', strtotime($pdata->date)) }}</td>
                                      <td class="text-center">{{ $pdata->invoice_no }}</td>
                                      <td>{{$pdata->wirehouse_name}}</td>
                                      <td>{{$pdata->gproduct_name}}</td>
                                      <td class="text-right">{{$pdata->quantity}}</td>
                                      <td class="text-right">{{number_format($pdata->rate)}}</td>
                                      <td class="text-right">{{number_format($pdata->total_value)}}</td>
                                      <td class="text-right">{{number_format($pdata->total_value)}}</td>
                                      <td class="text-center">-</td>
                                      <td class="text-right">{{number_format($balance)}}</td>
                                  </tr>
                                @endforeach
                      				@php
                                     	$balance +=$totaldebit;
                                    @endphp
                      			 <tr style="background: beige;">
                                   <th class="text-center">{{  date('d M, Y', strtotime($item->invoice_no)) }}</th>
                                   <th class="text-center">{{ $item->invoice_no }}</th>
                                   <th class="text-center">-</th>
                                   <th class="text-center">-</th>
                                   <th class="text-right">{{number_format($pqntty)}}</th>
                                   <th class="text-center">-</th>
                                   <th class="text-center">-</th>
                                   <th class="text-right">{{number_format($totaldebit)}}</th>
                                   <th class="text-center">-</th>
                                   <th class="text-right ">{{number_format($balance)}}</th>
                            	</tr>
                      			@else
                      				@php
                                     	$balance -=$inv->credit;
                                    @endphp
                      			 <tr style="background: burlywood;">
                                   <th class="text-center">{{  date('d M, Y', strtotime($inv->date)) }}</th>
                                   <th class="text-center">{{ $item->invoice_no }}</th>
                                   <th class="text-left">{{$inv->warehouse_bank_name}}</th>
                                   <th class="text-center">-</th>
                                   <th class="text-center">-</th>
                                   <th class="text-center">-</th>
                                   <th class="text-center">-</th>
                                   <th class="text-center">-</th>
                                   <th class="text-right">{{number_format($inv->credit)}}</th>
                                   <th class="text-center">-</th>
                            	</tr>
                      			@endif

                            @endforeach
							@php
                             $totalbalance += $balance;
                        	@endphp
                        @endforeach
                      <tr style="background: chocolate;">
                                <td colspan="9">Grand Total</td>
                                <td class="text-right">{{ number_format($totalbalance) }}</td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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
                  style: ' @page  { size: A4 landscape; max-height:100%; max-width:100% !important;} table, th, td {border: 1px solid black; font-size:16px!important; border-collapse: collapse; padding: 0px 3px} h3{margin: 0!important;padding: 0 !important; text-align:center;} h5{margin: 0!important;padding: 0 !important; text-align:center;} p{margin: 0!important;padding: 0 !important; text-align:center;} h6{margin: 0!important;padding: 0 !important; text-align:center;} .cominfo{text-align:center;} .pageinfo{text-align:center;margin-bottom:2rem;padding: 0 !important;} .dt-buttons{display:none !important;} .dataTables_filter{display:none !important;} .dataTables_paginate{display:none !important;} .dataTables_info{display:none !important;}'
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
