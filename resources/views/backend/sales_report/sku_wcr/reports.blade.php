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
                      <button class="btn btn-sm btn-info mt-1"  onclick="printland()"><i class="fa fa-print" aria-hidden="true"> </i> PrintLands. </button>
                    </div>
          </div>

            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh"  id="contentbody">
              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">SKU Wise COGS Report</h5>
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
                            <tr class="table-header-fixt-top">
                                <th>SI No</th>
                                <th>Category</th>
                                <th>Brand Code</th>
                                <th>Brand Name</th>
                                <th>SKU Name</th>
                                <th>SKU Code</th>
                                <th>RM</th>
                                <th>PM</th>
                                <th>Total RM+PM</th>
                                <th>%</th>
                                <th>OH</th>
                                <th>Total COGS</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $g_rm = 0;
                            $g_pm = 0;
                            $g_percentage = 0;
                            $g_oh = 0;
                            $g_cogs = 0;
                            $i = 0;
                        @endphp
                                @foreach($allRawProducts as $raw)
                                    @php
                                        $pm = App\Models\PackingStockOut::where('invoice','LIKE','Sal-%')
                                        ->where('status',1)
                                        ->where('product_id',$raw->product_id)
                                        ->whereBetween('date',[$fdate, $tdate])
                                        ->sum('amount');
                                        
                                        $rm_pm = $pm + $raw->amount;
                                        $percentage = ($rm_pm / $grandTotalRawProductsAmount) * 100;
                                        $oh = ($totalFOverHead * $percentage) / 100;
                                        $cogs = $rm_pm + $oh;
                                        
                                        $g_rm += $raw->amount;
                                        $g_pm += $pm;
                                        $g_percentage += $percentage;
                                        $g_oh += $oh;
                                        $g_cogs += $cogs;
                                        $i++;
                                    @endphp

                                    <tr style="font-size: 13x; @if($raw->qty < 0)  color: red; @else  @endif">
                                      {{--<td>{{$loop->iteration}}</td>--}}
                                      <td>{{$i}}</td>
                                      <td>{{$raw->product->sales_category->category_name ?? ''}}</td>
                                      <td>{{$raw->product->product_code ?? ''}}</td>
                                      <td>{{$raw->product->product_name ?? ''}}</td>
                                      <td>{{$raw->product->product_name ?? ''}}</td>
                                      <td>{{$raw->product->product_code ?? ''}}</td>
                                      <td title="RM" class="text-right">{{number_format($raw->amount,2)}}</td>
                                      <td title="PM">{{number_format($pm,2)}}</td>
                                      <td title="RM+PM" class="text-right">{{number_format($rm_pm,2)}}</td>
                                      <td title="%">
                                          {{number_format($percentage,2)}}%
                                      </td>
                                      <td title="OH">{{number_format($oh,2)}}</td>
                                      <td title="Total COGS" class="text-right">{{number_format($cogs,2)}}</td>
                                    </tr>
                                @endforeach

                                @foreach($rawProducts as $val)
                                    @php
                                        $pm = App\Models\PackingStockOut::where('invoice','LIKE','Sal-%')
                                            ->where('status',1)
                                            ->where('product_id',$val->product_id)
                                            ->whereBetween('date',[$fdate, $tdate])
                                            ->sum('amount');
                                            
                                        $rm_pm = $pm + $val->total_amount;
                                        $percentage = ($rm_pm / $grandTotalRawProductsAmount) * 100;
                                        $oh = ($totalFOverHead * $percentage) / 100;
                                        $cogs = $rm_pm + $oh;
                                            
                                        
                                        $g_rm += $val->total_amount;
                                        $g_pm += $pm;
                                        $g_percentage += $percentage;
                                        $g_oh += $oh;
                                        $g_cogs += $cogs;
                                        $i++;
                                    @endphp

                                    <tr style="font-size: 13x; @if($val->stock_out_quantity < 0)  color: red; @else  @endif">
                                      <td>{{$i}}</td>
                                      <td>{{$val->product->sales_category->category_name ?? ''}}</td>
                                      <td>{{$val->product->product_code ?? ''}}</td>
                                      <td>{{$val->product->product_name ?? ''}}</td>
                                      <td>{{$val->product->product_name ?? ''}}</td>
                                      <td>{{$val->product->product_code ?? ''}}</td>
                                      <td title="RM" class="text-right">{{number_format($val->total_amount,2)}}</td>
                                      <td title="PM">{{number_format($pm,2)}}</td>
                                      <td title="RM+PM" class="text-right">{{number_format($rm_pm,2)}}</td>
                                      <td title="%">
                                          {{number_format($percentage,2)}}%
                                      </td>
                                      <td title="OH">{{number_format($oh,2)}}</td>
                                      <td title="Total COGS" class="text-right">{{number_format($cogs,2)}}</td>
                                    </tr>
                                @endforeach

                                @foreach($allFgProducts as $fg)
                                @php
                                
                                $g_pm += 0;
                                $g_percentage += 0;
                                $g_oh += 0;
                                $g_cogs += $fg->amount;
                                $i++;
                                @endphp

                                <tr style="font-size: 13x; @if($fg->qty < 0)  color: red; @else  @endif">
                                  <td>{{$i}}</td>
                                  <td>{{$fg->product->sales_category->category_name ?? ''}}</td>
                                  <td>{{$fg->product->product_code ?? ''}}</td>
                                  <td>{{$fg->product->product_name ?? ''}}</td>
                                  <td>{{$fg->product->product_name ?? ''}}</td>
                                  <td>{{$fg->product->product_code ?? ''}}</td>
                                  <td title="RM" class="text-right">0</td>
                                  <td title="PM">0</td>
                                  <td title="RM+PM" class="text-right">0</td>
                                  <td title="%">0</td>
                                  <td title="OH">0</td>
                                  <td title="Total COGS" class="text-right">{{number_format($fg->amount,2)}}</td>
                                </tr>
                                @endforeach
                         </tbody>
                           <tfoot>
                                
                            <tr style="background-color: #e1936e;">
                                <th colspan="6">Grand Total</th>
                          		<td title="RM" class="text-right">{{number_format($g_rm,2)}}</td>
                                <td title="PM">{{number_format($g_pm,2)}}</td>
                                <td title="RM+PM" class="text-right">{{number_format(($grandTotalRawProductsAmount + $g_pm),2)}}</td>
                                <td title="%">{{number_format($g_percentage,2)}}%</td>
                                <td title="OH">{{number_format($g_oh,2)}}</td>
                                <td title="Total COGS" class="text-right">{{number_format($g_cogs,2)}}</td>
                            </tr>
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

        function printland() {

                  	printJS({
                      printable: 'contentbody',
                      type: 'html',
                       font_size: '16px;',
                      style: ' @page  { size: A4 landscape; max-height:100%; max-width:100%} table, th, td {border: 1px solid black; font-size:16px!important; border-collapse: collapse; padding: 0px 3px} h3{margin: 0!important;padding: 0 !important; text-align:center;} h5{margin: 0!important;padding: 0 !important; text-align:center;} p{margin: 0!important;padding: 0 !important; text-align:center;} h6{margin: 0!important;padding: 0 !important; text-align:center;} .cominfo{text-align:center;margin-left:8rem;} .pageinfo{text-align:center;margin-left:8rem;margin-bottom:2rem;padding: 0 !important;}'
                    });
              }
</script>

<script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#reporttable").table2excel({
                filename: "Sales_cogs_Report.xls"
            });
        });
    });
</script>
@endsection
