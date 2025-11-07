@extends('layouts.purchase_deshboard')

@section('content')
<style media="screen">
        .form-check-input {
          position: absolute;
          margin-top: 0rem;
          margin-left: -2rem;
          width: 28px;
          height: 28px;}
  label{
    font-size:20px!important;
  }
        </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent" id="contentbody">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid bg-white p-5">
              <div class="row">

                <div class="col-md-12 mt-2">
                  <div class="text-center">
                    <h1>Naba Crop Care</h1>
                    <p>Head office, Rajshahi, Bangladesh</p>

                </div>
                  </div>
						<div class="col-md-12 text-center">
							<h3>Requisition Approved Form</h3>
						</div>
                        @php
                        //$user = DB::table('employees')->where('user_id',$data->to_user_id)->first();
                	//	$users = \App\Models\RequisitionUser::select('employees.emp_name')->leftJoin('employees', 'employees.user_id', '=', 'requisition_users.to_user_id')->where('requisition_id',$data->id)->get();
                  if($data->status == 4){
                    $users = \App\Models\RequisitionUser::where('requisition_id',$data->id)->where('requisition_users.status',0)->get();
                  } else {
                    $users = \App\Models\RequisitionUser::where('requisition_id',$data->id)->where('requisition_users.status',500)->get();

                  }

								$contact_user = \App\Models\Employee::where('user_id',$data->from_user)->first();
								@endphp

                			<div class="col-md-12 mt-4 mb-3" style="font-size:16px">
									<div class="row">
										<div class="col-md-6">
											<div class="text-left">
												<h4>Request to:</h4>
												<span>Name: @foreach($users as $user)
                                                {{--  @php
                                                  	if(!empty($user->emp_designation_id)){
                                                        $designation = \App\Models\Designation::where('id',$user->emp_designation_id)->value('designation_title');
                                                    } else {
                                                        $designation = '';
                                                    }
                                                  @endphp --}}
                                                  {{$user->emp->emp_name ?? ' Admin'}}  ,  @endforeach</span></br>
												{{-- <span>Degination: {{$designation}}</span></br> --}}
												<span>Users Name: @if(!empty($contact_user)){{ $contact_user->emp_name }} @else  @endif</span></br>
												<span>Contact Number: @if(!empty($contact_user)){{$contact_user->emp_mobile_number }} @else  @endif</span></br>
											</div>
										</div>
										<div class="col-md-6">
											<div class="text-right">
												<span><b>UR No: {{$data->invoice}}</b></span></br>
												<span>Date: {{date("d.m.y")}}</span>
											</div>
										</div>
									</div>
                {{--   <div class="text-left">
                    <span><b>Invoice N0: {{$data->invoice}}</b></span></br>
                    <span>User Name: {{$name}}</span></br>
                    <span>User Name: {{$name}}</span></br>
                  <span>Date Of Requisition: {{ date("d.m.y", strtotime($data->required_date)) }}</span></br>
          		<span>Last Purchase Date: {{ date("d.m.y", strtotime($data->last_purchase_date)) }}</span></br>
							<span>Subject: {{ $data->subject }}</span>
                </div>
								--}}
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
                  <div class="row">
                    <div class="col-md-4">
                      Supplier Name: {{ $data->supplier->supplier_name }}
                    </div>
                    <div class="col-md-4">
                      Amount: {{number_format($data->amount,2)}}
                    </div>
                    <div class="col-md-4">
                      Document:
                      <a href="{{URL::to('/public/uploads/requisition/')}}/{{$data->doc}}" target="_blank" download><i class="fas fa-download"></i>  Document</a>
                    </div>
                    <div class="col-md-12">
                      Description:
                      {{$data->description}}
                    </div>
                  </div>
                  {{--  <table class="table" style="font-size: 16px;">
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
                              	<th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 16px;">
                          @php
                          $all = \App\Models\RequisitionDetail::where('req_id', $data->id)->get();

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
																	<!-- <td>{{ date("d.m.y", strtotime($data->required_date)) }}</td>  -->
																		<td>{{ date("d.m.y", strtotime($data->last_purchase_date)) }}</td>
                                		<td>{{$val->lup}}</td>
                                		<td>{{$data->description}}</td>

                                </tr>
																@endforeach

                           </tbody>
                    </table> --}}
                </div>

	{{--
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
            </div> --}}
			<form class="floating-labels" action="{{route('user.multiFunction.requisition.approved', $data->id)}}" method="POST">
          @csrf
              <input type="hidden" name="user" value="{{$myid}}">
            {{--  <input type="hidden" name="approved_user" value="{{$approvedUserId}}"> --}}
              <div class="col-md-12 mt-3">
              {{--  <div class="row">
                  @foreach($items as $val)
                  @php
                    $item = \App\Models\UserSelectItem::where('user_id',$myid)->where('requisition_id',$data->id)->where('item_id',$val->id)->first();
                  @endphp
                  <div class="col-md-3">
                      <div class="form-check h6">
                        <input class="form-check-input" type="checkbox"  name="item[]" id="s{{$val->id}}" value="{{$val->id}}" @if(!empty($item->item_id)) @if($item->item_id == $val->id) checked @else   @endif @endif  class="form-control present-checkbox" style="width: 20px; height: 20px;">
                        <label class="form-check-label" for="s{{$val->id}}">{{$val->name}}</label>
                      </div>
                  </div>
                  @endforeach

                </div> --}}
                <div class="row">
                  <div class="col-md-3">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label"> Document:</label>
                  <div class="col-sm-9">
                      <input type="file" name="user_doc" value="">
                  </div>
                </div>
              </div>
            </div>
              	<div class="row pt-4">
                    <div class="col-md-3">
                         <div class="form-check h5">
                            <input class="form-check-input" type="radio" @if($data->status == 3)  checked @else  @endif name="status" id="s1" value="3" required>
                            <label class="form-check-label" for="s1">Accept </label>
                          </div>
                     </div>
                    <div class="col-md-3">
                            <div class="form-check h5">
                             <input class="form-check-input" type="radio" @if($data->status == 4)  checked @else  @endif name="status" id="s2" value="4" required>
                               <label class="form-check-label" for="s2">Reject </label>
                             </div>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group row">
                           <label class="col-sm-4 col-form-label"> Note:</label>
                           <div class="col-sm-8">
                               <textarea name="note" class="form-control"   rows="2"></textarea>
                           </div>
                       </div>
                     </div>

                  </div>
              </div>
              <div class="col-md-12 row pb-5">

              <div class="col-md-6 mt-3">
                  <div class="text-right">
                      <button type="submit" class="btn custom-btn-sbms-submit btn-primary"> Submit </button>
                  </div>
              </div>
              <div class="col-md-6 mt-3"></div>
          </div>
			     </form>

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
