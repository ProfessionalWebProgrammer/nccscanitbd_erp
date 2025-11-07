@extends('layouts.account_dashboard')

@push('addcss')
    <style>
        .text_sale {
            color: #f7ee79;
        }

        .text_credit {
            color: lime;
        }
    </style>
@endpush

@section('print_menu')
    <li class="nav-item">

    </li>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="padding-bottom: 100px;">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="row pt-3">
                <div class="col-md-12 text-right">
                    <button class="btn btn-sm  btn-success mt-1" id="btnExport">
                        Export
                    </button>
                    <button class="btn btn-sm  btn-warning mt-1" onclick="printDiv('contentbody')" id="printbtn">
                        Print
                    </button>
                </div>
            </div>

            <div class="container-fluid" id="contentbody">
                <div class="container" style="padding-top: 31px !important;">
                    <div class="col-md-10 offset-md-1">


                        <div class="row pt-2">
                            <div class="col-md-4 text-left">
                                <h5 class="text-uppercase font-weight-bold">PL Statement</h5>
                                <p>From {{ date('d m, Y', strtotime($fdate)) }} to {{ date('d m, Y', strtotime($tdate)) }}
                                </p>

                            </div>
                            <div class="col-md-4 pt-3 text-center">
                                <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                                <p>Head office, Rajshahi, Bangladesh</p>
                            </div>
                        </div>
                        <div class="row py-4">
                            <div class="py-4 col-md-12 table-responsive insertAfter">
                                <table id="reporttable" class="table table-bordered table-striped table-fixed"
                                    style="font-size:13px;table-layout: inherit;">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Sales Revenue Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <th>Particulars </th>
                                            <th>Amount (BDT)</th>
                                        </tr>
                                        {{-- <tr>
                                              <td>Monthly Total Sales </td>
                                              <td align="right">{{number_format(($data['sales']), 2)}}</td>
                                          </tr> --}}

                                        @php
                                            $totalSales = 0;
                                        @endphp
                                        @foreach ($categories as $val)
                                            @php
                                                $salesData = \App\Models\SalesLedger::select(DB::raw('SUM(total_price) + SUM(discount_amount) as balance'))->where('category_id', $val->id)
                                                    ->whereBetween('ledger_date', [$fdate, $tdate])
                                                    ->whereNotNull('category_id')
                                                    ->first();
                                                    $amount = $salesData->balance ?? 0 ;
                                                $totalSales += $amount;
                                            @endphp
                                            @if ($amount > 0)
                                                <tr>
                                                    <td>{{ $val->name }}</td>
                                                    <td align="right">{{ number_format($amount, 2) }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td>Sub Total Sales</td>
                                            <td align="right">{{ number_format(($totalSales), 2) }}</td>
                                        </tr>
                                        @if ($data['salesDiscount'])
                                            <tr style="color:#000;">
                                                <td> Sales Discount </td>
                                                <td align="right">{{ number_format($data['salesDiscount'], 2) }}</td>
                                            </tr>
                                        @endif
                                        @if ($data['sales_return'])
                                            <tr style="color:#000;">
                                                <td> Sales Return </td>
                                                <td align="right">{{ number_format($data['sales_return'], 2) }}</td>
                                            </tr>
                                        @endif
                                        @php
                                            $salesRevenue = $totalSales - ($data['sales_return'] + $data['salesDiscount']);
                                        @endphp
                                        <tr>
                                            <td>Total Sales Revenues :</td>
                                            <td align="right">{{ number_format($salesRevenue, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @php
                                    $totalFC = 0;
                                    $totalCost = 0;
                                @endphp


                                @foreach ($expenseData as $key => $val)
                                    @if ($val['id'] == 21 || $val['id'] == 56 || $val['id'] == 9)
                                        @php
                                            $totalFC += $val['debit'];
                                        @endphp
                                    @endif
                                @endforeach

                                @php
                                    $totalCost = $assetData['rawCogs'] + $assetData['packCogs'] + $totalFC;
                                @endphp

                                {{--  <table  class="table table-bordered table-striped table-fixed" style="font-size:13px; table-layout: inherit;">
                                        <thead>
                                          <tr>
                                            <th colspan="2">F.G Closing Details</th>
                                            </tr>
                                      </thead>
                                      <tbody>
                                        <tr class="text-center">
                                                <th>Particulars </th>
                                                <th>Amount (BDT)</th>
                                        </tr>

                                          @php
                                                $totalFC = 0;
                                                $totalCost = 0;
                                            @endphp


                                            @foreach ($expenseData as $key => $val)
                                              @if ($val['id'] == 21 || $val['id'] == 56 || $val['id'] == 9)
                                              @php
                                                  $totalFC += $val['debit'];
                                              @endphp
                                              @endif
                                            @endforeach

                                            @php
                                              $totalCost = $assetData['rawCogs'] + $assetData['packCogs'] + $totalFC;
                                            @endphp

                                        <tr>
                                            <td>Manufacturing Cost :</td>
                                          <td align="right">{{number_format($totalFC, 2)}}</td>
                                        </tr>
                                        <tr>
                                            @php

                                            @endphp
                                            <td>Total C.O.G.S :</td>
                                          <td align="right">{{number_format($totalCost, 2)}}</td>
                                        </tr>
                                        </tbody>
                                </table> --}}
                            </div>

                            <div class="py-4 col-md-12 table-responsive" id="insertAfter">
                                <table id="reporttable" class="table table-bordered table-striped table-fixed"
                                    style="font-size:13px; table-layout: inherit;">
                                    <thead>
                                        <tr class="text-center" style="font-size:20px; font-weight: 600;">
                                            <th>Particulars </th>
                                            <th>Amount (BDT)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                        @endphp


                                        <tr>
                                            @php
                                                $total += $salesRevenue;
                                            @endphp
                                            <td style="font-size:20px; font-weight: 600;">Sales Revenues</td>
                                            <td align="right">{{ number_format($salesRevenue, 2) }}</td>
                                        </tr>

                                        <tr>
                                            @php
                                                /*$temp = $data['cogs']; */
                                                $total -= $totalCost;

                                            @endphp
                                            <td>C.O.G.S (Direct Operating Cost) </td>
                                            <td align="right">{{ number_format($totalCost, 2) }} </td>

                                        </tr>
                                        @if ($data['sales'] > 0)
                                            <tr style="font-weight: bold; font-size:20px;">
                                                <td>Gross profit</td>
                                                <td align="right">{{ number_format($total, 2) }} @if ($total != 0)
                                                        ({{ number_format(($total / $salesRevenue) * 100, 2) }}%)
                                                    @endif
                                                </td>

                                            </tr>
                                        @endif
                                        @if ($expenseData)
                                            <tr style="font-weight: bold;color:#000; font-size:20px;">
                                                <td>Operating Expanse</td>
                                                <td align="right"></td>
                                            </tr>

                                            @php
                                                $expansetotal = 0;
                                            @endphp


                                            @foreach ($expenseData as $key => $val)
                                                @if ($val['id'] != 8 && $val['id'] != 9 && $val['id'] != 10 && $val['id'] != 18 && $val['id'] != 21 && $val['id'] != 56 && $val['id'] != 60)
                                                    @if($val['id'] == 23)
                                                    @php
                                                        $total -= $val['debit'] + $data['depreciationAmounts'] ;
                                                        $expansetotal += $val['debit'] + $data['depreciationAmounts'];
                                                    @endphp
                                                    <tr>
                                                        <td class="pl-5">{{ $val['title'] }}</td>
                                                        <td align="right">{{ number_format(($val['debit'] + $data['depreciationAmounts']), 2) }}</td>
                                                    </tr>
                                                    @else
                                                    @php
                                                        $total -= $val['debit'];
                                                        $expansetotal += $val['debit'];
                                                    @endphp
                                                    <tr>
                                                        <td class="pl-5">{{ $val['title'] }}</td>
                                                        <td align="right">{{ number_format($val['debit'], 2) }}</td>
                                                    </tr>
                                                @endif
                                                @endif
                                            @endforeach




                                             
                                            <tr style="font-weight:bold">
                                                <td class="pl-5">Depreciation Amount </td>
                                                <td align="right">
                                                    {{ number_format($data['depreciationAmounts'], 2) ?? 0 }}</td>
                                            </tr>



                                            <tr style="font-weight:bold; font-size:20px;">
                                                <td>Total Operating Expanse</td>
                                                <td align="right">
                                                    {{ number_format($expansetotal, 2) }}
                                                </td>
                                            </tr>

                                            <tr style="font-weight: bold; color:#000;font-size:20px;">
                                                <td>Total Operating Profit</td>
                                                <td align="right">{{ number_format($total, 2) }}</td>
                                            </tr>
                                        @endif

                                        @if ($allincome)
                                            <tr style="font-weight: bold;color:#000;font-size:20px;">
                                                <td>Others Income</td>
                                                <td align="right"></td>
                                            </tr>

                                            @php
                                                $incometotal = 0;
                                            @endphp
                                            @foreach ($allincome as $key => $item)
                                                @if ($item->incomeamount > 0)
                                                    <tr>
                                                        @php
                                                            $total += $item->incomeamount;
                                                            $incometotal += $item->incomeamount;
                                                        @endphp
                                                        <td class="pl-5">{{ $item->name }}</td>
                                                        <td align="right">{{ number_format($item->incomeamount, 2) }}</td>

                                                    </tr>
                                                @endif
                                            @endforeach

                                            <tr style="font-weight: bold; font-size:20px;">
                                                <td>Total Income</td>
                                                <td align="right">{{ number_format($incometotal, 2) }}</td>
                                            </tr>
                                        @endif

                                        <tr style="font-weight: bold; font-size:20px;">
                                            {{-- <td>Total Operating Profit (Before Financial Expense & Tax)</td> --}}
                                            <td>Total Operating Profit (Before Financial Expense)</td>
                                            <td align="right">{{ number_format($total, 2) }}</td>
                                        </tr>

                                        <tr style="font-weight: bold;font-size:20px;">
                                            <td colspan="2">Financial Expense</td>
                                        </tr>
                                        @php
                                            $total_f_exp = 0;
                                        @endphp
                                        @foreach ($expenseData as $key => $item)
                                            @if ($item['id'] == 10)
                                                @php
                                                    $total -= $item['debit'];
                                                    $total_f_exp += $item['debit'];
                                                @endphp
                                                <tr>
                                                    <td class="pl-5">{{ $item['title'] }}</td>
                                                    <td align="right">{{ number_format($item['debit'], 2) }}</td>
                                                </tr>
                                            @endif
                                        @endforeach



                                        <tr style="font-weight: bold; font-size:20px;">
                                            <td>Total Operating Profit (After Financial Expense)</td>
                                            <td align="right">{{ number_format($total, 2) }}</td>
                                        </tr>
                                    </tbody>

                                    <tfoot>
                                        <tr style="color:#000; font-weight:bold; font-size:20px;">
                                            <th>Net Profit </th>
                                            {{-- <td align="right">{{ number_format(($total/100)*(100-$taxes), 2) }}</td> --}}
                                            <td align="right">{{ number_format($total, 2) }}</td>

                                        </tr>

                                    </tfoot>

                                </table>
                            </div>
                            {{-- Inside code start --}}
                            <div class="py-4 col-md-12 table-responsive">
                                <table id="reporttable" class="table table-bordered table-striped table-fixed"
                                    style="font-size: 13px;table-layout: inherit;">
                                    <thead>
                                        <tr>
                                            <th colspan="2">C. O. G. S</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <th>Particulars </th>
                                            <th>Amount (BDT)</th>
                                        </tr>

                                        <tr>
                                            <td><a href="#" data-toggle="modal" data-target="#rmConsumption"
                                                    data-myid=""> Direct R.M Consumption </a></td>
                                            <td align="right"> {{ number_format($assetData['rawCogs'], 2) }} </td>
                                        </tr>

                                        <tr>
                                            <td><a href="#" data-toggle="modal" data-target="#packingConsumption"
                                                    data-myid="">Packing Material Consumption </a></td>
                                            <td align="right">{{ number_format($assetData['packCogs'], 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Labor Expenses (Direct)</td>
                                        </tr>

                                        @php
                                            $totalLEC = 0;
                                        @endphp
                                        @foreach ($expenseData as $key => $val)
                                            @if ($val['id'] == 56)
                                                @php
                                                    $totalLEC += $val['debit'];
                                                @endphp
                                                <tr>
                                                    <td class="pl-5">{{ $val['title'] }}</td>
                                                    <td align="right">{{ number_format($val['debit'], 2) }}</td>
                                                </tr>
                                            @endif
                                        @endforeach


                                        {{-- @foreach ($allexpasne as $key => $item)

                                      @if ($item->id == 20)

                                          @php


                                              $totalLEC += $item->expamount;

                                              $factoryCostDetails = App\Models\Payment::select([DB::raw("SUM(amount) expFAmount"),'expanse_subgroups.subgroup_name as name'])
                                                                    ->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
                                                                    ->where('payments.expanse_type_id',$item->id)
                                                                    ->where('payments.payment_type', 'EXPANSE')
                                                                    ->whereBetween('payment_date', [$fdate, $tdate])
             				                                                ->where('payments.status', 1)
                                                                    ->groupby('payments.expanse_subgroup_id')->get();

                                          @endphp
                                          @foreach ($factoryCostDetails as $val)

                                            <tr>
                                                <td class="pl-5">{{$val->name}}</td>
                                                <td align="right">{{  number_format($val->expFAmount, 2) }}</td>
                                            </tr>
                                            @endforeach
                                      @endif
                                    @endforeach --}}

                                        <tr>
                                            <td>Prime Cost :</td>
                                            <td align="right">
                                                {{ number_format($assetData['rawCogs'] + $assetData['packCogs'] + $totalLEC, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table id="reporttable" class="mt-5 table table-bordered table-striped table-fixed"
                                    style="font-size: 13px;table-layout: inherit;">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Manufacturing Overhead</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <th>Particulars </th>
                                            <th>Amount (BDT)</th>
                                        </tr>
                                        @php
                                            $totalLEOver = 0;
                                        @endphp

                                        @foreach ($expenseData as $key => $val)
                                            @if ($val['id'] == 21 || $val['id'] == 9)
                                                @php
                                                    $totalLEOver += $val['debit'];
                                                @endphp
                                                <tr>
                                                    <td class="pl-5">{{ $val['title'] }}</td>
                                                    <td align="right">{{ number_format($val['debit'], 2) }}</td>
                                                </tr>
                                            @endif
                                        @endforeach




                                        <tr>
                                            <td>Total Manufacturing Overhead Cost:</td>
                                            <td align="right">{{ number_format($totalLEOver, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total C.O.G.S :</td>
                                            <td align="right">{{ number_format($totalCost, 2) }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                                <table class="table table-bordered table-striped table-fixed"
                                    style="font-size:13px; table-layout: inherit;">
                                    <thead>
                                        <tr>
                                            <th colspan="2">F.G Closing Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <th>Particulars </th>
                                            <th>Amount (BDT)</th>
                                        </tr>
                                        <tr>
                                            <td>Prime Cost :</td>
                                            <td align="right">
                                                {{ number_format($assetData['rawCogs'] + $assetData['packCogs'] + $totalLEC, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Manufacturing Overhead Cost:</td>
                                            <td align="right">{{ number_format($totalLEOver, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total C.O.G.S :</td>
                                            <td align="right">{{ number_format($totalCost, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{-- end --}}
                        </div>

                    </div><!--/.col-md-10 offset-md-1-->
                </div><!--/.container-->

            </div>
        </div>
    </div>

    <!-- /.modal -->
    <div class="modal fade" id="rmConsumption">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">RM Consumptions </h4>
                    <p class="mt-2 ml-2"> From {{ date('d m, Y', strtotime($fdate)) }} to
                        {{ date('d m, Y', strtotime($tdate)) }}</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @php
                    $salesDatas = \App\Models\SalesLedger::select('product_id as id', 'product_name as name')
                        ->whereNotNull('product_id')
                        ->whereBetween('ledger_date', [$fdate, $tdate])
                        ->groupby('product_id')
                        ->get();
                @endphp
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-fixed"
                        style="font-size: 13px;table-layout: inherit;">
                        <thead>
                            <tr style="background:#FA621C; color:#f5f5f5;">
                                <th>Sl</th>
                                <th>Item Name</th>
                                <th>Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salesDatas as $key => $val)
                                @php
                                    $production = \App\Models\PurchaseStockout::select(
                                        'r.product_name as name',
                                        'stock_out_rate as rate',
                                    )
                                        ->leftjoin(
                                            'row_materials_products as r',
                                            'r.id',
                                            '=',
                                            'purchase_stockouts.product_id',
                                        )
                                        ->where('r.product_name', $val->name)
                                        ->first();
                                    if (!empty($production)) {
                                        $name = $production->name;
                                        $rate = $production->rate;
                                    } else {
                                        $rawProduct = \App\Models\PurchaseStockout::select(
                                            'r.product_name as name',
                                            'stock_out_rate as rate',
                                        )
                                            ->leftjoin(
                                                'row_materials_products as r',
                                                'r.id',
                                                '=',
                                                'purchase_stockouts.product_id',
                                            )
                                            ->where('finish_goods_id', $val->id)
                                            ->first();
                                        $tempRate = $rawProduct->rate ?? -1;
                                        if ($tempRate > 0) {
                                            $name = $rawProduct->name;
                                            $rate = $rawProduct->rate;
                                        } else {
                                            $name = $val->name;
                                            $rate = \App\Models\SalesProduct::where('id', $val->id)->value('rate');
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $name }}</td>
                                    <td>{{ $rate }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{--  <div class="modal-footer float-right ">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    </div> --}}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- /.modal -->
    <div class="modal fade" id="packingConsumption">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Packing Consumptions </h4>
                    <p class="mt-2 ml-1"> ({{ date('d m, Y', strtotime($fdate)) }} to
                        {{ date('d m, Y', strtotime($tdate)) }}) </p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @php
                    $salesDatas = \App\Models\PackingConsumptions::select(
                        'r.product_name as name',
                        'packing_consumptions.rate',
                    )
                        ->leftjoin('row_materials_products as r', 'r.id', '=', 'packing_consumptions.bag_id')
                        ->whereNotNull('packing_consumptions.bag_id')
                        ->whereBetween('packing_consumptions.date', [$fdate, $tdate])
                        ->groupby('packing_consumptions.bag_id')
                        ->get();
                @endphp
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-fixed"
                        style="font-size: 13px;table-layout: inherit;">
                        <thead>
                            <tr style="background:#FA621C; color:#f5f5f5;">
                                <th>Sl</th>
                                <th>Item Name</th>
                                <th>Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salesDatas as $key => $val)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $val->name }}</td>
                                    <td>{{ $val->rate }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{--  <div class="modal-footer float-right ">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    </div> --}}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection

@push('end_js')
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
        $(function() {
            $("#btnExport").click(function() {
                $("#reporttable").table2excel({
                    filename: "Income_statement.xls"
                });
            });
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $('#rmConsumption').on('show.bs.modal', function(event) {
            //console.log('hello test');
            var button = $(event.relatedTarget)
            var modal = $(this)
            //modal.find('.modal-body #minvoice').val(id);
        });

        $('#packingConsumption').on('show.bs.modal', function(event) {
            //console.log('hello test');
            var button = $(event.relatedTarget)
            var modal = $(this)
            //modal.find('.modal-body #minvoice').val(id);
        });

        let getDiv = $('.insertAfter').html();
        getDiv = '<div class="py-4 col-md-12 table-responsive">'+getDiv+'</div>';
        $(getDiv).insertAfter($('#insertAfter'));
        $('.insertAfter').addClass('d-none');
    </script>
@endpush
