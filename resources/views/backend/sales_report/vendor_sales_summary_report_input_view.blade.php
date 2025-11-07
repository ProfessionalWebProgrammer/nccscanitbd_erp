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

                      <h5 class="text-uppercase font-weight-bold">Vendor Sales Summary Report View</h5>
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
                                <th>Ledger</th>
                                <th>Opening Balance</th>
                                <th>Sales</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Current Balance</th>
                                <th>Closing Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                          			@php
                          				$grandtotalopening = 0;
                          				$grandtotalsales = 0;
                          				$grandtotaldebit = 0;
                          				$grandtotalcredit = 0;
                          				$grandtotalcurrent = 0;
                          				$grandtotalclsing = 0;
                                    @endphp
                         	@foreach ($areas as $area)

                                          <tr style="background-color:#C641CF;color:#ffffff;">
                                            <td colspan="7"> {{ $area->area_title }}</td>
                                          </tr>
                                    @php
                                        if($delar == ''){
                                                $delars = DB::table('dealers')->where('dlr_area_id', $area->id)->get();
                                          }else{
                                                $delars = DB::table('dealers')->whereIn('dlr_type_id',$delar)->where('dlr_area_id', $area->id)->get();
                                          }
                          				$subtotalopening = 0;
                          				$subtotalsales = 0;
                          				$subtotaldebit = 0;
                          				$subtotalcredit = 0;
                          				$subtotalcurrent = 0;
                          				$subtotalclsing = 0;
                                    @endphp

                                    @foreach ($delars as $dlr)
                                              @php
                          						  $stardate = "2021-01-01";
                          						  $beforeday = date("Y-m-d",strtotime("-1 day",strtotime($fdate)));

                          						  $op_balance = DB::table('sales_ledgers')->whereBetween('ledger_date',[$stardate, $beforeday])->where('vendor_id',$dlr->id)->orderby('id','desc')->value('closing_balance');

                                                  /*$totalsales = DB::Table('sales')->where('dealer_id', $dlr->id)->whereBetween('date', [$fdate, $tdate])->sum('total_qty');
                          						 $totaldebit = DB::Table('sales')->where('dealer_id', $dlr->id)->whereBetween('date', [$fdate, $tdate])->sum('grand_total');*/
                          
                          						  $totalsales = DB::Table('sales_ledgers')->where('vendor_id', $dlr->id)->whereBetween('ledger_date', [$fdate, $tdate])->sum('qty_pcs');
                                                  $totaldebit = DB::Table('sales_ledgers')->where('vendor_id', $dlr->id)->whereBetween('ledger_date', [$fdate, $tdate])->sum('debit');
                          						  $totalcredit =DB::table('payments') ->where('vendor_id',$dlr->id)->where('payment_type','RECEIVE')->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
                          						  $current_balance = $totalcredit - $totaldebit;
                          						  $closing_balance = $op_balance-$current_balance;

                                                  $subtotalopening += $op_balance;
                                                  $subtotalsales += $totalsales;
                                                  $subtotaldebit += $totaldebit;
                                                  $subtotalcredit += $totalcredit;
                                                  $subtotalcurrent += $current_balance;
                                                  $subtotalclsing += $closing_balance;

                                              @endphp

                                              <tr>
                                                <td> {{ $dlr->d_s_name }}</td>
                                                <td class="text-right">{{number_format($op_balance, 2)}}</td>
                                                <td class="text-right">{{number_format($totalsales,2)}}</td>
                                                <td class="text-right">{{number_format($totaldebit,2)}}</td>
                                                <td class="text-right">{{number_format($totalcredit,2)}}</td>
                                                <td class="text-right">{{number_format($current_balance,2)}}</td>
                                                <td class="text-right">{{number_format($closing_balance,2)}}</td>
                                              </tr>

                                    @endforeach
                          					  <tr style="background-color:#1E8496;color:#ffffff;">
                                                <td> Subtotal :</td>
                                                <td class="text-right">{{number_format($subtotalopening,2)}}</td>
                                                <td class="text-right">{{number_format($subtotalsales,2)}}</td>
                                                <td class="text-right">{{number_format($subtotaldebit,2)}}</td>
                                                <td class="text-right">{{number_format($subtotalcredit,2)}}</td>
                                                <td class="text-right">{{number_format($subtotalcurrent,2)}}</td>
                                                <td class="text-right">{{number_format($subtotalclsing,2)}}</td>
                                              </tr>
                          			@php
                          				$grandtotalopening += $subtotalopening;
                          				$grandtotalsales += $subtotalsales;
                          				$grandtotaldebit += $subtotaldebit;
                          				$grandtotalcredit += $subtotalcredit;
                          				$grandtotalcurrent += $subtotalcurrent;
                          				$grandtotalclsing += $subtotalclsing;
                                    @endphp

                            @endforeach
                          					<tr style="background-color:#FA621C;color:#ffffff;">
                                                <td> Grand Total :</td>
                                                <td class="text-right">{{number_format($grandtotalopening,2)}}</td>
                                                <td class="text-right">{{number_format($grandtotalsales,2)}}</td>
                                                <td class="text-right">{{number_format($grandtotaldebit,2)}}</td>
                                                <td class="text-right">{{number_format($grandtotalcredit,2)}}</td>
                                                <td class="text-right">{{number_format($grandtotalcurrent,2)}}</td>
                                                <td class="text-right">{{number_format($grandtotalclsing,2)}}</td>
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
