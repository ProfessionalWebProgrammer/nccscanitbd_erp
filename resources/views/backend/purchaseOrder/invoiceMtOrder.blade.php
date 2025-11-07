@extends('layouts.purchase_deshboard')
<style media="screen">
		.form-check-input {
			position: absolute;
			margin-top: 0rem!important;
			margin-left: -1.75rem!important;
			width: 20px;
			height: 20px;}

        table{
        border-collapse: collapse;
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
        table, .table td, .table th{
    border: 1px solid #666!important;
        }


	.h5, h5 {
    font-size: 1.1rem;
        }
      </style>
@section('print_menu')
			<li class="nav-item">
                    <button class="btn btn-xs  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                </li>
			<li class="nav-item ml-1">
                    <button class="btn btn-xs  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
            </li>
@endsection

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent" id="contentbody" style="min-height:700px!important;">


        <!-- Main content -->
        <div class="content px-4 " >
            <div class="container-fluid bg-white p-5">
              <div class="row">

                <div class="col-md-12 mt-5 mb-1">
                  <div class="text-center">
										<h1><b>Naba Crop Care</b></h1>
										<p>Head office, Rajshahi, Bangladesh</p>
                </div>
                  </div>
              	@php


                @endphp

								<div class="col-md-12 mt-5">
                  <div class="row">

										<div class="col-md-7">
                      <div class="text-left">
						 					<span class="h4">Invoice No: {{ $orderViews->invoice}}</span></br>
		                  <span>Company Name: {{$orderViews->comName}}</span></br>
		                  <span>Company Address: {{$orderViews->address}}</span>
                      </div>
                    </div>


                    <div class="col-md-5 text-right">
                      <div class="row">
                        <div class="col-md-12">
													<span>Invoice Date: {{ date("F d, Y", strtotime($orderViews->date)) }}</span></br>
				          		  	<span>Require Date : {{ date("F d, Y", strtotime($orderViews->require_date)) }}</span></br>
                          <!-- <span class=""> Current Date: {{ date("F d, Y") }}</span>  -->
													<span class=""> Approved By: {{$user }}</span>
                        </div>

                      </div>
                    </div>
                  </div>
                  </div>


              </div>

                <div class="py-2 ">
                    <table class="table mt-3 " style="font-size: 14px;">
                        <thead>
                            <tr >
                                <th width="7%">Sl No</th>
                                <th width="20%">Item Name</th>
																<th>Item Code</th>
																<th>Unit</th>
																<th>Category</th>
                                <th>Sub Category</th>

																<th>Image</th>
																<th>Quantity</th>
                               <!-- <th width="25%"> Specifications </th> -->

                            </tr>
                        </thead>

                        <tbody style="font-size: 16px;">


                              <tr>
                                    <td>1</td>
                                    <td>{{$orderViews->name}} </td>
	                                	<td>{{$orderViews->code}}</td>
	                                	<td>{{$orderViews->unit}}</td>
																		<td>{{ $orderViews->category_name }}</td>
                                    <td>{{ $orderViews->subCat }}</td>
	                                  <td><a href="{{URL::to('/public/uploads/marketing/')}}/{{$orderViews->image}}" target="_blank"><img class="gallery" style="height:50px;" src="{{URL::to('/public/uploads/marketing/')}}/{{$orderViews->image}}" alt="Image"></a></td>
	                                	<td>{{$orderViews->qty}}</td>
                                    {{-- <td>{{$orderViews->specification ?? ''}}</td> --}}
                                </tr>
																@php
																	$datas = \App\Models\MarketingOrderSpecification::leftJoin('marketing_order_specification_heads as m','m.id','=','marketing_order_specifications.specification_id')
																						->where('marketing_order_specifications.invoice',$orderViews->invoice)->get();
																@endphp
													<tr>
														<td>Specification:</td>
														<td colspan="100%" align="left">
															@foreach($datas as $val)
																	{{$val->name}} : {{$val->value}} ,
															@endforeach
														</td>
													</tr>

                           </tbody>
                    </table>


								<form class="mt-3" action="{{route('marketingOrder.item.ststus.update',$orderViews->invoice)}}" method="post">
									@csrf
									<div class="col-md-12">
                    <div class="row pt-2">
                    <div class="col-md-3">
                         <div class="form-check h5">
                             <input class="form-check-input" type="radio" @if($orderViews->orderStatus == 1)  checked @else  @endif name="status" id="s1" value="1" >
                               <label class="form-check-label" for="s1">Accept </label>
            		 					</div>
                     </div>
                    <div class="col-md-3">
                         <div class="form-check h5">
                             <input class="form-check-input" type="radio"  name="status" id="s2" value="0" >
                               <label class="form-check-label" for="s2">Reject </label>
            		 	</div>
                     </div>

                      <div class="col-md-6">

                      </div>
                  </div>



	              <div class="col-md-6 mt-3">
	                  <div class="text-right">
	                      <button type="submit" class="btn custom-btn-sbms-submit btn-primary"> Submit </button>
	                  </div>
	              </div>
	              <div class="col-md-6 mt-3"></div>

	          </div>
								</form>
								</div>

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
