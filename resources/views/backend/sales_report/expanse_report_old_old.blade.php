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
                      <h5 class="text-uppercase font-weight-bold">Expense Report</h5>
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
                                <th>SI</th>
                                <th>Date</th>
                                {{-- <th>Group</th> --}}
                                <th>Ledger</th>
                                <th>Sub Ledger</th>
                                <th>Invoice</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>

                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $total_exp = 0;
                                $total_cre = 0;
                                $balance = 0; 
                                $totalCredit = 0; 
                            @endphp
                            
                            @foreach ($expanse_group as $data)

                                <tr>
                                    <th style="background: rgba(222, 184, 135, 0.342);" colspan="100%">@if(!empty($data->group_name)){{ $data->group_name }} @else Others Expense @endif </th>
                                </tr>
                                 
                                @php
                                 
                                    $subtotal_exp = 0;
                                    $subtotal_cre = 0;
                                    $subTotalCredit = 0; 
                                    

                                    if ($exp_subgroup) {
                                        $expanse_data = DB::table('payments as t1')
                                            ->select('t1.*', 't2.subgroup_name','t2.group_name','t3.subSubgroup_name')
                                            ->leftJoin('expanse_subgroups as t2', 't1.expanse_subgroup_id', '=', 't2.id')
                                            ->leftJoin('expanse_sub_subgroups as t3', 't1.expanse_subSubgroup_id', '=', 't3.id')
                                            ->whereNotNull('expanse_subgroup_id')
                                            ->where('t2.group_id', $data->group_id)
                                            ->where('status', 1)
                                            ->whereBetween('payment_date', [$fdate, $tdate])
                                            ->whereIn('expanse_subgroup_id', $exp_subgroup)->orderby('payment_date', 'desc')
                                            ->get();
                                    } else {
                                        $expanse_data = DB::table('payments as t1')
                                                ->select('t1.*', 't2.subgroup_name','t2.group_name','t3.subSubgroup_name')
                                                ->leftJoin('expanse_subgroups as t2', 't1.expanse_subgroup_id', '=', 't2.id')
                                                ->leftJoin('expanse_sub_subgroups as t3', 't1.expanse_subSubgroup_id', '=', 't3.id')
                                                ->whereNotNull('expanse_subgroup_id')
                                                ->where('t2.group_id', $data->group_id)
                                                ->where('status', 1)
                                                ->whereBetween('payment_date', [$fdate, $tdate])->orderby('payment_date', 'desc')
                                                ->get();
                                    }
                                    

                                @endphp
                                @if(count($expanse_data) > 0)
                                @foreach ($expanse_data as $exp)
                                    @php
                                        $total_exp += $exp->amount;
                                        $subtotal_exp += $exp->amount;
                                        $balance += $exp->amount;
                                       
                                        
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $exp->payment_date }}</td>
                                        <td>{{ $exp->subgroup_name }}</td>
                                        <td>{{ $exp->subSubgroup_name ?? '' }}</td>
                                        <td>{{ $exp->invoice }}</td>
                                        <td>{{ number_format($exp->amount, 2)}}</td>
                                        <td></td>
                                        <td>{{ number_format($balance, 2)}}</td>
                                    </tr>
                                 @endforeach
                                    @php 
                                     $dataRent = App\Models\JournalEntry::select(
                                                    'journal_entries.date',
                                                    'journal_entries.invoice',
                                                    'journal_entries.dc_type',
                                                    'journal_entries.debit',
                                                    'journal_entries.credit',
                                                    'journal_entries.sub_ledger_id',
                                                    'e.group_name',
                                                    'e.subgroup_name')
                                                   ->leftjoin('expanse_subgroups as e','journal_entries.ledger_id','=','e.id')
                                                   ->wherein('journal_entries.ledger_id',$exp_subgroup)->where('journal_entries.type','Rent')
                                                   ->whereBetween('journal_entries.date', [$fdate, $tdate])->get();
                                    @endphp 
                                    @if(!empty($dataRent))
                                     @foreach($dataRent as $data)
                                    @if($data->dc_type == 6)
                                        @php 
                                        
                                        if(!empty($data->sub_ledger_id)){
                                                        $subLedger = DB::table('expanse_sub_subgroups')->where('id',$data->sub_ledger_id)->value('subSubgroup_name');
                                                    } else {
                                                        $subLedger = ''; 
                                                    }
                                                    
                                        $balance += $data->debit ?? 0;
                                        $subtotal_exp += $data->debit ?? 0;
                                        $total_exp += $data->debit ?? 0; 
                                        @endphp 
                                    <tr>
                                        <td></td>
                                        <td>{{ $data->date }}</td>
                                        <td>{{ $data->subgroup_name }}</td>
                                        <td>{{ $subLedger }}</td>
                                        <td>{{ $data->invoice }}</td>
                                        <td>{{ number_format($data->debit, 2)}}</td>
                                        <td></td>
                                        <td>{{ number_format($balance, 2)}}</td>
                                    </tr>
                                    
                                    
                                    @else 
                                        @php 
                                        $balance -= $data->credit ?? 0;
                                        $subTotalCredit += $data->credit ?? 0;
                                        $totalCredit += $data->credit ?? 0;
                                        @endphp
                                    <tr>
                                        <td></td>
                                        <td>{{ $data->date }}</td>
                                        <td>{{ $data->subgroup_name }} (Cr)</td>
                                        <td>{{ $subLedger }}</td>
                                        <td>{{ $data->invoice }}</td>
                                        <td></td>
                                        <td>{{ number_format($data->credit, 2)}}</td>
                                        <td>{{ number_format($balance, 2)}}</td>
                                    </tr>
                                        @endif
                                       @endforeach
                                    @endif
                                
                                
                                
                                @elseif(!empty($exp_subgroup)) 
                               
                                        @php
                                            $journalLedgers = App\Models\JournalEntry::select('journal_entries.*','e.subgroup_name')
                                                            ->leftjoin('expanse_subgroups as e','journal_entries.ledger_id','=','e.id')
                                                            ->whereIn('journal_entries.ledger_id',$exp_subgroup)->where('journal_entries.type', 'Rent')
                                                            ->whereBetween('journal_entries.date', [$fdate, $tdate])->get();
                                                  
                                         
                                        @endphp 
                                        
                                        @if(!empty($journalLedgers))
                                        @foreach($journalLedgers as $key => $dataRent)
                                        @php 
                                        $balance += $dataRent->debit ?? 0;
                                        $subtotal_exp += $dataRent->debit ?? 0;
                                        $total_exp += $dataRent->debit ?? 0; 
                                        
                                        if($dataRent->sub_ledger_id){
                                                        $subLedger = DB::table('expanse_sub_subgroups')->where('id',$dataRent->sub_ledger_id)->value('subSubgroup_name');
                                                    } else {
                                                        $subLedger = ''; 
                                                    } 
                                        @endphp 
                                            <tr>
                                                <td></td>
                                                <td>{{ $dataRent->date }}</td>
                                                <td>{{ $dataRent->subgroup_name }}</td>
                                                <td>{{$subLedger}}</td>
                                                <td>{{ $dataRent->invoice }} </td>
                                                <td>{{ number_format($dataRent->debit, 2)}}</td>
                                                <td></td>
                                                <td>{{ number_format($balance, 2)}}</td>
                                            </tr>
                                        @endforeach
                                      @endif
                                      
                                 @else  
                               
                               
                               @php 
                                 
                                 
                                $dataRent = App\Models\JournalEntry::select(
                                                    'journal_entries.date',
                                                    'journal_entries.dc_type',
                                                    'journal_entries.ledger_id',
                                                    'journal_entries.sub_ledger_id',
                                                    'journal_entries.invoice',
                                                    'journal_entries.input',
                                                    'journal_entries.debit',
                                                    'journal_entries.credit',
                                                    'e.*'
                                                )
                                                ->leftJoin('expanse_subgroups as e', 'journal_entries.ledger_id', '=', 'e.id')
                                                ->where('journal_entries.type', 'Rent')
                                                ->whereBetween('journal_entries.date', [$fdate, $tdate]);
                                            
                                            if (is_array($exp_sub_subgroup)) {
                                                $dataRent->whereIn('journal_entries.sub_ledger_id', $exp_sub_subgroup);
                                            }
                                            
                                            $dataRent = $dataRent->get(); 
                                              // dd($dataRent);     
                                            
                                        
                                    $expenseData = App\Models\Payment::select('payments.*','t3.group_name','t3.subgroup_name', 't3.subSubgroup_name')
                                            ->leftJoin('expanse_sub_subgroups as t3', 'payments.expanse_subSubgroup_id', '=', 't3.id')
                                            ->wherein('payments.expanse_subSubgroup_id', $exp_sub_subgroup)
                                            ->whereBetween('payments.payment_date', [$fdate, $tdate])
                                            ->orderby('payments.payment_date', 'desc')
                                            ->where('payments.status', 1)->get();
                                            
                                       //dump($expenseData);
                                @endphp 
                                @if(count($expenseData) > 0)
                                     @foreach($expenseData as $data)
                                        @php 
                                        $balance += $data->amount ?? 0;
                                        $subtotal_exp += $data->amount ?? 0;
                                        $total_exp += $data->amount ?? 0;
                                        @endphp 
                                    <tr>
                                        <td></td>
                                        <td>{{ $data->payment_date }}</td>
                                        
                                        <td>{{ $data->subgroup_name}}</td>
                                        <td>{{ $data->subSubgroup_name }}</td>
                                        <td>{{ $data->invoice }}</td>
                                        <td>{{ number_format($data->amount, 2)}}</td>
                                        <td></td>
                                        <td>{{ number_format($balance, 2)}}</td>
                                    </tr>
                                    @endforeach 
                                @endif 
                                
                                @if(count($dataRent) > 0)
                                @foreach($dataRent as $data)
                                @php 
                                if($data->sub_ledger_id){
                                                        $subLedger = DB::table('expanse_sub_subgroups')->where('id',$data->sub_ledger_id)->value('subSubgroup_name');
                                                    } else {
                                                        $subLedger = 0; 
                                                    }  
                                        if($data->ledger_id){
                                        $ledgerNasme = DB::table('expanse_subgroups')->where('id',$data->ledger_id)->value('subgroup_name');
                                        } else {
                                        $ledgerNasme = '';
                                        }
                                        
                                        @endphp 
                                        
                                @if(!empty($data->credit) || !empty($data->debit))
                                   @if($data->dc_type == 6)
                                       {{-- @php 
                                        $balance += $data->debit ?? 0;
                                        $subtotal_exp += $data->debit ?? 0;
                                        $total_exp += $data->debit ?? 0;
                                        @endphp 
                                    <tr>
                                        <td></td>
                                        <td>{{ $data->date }}</td>
                                        <td>{{ $data->group_name  }}</td>
                                        <td>{{ $data->subgroup_name }}</td>
                                        <td></td>
                                        <td>{{ $data->invoice }}</td>
                                        <td>{{ number_format($data->debit, 2)}}</td>
                                        <td></td>
                                        <td>{{ number_format($balance, 2)}}</td>
                                    </tr> --}}
                                       @php 
                                        $balance -= $data->credit ?? 0;
                                        $subTotalCredit += $data->credit ?? 0;
                                        $totalCredit += $data->credit ?? 0;
                                        @endphp
                                    <tr>
                                        <td></td>
                                        <td>{{ $data->date }}</td>
                                       {{-- <td>{{ $data->group_name  }}</td> --}}
                                        <td>{{$data->subgroup_name}} (Dr)</td>
                                        <td>{{ $subLedger }}</td>
                                        <td>{{ $data->invoice }}</td>
                                        <td></td>
                                        <td>{{ number_format($data->credit, 2)}}</td>
                                        <td>{{ number_format($balance, 2)}}</td>
                                    </tr> 
                                    @else 
                                        @php 
                                        $balance -= $data->credit ?? 0;
                                        $subTotalCredit += $data->credit ?? 0;
                                        $totalCredit += $data->credit ?? 0;
                                        @endphp
                                    <tr>
                                        <td></td>
                                        <td>{{ $data->date }}</td>
                                       {{-- <td>{{ $dataRent->group_name  }}</td> --}}
                                        <td>{{ $data->subgroup_name }} (Dr)</td>
                                       <td>{{ $subLedger }}</td>
                                        <td>{{ $data->invoice }}</td>
                                        <td></td>
                                        <td>{{ number_format($data->credit, 2)}}</td>
                                        <td>{{ number_format($balance, 2)}}</td>
                                    </tr>
                                    
                                        @php 
                                        $balance += $data->debit ?? 0;
                                        $subtotal_exp += $data->debit ?? 0;
                                        $total_exp += $data->debit ?? 0;
                                        @endphp 
                                    <tr>
                                        <td></td>
                                        <td>{{ $data->date }}</td>
                                        {{-- <td>{{ $dataRent->group_name  }}</td> --}}
                                        <td>{{ $data->subgroup_name }} (Cr)</td>
                                        <td>{{ $subLedger }}</td>
                                        <td>{{ $data->invoice }}</td>
                                        <td>{{ number_format($data->debit, 2)}}</td>
                                        <td></td>
                                        <td>{{ number_format($balance, 2)}}</td>
                                    </tr> 
                                    
                                        @endif
                                     
                                        @endif
                                        @endforeach 
                                        
                                    @endif
                                    
                                    
                                    
                                    
                                    @endif
                                    
                                   
                                    
                                    
                                    
                               
                                <tr style="background: rgba(222, 184, 135, 0.295);">
                                    <td align="right" colspan="3">SubTotal =</td>
                                    {{-- <td></td> --}}
                                    <td></td>
                                    <td></td>
                                    <td>{{ number_format($subtotal_exp, 2) }}</td>
                                    <td>{{ number_format($subTotalCredit, 2) }}</td>
                                    <td>{{ number_format($balance, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background: #bdb4b565;">
                                <td align="right" colspan="3">Total =</td>
                                {{-- <td></td> --}}
                                <td></td>
                                <td></td>
                                <td>{{ number_format($total_exp, 2) }}</td>
                                <td>{{ number_format($totalCredit, 2) }}</td>
                                <td>{{ number_format($balance, 2) }}</td>
                            </tr>
                        </tfoot>
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
