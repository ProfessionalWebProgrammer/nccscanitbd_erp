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
                      <h5 class="text-uppercase font-weight-bold">PL Threat Comparison Analytical Report</h5>
                      

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                      <p>Head office, Rajshahi, Bangladesh</p>
                      <h4 class="mt-3">For Threat Comparison Analytical Report </h4>
                    </div>
                </div>
              <div class="row py-4">
                <div class="col-md-4">
                <!--  <a href="{{route('monthly-threat-detection')}}" class="btn btn-success">Threat Detection</a>-->
                </div>
                
                <div class="col-md-4">
                	<form action="{{ route('monthly-threat-detection') }}" method="GET">
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
                 <div class="col-md-4">
                </div>
                @if(@$information)
                @foreach ($information as $data)
                    <div class="py-4 col-md-4 table-responsive">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 16px;table-layout: inherit;">
                            <thead>
                              <tr>
                                <th colspan="3">Gross Profit & Net Profit <span style="color:#000080;">({{$data['month']}})</span></th>
                                </tr>
                          </thead>
                          <tbody>
                            <tr class="text-center">
                                    <th>Gross profit (BDT)</th>
                                    <th>Net Profit (BDT)</th>
                              		<th>Difference (BDT)</th>
                            </tr>
                            <tr class="text-center">
                                    <th>{{number_format($data['grossProfit'], 2)}} - ({{$data['grossProfitPercent']}}%)</th>
                                    <th>{{number_format($data['netProfit'], 2)}}</th>
                              		<th>{{number_format($data['differenceGrossAndNet'], 2)}}</th>
                            </tr>
                          
                            </tbody>
                          
                    </table>
                    </div>
                @endforeach 
               
                @foreach ($information as $data)
                    <div class="py-4 col-md-4 table-responsive">  
                        <table id="reporttable" class="table table-bordered table-striped table-fixed table-hover"
                            style="font-size: 6;table-layout: inherit;">
                            <thead>
                              <tr style="font-weight: bold;color:blue">
                                    <td colspan="2">Expanse Ledger and Subledger Details <span style="color:#000080;">({{$data['month']}})</span></td>
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
                            @foreach($data['allexpasne'] as $expasne)
                            @php 
                            	$totalAmount += $expasne->expamount;
                            	$subExpenseLedgers =  DB::table('payments')->select([DB::raw("SUM(amount) amount"),'expanse_subgroups.subgroup_name'])
                                                     ->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
                                                     ->where('expanse_type_id',$expasne->id)->where('payment_type', 'EXPANSE')
                                                     ->whereYear('payment_date', date('Y'))
                                                     ->whereMonth('payment_date',$data['month_no'])
                                                     ->where('status', 1)->groupby('payments.expanse_subgroup_id')->orderby('payments.amount','DESC')->get();
                            @endphp 
                            <tr style="background:#3ab0bd"> 
                               <td align="left">{{$expasne->group_name}}</td>
                              <td align="center">{{number_format($expasne->expamount,2)}}</td>
                            </tr>
                             @foreach($subExpenseLedgers as $key =>$subExpenseLedger)
                            
                             @php
                               if(@$ledgerMonths){
                                   $subLedgerName = $subExpenseLedger->subgroup_name;
                                   $monthsCount = count($ledgerMonths[$subLedgerName]);
                                   $background = ($monthsCount > 1) ? 'red' : 'green';
                                   $color = 'white';
                               }
                             @endphp
                             <tr style="background:{{(@$ledgerMonths) ? $background : ''}};color:{{(@$ledgerMonths) ? $color : ($key == 0 ? '#ff0000' : ($key == 1 ? '#ffdd00' :($key == 2 ? '#371777' : ($key == 3 ? '#da1884' :($key == 4 ? '#52325d' :($key == 5 ? '#d7d700' : 'green'))))))}}"> 
                               <td align="left">{{$subExpenseLedger->subgroup_name}} </td>
                               <td align="center">
                                 {{number_format($subExpenseLedger->amount,2)}}
                               </td>
                             </tr> 
                               @endforeach
                             
                            @endforeach
                            </tbody>
                          	<tfoot>
                                <tr style="background-color:#F5B041; color:#000; font-weight:700; font-size:18px;">
                                    <th class="pl-3">Total Operating  Expanse: </th>
                                    <td align="center">{{ number_format($totalAmount, 2) }}</td>
                                </tr>
                            </tfoot>
                         
                        </table>
                    </div>
                @endforeach
                @endif
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
