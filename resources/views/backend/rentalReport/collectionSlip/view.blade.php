@extends('layouts.purchase_deshboard')
@section('header_menu')
<div class="mt-2">
<a href="#" class="btn btn-xs btn-warning"  onclick="printDiv('cardbody')"><i class="fa fa-print"  aria-hidden="true"> Print </i></a>
</div>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">

            <div class="container" id="cardbody">
                <div class="text-center pt-3">
                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3 mb-4">
                    <h5 class="text-uppercase font-weight-bold">Collection Slip View</h5>
                   <hr>
                </div>
                <div class="row pt-5">

                    <div class="col-md-8">
                        <div class="text-left">
                            <h4>Invoice Date : {{ date('d-m-Y') }}</h4>

                            <div class="mt-3">
                                <table style="font-size:15px;">
                                    <tr>
                                        <td>Customer</td>
                                        <td> : </td>
                                        <td>Abdul Karim </td>
                                    </tr>
                                  <tr>
                                        <td>Address</td>
                                        <td> : </td>
                                        <td>Dhaka </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"> </div>
                    <div class="col-md-3">
                        <div class="text-right">
                            <h4>Invoice :c-1001</h4>
                            <div class=" ">
                                <img class="img-fluid bg-light" style="height: 45px; width: 200px;" src="{{ asset('public/backend/images/barcode-png.png') }}"
                                    alt="Barcode-Display">
                            </div>

                            <h5 class="mt-2">Current Time: {{date('g:i a',strtotime(Carbon\Carbon::now()))}} </br> Current Date: {{date('d-m-Y',strtotime(Carbon\Carbon::now()))}}</h5>
                      		<h5>Create By: Super Admin</h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col-md-1"></div> --}}
                    <div class="col-md-12 mt-5">
                        <table id="" class="table table-bordered table-striped table-fixed" style="font-size:14px;">
                            <thead>
                                <tr>
                                    <th width="10%">Si No</th>
                                    <th>Date</th>
                                    <th>Bank/Cash</th>
                                    <th class="text-center">Amount</th>
                                </tr>
                            </thead>
                            <tbody>


                                <tr>
                                    <td>1</td>
                                    <td>25-09-2023</td>
                                    <td>Cash</td>
                                    <td  align="center">50,000.00</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>28-09-2023</td>
                                    <td>Bank</td>
                                    <td  align="center">70,000.00</td>
                                </tr>

                            </tbody>
                          <tr>
                            <td colspan="3" align="right" >Total Amount:</td>
                            <td align="center" >120,000.00</td>
                          </tr>
                        </table>
                    </div>
                </div>
              <div class="col-md-12 mt-5"></br></br></br></br></div>
                <div class="row mt-5 pb-5" style="margin-top:120px">
                    <div class="col-md-3">
                        <div class="text-center " style="font-size:22px;">
                            <p></p>
                            <hr class="bg-light my-0" width="70%">
                            <p>Collected By</p>
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
