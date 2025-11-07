@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Finish Goods Purchase Details</h5>
                    <h6 style="margin-top:5px; font-size:18px;font-weight: bold;">{{$fgpurchasedetailes->supplier_name}}</h6>
                </div>
                <div class="py-4 table-responsive">

                   <div class="row" style="margin-top:50px;">

                            <div class="col-md-6" style=" height:auto">
                                <h6 style="margin-bottom:10px;"><b>Invoice No : INV-{{$fgpurchasedetailes->id}}</b></h6>
                                <h6 style="margin-bottom:10px;"><b>Date : {{ \Carbon\Carbon::parse($fgpurchasedetailes->date)->format('d M Y')}}</b></h6>


                                <h6 style="margin-bottom:15px;"><b>Warehouse : {{$fgpurchasedetailes->factory_name}}</b></h6>
                              </div>
                            <div class="col-md-6">
                                <!--<h6 style="margin-bottom:10px;"><b>Truck No : 11.4910</b></h6>-->
                                <!--<h6 style="margin-bottom:10px;"><b>Product Type : House Hold</b></h6>-->
                            </div>
                        </div>

                    <table id="" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top text-center">
                                <th>No</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Rate</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalp = 0;
                                $totala = 0;
                            @endphp
                            @foreach ($fgpurchaseitems as $data)
                                @php
                                    $totalp += $data->quantity;
                                    $totala += $data->total_value;
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }} </td>

                                    <td>{{ $data->product_name }} </td>
                                    <td class="text-right">{{ $data->quantity }}</td>
                                    <td>{{ $data->unit_name }}</td>
                                    <td class="text-right">{{ $data->rate }}</td>
                                    <td class="text-right">{{ number_format($data->total_value, 2) }}</td>


                                </tr>

                            @endforeach

                            </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Total</th>
                                <th class="text-right">{{ $totalp }}</th>
                                <th></th>
                                <th></th>
                                <th class="text-right">{{ number_format($totala, 2) }}</th>
                            </tr>
                          	<tr>
                                <th></th>
                                <th>Transport Fare:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="text-right">{{ number_format($fgpurchasedetailes->transport_fare, 2) }}</th>
                            </tr>
                          	<tr>
                                <th></th>
                                <th>Net Payable Amount:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="text-right">{{ number_format($fgpurchasedetailes->net_payable_amount, 2) }}</th>
                            </tr>


                        </tfoot>

                    </table>

                   <div class="row mt-5 pb-5">
                    <div class="col-md-3">
                        <div class="text-center " style="font-size:22px;">
                            <p></p>
                            <hr class="bg-light my-0" width="70%">
                            <p>Receive By</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center" style="font-size:22px;">
                            <p></p>
                            <hr class="bg-light my-0" width="70%">
                            <p>Printed By</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center" style="font-size:22px;">
                        <p></p>
                        <hr class="bg-light my-0" width="70%">
                        <p>Autorise Signature</p>
                    </div>
                </div>


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
