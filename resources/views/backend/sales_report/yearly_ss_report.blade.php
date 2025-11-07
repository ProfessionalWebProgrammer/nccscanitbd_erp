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
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn">
                       Print
                    </button>
                    </div>
                </div>

            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh" id="contentbody">

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Yearly Sales Statement Report</h5>
                      <p>Year-{{$get_year}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>

                <div class="py-4 table-responsive">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed" style="font-size: 14px;">
                        <thead>
                            @php
                            $STJanuary=0;
                            $STFebruary=0;
                            $STMarch=0;
                            $STApril=0;
                            $STMay=0;
                            $STJune=0;
                            $STJuly=0;
                            $STAugust=0;
                            $STSeptember=0;
                            $STOctober=0;
                            $STNovember=0;
                            $STDecember=0;
                            $STcredit=0;
                            @endphp
                            <tr class="table-header-fixt-top">
                                <th>SI</th>
                                <th>Vedor</th>
                                <th>Jan</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Apr</th>
                                <th>May</th>
                                <th>June</th>
                                <th>July</th>
                                <th>Aug</th>
                                <th>Sep</th>
                                <th>Oct</th>
                                <th>Nov</th>
                                <th>Dec</th>
                                <th>Target</th>
                                <th>Pre.Credit</th>
                                <th>Credit Limit</th>
                            </tr>
                        </thead>
                        <tbody>
                         @php
                            $GTJanuary=0;
                            $GTFebruary=0;
                            $GTMarch=0;
                            $GTApril=0;
                            $GTMay=0;
                            $GTJune=0;
                            $GTJuly=0;
                            $GTAugust=0;
                            $GTSeptember=0;
                            $GTOctober=0;
                            $GTNovember=0;
                            $GTDecember=0;
                            $GTcredit=0;
                       @endphp


                            @foreach($area as $key=>$areadata)
                            @php
                            $stardate = "2021-01-01";
                            $tdate = $get_year."-12-31";

                            $dealers=DB::table('sales_ledgers as t1')
                                      ->select('t1.vendor_id as dealer_id','t2.d_s_name','t2.dlr_base','t2.monthly_target','t2.dlr_police_station',
                                      DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = 1 AND YEAR(t1.ledger_date) = "'.$get_year.'" THEN `qty_kg` ELSE null END) as total_qty_1'),
                                      DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = 2 AND YEAR(t1.ledger_date) = "'.$get_year.'" THEN `qty_kg` ELSE null END) as total_qty_2'),
                                      DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = 3 AND YEAR(t1.ledger_date) = "'.$get_year.'" THEN `qty_kg` ELSE null END) as total_qty_3'),
                                      DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = 4 AND YEAR(t1.ledger_date) = "'.$get_year.'" THEN `qty_kg` ELSE null END) as total_qty_4'),
                                      DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = 5 AND YEAR(t1.ledger_date) = "'.$get_year.'" THEN `qty_kg` ELSE null END) as total_qty_5'),
                                      DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = 6 AND YEAR(t1.ledger_date) = "'.$get_year.'" THEN `qty_kg` ELSE null END) as total_qty_6'),
                                      DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = 7 AND YEAR(t1.ledger_date) = "'.$get_year.'" THEN `qty_kg` ELSE null END) as total_qty_7'),
                                      DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = 8 AND YEAR(t1.ledger_date) = "'.$get_year.'" THEN `qty_kg` ELSE null END) as total_qty_8'),
                                      DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = 9 AND YEAR(t1.ledger_date) = "'.$get_year.'" THEN `qty_kg` ELSE null END) as total_qty_9'),
                                      DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = 10 AND YEAR(t1.ledger_date) = "'.$get_year.'" THEN `qty_kg` ELSE null END) as total_qty_10'),
                                      DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = 11 AND YEAR(t1.ledger_date) = "'.$get_year.'" THEN `qty_kg` ELSE null END) as total_qty_11'),
                                      DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = 12 AND YEAR(t1.ledger_date) = "'.$get_year.'" THEN `qty_kg` ELSE null END) as total_qty_12'),
                                      DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "'.$stardate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit_a'),
                                      DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "'.$stardate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit_a'))
                                      ->join('dealers as t2','t1.vendor_id','=','t2.id')
                                        ->where('t2.dlr_area_id',$areadata->id)
                                        ->groupBy('dealer_id')
                                        ->orderBy('d_s_name')->get();

                              // dd($ddd);

                           // $dealers = DB::select('SELECT * FROM `dealers` WHERE dlr_area_id= "'.$areadata->id.'" ');

                            $STJanuary=0;
                            $STFebruary=0;
                            $STMarch=0;
                            $STApril=0;
                            $STMay=0;
                            $STJune=0;
                            $STJuly=0;
                            $STAugust=0;
                            $STSeptember=0;
                            $STOctober=0;
                            $STNovember=0;
                            $STDecember=0;
                            $STcredit=0;
                            @endphp
                            <tr style="color: rgb(238, 238, 255);font-size: 14;font-weight: bold;">
                                <td colspan="100%">{{$areadata->area_title}} - {{$areadata->main_zone}} Zone - {{$areadata->zone_title}}</td>
                            </tr>

                            @foreach($dealers as $key=>$data)

                            @php
                        $January_sale = $data->total_qty_1;
                        $January = round($January_sale/1000,2);

                         $February_sale =$data->total_qty_2;
                        $February = round($February_sale/1000,2);

                        $March_sale = $data->total_qty_3;
                        $March = round($March_sale/1000,2);

                       $April_sale = $data->total_qty_4;
                        $April = round($April_sale/1000,2);

                          $May_sale = $data->total_qty_5;
                        $May = round($May_sale/1000,2);

                           $June_sale = $data->total_qty_6;
                        $June = round($June_sale/1000,2);

                           $July_sale = $data->total_qty_7;
                        $July = round($July_sale/1000,2);

                           $August_sale = $data->total_qty_8;
                        $August = round($August_sale/1000,2);

                          $September_sale =$data->total_qty_9;
                        $September = round($September_sale/1000,2);

                        $October_sale = $data->total_qty_10;
                        $October = round($October_sale/1000,2);

                        $November_sale = $data->total_qty_11;
                        $November = round($November_sale/1000,2);

                        $December_sale = $data->total_qty_12;
                        $December = round($December_sale/1000,2);



                                    $op_b = $data->dlr_base;



                                        $c_balane = $data->debit_a - $data->credit_a;
                         $credit = $c_balane + $op_b;

                       // $credit = 0;



                            $STJanuary+=$January;
                            $STFebruary+=$February;
                            $STMarch+=$March;
                            $STApril+=$April;
                            $STMay+=$May;
                            $STJune+=$June;
                            $STJuly+=$July;
                            $STAugust+=$August;
                            $STSeptember+=$September;
                            $STOctober+=$October;
                            $STNovember+=$November;
                            $STDecember+=$December;
                            $STcredit+=$credit;


                            $GTJanuary+=$January;
                            $GTFebruary+=$February;
                            $GTMarch+=$March;
                            $GTApril+=$April;
                            $GTMay+=$May;
                            $GTJune+=$June;
                            $GTJuly+=$July;
                            $GTAugust+=$August;
                            $GTSeptember+=$September;
                            $GTOctober+=$October;
                            $GTNovember+=$November;
                            $GTDecember+=$December;
                            $GTcredit+=$credit;

                            @endphp

                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->d_s_name}}</td>
                                <td>{{$January}}</td>
                                <td>{{$February}}</td>
                                <td>{{$March}}</td>
                                <td>{{$April}}</td>
                                <td>{{$May}}</td>
                                <td>{{$June}}</td>
                                <td>{{$July}}</td>
                                <td>{{$August}}</td>
                                <td>{{$September}}</td>
                                <td>{{$October}}</td>
                                <td>{{$November}}</td>
                                <td>{{$December}}</td>
                                <td>{{$data->monthly_target}}</td>
                                <td>{{number_format($credit,2)}}</td>
                                <td>{{number_format($data->dlr_police_station,2)}}</td>
                            </tr>
                            @endforeach
                            <tr style="background-color: #e9e2d8; font-weight: bold;">
                               <td></td>
                               <td>Sub Total</td>

                                <td>{{$STJanuary}}</td>
                                <td>{{$STFebruary}}</td>
                                <td>{{$STMarch}}</td>
                                <td>{{$STApril}}</td>
                                <td>{{$STMay}}</td>
                                <td>{{$STJune}}</td>
                                <td>{{$STJuly}}</td>
                                <td>{{$STAugust}}</td>
                                <td>{{$STSeptember}}</td>
                                <td>{{$STOctober}}</td>
                                <td>{{$STNovember}}</td>
                                <td>{{$STDecember}}</td>
                                <td></td>
                                <td>{{number_format($STcredit,2)}}</td>
                                <td></td>
                            </tr>
                            @endforeach
                            <tr style="background-color: #bdbdbd; font-weight: bold;">
                              <td></td>
                               <td>Grend Total</td>

                                <td>{{$GTJanuary}}</td>
                                <td>{{$GTFebruary}}</td>
                                <td>{{$GTMarch}}</td>
                                <td>{{$GTApril}}</td>
                                <td>{{$GTMay}}</td>
                                <td>{{$GTJune}}</td>
                                <td>{{$GTJuly}}</td>
                                <td>{{$GTAugust}}</td>
                                <td>{{$GTSeptember}}</td>
                                <td>{{$GTOctober}}</td>
                                <td>{{$GTNovember}}</td>
                                <td>{{$GTDecember}}</td>
                                <td></td>
                                <td>{{number_format($GTcredit,2)}}</td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>

                        </tfoot>
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
                filename: "Yearly Sales Report.xls"
            });
        });
    });
</script>
@endsection
