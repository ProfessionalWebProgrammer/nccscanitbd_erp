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
                    <h5>Total Report</h5>
                </div>
                <div class="py-4 table-responsive">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Date</th>
                                <th>IN. NO</th>
                                <th>Warehouse/Bank</th>
                                <th>Vehicle</th>
                                <th>Product</th>
                                <th>Order Qty</th>
                                <th>Receive Qty</th>
                                <th>DED.Qty</th>
                                <th>Bill Qty</th>
                                <th>Rate</th>
                                <th>Purchase Value</th>
                                <th>TP Fare</th>
                                <th>Credit</th>
                                <th>Debit</th>
                                <th>Balance BDT</th>
                                <th>(U-02) Soraikandi Mll [Ton]</th>
                                <th>(U-01) Ishurdi Mill [Ton]</th>
                                <th>Pabna Mill [Ton]</th>
                                <th>Total Ton</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">
                            @php
                                $sl = 0;
                                $invoice = 102030;
                            @endphp
                            @for ($i = 0; $i < 30; $i++)
                                @php
                                    $sl++;
                                    $invoice++;
                                @endphp
                                <tr>
                                    <td>01-06-2021</td>
                                    <td>PURCHASE3465</td>
                                    <td>(U-02) Soraikandi Mll</td>
                                    <td>15-7111-S</td>
                                    <td>Salt</td>
                                    <td> KG</td>
                                    <td>6060 KG</td>
                                    <td>0.00 KG</td>
                                    <td>6,000.00 KG</td>
                                    <td>8</td>
                                    <td>48,000.00</td>
                                    <td>0</td>
                                    <td>48,000.00</td>
                                    <td>0.00</td>
                                    <td>530,961.00 (Cr) </td>
                                    <td>6.00 </td>
                                    <td> 0 </td>
                                    <td> 0 </td>
                                    <td>6.00</td>
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
                filename: "TotalReport.xls"
            });
        });
    });
</script>
@endsection
