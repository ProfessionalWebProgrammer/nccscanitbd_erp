@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
              <div class="col-md-12 pt-3" align="right" id="btndiv">
                <button class="btn btn-outline-warning"  onclick="printDiv('cardbody')"><i class="fa fa-print"
                        aria-hidden="true"> Print </i></button>
             </div>
            <div class="container-fluid" id="cardbody">
                <div class="text-center pt-3">
                   <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  		<p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Invoice View</h5>
                   <hr>
                </div>
                <div class="row pt-4">

                    <div class="col-md-8">
                        <div class="text-left">
                            <h4>Invoice Date : {{ date("d-m-Y", strtotime($data->date))}}</h4>
                            <div class="mt-3">
                                <table style="font-size:22px;">
                                    <tr>
                                        <td>Supplier Name</td>
                                        <td> : </td>
                                        <td>{{ $data->supplier_name }} </td>
                                    </tr>
                                    <tr>
                                        <td>Warehouse Name</td>
                                        <td> : </td>
                                        <td>{{$data->factory_name}} </td>
                                    </tr>
                                  
                                 
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"> </div>
                    <div class="col-md-3">
                        <div class="text-right">
                          	
                            <h4>Invoice : {{ $data->invoice }}</h4>
                            <div class=" ">
                                <img class="img-fluid bg-light" style="height: 75px; width: 268px;" src="{{ asset('public/backend/images/barcode-png.png') }}"
                                    alt="Barcode-Display">
                            </div>

                            <h5 class="mt-2">Current Time:  {{date('g:i a',strtotime(Carbon\Carbon::now()))}} </br> Current Date: {{date('d-m-Y',strtotime(Carbon\Carbon::now()))}}</h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-12 mt-5">
                        <table id="" class="table table-bordered table-striped table-fixed" style="font-size:20px;">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Product Name</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>

                              
                                <tr>
                                    <td>1</td>
                                    <td>{{$data->product_name}}</td>
                                    <td align="right">{{$data->unit}}</td>
                                    <td  align="right">{{$data->qty}}</td>

                                </tr>



                            </tbody>
                            <tfoot class="text-right">
                                <tr class="font-weight-bold">
                                    <td colspan="3">Total Quantity</td>
                                    <td>{{number_format($data->qty,2)}} {{$data->unit}}</td>
                                </tr>
                               
                            </tfoot>
                        </table>
                    </div>
                    {{-- <div class="col-md-1"></div> --}}
                </div>
              <div class="col-md-12 mt-5"></br></br></br></br></div>
                <div class="row mt-5 pb-5" style="margin-top:120px">
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
