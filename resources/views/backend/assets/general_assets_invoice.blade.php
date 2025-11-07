@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
              <div class="col-md-12 pt-3" align="right" id="btndiv">
                <button class="btn btn-outline-warning"  onclick="printDiv('cardbody')"><i class="fa fa-print"
                        aria-hidden="true"> Print </i></button>
             </div>
           <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh"id="cardbody">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Asset Voucher</h5>
                   <hr>
                </div>
                <div class="row pt-4">

                    <div class="col-md-8">
                        <div class="text-left">
                            <h4>Date : {{date('d-m-Y',strtotime($asset->date)) }}</h4>
                          	<h4>Invoice : {{$asset->invoice}}</h4>
                          	<h5 class="mt-1">Current Time: {{date('g:i a',strtotime(Carbon\Carbon::now()))}} </br> Current Date: {{date('d-m-Y',strtotime(Carbon\Carbon::now()))}}</h5>
                      		<h5>Create By: {{Auth::user()->name}}</h5>
                        </div>
                    </div>
                    <div class="col-md-1"> </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-5">
                        <table id="" class="table table-bordered table-striped table-fixed" style="font-size:20px;">
                            <thead>
                                <tr>
                                    <th style="width: 10px">Sl.</th>
                                    <th>Client Name</th>
                                    <th>Payment Mode</th>
                                    <th class="text-center">Asset Type</th>
                                    <th class="text-center">Type</th>
                                    <th>Debit Amount</th>
                                    <th>Credit Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                    <td rowspan="2">1</td>
                                    <td>{{$asset->name}}</td>
                                    <td align="right"></td>
                                    <td class="text-center">{{$asset->asset_type_name}}</td>
                                    <td class="text-center">{{$asset->asset_term}}</td>
                                    
                                    <td class="text-right">0/-</td>
                                    <td  align="right">{{number_format($asset->payment_value,2)}}/-</td>
                                </tr>
                                
                                <tr>
                                    <td></td>
                                    <td align="left">
                                        @if ($asset->payment_mode == 'Bank')
                                            {{ $asset->payment_mode }}
                                            <span
                                                class="text-danger">({{ DB::table('master_banks')->where('bank_id', $asset->bank_id)->value('bank_name') }})</span>
                                        @elseif($asset->payment_mode == "Cash")
                                            {{ $asset->payment_mode }} <span
                                                class="text-danger">({{ DB::table('master_cashes')->where('wirehouse_id', $asset->wirehouse_id)->value('wirehouse_name') }})</span>
                                        @endif
                                    </td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td  align="right">{{number_format($asset->payment_value,2)}}/-</td>
                                    <td  align="right">0/-</td>
                                    
                                </tr>


                            </tbody>
                            <tfoot >
                                <tr class="font-weight-bold">
                                    <td colspan="7">Note: {{$asset->description}}</td>
                                </tr>

                                  <tr class="font-weight-bold">
                                      <td colspan="7" >Total Amount: {{ convert_number($asset->payment_value).convert_paisa((string)$asset->payment_value) }} </td>
                                  </tr>
                              </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 mt-5" ><br> <br><br></div>
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
                {{-- <div class="row mt-5 pb-5">
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
