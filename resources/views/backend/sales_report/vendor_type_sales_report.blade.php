@extends('layouts.sales_dashboard')


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

                                 <th  style=" font-weight: bold;">Previous Due</th>
                                 <th style=" font-weight: bold;">Sales Amount</th>
                                 <th style=" font-weight: bold;">Total Due</th>
                              	 <th style=" font-weight: bold;">Collection</th>
                                 <th style=" font-weight: bold;">Net Due</th>

                                 @if($dlr_type->id == 11 || $dlr_type->id == 14)
                                  <th style=" font-weight: bold;">Commission</th>
						        @endif



                            </tr>
                            </thead>
                             @php

                                     $grandtotal_pd = 0;
                                      $grandtotal_sa = 0;
                                      $grandtotal_c = 0;
                                      $grandtotal_si = 0;
                                      $grandtotal_com = 0;


                             @endphp

                            <tbody>


                             @foreach($zones as $zone)

                             <tr>
                             <td style="color:red; font-weight: bold;" colspan="100%">{{$zone->main_zone}} Zone - {{$zone->zone_title}} </td>

                             </tr>


                              @php
                              $total_pd = 0;
                              $total_sa = 0;
                              $total_c = 0;
                              $total_com = 0;


                                @endphp

                            @php

                              //    $subzons= DB::table('dealers as t1')
                               // 		 ->select('t1.dlr_subzone_id','t3.subzone_title')
                                //         ->join('dealer_subzones as t3','t1.dlr_subzone_id','=','t3.id')
                                //        ->where('t1.dlr_zone_id',$zone->dlr_zone_id)
                                //        ->where('t1.dlr_type_id',$dlr_type->id)
                                 //       ->distinct('dlr_subzone_id')
                                 //       ->get();
                              $areas= DB::table('dealers as t1')
                                		 ->select('t1.dlr_area_id','t3.area_title')
                                         ->join('dealer_areas as t3','t1.dlr_area_id','=','t3.id')
                                        ->where('t1.dlr_zone_id',$zone->dlr_zone_id)
                                        ->where('t1.dlr_type_id',$dlr_type->id)
                                        ->distinct('dlr_area_id')
                                        ->get();

                             @endphp
                             @foreach($areas as $areas)
                               <tr>
                                 <td style="color: #9a9aff; font-weight: bold;" colspan="100%">{{$areas->area_title}} </td>

                                </tr>

                                 @php
                                  $subtotal_pd = 0;
                                  $subtotal_sa = 0;
                                  $subtotal_c = 0;
                                  $subtotal_com = 0;

                                 $dealers= DB::table('dealers as t2')
                                		  ->where('t2.dlr_zone_id',$zone->dlr_zone_id)
                                        ->where('t2.dlr_type_id',$dlr_type->id)
                                        ->where('t2.dlr_area_id',$areas->dlr_area_id)
                                        ->get();

                               $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

                                   $sdate = "2023-07-01";

                               $dealerData =  DB::select('SELECT dealers.id,dealers.d_s_name,dealers.dlr_base,dealers.dlr_commission,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$sdate.'" AND "'.$predate.'" THEN `debit` ELSE null END) as debit_a,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$sdate.'" AND "'.$predate.'" THEN `credit` ELSE null END) as credit_a,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as sales_a,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as collection
                                        FROM `sales_ledgers`
                                        LEFT JOIN dealers ON dealers.id = sales_ledgers.vendor_id
                                   	    WHERE dealers.dlr_area_id = "'.$areas->dlr_area_id.'"  and  dealers.dlr_type_id = "'.$dlr_type->id.'"  and  dealers.dlr_zone_id = "'.$zone->dlr_zone_id.'"
                                        GROUP BY dealers.id');

                              //dd($dealerData);


                             @endphp

                              @foreach($dealerData as $dealer)


                              @php
                             //previous deu

                              		$debit_a = $dealer->debit_a;
                                    $credit_a = $dealer->credit_a;

                              		 $c_balane = $debit_a - $credit_a;

                                    $present_b =  $dealer->dlr_base+$c_balane;

                                    $pre_b = $present_b;




                                    $sales_a = $dealer->sales_a;
                                    $collection = $dealer->collection;

                                  $total_pd += $pre_b;
                                  $total_sa += $sales_a;
                                  $total_c += $collection;


                                  $subtotal_pd += $pre_b;
                                  $subtotal_sa += $sales_a;
                                  $subtotal_c += $collection;


                                   $grandtotal_pd += $pre_b;
                                  $grandtotal_sa += $sales_a;
                                  $grandtotal_c += $collection;


                                  $grandtotal_si++;



                              @endphp

                               <tr style="font-size: 16px;">
                                <td>{{$loop->iteration}}</td>
                                 <td >{{$dealer->d_s_name}} </td>
                                 <td >{{number_format($pre_b,2)}} </td>
                                 <td > {{number_format($sales_a,2)}} </td>
                                 <td >{{number_format($pre_b + $sales_a ,2)}} </td>
                                 <td >{{number_format($collection,2)}} </td>
                                 <td >{{number_format($pre_b + $sales_a - $collection ,2)}} </td>

                                @if($dlr_type->id == 11 || $dlr_type->id == 14)
                                @php
                                 $total_com += $dealer->dlr_commission;
                                  $subtotal_com += $dealer->dlr_commission;
                                  $grandtotal_com += $dealer->dlr_commission;
                                @endphp
                                  <td >{{number_format($dealer->dlr_commission,2)}} </td>
						        @endif

                                </tr>
                            @endforeach


                            <tr style="background-color: rgba(255, 228, 196, 0.281); color: #8686ff; font-weight: bold;">
                                <td colspan="2">Sub Total</td>
								 <td >{{number_format($subtotal_pd,2)}} </td>
                                 <td > {{number_format($subtotal_sa,2)}} </td>
                                 <td >{{number_format($subtotal_pd + $subtotal_sa ,2)}} </td>
                                 <td >{{number_format($subtotal_c,2)}} </td>
                                 <td >{{number_format($subtotal_pd + $subtotal_sa - $subtotal_c ,2)}} </td>

                                  @if($dlr_type->id == 11 || $dlr_type->id == 14)
                                  <td >{{number_format($subtotal_com,2)}} </td>
						        @endif


                           </tr>
                            @endforeach
                            <tr style="background-color: rgba(255, 228, 196, 0.253); color: rgb(255, 113, 113);   font-weight: bold;">
                                <td colspan="2">Total</td>
								 <td >{{number_format($total_pd,2)}} </td>
                                 <td > {{number_format($total_sa,2)}} </td>
                                 <td >{{number_format($total_pd + $total_sa ,2)}} </td>
                                 <td >{{number_format($total_c,2)}} </td>
                                 <td >{{number_format($total_pd + $total_sa - $total_c ,2)}} </td>

                                 @if($dlr_type->id == 11 || $dlr_type->id == 14)
                                  <td >{{number_format($total_com,2)}} </td>
						         @endif

                           </tr>
                            @endforeach


                            <tr style="color: black;background-color: #827d789c;font-weight: bold;">
                                <td colspan="2">Grand Total ({{$grandtotal_si}})</td>
                                <td >{{number_format($grandtotal_pd,2)}} </td>
                                 <td > {{number_format($grandtotal_sa,2)}} </td>
                                 <td >{{number_format($grandtotal_pd + $grandtotal_sa ,2)}} </td>
                                 <td >{{number_format($grandtotal_c,2)}} </td>
                                 <td >{{number_format($grandtotal_pd + $grandtotal_sa - $grandtotal_c ,2)}} </td>

                                     @if($dlr_type->id == 11 || $dlr_type->id == 14)
                                      <td >{{number_format($grandtotal_com,2)}} </td>
                                    @endif
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
