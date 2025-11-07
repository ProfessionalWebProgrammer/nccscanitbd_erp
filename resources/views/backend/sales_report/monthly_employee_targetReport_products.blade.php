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
                  	<div class="col-md-8 m-auto  pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                       <h5 class="text-uppercase font-weight-bold">Monthly Mr Sales Target Products Report <br> {{$month}} {{$year}}</h5>
                    </div>
                </div>


                <div class="py-4 table-responsive">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead style="border: 1px solid #515151;">
                          <tr class="table-header-fixt-top">
                               <th>Product Name</th>
                               <th>Quantity (Kg)</th>
                            	<th>Quantity (Ton)</th>
                          </tr>
                          </thead>
                           @php
                                 $grand_total_kg = 0;
                           @endphp

                          <tbody>
                            <tr class="" style="border: 1px solid black">
                                   <th style="color: rgb(104, 28, 28); font-weight: bold;" colspan="100%">{{$zones->main_zone}} Zone - {{$zones->zone_title}} Area - {{$area}}</th>
                              </tr>
                             @foreach($products as $key=>$val)
                              <tr style="color: #333; font-weight: bold;">
                              
                                @php 
                                	$grand_total_kg += $val->qty_kg;
                                @endphp 
                                    <td><b>{{$val->product_name}}</b></td>
                                    <td><b>{{number_format($val->qty_kg,2)}}</b></td>
                                	<td><b>{{number_format(($val->qty_kg/1000),2)}}</b></td>
                         </tr>
                            @endforeach

                           <tr style="color: black;background-color: #e198509c;font-weight: bold;">
                              <td><b>Grand Total</b></td>
                               <td><b>{{number_format($grand_total_kg,2)}}</b></td>
                              <td><b>{{number_format(($grand_total_kg/1000),2)}}</b></td>       
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
                filename: "MonthlyEmployeeTargetProductsReport.xls"
            });
        });
    });
</script>
@endsection
