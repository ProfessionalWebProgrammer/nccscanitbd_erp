@extends('layouts.purchase_deshboard')


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
                    <h5 class="text-uppercase font-weight-bold">Rental Goods Delivery Report</h5>
                    <hr>
                </div>
                <div class="py-4">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Bag Type</th>
                                <th>Quantity</th>
																<th>Rate</th>
																<th>Amount</th>
                              </tr>
                        </thead>
                        <tbody style="font-size: 14px;">
                            <tr>
                                <td colspan="15">Customer Name:  Abdull Karim </td>
                            </tr>
                            @php
                                $sl = 7;
                                $invoice = 159;
                            @endphp
                            @for ($i = 0; $i < 10; $i++)
                                @php
                                    $sl++;
                                    $invoice++;
                                @endphp
                                <tr>
                                    <td>29-09-{{$sl}}</td>
                                    <td>D-{{$invoice}}</td>
                                    <td style="text-align:center">PP Bag</td>
                                    <td style="text-align:center">500</td>
																		<td class="text-center">30</td>
																		<td class="text-center">15,000.00</td>
                                </tr>
                            @endfor
                        </tbody>
                        <tfoot style="font-size: 18px;">
                          <tr>
                            <td colspan="3">Total: </td>
                            <td class="text-center">5,000.00</td>
														<td></td>
														<td class="text-center">150,000.00</td>
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
                filename: "PurchasReport.xls"
            });
        });
    });
</script>
@endsection
