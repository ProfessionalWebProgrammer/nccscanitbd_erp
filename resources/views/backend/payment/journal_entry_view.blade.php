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
                    <h5 class="text-uppercase font-weight-bold">Journal Entry View</h5>
                   <hr>
                </div>
                <div class="row pt-5">

                    <div class="col-md-8">
                        <div class="text-left">
                            <h4>Journal Date : {{ date('d-m-Y',strtotime($data->date)) }}</h4>
                          	<h4>Invoice : {{$data->invoice}}</h4>
                          	<h5 class="mt-2">Current Time: {{date('g:i a',strtotime(Carbon\Carbon::now()))}} </br> Current Date: {{date('d-m-Y',strtotime(Carbon\Carbon::now()))}}</h5>
                      		<h5>Create By: {{$userName}}</h5>

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
                                    <th >Particular</th>


                                   <th class="text-center">Debit</th>
                                  <th class="text-center">Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php
                              $debit = 0;
                              $credit = 0;
                              $sl = 0;
                              @endphp
                              @foreach($journalDatas as $val)
                              @php
                              $debit += $val->debit;
                              $credit += $val->credit;
                              $sl += 1;
                              @endphp
                                <tr>
                                      <td>{{$sl}}</td>
                                      <td class="align-middle">{{ $val->subject }}</td>

                                  		<td class="text-center align-middle">{{  number_format($val->debit,2) }}/-</td>
                                      <td class="text-center align-middle"> {{ number_format($val->credit,2) }}/-</td>
                                </tr>
                                @endforeach
                                <tr>
                                  <td colspan="100%"> Narration: {{$val->journel_description}}</td>
                                </tr>
                            </tbody>
                        	 <tr>
                            <td colspan="2" align="right" >Total Amount:</td>
                            <td align="center" >{{number_format($debit,2)}}/-</td>
                              <td align="center" >{{number_format($credit,2)}}/-</td>
                          </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 mt-5" ><br> <br><br></div>
                  <div class="row mt-5 pb-5" >
                    <table style="width:100%">
                      <tr >
                        <th  width="33.33%" style="text-align:center;" ><span style=" margin-top:10px; border-top:1px solid #333;" >Delivered By</span></th>
                        <!-- <th  width="25%" style="text-align:center;"><span style=" margin-top:10px; border-top:1px solid #333;" >Checked By</span></th> -->
                        <th  width="33.33%" style="text-align:center;"><span style=" margin-top:10px; border-top:1px solid #333;" >Printed By</span></th>
                        <th  width="33.33%" style="text-align:center;"><span style=" margin-top:10px; border-top:1px solid #333;" >Autorise By</span></th>
                      </tr>
                    </table>
                      <br><br>
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
