@extends('layouts.purchase_deshboard')

@push('addcss')
    <style>
        .text_sale {
            color: #f7ee79;
        }

        .text_credit {
            color: lime;
        }
		.blink_me {
          animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
          50% {
            opacity: 0;
          }
        }
    </style>
@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">


              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Comparison Report View</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>




                    <table id="" class="table table-bordered table-striped mt-4" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>Date</th>
                                <th>Inv No</th>
                                <th>Supplier</th>
                                <th>Wirehouse</th>
                                <th>Product</th>
                                <th>Dimension </th>
                                <th>Qty </th>
                                <th>Rate </th>
                                <th>Av. Rate </th>
                                <th>Running Rate </th>
                              	<th>Previous Rate</th>
                              	<th>Pre Privious Rate</th>
                              	<th>Old Rate</th>
                                <th>Total Value</th>
                            </tr>
                        </thead>

                        <tbody style="font-size: 14px;">
                            @php
                                $gtotalqntty = 0;
                                $gtotalvalue = 0;
                            @endphp
                            @foreach ($reportdata as $item)
                                @php
                                    $invoicedetailes = DB::table('general_purchases')
                                        ->where('invoice_no', $item->invoice_no)
                                        ->first();
                                @endphp
                                {{-- <tr class="text-danger font-weight-bold" style="background: papayawhip">
                                    <td>{{ $invoicedetailes->date }}</td>
                                    <td>{{ $invoicedetailes->invoice_no }}</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr> --}}
                                @php
                                    if ($products !== null) {
                                        $reportdetailes = DB::table('general_purchases')
                                            ->select('general_purchases.*', 'general_products.gproduct_name','general_products.dimensions', 'general_suppliers.supplier_name', 'general_wirehouses.wirehouse_name')
                                            ->leftjoin('general_products', 'general_products.id', 'general_purchases.product_id')
                                            ->leftjoin('general_suppliers', 'general_suppliers.id', 'general_purchases.supplier_id')
                                            ->leftjoin('general_wirehouses', 'general_wirehouses.wirehouse_id', 'general_purchases.warehouse_id')
                                            ->where('general_purchases.invoice_no', $item->invoice_no)
                                            ->whereBetween('general_purchases.date', [$fdate, $tdate])
                                            ->whereIn('general_purchases.product_id', $products)
                                            ->get();
                                    } else {
                                        $reportdetailes = DB::table('general_purchases')
                                            ->select('general_purchases.*', 'general_products.gproduct_name','general_products.dimensions', 'general_suppliers.supplier_name', 'general_wirehouses.wirehouse_name')
                                            ->leftjoin('general_products', 'general_products.id', 'general_purchases.product_id')
                                            ->leftjoin('general_suppliers', 'general_suppliers.id', 'general_purchases.supplier_id')
                                            ->leftjoin('general_wirehouses', 'general_wirehouses.wirehouse_id', 'general_purchases.warehouse_id')
                                            ->where('general_purchases.invoice_no', $item->invoice_no)
                                            ->whereBetween('general_purchases.date', [$fdate, $tdate])
                                            ->get();
                                    }
                                @endphp
                                @php
                                    $totlqntty = 0;
                                    $totalvalue = 0;
                                @endphp
                                @foreach ($reportdetailes as $item)
                                    @php
                                        $totlqntty += $item->quantity;
                                        $totalvalue += $item->rate * $item->quantity;
                          				$oldrates = DB::table('general_purchases')
                          						  ->where('product_id',$item->product_id)
                          						  ->orderBy('created_at', 'DESC')
                          						  ->take(4)
                          						  ->get();
                          				$lastrate = DB::table('general_purchases')
                          						  ->where('product_id',$item->product_id)
                          						  ->orderBy('created_at', 'DESC')
                          						  ->take(2)
                          						  ->get();

                          				$ratesum = DB::table('general_purchases')
                          						  ->where('product_id',$item->product_id)
                          						  ->sum('rate');
                          				$ratecount = DB::table('general_purchases')
                          						  ->where('product_id',$item->product_id)
                          						  ->count('id');
                          				$avaragerate = $ratesum/$ratecount;
                          				$tpercent= ($avaragerate*15)/100;
                          				$count = count($lastrate);
                          				if($count == 2){
                          					$withtpercent = $lastrate[1]->rate + $tpercent;
                          				}


                                    @endphp
                                    <tr>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->invoice_no }}</td>
                                        <td>{{ $item->supplier_name }}</td>
                                        <td>{{ $item->wirehouse_name }}</td>
                                        <td>{{ $item->gproduct_name }}</td>
                                        <td>{{ $item->dimensions }}</td>
                                        <td class="text-right font-weight-bold">{{ number_format($item->quantity) }}</td>
                                        <td class="text-right font-weight-bold">{{ number_format($item->rate) }}
                                          @if($count ==2)
                                       		@if($item->rate >= $withtpercent )
                                            	</br>
                                                <span class="text-danger blink_me">(Abnormal Rate)</span>
                  							@endif
                                          @endif
                          				</td>
                                        <td class="text-right text-danger font-weight-bold">{{ number_format($avaragerate) }}</td>
                                      @php $loopcount = 0; @endphp
                                      @foreach ($oldrates as $rates)
                                       @php $loopcount ++; @endphp
                                      	<td class="text-right">{{ number_format($rates->rate) }}</td>
                                      @endforeach
                                      @if($loopcount <4 )
                                                  @for ( $loopcount; $loopcount < 4; $loopcount ++)
                                                      <td class="text-center">-</td>
                                                  @endfor
                                      @endif

                                        <td class="text-right font-weight-bold">
                                            {{ number_format($item->rate * $item->quantity) }}</td>
                                    </tr>
                                @endforeach
                                @php
                                    $gtotalqntty += $totlqntty;
                                    $gtotalvalue += $totalvalue;
                                @endphp
                                <tr class="font-weight-bold"
                                    style="color: #72199e; background: #ff00002e; font-size: 15px;">
                                    <td colspan="6" class="text-center">Total </td>
                                    <td class="text-right">{{ $totlqntty }}</td>
                                  	<td colspan="5">-</td>
                                    <td class="text-center">-</td>

                                    <td class="text-right font-weight-bold">{{ number_format($totalvalue) }}</td>
                                </tr>
                            @endforeach

                            <tr style="font-size: 16px; font-weight:bold">
                                <td class="text-center" colspan="6">GrandTotal</td>
                                <td class="text-right">{{ number_format($gtotalqntty) }}</td>
                                <td colspan="6" class="text-center">-</td>
                                <td class="text-right">{{ number_format($gtotalvalue) }}</td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
