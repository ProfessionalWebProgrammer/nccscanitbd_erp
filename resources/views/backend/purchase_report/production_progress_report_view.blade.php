@extends('layouts.purchase_deshboard')


@section('print_menu')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >


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
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh" id="contentbody">

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>

                <div class="py-4 table-responsive">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Product Name</th>

                              @foreach($period as $months)
                                  <th>{{$months->format("F")}} Standard (Rate)</th>
                               <th>Actual (Rate)</th>
                              <th>Difference (Rate)</th>
                              <th>Value (BDT)</th>
                             @endforeach
                              	<th>Stock Out (Standard)(Rate)</th>
                              <th>Stock Out (Actual)(Rate)</th>
                            </tr>
                        </thead>

                        <tbody>
						@foreach ($fgProducts as $val)
                          <tr>
                            <td colspan="100%" align="left">Finish Goods Product Name: {{$val->product_name}}</td>
                          </tr>
                          @php
                          $data = DB::table('purchase_stockouts')
                            ->select('product_id',DB::raw('SUM(stock_out_quantity) AS totalqntty'),DB::raw('SUM(previous_stock_out_quantity) AS preTotalQty'),'purchase_stockouts.stock_out_rate','row_materials_products.product_name')
                            ->leftJoin('row_materials_products','row_materials_products.id','purchase_stockouts.product_id')->where('purchase_stockouts.finish_goods_id', $val->id)
                            ->whereBetween('date', [$fdate, $tdate])
                            ->groupby('purchase_stockouts.product_id')
                            ->orderBy('totalqntty','desc')
                            ->get();

                          $packingDetails = \App\Models\PackingConsumptions::select('bag_id',DB::raw('SUM(qty) AS totalqntty'),DB::raw('SUM(pre_qty) AS preTotalQty'),'packing_consumptions.rate','row_materials_products.product_name')
                                        ->leftJoin('row_materials_products','row_materials_products.id','packing_consumptions.bag_id')
                                        ->where('packing_consumptions.product_id', $val->id)
                                        ->whereBetween('date', [$fdate, $tdate])
                                        ->groupby('packing_consumptions.product_id')
                                        ->orderBy('totalqntty','desc')
                                        ->get();
                              $stsndardSubTotal = 0;
                              $actualSubTotal = 0;
                           	  $difference = 0;
                          	  $differenceValue = 0;
                          	  $differenceValueBag = 0;
                              $rate = 0;
                              @endphp

                           @foreach($data as $item)
                          	<tr>
                          		<td>{{$item->product_name}}</td>
                              @php
                               $rate = $item->stock_out_rate;
                              @endphp
                                @foreach($period as $months)
                              		@php
                              			$qtr_end_date = date('Y-m-t', strtotime($months));
                              			$mothvalue = DB::table('purchase_stockouts')->select(DB::raw('SUM(stock_out_quantity) AS qty'),DB::raw('SUM(previous_stock_out_quantity) AS preQty'))
                              						->whereBetween('date', [$months, $qtr_end_date])
                              						->where('product_id',$item->product_id)->where('finish_goods_id', $val->id)
                              						->first();
                              			if(!empty($mothvalue->preQty)){
                              			$stsndardSubTotal += $mothvalue->preQty;
                              			} else {
                              				$stsndardSubTotal = 0;
                              			}

                              			$actualSubTotal += $mothvalue->qty;
                              			if(!empty($mothvalue->preQty)){
                              				if($mothvalue->qty - $mothvalue->preQty > .001){
                                          $difference += $mothvalue->qty - $mothvalue->preQty;
                                          $differenceValue +=($mothvalue->qty - $mothvalue->preQty)*$item->stock_out_rate;
                                          }
                              		} else {
                              		$difference = 0;
                              		$differenceValue = 0;
                              	}

                              	@endphp
                              @if($mothvalue->preQty > 0)
                          			 <td class="text-right"><span style="font-weight:700;">{{number_format($mothvalue->preQty,2)}} @if(!empty($item->stock_out_rate))<span style="color:blue;">({{number_format($item->stock_out_rate,2)}})</span> @endif</span></td>
                              @else
                              {{-- <td class="text-right"><span style="font-weight:700;">{{number_format($mothvalue->qty,2)}} @if(!empty($item->stock_out_rate))<span style="color:blue;">({{number_format($item->stock_out_rate,2)}})</span> @endif</span></td> --}}
                              <td class="text-right">00.00 </td>
                              @endif
                              @if($mothvalue->preQty > 0)
                                       <td class="text-right">@if($mothvalue->qty - $mothvalue->preQty > .001) <span style="color:red; font-weight:700;"> {{number_format($mothvalue->qty,2)}} @if(!empty($item->stock_out_rate))<span style="color:blue;">({{number_format($item->stock_out_rate,2)}})</span> @endif  @else  <span style="color:green; font-weight:700;"> {{number_format($mothvalue->qty,2)}} <span style="color:blue;">({{number_format($item->stock_out_rate,2)}})</span> @endif </span></td>
                              @else
                                  {{-- <td class="text-right"><span style="color:green; font-weight:700;"> {{number_format($mothvalue->qty,2)}} <span style="color:blue;">({{number_format($item->stock_out_rate,2)}})</span></span></td> --}}
                                  <td class="text-right">00.00 </td>
                              @endif
                              @if($mothvalue->preQty > 0)
                              		   <td class="text-right">@if($mothvalue->qty - $mothvalue->preQty > .001)<span style="color:red; font-weight:700;">{{number_format(($mothvalue->qty - $mothvalue->preQty),2)}} @if(!empty($item->stock_out_rate))<span style="color:blue;">({{number_format($item->stock_out_rate,2)}})</span>  @endif </span> @endif</td>
                              @else
                              <td class="text-right">00.00 </td>
                              @endif

                              @if($mothvalue->preQty > 0)
                              		   <td class="text-right">@if($mothvalue->qty - $mothvalue->preQty > .001)<span style="color:red; font-weight:700;">{{number_format(($mothvalue->qty - $mothvalue->preQty)*$item->stock_out_rate,2)}} </span> @endif</td>
							                @else
                              <td class="text-right">00.00</td>
                              @endif

                                @endforeach
                              @if($item->preTotalQty > 0)
                          		<td class="text-right">{{number_format($item->preTotalQty,2)}} @if(!empty($item->stock_out_rate))<span style="color:blue;">({{number_format($item->stock_out_rate,2)}})</span> @endif</td>
                              @else
                              	<td class="text-right">00.00</td>
                              @endif

                              <td class="text-right">{{number_format($item->totalqntty,2)}} @if(!empty($item->stock_out_rate))<span style="color:blue;">({{number_format($item->stock_out_rate,2)}})</span> @endif</td>
                              {{-- <td class="text-right">@if($item->totalqntty > $item->preTotalQty)<span style="color:red; font-size:18px; font-weight:800;"> {{number_format($item->totalqntty,2)}} </span> @else <span style="color:green; font-size:18px; font-weight:800;"> {{number_format($mothvalue->qty,2)}} </span> @endif/ {{number_format($item->preTotalQty,2)}}</td> --}}
                            </tr>

                           @endforeach
                           @foreach($packingDetails as $item)
                          	<tr>
                          		<td>{{$item->product_name}}</td>
                              @php
                               $rate = $item->stock_out_rate;
                              @endphp
                                @foreach($period as $months)
                              		@php
                              			$qtr_end_date = date('Y-m-t', strtotime($months));
                              			$mothvalue = DB::table('packing_consumptions')->select(DB::raw('SUM(qty) AS qty'),DB::raw('SUM(pre_qty) AS preQty'))
                              						->whereBetween('date', [$months, $qtr_end_date])
                              						->where('bag_id',$item->bag_id)->where('product_id', $val->id)
                              						->first();
                              			/* if(!empty($mothvalue->preQty)){
                              			$stsndardSubTotal += $mothvalue->preQty;
                              			} else {
                              				$stsndardSubTotal = 0;
                              			}

                              			$actualSubTotal += $mothvalue->qty;
                                    */
                              			if(!empty($mothvalue->preQty)){
                              				if($mothvalue->qty - $mothvalue->preQty > .001){
                                          $differenceValueBag +=($mothvalue->qty - $mothvalue->preQty)*$item->rate;
                                          } else {
                              		$differenceValueBag = 0;
                              	}
                                }

                              	@endphp
                              @if($mothvalue->preQty > 0)
                          			 <td class="text-right"><span style="font-weight:700;">{{number_format($mothvalue->preQty,2)}} @if(!empty($item->rate))<span style="color:blue;">({{number_format($item->rate,2)}})</span> @endif</span></td>
                              @else
                              {{-- <td class="text-right"><span style="font-weight:700;">{{number_format($mothvalue->qty,2)}} @if(!empty($item->rate))<span style="color:blue;">({{number_format($item->rate,2)}})</span> @endif</span></td> --}}
                              <td class="text-right">00.00 </td>
                              @endif
                              @if($mothvalue->preQty > 0)
                                       <td class="text-right">@if($mothvalue->qty - $mothvalue->preQty > .001) <span style="color:red; font-weight:700;"> {{number_format($mothvalue->qty,2)}} @if(!empty($item->rate))<span style="color:blue;">({{number_format($item->rate,2)}})</span> @endif  @else  <span style="color:green; font-weight:700;"> {{number_format($mothvalue->qty,2)}} <span style="color:blue;">({{number_format($item->rate,2)}})</span> @endif </span></td>
                              @else
                                  {{-- <td class="text-right"><span style="color:green; font-weight:700;"> {{number_format($mothvalue->qty,2)}} <span style="color:blue;">({{number_format($item->rate,2)}})</span></span></td> --}}
                                  <td class="text-right">00.00 </td>
                              @endif
                              @if($mothvalue->preQty > 0)
                              		   <td class="text-right">@if($mothvalue->qty - $mothvalue->preQty > .001)<span style="color:red; font-weight:700;">{{number_format(($mothvalue->qty - $mothvalue->preQty),2)}} @if(!empty($item->rate))<span style="color:blue;">({{number_format($item->rate,2)}})</span>  @endif </span> @endif</td>
                              @else
                              <td class="text-right">00.00 </td>
                              @endif

                              @if($mothvalue->preQty > 0)
                              		   <td class="text-right">@if($mothvalue->qty - $mothvalue->preQty > .001)<span style="color:red; font-weight:700;">{{number_format(($mothvalue->qty - $mothvalue->preQty)*$item->rate,2)}} </span> @endif</td>
							                @else
                              <td class="text-right">00.00</td>
                              @endif

                                @endforeach
                              @if($item->preTotalQty > 0)
                          		<td class="text-right">{{number_format($item->preTotalQty,2)}} @if(!empty($item->rate))<span style="color:blue;">({{number_format($item->rate,2)}})</span> @endif</td>
                              @else
                              	<td class="text-right">00.00</td>
                              @endif

                              <td class="text-right">{{number_format($item->totalqntty,2)}} @if(!empty($item->rate))<span style="color:blue;">({{number_format($item->rate,2)}})</span> @endif</td>
                              {{-- <td class="text-right">@if($item->totalqntty > $item->preTotalQty)<span style="color:red; font-size:18px; font-weight:800;"> {{number_format($item->totalqntty,2)}} </span> @else <span style="color:green; font-size:18px; font-weight:800;"> {{number_format($mothvalue->qty,2)}} </span> @endif/ {{number_format($item->preTotalQty,2)}}</td> --}}
                            </tr>

                           @endforeach

                          <tr style="background:#e15717; color:#f2f2f2;">
                          	<td>Total:</td>
                            @foreach($period as $months)
                            <td class="text-right">{{number_format($stsndardSubTotal,2)}}</td>
                            <td class="text-right">{{number_format($actualSubTotal,2)}}</td>
                            <td class="text-right">{{number_format($difference,2)}}</td>
                            <td class="text-right">{{number_format(($differenceValue + $differenceValueBag),2)}}</td>
                            @endforeach
                            <td class="text-right">{{number_format($stsndardSubTotal,2)}}</td>
                            <td class="text-right">{{number_format($actualSubTotal,2)}}</td>
                          </tr>
						                    @endforeach

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
</script>

<script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#reporttable").table2excel({
                filename: "COGMReport.xls"
            });
        });
    });
</script>
@endsection
