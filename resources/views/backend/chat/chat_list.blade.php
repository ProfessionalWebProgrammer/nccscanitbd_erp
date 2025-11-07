@extends('layouts.backendbase')




@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Chat List</h5>
                </div>


              <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active text-white bg-danger" id="receive-tab" data-toggle="tab" href="#receive" role="tab" aria-controls="receive" aria-selected="true">Receive Message</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white  bg-danger" id="sentm-tab" data-toggle="tab" href="#sentm" role="tab" aria-controls="sentm" aria-selected="false">Sent Message</a>
                  </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="receive" role="tabpanel" aria-labelledby="profile-tab">
                   <div class="py-4 table-responsive">

                        <table id="example3" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                            <thead>
                                <tr class="text-center table-header-fixt-top">
                                    <th>Sl</th>
                                    <th>From User</th>
                                    <th>Reference</th>
                                  	<th>Invoice</th>
                                    <!--<th>Required Date</th>-->
                                    <th>Last Purchase Date</th>
                                    <th>Remarks</th>
                                    <th>Status</th>
                                   <th>Action</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 18px;">


                              @foreach($tomassage as $item)

                               @php
                              $tuser = \App\Models\User::where('id',$item->from_user)->value('name');
                              /* $p = DB::table('row_materials_products')->where('id',$item->item)->value('product_name'); */
                              $approvedUserId = \App\Models\ApprovedUser::where('requisition_id',$item->id)
                                                ->where('user_id',$myid)->first();
                              if(!empty($approvedUserId->user_id)){
                                $userId = $approvedUserId->user_id;
                              }  else {
                                $userId = 101;
                              }
                              if(!empty($approvedUserId->status)){
                                $status = $approvedUserId->status;
                              }   else {
                                $status = 99;
                              }

                              @endphp
                              <!-- date('d F Y, H:m: A', strtotime() -->
                              <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$tuser}} <br>{{date('d M y, g:i a', strtotime($item->created_at));}}</td>
                                <td>{{$item->reference}} </td>
                                <td>{{$item->invoice}}</td>
                                {{-- <td>{{date("d M y", strtotime($item->required_date))}}</td> --}}
                                <td>{{date("d M y", strtotime($item->last_purchase_date))}}</td>
                                <td>{{$item->description}}</td>
                                <td>@if($item->status == 3  && $userId == $myid) <span class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="PR Approved Accept"><i class="fa fa-check-circle" aria-hidden="true"></i></span> @elseif($item->status == 4) <span class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="PR Approved Reject"> <i class="fa fa-times" aria-hidden="true"></i> </span> @else {{$item->status == 0 ? "UnRead" : "Seen"}}
                                  @endif</td>
                                <td>@if($item->status == 3 || $status == 3 && $userId == $myid)<a href="{{route('user.chat.view',$item->id)}}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Requisition View"><span
                                                class="fa fa-eye"></span></a>  @elseif(!empty($userId)) <a href="{{route('user.chat.edit',[$item->id,$userId])}}" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Requisition Approved Pending"><span
                                                class="fa fa-spinner"></span></a>  @elseif($myid == 101)  <a href="{{route('user.chat.edit',[$item->id,101])}}" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Requisition Approved Pending"><span
                                                class="fa fa-spinner"></span></a>
                                  @endif</td>
                              </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>

                  </div>
                  <div class="tab-pane fade" id="sentm"  role="tabpanel" aria-labelledby="home-tab">

                    <div class="py-4 table-responsive">

                        <table id="example5" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                            <thead>
                                <tr class="text-center table-header-fixt-top">
                                    <th>Sl</th>
                                    <th>To User</th>
                                    <th>Reference</th>
                                  	<th>Invoice</th>
                                    <!--<th>Required Date</th>-->
                                    <th>Last Purchase Date</th>
                                    <th>Remarks</th>
                                    <th>Status</th>
                                  <th>Action</th>

                                </tr>
                            </thead>
                            <tbody style="font-size: 18px;">

                             @foreach($from as $item)
                               @php
                              $fuser = \App\Models\User::where('id',$item->to_user_id)->value('name');
                              /* $p = DB::table('row_materials_products')->where('id',$item->item)->value('product_name'); */
                              $approvedUserId = \App\Models\ApprovedUser::where('requisition_id',$item->id)
                                                ->where('user_id',$myid)->value('user_id');
                              @endphp
                              <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$fuser}} <br> {{date('d M y, g:i a', strtotime($item->created_at));}}</td>
                                <td>{{$item->reference}}</td>
                                <td>{{$item->invoice}}</td>
                              {{--  <td>{{date("d M y", strtotime($item->required_date))}}</td> --}}
                                <td>{{date("d M y", strtotime($item->last_purchase_date))}}</td>
                                <td>{{$item->description}}</td>
                                <td>@if($item->status == 3 && $approvedUserId == $myid) <span class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="PR Approved Accept"><i class="fa fa-check-circle" aria-hidden="true"></i></span> @elseif($item->status == 4) <span class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="PR Approved Reject"> <i class="fa fa-times" aria-hidden="true"></i> </span> @else {{$item->status == 0 ? "UnRead" : "Seen"}} @endif</td>
                                <td>@if($item->status == 3 && $approvedUserId == $myid)<a href="{{route('user.chat.view',$item->id)}}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="PR View"><span
                                                class="fa fa-eye"></span></a>  @elseif(!empty($approvedUserId)) <a href="{{route('user.chat.edit',[$item->id,$approvedUserId])}}" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="PR Approved"><span
                                                class="fa fa-spinner"></span></a>  @elseif($myid == 101)  <a href="{{route('user.chat.edit',[$item->id,101])}}" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="PR Approved Pending"><span
                                                class="fa fa-spinner"></span></a>@elseif($item->from_user == $myid || $myid == 101)
                                  <a href="{{route('user.chat.again.edit',$item->id)}}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="PR Edit"><span
                                                class="fa fa-edit"></span></a>
                                  @endif</td>

                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>

                  </div>

               </div>

            </div>
        </div>
    </div>


    <!-- /.modal -->

    <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('sales.invoice.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this invoice?</p>

                        <input type="hidden" id="mid" name="id">
                        <input type="hidden" id="minvoice" name="invoice">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-light">Confirm</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.modal -->



@endsection

@push('end_js')

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })


        $('#delete').on('show.bs.modal', function(event) {
           // console.log('hello test');
            var button = $(event.relatedTarget)
            var title = button.data('mytitle')
            var id = button.data('myid')
            var modal = $(this)
            modal.find('.modal-body #minvoice').val(id);
        });

        // $(document).ready(function() {
        //    $('.receiveMessagesCount').on('click', function() {
        //      alert('OK');
        //    });
        // });
    </script>

@endpush
