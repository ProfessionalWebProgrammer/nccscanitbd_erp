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
                      <h5 class="text-uppercase font-weight-bold">Product Comparison  Report</h5>
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
                                <th>Product Name</th>
                                <th>Sales PCS</th>
                                <th>Sales KG</th>
                                <th>Sales TON</th>
                                <th>This Value</th>

                            </tr>
                        </thead>
                        <tbody>
                         @php
                              $gtotal_pcs= 0;
                            $gtotal_kg = 0;
                            $gtotal_ton = 0;
                            $gtotal_val = 0;
                        @endphp

                                @foreach($products as $all_products)
                                @php
                                   $startdate = '2021-01-01';
                                    $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));


                                    $sales = \App\Models\SalesLedger::where('product_id',$all_products->id)->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_kg');
                                    $salespcs = \App\Models\SalesLedger::where('product_id',$all_products->id)->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_pcs');


                                    $product_name = \App\Models\SalesProduct::where('id',$all_products->id)->value('product_name');

                                    $gtotal_pcs +=$salespcs;
                                    $gtotal_kg += $sales;
                                    $gtotal_ton += $sales/1000;
                                    $gtotal_val += $salespcs*$all_products->product_mrp;


                                @endphp



                                <tr style="font-size: 12x;"><!--  -->

                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$product_name}}</td>
                                    <td>{{$salespcs}}</td>
                                    <td>{{$sales}}</td>


                                    <td>{{$sales/1000}}</td>
                                    <td>{{$salespcs*$all_products->product_mrp}}</td>

                                </tr>

                         @endforeach

                         </tbody>
                           <tfoot>
                            <tr style="background-color: rgba(255, 127, 80, 0.233);">
                                    <th></th>
                                    <th>Total</th>

                                    <td>{{$gtotal_pcs}}</td>
                                    <td>{{$gtotal_kg}}</td>

                                    <td>{{$gtotal_ton}}</td>
                                    <td>{{$gtotal_val}}</td>
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
