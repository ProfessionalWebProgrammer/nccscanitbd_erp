@extends('layouts.sales_dashboard')

@section('print_menu')

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
                    </div>
                </div>

            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh"  id="contentbody">

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Yearly Vendor Daterange Sales Statement Report</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>




                <div class="py-4 table-responsive">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed" style="font-size: 14px;">
                        <tbody>
                            <tr style="font-weight:600; font-size:14px;" class="table-header-fixt-top">

                                <th>Month</th>
                                <th>Ton</th>
                                <th>Sales Amount</th>
                                <th>Debit Dr</th>
                                <th>Credit Cr</th>
                                <th>Balance</th>
                                <th>Transport</th>
                                <th>Incentive</th>

                                <th>(%)</th>
                                 @php
                              $toncomvaleu = 0;
                              @endphp
                                @foreach ($dealer_warehouse as $warehouse)
                              			@php
                              				$toncomvaleu += $warehouse->commission_per_ton;
                              			@endphp
                                <th>{{$warehouse->factory_name}}</th>
                                @endforeach

                                <th>Total Bags</th>
                                <th>50kg Bags</th>
                                 <th>p.e.i</th>

                            </tr>
                               <tr>
                                        <td colspan="5">Opening Balance</td>
                                        <td>{{($dealer_opening_balance)?$dealer_opening_balance:0}}</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>


                                           @foreach($dealer_warehouse as $key => $warehouse)
                                           @php
                                                $totalcomperton[$key] = 0;
                                                $totalcomperbag[$key] = 0;
                                                $totalwton[$key] = 0;
                                                $totalwbag[$key] = 0;
                                              @endphp
                                           <td>0</td>
                                        @endforeach
                                        <td>0</td>
                                        <td>0</td>
                                         <td>0</td>
                                    </tr>
                                <?php
                                $t_cr = 0;
                                $t_dr = 0;
                                $t_qty = 0;
                                $total_ton = 0;
                                 $t_transport = 0;
                                $t_incentive = 0;
                                $c_blan = 0;
                                $totalbag_50kg = 0;
                                 $peitotal = 0;
                                $peitotal1 = 0;
                                ?>
                                @php
                                         $totalbag =0;
                                  // dd($data);
                                   @endphp
                                @foreach($data as $monthkey=>$value)

                                    @if(isset($value->month))
                                    <?php
                                $t_cr += $value->credit;
                                $t_dr += $value->debit;
                                $t_qty += $value->qty_kg;
                              $total_ton += $value->qty_kg/1000;
                                $t_transport += $value->transport_cost;
                                $t_incentive += $value->incentive;
                                $c_blan += $value->debit - $value->credit;
                              $totalbag_50kg +=  $value->total_qty_50kg;
                              $totalbag+=$value->total_qty;
                                ?>
                                   <tr>
                                        <td><?=date('F', mktime(0, 0, 0, $value->month, 10))?> {{$value->year}}</td>
                                        <td><?=($value->qty_kg)/1000?></td>
                                        <td><?=$value->debit?></td>
                                        <td><?=$value->debit?></td>
                                        <td><?=$value->credit?></td>
                                        <td><?=($c_blan + $dealer_opening_balance) ?></td>
                                        <td> @if($toncomvaleu != 0) 0 @else <?= $value->transport_cost ?> @endif</td>
                                        <td> @if($toncomvaleu != 0) 0 @else <?= $value->incentive ?>  @endif</td>

                                         <td><?=$value->percent?></td>

                                          @php
                                        $pei1 = 0;
                                        $pei2 = 0;
                                        @endphp
                                        @foreach($warehouse_data[$monthkey] as $key=> $w_data)
                                            @php
                                             $pei1 += $w_data/1000*$dealer_warehouse[$key]->commission_per_ton;
                                             $peitotal += $w_data/1000*$dealer_warehouse[$key]->commission_per_ton;
                                                $totalwton[$key] += $w_data/1000;

                                              @endphp

                                        @endforeach

                                        @foreach($warehouse_bagdata[$monthkey] as $key=> $w_data)
                                            @php

                                            $pei2 = ($value->qty_kg/1000)*20*$dealer_warehouse[$key]->commission_per_bag;

                                                $totalwbag[$key] += $w_data;

                                              @endphp
                                        <td>{{$w_data}}</td>
                                        @endforeach

                                      @php
                                      $peitotal1 += $pei2;
                                      @endphp

                                        <td><?=$value->total_qty?></td>
                                        <td><?=$value->total_qty_50kg?></td>

                                      <td>{{$pei1+$pei2}}</td>
                                    </tr>


                                    @endif

                                @endforeach
                            </tbody>
                            <tr style=" background-color: #827d789c;" >
                                  <th>Total</th>
                                  <th>{{($t_qty)/1000}}</th>
                                  <th>{{$t_dr}}</th>
                                  <th>{{$t_dr}}</th>
                                  <th>{{$t_cr}}</th>
                                  <th>{{$t_dr - $t_cr + $dealer_opening_balance}}</th>
                                  <th>@if($toncomvaleu != 0) 0 @else {{ $t_transport }} @endif</th>
                            	<th>@if($toncomvaleu != 0) 0 @else {{ $t_incentive }} @endif</th>
                                  <th>0</th>

                                   @php
                                  $dlrcommissionPerTon = 0;
                                  $dlrcommissionPerbag = 0;
                                  @endphp
                                  @foreach($dealer_warehouse as $key=>  $warehouse)
                                  @php

                                    			$totalcomperton[$key] = $totalwton[$key]*$warehouse->commission_per_ton;
                                                $totalcomperbag[$key] = $totalwbag[$key]*$warehouse->commission_per_bag;

                                                $dlrcommissionPerTon += $totalwton[$key]*$warehouse->commission_per_ton;
                                  				$dlrcommissionPerbag += $totalwbag[$key]*$warehouse->commission_per_bag;
                                  @endphp
                                       <th>{{$totalwbag[$key]}}</th>
                                   @endforeach
                                  <th>{{$totalbag}}</th>
                                  <th>{{$totalbag_50kg}}</th>
                                  <th>{{$peitotal+$peitotal1}}</th>

                                   @php
                              $bagincenctive = $peitotal1;
                              @endphp

                                </tr>



                              <tr>
                                <td colspan="6" align="center" style="font-size:20px">Summary</td>
                             </tr>

                            <tr>
                                <td colspan="3">Opening Balance</td>
                                <td colspan="3">{{($dealer_opening_balance)?$dealer_opening_balance:0}}</td>
                            </tr>
                            <tr>
                                <td colspan="3">Sales Amount</td>
                                <td colspan="3">{{$t_dr}}</td>
                            </tr>
                            <tr>
                                <td colspan="3"><label><strong>Total Amount</strong></label></td>
                                <td colspan="3">{{$t_dr + $dealer_opening_balance}}</td>
                            </tr>
                            <tr>
                                <td colspan="3">Transport</td>
                                <td colspan="3">@if($dlrcommissionPerTon > 0) 0 @else  {{$t_transport}} @endif</td>
                            </tr>
                      
                            {{-- <tr>
                                <td colspan="3">Monthly Incentive</td>
                                <td colspan="3">@if($dlrcommissionPerTon > 0) 0 @else  {{$t_incentive}}  @endif</td>

                            	</tr>
                      			<tr>
                               <td colspan="3">Yearly Incentive</td>
                                <td>{{($yearly_incentive)?$totalbag*$yearly_incentive->incentive:0}}</td>
                                @if($yearly_incentive )
                                <td colspan="3">@if($dlrcommissionPerTon > 0) 0 @else {{$total_ton*20*$yearly_incentive->incentive}}  @endif</td>

                             	 @else
                                <td colspan="3">0</td>
                                @endif
 							@php
                               $y_ins = 0;
                            $y_ins = ($yearly_incentive)?$total_ton*20*$yearly_incentive->incentive:0;
                             @endphp

                            </tr>  --}}
                       		<tr>
                                <td colspan="3">Incentive</td>
                                <td colspan="3">{{$value->incentive}}</td>

                            </tr>
                            
                           <tr>

                                <td colspan="3">Yearly Target Ton Incentive</td>
                                <td colspan="3">@if($dlrcommissionPerTon > 0) {{$dlrcommissionPerTon}} @else 0 @endif</td>
                            @php
                           $total_commission_on_ton = ($dlrcommissionPerTon > 0)?$dlrcommissionPerTon:0;
                           @endphp

                            </tr>
                          <tr>
                                <td colspan="3">Yearly special  Bag  Incentive</td>
                               {{-- <td colspan="3">@if($dlrcommissionPerbag > 0) {{$dlrcommissionPerbag}} @else 0 @endif</td> --}}
                                <td colspan="3">@if($bagincenctive > 0 ) {{$bagincenctive}} @else 0 @endif</td>
                             @php
                           // $y_ins += ($dlrcommissionPerbag > 0)?$dlrcommissionPerbag:0;
                            $y_ins += ($bagincenctive > 0)?$bagincenctive:0;
                            @endphp
                            </tr>
                            <tr>
                                <td colspan="3">P.E.I.</td>
                                <td colspan="3">0</td>
                            </tr>
                          @php
                          	if($total_commission_on_ton != 0){
                          	$total_pay_incentive =$total_commission_on_ton;
                          }else{
                          	$total_pay_incentive = $t_transport+$t_incentive+$y_ins;
                          }

                          @endphp

                            <tr>
                                <td colspan="3"><strong>Total Pay of Incentive</strong></td>
                                <td colspan="3">{{$total_pay_incentive}}</td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Net Payable Amount</strong> </td>
                                <td colspan="3">{{($t_dr + $dealer_opening_balance) - $total_pay_incentive}} (Dr)</td>
                            </tr>
                            <tr>
                                <td colspan="3">Total Payment</td>
                                <td colspan="3">{{$t_cr}} (Cr)</td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Due Balance</strong></td>
                                <td colspan="3">{{(($t_dr + $dealer_opening_balance) - $total_pay_incentive)-($t_cr)}} (Dr)</td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Closing Balance</strong></td>
                                <td colspan="3">{{$total_pay_incentive+((($t_dr + $dealer_opening_balance) - $total_pay_incentive)-($t_cr))}} (Dr)</td>
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
                filename: "Yearly Vendor Report.xls"
            });
        });
    });
</script>
@endsection
