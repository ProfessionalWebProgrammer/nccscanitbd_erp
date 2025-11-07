@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	<a href="{{ URL('/production/stock/in/create') }}" class=" btn btn-sm btn-success mr-2">Manual Stock In Entry</a>

                    </div>
                </div>

                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Stock TrunOver Report</h5>


                </div>
                <div class="py-4 table-responsive">
                    <table id="" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top">
                              <th>Production Date</th>
                               <th>Product Name</th>
                               <th>Wirehouse Name</th>
                            <th>SI Qty</th>
                            <th>SO Date</th>
                            <th>SO Qty</th>

                            <th>Duration</th>
                            <th>Balance</th>
                              <th>Batch</th>
                              <th>Factory</th>
                               <th>Expire Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stock_ins as $key=>$data)
                              @php
                                  $sales = \App\Models\SalesLedger::where('product_id',$data->prouct_id)->where('warehouse_bank_id',$data->factory_id)->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_pcs');
                                  $salesdate = \App\Models\SalesLedger::where('product_id',$data->prouct_id)->where('warehouse_bank_id',$data->factory_id)->whereBetween('ledger_date',[$fdate,$tdate])->first();
                                 //$duration = $tdate->diffInDays($fdate);

                           $formatted_dt1=Carbon\Carbon::parse($data->date);

$formatted_dt2=Carbon\Carbon::parse(date('Y-m-d'));

$date_diff=$formatted_dt1->diffInDays($formatted_dt2);

                              @endphp
                              <tr>
                                 <td>{{$data->date}}</td>
                                <td>{{$data->product_name}}</td>
                                <td>{{$data->factory_name}}</td>
                                 <td>{{$data->quantity}}</td>
                                 <td>@if($salesdate) {{$salesdate->ledger_date}} @endif</td>
                                 <td>{{$sales}}</td>
                                 <td>{{$date_diff}} Days</td>
                                <td>{{$data->quantity-$sales}}</td>
                                 <td>{{$data->batch_id}}</td>
                                 <td>{{$data->pfname}}</td>
                                <td>{{$data->expire_date}}</td>
                          	</tr>
                            @endforeach

                             @foreach($transfers as $item)
                              @php
                              	$fromfac = DB::table('factories')->where('id',$item->from_wirehouse)->value('factory_name');
                              	$tofac = DB::table('factories')->where('id',$item->to_wirehouse)->value('factory_name');
								$productiondate = DB::table('sales_stock_ins')->where('batch_id',$item->p_branch_id)->first();
                                $d1=Carbon\Carbon::parse($productiondate->date);
                                $d2=Carbon\Carbon::parse(date('Y-m-d'));
                                $diff=$d1->diffInDays($d2);
                              @endphp
                              <tr>
                                <td>{{$productiondate->date}}</td>
                                <td>{{$item->product_name}} <span class="text-danger">(Tr - {{$item->date}})</span> </td>
                                <td>{{$tofac}}</td>
                                <td>{{$item->qty}}</td>
                                <td></td>
                                <td></td>
                                <td>{{$diff}} Days</td>
                                <td>{{$item->qty}}</td>
                                <td>{{$item->p_branch_id}}</td>
                                <td>{{$fromfac}}</td>
                                <td></td>

                              </tr>
                             @endforeach
                            </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <div class="modal fade" id="delete">
            <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('production.stock.in.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Item?</p>

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

    @endpush
@endsection
