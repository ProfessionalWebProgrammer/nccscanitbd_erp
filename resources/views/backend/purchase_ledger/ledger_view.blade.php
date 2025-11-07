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
         font-size:15px;
         font-weight:400;
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
      
      .table_sub_total th{
          font-size: 15px;
          color: #000;
          padding: 2px;
      }
      
      .table_sub_total th:nth-child(1){
          padding-left: 10px !important;
      }
      
      .table_sub_total th:last-child {
          padding-right: 10px !important;
      }
      
      .table_sub_total{
          padding-right: 10px !important;
          border-right: 1px solid #333;
          border-left: 1px solid #333;
      }
      
      .table_total th{
          font-size: 15px;
          color: #000;
          padding: 2px;
      }
      
      .table_total th:nth-child(1){
          padding-left: 10px !important;
      }
      
      .table_total th:last-child {
          padding-right: 10px !important;
      }
      
      .table_total{
          padding-right: 10px !important;
          border-right: 1px solid #333;
          border-left: 1px solid #333;
      }
      
      
      
      .table_grand_total th{
          font-size: 15px;
          color: #000;
          padding: 2px;
          border-top: 2px solid #333;
          border-bottom: 1px solid #333;
      }
      
      .table_grand_total th:nth-child(1){
          padding-left: 10px !important;
      }
      
      .table_grand_total th:last-child {
          padding-right: 10px !important;
      }
      
      .table_grand_total{
          padding-right: 10px !important;
          border-right: 1px solid #333;
          border-left: 1px solid #333;
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
						 {{-- <button class="btn btn-sm  btn-success mt-1" id="btnExport"  > Export  </button> --}}
                         <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  > Print </button>
                         <button class="btn btn-sm btn-info mt-1"  onclick="printland()"><i class="fa fa-print" aria-hidden="true"> </i> Landscape</button>
                  </div>
              </div>
            <div class="container-fluid mt-2" id="contentbody" style="min-width: 100% !important;">


              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Purchase Ledger</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  			<p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>

                <div class="py-4 table-responsive">
                    <table id="" class="table pl-3 pr-3">
                        <thead>
                            <tr>
                                @if($raw_materials_report_view_fields['report_view_field_date'] == 1)
                                    <th>Date</th>
                                @else
                                    <th></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_invoice'] == 1)
                                    <th>Invoice</th>
                                @else
                                    <th></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_warehouse_bank'] == 1)
                                    <th>Warehouse/Bank</th>
                                @else
                                    <th></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_vehicle'] == 1)
                                    <th>Vehicle</th>
                                @else
                                    <th></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_product'] == 1)
                                    <th>Product</th>
                                @else
                                    <th></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_chalan_qty'] == 1)
                                    <th class="text-right">Chalan Qty</th>
                                @else
                                    <th></th>
                                @endif
                                @if($raw_materials_report_view_fields['report_view_field_order_qty'] == 1)
                                    <th>Order Qty</th>
                                @else
                                    <th></th>
                                @endif
                                @if($raw_materials_report_view_fields['report_view_field_receive_qty'] == 1)
                                    <th>Receive Qty</th>
                                @else
                                    <th></th>
                                @endif
                                @if($raw_materials_report_view_fields['report_view_field_ded_qty'] == 1)
                                    <th>DED.Qty</th>
                                @else
                                    <th></th>
                                @endif
                                @if($raw_materials_report_view_fields['report_view_field_bill_qty'] == 1)
                                    <th>Bill Qty</th>
                                @else
                                    <th></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_rate'] == 1)
                                    <th>Rate</th>
                                @else
                                    <th></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_purchase_value'] == 1)
                                    <th>Purchase Value</th>
                                @else
                                    <th></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_tp_fare'] == 1)
                                    <th>TP Fare</th>
                                @else
                                    <th></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_debit'] == 1)
                                    <th style="text-align:right">Debit</th>
                                @else
                                    <th></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_credit'] == 1)
                                    <th style="text-align:right">Credit</th>
                                @else
                                    <th></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_balance_bdt'] == 1)
                                    <th style="text-align:right">Balance BDT</th>
                                @else
                                    <th></th>
                                @endif
                                

                               {{-- @foreach ($ledgerspurchase as $key => $wdata)
                                    @php
                                        $totalwq[$key] = 0;
                                        $stotalwq[$key] = 0;
                                        $gtotalwq[$key] = 0;
                                    @endphp
                                    <th>{{ $wdata->wirehouse_name }} [Ton]</th>
                                @endforeach
                              <th>IP-Raj</th> --}}
                              
                              @if($raw_materials_report_view_fields['report_view_field_total_ton'] == 1)
                                    <th style="text-align:right">Total Ton</th>
                                @else
                                    <th></th>
                                @endif
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                           @php
                                $gtotalc = 0;
                                $gtotald = 0;
                                $gtotalcb =  0;

                                $gtotalcq = 0;
                                $gtotaloq = 0;
                                $gtotalrq = 0;
                                $gtotaldq = 0;
                                $gtotalbq = 0;
                                $gtotalpv = 0;
                                $gtotaltf = 0;
                                $gtotalton = 0;

                                $gtotalpcsbq = 0;
                                $gtotalpcspv = 0;
                                $gtotalpcston = 0;
								$unit = 0;
								
								//print_r($raw_materials_report_view_fields);
                            @endphp

                          @foreach($supplier as $sgropub)
                          <tr>
                                <td colspan="100%">Group- {{$sgropub->group_name}} </td>

                            </tr>

                           @php
                                $totalc = 0;
                                $totald = 0;
                                $totalcb =  0;

                                $totalcq = 0;
                                $totaloq = 0;
                                $totalrq = 0;
                                $totaldq = 0;
                                $totalbq = 0;
                                $totalpv = 0;
                                $totaltf = 0;
                                $totalton = 0;

                                $totalpcsbq = 0;
                                $totalpcspv = 0;
                                $totalpcston = 0;
                                
                                
                            @endphp


                           @foreach($sgropub->suppliers as $sdata)

                            @php
                           $supop  = DB::table('purchase_ledgers as t1')->select('t1.supplier_id',
                                      DB::raw('sum(CASE WHEN t1.date BETWEEN   "'.$sdate.'" AND "'.$pdate.'" THEN `debit` ELSE null END) as debit'),
                                      DB::raw('sum(CASE WHEN t1.date BETWEEN   "'.$sdate.'" AND "'.$pdate.'" THEN `credit` ELSE null END) as credit'))
                                      ->where('supplier_id',$sdata->id)
                                      ->groupBy('supplier_id')
                                      ->first();

                            if($supop){
                                      $opbalance = $sdata->opening_balance-$supop->debit+$supop->credit;
						                        }else{
                                      $opbalance = $sdata->opening_balance;
                                    }
                            @endphp
                            <tr>
                                <td></td>
                                <td colspan="10"> {{$sdata->supplier_name}}</td>
                                  <td colspan="4"> Opening Balance</td>
                                  
                                @if($raw_materials_report_view_fields['report_view_field_balance_bdt'] == 1)
                                    <td style="text-align:right">{{  $opbalance }} @if ( $opbalance >= 0) (Cr) @else (Dr) @endif</td>
                                @else
                                    <td style="text-align:right"></td>
                                @endif
                                
                                {{-- @foreach ($ledgerspurchase as $wdata)
                                    <td style="text-align:right"></td>
                                @endforeach --}}
                                <td style="text-align:right"></td>
                            </tr>



                            @php
                                $ledger = DB::table('purchase_ledgers')
                                    ->select('purchase_ledgers.*', 'purchases.wirehouse_id')
                                    ->leftJoin('purchases', 'purchase_ledgers.purcahse_id', '=', 'purchases.purchase_id')
                                    ->where('purchase_ledgers.supplier_id', $sdata->id)
                                    ->whereBetween('purchase_ledgers.date', [$fdate, $tdate])
                                    ->orderBy('purchase_ledgers.date', 'asc')
                                    ->get();

                                $wname = '';
                                $stotalc = 0;
                                $stotald = 0;
                                $stotalcb = $opbalance;
                                $stotalcq = 0;
                                $stotaloq = 0;
                                $stotalrq = 0;
                                $stotaldq = 0;
                                $stotalbq = 0;
                                $stotalpv = 0;
                                $stotaltf = 0;
                                $stotalton = 0;

                                $stotalpcsbq = 0;
                                $stotalpcspv = 0;
                                $stotalpcston = 0;

                                $totalcb += $opbalance;

                            @endphp

                            @if(!empty($ledger))
                            @foreach ($ledger as $data)

                                    @php
                                    $invoice = substr($data->invoice_no, 0,3);
                                    if($invoice == 'FGP'){
                                    $purchase = '';
                                    } else {
                                      $purchase = DB::table('purchases')
                                          ->select('purchases.*', 'factories.factory_name as wirehouse_name', 'row_materials_products.product_name','row_materials_products.unit')
                                          ->leftJoin('factories', 'purchases.wirehouse_id', '=', 'factories.id')
                                          ->leftJoin('row_materials_products', 'purchases.product_id', '=', 'row_materials_products.id')
                                          ->where('purchase_id', $data->purcahse_id)->whereNotNull('wirehouse_id')->where('invoice','NOT LIKE','FGP%')
                                          ->first();
                                    }
                                    //dd($data->invoice_no);
                            //dd($purchase->bill_quantity);
                          	$purchaseBag = DB::table('purchases')
                                            ->where('purchase_id', $data->purcahse_id)
                                            ->value('purchas_unit');
                                    @endphp

                                 @if($purchase)

                                    @php
                                        $totalc += $data->credit;
                                        $totald += $data->debit;
                                        $totalcb += $data->credit - $data->debit;

                                        $stotalc += $data->credit;
                                        $stotald += $data->debit;
                                        $stotalcb += $data->credit - $data->debit;

										              $schalanqty = $purchase->supplier_chalan_qty ?? 0;
                          				$srecQty = $purchase->receive_quantity ?? 0;
                                      if($purchase->bill_quantity > 1){
                                      $bQty = $purchase->bill_quantity;
                                      } else {
                                      $bQty = 0;
                                      }

                                        $wname = $purchase->wirehouse_name ?? '';

                                        $totalcq += $purchase->supplier_chalan_qty ?? 0;
                                        $totaloq += $purchase->order_quantity ?? 0;
                                        $totalrq += ($srecQty > $schalanqty ) ? $schalanqty : $srecQty;
                                        $totaldq += $purchase->deduction_quantity ?? 0;
                                        $totalbq += $purchase->bill_quantity ?? 0;
                                        // $totalpv += $purchase->purchase_rate ?? 0 * $bQty;
                                        $totalpv += $data->credit;
                                        $totaltf += $purchase->transport_fare ?? 0;

                          if($bQty > 0) {$totalton += $bQty/ 1000;}

                          				$stotalcq += $purchase->supplier_chalan_qty ?? 0;
                                        $stotaloq += $purchase->order_quantity ?? 0;
                                        $stotalrq += ($srecQty > $schalanqty ) ? $schalanqty : $srecQty;
                                        $stotaldq += $purchase->deduction_quantity ?? 0;
                                        $stotalbq += $purchase->bill_quantity ?? 0;
                                        $stotalpv += $data->credit;
                                        $stotaltf += $purchase->transport_fare ?? 0;
                                        if($bQty > 0) {
                                          $stotalton += $bQty/ 1000;
                                        }
                          				$unit = $purchase->unit;

                                    @endphp
                                    <tr>
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_date'] == 1)
                                            <td>{{ date('d-m-Y', strtotime($data->date)) }}</td>
                                        @else
                                            <td></td>
                                        @endif
                                
                                        {{-- @if ($purchase->purchas_unit ?? '' == 'bag') (Bag) @endif --}}
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_invoice'] == 1)
                                            <td><a style=" color: #333 !important;" href={{ url('showpurchasedetails', $data->purcahse_id) }}>{{ $data->invoice_no }}</a></td>
                                        @else
                                            <td></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_warehouse_bank'] == 1)
                                            <td class="wirehouse_name hidden">{{ $purchase->wirehouse_name ?? ''}}  <br> {{$purchase->reference ?? ''}} </td>
                                        @else
                                            <td></td>
                                        @endif
                                        
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_vehicle'] == 1)
                                            <td class="transport_vehicle hidden">{{ $purchase->transport_vehicle ?? '' }}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_product'] == 1)
                                            <td class="product hidden">{{ $purchase->product_name ?? ''}}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        
                                        
                                        @if($data->ledger_id != 1)
                                            @if($raw_materials_report_view_fields['report_view_field_chalan_qty'] == 1)
                                                <td class="chalan_qty hidden" style="text-align:right">{{ $purchase->supplier_chalan_qty ?? 0}} @if($purchase->supplier_chalan_qty > 0 ){{$purchase->unit}} @else  @endif </td>
                                            @else
                                                <td class="chalan_qty hidden" style="text-align:right"></td>
                                            @endif
                                            
                                            @if($raw_materials_report_view_fields['report_view_field_order_qty'] == 1)
                                                <td class="order_qty hidden" style="text-align:right">{{ $purchase->order_quantity ?? 0 }}  @if($purchase->order_quantity > 0 ){{$purchase->unit}} @else  @endif </td>
                                            @else
                                                <td class="order_qty hidden" style="text-align:right"></td>
                                            @endif
                                            
                                            @if($raw_materials_report_view_fields['report_view_field_receive_qty'] == 1)
                                                <td class="receive_qty hidden" style="text-align:right">
                                                    @if ($srecQty > $schalanqty)
                                                       {{ $schalanqty}} {{$purchase->unit}}
                                               		@else
                                                        {{ $srecQty }} {{$purchase->unit}}
                                          			@endif
                                      			</td>
                                            @else
                                                <td class="receive_qty hidden" style="text-align:right"></td>
                                            @endif
                                            
                                            @if($raw_materials_report_view_fields['report_view_field_ded_qty'] == 1)
                                                <td class="deduction_qty hidden" style="text-align:right"> {{ number_format($purchase->deduction_quantity ?? 0, 2) }} @if($purchase->deduction_quantity > 0 ){{$purchase->unit}} @else  @endif</td>
                                            @else
                                                <td class="deduction_qty hidden" style="text-align:right"></td>
                                            @endif
                                            
                                            @if($raw_materials_report_view_fields['report_view_field_bill_qty'] == 1)
                                                <td class="bill_qty hidden" style="text-align:right">{{ number_format($purchase->bill_quantity ?? 0, 2) }} @if($purchase->bill_quantity > 0 ){{$purchase->unit}} @else  @endif</td>
                                            @else
                                                <td class="bill_qty hidden" style="text-align:right"></td>
                                            @endif
                                            
                                            @if($raw_materials_report_view_fields['report_view_field_rate'] == 1)
                                                <td class="purchase_rate hidden" style="text-align:right">{{ $purchase->rate ?? 0 }}</td>
                                            @else
                                                <td class="purchase_rate hidden" style="text-align:right"></td>
                                            @endif
                                        @else
                                            <td colspan="6"></td>
                                        @endif
                                        
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_purchase_value'] == 1)
                                            <td class="purchase_value hidden" style="text-align:right">{{ number_format($data->credit, 2) }}</td>
                                        @else
                                            <td class="purchase_value hidden" style="text-align:right"></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_tp_fare'] == 1)
                                            <td class="transport_fare hidden" style="text-align:right">{{ number_format($purchase->transport_fare ?? 0,2) }}</td>
                                        @else
                                            <td class="transport_fare hidden" style="text-align:right"></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_debit'] == 1)
                                            <td class="debit hidden" style="text-align:right">{{ number_format($data->debit, 2) }}</td>
                                        @else
                                            <td class="debit hidden" style="text-align:right"></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_credit'] == 1)
                                            <td class="credit hidden" style="text-align:right">{{ number_format($data->credit, 2) }}</td>
                                        @else
                                            <td class="credit hidden" style="text-align:right"></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_balance_bdt'] == 1)
                                            <td style="text-align:right">{{ number_format($stotalcb, 2) }}@if ($stotalcb >= 0) (Cr) @else (Dr) @endif</td>
                                        @else
                                            <td style="text-align:right"></td>
                                        @endif
                                        

                                       {{-- @foreach ($ledgerspurchase as $key => $wdata)
                                            @php
                                                if ($wdata->wirehouse_id == $purchase->wirehouse_id && $bQty > 0) {
                                                    $totalwq[$key] += $bQty / 1000;
                                                    $stotalwq[$key] += $bQty / 1000;
                                                    $gtotalwq[$key] += $bQty / 1000;
                                                }
                                            @endphp
                                            <td style="text-align:right">@if ($wdata->wirehouse_id == $purchase->wirehouse_id){{ number_format($purchase->bill_quantity / 1000, 2) }} @else 0 @endif</td>
                                        @endforeach --}}
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_total_ton'] == 1)
                                            <td style="text-align:right">{{ number_format($purchase->bill_quantity / 1000, 2) }}</td>
                                        @else
                                            <td style="text-align:right"></td>
                                        @endif
                                        
                                    </tr>
                                @else
                                    @php
                                        if ($data->payment_id != null) {
                                           /* $payment_namea = DB::select(
                                                'SELECT master_banks.bank_name,master_cashes.wirehouse_name FROM `payments`
                                                                                                                                                   WHERE payments.id = "' .
                                                    $data->payment_id .
                                                    '" ',
                                            ); */
                                        }
                                        $return = '';

                                        if ($data->return_id != null) {
                                            $return = DB::table('purchase_returns')->select('purchase_returns.*','factories.factory_name as wirehouse_name', 'row_materials_products.product_name','row_materials_products.unit')
                                                ->leftJoin('factories', 'purchase_returns.wirehouse_id', '=', 'factories.id')
                                                ->leftJoin('row_materials_products', 'purchase_returns.product_id', '=', 'row_materials_products.id')
                                                ->where('purchase_returns.id', $data->return_id)
                                                ->first();

                                            if ($return != '') {
                                                $totalbq -= $return->return_quantity;
                                                $totalpv += $return->return_quantity * $return->return_rate;
                                                $totaltf += $return->transport_fare;

                            					$stotalbq -= $return->return_quantity;
                                                $stotalpv += $return->return_quantity * $return->return_rate;
                                                $stotaltf += $return->transport_fare;
                                            }
                                        }

                                        $totalc += $data->credit;
                                        $totald += $data->debit;
                                        $totalcb += $data->credit - $data->debit;

                           				$stotalc += $data->credit;
                                        $stotald += $data->debit;
                                        $stotalcb += $data->credit - $data->debit;

                                    @endphp
                                    <tr>
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_date'] == 1)
                                            <td>{{ date('d-m-Y', strtotime($data->date)) }}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_invoice'] == 1)
                                            <td>{{ $data->invoice_no }}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_warehouse_bank'] == 1)
                                            <td class="wirehouse_name hidden">@if ($return != ''){{ $return->wirehouse_name }} @else {{ $data->warehouse_bank_name }}  @endif <br> {{$data->narration ?? ''}} </td>
                                        @else
                                            <td class="wirehouse_name hidden"></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_vehicle'] == 1)
                                            <td class="transport_vehicle hidden">@if ($return != ''){{ $return->vehicle_no }} @else - @endif</td>
                                        @else
                                            <td class="transport_vehicle hidden"></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_product'] == 1)
                                            <td class="product hidden">@if ($return != ''){{ $return->product_name }} @else - @endif</td>
                                        @else
                                            <td class="product hidden"></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_chalan_qty'] == 1)
                                            <td class="chalan_qty hidden">-</td>
                                        @else
                                            <td class="chalan_qty hidden"></td>
                                        @endif
                                        @if($raw_materials_report_view_fields['report_view_field_order_qty'] == 1)
                                            <td class="order_qty hidden">-</td>
                                        @else
                                            <td class="chalan_qty hidden"></td>
                                        @endif
                                        @if($raw_materials_report_view_fields['report_view_field_receive_qty'] == 1)
                                            <td class="receive_qty hidden">-</td>
                                        @else
                                            <td class="chalan_qty hidden"></td>
                                        @endif
                                        @if($raw_materials_report_view_fields['report_view_field_ded_qty'] == 1)
                                            <td class="deduction_qty hidden">-</td>
                                        @else
                                            <td class="chalan_qty hidden"></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_bill_qty'] == 1)
                                            <td class="bill_qty hidden" style="text-align:right">@if ($return != ''){{ $return->return_quantity }} {{$return->unit}} @else - @endif</td>
                                        @else
                                            <td></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_rate'] == 1)
                                            <td class="purchase_rate hidden" style="text-align:right">@if ($return != ''){{ $return->return_rate }} @else - @endif</td>
                                        @else
                                            <td></td>
                                        @endif
                                        
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_purchase_value'] == 1)
                                            <td class="purchase_value hidden" style="text-align:right">@if ($return != ''){{ $return->return_rate * $return->return_quantity }} @else - @endif</td>
                                        @else
                                            <td class="purchase_value hidden" style="text-align:right"></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_tp_fare'] == 1)
                                            <td class="transport_fare hidden" style="text-align:right">@if ($return != ''){{ $return->transport_fare }} @else - @endif</td>
                                        @else
                                            <td class="transport_fare hidden" style="text-align:right"></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_debit'] == 1)
                                            <td class="debit hidden" style="text-align:right">{{ number_format($data->debit) }}</td>
                                        @else
                                            <td class="debit hidden" style="text-align:right"></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_credit'] == 1)
                                            <td class="credit hidden" style="text-align:right">{{ number_format($data->credit) }}</td>
                                        @else
                                            <td class="credit hidden" style="text-align:right"></td>
                                        @endif
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_balance_bdt'] == 1)
                                            <td style="text-align:right">{{ number_format($stotalcb, 2) }} @if ($stotalcb >= 0) (Cr) @else (Dr) @endif</td>
                                        @else
                                            <td style="text-align:right"></td>
                                        @endif
                                        
                                        {{-- @foreach ($ledgerspurchase as $wdata)
                                        <td style="text-align:right">0</td>
                                        @endforeach --}}
                                        
                                        @if($raw_materials_report_view_fields['report_view_field_total_ton'] == 1)
                                            <td style="text-align:right">0</td>
                                        @else
                                            <td style="text-align:right"></td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach



                    @if($sgropub->suppliers_count >1)


                            <tr class="table_sub_total">
                                <th colspan="5"> Sub Total</th>
                                {{-- <th></th>
                                <th class="wirehouse_name" ></th>
                                <th class="transport_vehicle " ></th>
                                <th class="product " ></th> --}}
                                
                                @if($raw_materials_report_view_fields['report_view_field_chalan_qty'] == 1)
                                    <th class="chalan_qty"  style="text-align:right">{{$stotalcq}} </th>
                                @else
                                    <th class="chalan_qty" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_order_qty'] == 1)
                                    <th class="order_qty hidden"  style="text-align:right">{{$stotaloq}} </th>
                                @else
                                    <th class="order_qty hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_receive_qty'] == 1)
                                    <th class="receive_qty hidden"  style="text-align:right">{{$stotalrq}} </th>
                                @else
                                    <th class="receive_qty hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_ded_qty'] == 1)
                                    <th class="deduction_qty hidden"  style="text-align:right">{{$stotaldq}} </th>
                                @else
                                    <th class="deduction_qty hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_bill_qty'] == 1)
                                    <th  class="bill_qty hidden" style="text-align:right">{{number_format($stotalbq,2)}}  <br> @if($stotalpcsbq != 0){{number_format($stotalpcsbq,2)}} PCS @endif</th>
                                @else
                                    <th class="bill_qty hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_rate'] == 1)
                                    <th class="purchase_rate hidden" ></th>
                                @else
                                    <th class="purchase_rate hidden" ></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_purchase_value'] == 1)
                                    <th class="purchase_value hidden"  style="text-align:right">{{number_format($stotalpv,2)}}</th>
                                @else
                                    <th class="purchase_value hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_tp_fare'] == 1)
                                    <th class="transport_fare hidden"  style="text-align:right">{{number_format($stotaltf,2)}}</th>
                                @else
                                    <th class="transport_fare hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_debit'] == 1)
                                    <th  class="debit hidden" style="text-align:right">{{number_format($stotald,2)}}</th>
                                @else
                                    <th class="debit hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_credit'] == 1)
                                    <th  class="credit hidden" style="text-align:right">{{number_format($stotalc,2)}}</th>
                                @else
                                    <th class="credit hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_balance_bdt'] == 1)
                                    <th style="text-align:right">{{number_format($stotalcb,2)}} @if($stotalcb >= 0) (Cr) @else (Dr) @endif</th>
                                @else
                                    <th style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_total_ton'] == 1)
                                    <th style="text-align:right">{{number_format($stotalton+$stotalpcston,2)}}</th>
                                @else
                                    <th style="text-align:right"></th>
                                @endif
                                
                            </tr>
                                                    @endif

                                                    @endif
                       @endforeach


                          <!--<tr> <td colspan="100%"></td></tr>-->
                             <tr class="table_total">
                                <th colspan="5"> Total</th>
                                
                                @if($raw_materials_report_view_fields['report_view_field_chalan_qty'] == 1)
                                    <th class="chalan_qty hidden"  style="text-align:right">{{$totalcq}} </th>
                                @else
                                    <th class="chalan_qty hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_order_qty'] == 1)
                                    <th class="order_qty hidden"  style="text-align:right">{{$totaloq}} </th>
                                @else
                                    <th class="order_qty hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_receive_qty'] == 1)
                                    <th class="receive_qty hidden"  style="text-align:right">{{$totalrq}} </th>
                                @else
                                    <th class="receive_qty hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_ded_qty'] == 1)
                                    <th class="deduction_qty hidden"  style="text-align:right">{{$totaldq}} </th>
                                @else
                                    <th class="deduction_qty hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_bill_qty'] == 1)
                                    <th  class="bill_qty hidden" style="text-align:right">{{number_format($totalbq,2)}}  <br> @if($totalpcsbq != 0){{number_format($totalpcsbq,2)}} PCS @endif</th>
                                @else
                                    <th class="bill_qty hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_rate'] == 1)
                                    <th class="purchase_rate hidden" ></th>
                                @else
                                    <th class="purchase_rate hidden" ></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_purchase_value'] == 1)
                                    <th class="purchase_value hidden"  style="text-align:right">{{number_format($totalpv+$totalpcspv,2)}}</th>
                                @else
                                    <th class="purchase_value hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_tp_fare'] == 1)
                                    <th class="transport_fare hidden"  style="text-align:right">{{number_format($totaltf,2)}}</th>
                                @else
                                    <th class="transport_fare hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_debit'] == 1)
                                    <th  class="debit hidden" style="text-align:right">{{number_format($totald,2)}}</th>
                                @else
                                    <th class="debit hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_credit'] == 1)
                                    <th  class="credit hidden" style="text-align:right">{{number_format($totalc,2)}}</th>
                                @else
                                    <th class="credit hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_balance_bdt'] == 1)
                                    <th style="text-align:right">{{number_format($totalcb,2)}} @if($totalcb >= 0) (Cr) @else (Dr) @endif</th>
                                @else
                                    <th style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_total_ton'] == 1)
                                    <th style="text-align:right">{{number_format($totalton+$totalpcston,2)}}</th>
                                @else
                                    <th style="text-align:right"></th>
                                @endif
                                
                            </tr>


                      </tbody>


                      @php
                                $gtotalc += $totalc;
                                $gtotald += $totald;
                                $gtotalcb +=  $totalcb;

                                $gtotalcq += $totalcq;
                                $gtotaloq += $totaloq;
                                $gtotalrq += $totalrq;
                                $gtotaldq += $totaldq;
                                $gtotalbq += $totalbq;
                                $gtotalpv += $totalpv;
                                $gtotaltf += $totaltf;
                                $gtotalton += $totalton;

                                $gtotalpcsbq += $totalpcsbq;
                                $gtotalpcspv += $totalpcspv;
                                $gtotalpcston += $totalpcston;

                            @endphp


                        @endforeach
                      @if($groupcount >1)
                      <tfoot>
                        <!--<tr> <td colspan="100%"></td></tr>-->
                        <!--<tr> <td colspan="100%"></td></tr>-->
                            <tr class="table_grand_total">
                                <th>Grand Total</th>
                                <th></th>
                                <th class="wirehouse_name hidden" ></th>
                                <th class="transport_vehicle hidden" ></th>
                                <th class="product hidden" ></th>
                                
                                @if($raw_materials_report_view_fields['report_view_field_chalan_qty'] == 1)
                                    <th class="chalan_qty hidden"  style="text-align:right">{{$gtotalcq}} </th>
                                @else
                                    <th class="chalan_qty hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_order_qty'] == 1)
                                    <th class="order_qty hidden"  style="text-align:right">{{$gtotaloq}} </th>
                                @else
                                    <th class="order_qty hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_receive_qty'] == 1)
                                    <th class="receive_qty hidden"  style="text-align:right">{{$gtotalrq}} </th>
                                @else
                                    <th class="receive_qty hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_ded_qty'] == 1)
                                    <th class="deduction_qty hidden"  style="text-align:right">{{$gtotaldq}} </th>
                                @else
                                    <th class="deduction_qty hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_bill_qty'] == 1)
                                    <th  class="bill_qty hidden" style="text-align:right">{{number_format($gtotalbq,2)}}   <br> @if($gtotalpcsbq != 0){{number_format($gtotalpcsbq,2)}} PCS @endif</th>
                                @else
                                    <th class="bill_qty hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_rate'] == 1)
                                    <th class="purchase_rate hidden" ></th>
                                @else
                                    <th class="purchase_rate hidden" ></th>
                                @endif
                                
                                
                                @if($raw_materials_report_view_fields['report_view_field_purchase_value'] == 1)
                                    <th class="purchase_value hidden"  style="text-align:right">{{number_format($gtotalpv+$gtotalpcspv,2)}}</th>
                                @else
                                    <th class="purchase_value hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_tp_fare'] == 1)
                                    <th class="transport_fare hidden"  style="text-align:right">{{number_format($gtotaltf,2)}}</th>
                                @else
                                    <th class="transport_fare hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_debit'] == 1)
                                    <th  class="debit hidden" style="text-align:right">{{number_format($gtotald,2)}}</th>
                                @else
                                    <th class="debit hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_credit'] == 1)
                                    <th  class="credit hidden" style="text-align:right">{{number_format($gtotalc,2)}}</th>
                                @else
                                    <th class="credit hidden" style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_balance_bdt'] == 1)
                                    <th style="text-align:right">{{number_format($gtotalcb,2)}} @if($gtotalcb >= 0) (Cr) @else (Dr) @endif</th>
                                @else
                                    <th style="text-align:right"></th>
                                @endif
                                
                                @if($raw_materials_report_view_fields['report_view_field_total_ton'] == 1)
                                    <th style="text-align:right">{{number_format($gtotalton+$gtotalpcston,2)}}</th>
                                @else
                                    <th style="text-align:right"></th>
                                @endif
                                
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
                style: ' @page  { size: A4 landscape; max-height:100% !important; max-width:100% !important; min-height:100% !important; min-width:100% !important} .table-responsive{min-width:100% !important; min-height:100% !important; display:block;} .table{min-width:100% !important; min-height:100% !important; display:block;} #contentbody{display:block; min-height:100% !important; min-width:100% !important; overflow:visible !important} table, th, td {border: 1px solid black; font-size:16px!important; border-collapse: collapse; padding: 0px 3px} h3{margin: 0!important;padding: 0 !important; text-align:center;} h5{margin: 0!important;padding: 0 !important; text-align:center;} p{margin: 0!important;padding: 0 !important; text-align:center;} h6{margin: 0!important;padding: 0 !important; text-align:center;} .cominfo{text-align:center;margin-left:12rem;} .pageinfo{text-align:center;margin-left:12rem;margin-bottom:2rem;padding: 0 !important;} .dt-buttons{display:none !important;} .dataTables_filter{display:none !important;} .dataTables_paginate{display:none !important;} .dataTables_info{display:none !important;}'
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
