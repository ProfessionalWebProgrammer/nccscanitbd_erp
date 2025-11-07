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
    <div class="content-wrapper" >
        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                        <a href="{{route('pl.analytical.report.threat-detection.view')}}" class="btn btn-sm  btn-danger mt-1"  >
                           Threat Comparison
                        </a>
                      	<button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                           Export
                        </button>
                        <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn">
                           Print
                        </button>
                    </div>
                </div>

            <div class="container-fluid" id="contentbody" >
               <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">PL Analytical Report</h5>
                      <p>From {{date('d m, Y',strtotime($fdate))}} to {{date('d m, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                      <p>Head office, Rajshahi, Bangladesh</p>
                     <h4 class="mt-3">Select Month for Comparison Analysis </h4>
                    </div>
                </div>
              <div class="row py-4">
                <div class="col-md-6">
                	<form action="{{ route('pl.analytical.report.view') }}" method="GET">
                        <div class="row pb-2">
                            <div class="col-md-12 input-group rounded">

                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Date</span>
                                </div>
                                <input type="text" name="date" class="form-control float-right" id="daterangepicker"value="" style="border-radius:0px;">


                                <div class="input-group-prepend pr-2">
                                    <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-search"></i>
                                        Search</button>
                                </div>

                                {{-- <div class="input-group-prepend pr-2">
                                    <a href="{{ route('sales.order.index') }}" class="btn btn-sm btn-danger"><i
                                            class="far fa-times-circle"></i>
                                        Clear</a>
                                </div> --}}

                            </div>

                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                	<form action="{{ route('pl.analytical.report.monthWise.view') }}" method="GET">
                        <div class="row pb-2">
                            <div class="col-md-12 input-group rounded">

                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Month</span>
                                </div>
                                 <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true"  data-actions-box="true" multiple name="months[]">
                                    <option value="">Select Months</option>
                                    <option style="color: #FF0000; font-weight:bold" value="01">January  </option>
                                   	<option style="color: #FF0000; font-weight:bold" value="02">February </option>
                                    <option style="color: #FF0000; font-weight:bold" value="03">March </option>
                                    <option style="color: #FF0000; font-weight:bold" value="04">April </option>
                                   <option style="color: #FF0000; font-weight:bold" value="05"> May</option>
                                   <option style="color: #FF0000; font-weight:bold" value="06">June </option>
                                   <option style="color: #FF0000; font-weight:bold" value="07">July</option>
                                   	<option style="color: #FF0000; font-weight:bold" value="08">August </option>
                                    <option style="color: #FF0000; font-weight:bold" value="09">September </option>
                                    <option style="color: #FF0000; font-weight:bold" value="10">October  </option>
                                   <option style="color: #FF0000; font-weight:bold" value="11">November</option>
                                   <option style="color: #FF0000; font-weight:bold" value="12">December </option>
                                </select>

                                <div class="input-group-prepend pr-2">
                                    <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-search"></i>
                                        Search</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                    <div class="py-4 col-md-6 table-responsive">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 6;table-layout: inherit;">
                            <thead>
                              <tr>
                                <th colspan="3">Gross Profit & Net Profit</th>
                                </tr>
                          </thead>
                          <tbody>
                            <tr class="text-center">
                                    <th>Gross profit (BDT)</th>
                                    <th>Net Profit (BDT)</th>
                              		<th>Difference (BDT)</th>
                            </tr>
                            <tr>
                               <td align="center">{{number_format($grossProfit, 2)}} - ({{$grossProfitPercent}}%)</td>
                               <td align="center">{{number_format($netProfit, 2)}}</td>
                              <td align="center">{{number_format($grossProfit - $netProfit, 2)}}</td>
                            </tr>
                            </tbody>
                    </table>
                    </div>
                
                    <div class="py-4 col-md-6 table-responsive">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed table-hover"
                            style="font-size: 6;table-layout: inherit;">
                            <thead>
                               <tr style="font-weight: bold;color:blue">
                                    <td colspan="2">Expanse Details</td>
                                </tr> 
                               
                            </thead>
                            <tbody>
                                 <tr class="text-center">
                                    <th>Head </th>
                                    <th>Amount (BDT)</th>

                                </tr> 
                           @php 
                            $totalAmount = 0;
                            @endphp 
                            @foreach($allexpasne as $data)
                            @php 
                            	$totalAmount += $data->expamount;
                            @endphp 
                            <tr> 
                               <td align="left">{{$data->group_name}}</td>
                              <td align="center">{{number_format($data->expamount,2)}}</td>
                            </tr>
                            @endforeach
                            </tbody>
                          	<tfoot>
                                <tr style="background-color:#FA621C; color:#f5f5f5; font-weight:700; font-size:18px;">
                                    <th class="pl-3">Total Operating  Expanse: </th>
                                    <td align="center">{{ number_format($totalAmount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
              </div>
					<div class="row">
                    <div class="py-4 col-md-6 table-responsive">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 6;table-layout: inherit;">
                            <thead>
                              <tr>
                                <th colspan="2">All Expense Ledger Details</th>
                                </tr>
                          </thead>
                          <tbody>
                            <tr class="text-center">
                                    <th>Head</th>
                                    <th>Amount (BDT)</th>
                            </tr>
                            @php 
                            $totalAmount = 0;
                            @endphp 
                            @foreach($allexpasne as $data)
                            @php 
                            	$totalAmount += $data->expamount;
                            	$subExpenseLedgers =  DB::table('payments')->select([DB::raw("SUM(amount) amount"),'expanse_subgroups.subgroup_name'])
                             	->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
                            	->where('expanse_type_id',$data->id)->where('payment_type', 'EXPANSE')
                        		->whereBetween('payment_date', [$fdate, $tdate])->where('status', 1)->groupby('payments.expanse_subgroup_id')->orderby('payments.amount','DESC')->get();
                           		$subTotalAmount = 0;
                            @endphp 
                            {{-- 
                            	$subExpenseLedgers =  DB::table('payments')
                             	->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
                            	->where('expanse_type_id',19)->where('payment_type', 'EXPANSE')
                        		->whereBetween('payment_date', [$fdate, $tdate])->where('status', 1)->max('amount');
                            --}}
                            <tr> 
                               <td align="left" colspan="2"><b>{{$data->group_name}}</b></td>
                              
                            </tr>
                             	@foreach($subExpenseLedgers as $key => $val)
                                  @php 
                                      $subTotalAmount += $val->amount;
                                  @endphp 
                                  <tr style="color:
                                               @if($key == 0) #ff0000; 
                                               @elseif($key == 1) #ffdd00;  
                                               @elseif($key == 2) #371777;
                                               @elseif($key == 3) #da1884;
                                               @elseif($key == 4) #52325d;
                                               @elseif($key == 5) #d7d700;
                                               @else green;
                                               @endif"> 
                                     <td align="left">{{$val->subgroup_name}} </td>
                                    <td align="center">
                                      {{number_format($val->amount,2)}}
                                    </td>
                                  </tr> 
                            	@endforeach
                            	<tr style="background-color:#3ab0bd; color:#000; font-weight:700; font-size:17px;">
                                    <th class="pl-3">Sub Total Operating  Expanse: </th>
                                    <td align="center">{{ number_format($subTotalAmount, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                          	<tfoot>
                                <tr style="background-color:#FA621C; color:#f5f5f5; font-weight:700; font-size:20px;">
                                    <th class="pl-3">Grand Total Operating  Expanse: </th>
                                    <td align="center">{{ number_format($totalAmount, 2) }}</td>
                                </tr>

                            </tfoot>
                    </table>
                    </div>
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
</script>

@endpush
