@extends('layouts.sales_dashboard')


@section('print_menu')

			<li class="nav-item">

                </li>
			<li class="nav-item ml-1">

                </li>
<li class="nav-item ml-1">

                </li>

@endsection

@section('content')
 
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


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
                 	<button class="btn btn-sm  btn-warning mt-1"  onclick="printland()"  id="printland"  >
                       PrintLands.
                    </button>

               </div>
           </div>

            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh" id="contentbody">


              <div class="row pt-2">
                  	<div class="col-md-5 text-left">
                      <h5 class="text-uppercase font-weight-bold">Monthly Mr Sales Target Report <br> {{$month_name}} {{$year}}</h5>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>


                <div class="py-4 ">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed table-responsive" style="font-size: 15px;">
                        <thead style="border: 1px solid #515151;">
                            <tr>
                              <td></td>
								@php 
                              	$modalAreaId = 0;
                              	$modalSales = 0;
                              	@endphp 
                              <td colspan="3" style="color: rgb(12, 80, 12); font-weight: bold;text-align: center; ">Total Target Achive</td>
                               @foreach($product_categorys as $key=>$p_c)

                              <th colspan="3" style="color: rgb(20, 88, 20); font-weight: bold;text-align: center">{{$p_c->category_name}}</th>


                               @endforeach
                            <!--  <td colspan="3" style="color: green; font-weight: bold;text-align: center">Boiler Feed</td>
                              <td colspan="3" style="color: green; font-weight: bold;text-align: center">Layer Feed</td>
                              <td colspan="3" style="color: green; font-weight: bold;text-align: center">Fish Feed</td>
                              <td colspan="3" style="color: green; font-weight: bold;text-align: center">Cattle Feed</td>  -->
                              <td></td>
                              <td></td>
                            </tr>
                          <tr class="table-header-fixt-top">
                               <!-- <th>Mr</th> -->
                               <th>Area & Zone</th>

                               <th>Total Target</th>
                               <th>{{$month_name}} Sales</th>
                               <th>Total Achive</th>



                               @foreach($product_categorys as $key=>$p_c)
                                @php
                                 $gtp_target[$key] = 0;
                                 $gtp_sale[$key] = 0;
                               @endphp

                               <th>Target</th>
                           <!--    <th>{{$p_c->category_name}}</th>  -->
                               <th>Sales</th>

                               <th>Achive</th>


                               @endforeach
                                <th>Present Credit</th>
                               <th>Credit Limit</th>
                             <!--  <th>Tatal Sale</th> -->




                          </tr>
                          </thead>
                           @php
                                 $grand_target = 0;
                                  $grand_sale = 0;

                                   $grandtotal_credit_limit = 0;
                                    $grandtotal_present_credit = 0;


                           @endphp

                          <tbody>

                               @foreach($zones as $key=>$zone)


                               @php
                               // $zone = DB::table('dealer_zones')->where('id',$key)->first();

                                 $total_credit_limit = 0;
                            $total_present_credit = 0;

                              $total_total_target = 0;
                              $total_monthly_sale = 0;

                               foreach($product_categorys as $key=>$p_c){
                                $ttp_target[$key]  = 0;
                                $ttp_sale[$key] = 0;
                               }

                           $values= DB::table('montly_sales_targets as t1')
                               ->select('t1.subzone_id','t4.subzone_title')
                              ->join('dealer_subzones as t4','t1.subzone_id','=','t4.id')
                              ->whereBetween('date', [$fdate, $tdate])
                              ->where('t1.area_id', $zone->area_id)
                              //->distinct('subzone_id')
                              ->orderby('subzone_title')
                              ->get();
                               $sareabysubzone = $values->unique('subzone_id')->all();



                           @endphp
                                 <tr class="" style="border: 1px solid black">
                                   <th style="color: rgb(104, 28, 28); font-weight: bold;" colspan="4">{{$zone->main_zone}} Zone - {{$zone->zone_title}} </th>

                                       @foreach($product_categorys as $key=>$p_c)
                                         <th></th>
                                     <th></th>
                                     <th></th>


                                       @endforeach
                                       <th></th>
                                     <th></th>
                                   </tr>

                       @if($sareabysubzone)


                        @foreach($sareabysubzone as $data)

                         <tr class="" style="border: 1px solid black">
                                   <th style="color:rgb(22, 78, 22); font-weight: bold;" >{{$data->subzone_title}}</th>
                                    <th></th>
                                   <th></th>
                                   <th></th>
                                       @foreach($product_categorys as $key=>$p_c)
                                         <th></th>
                                     <th></th>
                                     <th></th>


                                       @endforeach
                                       <th></th>
                                     <th></th>
                                   </tr>
                         @php
                            $subtotal_credit_limit = 0;
                            $subtotal_present_credit = 0;

                              $subtotal_total_target = 0;
                              $subtotal_monthly_sale = 0;

                               foreach($product_categorys as $key=>$p_c){
                                $subttp_target[$key]  = 0;
                                $subttp_sale[$key] = 0;
                               }

                         $value= DB::table('montly_sales_targets as t1')
                                 ->select('t1.area_id','t4.area_title')
                                ->join('dealer_areas as t4','t1.area_id','=','t4.id')
                                ->whereBetween('date', [$fdate, $tdate])
                                ->where('t1.subzone_id', $data->subzone_id)
                                ->distinct('area_id')
                                ->orderby('area_title')
                                ->get();

                         @endphp
                          @foreach($value as $area)
                               @php
                                $target = \App\Models\Lmcommisiontarget::where('employe_area_id',$area->area_id)
                                                      ->whereBetween('from_date',[$fdate,$tdate])
                                                      ->whereBetween('to_date',[$fdate,$tdate])
                                                      ->sum('target_amount');

                               $qty = DB::table('montly_sales_targets')->where('area_id',$area->area_id)->whereBetween('date', [$fdate, $tdate])->sum('qty_kg');

                                $total_total_target  += $target;
                                  $total_monthly_sale  += ($qty/1000);

                                   $subtotal_total_target  += $target;
                                  $subtotal_monthly_sale  += ($qty/1000);


                                  $grand_target += $target;
                                  $grand_sale += ($qty/1000);

                                   @endphp

                           <tr>
                              <td ><b>{{$area->area_title}} </b></td>
                              <td >{{$target}}</td>
                               <td >{{round($qty/1000, 2)}}</td>
                               @if($target != 0 && $qty/1000 != 0)
                                  <td>{{round((($qty/1000)/$target)*100, 2)}}</td>
                                  @else
                                  <td>0</td>
                              @endif
                                   @foreach($product_categorys as $key=>$p_c)
                                    @php
                                   $dataaa = DB::table('montly_sales_targets')->where('area_id',$area->area_id)->where('category_id',$p_c->category_id)->whereBetween('date', [$fdate, $tdate])->sum('qty_kg');

                                 $target = \App\Models\Lmcommisiontarget::where('employe_area_id',$area->area_id)
                                                      ->where('category_id',$p_c->category_id)
                                                      ->whereBetween('from_date',[$fdate,$tdate])
                                                      ->whereBetween('to_date',[$fdate,$tdate])
                                                      ->sum('target_amount');


                                   $ttp_target[$key] += $target;
                                   $ttp_sale[$key] += $dataaa/1000;

                                   $subttp_target[$key] += $target;
                                   $subttp_sale[$key] += $dataaa/1000;

                                   $gtp_target[$key] += $target;
                                   $gtp_sale[$key] += $dataaa/1000;

                                   @endphp

                                   <td >{{$target}}</td>
                                  <td >{{round($dataaa/1000, 2)}}</td>
                                   @if($target != 0 && $dataaa/1000 != 0)
                                  <td>{{round((($dataaa/1000)/$target)*100, 2)}}</td>
                                  @else
                                  <td>0</td>
                                  @endif


                                   @endforeach

                                     @php
                                   $credit_limit = DB::table('dealers')
                                          ->where('dlr_area_id',$area->area_id)
                                          ->sum('dlr_police_station');


                                    $openingbalance = DB::table('dealers')
                                          ->where('dlr_area_id',$area->area_id)
                                          ->sum('dlr_base');



                                      $att = "2021-01-01";


                                     $op_b = $openingbalance;

                                         $debit_a =  DB::table('sales_ledgers as t1')
                                                             ->join('dealers as t3','t1.vendor_id','=','t3.id')

                                                             ->where('t3.dlr_area_id',$area->area_id)
                                                             ->whereBetween('ledger_date',[$att,$tdate])
                                                             ->sum('t1.debit');

                                        $cretid_a = DB::table('sales_ledgers as t1')
                                                             ->join('dealers as t3','t1.vendor_id','=','t3.id')
                                                             ->where('t3.dlr_area_id',$area->area_id)
                                                             ->whereBetween('ledger_date',[$att,$tdate])
                                                             ->sum('t1.credit');


                                     $c_balane = $debit_a - $cretid_a;

                                    $credit =  $op_b+$c_balane;

                                     $total_credit_limit +=  $credit_limit;
                                  $total_present_credit += $credit;

                                   $subtotal_credit_limit +=  $credit_limit;
                                  $subtotal_present_credit += $credit;

                                   $grandtotal_credit_limit +=  $credit_limit;
                                  $grandtotal_present_credit += $credit;

                                  @endphp
                                   <td ><b>{{number_format($credit,2)}}</b></td>
                                   <td ><b>{{number_format($credit_limit,2)}}</b></td>



                              </tr>
                              @endforeach

                                <tr style="background-color: rgb(235, 195, 146); color:rgb(176, 255, 176); font-weight: bold;">
                              <td><b>SubTotal</b></td>

                              <td><b>{{$subtotal_total_target}}</b></td>
                              <td><b>{{round($subtotal_monthly_sale,2)}}</b></td>
                              @if($subtotal_monthly_sale != 0 && $subtotal_total_target !=0)
                              <td><b>{{round(($subtotal_monthly_sale/$subtotal_total_target)*100,2)}}</b></td>
                              @else
                              <td><b>0</b></td>
                              @endif


                               @foreach($product_categorys as $key=>$p_c)

                                    <td><b>{{$subttp_target[$key]}}</b></td>
                                    <td><b>{{round($subttp_sale[$key],2)}}</b> </td>
                                    @if($subttp_sale[$key] != 0 && $subttp_target[$key] !=0)
                                    <td><b>{{round(($subttp_sale[$key]/$subttp_target[$key])*100,2)}}</b></td>
                                    @else
                                    <td><b>0</b></td>
                                    @endif
                                  @endforeach




                                <td><b>{{number_format($total_present_credit,2)}}</b></td>
                                  <td><b>{{number_format($total_credit_limit,2)}}</b></td>

                         </tr>

                        @endforeach


                         @endif

                         @if(!$sareabysubzone)
                                      @php
                         $value= DB::table('montly_sales_targets as t1')
                                 ->select('t1.area_id','t4.area_title')
                                ->join('dealer_areas as t4','t1.area_id','=','t4.id')
                                ->whereBetween('date', [$fdate, $tdate])
                                ->where('t1.area_id', $zone->area_id)
                                ->distinct('area_id')
                                ->orderby('area_title')
                                ->get();

                         @endphp
                          @foreach($value as $area)
                               @php
                                $target = \App\Models\Lmcommisiontarget::where('employe_area_id',$area->area_id)
                                                      ->whereBetween('from_date',[$fdate,$tdate])
                                                      ->whereBetween('to_date',[$fdate,$tdate])
                                                      ->sum('target_amount');

                               $qty = DB::table('montly_sales_targets')->where('area_id',$area->area_id)->whereBetween('date', [$fdate, $tdate])->sum('qty_kg');

                                $total_total_target  += $target;
                                  $total_monthly_sale  += ($qty/1000);


                                  $grand_target += $target;
                                  $grand_sale += ($qty/1000);

                                   @endphp

                           <tr>
                              <td ><b>{{$area->area_title}} </b></td>
                              <td >{{$target}}</td>
                              <td >{{round($qty/1000, 2)}}</td>
                               @if($target != 0 && $qty/1000 != 0)
                                  <td>{{round((($qty/1000)/$target)*100, 2)}}</td>
                                  @else
                                  <td>0</td>
                              @endif
                                   @foreach($product_categorys as $key=>$p_c)
                                    @php
                                   $dataaa = DB::table('montly_sales_targets')->where('area_id',$area->area_id)->where('category_id',$p_c->category_id)->whereBetween('date', [$fdate, $tdate])->sum('qty_kg');

                                 $target = \App\Models\Lmcommisiontarget::where('employe_area_id',$area->area_id)
                                                      ->where('category_id',$p_c->category_id)
                                                      ->whereBetween('from_date',[$fdate,$tdate])
                                                      ->whereBetween('to_date',[$fdate,$tdate])
                                                      ->sum('target_amount');


                                   $ttp_target[$key] += $target;
                                   $ttp_sale[$key] += $dataaa/1000;


                                   $gtp_target[$key] += $target;
                                   $gtp_sale[$key] += $dataaa/1000;
                             
									$modalAreaId = $area->area_id;
                              		$modalSales = $dataaa;
                                   @endphp
                             
                                   <td >{{$target}}</td>
                             		<td ><a href="{{URL('/monthly/employee/target/item/report/')}}/{{$p_c->category_id}}/{{$area->area_id}}/{{$fdate}}/{{$tdate}}" >{{round($dataaa/1000, 2)}}</a></td>
                                   @if($target != 0 && $dataaa/1000 != 0)
                                  <td>{{round((($dataaa/1000)/$target)*100, 2)}}</td>
                                  @else
                                  <td>0</td>
                                  @endif


                                   @endforeach

                                     @php
                                   $credit_limit = DB::table('dealers')
                                          ->where('dlr_area_id',$area->area_id)
                                          ->sum('dlr_police_station');


                                    $openingbalance = DB::table('dealers')
                                          ->where('dlr_area_id',$area->area_id)
                                          ->sum('dlr_base');



                                      $att = "2021-01-01";


                                     $op_b = $openingbalance;

                                         $debit_a =  DB::table('sales_ledgers as t1')
                                                             ->join('dealers as t3','t1.vendor_id','=','t3.id')

                                                             ->where('t3.dlr_area_id',$area->area_id)
                                                             ->whereBetween('ledger_date',[$att,$tdate])
                                                             ->sum('t1.debit');

                                        $cretid_a = DB::table('sales_ledgers as t1')
                                                             ->join('dealers as t3','t1.vendor_id','=','t3.id')
                                                             ->where('t3.dlr_area_id',$area->area_id)
                                                             ->whereBetween('ledger_date',[$att,$tdate])
                                                             ->sum('t1.credit');


                                     $c_balane = $debit_a - $cretid_a;

                                    $credit =  $op_b+$c_balane;

                                     $total_credit_limit +=  $credit_limit;
                                  $total_present_credit += $credit;

                                    $grandtotal_credit_limit +=  $credit_limit;
                                  $grandtotal_present_credit += $credit;

                                  @endphp
                                   <td ><b>{{number_format($credit,2)}}</b></td>
                                   <td ><b>{{number_format($credit_limit,2)}}</b></td>



                              </tr>
                                    <tr>
                                      <th></th>
                                      <th colspan="3"></th>
                                      @foreach($product_categorys as $key=>$p_c)
                                               @php
                                               
                                                   $products = DB::table('montly_sales_targets as t1')->select('t2.product_name',DB::raw('sum(qty_kg) as qty_kg'))
                                                              ->join('sales_products as t2', 't1.product_id', '=', 't2.id')->where('t1.category_id',$p_c->category_id)
                                                              ->where('t1.area_id',$area->area_id)->whereBetween('t1.date', [$fdate, $tdate])->groupBy('t1.product_id')->get();
                                                   
                                                         $grand_total_kg = 0;
                                                  
                                               @endphp
                                         <th  style="text-align: center;padding:0px" colspan="3">
                                            <table >
                                              <tr style="color: rgb(20, 88, 20); font-weight: bold;">
                                                <th>Product Name</th>
                                                <th>Quantity (Kg)</th>
                                                <th>Quantity (Ton)</th>
                                              </tr>
                                                @foreach($products as $product)
                                                   @php 
                                                        $grand_total_kg += $product->qty_kg;
                                                    @endphp 
                                                <tr>
                                                  <td>{{$product->product_name}}</td>
                                                  <td>{{number_format($product->qty_kg,2)}}</td>
                                                  <td>{{number_format(($product->qty_kg/1000),2)}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="color: black;background-color: #e198509c;font-weight: bold;">
                                                  <td><b>Grand Total</b></td>
                                                   <td><b>{{number_format($grand_total_kg,2)}}</b></td>
                                                  <td><b>{{number_format(($grand_total_kg/1000),2)}}</b></td>       
                                                 </tr>
                                             </table>
                                         </th>
                                      @endforeach
                                      <th></th>
                                      <th></th>
                                    </tr>
                              @endforeach
                        @endif

                              <tr style="background-color: bisque; color: rgb(216, 0, 0); font-weight: bold;">
                              <td><b>Total</b></td>

                              <td><b>{{$total_total_target}}</b></td>
                              <td><b>{{round($total_monthly_sale,2)}}</b></td>
                              @if($total_monthly_sale != 0 && $total_total_target !=0)
                              <td><b>{{round(($total_monthly_sale/$total_total_target)*100,2)}}</b></td>
                              @else
                              <td><b>0</b></td>
                              @endif


                               @foreach($product_categorys as $key=>$p_c)

                                    <td><b>{{$ttp_target[$key]}}</b></td>
                                    <td><b>{{round($ttp_sale[$key],2)}}</b></td>
                                    @if($ttp_sale[$key] != 0 && $ttp_target[$key] !=0)
                                    <td><b>{{round(($ttp_sale[$key]/$ttp_target[$key])*100,2)}}</b></td>
                                    @else
                                    <td><b>0</b></td>
                                    @endif
                                  @endforeach




                                <td><b>{{number_format($total_present_credit,2)}}</b></td>
                                  <td><b>{{number_format($total_credit_limit,2)}}</b></td>

                         </tr>

                          @endforeach




                           <tr style="color: black;background-color: #827d789c;font-weight: bold;">
                              <td><b>Grand Total</b></td>
                               <td><b>{{$grand_target}}</b></td>
                              <td><b>{{round($grand_sale,2)}}</b></td>
                              @if($grand_sale != 0 && $grand_target !=0)
                              <td><b>{{round(($grand_sale/$grand_target)*100,2)}}</b></td>
                              @else
                              <td><b>0</b></td>
                              @endif

                               @foreach($product_categorys as $key=>$p_c)

                                <td><b>{{$gtp_target[$key]}}</b></td>
                                <td><b>{{round($gtp_sale[$key],2)}}</b></td>
                                @if($gtp_sale[$key] != 0 && $gtp_target[$key] !=0)
                                  <td><b>{{round(($gtp_sale[$key]/$gtp_target[$key])*100,2)}}</b></td>
                                  @else
                                  <td><b>0</b></td>
                                  @endif

                               @endforeach
                              <td><b>{{number_format($grandtotal_present_credit,2)}}</b></td>
                                  <td><b>{{number_format($grandtotal_credit_limit,2)}}</b></td>
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
                filename: "Monthly Employee Target Report.xls"
            });
        });
    });
</script>
@endsection
