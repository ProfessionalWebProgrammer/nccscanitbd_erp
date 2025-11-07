@extends('layouts.account_dashboard')

@push('addcss')
    <style>
        .text_sale {
            color: #f7ee79;
        }

        .text_credit {
            color: lime;
        }

        .comparedPLStatement .table thead tr th{
            background: #f8f9fa !important;
            color:#111;
        }

    </style>
@endpush

@section('print_menu')

			<li class="nav-item">

                </li>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      {{--	<button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                           Export
                        </button> --}}
                        <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn">
                           Print
                        </button>
                    </div>
                </div>

            <div class="container-fluid" id="contentbody" >


               <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Compared PL Statement</h5>
                      {{--  <p>From {{date('d m, Y',strtotime($fdate))}} to {{date('d m, Y',strtotime($tdate))}}</p> --}}

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                      <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
              <div class="row py-4">
                @php  $i = 0; @endphp
								@foreach($information as $key => $value)
								<div class="@if($i == 0) col-md-4 @else col-md-2 @endif table-responsive comparedPLStatement" style="@if($i == 0) width:66%; @else width:34%; @endif">
                    @php
                          $totalFC = 0;
                          $totalCost = 0;
                      @endphp

                      @foreach ($value['expenseData'] as $key => $val)
                        @if($val['id'] == 21 || $val['id'] == 56 || $val['id'] == 9)
                        @php
                            $totalFC += $val['debit'];
                        @endphp
                        @endif
                      @endforeach

                      @php
                        $totalCost = $value['costData'] + $totalFC;
                      @endphp


                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size:12px; table-layout: inherit;">
                            <thead>
															<tr>
                                @if($i == 0)
    														<th colspan="2" style="text-align:center;"> Assets - The Month of {{ $value['month']}}</th>
                                @else
                                <th colspan="1" style="text-align:center;"> The Month of {{ $value['month']}}</th>
                                @endif
															</tr>
                                <tr class="text-center">

                                    @if($i == 0)
                                      <th width="60%" >Particular </th>
                                      @else

                                      @endif
                                      <th  width="40%" style="text-align: right;">Amount (BDT)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp

                                <tr>
                                    @php
                                        $total += $value['salesRevenue'];
                                    @endphp
                                    @if($i == 0)
                                    <td style="font-weight:600;">Sales Revenues</td>
                                    @else

                                    @endif
                                    <td align="right">{{ number_format($value['salesRevenue'], 2) }}</td>
                                </tr>

                                <tr>
                                    @php
                                        $total -= $totalCost;

                                    @endphp
                                    @if($i == 0)
                                    <td>C.O.G.S (Direct Operating Cost) </td>
                                    @else

                                    @endif
                                    <td align="right">{{ number_format($totalCost, 2) }} </td>

                                </tr>
                            {{--   @if($data['sales'] > 0) --}}
                                <tr style="font-weight: bold">
                                  @if($i == 0)
                                    <td>Gross profit</td>
                                    @else

                                    @endif
                                    <td align="right">{{ number_format($total, 2) }} @if($total != 0)({{  number_format(($total/$value['salesRevenue'])*100,2) }}%) @endif</td>

                                </tr>
															{{-- 	@endif --}}
                                @if ($value['expenseData'])

                                <tr style="font-weight: bold;">
                                    <td colspan="100%">Operating Expanse</td>

                                </tr>

                               @php
                                $expansetotal = 0;
                                @endphp

                                @foreach ($value['expenseData'] as $key => $val)
                                  @if($val['id'] != 8  && $val['id'] != 9 && $val['id'] != 10 && $val['id'] != 18 && $val['id'] != 21 && $val['id'] != 56 && $val['id'] != 60 &&  $val['debit'] != 0)
                                  @php
                                      $total -= $val['debit'];
                                      $expansetotal += $val['debit'];
                                  @endphp
                                  <tr>
                                    @if($i == 0)
                                      <td class="pl-3">{{$val['title']}}</td>
                                      @else

                                      @endif
                                      <td align="right">{{  number_format($val['debit'], 2) }}</td>
                                  </tr>
                                  @endif
                                @endforeach
                                @php
                                $expansetotal += $value['data']['depreciationAmounts'];
                                @endphp
                              {{--  @php
                                $expansetotal = 0;
                                @endphp


                                @foreach ($value['expenseData'] as $key => $val)

                                  @if($val['id'] != 8  && $val['id'] != 10 && $val['id'] != 18 && $val['id'] != 21 && $val['id'] != 56 && $val['id'] != 60 && $val['debit'] != 0)
                                  @php
                                      $total -= $val['debit'];
                                      $expansetotal += $val['debit'];
                                  @endphp
                                  <tr>
                                      <td class="pl-5">{{$val['title']}}</td>
                                      <td align="right">{{  number_format($val['debit'], 2) }}</td>
                                  </tr>
                                  @endif
                                @endforeach  --}}

                              		    @php
                                            $total -= $value['data']['depreciationAmounts'];
                                        @endphp
                              <tr style="font-weight:bold">
                                @if($i == 0)
                                 <td>Depreciation Amount </td>
                                 @else

                                 @endif
                                 <td align="right">{{ number_format($value['data']['depreciationAmounts'], 2) ?? 0 }}</td>
                               </tr>

                                <tr style="font-weight:bold">
                                  @if($i == 0)
                                   <td>Total Operating  Expanse</td>
                                   @else

                                   @endif
                                    <td align="right">{{number_format(($expansetotal), 2)}}</td>
                                </tr>

                                  <tr style="font-weight: bold;">
                                    @if($i == 0)
                                    <td>Total Operating Profit</td>
                                    @else

                                    @endif
                                    <td align="right">{{ number_format($total, 2)}}</td>
                                	</tr>

                                 @endif


                                <tr style="font-weight: bold;">

                                    <td colspan="100%">Others Income</td>


                                </tr>

	                              @php
	                              $total += $value['othersIncome'];
	                              @endphp
                              {{--  @foreach ($value['allincome'] as $key=>$item)
									                       @if($item->incomeamount > 0)
                                          <tr>
                                              @php
                                                  $total += $item->incomeamount;
                                                  $incometotal += $item->incomeamount;
                                              @endphp
                                              <td class="pl-3">{{$item->name}}</td>
                                              <td align="right">{{  number_format($item->incomeamount, 2) }}</td>

                                          </tr>
                                          @endif
                                @endforeach --}}

								                <tr style="font-weight: bold">
                                  @if($i == 0)
                                    <td>Total Others Income</td>
                                    @else

                                    @endif
                                    <td align="right">{{ number_format($value['othersIncome'], 2) }}</td>
                                </tr>



                                <tr style="font-weight: bold">
                                   {{-- <td>Total Operating Profit (Before Financial Expense & Tax)</td> --}}
                                   @if($i == 0)
                                    <td>Total Operating Profit (Before Financial Expense)</td>
                                    @else

                                    @endif
                                    <td align="right">{{ number_format($total, 2) }}</td>
                                </tr>

                                <tr style="font-weight: bold;">

                                  <td colspan="100%">Financial Expense</td>

                                </tr>
                              @php
                              $total_f_exp = 0;
                              @endphp
                              @foreach ($value['expenseData'] as $key=>$item)
                                 @if($item['id'] == 10)
                                     @php
                                         $total -= $item['debit'];
                                         $total_f_exp += $item['debit'];
                                     @endphp
                                     <tr>
                                       @if($i == 0)
                                         <td class="pl-3 text-capitalize">{{$item['title']}}</td>
                                         @else

                                         @endif
                                         <td align="right">{{  number_format($item['debit'], 2) }}</td>
                                     </tr>
                                 @endif
                              @endforeach

                                <tr style="font-weight: bold">
                                  @if($i == 0)
                                    <td>Total Operating Profit (After Financial Expense)</td>
                                    @else

                                    @endif
                                    <td align="right">{{ number_format($total, 2) }}</td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr style="font-weight:bold">
                                  @if($i == 0)
                                    <th>Net Profit </th>
                                   {{-- <td align="right">{{ number_format(($total/100)*(100-$taxes), 2) }}</td> --}}
                                   @else

                                   @endif
                                    <td align="right">{{ number_format($total, 2) }}</td>
                                </tr>

                            </tfoot>

                        </table>
                    </div>
                    @php
                    $i = 1;
                    @endphp
										@endforeach
                </div>
            </div>
        </div>
    </div>

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
    $(function () {
        $("#btnExport").click(function () {
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

</script>


@endpush
