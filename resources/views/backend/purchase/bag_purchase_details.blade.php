@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                   <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Purchase Bag Details View</h5>
                    <h6 style="margin-top:5px; font-size:18px;font-weight: bold;">{{$purchases->supplier_name}}</h6>
                </div>
                <div class="py-4 table-responsive">

                   <div class="row" style="margin-top:50px;">

                            <div class="col-md-6" style=" height:auto">
                                <h6 style="margin-bottom:10px;"><b>Invoice No : {{$purchases->invoice}}</b></h6>
                                <h6 style="margin-bottom:10px;"><b>Date : {{ \Carbon\Carbon::parse($purchases->date)->format('d M Y')}}</b></h6>


                                <h6 style="margin-bottom:15px;"><b>Warehouse : {{$purchases->factory_name}}</b></h6>
                              </div>
                            <div class="col-md-6">
                                <!--<h6 style="margin-bottom:10px;"><b>Truck No : 11.4910</b></h6>-->
                                <!--<h6 style="margin-bottom:10px;"><b>Product Type : House Hold</b></h6>-->
                            </div>
                        </div>

                    <table id="" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top">
                                <th>No</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalp = 0;
                                $totala = 0;
                            @endphp
                            @foreach ($purchaseinfo as $key => $data)
                                @php
                                    $totalp += $data->bill_quantity;
                                    $totala += $data->amount;
                                @endphp

                                <tr>
                                    <td>{{ ++$key }} </td>

                                    <td>{{ $data->product_name }} </td>
                                    <td>{{ $data->bill_quantity }}</td>
                                    <td>{{ $data->purchase_rate }}</td>
                                    <td>{{ $data->amount }}</td>


                                </tr>

                            @endforeach

                            </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Total</th>
                                <th>{{ $totalp }}</th>
                                <th></th>
                                <th>{{ $totala }}</th>
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
