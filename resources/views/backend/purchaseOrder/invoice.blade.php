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
                    <h3 class="text-center mt-4"><u>Purchase Order Invoice </u></h3>
                  </div>
                    </div>
                </div> --}}
                <div class="col-md-12 mt-5 mb-1">
                  <div class="text-center">
										<h1><b>Naba Crop Care</b></h1>
										<p>Head office, Rajshahi, Bangladesh</p>
                </div>
                  </div>
              	@php
                $id = $order->supplier_id;
                $supplier = DB::table('suppliers as s')
                ->select('s.supplier_name','s.phone','s.address')
                ->where('s.id',$id)->first();

                @endphp

								<div class="col-md-12 mt-5">
                  <div class="row">
                    @if(!empty($supplier))
                    <div class="col-md-6" style="width:50%; display:block;">
                      <div class="text-left">
							<span class="h4">Purchase Order No: {{ substr($order->order_no, -5)}}</span></br>
		                  <span>Supplier Name: {{$supplier->supplier_name ?? ' '}}</span></br>
		                	<span>Supplier Phone: {{$supplier->phone ?? ' '}}</span></br>
		                  <span>Supplier Address: {{$supplier->address ?? ' '}}</span></br>
		                  <span>Date Of Purchase: {{ date("F d, Y", strtotime($order->date)) }}</span></br>
		          				<span>Date Of Delivery: {{ date("F d, Y", strtotime($order->deliveryDate)) }}</span></br>
											<span>Referance No: {{ $order->reference_no }}</span>
                      </div>
                    </div>
					@else
								<div class="col-md-6" style="width:50%; display:block;">
                      <div class="text-left">
						 <span class="h4">Purchase Order No: {{ substr($order->order_no, -5)}}</span></br>
		                  <span>Supplier Name: </span></br>
		                	<span>Supplier Phone:</span></br>
		                  <span>Supplier Address: </span></br>
		                  <span>Date Of Purchase: {{ date("F d, Y", strtotime($order->date)) }}</span></br>
		          		  <span>Date Of Delivery: {{ date("F d, Y", strtotime($order->deliveryDate)) }}</span></br>
						 <span>Referance No: {{ $order->reference_no }}</span>
                      </div>
                    </div>
					@endif

                    <div class="col-md-6 text-right" style="width:50%; display:block;">
                      <div class="row">
                        <div class="col-md-12">
                          <span class="">PR No: {{$order->pr_no}} </span> </br><span class="">RFQ No: {{$order->rfq_no}} </span> </br>  CS No: {{ $order->cs_no}} </br> Date: {{ date("F d, Y") }}
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>

                <div class="col-md-12 mt-4 mb-4">
                   <h3 style="font-size:20px;">Dear Sir/Madam,</h3>
									 {{--
                  <span>Here are your order details. We thank you for your purchase.</span>
									--}}
									<p class="h5">with reference to your Email, we are pleased to issue this Purchase Order to you as per the terms and conditions
appended below:</p>
                </div>
              </div>
      <style>
        table{
        border-collapse: collapse;
				border-style: none;
        }
        .table thead tr{
        text-align:center;
        }
        .table tbody tr{
        text-align:center;
          font-size:14px;
        }
        .table td, .table th{
          border-top:none!important
        }
      .table,  .table td, .table th{
    border: 1px solid #666!important;
        }


	.h5, h5 {
    font-size: 1.1rem;
        }
      </style>
                <div class="py-2 ">
                    <table class="table" style="font-size: 14px;">
                        <thead>
                            <tr >
                                <th width="7%">Sl No</th>
                                <th width="20%">Item Name</th>
                               <th width="18%"> Specifications </th>
                                <th>UOM (Kg)</th>
								<th>Quantity</th>
                                <th>Price</th>
                                <th >Currency</th>

                                <th width="16%">Total Value</th>
                            </tr>
                        </thead>
                      @php
                      $id = $order->id;
                      $Items = DB::table('purchase_order_create_details as pd')
                                ->select( 'pd.product_id','pd.category_id','pd.specification','pd.unit','pd.rate','pd.quantity','pd.amount')
                                ->where('pd.purchase_order_id',$id)->get();
																$total = 0;
                      @endphp
                        <tbody style="font-size: 13px;">
                          @foreach($Items as $val)
                          @php
                          $product = DB::table('row_materials_products')
                                        ->where('id', $val->product_id)
                                        ->value('product_name');

													$total += $val->amount;
                          @endphp
                              <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$product}} </td>

                                	<td>@if ($val->specification == 'null')  @else {{ $val->specification ?? '' }} @endif </td>
                                    <td>{{$val->unit ?? 'kg'}}</td>

                                	<td>{{round($val->quantity)}}</td>
																	<td>{{$val->rate}}/-</td>
																	<td>BDT</td>
                                    <td>{{number_format($val->amount, 2)}}/-</td>
                                </tr>
                          		{{-- <tr>
                                  <td>Item Specification</td>
                                  <td colspan="6">{{$val->specification}}</td>
                          		</tr> --}}
                          @endforeach
                          	<tr>
                              <th  colspan="7" style="text-transform: capitalize; text-align:left;">Total Amount in words: {{convert_number($order->totalAmount).convert_paisa((string)$order->totalAmount)}}</th>
															<td>{{number_format($total, 2)}}/-</td>
                             <tr>
                           </tbody>
                    </table>
                </div>
				<div class="col-md-12 mt-1">
                   <div class="text-justify">
                     Note: {{$order->description != 'null' ? $order->description  : ''}}
                   </div>
            	</div>
        <div class="py-2 ">
                  <h4>Terms & Conditions </h4>
                    <table class="table" style="font-size: 15px;">
                        <tbody style="font-size: 16px;">
                              <tr>
                                    <td class="text-left">{!! $term->term !!}</td>
                                </tr>
                           </tbody>
                    </table>
                </div>
								<div class="col-md-12 mt-5" ><br></div>
								<div class="row mt-5 pb-5" >
									<table style="width:100% ">
										<tr >
											<th  width="33.33%" style="text-align:center;" ><span style=" margin-top:10px; border-top:1px solid #333;" >Prepared By</span></th>
											<th  width="33.33%" style="text-align:center;"><span style=" margin-top:10px; border-top:1px solid #333;" >Checked By</span></th>
											<th  width="33.33%" style="text-align:center;"><span style=" margin-top:10px; border-top:1px solid #333;" >Approved By</span></th>
										</tr>
									</table>
										<br>
								</div>

								{{--<div class="col-md-10 m-auto mt-5 mb-5">
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
	            </div> --}}
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
