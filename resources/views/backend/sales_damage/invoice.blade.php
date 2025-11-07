@extends('layouts.account_dashboard')

 @section('header_menu')
<div class="mt-2">
<a href="#" class="btn btn-xs btn-warning"  onclick="printDiv('cardbody')"><i class="fa fa-print"  aria-hidden="true"> Print </i></a>
</div>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4">

            <div class="container-fluid" id="cardbody">
                <div class="text-center pt-3" style="padding-left:40px;">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3 mb-4" style="padding-left:40px;padding-right:40px;">
                    <h5 class="text-uppercase font-weight-bold">Damage Voucher</h5>
                   <hr>
                </div>
                <div class="row pt-1" style="padding-left:40px;">

                    <div class="col-md-8">
                        <div class="text-left">
                            <h4>Date : {{date('d-m-Y',strtotime($damage->payment_date)) }}</h4>
                          	<h4>Invoice : {{$damage->invoice}}</h4>
                          	<h5 class="mt-1">Current Time: {{date('g:i a',strtotime(Carbon\Carbon::now()))}} </br> Current Date: {{date('d-m-Y',strtotime(Carbon\Carbon::now()))}}</h5>
                      		<h5>Create By: {{Auth::user()->name}}</h5>
                        </div>
                    </div>
                    <div class="col-md-1"> </div>
                    <div class="col-md-3">

                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12 mt-5" style="padding:40px;">
                        <table id="" class="table table-bordered table-striped table-fixed" style="font-size:18px;">
                            <thead>
                              @php


                                @endphp
                                <tr>
                                   <th class="text-center">Sl. </th>
                                   <th class="text-center">Product Name</th>
                                   <th class="text-right">Debit Amount </th>
                                   <th class="text-right">Credit Amount </th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                              <tr>
                                  <td rowspan="2" class="text-center">1</td>
                                  <td>{{$damage->product_name}}</td>
                                  
                                  <td class="text-right">0/-</td>
                                  <td class="text-right">{{ number_format($damage->amount,2) }}/-</td>
                              </tr>
                              <tr>
                                  <td>Retained Earning</td>
                                  <td class="text-right">{{ number_format($damage->amount,2) }}/-</td>
                                  <td class="text-right">0/-</td>
                              </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="col-md-12 mt-5" ></div>
                  <div class="row mt-5 pb-5" >
                    <table style="width:100%">
                      <tr >
                        <th  width="33.33%" style="text-align:center;" ><span style=" margin-top:10px; border-top:1px solid #333;" >Delivered By</span></th>
                        <th  width="33.33%" style="text-align:center;"><span style=" margin-top:10px; border-top:1px solid #333;" >Printed By</span></th>
                        <th  width="33.33%" style="text-align:center;"><span style=" margin-top:10px; border-top:1px solid #333;" >Autorise By</span></th>
                      </tr>
                    </table>
                      <br><br>
                  </div>

              {{-- <div class="col-md-12 mt-5"></br></br></br></br></div>
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
                </div> --}}
            </div><!-- /.container-fluid -->
            
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
