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
                      <h5 class="text-uppercase font-weight-bold">Daily Production Summary Report </h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                        <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>


                <div class="py-4 ">
                    <table class="table table-bordered "
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top" style="font-size: 16px;text-align: center;font-weight: bold;color: rgb(0, 0, 0);top: -25px;">
                              <th width="120px">Date</th>
                              <th width="100px">Invoice No</th>
                              <th>Product Name</th>
                              <th>Quantity (Bag) </th>
                            </tr>
                            </thead>
                            <tbody>
                                @php 
                                $total = 0;
                                @endphp 
                                @foreach($allFinishGoods as $data)
                              	@php 
                                $total += $data->quantity;
                                @endphp 
                                <tr>
                                  <td>{{$data->date}}</td>
                              	  <td>PJV-{{$data->sout_number}}</td>
                                  <td>{{$data->product_name}}</td>
                                  <td>{{$data->quantity}}</td>
                              	</tr>
                              @endforeach
                            </tbody>
                      			<tfoot class="bg-info">
                                  <tr>
                                    <td colspan="3">Grand Total: </td>
                                    <td>{{number_format($total)}} (Bag)</td>
                                  </tr>
                                </tfoot>
                            
                    </table>
                </div>
              <h3 class="mt-3">Production Summary Report</h3>
              <div class="py-4   mt-3">
                    <table  class="table table-bordered "
                        style="font-size: 15px;">
                        <thead>
                            <tr class="table-header-fixt-top" style="font-size: 16px;text-align: center;font-weight: bold;color: rgb(0, 0, 0);top: -25px;">
                              <th>Product Name</th>
                              <th>Quantity (Bag) </th>
                            </tr>
                            </thead>
                            <tbody>
                                 @php 
                                $total = 0;
                                @endphp 
                                @foreach($finishGoodsDetails as $data)
                                @php 
                                $total += $data->qty;
                                @endphp 
                                <tr>
                                   <td>{{$data->product_name}}</td>
                                   <td>{{$data->qty}}</td>
                              	</tr>
                              @endforeach
                              	<tfoot class="bg-info">
                                  <tr>
                                    <td>Grand Total: </td>
                                    <td>{{number_format($total)}} (Bag)</td>
                                  </tr>
                                </tfoot>
                            </tbody>
                            
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
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
