@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 pb-5">
              <div class="col-md-12 pt-3" align="right" id="btndiv">
                <button class="btn btn-outline-warning"  onclick="printDiv('cardbody')"><i class="fa fa-print"
                        aria-hidden="true"> Print </i></button>
             </div>
          <dic class="row">
          <dic class="col-md-8 m-auto bg-light">

            <div class="container-fluid  mt-4" id="cardbody">
                <div class="row">
                    {{-- <div class="col-md-1"></div> --}}
                    <div class="col-md-12 mt-2">
                      	@php
                      		$empinfo = DB::table('employees')->where('id',$payinfo->emp_id)->first();
                      		$designation = DB::table('designations')->where('id',$empinfo->emp_designation_id)->value('designation_title');
                      		$department = DB::table('departments')->where('id',$empinfo->emp_department_id)->value('department_title');
                      	@endphp
                        <table id="" class="table table-bordered table-striped table-fixed" style="font-size:16px;">
                                <tr class="text-center">
                                    <th width="25%"></th>
                                    <th colspan ="2" width="50%">
                                      <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                                      <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                                      <h6>01712345678 , 86458415</h6>
                                      <h6 class="text-uppercase font-weight-bold">Employee Salary Paysleep</h6>
                                  	</th>
                                    <th width="25%"></th>
                                </tr>
                              	<tr class="text-center">
                                    <th width="25%"></th>
                                    <th colspan ="2" width="50%">
                                      <h6 class="text-uppercase font-weight-bold">{{date('F, Y',strtotime($payinfo->month))}}</h6>
                                  	</th>
                                    <th width="25%"></th>
                                </tr>
                              	<tr class="text-left">
                                    <th colspan ="2" width="50%">
                                            Employee Name : {{$empinfo->emp_name}} <br>
                                            Employee Id : {{$empinfo->id}}
                                  	</th>
                                    <th colspan ="2" width="50%">
                                      	Title : {{$designation}} <br>
                                        Department : {{$department}}
                                  	</th>
                                </tr>
                              	<tr class="text-center">
                                    <th colspan="2" width="50%">Description</th>
                                    <th>Earnings</th>
                                    <th>Deductions</th>
                                </tr>
                              	<tr >
                                    <th class="text-left" colspan="2"  width="50%">Basic Salary</th>
                                    <th class="text-right">{{number_format($empaccinfo->basic_salary)}}/-</th>
                                  	<th width="25%"></th>
                                </tr>
                              	<tr>
                                    <th class="text-left" colspan="2" width="50%">MA</th>
                                    <th class="text-right">{{number_format($empaccinfo->MA)}}/-</th>
                                  <th width="25%"></th>
                                </tr>
                              	<tr>
                                    <th class="text-left" colspan="2" width="50%">HRA</th>
                                    <th class="text-right">{{number_format($empaccinfo->HRA)}}/-</th>
                                  <th width="25%"></th>
                                </tr>
                              	<tr>
                                    <th class="text-left" colspan="2" width="50%">PB</th>
                                    <th class="text-right">{{number_format($empaccinfo->PB)}}/-</th>
                                  <th width="25%"></th>
                                </tr>
                              	<tr>
                                    <th class="text-left" colspan="2" width="50%">DA</th>
                                    <th class="text-right">{{number_format($empaccinfo->DA)}}/-</th>
                                  <th width="25%"></th>
                                </tr>
                              	<tr>
                                    <th class="text-left" colspan="2" width="50%">TA</th>
                                    <th class="text-right">{{number_format($empaccinfo->TA)}}/-</th>
                                  <th width="25%"></th>
                                </tr>

                              	<tr>
                                    <th class="text-left" colspan="2" width="50%">FB</th>
                                    <th class="text-right">{{number_format($empaccinfo->FB)}}/-</th>
                                  <th width="25%"></th>
                                </tr>

                              	<tr>
                                    <th class="text-left" colspan="2" width="50%">SD</th>
                                    <th class="text-right">{{number_format($empaccinfo->SD)}}/-</th>
                                  	<th width="25%"></th>
                                </tr>

                              	<tr>
                                    <th class="text-left" colspan="2" width="50%">LE</th>
                                    <th class="text-right">{{number_format($empaccinfo->LE)}}/-</th>
                                  <th width="25%"></th>
                                </tr>

                              	<tr>
                                    <th class="text-left" colspan="2" width="50%">Tax</th>
                                  	<th width="25%"></th>
                                    <th class="text-right">{{number_format($tax)}}/-</th>

                                </tr>

                          		<tr>
                                    <th class="text-left" colspan="2" width="50%">Total Fine</th>
                                  	<th width="25%"></th>
                                    <th class="text-right">{{number_format($totalfineamount)}}/-</th>
                                </tr>

                              	<tr>
                                    <th class="text-left" colspan="2" width="50%">Net Salary After EPF</th>
                                    <th class="text-right">{{$netsalary}}/-</th>
                                  <th width="25%"></th>
                                </tr>

                              	<tr>
                                    <th class="text-left" colspan="2" width="50%">F. N. S.</th>
                                    <th class="text-right">{{$finalnetsalary}}/-</th>
                                  	<th width="25%"></th>
                                </tr>

                              	<tr>
                                    <th class="text-left" colspan="2" width="50%">Total Payment</th>
                                    <th class="text-right">{{$payinfo->payment_amount}}/-</th>
                                  <th width="25%"></th>
                                </tr>
                          		<tr>
                                    <th class="text-left" colspan="2" width="50%">
                                      	Payment Date : {{$payinfo->date}} <br>
                                      	Bank/Cash Name : {{$payinfo->bank_warehouse_name}}

                                  	</th>
                                    <th class="text-left" colspan="2" width="50%">
                                      	Payment Status : @if($payinfo->net_salary == $payinfo->payment_amount)
                                      	<span class="text-success"> Paid</span>
                                      @else
                                      	<span class="text-danger"> Not Paid </span>
                                      @endif
                                  	</th>
                                </tr>
                        </table>
                    </div>
                    {{-- <div class="col-md-1"></div> --}}
                </div>
                <div class="row mt-5 pb-5">
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
            </div>
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
