@extends('layouts.purchase_deshboard')
@push('addcss')
    <style>
        .text_sale {
            color: #1fb715;
        }
        .text_credit{
            color: #f90b0b;
        }
          .tableFixHead          { overflow: auto; height: 600px; }
    	.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }

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
                     {{-- <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button> --}}
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                    </div>
                </div>
            <div class="container-fluid" id="contentbody">

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Individual Production Stock Out Report</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                        <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>


                <div class="py-4 table-responsive tableFixHead">
                    <table id="example3" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top" style="font-size: 16px;font-weight: bold;color: rgb(0, 0, 0);top: -25px;">
                              <th>SL</th>
                              <th>Date</th>
                              <th>Invoice</th>
                              <th>Product Name</th>
                              <th>Stock Out Qty</th>
                            </tr>
                            </thead>
                            <tbody>
                               
                              @php 
                              $total = 0; 
                              @endphp 
                                @foreach($rawProducts as $key => $data)

                                @php
								$name = \App\Models\RowMaterialsProduct::where('id',$data->product_id)->value('product_name');
                              	$total += $data->stock_out_quantity;
                                @endphp
                                  @if($data->stock_out_quantity > 0)
                                  <tr>
                                    <td>{{++$key}}</td>
                                      <td>{{date('d M, Y',strtotime($data->date))}}</td>
                                      <td>{{$data->sout_number}} </td>
                                      <td>{{$name}}</td>
                                      <td>{{number_format($data->stock_out_quantity,2)}} Kg</td>
                                  </tr>
                                  @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                            	<tr>
                                    <td>Total</td>
                                      <td colspan="4">{{number_format($total,2)}} Kg</td>
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
                filename: "StockReportPurchase.xls"
            });
        });
    });
</script>
@endsection
