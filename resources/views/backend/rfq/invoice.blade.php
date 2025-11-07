@extends('layouts.purchase_deshboard')
@section('print_menu')
			{{-- <li class="nav-item">
                    <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                </li> --}}
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
                    <div class="col-md-7">
                      <div class="text-left">
                        <h1><b>Naba Crop Care</b></h1>
                        <p>Head office, Rajshahi, Bangladesh</p>
                        <h4 class="mt-2">Request For Quotation </h4>
                      </div>
                    </div>
                    <div class="col-md-5 mt-5 text-right">

                        <div class="h5 ">
                          <span >PR No: {{$data->pr_no}}</span> </br>
                         <span >RFQ No: {{$data->invoice}}</span> </br>
                          <span >Date: {{date("M d, Y", strtotime($data->issue_date))}}</span>

                    	</div>
                        {{-- <div class="col-md-1"></div>
                        <div class="col-md-5 h5">
                          <span class="">PR No: {{$data->pr_no}}</span> </br>
                          <span class="">RFQ No: {{$data->}}</span>
                        </div>
                        <div class="col-md-6 h5">
													<!-- date('F d, Y')  Date: {{ date('d.m.y')}} -->
                          <span> Date:  {{ date("M d, Y", strtotime($data->issue_date)) }}</span>
                        </div> --}}

                    </div>
                  </div>
                  </div>
									@php
									$supplier = \App\Models\Supplier::where('id',$data->supplier_id)->first();
									@endphp
                <div class="col-md-12 mt-4">
                  <div class="row">
                    <div class="col-md-8 ">
                      <span>Ruotation to</span></br>
                      <span>Company name: {{ $supplier->supplier_name?? ''}}</span></br>
                      <span>Contact name: {{$supplier->contact_person ?? ''}}</span></br>
                      <span>Contact No: {{$supplier->phone ?? '' }}</span></br>
                      <span>Date issued: {{ date("F d, Y", strtotime($data->issue_date)) }}</span>
                    </div>
                    <div class="col-md-4 mt-4">
                      <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-11 text-right">
                          <span>Designation: {{$supplier->desination ?? ''}}</span></br>
                          <span>Company address: {{$supplier->address ?? ''}}</span></br>
                          <span>Email address: {{$supplier->email ?? ''}}</span></br>
                          <span>Response deadline: {{ date("F d, Y", strtotime($data->response_date)) }}</span>
                        </div>
                        </div>
                      </div>

                  </div>
                </div>

                <div class="col-md-12 mt-4 mb-3">
                  <h3 style="font-size:24px;">Dear Sir,</h3>
                  <span>We kindly request you to submit your quotation for delivery the items as detailed below:</span>
                </div>
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
                    <table class="table" style="font-size: 15px;">
                        <thead>
                            <tr >
                                <th width="16%">Sl No</th>
                                <th>Item Name</th>
                                <th>Specification</th>
                                <th>UOM (Kg)</th>
                                <th>Quantity</th>
                                {{-- <th>Price</th>
                                <th>Total Value</th> --}}
                            </tr>
                        </thead>
                      @php
                      $Items = DB::table('rfq_details')->where('rfq_id',$data->id)->get();
											$i = 1;
                      @endphp
                        <tbody style="font-size: 16px;">
		                         @foreach($Items as $val)
		                          @php
		                          $product = \App\Models\RowMaterialsProduct::where('id', $val->item)->value('product_name');
		                          @endphp
                              <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{$product}}</td>
                                	<td>{{$val->specification}}</td>
                                    <td>{{$val->unit}}</td>
                                    <td>{{$val->qty}}</td>
                                	{{--  <td>{{$val->rate}}</td>
                                	  <td class="text-right">{{$val->amount}}/-</td> --}}
                                </tr>
																@endforeach
																{{-- <tr>
																	<td>Total Amount:</td>
																	<td colspan="5">{{$data->total_amount}}/-</td>
																</tr>
                          		<tr>
                              <th colspan="6" style=" text-transform: capitalize;">Total Amount in words: {{ convert_number($data->total_amount).convert_paisa((string)$data->total_amount) }}</th>
                             	<tr> --}}
                           </tbody>
                    </table>
                </div>
				            <div class="col-md-12 mt-2">
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
                          <td>Billing Address:</td>
                          <td colspan="3"></td>
                        </tr>
                      </table>
                    </div>
                    <div class="mt-5 py-2" style="height:200px">
                        <h4>Terms & Conditions </h4>
                    </div>
              {{-- <div class="py-2 ">
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
          {{--  <div class="col-md-12 mt-1 mb-5">
                 <div class="row">
                   <div class="col-md-4 ml-2 text-center">
                     <div class="text-left mt-5">
                        <h3>Corporate Office</h3>
                        <span>Silverstone Shoppire, House# 09, Road# 23,</br> Block # B, Banani, Dhaka</span>
                     </div>
                   </div>
                   <div class="col-md-4 ml-2 text-center">
                     <div class="text-left mt-5">
                       <h3>Hade Office</h3>
                       <span>Nabil House, 15/2 Ahmadnagor, Sopura, </br>Boalia, Rajshahi</span>
                     </div>
                   </div>
                   <div class="col-md-3 ml-4 text-center">
                     <div class="text-left mt-5">
                       <h3>Project Office</h3>
                       <span>Nabil Industrial Park , Verapora Bazar, </br> Daokandi, Paba, Rajshahi.</span>
                     </div>
                   </div>

                 </div>
          </div> --}}

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
