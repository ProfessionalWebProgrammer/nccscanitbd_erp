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
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                    </div>
                </div>
            <div class="container-fluid" id="contentbody">

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Purchase Inventory Report</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>




                <div class="py-4 table-responsive tableFixHead">
                    <table id="datatablecustom" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top" style="font-size: 16px;font-weight: bold;color: rgb(0, 0, 0);top: -25px;">
                                <th >No</th>
                                <th >Date</th>
                                <th >Inv No</th>
                                <th >Item</th>
                                <th >Warehouse</th>
                                <th >Transport Vehicle</th>
                                <th >Inventory Receive</th>

                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($purchases as $key => $purchase)

                                @php
                                    $total += $purchase->inventory_receive;
                                @endphp

                                <tr @if (!$purchase->product_name) class="color: red" @endif>
                                    <td class="tdNo">{{ ++$key }} </td>
                                    <td class="tdDate">{{ date('d-m-y', strtotime($purchase->date)) }}</td>
                                    <td>INV-{{ $purchase->purchase_id }}</td>

                                    <td class="tdProductName">{{ $purchase->product_name }}</td>
                                    <td>{{ $purchase->factory_name }}</td>
                                    <td>{{ $purchase->transport_vehicle }}</td>
                                    <td align="right">{{ $purchase->inventory_receive }} KG</td>

                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr style="background-color:rgba(238, 107, 107, 0.473); font-weight: bold;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td align="right">{{$total}} KG</td>
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
                filename: "InventoryReport.xls"
            });
        });
    });
</script>
@endsection
