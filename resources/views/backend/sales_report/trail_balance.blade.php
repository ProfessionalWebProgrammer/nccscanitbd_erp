@extends('layouts.sales_dashboard')

@section('print_menu')

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->


    <div class="content-wrapper" >


        <!-- Main content -->
        <div class="content px-4 " >
          <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	<button class="btn btn-sm  btn-success mt-1" id="btnExport"  > Export  </button>
                      	<button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  > Print  </button>
                      	<button class="btn btn-sm  btn-warning mt-1"  onclick="printland()"  id="printland"  >  PrintLands. </button>
                    </div>
                </div>
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh" id="contentbody">
              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Trail Balance</h5>
                    <h6>From {{ date('d F Y', strtotime($fdate)) }}
                        To
                        {{ date('d F Y', strtotime($tdate)) }}</h6>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
        @if($list_type == 1 || $list_type == 0)
        <h3>Sales Trail Balance</h3>
                <div class="table-responsive" style="font-size:15px;">
                    <table id="reporttable" class="table table-bordered" style="width:98%;font-size: 13px;font-weight: bolder;">
                         <thead style="font-size: 18px; font-weight: bold;">
                            <tr class="table-header-fixt-top">
                                <th>Vendor Ledger</th>
                                <th>Opening Balance</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Current Balance</th>
                                <th>Closing Balance</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $sttotal_d=0;
                            $fttotal_d=0;
                            $sttotal_c=0;
                            $stbalance=0;
                            $stcbalance=0;
                        @endphp

                        @foreach($dlr_area as $area)
                        @php

                        @endphp
                       			 <tr>
                                     <th  colspan="100%" style="font-size: 15px;font-weight: bold; color: #8282ff">{{$area->area_title}}</th>
                                 </tr>

                                    @php
                                    $predate=date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
                                     $sdate = "2021-01-01";

                                        //$dealerData =  DB::table('dealers')->where('dlr_area_id',$area->id)->get();
                                      //  $dealerData =  DB::select('SELECT * FROM `dealers`
                                   	    //    			WHERE dlr_area_id = "'.$area->id.'" ');

                                        $dealerData =  DB::select('SELECT dealers.id,dealers.d_s_name,dealers.dlr_base,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$sdate.'" AND "'.$predate.'" THEN `debit` ELSE null END) as debit_a,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$sdate.'" AND "'.$predate.'" THEN `credit` ELSE null END) as credit_a,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit
                                        FROM `sales_ledgers`
                                        LEFT JOIN dealers ON dealers.id = sales_ledgers.vendor_id
                                   	    WHERE dealers.dlr_area_id = "'.$area->id.'"
                                        GROUP BY dealers.id');
                                   //dd($dddata);
                                        $stotal_d=0;
                                        $stotal_c=0;
                                         $ssb =  0;
                                        $sbalance = 0;


                                    @endphp

                                    @foreach($dealerData as $data)
                                    @php



                                          $c_balane = $data->debit_a - $data->credit_a;

                                          $openingnbalance =  $c_balane;

                                   $debit =  $data->debit;
                                   $credit =  $data->credit;


                                    $stotal_d +=$debit;
                                    $fttotal_d +=$debit;
                                    $stotal_c +=$credit;
                                     $ssb +=$debit-$credit;
                                    $sbalance += ($openingnbalance+$debit)-$credit;

                                    $sttotal_d +=$debit;
                                    $sttotal_c +=$credit;
                                    $stbalance +=$debit-$credit;
                                    $stcbalance +=($openingnbalance+$debit)-$credit;
                                    @endphp
                                    <tr>
                                        <td>{{$data->d_s_name}}</td>
                                        <td>{{number_format($openingnbalance,2)}}
                                            @if($openingnbalance < 0 )
                                            <span style="color:rgb(103, 103, 255)">(Cr) </span>
                                            @endif
                                             @if($openingnbalance >= 0 )
                                            <span style="color:rgb(255, 106, 106)">(Dr) </span>
                                            @endif
                                        </td>
                                        <td>{{number_format($debit,2)}}</td>
                                        <td>{{number_format($credit,2)}}</td>
                                        <td>{{number_format($debit-$credit,2)}}</td>
                                        <td>{{number_format(($openingnbalance+$debit)-$credit,2)}}
                                            @if(($openingnbalance+$debit)-$credit < 0 )
                                            <span style="color:rgb(129, 129, 255)">(Cr) </span>
                                            @endif
                                             @if(($openingnbalance+$debit)-$credit >= 0 )
                                            <span style="color:red">(Dr) </span>
                                            @endif
                                        </td>

                                    </tr>
                                    @endforeach
                                    @if($dlr_area->count() != 1)
                                        <tr style="background: rgba(222, 184, 135, 0.24);">
                                            <td></td>
                                            <td>SubTotal =</td>
                                            <td>{{number_format($stotal_d,2)}}</td>
                                            <td>{{number_format($stotal_c,2)}}</td>
                                            <td>{{number_format($ssb,2)}}</td>
                                            <td>{{number_format($sbalance,2)}}
                                            @if($sbalance < 0 )
                                            <span style="color:rgb(134, 134, 255)">(Cr) </span>
                                            @endif
                                             @if($sbalance >= 0 )
                                            <span style="color:rgb(255, 97, 97)">(Dr) </span>
                                            @endif
                                        </td>
                                        </tr>
                                     @endif
                              @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background: #bdb4b556;">
                                    <td></td>
                                    <td>Total =</td>
                                    <td>{{number_format($sttotal_d,2)}}</td>
                                    <td>{{number_format($sttotal_c,2)}}</td>
                                    <td>{{number_format($stbalance,2)}}</td>
                                    <td>{{number_format($stcbalance,2)}}
                                            @if($stcbalance < 0 )
                                            <span style="color:rgb(112, 112, 255)">(Cr) </span>
                                            @endif
                                             @if($stcbalance >= 0 )
                                            <span style="color:rgb(255, 112, 112)">(Dr) </span>
                                            @endif
                                        </td>
                                </tr>
                            </tfoot>

                    </table>


                </div>
                @endif
                @if($list_type == 2 || $list_type == 0)
                <h3>Purchase Trail Balance</h3>

                <div class="table-responsive" style="font-size:15px;">
                    <table id="" class="table table-bordered" style="width:98%;font-size: 13px;font-weight: bolder;">
                         <thead style="font-size: 18px; font-weight: bold;">
                            <tr>
                                <th>Supplier Ledger</th>
                                <th>Opening Balance</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Current Balance</th>
                                <th>Closing Balance</th>
                            </tr>
                        </thead>



                    </table>


                </div>
                @endif

                @if($list_type == 3  || $list_type == 0)
                <h3>Expanse Trail Balance</h3>
                 <div class="table-responsive" style="font-size:15px;">
                    <table id="" class="table table-bordered" style="width:98%;font-size: 13px;font-weight: bolder;">
                         <thead style="font-size: 18px;">
                            <tr>
                                <th>Expanse</th>
                                <th>Oprning Balance</th>
                                <th>Total Debit</th>
                                <th>Total Credit</th>
                                <th>Closing Balance</th>

                            </tr>
                        </thead>

                        <tbody>
                        @php
                        $total_exp = 0;
                        $total_cre = 0;
                        @endphp
                          @foreach($espanse_group as $data)

                         		<tr>
                                     <th  colspan="100%">{{$data->group_name}}</th>
                                 </tr>
                            @php
                            $subtotal_exp = 0;
                            $subtotal_cre = 0;

                         	 $expanse_data = DB::table('payments as t1')
                          			->select('t1.expanse_subgroup_id','t2.subgroup_name',DB::raw("SUM(amount) as total_amount"))
                            		->leftJoin('expanse_subgroups as t2', 't1.expanse_subgroup_id', '=', 't2.id')
                                     ->whereNotNull('expanse_subgroup_id')
                                     ->where('t2.group_id',$data->group_id)
                                     ->whereBetween('payment_date',[$fdate,$tdate])
                                     ->groupBy('expanse_subgroup_id','subgroup_name')
                                     ->get();



					      	 @endphp
                             @foreach($expanse_data as $exp)
                               @php

                                $total_exp += $exp->total_amount;
                                $subtotal_exp += $exp->total_amount;

                                $credit = \App\Models\Payment::where('expanse_subgroup_id', $exp->expanse_subgroup_id)->where('payment_type','RECEIVE')->where('type','CASH')->whereBetween('payment_date',[$fdate,$tdate])->sum('amount');

                                $subtotal_cre += $credit;
                                $total_cre  += $credit;
                                @endphp
                                <tr >
                                           <td>{{$exp->subgroup_name}}</td>
                                           <td></td>
                                           <td>{{$exp->total_amount}}</td>
                                           <td>{{$credit}}</td>
                                           <td></td>
                                </tr>
                              @endforeach
                                 <tr style="background: rgba(222, 184, 135, 0.274);" >
                                            <td align="right">SubTotal =</td>
                                            <td></td>
                                            <td>{{number_format($subtotal_exp,2)}}</td>
                                            <td>{{number_format($subtotal_cre,2)}}</td>
                                            <td></td>
                                        </tr>
                          @endforeach
                        </tbody>
                            <tfoot>
                                <tr style="background: #bdb4b546;" >
                                   <td align="right">Total =</td>
                                   <td></td>
                                     <td>{{number_format($total_exp,2)}}</td>
                                     <td>{{number_format($total_cre,2)}}</td>
                                    <td></td>

                                </tr>
                            </tfoot>

                    </table>


                </div>
             @endif
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
                   filename: "Sales Trail Balance.xls"
            });
        });
    });
</script>
@endsection
