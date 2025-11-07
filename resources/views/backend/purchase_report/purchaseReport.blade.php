@extends('layouts.backendbase')


@section('print_menu')

			<li class="nav-item">
                    <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                </li>
			<li class="nav-item ml-1">
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                </li>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="contentbody">



        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Purchase Report</h5>
                    <hr>
                </div>
                <div class="py-4">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Date</th>
                                <th>N no</th>
                                <th>Warehouse</th>
                                <th>Vehicle</th>
                                <th>Product Name</th>
                                <th>Order Qty</th>
                                <th>Receive Qty</th>
                                <th>Sack</th>
                                <th>Mois</th>
                                <th>DED. Qty</th>
                                <th>Bill Qty</th>
                                <th>Rate</th>
                                <th>Purchase Value</th>
                                <th>TP Fare</th>
                                <th>Total Payable Amount</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">
                            <tr>
                                <td colspan="15">Abdullah Traders</td>
                            </tr>
                            @php
                                $sl = 0;
                                $invoice = 102030;
                            @endphp
                            @for ($i = 0; $i < 20; $i++)
                                @php
                                    $sl++;
                                    $invoice++;
                                @endphp
                                <tr>
                                    <td>29-07-21</td>
                                    <td>INV-8457</td>
                                    <td style="text-align:center">(U-03) Narshingdi Mill</td>
                                    <td style="text-align:center">DMT-145205N</td>
                                    <td style="text-align:center">Maize</td>
                                    <td style="text-align:right">0.00</td>
                                    <td style="text-align:right">14,050.00</td>
                                    <td style="text-align:right">0.00</td>
                                    <td style="text-align:right">0.00</td>
                                    <td style="text-align:right">0.00</td>
                                    <td style="text-align:right">14,025.00</td>
                                    <td style="text-align:right">27.00</td>
                                    <td style="text-align:right">378,675.00 Tk</td>
                                    <td style="text-align:right">20,000.00 Tk (Dr)</td>
                                    <td style="text-align:right">358,675.00 Tk (Cr)</td>
                                </tr>
                            @endfor
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
                filename: "PurchasReport.xls"
            });
        });
    });
</script>
@endsection
