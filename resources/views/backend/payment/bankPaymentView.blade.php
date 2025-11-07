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
                    <h5 class="text-uppercase font-weight-bold">Bank Payment View</h5>
                   <hr>
                </div>
                <div class="row pt-5">
                    
                    @php
                       $username = DB::table('users')
                                ->where('id', $data->created_by)
                                ->value('name');
                      $updatename = DB::table('users')
                                ->where('id', $data->updated_by)
                                ->value('name');
                    @endphp

                    <div class="col-md-8">
                        <div class="text-left">
                            <h4>Paymant Date : {{ date('d-m-Y',strtotime($data->payment_date)) }}</h4>
                          	<h4>Invoice : {{$data->invoice}}</h4>
                          	<h5 class="mt-2">Current Time: {{date('g:i a',strtotime(Carbon\Carbon::now()))}} </br> Current Date: {{date('d-m-Y',strtotime(Carbon\Carbon::now()))}}</h5>
                        </div>
                    </div>
                    <div class="col-md-1"> </div>
                    <div class="col-md-3">
                        <div class="float-right">
                            <h4>Created By : {{ $username }}</h4>
                            <h4>Updated By : {{ $updatename }}</h4>
                            <h4>Printed By: {{$userName}}</h4>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12 mt-5">
                        <table id="" class="table table-bordered table-striped table-fixed" style="font-size:20px;">
                            <thead>
                                <tr>
                                    <th width="10%">Sl No</th>
                                    <th>Account Name</th>
                                    @if($data->company) <th >Sister Concern Name</th> @else <th >Supplier Name</th> @endif
                                    <th class="text-center">Debit Amount</th>
                                    <th class="text-center">Credit Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td rowspan="2">1</td>
                                    <td class="align-middle">{{ $data->bank_name }}</td>
                                    <td class="align-middle"></td>
                                    <td class="text-center align-middle">0/-</td>
                                    <td class="text-center align-middle"> {{ number_format($data->amount,2) }}/-</td>
                                    
                                </tr>
                                
                                <tr>
                                    <td class="align-middle"></td>
                                    <td class="align-middle">@if($data->company) {{$data->company}} @else {{ $data->supplier_name }} @endif</td>
                                    <td class="text-center align-middle"> {{ number_format($data->amount,2) }}/-</td>
                                    <td class="text-center align-middle">0/-</td>
                                </tr>

                            </tbody>
                            <tr>
                                <td colspan="5" align="left" ><strong>Note:</strong> {{ $data->payment_description ?? 'n/a' }}</td>
                            </tr>
                        	<tr>
                                <td colspan="5" align="left" ><strong>Total Amount:</strong> {{ convert_number($data->amount).convert_paisa((string)$data->amount) }}</td>
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
