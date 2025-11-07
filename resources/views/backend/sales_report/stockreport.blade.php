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
                    <h5 class="text-uppercase font-weight-bold">Stock Report</h5>
                    <hr>
                </div>
                <div class="py-4">
                    <table class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>SI No</th>
                                <th>Product Name</th>
                                <th>Opening Balance</th>
                                <th>Stock In</th>
                                <th>Stock out</th>
                                <th>Return</th>
                                <th>Transfer In</th>
                                <th>Transfer Out</th>
                                <th>Damage</th>
                                <th>Closing Balance</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">
                            <tr>
                                <td colspan="10">Barisal Depo</td>
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
                                    <td>{{ $sl }}</td>
                                    <td>BG</td>
                                    <td>434</td>
                                    <td>0</td>
                                    <td>1226</td>
                                    <td>0</td>
                                    <td>1230</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>438</td>

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
