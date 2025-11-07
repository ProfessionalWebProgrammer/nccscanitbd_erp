@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Invoice View</h5>
                   <hr>
                </div>
                <div class="row pt-4">

                    <div class="col-md-4">
                        <div class="text-left">
                            <h4>Date : {{ $salesdetails->date }}</h4>
                            <div class="mt-3">
                                <table style="font-size:22px;">
                                    <tr>
                                        <td>Dealer</td>
                                        <td> : </td>
                                        <td>{{$salesdetails->d_s_name}} </td>
                                    </tr>
                                    <tr>
                                        <td>Warehouse</td>
                                        <td> : </td>
                                        <td>{{$salesdetails->factory_name}} </td>
                                    </tr>
                                    <tr>
                                        <td>Vehicle</td>
                                        <td>:</td>
                                        <td>{{$salesdetails->vehicle}} </td>
                                    </tr>
                                    <tr>
                                        <td>Transport Cost</td>
                                        <td>:</td>
                                        <td>{{$salesdetails->transport_cost}} </td>
                                    </tr>
                                    {{-- <tr>
                                        <td>Current Balance</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr> --}}
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5"> </div>
                    <div class="col-md-3">
                        <div class="text-right">
                            <h4>Invoice : {{$invoice}}</h4>
                            <div class=" bg-light">
                                <img class="img-fluid" src="{{ asset('public/backend/images/barcode-png.png') }}"
                                    alt="Barcode-Display">
                            </div>

                            <h5 class="mt-2">Current Time:  {{date('h:m:s a')}} </h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col-md-1"></div> --}}
                    <div class="col-md-12 mt-5">
                        <table id="" class="table table-bordered table-striped table-fixed" style="font-size:20px;">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th colspan="2">Quantity</th>
                                    <th>Discount</th>
                                    <th>Discount Value</th>
                                    <th>Free</th>
                                    <th>Total Value</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $totalvalue = 0;
                                    $totaldes = 0;
                                @endphp

                                @foreach ($salesitems as $item)

                                @php
                                $totalvalue += $item->total_price+$item->discount_amount;
                                $totaldes += $item->discount_amount;
                            @endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->product->product_name}}</td>
                                    <td align="right">{{$item->unit_price}}</td>
                                    <td  align="right">{{$item->qty * $item->product->product_weight }} $item->product->weightUnit->unit_name</td>
                                    <td  align="right">{{$item->qty }} $item->product->unit->unit_name</td>
                                  @if($item->discount_amount > 0 )
                                    <td  align="right">{{$item->discount}}%</td>
                                  <td  align="right">{{$item->discount_amount}} </td>
                                  @else 
                                  	<td  align="right"></td>
                                    <td  align="right"></td>
                                  @endif
                                    <td  align="right">{{$item->bonus}}</td>
                                    <td  align="right">{{$item->total_price+$item->discount_amount}}</td>

                                </tr>

                                @endforeach


                            </tbody>
                            <tfoot class="text-right">
                                <tr class="font-weight-bold">
                                    <td colspan="7">Total Value</td>
                                    <td>{{$totalvalue}}</td>
                                </tr>
                                <tr class="font-weight-bold">
                                    <td colspan="7">Discount</td>
                                    <td>{{$totaldes}}</td>
                                </tr>
                                <tr class="font-weight-bold">
                                    <td colspan="7">Payable</td>
                                    <td>{{$totalvalue-$totaldes}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    {{-- <div class="col-md-1"></div> --}}
                </div>
                <div class="row mt-5 pb-5">
                    <div class="col-md-3">
                        <div class="text-center " style="font-size:22px;">
                            <p></p>
                            <hr class="bg-light my-0" width="70%">
                            <p>Delivered By</p>
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
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
