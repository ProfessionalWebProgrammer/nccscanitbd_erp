@extends('layouts.backendbase')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                    <h5>General Purchase Details View</h5>
                    <h6 style="margin-top:5px; font-size:18px;font-weight: bold;"></h6>
                </div>
                <div class="py-4 table-responsive">
                  
                   <div class="row" style="margin-top:50px;">
                    
                            <div class="col-md-6" style=" height:auto">
                                <h6 style="margin-bottom:10px;"><b>Invoice No : INV-{{$purchasedata->invoice_no}}</b></h6>
                                <h6 style="margin-bottom:10px;"><b>Date : {{date('d M, Y',strtotime($purchasedata->date))}} </b></h6>

                              
                                <h6 style="margin-bottom:15px;"><b>Warehouse : {{DB::table('general_wirehouses')->where('wirehouse_id',$purchasedata->warehouse_id)->value('wirehouse_name')}}</b></h6>
                              </div>
                            <div class="col-md-6">
                                <!--<h6 style="margin-bottom:10px;"><b>Truck No : 11.4910</b></h6>-->
                                <!--<h6 style="margin-bottom:10px;"><b>Product Type : House Hold</b></h6>-->
                            </div>
                        </div>
                  
                    <table id="" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $purchaseitems = DB::table('general_purchases')
                          		->select('general_purchases.*','general_products.gproduct_name')
                          		->leftJoin('general_products','general_products.id','general_purchases.product_id')
                          		->where('invoice_no',$purchasedata->invoice_no)
                          		->get();
                          		$totalqntty = 0;
                          		$totalvalue = 0;
                            @endphp
                            @foreach ($purchaseitems as $data)
                          	@php
                          		$totalqntty += $data->quantity;
                          		$totalvalue += $data->total_value;
                            @endphp
                                <tr>
                                    <td>{{	$loop->iteration }} </td>
                                    <td>{{ $data->gproduct_name }} </td>
                                    <td class="text-right">{{ number_format($data->quantity) }} </td>
                                    <td class="text-right">{{ number_format($data->rate) }} </td>
                                    <td class="text-right">{{ number_format($data->total_value) }} </td>


                                </tr>

                            @endforeach 

                            </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Total</th>
                                <th class="text-right">{{number_format($totalqntty)}}</th>
                                <th class="text-center">-</th>
                                <th class="text-right">{{number_format($totalvalue)}}</th>
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
