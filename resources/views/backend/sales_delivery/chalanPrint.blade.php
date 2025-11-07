@extends('layouts.sales_dashboard')
@section('header_menu')
<nav class="mt-1">
<li class="nav-item d-none d-sm-inline-block" id="btndiv">
                      <a href="#" class=" btn btn-success btn-sm mr-2" onclick="printDiv('cardbody')"><i class="fa fa-print"
                        aria-hidden="true"> Print </i></a>
                  </li>
               
</nav>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" id="cardbody">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Invoice Chalan View</h5>
                   <hr>
                </div>
                <div class="row pt-4">

                    <div class="col-md-8">
                        <div class="text-left">
                            <h4>Invoice Date : {{date("d-m-Y", strtotime($salesdetails->date))  }}</h4>
                          <h5>Chalan Date : {{date("d-m-Y", strtotime($chalanDate))  }}</h5>
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
                                   <form action="{{route('sales.on.invoice.update')}}" method="POST">

        							@csrf
                                     <input type="hidden" name="invoice" value="{{$salesdetails->invoice_no}}">
                                    <tr>
                                        <td>Vehicle</td>
                                        <td>: </td>
                                        <td> <input type="text" style="border: none;" name="vehicle" value="{{$salesdetails->vehicle}}" oninput="showButton()"  class="form-comtrol"> </td>
                                    </tr>
                                    <tr>
                                        <td>Transport Cost</td>
                                        <td>: </td>
                                        <td> <input type="text" style="border: none;" oninput="showButton()" name="tcost" value="{{$salesdetails->transport_cost}}"  class="form-comtrol">  </td> <td><button class="btn btn-sm btn-outline-info m-2" type="submit" style="display:none" id="button">Save</button></td>
                                    </tr>
                                   </form>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"> </div>
                    <div class="col-md-3">
                        <div class="text-right">
                            <h4>Invoice : {{$invoice}}</h4>
                            <div class=" ">
                                <img class="img-fluid bg-light" style="height: 75px; width: 268px;" src="{{ asset('public/backend/images/barcode-png.png') }}"
                                    alt="Barcode-Display">
                            </div>
							@php 
                          		$mytime = Carbon\Carbon::now();
        						$time = date('g:i a',strtotime($mytime));
                            @endphp 
                            <h5 class="mt-2">Current Time:  {{$time}} </br> Current Date: {{date('d-m-Y',strtotime($mytime))}} </h5>
                        <h5 class="mt-2">Create By:  {{$user}} </h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col-md-1"></div> --}}
                    <div class="col-md-12 mt-5">
                        <table id="" class="table table-bordered table-striped table-fixed" style="font-size:20px;">
                            <thead>
                                <tr>
                                    <th style="width: 10%">Sl No</th>
                                    <th>Product Name</th>
                                    <th style="width: 20%; text-align:center;">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>

                               
								@php $total = 0; @endphp 
                                @foreach ($salesitems as $item)
								@php 
                              		$total += $item->delivery_qty;
                                @endphp 
                               @if($item->delivery_qty > 0)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->product_name}}</td>
                                    <td  align="center">{{number_format($item->delivery_qty,0)}}</td>
                                </tr>
								@else 
                              
                               @endif
                                @endforeach
								<tr>
                              	<td colspan="2" align="right">Total Quantity:</td>
                                 <td align="center">{{ $total }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-5 pb-5">
                    <div class="col-md-3 mt-5">
                        <div class="text-center " style="font-size:22px;">
                            <p></p>
                            <hr class="bg-light my-0" width="60%">
                            <p>Delivered By</p>
                        </div>
                    </div>
                    <div class="col-md-6 mt-5">
                        <div class="text-center" style="font-size:22px;">
                            <p></p>
                            <hr class="bg-light my-0" width="30%">
                            <p>Printed By</p>
                        </div>
                    </div>
                    <div class="col-md-3 mt-5 text-center" style="font-size:22px;">
                        <p></p>
                        <hr class="bg-light my-0" width="60%">
                        <p>Autorise Signature</p>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
		<script>
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
			 function showButton() {
                var a = document.getElementById("button");
                   a.style.display = "block";
                }
        </script>
@endsection
