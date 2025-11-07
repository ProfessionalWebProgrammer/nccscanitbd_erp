@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px; min-height:85vh;">
              <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	 <a href="{{ route('product.transfer.create') }}" class=" btn btn-sm btn-success mr-2">Transfer Entry</a>
                    </div>
                </div>

                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Transfer List </h5>
                        <hr>
                    </div>
                    <div class="my-3">

                    </div>
                    <table id="example1" class="table table-bordered text-light table-striped" style="font-size: 15px;">
                        {{-- <table id="example1" class="table table-bordered" style="width:100%; font-size:13px;font-weight: 600;"> --}}
                        <thead>
                            <tr>
                                <th>SI. No</th>
                                <th>Date</th>
                                <th>From Wirehouse</th>
                                <th>To Wirehouse</th>
                                <th>Invoice Number</th>
                                <th>Vehicle</th>
                                <th>Fare</th>
                                <th>Total Amount</th>
                                <th>Batch N.</th>
                                <th>Note</th>
                                <th>Total Qantity</th>
                                <th>Delivery Time</th>
                                <th style="width:120px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $t_qty = 0;
                                $t_value = 0;
                                $t_fare = 0;

                      //    dd($transfer);
                            @endphp

                            @foreach ($transfer as $data)
                                @php
                                    $from_w = DB::table('factories')
                                        ->where('id', $data->from_wirehouse)
                                         ->value('factory_name');

                                    $to_w = DB::table('factories')
                                        ->where('id', $data->to_wirehouse)
                                        ->value('factory_name');

                                    $t_qty += $data->qty;
                                    $t_value += $data->price;
                                    $t_fare += $data->transfer_fare;

                                    $tr_products = DB::table('transfers')
                                        ->select('transfers.*', 'sales_products.product_name', 'sales_products.product_dp_price')
                                        ->leftJoin('sales_products', 'transfers.product_id', '=', 'sales_products.id')
                                        ->where('invoice', $data->invoice)
                                        ->get();
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }} <br> ({{$data->created_at}})</td>
                                    <td>{{ $data->date }}</td>
                                    <td>{{ $from_w }}</td>
                                    <td>{{ $to_w }}</td>
                                    @if ($data->confirm_status == 0)
                                        <td style="color: red;font-weight: bold;">{{ $data->invoice }}</td>
                                    @else
                                        <td style="color: green;font-weight: bold;">{{ $data->invoice }}</td>
                                    @endif
                                    <td>{{ $data->vehicle }}</td>
                                    <td>{{ $data->transfer_fare }}</td>
                                    <td align="right">{{ $data->price }}</td>
                                    <td>{{ $data->p_branch_id }}</td>
									<td>{{ $data->note }}</td>
                                    <td align="right">
                                        @foreach ($tr_products as $pdata)
                                            {{ $pdata->product_name }} - {{ $pdata->qty }} <br />
                                        @endforeach
                                        <span style="color:red"> Total - {{ $data->qty }} </span>
                                    </td>
                                  @php

                                  $datetime1 	= new DateTime($data->created_at);
								$datetime2 	= new DateTime($data->updated_at);
                                  $interval 	= $datetime1->diff($datetime2);

                                //  $difftime = date('H Hour i Minute', strtotime($interval));
                                  	//dd($interval->i);
                                  @endphp
                                 {{-- <td> {{ ( new Carbon\Carbon($starttime))->diff(new Carbon($endtime))->format('%h:%I') }} </td>   --}}
                                  <td>@if($data->confirm_status == 1) {{ $interval->h }} Hour {{ $interval->i }} Minute <br> ({{$data->updated_at}}) @endif</td>

                                    <td>
                                        {{--<a class="btn btn-xs text-light salesedit" style="background-color: #66BB6A"
                                        href="{{ URL::to('/product/transfer/edit/' . $data->invoice) }}"
                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                            class="fas fa-edit"></i> </a> --}}
                                      <a class="btn btn-xs btn-info text-light "
                                        href="{{ URL::to('/product/transfer/chalan/view/' . $data->invoice) }}"
                                        data-toggle="tooltip" data-placement="top" title="Chalan View"><i
                                            class="far fa-eye"></i> </a>

                                             <a class="btn btn-xs btn-danger salesdelete" href="" data-toggle="modal" data-target="#delete"
                                            data-myid="{{ $data->invoice }}"><i class="far fa-trash-alt"></i>

                                        </a>
                                       @if ($data->confirm_status == 0)
                                      <a class="btn btn-xs text-light salesedit mt-1" style="background-color: #2f49ff"
                                        href="{{ URL::to('/product/transfer/return/' . $data->invoice) }}"
                                        data-toggle="tooltip" data-placement="top" title="Return">Return</a>
                                      @endif

                                    </td>
                                </tr>



                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>



                                <th></th>
                                <th style="text-align:right">Total = </th>
                                <th style="text-align:right">{{ $t_fare }}</th>
                                <th style="text-align:right">{{ $t_value }}</th>
                                <th></th>
                                <th></th>
                                <th style="text-align:right">{{ $t_qty }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>

                    </table>
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
                <form action="{{ route('product.transfer.delete') }}" method="POST">
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
          //  console.log('hello test');
            var button = $(event.relatedTarget)
            var title = button.data('mytitle')
            var id = button.data('myid')

            var modal = $(this)

            modal.find('.modal-body #minvoice').val(id);
        })
    </script>

@endpush
