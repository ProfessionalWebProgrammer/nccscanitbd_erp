@extends('layouts.sales_dashboard')

@section('print_menu')

			<li class="nav-item">
                    <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                </li>
			<li class="nav-item ml-1">
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                </li>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="contentbody">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Various Vendor Report Report</h5>
                      <p>{{$month_name}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>





                <div class="py-4">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                            <thead style="border: 1px solid #515151;">

                            <tr class="table-header-fixt-top">
                                 <!-- <th>Mr</th> -->
                                 <th style=" font-weight: bold;">SI</th>
                                 <th style=" font-weight: bold;">Zone & Vendor</th>
                                 <th  style=" font-weight: bold;">Area Target</th>
                                 <th  style=" font-weight: bold;">Target</th>
                                 <th  style=" font-weight: bold;">Total Sale</th>
                                 <th  style=" font-weight: bold;">Total Achieve</th>
                                 <th  style=" font-weight: bold;">Total Amount</th>
                                 <th  style=" font-weight: bold;">Collection</th>
                                 <th  style=" font-weight: bold;">Present Credit</th>




                            </tr>
                            </thead>
                             @php


                                      $grandtotal_t = 0;
                                      $grandtotal_s = 0;
                                      $grandtotal_a = 0;
                                      $grandtotal_c = 0;
                                      $grandtotal_p = 0;
                                      $grandtotal_si = 0;
                                      $grandtotal_mt = 0;


                             @endphp

                            <tbody>


                             @foreach($zones as $zone)
                             @php
                             	$zoneterget= \App\Models\Lmcommisiontarget::where('employe_zone_id',$zone->dlr_zone_id)
                                                        ->whereBetween('from_date',[$fdate,$tdate])
                                                        ->whereBetween('to_date',[$fdate,$tdate])
                                                        ->sum('target_amount');

                            @endphp
                             <tr>
                             <td style="color:red; font-weight: bold;"  colspan="100%" >{{$zone->main_zone}} Zone - {{$zone->zone_title}}  ({{$zoneterget}}) </td>
                             </tr>


                              @php


                              $total_t = 0;
                              $total_s = 0;
                              $total_a = 0;
                              $total_c = 0;
                              $total_p = 0;
                              $total_mt = 0;


                                @endphp
                            @php

                             $areas= DB::table('dealers as t1')
                                		 ->select('t1.dlr_area_id','t3.area_title')
                                         ->join('dealer_areas as t3','t1.dlr_area_id','=','t3.id')
                                        ->where('t1.dlr_zone_id',$zone->dlr_zone_id)
                                       // ->where('t1.dlr_type_id',$dlr_type->id)
                                        ->distinct('dlr_area_id')
                                        ->get();

                                $target = 0;
                             @endphp
                             @foreach($areas as $area)
                             @php
                              $targetttttt = \App\Models\Lmcommisiontarget::where('employe_area_id',$area->dlr_area_id)
                                                        ->whereBetween('from_date',[$fdate,$tdate])
                                                        ->whereBetween('to_date',[$fdate,$tdate])
                                                        ->sum('target_amount');
                               if($targetttttt != 0) {
                                $target = $targetttttt;
                               }else{

                               $target = 0;
                               }

                               $grandtotal_mt += $target;
                               $total_mt += $target;

                             @endphp
                               <tr>
                                 <td style="color: #3232b1; font-weight: bold;" colspan="100%">{{$area->area_title}}   </td>

                                </tr>

                                 @php
                                   $subtotal_t = 0;
                                    $subtotal_s = 0;
                                    $subtotal_a = 0;
                                    $subtotal_c = 0;
                                    $subtotal_p = 0;

                                $dealersss= DB::table('dealers')
                                		  ->where('dlr_zone_id',$zone->dlr_zone_id)
                                        ->where('dlr_type_id',$dlr_type->id)
                                        ->where('dlr_area_id',$area->dlr_area_id)
                                        ->get();

                               $sdate = "2021-01-01";

                                $dealers =  DB::select('SELECT dealers.id,dealers.d_s_name,dealers.dlr_base,dealers.dlr_commission,dealers.monthly_target,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$sdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit_a,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$sdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit_a,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as total_amont,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as collection,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$fdate.'" AND "'.$tdate.'" THEN `qty_kg` ELSE null END) as total_sale
                                        FROM `sales_ledgers`
                                        LEFT JOIN dealers ON dealers.id = sales_ledgers.vendor_id
                                   	    WHERE dealers.dlr_area_id = "'.$area->dlr_area_id.'"  and  dealers.dlr_type_id = "'.$dlr_type->id.'"  and  dealers.dlr_zone_id = "'.$zone->dlr_zone_id.'"
                                        GROUP BY dealers.id');






                             @endphp

                              @foreach($dealers as $dealer)


                              @php
                             /*	$total_sale =  DB::table('sales_ledgers as t1')
                                                          ->join('dealers as t3','t1.vendor_id','=','t3.id')
                                                           ->where('t3.dlr_zone_id', $zone->dlr_zone_id)
                                                          ->where('t1.vendor_id',$dealer->id)
                                                          ->whereBetween('ledger_date',[$fdate,$tdate])
                                                          ->sum('qty_kg');

                                 $total_amont =  DB::table('sales_ledgers as t1')
                                                          ->join('dealers as t3','t1.vendor_id','=','t3.id')
                                                           ->where('t3.dlr_zone_id', $zone->dlr_zone_id)
                                                          ->where('t1.vendor_id',$dealer->id)
                                                          ->whereBetween('ledger_date',[$fdate,$tdate])
                                                          ->sum('debit');
                                 $collection =  DB::table('sales_ledgers as t1')
                                                          ->join('dealers as t3','t1.vendor_id','=','t3.id')
                                                           ->where('t3.dlr_zone_id', $zone->dlr_zone_id)
                                                          ->where('t1.vendor_id',$dealer->id)
                                                          ->whereBetween('ledger_date',[$fdate,$tdate])
                                                          ->sum('credit');




                                    $debit_a = \App\Models\SalesLedger::where('vendor_id', $dealer->id)->whereBetween('ledger_date',[$sdate,$tdate])->sum('debit');
                                    $cretid_a = \App\Models\SalesLedger::where('vendor_id', $dealer->id)->whereBetween('ledger_date',[$sdate,$tdate])->sum('credit');  */


                              	$total_sale =$dealer->total_sale;
                              $total_amont = $dealer->total_amont;
                              $collection =$dealer->collection;

                                    $c_balane = $dealer->debit_a - $dealer->credit_a;

                                    $present_b =  $dealer->dlr_base+$c_balane;



                                 $total_t += $dealer->monthly_target;
                                 $total_s += $total_sale/1000;
                                 $total_a += $total_amont;
                                 $total_c += $collection;
                                 $total_p += $present_b;

                                 $subtotal_t += $dealer->monthly_target;
                                 $subtotal_s += $total_sale/1000;
                                 $subtotal_a += $total_amont;
                                 $subtotal_c += $collection;
                                 $subtotal_p += $present_b;

                                $grandtotal_t += $dealer->monthly_target;
                                $grandtotal_s += $total_sale/1000;
                                $grandtotal_a += $total_amont;
                                $grandtotal_c += $collection;
                                $grandtotal_p += $present_b;
                                $grandtotal_si++;

                              @endphp

                               <tr style="font-size: 16px;">
                                <td>{{$loop->iteration}}</td>
                                 <td >{{$dealer->d_s_name}} </td>
                                 <td ></td>
                                 <td >{{$dealer->monthly_target}}</td>
                                 <td >{{$total_sale/1000}}</td>
                                 <td >@if($dealer->monthly_target > 0){{round(($total_sale/1000)/$dealer->monthly_target*100,2)}}% @endif</td>
                                 <td >{{number_format($total_amont,2)}}</td>
                                 <td >{{number_format($collection,2)}}</td>
                                 <td >{{number_format($present_b,2)}}</td>

                                </tr>
                            @endforeach
                              <tr style="background-color: bisque; color: #3232b1;  font-weight: bold;">
                                <td colspan="2">Sub Total</td>
								<td style="text-align:right">{{$target}}</td>

								<td >{{$subtotal_t}}</td>
								<td >{{$subtotal_s}}  </td>
								<td >@if($target > 0){{round($subtotal_s/$target*100,2)}}% @endif</td>
								<td >{{number_format($subtotal_a,2)}}</td>
								<td >{{number_format($subtotal_c,2)}}</td>
								<td >{{number_format($subtotal_p,2)}}</td>


                           </tr>
                          @endforeach

                            <tr style="background-color: bisque; color:red;  font-weight: bold;">
                                <td  colspan="2" >Total</td>
								<td style="text-align:right">{{$total_mt}}</td>
								<td >{{$total_t}}</td>
								<td >{{$total_s}}</td>
								<td >@if($total_mt > 0){{round($total_s/$total_mt*100,2)}}% @endif</td>
								<td >{{number_format($total_a,2)}}</td>
								<td >{{number_format($total_c,2)}}</td>
								<td >{{number_format($total_p,2)}}</td>


                           </tr>
                            @endforeach



                            <tr style="color: black;background-color: #827d789c;font-weight: bold;">
                                <td  colspan="2" >Grand Total ({{$grandtotal_si}})</td>
                                <td style="text-align:right">{{$grandtotal_mt}}</td>
                                <td >{{$grandtotal_t}}</td>
                                <td >{{$grandtotal_s}}</td>
                                <td >@if($grandtotal_mt > 0){{round($grandtotal_s/$grandtotal_mt*100,2)}}% @endif</td>
                                <td >{{number_format($grandtotal_a,2)}}</td>
                                <td >{{number_format($grandtotal_c,2)}}</td>
                                <td >{{number_format($grandtotal_p,2)}}</td>
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
</script>

<script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#reporttable").table2excel({
                 filename: "Various Vendor Type Report.xls"
            });
        });
    });
</script>
@endsection
