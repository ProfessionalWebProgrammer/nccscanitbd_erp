@extends('layouts.sales_dashboard')
@section('print_menu')

			<li class="nav-item">

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
                    </div>
                </div>

            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh" id="contentbody">

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Yearly Company Short Summary Report</h5>
                      <p>Year - {{$year}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>

                <div class="text-center pt-3 ">
                    <h5 class="text-uppercase font-weight-bold">Yearly Company Short Summary Report DD</h5>
                    <hr>
                </div>




                <div class="py-4 table-responsive">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed" style="font-size: 14px;">
                       <thead style="border: 1px solid #515151;">
                                  <tr class="table-header-fixt-top">

                                <th>Month</th>
                                <th>Total Target</th>
                                <th>Total Sales</th>
                                <th>Total Achive</th>

                              @foreach($categorys as $key => $cat)
                              @php
                              $cattarget[$key] = 0;
                              @endphp
                               <th>{{$cat->category_name}}</th>

                              @endforeach


                            </tr>



                        </thead>
                        <tbody>
                          @php
                          $totaltarget = 0;
                          $totalsale = 0;
                          @endphp

                            @foreach($areas as $data)
                            @php
                        //    $target = \App\Models\Lmcommisiontarget::where('employe_area_id',$data->id)
                       //                               ->whereYear('from_date', $year)
                        //                              ->sum('target_amount');
                           $target = \App\Models\Lmcommisiontarget::select(
          				      DB::raw('sum(target_amount) as `target`'),
                				DB::raw('YEAR(from_date) year, MONTH(from_date) month')
             					)->where('employe_area_id',$data->id)
                                                      ->whereYear('from_date', $year)
                           							->groupby('year', 'month')
                                                        ->orderBy('month', 'asc')
                                                        ->get();




                           $count = count($target);
                         // dd($count);
                        //   $totaltarget += $target;
                         // $totalsale += $qty/1000;

                          $subtarget = 0;
                          $subqty= 0;

                            @endphp

                          <tr>  <td   colspan="100%" style="color:red; font-size:16px">{{$data->area_title}}</td> </tr>

                                @foreach($target as $key => $tdata)


                          			@php
                          				$qty = DB::table('montly_sales_targets')->where('area_id',$data->id)->whereMonth('date', $tdata->month)->whereYear('date', $year)->sum('qty_kg');

                                       $subtarget += $tdata->target;
                                      $subqty += $qty/1000;
                          			@endphp
                                  <tr>

                                    <td align="center">{{date('F', strtotime($year.'-'.$tdata->month))}}</td>
                                    <td align="right">{{$tdata->target}}</td>
                                    <td align="right">{{$qty/1000}}</td>
                                    @if($tdata->target != 0 && $qty/1000 != 0)
                                  <td align="right">{{round((($qty/1000)/$tdata->target)*100, 2)}}</td>
                                  @else
                                      <td>0</td>
                             	 @endif

                                     @foreach($categorys as $key => $cat)
                                    @php
                          				$catqty = DB::table('montly_sales_targets')->where('area_id',$data->id)->where('category_id',$cat->id)->whereMonth('date', $tdata->month)->whereYear('date', $year)->sum('qty_kg');
                          			$cattarget[$key] += $catqty/1000;
                                    @endphp

                                       <td align="right">{{$catqty/1000}}</td>

                                      @endforeach



                                    </tr>
                                @endforeach

                             <tr style=" background-color: #827d789c;">
                                  <td>SubTotal</td>

                                  <td align="right">{{$subtarget}}</td>
                                  <td align="right">{{$subqty}}</td>
                                 @if($subtarget != 0 && $subqty != 0)
                                  <td align="right">{{round((($subqty)/$subtarget)*100, 2)}}</td>
                                  @else
                                <td>0</td>
                             	 @endif

                                 @foreach($categorys as $key => $cat)

                                 <td align="right">{{$cattarget[$key]}}</td>

                                @endforeach

                              </tr>

                            @endforeach

                     {{--   <tr style=" background-color: #827d789c;">
                            <th>Total</th>
                            <th>{{$totaltarget}}</th>
                            <th>{{$totalsale}}</th>

                        </tr> --}}



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
                filename: "Yearly Sales Report.xls"
            });
        });
    });
</script>
@endsection
