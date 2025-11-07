@extends('layouts.account_dashboard')

@push('addcss')
    <style>
        .text_sale {
            color: #f7ee79;
        }

        .text_credit {
            color: lime;
        }

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
                      	<button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                           Export
                        </button>
                        <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn">
                           Print
                        </button>
                    </div>
                </div>

            <div class="container-fluid" id="contentbody" >


               <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">PL Statement</h5>
                      <p>From {{date('d m, Y',strtotime($fdate))}} to {{date('d m, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                      <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
              <div class="row py-4">
                    <div class="py-4 col-md-3 table-responsive">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size:13px;table-layout: inherit;">
                            <thead>
                              <tr>
                                <th colspan="2">Sales Revenue Details</th>
                                </tr>
                          </thead>
                          <tbody>
                            <tr class="text-center">
                                    <th>Head </th>
                                    <th>Amount (BDT)</th>
                            </tr>
                            <tr>
                              <td>Monthly Total Sales </td>
                              <td align="right">{{number_format(($data['sales'] - $data['sales_return']), 2)}}</td>
                            </tr>
                            <tr>
                              <td>Sales Discount</td>
                              <td align="right">{{number_format($sales_amount->discountPrice, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Monthly Commission</td>
                              <td align="right">{{number_format($data['monthlyCom'] ?? 0, 2)}}</td>
                            </tr>
                            {{-- <tr>
                              <td>Carriage Outward</td>
                              <td align="right">{{number_format($data['journalDiscount'] ?? 0, 2)}}</td>
                            </tr> --}}
                            
                            @if($data['salesDealer'] > 0 && $data['sales'] > 0)
                            <tr>
                              <td>Dealer Sales ({{ number_format(($data['salesDealer']*100)/($data['sales'] - $data['sales_return']),2)}} %)</td>
                              <td align="right">{{number_format($data['salesDealer'], 2)}}</td>
                            </tr>
                            @endif
                            @if($data['sales'] > 0 && $data['salesDealer'] > 0 && $data['sales'] > 0)
                            <tr>
                              @php 
                              $ownSales = $data['sales'] - ($data['sales_return'] + $data['salesDealer']); 
                              @endphp 
                              <td>Own Sales ({{ number_format(($ownSales*100)/($data['sales'] - $data['sales_return']),2)}} %) </td>
                              <td align="right">{{number_format($ownSales, 2)}}</td>
                            </tr>
                            @endif
                            <tr>
                              @php 
                              $totalCom = $sales_amount->discountPrice + ($data['monthlyCom'] ?? 0); 
                              $salesRevenue = ($data['sales']) - ($data['sales_return'] + $totalCom);
                              @endphp 
                              <td>Total Sales Revenues :</td>
                              <td align="right">{{number_format($salesRevenue, 2)}}</td>
                            </tr>
                            <tr>
                               <td colspan="2">Month of {{date('F',strtotime($tdate))}} Total Com: ({{number_format($totalCom, 2)}})</td>
                              
                              </tr>
                            </tbody>
                    </table>
                    <table  class="table table-bordered table-striped table-fixed"
                            style="font-size:13px; table-layout: inherit;">
                            <thead>
                              <tr>
                                <th colspan="2">F.G Openig & Closing Details</th>
                                </tr>
                          </thead>
                          <tbody>
                            <tr class="text-center">
                                    <th>Head </th>
                                    <th>Amount (BDT)</th>
                            </tr>
                            <tr>
                                <td>Opening Balance Stock of F.G :</td>
                              <td align="right">{{number_format($data['openingAmount'], 2)}}</td>
                            </tr>
                            <tr>
                                <td>Closing Balance Stock of F.G :</td>
                              <td align="right">{{number_format($data['closingAmount'], 2)}}</td>
                            </tr>
                            <tr>
                                <td>WIP :</td>
                              <td align="right">{{number_format(0, 2)}}</td>
                            </tr>
                            <tr>
                                @php
                                    $manufacturingCost = ($cogs + $manufacturingcost + $packing_cost + $data['direct_labour_costs']);
                                @endphp 
                                <td>Manufacturing Cost :</td>
                              <td align="right">{{number_format($manufacturingCost, 2)}}</td>
                            </tr>
                            <tr>
                                @php
                                    $totalCost = ($cogs + $manufacturingcost + $packing_cost + $data['direct_labour_costs'] + $data['openingAmount']) - $data['closingAmount'];
                                @endphp 
                                <td>Total C.O.G.S :</td>
                              <td align="right">{{number_format($totalCost, 2)}}</td>
                            </tr>
                            </tbody>
                    </table>
                    </div>
                
                    <div class="py-4 col-md-5 table-responsive">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size:13px; table-layout: inherit;">
                            <thead>
                                <tr class="text-center">
                                    <th>Head </th>
                                    <th>Amount (BDT)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp


                                <tr>
                                    @php
                                        $total += $salesRevenue;
                                    @endphp
                                    <td>Sales Revenues</td>
                                    <td align="right">{{ number_format($salesRevenue, 2) }}</td>

                                </tr>
                               {{-- <tr>
                                    <td>Finished Goods Opening</td>
                                    <td align="right">{{ number_format(9506956, 2) }}</td>
                                </tr>
                              <tr>
                                    <td>Finished Goods Closing</td>
                                    <td align="right">{{ number_format(9538751, 2) }}</td>
                                </tr> --}}
                                <tr>
                                    @php 
                                  		/*$temp = $data['cogs']; */
                                        $total -= $totalCost;
                                        
                                    @endphp
                                    <td>C.O.G.S (Direct Operating Cost) </td>
                                    <td align="right">{{ number_format($totalCost, 2) }}</td>

                                </tr>
                              @if($data['sales'] > 0)
                                <tr style="font-weight: bold">
                                    <td>Gross profit</td>
                                    <td align="right">{{ number_format($total, 2) }} @if($total != 0)({{  number_format(($total/$salesRevenue)*100,2) }}%) @endif</td>

                                </tr>
							@endif
                                @if ($allexpasne)

                                <tr style="font-weight: bold;color:blue">
                                    <td>Operating Expanse</td>
                                    <td align="right"></td>
                                </tr>

                                @php
                              $expansetotal = 0;
                              @endphp
                                @foreach ($allexpasne as $key=>$item)

                                <tr>
                                    @php
                                        $total -= $item->expamount;
                                        $expansetotal += $item->expamount;
                                    @endphp
                                    <td class="pl-5">{{$item->group_name ? $item->group_name : "Others Expnase" }}</td>
                                    <td align="right">{{  number_format($item->expamount, 2) }}</td>

                                </tr>

                                @endforeach 
                              
                              {{--
								<tr>
                                    @php
                                        $total -= 3686308;
                                        $expansetotal += 3686308;
                                    @endphp
                                    <td class="pl-5">Administrative Expenses</td>
                                    <td align="right">{{  number_format(3686308, 2) }}</td>

                                </tr>
                              <tr>
                                    @php
                                        $total -= 359015;
                                        $expansetotal += 359015;
                                    @endphp
                                    <td class="pl-5">Marketing Expenses</td>
                                    <td align="right">{{  number_format(359015, 2) }}</td>

                                </tr>
                              <tr>
                                    @php
                                        $total -= 2361237;
                                        $expansetotal += 2361237;
                                    @endphp
                                    <td class="pl-5">Field Force Expenses</td>
                                    <td align="right">{{  number_format(2361237, 2) }}</td>

                                </tr>
                              <tr>
                                    @php
                                        $total -= 576229;
                                        $expansetotal += 576229;
                                    @endphp
                                    <td class="pl-5">Distribution Expenses</td>
                                    <td align="right">{{  number_format(576229, 2) }}</td>

                                </tr>
                              --}}
                              		@php
                                     $total -= $data['asset_depreciations'];
                                     @endphp
                              <tr style="font-weight:bold">
                                 <td>Depreciation Amount </td>
                                 <td align="right">{{ number_format($data['asset_depreciations'], 2) ?? 0 }}</td>
                               </tr>

                             {{--   <tr style="font-weight: bold">
                                    <td>Total Expnase</td>
                                    <td align="right">{{ $expansetotal }}</td>

                                </tr>
                              @if($data['asset_depreciations'])
                               <tr style="font-weight:bold">
                                    <td colspan="100%">Depreciation Amount </td>
                                </tr>
                              @php
                              $tpped = 0;
                              @endphp
                              @foreach($data['asset_depreciations'] as $item)
                             	 <tr>
                                     @php
                                     $tpped += $item->yearly_amount;
                                     $total -= $item->yearly_amount;
                                     @endphp
                                    <td style="padding-left:30px">{{$item->asset_head}}-{{$item->product_name}}</td>
                                    <td align="right">{{$item->yearly_amount}}</td>
                                </tr>
                              @endforeach
                              <tr style="font-weight:bold">
                                   <td>Total  Depreciation Amount</td>
                                    <td align="right">{{$tpped}}</td>
                                </tr>
                              @endif --}}

                                <tr style="font-weight:bold">
                                   <td>Total Operating  Expanse</td>
                                    <td align="right">{{number_format(($data['asset_depreciations']+$expansetotal), 2)}}</td>
                                </tr>

                                  <tr style="font-weight: bold; color:blue;">
                                    <td>Total Operating Profit</td>
                                    <td align="right">{{ number_format($total, 2)}}</td>
                                	</tr>

                                 @endif

                               @if ($allincome)

                                <tr style="font-weight: bold;color:blue;">
                                    <td>Others Income</td>
                                    <td align="right"></td>

                                </tr>

                              @php
                              $incometotal = 0;
                              @endphp
                                @foreach ($allincome as $key=>$item)
									@if($item->incomeamount > 0)
                                      <tr>
                                          @php
                                              $total += $item->incomeamount;
                                              $incometotal += $item->incomeamount;
                                          @endphp
                                          <td class="pl-5">{{$item->name}}</td>
                                          <td align="right">{{  number_format($item->incomeamount, 2) }}</td>

                                      </tr>
                                    @endif

                                @endforeach
                             
								<tr style="font-weight: bold">
                                    <td>Total Income</td>
                                    <td align="right">{{ number_format($incometotal, 2) }}</td>

                                </tr>

                                @endif

                                <tr style="font-weight: bold">
                                    <td>Total Operating Profit (Before Financial Expense & Tax)</td>
                                    <td align="right">{{ number_format($total, 2) }}</td>
                                </tr>

                              <tr style="font-weight: bold">
                                    <td colspan="2">Financial Expense</td>
                                </tr>
                              @php
                              $total_f_exp = 0;
                              @endphp
                            @if(!empty($financial_expenses))
                              	@foreach($financial_expenses as $val)
                                <tr>
                                  @php
                                  $total_f_exp += $val->expense;
                                  @endphp
                                  <td class="pl-5">{{$val->head}}</td>
                                  <td align="right">{{number_format($val->expense,2)}}</td>
                                </tr>
                              	@endforeach
                              @endif

                              @php
                              $total = $total - $total_f_exp;
                              @endphp
                              <tr style="font-weight: bold">
                                    <td> Operating Profit (Before Tax)</td>
                                    <td align="right">{{ number_format($total, 2) }}</td>
                                </tr>

                                <tr style="font-weight: bold">
                                    <td>Taxes</td>
                                    <td align="right">{{ $taxes }}% ({{number_format(($total/100)*($taxes), 2)}})</td>

                                </tr>

                            </tbody>

                            <tfoot>
                                <tr style="color:red; font-weight:bold">
                                    <th>Net Profit (After Tax)</th>
                                    <td align="right">{{ number_format(($total/100)*(100-$taxes), 2) }}</td>

                                </tr>

                            </tfoot>

                        </table>
                    </div>
				{{-- Inside code start--}}
                   <div class="py-4 col-md-4 table-responsive">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 13px;table-layout: inherit;">
                            <thead>
                              <tr>
                                <th colspan="2">C. O. G. S</th>
                                </tr>
                          </thead>
                          <tbody>
                            <tr class="text-center">
                                    <th>Head </th>
                                    <th>Amount (BDT)</th>
                            </tr>
                           {{-- @php 
                            $totalRawMCost = 0;
                            @endphp 
                            @foreach($rMCost as $val)
                              @php 
                              	$totalRawMCost += $val->stock_out_quantity * $val->stock_out_rate;
                              @endphp 
                            @endforeach --}}
                            <tr>
                              <td>Direct R.M Consumption</td>
                              <td align="right">{{number_format($cogsRaw, 2)}}</td>
                            </tr>
                           {{-- @php 
                            $totalRawMACost = 0;
                            @endphp 
                            @foreach($rMACost as $val)
                              @php 
                             	$totalRawMACost += $val->stock_out_quantity * $val->stock_out_rate;
                              @endphp 
                            @endforeach --}}
                            <tr>
                              <td>Medicine Consumption</td>
                              <td align="right">{{number_format($cogsRawM, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Packing Material Consumption</td>
                              <td align="right">{{number_format($packing_cost, 2)}}</td>
                            </tr> 
                            <tr>
                              <td>Labor Expenses (Direct)</td>
                              <td align="right">{{number_format($data['direct_labour_costs'], 2)}}</td>
                            </tr>
                            <tr>
                              <td>Prime Cost :</td>
                              <td align="right">{{number_format(($cogsRaw + $cogsRawM + $packing_cost + $data['direct_labour_costs']), 2)}}</td>
                            </tr>
                            </tbody>
                    </table>
                 
                        <table id="reporttable" class="mt-5 table table-bordered table-striped table-fixed"
                            style="font-size: 13px;table-layout: inherit;">
                            <thead>
                              <tr>
                                <th colspan="2">Manufacturing Overhead</th>
                                </tr>
                          </thead>
                          <tbody>
                            <tr class="text-center">
                                    <th>Head </th>
                                    <th>Amount (BDT)</th>
                            </tr>
                            @php 
                            	$totalMCost = 0;
                            @endphp 
                            @foreach($data['manufacturing_costs'] as $val)
                              @php 
                                  $totalMCost += $val->total_cost;
                              @endphp 
                            <tr>
                              <td>{{$val->head}}  </td>
                              <td align="right">{{number_format($val->total_cost, 2)}}</td>
                            </tr>
                            @endforeach
                           {{--  <tr>
                              <td>Salary-Casual	  </td>
                              <td align="right">{{number_format(65500, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Bonus-mgt	  </td>
                              <td align="right">{{number_format(90091, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Bonus-Casual	  </td>
                              <td align="right">{{number_format(6004, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Depreciation Expenses(Schedule of F.A.)</td>
                              <td align="right">{{number_format(2228000, 2)}}</td>
                            </tr>
                             <tr>
                              <td>Cost of Fuel & Lubricants 	  </td>
                              <td align="right">{{number_format(942143, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Storage & Spare Parts-prov </td>
                              <td align="right">{{number_format(400000, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Repair & Maintainance Expenses	    </td>
                              <td align="right">{{number_format(203190, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Electrical Goods </td>
                              <td align="right">{{number_format(153197, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Electricity Bill	   </td>
                              <td align="right">{{number_format(643058, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Entertainment Expenses</td>
                              <td align="right">{{number_format(26092, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Hardware Goods	  </td>
                              <td align="right">{{number_format(100000, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Lab Test Expenses	   </td>
                              <td align="right">{{number_format(259270, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Load & Unload Expenses</td>
                              <td align="right">{{number_format(4950, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Licence and Renewal Expenses-prov	  </td>
                              <td align="right">{{number_format(112000, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Medical Expenses</td>
                              <td align="right">{{number_format(3897, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Other Factory Expenses </td>
                              <td align="right">{{number_format(3740, 2)}}</td>
                            </tr> 
                            <tr>
                              <td>Printing & Stationery	   </td>
                              <td align="right">{{number_format(25632, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Telephone, Mobile & Internet	    </td>
                              <td align="right">{{number_format(9700, 2)}}</td>
                            </tr>
                            <tr>
                              <td>Travel & Conveyance	  	    </td>
                              <td align="right">{{number_format(2660, 2)}}</td>
                            </tr> --}}
                            <tr>
                              <td>Total Factory Overhead :</td>
                              <td align="right">{{number_format($totalMCost, 2)}}</td>
                            </tr>
                            </tbody>
                    </table>
                  </div> 
                  {{-- end--}}
					
                </div>
            </div>
        </div>
    </div>


@endsection

@push('end_js')

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
                filename: "Income_statement.xls"
            });
        });
    });
</script>

@endpush
