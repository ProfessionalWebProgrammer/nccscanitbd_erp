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

                <div class="col-md-12 mt-5">
                  <div class="text-center">
                    <h1>Naba Crop Care</h1>
                    <p>Head office, Rajshahi, Bangladesh</p>

                </div>
                  </div>
									<div class="col-md-12 text-center">
										<h3>Materials Requisition Form</h3>
									</div>
              	@php
                //$user = DB::table('employees')->where('user_id',$data->to_user_id)->first();
                //$users = DB::table('requisition_users')->select('employees.emp_name','employees.emp_designation_id')->leftJoin('employees', 'employees.user_id', '=', 'requisition_users.to_user_id')->where('requisition_id',$data->id)->where('requisition_users.status',0)->groupBy('requisition_users.to_user_id')->get();

								if($data->status == 4){
									$users = \App\Models\RequisitionUser::where('requisition_id',$data->id)->where('requisition_users.status',0)->get();
								} else {
									$users = \App\Models\RequisitionUser::where('requisition_id',$data->id)->where('requisition_users.status',500)->get();

								}

                	//	dd($users);
              //  $approved = DB::table('employees')->where('user_id',$data->approved_user)->first();
								$approved_users = \App\Models\ApprovedUser::leftJoin('employees', 'employees.user_id', '=', 'approved_users.user_id')
																	->where('requisition_id',$reqId)->where('approved_users.status',3)->get();

								$contact_user = DB::table('employees')->where('user_id',$data->from_user)->first();
								@endphp

                <div class="col-md-12 mt-4 mb-3" style="font-size:16px">
									<div class="row">
										<div class="col-md-6">
											<div class="text-left">
												<h4>Request to:</h4>
												@if($users)
												<span>Name: @foreach($users as $user)
                                                {{--  @php
                                                  	if(!empty($user->emp_designation_id)){
                                                        $designation = DB::table('designations')->where('id',$user->emp_designation_id)->value('designation_title');
                                                    } else {
                                                        $designation = '';
                                                    }
                                                  @endphp --}}
                                                  {{$user->emp->emp_name ?? 'Admin'}} ,  
																									@endforeach</span></br>
																									@else
																										@foreach($approved_users as $user)
																											{{$user->emp_name ?? ' Admin'}}  ,
																										@endforeach
																									@endif
											{{--	<span>Degination: {{$designation}}</span></br> --}}
												<span>Users Name: @if(!empty($contact_user)){{ $contact_user->emp_name }} @else  @endif</span></br>
												<span>Contact Number: @if(!empty($contact_user)){{$contact_user->emp_mobile_number }} @else  @endif</span></br>
											</div>
										</div>
										<div class="col-md-6">
											<div class="text-right">
												<span><b>PR No: {{$data->invoice}}</b></span></br>
												<span>Date: {{date("d.m.y")}}</span> </br>
          									{{-- <span>Approved By: @if(!empty($approved)) {{$approved->emp_name}} @else Admin @endif</span> --}}
          										<span>Approved By:
															{{--	@if($approved_users)
																@foreach($approved_users as $user)
																	{{$user->emp_name ?? ' Admin'}}  ,
																@endforeach
																@else
																	Admin
																@endif --}}
																@foreach($users as $user)
				                            {{$user->emp->emp_name ?? ' Admin'}}
																@endforeach
															</span>
											</div>
										</div>
									</div>
                 {{-- <div class="text-right">
                    <span><b>Invoice N0: </b></span></br>

                    <span>User Name: </span></br>

                </div> --}}

                </div>
                {{-- <div class="col-md-12 mt-4 mb-4">
                  <h3 style="font-size:24px;">Dear Sir/Madam,</h3>
                  <span>Here are your requisition details. We thank you for your requisition.</span>
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

      </style>
                <div class="py-2 ">
                    <table class="table" style="font-size: 16px;">
                        <thead>
                            <tr >
                              <th width="6%">Sl NO</th>
                               <th width="6%">Product Code</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>UOM</th>
                                <th>Required Qtty</th>
                              	<th>Stock in Store</th>
                              	<th>Actual Requirement</th>
                              	<!--<th>Required Date</th>-->
                              	<th>Last Purchase Date</th>
                              	<th>Last Unit Price</th>
                              	<th>Status</th>
                              	<th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 16px;">
                          @php
                          $all = \App\Models\RequisitionDetail::where('req_id', $data->id)->get();
													$checkBoxItems = \App\Models\UserSelectItem::where('requisition_id',$data->id)->get();
                          @endphp
													@foreach($all as $key => $val)
													@php
													$item = \App\Models\RowMaterialsProduct::where('id',$val->item)->first();

													@endphp
                              <tr>
                                    <td>{{ ++$key}} </td>
                                    <td>@if(!empty($item)){{$item->code }} @else  @endif </td>
                                    <td>@if(!empty($item)) {{$item->product_name}} @else  @endif</td>
                                    <td>{{$val->specification}} </td>
                                    <td>{{$val->unit}}</td>
                                		<td>{{$val->qty}}</td>
                                		<td>{{$val->stock}}</td>
                                		<td>{{$val->qty - $val->stock}}</td>
																	{{--	<td>{{ date("d.m.y", strtotime($data->required_date)) }}</td> --}}
																		<td>{{ date("d.m.y", strtotime($data->last_purchase_date)) }}</td>
                                		<td>{{$val->lup}}</td>
																		<td>@if($data->status == 3 ) Accept @elseif($data->status == 4) Rejected  @else  @endif </td>
                                		<td>{{$data->description}}</td>

                                </tr>
																@endforeach

																@if(!empty($checkBoxItems))
																@foreach($checkBoxItems as $val)
																<tr>
																	<td colspan="2">Note: </td>
																	<td colspan="100%"> {{$val->selectItem->name ?? ''}}</td>
																</tr>
																@endforeach
																@endif

																@if($approved_users)
																@foreach($approved_users as $user)
																@if(!empty($user->note))
																<tr>
																	<td colspan="2">Note By: {{$user->emp_name}}</td>
																	<td colspan="100%">{{$user->note}}</td>
																</tr>
																@endif
																@endforeach
																@endif



                           </tbody>
                    </table>
                </div>

{{--
<div class="py-2 ">
                  <h4>Terms & Conditions </h4>
                    <table class="table" style="font-size: 15px;">
                        <tbody style="font-size: 16px;">
                              <tr>
                                    <td>{!! $term->term !!}</td>
                                </tr>
                           </tbody>
                    </table>
                </div> --}}

              <div class="col-md-12 mt-5 mb-5">
                   <div class="row mt-5 mb-5">
                     <div class="col-md-3">
                       <div class="text-left mt-5">
												 <span>---------------</span> </br>
                       		Proposed By:
                       </div>
                     </div>
                     <div class="col-md-3">
                       <div class="text-left mt-5">
												 <span>---------------</span> </br>
                       		Checked By:
                       </div>
                     </div>
                     <div class="col-md-3">
                       <div class="text-center mt-5">
												 <span>---------------</span> </br>
                       		Recommended By:
                       </div>
                     </div>
                     <div class="col-md-3">
                       <div class="text-right mt-5">
												 <span>---------------</span> </br>
                       		Approved By:
                       </div>
                     </div>

                   </div>
            </div>

            </div>
						<div class="col-md-12 mt-5"></div>
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
