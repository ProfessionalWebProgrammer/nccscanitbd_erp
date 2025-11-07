@extends('layouts.purchase_deshboard')
@section('print_menu')
			<li class="nav-item">
                    <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                </li>
			<li class="nav-item ml-1">
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
            </li>
@endsection

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent" id="contentbody">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid bg-white p-5">
              <div class="row">
                {{-- <div class="col-md-3">
                  <div class="imag">
                    <img src="{{ asset('public/uploads/logo.jpg') }}" class="w-60" style="width:80px" alt="User Image">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="row">
                  <div class="col-md-12 mt-3 mb-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  	<p>Head office, Rajshahi, Bangladesh</p>
                    <h3 class="text-center mt-4"><u>Request For Quotation </u></h3>
                  </div>
                    </div>
                </div> --}}
                <div class="col-md-12 mt-5">
                  <div class="row">
                    <div class="col-md-8 m-auto">
                      <div class="text-center">
                        <h1><b>Naba Crop Care</b></h1>
                        <p>Head office, Rajshahi, Bangladesh</p>

                      </div>
                    </div>
                    {{-- <div class="col-md-4 mt-5">
                      <div class="row mt-5">
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                          <h4 class="">RFQ No:</h4> PR No: {{$data->invoice}}
                        </div>
                        <div class="col-md-7">
													<!-- date('F d, Y') -->
                          <h4 class="">Date: </h4>Date: {{ date('d.m.y')}}
                        </div>
                      </div>
                    </div>  --}}
                  </div>
                  </div>
				@php

              $supplier = DB::table('suppliers')->where('id',$data->supplier_id)->first();
              $pName = DB::table('row_materials_products')->where('id',$data->product_id)->value('product_name');
              @endphp
                <div class="col-md-12 mt-4">
                  <div class="row">
                    <div class="col-md-8 h6" style="line-height:24px;">
                      <span>Chalan no: {{$data->chalan_no}}</span></br>
                      <span>Supplier Name: {{$supplier->supplier_name}}</span></br>
                  <span>Address: {{$supplier->address}}</span></br>
                      <span>Contact No: {{$supplier->phone}}</span></br>
                      <span>Date: {{ date("F d, Y") }}</span></br></br>

              			<span class="h4">Product Name: {{$pName}} </br> Quantity: {{$data->qty}} Kg</span></br>
						 <span class="h5">Status: @if($data->status == 1) <span class="badge badge-success p-2 pb-2">Accept</span> @else <span class="badge badge-danger p-2 pb-2">Rejected</span>@endif</span></br>
                    </div>
                    <div class="col-md-4 mt-4">
                     {{-- <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                          <span>Designation: {{$data->designation}}</span></br>
                          <span>Company address: {{$data->address}}</span></br>
                          <span>Email address: {{$data->email}}</span></br>
                          <span>Date: {{ date("F d, Y") }}</span>
                        </div>
                        </div> --}}
                      </div>

                  </div>
                </div>

                {{-- <div class="col-md-12 mt-4 mb-3">
                  <h3 style="font-size:24px;">Dear Sir,</h3>
                  <span>We kindly request you to submit your quotation for delivery the items as detailed below:</span>
                </div> --}}
              </div>
      <style>
        table{
        border-collapse: collapse;
        }
        .table td, .table th{
          border-top:none!important
        }
        table, .table td, .table th{
    border: 1px solid #666!important;
        }
        table.custom{
          border: none!important;
        }
      </style>
                <div class="py-0">
                    <table class="table mt-5 mb-5" style="font-size: 15px;">
                        <thead>
                            <tr >

                                <th width="10%">Sl No</th>
                                <th>Parameter Name</th>
                                <th>Standard Value</th>
                                <th>Parameter Type</th>
                                <th>Parameter Value</th>
                            </tr>
                        </thead>
                      @php
                      $Items = DB::table('qc_details')->where('qc_id',$data->id)->get();
						$c = count($Items);
                      @endphp
                        <tbody style="font-size: 16px;">

		                         @foreach($Items as $key => $val)
		                          @php
		                          $name = DB::table('quality_parameters')->where('id', $val->parameter_id)->value('name');
		                          $type = DB::table('qc_parameter_types')->where('id', $val->parameter_type_id)->value('name');
		                          @endphp
                          		<tr>
                                    <td>{{++$key }}</td>
                                    <td>{{$name}}</td>
                                    <td>{{$val->standard_qty}}</td>
                                    <td>{{$type}}</td>
                                    <td>{{$val->parameter_qty}}</td>
                                </tr>
								@endforeach


                           </tbody>
                    </table>
                </div>
				{{-- <div class="col-md-12 mt-2">
                     Quotation offer should be submitted on or before the deadline indicated.
            	      </div>
                    <div class="col-md-12 mt-5">
                      <table class="custom" style="width:100%">
                        <tr>
                          <td>Supplier Name:</td>
                          <td></td>
                          <td>Fed Tax ID:</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Address:</td>
                          <td colspan="3"></td>
                        </tr>
                        <tr>
                          <td>Contact No:</td>
                          <td></td>
                          <td>Email:</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Billing Address</td>
                          <td colspan="3"></td>
                        </tr>
                      </table>
                    </div>
                    <div class="mt-5 py-2" style="height:200px">
                        <h4>Terms & Conditions </h4>
                    </div>
               <div class="py-2 ">
                  <h4>Terms & Conditions </h4>
                    <table class="table" style="font-size: 15px;">
                        <tbody style="font-size: 16px;">
                              <tr>
                                    <td>{!! $term->term !!}</td>
                                </tr>
                           </tbody>
                    </table>
                </div>  --}}
              <div class="col-md-10 m-auto mt-5 mb-5">
                   <div class="row">
                     <div class="col-md-4">
                       <div class="text-left mt-5">
                          <span>--------------------</br>
                       		Prepared By: </span>
                       </div>
                     </div>
                     <div class="col-md-4">
                       <div class="text-center mt-5">
                         <span>-------------------- </br>
                       		Checked By: </span>
                       </div>
                     </div>
                     <div class="col-md-4">
                       <div class="text-right mt-5">
                         <span>------------------- </br>
                       		Approved By: </span>
                       </div>
                     </div>

                   </div>
            </div>
						<div class="col-md-12 mt-5"></div>

            </div>
        </div>
    </div>

@endsection


@push('end_js')

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })


        $('#delete').on('show.bs.modal', function(event) {
            console.log('hello test');
            var button = $(event.relatedTarget)
            var title = button.data('mytitle')
            var id = button.data('myid')

            var modal = $(this)

            modal.find('.modal-body #mid').val(id);
        })
    </script>
<script type="text/javascript">
    function printDiv(divName) {
             var printContents = document.getElementById(divName).innerHTML;
             var originalContents = document.body.innerHTML;

             document.body.innerHTML = printContents;

             window.print();

             document.body.innerHTML = originalContents;
        }
</script>

<script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#datatablecustom").table2excel({
                filename: "Invoice-purchase-order.xls"
            });
        });
    });

</script>

@endpush
