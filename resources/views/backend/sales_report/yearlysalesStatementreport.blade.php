@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Yearly Sales Statement Report</h5>
                    <hr>
                </div>
                <div class="py-4">
                    <table class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Month</th>
                                <th>Ton</th>
                                <th>Sales Amount</th>
                                <th>Debit Dr</th>
                                <th>Credit Cr</th>
                                <th>Balance</th>
                                <th>Transport</th>
                                <th>Incentive</th>
                                <th>p.e.i</th>
                                <th>(%)</th>
                                <th>Dhamrai</th>
                                <th>Total Bags</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">
                            <tr>
                                <td colspan="5">Opening Balance</td>
                                <td class="text-right">71,68,436.00</td>
                                <td class="text-right">0</td>
                                <td class="text-right">0</td>
                                <td class="text-right">0</td>
                                <td class="text-right">0</td>
                                <td class="text-right">0</td>
                                <td class="text-right">0</td>
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
                                    <td>January</td>
                                    <td>33.65</td>
                                    <td>1479060.00</td>
                                    <td>1479060.00</td>
                                    <td>1490270.00</td>
                                    <td>7157226</td>
                                    <td>20190</td>
                                    <td>21883.05</td>
                                    <td>0</td>
                                    <td>1.5</td>
                                    <td>805</td>
                                    <td class="text-right">718</td>
                                </tr>
                            @endfor
                            <tr>
                                <td colspan="6" align="center" style="font-size:20px">Summary</td>
                            </tr>

                            <tr>
                                <td colspan="3">Opening Balance</td>
                                <td colspan="3">7168436.00</td>
                            </tr>
                            <tr>
                                <td colspan="3">Sales Amount</td>
                                <td colspan="3">8577847.5</td>
                            </tr>
                            <tr>
                                <td colspan="3"><label><strong>Total Amount</strong></label></td>
                                <td colspan="3">15746283.5</td>
                            </tr>
                            <tr>
                                <td colspan="3">Transport</td>
                                <td colspan="3">113610</td>
                            </tr>
                            <tr>
                                <td colspan="3">Monthly Incentive</td>
                                <td colspan="3">114576.2055</td>
                            </tr>
                            <tr>
                                <td colspan="3">Yearly Incentive</td>
                                <!--<td>16168</td>-->
                                <td colspan="3">16168</td>

                            </tr>
                            <tr>
                                <td colspan="3">P.E.I.</td>
                                <td colspan="3">0</td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Total Pay of Incentive</strong></td>
                                <td colspan="3">244354.2055</td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Net Payable Amount</strong> </td>
                                <td colspan="3">15501929.2945 (Dr)</td>
                            </tr>
                            <tr>
                                <td colspan="3">Total Payment</td>
                                <td colspan="3">8246365 (Cr)</td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Due Balance</strong></td>
                                <td colspan="3">7255564.2945 (Dr)</td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Closing Balance</strong></td>
                                <td colspan="3">7499918.5 (Dr)</td>
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
@endsection
