@extends('layouts.account_dashboard')


@section('header_menu')
<li class="nav-item d-none d-sm-inline-block">

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper accountscontent">


        <!-- Main content -->
        <div class="content px-4 ">
           <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">

              <div class="row pt-3">
                      <div class="col-md-12 text-left">
                       <a href="{{ URL('/normalJournal/entry/create') }}" class=" btn btn-primary mr-2">Normal Journal Payment</a>
                       {{-- <a href="{{ URL('/journal/entry/create') }}" class=" btn btn-success mr-2">Create Journal Payment</a> --}}
                       <a href="{{ URL('/journal/report/index') }}" class=" btn btn-success mr-2">Journal Report</a>
                        <a href="{{ route('otherJournal.entry.create') }}" class=" btn btn-success mr-2">Others Journal Payment</a>
                       </div>

                  </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div>
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Journal List</h5>
                        <hr>
                    </div>
                    <table id="example3" class="table table-bordered table-striped" style="font-size: 13px;">
                        <thead>
                            <tr class="text-center">
                                <th>Sl</th>
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Particular</th>
                                <th>Dr</th>
                                <th>Cr</th>
                              	<th>User</th>
                                <th width="13%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 0;
                             @endphp
                            @foreach ($data['data'] as $item)

                                @php
                                $sl++;
                          			$name = DB::table('users')->where('id', $item->user_id)->value('name');
                                 @endphp
                                    <tr>
                                        <td class="align-middle">{{ $sl }}</td>
                                        <td>{{$item->invoice}}</td>
                                        <td class="align-middle"> {{$item->date}}</td>
                                        <td class="align-middle">@if(!empty($item->supplier_name)) {{ $item->supplier_name }}  @elseif(!empty($item->d_s_name)){{$item->d_s_name}} @else  {{$item->subject}} @endif</td>
                                        <td class="align-middle"> {{number_format($item->debit,2)}}</td>
                                        <td class="align-middle"> {{number_format($item->credit,2)}}</td>
                                      <td class="align-middle"> {{$name}} </br> {{$item->created_at}}</td>
                                        <td class="text-center align-middle">
                                            {{--<a class="btn btn-xs text-light accountsedit" style="background-color: #66BB6A" href="{{route('journal.entry.edit',$item->id)}}"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fas fa-edit"></i> </a>--}}
                                          <a class="btn btn-xs text-light btn-primary"  href="{{route('journal.entry.view',$item->invoice)}}"
                                                data-toggle="tooltip" data-placement="top" title="View"><i
                                                    class="fas fa-eye"></i> </a>
                                          <a class="btn btn-xs btn-danger accountsdelete" href="" data-myid="{{ $item->invoice }}"
                                                        data-mytitle="" data-toggle="modal" data-target="#delete"><i
                                                            class="far fa-trash-alt"></i>
                                                </td>
                                    </tr>

                            @endforeach
                        </tbody>
                    </table>

                  <div class="text-center mt-5">
                        <h5 class="text-uppercase font-weight-bold">Asset Journal List</h5>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>Sl</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Asset Type</th>
                                <th>Asset Value</th>
                                <th>Payment </th>
                                <th>Remaining </th>
                                <th>Payment Mode</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data['assets'] as $data)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ date('d-M-Y', strtotime($data->date)) }}</td>
                                    <td class="text-left">{{ $data->invoice }}</td>
                                    <td class="text-left">{{$data->asset_type_name}}</td>
                                    <td class="text-right">{{ number_format($data->asset_value,2) }}</td>
                                    <td class="text-right">{{ number_format($data->payment_value,2) }}</td>
                                    <td class="text-right">{{ number_format($data->remaining_value,2) }}</td>
                                    <td class="text-lef">
                                        @if ($data->payment_mode == 'Bank')
                                            {{ $data->payment_mode }}
                                            <span
                                                class="text-danger">({{ DB::table('master_banks')->where('bank_id', $data->bank_id)->value('bank_name') }})</span>
                                        @elseif($data->payment_mode == "Cash")
                                            {{ $data->payment_mode }} <span
                                                class="text-danger">({{ DB::table('master_cashes')->where('wirehouse_id', $data->wirehouse_id)->value('wirehouse_name') }})</span>
                                        @endif
                                    </td>
                                    <td class="text-left">{{ $data->description }}</td>


                                    <td class="text-center align-middle">
                                        {{-- <a class="btn btn-sm accountsedit"
                                            style="background-color: mediumaquamarine;                                                                                                                                                                                                                                                                    color: white;"
                                            href="{{route('asset.edit',$data->id)}}" data-toggle="tooltip" data-placement="top" title="CheckOut Asset"><i
                                                class="fas fa-spinner"></i></a> --}}
                                        <a class="btn btn-xs btn-danger accountsdelete" href="" data-toggle="modal" data-target="#assetdelete"
                                                        data-myid="{{ $data->id }}"><i class="far fa-trash-alt"></i>
                                                    </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                  <!-- expense journal start -->
                  <div class="text-center mt-5">
                        <h5 class="text-uppercase font-weight-bold">Expense Journal List</h5>
                        <hr>
                    </div>

                  <table id="example2" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>Sl</th>
                              	<th>Date</th>
                                <th>Invoice</th>
                              	<th>Company/Account</th>
                                <th>Expnase Group</th>
                                <th>Sub Ledger</th>
                              	<th>Expnase Head</th>
                                <th>Amount</th>
                              	<th>User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $item)

                                @php

                                $username = DB::table('users')->where('id',$item->created_by)->value('name');
                                $expansegroup = DB::table('expanse_subgroups')->where('id',$item->expanse_subgroup_id)->value('group_name');
                                $expansesubgroup = DB::table('expanse_subgroups')->where('id',$item->expanse_subgroup_id)->value('subgroup_name');
                                @endphp
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{date('d-M-Y', strtotime($item->payment_date))}}</td>
                                        <td class="text-center align-middle">{{$item->invoice}}</td>
                                        <td class="align-middle">{{$item->bank_name}} {{$item->wirehouse_name}}</td>
                                        <td class="align-middle">{{$expansegroup}}</td>
                                        <td class="align-middle">{{$expansesubgroup}}</td>
                                      	<td class="align-middle">{{$item->expanse_head}}</td>
                                        <td class="text-right align-middle"> {{number_format($item->amount,2)}}/-</td>
                      					<td class="text-center align-middle">{{$username}} <br> {{$item->created_at}}</td>
                                        <td class="text-center align-middle">
                                            {{-- <a class="btn btn-sm text-light accountsedit" style="background-color: #66BB6A" href="{{route('expanse.payment.edit',$item->id)}}"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fas fa-edit"></i> </a> --}}
                                          <a class="btn btn-xs btn-danger accountsdelete" href="" data-myid="{{ $item->id }}"
                                                        data-mytitle="" data-toggle="modal" data-target="#expensedelete"><i
                                                            class="far fa-trash-alt"></i>
                                                </td>
                                    </tr>

                            @endforeach



                        </tbody>
                    </table>
                  <!-- expense journal end -->
                </div>
            </div>
        </div>
    </div>

        <!-- /.modal journal-->

        <div class="modal fade" id="delete">
            <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                      <form action="{{ route('journal.entry.delete') }}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this?</p>

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

        <!-- /.modal journal end-->

 <!-- /.modal journal start-->

        <div class="modal fade" id="assetdelete">
            <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                      <form action="{{ route('otherJournal.entry.delete') }}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this?</p>

                            <input type="hidden" id="mid" name="id">
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

        <!-- /.modal journal end-->

	<!-- /.modal -->

        <div class="modal fade" id="expensedelete">
            <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('expanse.payment.delete') }}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this?</p>

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
                console.log('hello test');
                var button = $(event.relatedTarget)
                var title = button.data('mytitle')
                var id = button.data('myid')

                var modal = $(this)

                modal.find('.modal-body #mid').val(id);
            });

			$('#assetdelete').on('show.bs.modal', function(event) {
                //console.log('hello test');
                var button = $(event.relatedTarget)
               var id = button.data('myid')

                var modal = $(this)

                modal.find('.modal-body #mid').val(id);
            });

          $('#expensedelete').on('show.bs.modal', function(event) {
                alert('hello test');
                var button = $(event.relatedTarget)
               var id = button.data('myid')

                var modal = $(this)

                modal.find('.modal-body #mid').val(id);
            });

            $(document).ready(function() {

                $("#daterangepicker").change(function() {
                    var a = document.getElementById("today");
                    a.style.display = "none";
                });



            });
        </script>

    @endpush
