@extends('layouts.purchase_deshboard')
@push('addcss')
    <style>
        .text_sale {
            color: #1fb715;
        }
        .text_credit{
            color: #f90b0b;
        }
          .tableFixHead          { overflow: auto; height: 600px; }
    	.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }

    </style>
@endpush


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">



              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Current Liabilities Report</h5>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                      <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>



                <div class="py-4">

					 <form class="border-warning bordered rounded mb-3 " action="{{ route('current.liabilities.report') }}" method="get">
                        <div class="row p-2">
                            <div class="col-md-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="tdate">Date</label><br>
                                        <input type="text" name="date" class="form-control float-right" id="daterangepicker"
                                            value="{{$date}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group form-check pt-4">
                                            <h4>
                                                <input type="checkbox" class="form-check-input mt-1"  @if($opbalance == 1) checked @endif name="opbalance" id="checkItem"
                                                    style="height: 20px; width: 20px;">
                                                <label class="form-check-label pl-2" for="exampleCheck1">Opening
                                                    Balance</label>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-check pt-4">
                                            <h4>
                                                <input type="checkbox" class="form-check-input mt-1" @if($clbalance == 1) checked @endif name="clbalance" id="checkItem"
                                                    style="height: 20px; width: 20px;">
                                                <label class="form-check-label pl-2" for="exampleCheck1">Closing
                                                    Balance</label>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-check pt-4">
                                            <h4>
                                                <input type="checkbox" class="form-check-input mt-1" @if($totalpayable == 1) checked @endif name="totalpayable" id="checkItem"
                                                    style="height: 20px; width: 20px;">
                                                <label class="form-check-label pl-2" for="exampleCheck1">Total
                                                    Payable</label>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-check pt-4">
                                            <h4>
                                                <input type="checkbox" class="form-check-input mt-1" @if($totalpaid == 1) checked @endif name="totalpaid" id="checkItem"
                                                    style="height: 20px; width: 20px;">
                                                <label class="form-check-label pl-2" for="exampleCheck1">Total Paid</label>
                                            </h4>
                                        </div>
                                    </div>
                                  	<div class="col-md-2">
                                        <div class="form-group form-check pt-4">
                                            <h4>
                                                <input type="checkbox" class="form-check-input mt-1" @if($recivedquantity == 1) checked @endif name="recivedquantity" id="checkItem"
                                                    style="height: 20px; width: 20px;">
                                                <label class="form-check-label pl-2" for="exampleCheck1">Receive Quantity</label>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-check pt-4">
                                            <h4>
                                                <input type="checkbox" class="form-check-input mt-1" @if($totalreturn == 1) checked @endif name="totalreturn" id="checkItem"
                                                    style="height: 20px; width: 20px;">
                                                <label class="form-check-label pl-2" for="exampleCheck1">Total Return</label>
                                            </h4>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 m-auto">
                                <div class="form-group form-check pt-2 text-center">
                                       <input type="checkbox" class="mb-1" id="checkAll" style="height: 15px; width: 15px;"> Select All <br>
                                     <button type="submit" class="btn btn-success btn-sm">Ganarate <i class="fas fa-cog fa-spin"></i></button>
                                       <a type="submit" href="{{route('current.liabilities.report')}}" class="btn btn-danger btn-sm">Clear</a>
                                </div>
                            </div>
                        </div>
                   </form>
                    <table id="datatable7" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>SI. No</th>
                                <th>Supplier Name</th>
                                <th class="@if($opbalance == 0) d-none @endif">Opening Balance</th>
                              	<th class="@if($recivedquantity == 0) d-none @endif">Received Quantity</th>
                              	<th class="@if($totalreturn == 0) d-none @endif">Return Quantity</th>
                                <th class="@if($totalpayable == 0) d-none @endif">Total Net Payable Amount</th>
                                <th class="@if($totalpaid == 0) d-none @endif">Total Paid</th>
                                <th class="@if($clbalance == 0)  @endif">Closing Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php

                            $tpay = 0;
                            $trcvqty = 0;
                            $trtnqty = 0;
                             $tpaid = 0;
                            $top= 0;
                            $tcl= 0;
                          @endphp
                            @foreach ($suppliers as $data)
                          	@if($date !== '')
                               @php
                                    $totalpayablle = DB::table('purchases')
                          				->whereBetween('date', [$f_date, $t_date])
                                        ->where('raw_supplier_id', $data->id)
                                        ->sum('total_payable_amount');

                                     $totalreceivedqnty = DB::table('purchases')
                          				->whereBetween('date', [$f_date, $t_date])
                                        ->where('raw_supplier_id', $data->id)
                                        ->sum('receive_quantity');

                          			$totalreturnqnty = DB::table('purchase_returns')
                          				->whereBetween('date', [$f_date, $t_date])
                                        ->where('raw_supplier_id', $data->id)
                                        ->sum('return_quantity');

                                    $totalpaied = DB::table('payments')
                          				->whereBetween('payment_date', [$f_date, $t_date])
                                        ->where('supplier_id', $data->id)
                                        ->sum('amount');

                                    $openingbalance = $data->opening_balance;
                                    $closingbalance = ($totalpayablle + $openingbalance)-$totalpaied;

                                @endphp
                          	@else
                          		 @php
                                    $totalpayablle = DB::table('purchases')
                                        ->where('raw_supplier_id', $data->id)
                                        ->sum('total_payable_amount');

                                    $totalreceivedqnty = DB::table('purchases')
                                        ->where('raw_supplier_id', $data->id)
                                        ->sum('receive_quantity');

                          			$totalreturnqnty = DB::table('purchase_returns')
                                        ->where('raw_supplier_id', $data->id)
                                        ->sum('return_quantity');

                                    $totalpaied = DB::table('payments')
                                        ->where('supplier_id', $data->id)
                                        ->sum('amount');
                                    $openingbalance = $data->opening_balance;
                                    $closingbalance = $totalpaied - ($totalpayablle + $openingbalance);

                                @endphp
                          	@endif
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $data->supplier_name }}</td>
                                    <td class="text-right @if($opbalance == 0) d-none @endif">{{ number_format($openingbalance) }}</td>
                                  	<td class="text-right @if($recivedquantity == 0) d-none @endif">{{ number_format($totalreceivedqnty) }}</td>
                                  	<td class="text-right @if($totalreturn == 0) d-none @endif">{{ number_format($totalreturnqnty) }}</td>
                                    <td class="text-right @if($totalpayable == 0) d-none @endif">{{ number_format($totalpayablle) }}</td>
                                    <td class="text-right @if($totalpaid == 0) d-none @endif">{{ number_format($totalpaied) }}</td>
                                    <td class="text-right @if($clbalance == 0)  @endif">{{ number_format($closingbalance) }}</td>
                                </tr>

                           @php

                            $tpay += $totalpayablle;
                            $trcvqty += $totalreceivedqnty;
                             $trtnqty += $totalreturnqnty;
                            $tpaid += $totalpaied;
                            $top += $openingbalance;
                            $tcl += $closingbalance;
                          @endphp
                            @endforeach





                        </tbody>
                       <tfoot>
                        <tr style="font-weight:bold">
                                    <td class="text-center"></td>
                                    <td>Total </td>
                                    <td class="text-right @if($opbalance == 0) d-none @endif">{{ number_format($top,2) }}</td>
                                  	<td class="text-right @if($recivedquantity == 0) d-none @endif">{{ number_format($trcvqty,2) }}</td>
                                  	<td class="text-right @if($totalreturn == 0) d-none @endif">{{ number_format($trtnqty,2) }}</td>
                                    <td class="text-right @if($totalpayable == 0) d-none @endif">{{ number_format($tpay,2) }}</td>
                                    <td class="text-right @if($totalpaid == 0) d-none @endif">{{ number_format($tpaid,2) }}</td>
                                    <td class="text-right @if($clbalance == 0)  @endif">{{ number_format($tcl,2) }}</td>
                                </tr>
                      </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
	<script>
        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

    </script>

@endsection
