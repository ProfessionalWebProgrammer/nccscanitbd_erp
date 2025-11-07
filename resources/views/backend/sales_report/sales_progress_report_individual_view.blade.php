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
                      <button class="btn btn-sm  btn-success mt-1" id="btnExport"> Export  </button>
                      <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  > Print  </button>
                      <button class="btn btn-sm  btn-warning mt-1"  onclick="printland()"  id="printland"  > PrintLands. </button>
                    </div>
          </div>

            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh"  id="contentbody">
              <div class="row pt-2">
                  	<div class="col-md-4 text-left">

                      <h5 class="text-uppercase font-weight-bold">Sales Progress  Report (Individual) View</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
                <div class="py-4">
                    <table id="reporttable"  class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="table-header-fixt-top text-center">
                                <th>Vendor</th>
                                <th>Month</th>
                                <th>Opening Balance</th>
                                <th>Sales Kg/Ctn/Pack</th>
                                <th>Sales Amount </th>
                                <th>Receive Amount</th>
                                <th>Due Balance</th>
                              </tr>
                        </thead>
                        <tbody>
                          			@php
                          				$grandtotaldebit = 0;
                          				$grandtotalcredit = 0;
                          				$grandtotalcurrent = 0;
                          				$grand_total_qty = 0;
                      				    $grand_total_qtykg = 0;
                      				    $grand_total_pack = 0;
                          				$subtotaldlropbalance = 0;
                                    @endphp

                                    @foreach ($dealerData as $dlr)

                          	@if($dlr->qty_kg != null)
                                              @php
                          						  $stardate = "2021-01-01";
                          						  $beforeday = date("Y-m-d",strtotime("-1 day",strtotime($fdate)));


                            			$c_balane = $dlr->debit_a - $dlr->credit_a;

                                          $op_balance =  $c_balane;
                                          $dlr_op_balance = $dlr->dlr_base ?? 0  +$dlr->debit_a - $dlr->credit_a;

                                           $debit =  $dlr->debit;
                                            $credit =  $dlr->credit;

                          						  $current_balance = $debit - $credit;
                          						  $closing_balance = $op_balance-$current_balance;

                          						$cdata = DB::table('sales_ledgers')->leftjoin('sales_products','sales_ledgers.product_id','=','sales_products.id')
                                                           ->select(DB::raw('sum(debit) as `debit`,sum(credit) as credit,product_id,qty_pcs,sum(qty_pcs) as total_qty,sum(qty_kg) as qty_kg'),
                                                                        DB::raw('YEAR(ledger_date) year, MONTH(ledger_date) month'),
                                                                     DB::raw('sum(CASE WHEN sales_products.product_weight  = 50  THEN `qty_pcs` ELSE null END) as total_qty_50kg'),
                                                                     
                                                                     DB::raw('sum(CASE WHEN sales_products.product_weight_unit  = 4  THEN `qty_pcs` ELSE null END) as total_pices'),
                                                                     DB::raw('sum(CASE WHEN sales_products.product_weight_unit  = 2  THEN `qty_pcs` ELSE null END) as total_kgs'),
                                                                     DB::raw('sum(CASE WHEN sales_products.product_weight_unit  = 3  THEN `qty_pcs` ELSE null END) as total_packs'),
                                                                     
                                                                     )
                                                                    ->where('vendor_id',$dlr->id)
                                                                    ->whereBetween('ledger_date',[$fdate,$tdate])
                                                    ->groupby('year','month')
                                                    ->orderBy('month','asc')
                                                    ->get();
                                                    
                                                    //echo"<pre>";
                                                    //print_r($cdata);
                                                    //echo"</pre>";
                                              @endphp

                                              <tr>
                                                <td colspan="100%" style="color:blue"> {{ $dlr->d_s_name }}</td>
                                              {{--  <td class="text-right">{{number_format($debit)}} <span style="color:red">({{number_format($dlr->qty_kg/1000,2)}})</span></td>
                                                <td class="text-right">{{number_format($credit)}}</td>
                                                <td class="text-right">{{number_format($current_balance)}}</td> --}}
                                               </tr>

                          				 @foreach ($cdata as $key=>$value)

                          				@php
                          				    $due_balance = $dlr_op_balance + ($value->debit - $value->credit);
                          				    $subtotaldlropbalance += $dlr_op_balance;
                          				    
                          				    
                          				    $grandtotalcredit += $value->credit;
                          				    $grandtotaldebit += $value->debit;
                          				    $grandtotalcurrent += $due_balance;
                          				    
                          				    
                          					if($key == 0){
                          						$ratio ='';
                          						$ratiopercent= 0;
                          						}else{
                         						 $ratio = ($cdata[0]->qty_kg/1000 + $value->qty_kg/1000)/2;
                          						if($ratio != 0){
                         						 $ratiopercent = (100/$ratio)*$value->qty_kg/1000;
                          							}else{
                          								$ratiopercent =0;
                          								}

                          						}
                          						
                          						
                          						
                              				    $grand_total_qty += $value->total_pices;
                              				    $grand_total_qtykg += $value->total_kgs;
                              				    $grand_total_pack += $value->total_packs;

                          				@endphp

                          					 <tr>
                                               <td></td>
                                               <td><?=date('F', mktime(0, 0, 0, $value->month, 10))?> {{$value->year}}</td>
                                               <td class="text-right">{{number_format($dlr_op_balance, 2)}}</td>
                                       		  <!--<td class="text-right">{{number_format($value->qty_kg/1000,2)}} @if($key != 0) <span style="color:red">({{number_format($ratiopercent,2)}}%) @endif</span></td>-->
                                       		  <td class="text-right">
                                       		      @if($value->total_pices != '')
                                       		        {{number_format($value->total_pices, 2)}} Ctn 
                                       		      @endif
                                       		      
                                       		      @if($value->total_kgs != '')
                                       		        {{$value->total_pices != '' ? ' / ' : ''}}{{number_format($value->total_kgs, 2)}} Kg 
                                       		      @endif
                                       		      
                                       		      @if($value->total_packs != '')
                                       		        {{(($value->total_kgs != '') || ($value->total_pices != '')) ? ' / ' : ''}} {{number_format($value->total_packs, 2)}} Pack
                                       		      @endif
                                       		  </td>
                                       		  <td class="text-right">{{number_format($value->debit, 2)}}</td>
                                                <td class="text-right">{{number_format($value->credit, 2)}}</td>
                                                <td class="text-right">{{number_format($due_balance, 2)}}</td>
                                               </tr>
                          					 @endforeach
                          @endif

                                    @endforeach
                          					    <tr style="background-color:#1E8496;color:#ffffff;">
                                                    <td ></td>
                                                    <td> Grand Total :</td>
                                                    <td class="text-right">{{number_format($subtotaldlropbalance,2)}}</td>
                                                    <td class="text-right">

                                                        @if($grand_total_qty != '')
                                               		        {{number_format($grand_total_qty, 2)}} Ctn 
                                               		    @endif
                                               		      
                                               		    @if($grand_total_qtykg != '')
                                               		        {{$grand_total_qty != '' ? ' / ' : ''}}{{number_format($grand_total_qtykg, 2)}} Kg 
                                               		    @endif
                                               		      
                                               		    @if($grand_total_pack != '')
                                               		        {{(($grand_total_qtykg != '') || ($grand_total_qty != '')) ? ' / ' : ''}} {{number_format($grand_total_pack, 2)}} Pack
                                               		    @endif
                                       		      
                                                    </td>
                                                    <td class="text-right">{{number_format($grandtotaldebit, 2)}} </td>
                                                    <td class="text-right">{{number_format($grandtotalcredit, 2)}}</td>
                                                    <td class="text-right">{{number_format($grandtotalcurrent, 2)}}</td>
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
                filename: "Sales Stoct Report.xls"
            });
        });
    });
</script>
@endsection
