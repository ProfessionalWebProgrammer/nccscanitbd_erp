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

                <div class="col-md-12 mt-5 mb-3">
                  <div class="text-center">
                    <h1><b>Naba Crop Care</b></h1>
                    <p>Head office, Rajshahi, Bangladesh</p>
                    <h3 class="mt-2">Comparative Statement </h3>
                  </div>
                </div>
                <div class="col-md-12 mt-2 mb-3">
                  <div class="row">
                    <div class="col-md-9">
											<span class="h4">CS No: {{$data->invoice}}</span></br>
											<span class="h5">Date: {{ date("M d, Y", strtotime($data->issue_date)) }}</span>
                    </div>
                    <div class="col-md-3 h5 text-right">
                          <span >PR No: {{$data->pr_no}}</span> </br>
                         <span >RFQ No: {{$data->rfq_no}}</span> </br>
                          <span >Date: {{date("M d, Y")}}</span>

                    </div>
                  </div>
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
                    <table class="table mt-2" style="font-size: 15px;">
                        <thead>
                          @php 
                          $s1 = DB::table('suppliers')->where('id', $data->supplier1)->value('supplier_name');
                          $s2 = DB::table('suppliers')->where('id', $data->supplier2)->value('supplier_name');
                          $s3 = DB::table('suppliers')->where('id', $data->supplier3)->value('supplier_name');
                          $s4 = DB::table('suppliers')->where('id', $data->supplier4)->value('supplier_name');
                          $supplier = DB::table('suppliers')->where('id', $data->selected_supplier)->value('supplier_name');
                          
                          @endphp
                            <tr >
                                <th>Sl No</th>
                                <th>Item Name With Specification</th>
                                <th>UOM (Kg)</th>
                                <th>{{$s1}}</th>
                                <th>{{$s2}}</th>
                                <th>{{$s3}}</th>
                                <th>{{$s4}}</th>
                                <th>LUP</th>
                                <th>Negotiate</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 16px;">
						{{--  $product = DB::table('sales_products')->where('id', $data->item)->value('product_name'); --}}
                          @php
                         
                          $product = DB::table('row_materials_products')->where('id', $data->item)->value('product_name');
                          @endphp
                              <tr>
                                    <td>1</td>
                                    <td>{{$product}} </br> {{$data->specification}}</td>
                                    <td>{{$data->unit}}</td>
                                	  <td>{{$data->rate1}}</td>
                                	  <td>{{$data->rate2}}</td>
                                	  <td>{{$data->rate3}}</td>
                                	  <td>{{$data->rate4}}</td>
                                	  <td></td>
                                	  <td>{{$data->negotiate}}</td>
                                	  <td>{{$data->description}}</td>
                                </tr>
																<tr style="background:#b1d3f1;">
																	<th colspan="2"class="h5 ">Selected Supplier & Rate</th>
																	<th colspan="8"class="h5">{{$supplier}} - {{$data->selected_rate}}</th>
																</tr>
                             <tr>
                           </tbody>
                    </table>
                </div>

                <div class="col-md-12">
                  <h4><u>Negotiate price without VAT & Tax:</u><span class="h5"> (Confirmed by purchase department)</span>  </h4>
                  <h5>Payment: 30 days credit after successful delivery.</h5>
                </div>
                <div class="col-md-12 mt-5"></div>
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
            {{-- <div class="col-md-12 mt-1 mb-5">
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
