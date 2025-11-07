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
                    <h5 class="text-uppercase font-weight-bold">Expanse Payment View</h5>
                   <hr>
                </div>
                <div class="row pt-5">

                    <div class="col-md-8">
                        <div class="text-left">
                            <h4>Paymant Date : {{ date('d-m-Y',strtotime($data->payment_date)) }}</h4>
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
                              @php
                                  $username = DB::table('users')
                                            ->where('id', $data->created_by)
                                            ->value('name');
                                  $updatename = DB::table('users')
                                            ->where('id', $data->updated_by)
                                            ->value('name');
                                $exLadger = DB::table('expanse_subgroups')->where('id',$data->expanse_subgroup_id)->first();
                                $subSubgroup = DB::table('expanse_sub_subgroups')->where('id',$data->expanse_subSubgroup_id)->value('subSubgroup_name');
                              if($data->supplier_id)
                              {
                                $supplierName = DB::table('suppliers')->where('id',$data->supplier_id)->value('supplier_name');
                              } else {
                                $supplierName = '';
                              }

                                @endphp
                                <tr>
                                    <th width="10%">Si No</th>
                                  <th>User</th>
                                    @if(!empty($data->bank_name) || !empty($data->wirehouse_name))<th>Account Name</th> @else   @endif
                                    @if(!empty($data->supplier_name)) <th >Supplier Name</th> @else   @endif
                                  	@if(!empty($exLadger->group_name))<th>Group</th> @else   @endif
                                	@if(!empty($exLadger->subgroup_name))<th>Ledger</th> @else   @endif
                                	@if(!empty($subSubgroup))<th>Sub Ledger</th> @else   @endif
                                  	@if(!empty($data->payment_description))<th >Note</th> @else   @endif
                                    @if(!empty($updatename))<th >Updated By</th> @else   @endif
                                   <th class="text-center">Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                  $username = DB::table('users')
                                            ->where('id', $data->created_by)
                                            ->value('name');
                                  $updatename = DB::table('users')
                                            ->where('id', $data->updated_by)
                                            ->value('name');
                                $exLadger = DB::table('expanse_subgroups')->where('id',$data->expanse_subgroup_id)->first();
                                $subSubgroup = DB::table('expanse_sub_subgroups')->where('id',$data->expanse_subSubgroup_id)->value('subSubgroup_name');
                              if($data->supplier_id)
                              {
                                $supplierName = DB::table('suppliers')->where('id',$data->supplier_id)->value('supplier_name');
                              } else {
                                $supplierName = '';
                              }

                                @endphp


                                <tr>
                                    <td>1</td>
                                       <td>{{$username}}</td>
                                       @if(!empty($data->bank_name) || !empty($data->wirehouse_name)) <td class="align-middle">{{$data->bank_name}} {{ $data->wirehouse_name }}</td> @else   @endif
                                       @if(!empty($data->supplier_name)) <td class="align-middle">{{ $data->supplier_name }}</td> @else   @endif
                                  		@if(!empty($exLadger->group_name))<td class="align-middle">{{$exLadger->group_name}}</td> @else   @endif
                                        @if(!empty($exLadger->subgroup_name))<td class="align-middle">{{$exLadger->subgroup_name}}</td> @else   @endif
                                        @if(!empty($subSubgroup))<td class="align-middle">{{$subSubgroup}}</td> @else   @endif
                                  		@if(!empty($data->payment_description))<td>{{ $data->payment_description}}</td> @else   @endif
                                  		@if(!empty($updatename))<td>{{ $updatename}}</td> @else   @endif
                                        <td class="text-center align-middle"> {{ number_format($data->amount,2) }}/-</td>
                                </tr>

                            </tbody>
                        	 {{-- <tr>
                            <td colspan="9" align="left" >Total Amount:</td>
                            <td align="center" >{{number_format($data->amount,2)}}/-</td>
                          </tr> --}}
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
