@extends('layouts.backendbase')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Total Sales Report</h5>
                    <hr>
                </div>
                <div class="py-4">
                    <table class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Date</th>
                                <th>Inv</th>
                                <th>Item</th>
                                <th>Store</th>
                                <th>Qty(Bag)</th>
                                <th>Qty(KG)</th>
                                <th>Qty(Ton)</th>
                                <th>Rate</th>
                                <th>Dr. Amount</th>
                                <th>Cr. Amount</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">
                            <tr>
                                <th colspan="12" style="font-size: 17px; font-weight: bold;">xxxxxxxxx - Zone - </th>
                            </tr>
                            <tr>
                                <th colspan="10">Opening Balance</th>
                                <th style="text-align:right">-49330134</th>
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
                                    <td>02/08/2021</td>
                                    <td>1063337</td>
                                    <td></td>
                                    <td>IBBL-1376 (RRP ) A/C</td>
                                    <td style="text-align:right"></td>
                                    <td style="text-align:right"></td>
                                    <td style="text-align:right">0</td>
                                    <td style="text-align:right"></td>
                                    <!-- <td style="text-align:right"></td> -->
                                    <td class="highlighted text_green" style="text-align:right"></td>
                                    <td class="highlighted text_green" style="text-align:right">5000.00</td>
                                    <!-- <td style="text-align:right">-74176152.00</td> -->
                                    <td></td>
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
@endsection
