@extends('layouts.purchase_deshboard')
@section('print_menu')
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
                        <h4 class="mt-2">Weekly Production Forcasting </h4>
                      </div>
                    </div>
                    <div class="col-md-5 mt-5 text-right">

                        <div class="h5 ">
                          <span >Invoice No: {{$data->invoice}}</span> </br>
                          <span >Delivery Date: {{date("M d, Y", strtotime($data->f_date))}} - {{date("M d, Y", strtotime($data->t_date))}}</span>

                    	</div>

                    </div>
                  </div>
                  </div>
                  @php
                  $supplier = DB::table('suppliers')->where('id',$data->supplier_id)->first();
                  @endphp
                <div class="col-md-12 mt-4">
                  <div class="row">
                    <div class="col-md-8 ">
                      <span>Supplier Information </span></br>
                      <span>Supplier name: {{$supplier->supplier_name}}</span></br>
                      <span>Supplier Address: {{$supplier->address}}</span></br>
                      <span>Contact No: {{$supplier->phone}}</span></br>
                      <span>Date issued: {{ date("F d, Y", strtotime($data->issue_date)) }}</span>
                    </div>

                  </div>
                </div>

                <div class="col-md-12 mt-4 mb-3">
                  <h3 style="font-size:24px;">Dear Sir,</h3>
                  <span>We kindly request you to submit your quotation for Weekly Production Forcasting the items as detailed below:</span>
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
                <div class="py-0 mb-5">
                    <table class="table" style="font-size: 15px;">
                        <thead>
                            <tr >
                                <th width="10%">Sl No</th>
                                <th>Item Name</th>
                                <th>UOM (Kg)</th>
                                <th>Quantity</th>
                                <th>Specification</th>
                            </tr>
                        </thead>
                      @php
                      $Items = DB::table('weekly_production_forcasting_details')->where('wpf_id',$data->id)->get();
											$i = 1;
                      @endphp
                        <tbody style="font-size: 16px;">
		                         @foreach($Items as $val)
		                          @php
		                          $product = DB::table('sales_products')->where('id', $val->product_id)->value('product_name');
		                          @endphp
                              <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{$product}}</td>

                                    <td>Kg</td>
                                    <td>{{$val->qty}}</td>
                                	<td>{{$data->note}}</td>
                                </tr>
																@endforeach

                           </tbody>
                    </table>
                </div>
                {{--
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
                       		Authorized By: </span>
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
