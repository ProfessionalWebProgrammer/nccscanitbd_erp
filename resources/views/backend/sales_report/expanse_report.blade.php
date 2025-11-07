@extends('layouts.account_dashboard')

@section('print_menu')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row pt-2">
                  	<div class="col-md-12 text-right">
                         <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                           Export
                        </button>
                        <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                           Print
                        </button>
                    </div>
                </div>
            <div class="container-fluid"  id="contentbody">

               <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Expense @if($exp_subgroup) Ledger @else Sub Ledger @endif Report</h5>
                      <p>From {{date('d m, Y',strtotime($fdate))}} to {{date('d m, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>

                <div class="py-4">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead style="font-size: 18px;">
                            <tr class="text-center">
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>@if($exp_subgroup)Ledger/Bank/Cash @else Ledger @endif</th>
                                @if($exp_subgroup)  <th>Sub Ledger</th> @else   @endif
                                <th class="text-right">Debit</th>
                                <th class="text-right">Credit</th>
                                <th class="text-right">Balance</th>
                            </tr>
                        </thead>
                        @if($exp_subgroup)
                        @php
                            $balance = 0;
                            $TotalDebit = 0;
                            $TotalCredit = 0;
                            $subTotalBankReceivedCredit = 0;
                            $jarCr = 0;
                        @endphp
                        <tbody>
                          @foreach ($exp_subgroup as $key => $id)
                          @php
                          $subTotalDebit = 0;
                          $subTotalCredit = 0;
                            $oBalance = \App\Models\ExpanseSubgroup::where('id',$id)->first();

                            $payments = \App\Models\Payment::where('expanse_subgroup_id',$id)
                                        ->whereBetween('payment_date',[$fdate, $tdate])->where('status',1)->get();
                            $prePayment = \App\Models\Payment::where('expanse_subgroup_id',$id)
                                        ->whereBetween('payment_date',[$startDate, $predate])->where('status',1)->sum('amount');
                            

                            $chartOfLedger = \App\Models\Account\SubSubAccount::where('title',$oBalance->subgroup_name)->value('id');

                            if($chartOfLedger){
                              $journalDetails = \App\Models\Account\ChartOfAccounts::where('ac_sub_sub_account_id',$chartOfLedger)->where('invoice','LIKE','Jar-%')->whereBetween('date',[$fdate,$tdate])->get();
                              $journalPreData = \App\Models\Account\ChartOfAccounts::select(DB::raw('SUM(debit) as debit'),DB::raw('SUM(credit) as credit'))->where('ac_sub_sub_account_id',$chartOfLedger)->where('invoice','LIKE','Jar-%')->whereBetween('date',[$startDate,$predate])->first();
                            }else{
                              $chartOfLedgerId = \App\Models\Account\IndividualAccount::where('title',$oBalance->subgroup_name)->value('id');
                              $journalDetails = \App\Models\Account\ChartOfAccounts::where('ac_individual_account_id',$chartOfLedgerId)->where('invoice','LIKE','Jar-%')->whereBetween('date',[$fdate,$tdate])->get();
                              $journalPreData = \App\Models\Account\ChartOfAccounts::select(DB::raw('SUM(debit) as debit'),DB::raw('SUM(credit) as credit'))->where('ac_individual_account_id',$chartOfLedgerId)->where('invoice','LIKE','Jar-%')->whereBetween('date',[$startDate,$predate])->first();
                            }


                              if($journalPreData){
                                $preDebit = $journalPreData->debit ?? 0;
                                $preCredit = $journalPreData->credit ?? 0;
                              }  else {
                                $preDebit = 0;
                                $preCredit =  0;
                              }


                            $OpenigValue = $oBalance->balance ?? 0;
                            if($fdate == '2023-10-01'){
                                $openingBalance = $OpenigValue;
                            } else {
                            if($preCredit != 0 ){
                                $openingBalance = $OpenigValue + $prePayment - $preCredit;
                            } else {
                             $openingBalance = $OpenigValue + $prePayment + $preDebit;
                            }
                            }

                            $ledger = $oBalance->subgroup_name ?? '';
                            $balance += $openingBalance;

                            if($openingBalance > 0 ){
                              $subTotalDebit += $openingBalance;
                              $TotalDebit += $openingBalance;
                            } else {
                              $subTotalCredit += abs($openingBalance);
                              $TotalCredit += abs($openingBalance);
                            }
                            
                          @endphp
                          <tr>
                            <td colspan="4" class="text-left">{{$ledger}}  ( Opening Balance )</td>
                            @if($openingBalance > 0)
                            <td class="text-right">{{ number_format($openingBalance,2) }}</td>
                            <td></td>
                            @else
                            <td></td>
                           <td class="text-right">{{ number_format(abs($openingBalance),2) }}</td>
                            @endif
                            <td class="text-right">{{ number_format($balance,2) }}</td>
                          </tr>
                          
                          {{--<pre>
                              {{print_r($payments)}}
                          </pre>--}}
                          @foreach ($payments as $key => $val)
                          @php
                          
                              if($val->payment_type == 'EXPANSE')
                              {
                                $balance -= $val->amount;
                              }
                            
                            
                            $subTotalDebit += $val->amount;
                            $TotalDebit += $val->amount;
                            if($val->payment_type == 'RECEIVE')
                            {
                                
                                $subTotalDebit -= $val->amount;
                                $TotalDebit -= $val->amount;
                                $subTotalBankReceivedCredit += $val->amount;
                                $subTotalCredit +=$subTotalBankReceivedCredit;
                                $TotalCredit +=$subTotalBankReceivedCredit;
                                $balance += $val->amount;
                                
                            }
                            
                          @endphp
                          <tr>
                            <td>{{date('d M, Y',strtotime($val->payment_date))}}</td>
                            <td>{{$val->invoice}}</td>
                            <td>{{$val->bank_name ?? $val->wirehouse_name}}</td>
                            <td>
                                @if(!empty($exp_sub_subgroup))
                                    {{DB::table('expanse_sub_subgroups')->whereIn('id', $exp_sub_subgroup)->where('subgroup_id', $val->expanse_subgroup_id)->first()->subSubgroup_name}}
                                @endif
                            </td>
                            <td class="text-right">
                                @if($val->payment_type == 'EXPANSE')
                                    {{number_format($val->amount,2)}}
                                 @endif
                            </td>
                             <td class="text-right">
                                 @if($val->payment_type == 'RECEIVE')
                                    {{number_format($val->amount,2)}}
                                 @endif
                            </td>
                             <td class="text-right">{{number_format($balance,2)}}</td>
                          </tr>
                          @endforeach  {{--  Payment end  --}}

                          @foreach ($journalDetails as $key => $val)
                          @php
                          if($val->credit > 0){
                             $balance += $val->credit;
                             $subTotalCredit += $val->credit;
                             $TotalCredit += $val->credit;
                          } else {
                            $balance += $val->debit;
                            $subTotalDebit += $val->debit;
                            $TotalDebit += $val->debit;
                          }
                          @endphp
                          <tr>
                            <td>{{date('d M, Y',strtotime($val->date))}}</td>
                            <td>{{$val->invoice}}</td>
                            <td colspan="2">{{$val->acSubSubAccount->title;}}</td>
                              @if($val->credit > 0)
                            <td class="text-right"></td>
                            <td class="text-right">{{number_format($val->credit ?? 0,2)}}</td>
                            @elseif($val->debit < 0)
                            <td class="text-right"></td>
                            <td class="text-right">{{number_format(abs($val->debit) ?? 0,2)}}</td>
                            @else 
                            <td class="text-right">{{number_format($val->debit ?? 0,2)}}</td>
                            <td class="text-right"></td>
                            @endif
                            <td class="text-right">{{number_format($balance,2)}}</td>
                          </tr>
                          @endforeach {{--  Journal end  --}}

                          <tr style="background: #7cb7ee;">
                            <td colspan="4">Sub Total: </td>
                            <td class="text-right">{{number_format($subTotalDebit,2)}}</td>
                            <td class="text-right">{{number_format($subTotalCredit,2)}}</td>
                            <td class="text-right">{{number_format($balance,2)}}</td>
                          </tr>
                          @endforeach {{-- Ledger end  --}}
                        </tbody>
                        <tfoot>
                          <tr style="background: #e1936e;">
                            <td colspan="4">Grand Total: </td>
                            <td class="text-right">{{number_format($TotalDebit,2)}}</td>
                            <td class="text-right">{{number_format($TotalCredit,2)}}</td>
                           <td class="text-right">{{number_format($balance,2)}}</td>
                          </tr>
                        </tfoot>

                        @else
                          @php
                          $balance = 0;
                          $TotalDebit = 0;

                          @endphp
                        <tbody>
                          @foreach($exp_sub_subgroup as $key => $id)
                          @php
                          $subTotalDebit = 0;

                            $oBalance = DB::table('expanse_sub_subgroups')->where('id',$id)->first();



                            $journals = \App\Models\JournalEntry::select('journal_entries.*','e.subgroup_name as ledger','e.subSubgroup_name as name')
                                        ->leftJoin('expanse_sub_subgroups as e', 'journal_entries.sub_ledger_id','=','e.id')
                                        ->where('sub_ledger_id',$id)
                                        ->whereBetween('date',[$fdate, $tdate])->get();

                            $preDebit = \App\Models\JournalEntry::leftJoin('expanse_sub_subgroups as e', 'journal_entries.sub_ledger_id','=','e.id')
                                        ->where('sub_ledger_id',$id)
                                        ->whereBetween('date',[$startDate, $predate])->sum('credit');

                            //$openingBalance = $oBalance->balance;
                            $openingBalance = $preDebit;
                            $ledger = $oBalance->subSubgroup_name;
                            $balance += $openingBalance;


                              $subTotalDebit += $openingBalance;
                              $TotalDebit += $openingBalance;
                              $count = 0;
                          @endphp
                          <tr>
                            <td colspan="3" class="text-left">{{$ledger}}  Opening Balance</td>

                            <td class="text-right">{{ number_format($openingBalance,2) }}</td>
                            <td></td>
                           <td class="text-right">{{ number_format($balance,2) }}</td>
                          </tr>
                          @foreach ($journals as $key => $val)
                          @php
                            $balance += $val->credit;
                            $subTotalDebit += $val->credit;
                            $TotalDebit += $val->credit;
                            ++$count;
                          @endphp
                          <tr>
                            <td>{{date('d M, Y',strtotime($val->date))}}</td>
                            <td>{{$val->invoice}}</td>

                            <td >{{$val->ledger}}</td>
                            <td class="text-right">{{number_format($val->credit,2)}}</td>
                            <td class="text-right"></td>
                            <td class="text-right">{{number_format($balance,2)}}</td>
                          </tr>
                          @endforeach {{--  Journal end  --}}
                          <tr style="background: #7cb7ee;">
                            <td colspan="3">Sub Total: </td>
                            <td class="text-right">{{number_format($subTotalDebit,2)}}</td>
                            <td class="text-right"></td>
                           <td class="text-right">{{number_format($balance,2)}}</td>
                          </tr>

                            @endforeach {{-- Sub-Ledger end  --}}
                        </tbody>
                        <tfoot>
                          <tr style="background: #e1936e;">
                            <td colspan="3">Grand Total: </td>
                            <td class="text-right">{{number_format($TotalDebit,2)}}</td>
                            <td class="text-right"></td>
                            <td class="text-right">{{number_format($balance,2)}}</td>
                          </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
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
            $("#reporttable").table2excel({
                filename: "ExpanseReport.xls"
            });
        });
    });
</script>
@endsection
