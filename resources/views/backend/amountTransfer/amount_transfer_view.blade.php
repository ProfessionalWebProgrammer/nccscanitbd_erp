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
        <div class="content px-4 ">
              
            <div class="container-fluid" id="cardbody">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3 mb-4">
                    <h5 class="text-uppercase font-weight-bold">Amount Transfer View</h5>
                   <hr>
                </div>
                <div class="row pt-5">
					
                    <div class="col-md-8">
                        <div class="text-left">
                            <h4>Transfer Date : {{ date('d-m-Y',strtotime($data->payment_date)) }}</h4>
                          	<h4>Invoice : {{$data->invoice}}</h4>
                          	<h5 class="mt-2">Current Time: {{date('g:i a',strtotime(Carbon\Carbon::now()))}} </br> Current Date: {{date('d-m-Y',strtotime(Carbon\Carbon::now()))}}</h5>
                      		<h5>Create By: {{$userName[0]->name}}</h5>
                            
                        </div>
                    </div>
                    <div class="col-md-1"> </div>
                    <div class="col-md-3">
                        
                    </div>
                </div>
                <div class="row">
                   
                    <div class="col-md-12 mt-5">
                        <table id="" class="table table-bordered table-striped table-fixed" style="font-size:20px;">
                            <thead>
                                <tr>
                                    <th width="10%">Si No</th>
                                    <th>Transfer From</th>
                                    <th >Transfer To</th>
                                   <th class="text-center">Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                                
                                    @php
                                    $from = DB::table('payments')
                                        ->where('transfer_invoice', $data->transfer_invoice)
                                        ->where('transfer_type', 'PAYMENT')
                                        ->first();
                                     //dd($from);
                                    // $fromname = null;
                                    if ($from->bank_name != null) {
                                        $fromname = $from->bank_name;
                                    } elseif ($from->wirehouse_name != null) {
                                        $fromname = $from->wirehouse_name;
                                    }

                                    $to = DB::table('payments')
                                        ->where('transfer_invoice', $data->transfer_invoice)
                                        ->where('transfer_type', 'RECEIVE')->first();
                                     //dd($to->bank_name);

                                    if ($to->bank_name != null) {
                                        $toname = $to->bank_name;
                          				//dd($toname);
                                    } elseif ($to->wirehouse_name != null) {
                                        $toname = $to->wirehouse_name;
                                    }

                                @endphp
                               

                               
                                <tr>
                                    <td>1</td>
                                    <td>{{$fromname}}</td>
                                    <td>{{$toname}}</td>
                                    <td  align="center">{{number_format($to->amount,2)}}</td>                                  
                                </tr>

                            </tbody>
                        	 <tr>
                            <td colspan="3" align="left" >Total Amount:</td>
                            <td align="center" >{{number_format($to->amount,2)}}</td>
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
