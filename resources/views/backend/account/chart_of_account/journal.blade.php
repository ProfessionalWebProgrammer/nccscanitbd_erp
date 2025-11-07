@extends('layouts.account_dashboard')
@section('print_menu')

			<li class="nav-item mt-2">
				<a href="{{ URL('/accounts/trial/balance/head/change') }}" class=" btn btn-success btn-xs mr-2">Head Change</a>
            </li>
			<div class="text-right">
                      {{-- <button class="btn btn-xs  btn-success mr-1 mt-2" id="btnExport"  >
                       Export
                    </button> --}}
                    <button class="btn btn-xs  btn-warning mt-2"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                    </div>

@endsection
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


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >


        <!-- Main content -->
        <div class="content px-4 pt-4">

            <div class="container-fluid" id="contentbody">
                <div class="row pt-5">
                    <div class="col-md-12 pt-3 text-center">
                      <h5 class="text-uppercase font-weight-bold">Journal</h5>
                      <p>{{date('d F, Y',strtotime($fdate))}} To {{date('d F, Y',strtotime($tdate))}}</p>
                        <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                        <p>Head office, Rajshahi, Bangladesh</p>
                  </div>
              </div>

                <div class="py-4">
                    <div class="py-4 col-md-10 m-auto table-responsive">
                        <table  class="table table-bordered table-striped table-sm table-fixed"
                            style="font-size: 6;" width="100%">
                            <thead style="background:#15e649 !important; color: #fff;">
                                <tr style="background:#0f882d !important; color: #fff;">
                                    <th width="15%">Date</th>
                                    <th width="55%">Particulars</th>
                                    <th width="15%" class="text-center">Debit</th>
                                    <th width="15%" class="text-center">Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coaInfo as $key => $coa)
                                    @php
                                        $purchaseFG = $coa->filter(function ($item) {
                                                                    return $item->acIndividualAccount && $item->acIndividualAccount->title == 'FG';
                                                                });
                                        $purchaseRM = $coa->filter(function ($item) {
                                                                    return $item->acIndividualAccount && $item->acIndividualAccount->title == 'Raw Materials';
                                                                });
                                        $purchaseBG = $coa->filter(function ($item) {
                                                                    return $item->acIndividualAccount && $item->acIndividualAccount->title == 'Bag';
                                                                });
                                        $paymentSupplier = $coa->filter(function ($item) {
                                                                    return $item->acSubSubAccount && $item->acSubSubAccount->title == 'Accounts Payable (Suppliers)';
                                                                });
                                        $saleFG = $coa->filter(function ($item) {
                                                                    return $item->acSubSubAccount && $item->acSubSubAccount->title == 'Finished Goods Sales';
                                                                }); 
                                        $saleRM = $coa->filter(function ($item) {
                                                                    return $item->acSubSubAccount && $item->acSubSubAccount->title == 'Raw Material Sales';
                                                                }); 
                                        $receiveDealer = $coa->filter(function ($item) {
                                                                    return $item->acSubSubAccount && $item->acSubSubAccount->title == 'Accounts Receivable (Dealer)';
                                                                });
                                        $bankOrCash = $coa->filter(function ($item) {
                                                                    return $item->acSubSubAccount && ($item->acSubSubAccount->title == 'Bank' || $item->acSubSubAccount->title == 'Cash');
                                                                });                                                
                                    @endphp
                               
                                    @if( $purchaseFG->isNotEmpty())
                                        @foreach ($purchaseFG as $fg)
                                            @php
                                                $supplierInfo = $coa->where('id' , $fg->ref_id)->where('ac_sub_sub_account_id',6)->first();
                                            @endphp
                                            @if($supplierInfo )
                                            <tr>
                                                <td style="vertical-align: middle">{{ \Carbon\Carbon::parse($key)->format('d M, Y') }}</td>
                                                <td  width="55%" style="padding:0px;" colspan="3">
                                                    <table class="table table-bordered" style="margin:0px"  width="100%">
                                                        <tr>
                                                            <td  width="55%">Purchase (Finish Goods) A/C</td>
                                                            <td width="15%" class="text-center">{{ $fg->debit}}</td>
                                                            <td width="15%" class="text-center"></td>
                                                        </tr>
                                                       
                                                   
                                                    <tr>
                                                        <td  width="55%" ><span style="margin-left: 200px">To {{$supplierInfo->acIndividualAccount?->title  }} (Supplier) A/C</span></td>
                                                        <td width="15%" class="text-center"></td>
                                                        <td width="15%" class="text-center">{{ $supplierInfo->credit }}</td>
                                                    </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4">{{ $fg->comment ?? '---' }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if( $purchaseRM->isNotEmpty())
                                        @foreach ($purchaseRM as $rm)
                                            @php
                                                $supplierInfo = $coa->where('id' , $rm->ref_id)->where('ac_sub_sub_account_id',6)->first();
                                            @endphp
                                            @if($supplierInfo )
                                            <tr>
                                                <td style="vertical-align: middle">{{ \Carbon\Carbon::parse($key)->format('d M, Y') }}</td>
                                                <td  width="55%" style="padding:0px;" colspan="3">
                                                    <table class="table table-bordered" style="margin:0px"  width="100%">
                                                        <tr>
                                                            <td  width="55%">Purchase (Raw Materials) A/C</td>
                                                            <td width="15%" class="text-center">{{ $rm->debit}}</td>
                                                            <td width="15%" class="text-center"></td>
                                                        </tr>
                                                       
                                                   
                                                    <tr>
                                                        <td  width="55%" ><span style="margin-left: 200px">To {{$supplierInfo->acIndividualAccount?->title  }} (Supplier) A/C</span></td>
                                                        <td width="15%" class="text-center"></td>
                                                        <td width="15%" class="text-center">{{ $supplierInfo->credit }}</td>
                                                    </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4">{{ $rm->comment ?? '---' }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if( $purchaseBG->isNotEmpty())
                                        @foreach ($purchaseBG as $bg)
                                            @php
                                                $supplierInfo = $coa->where('id' , $bg->ref_id)->where('ac_sub_sub_account_id',6)->first();
                                            @endphp
                                            @if($supplierInfo )
                                            <tr>
                                                <td style="vertical-align: middle">{{ \Carbon\Carbon::parse($key)->format('d M, Y') }}</td>
                                                <td  width="55%" style="padding:0px;" colspan="3">
                                                    <table class="table table-bordered" style="margin:0px"  width="100%">
                                                        <tr>
                                                            <td  width="55%">Purchase (Bags) A/C</td>
                                                            <td width="15%" class="text-center">{{ $bg->debit}}</td>
                                                            <td width="15%" class="text-center"></td>
                                                        </tr>
                                                       
                                                   
                                                    <tr>
                                                        <td  width="55%" ><span style="margin-left: 200px">To {{$supplierInfo->acIndividualAccount?->title  }} (Supplier) A/C</span></td>
                                                        <td width="15%" class="text-center"></td>
                                                        <td width="15%" class="text-center">{{ $supplierInfo->credit }}</td>
                                                    </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4">{{ $bg->comment ?? '---' }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if( $paymentSupplier->isNotEmpty())
                                        @foreach ($paymentSupplier as $supplier)
                                            @php
                                                $bankOrCashInfo = $coa->where('id' , $supplier->ref_id)->whereIn('ac_sub_sub_account_id',[4,7])->first();
                                            @endphp
                                            @if($bankOrCashInfo )
                                            <tr>
                                                <td style="vertical-align: middle">{{ \Carbon\Carbon::parse($key)->format('d M, Y') }}</td>
                                                <td  width="55%" style="padding:0px;" colspan="3">
                                                    <table class="table table-bordered" style="margin:0px"  width="100%">
                                                        <tr>
                                                            <td  width="55%">{{ $supplier->acIndividualAccount?->title}} (Supplier) A/C</td>
                                                            <td width="15%" class="text-center">{{ $supplier->debit}}</td>
                                                            <td width="15%" class="text-center"></td>
                                                        </tr>
                                                    
                                                
                                                    <tr>
                                                        <td  width="55%" ><span style="margin-left: 200px">To {{$bankOrCashInfo->acSubSubAccount?->title  }} A/C</span></td>
                                                        <td width="15%" class="text-center"></td>
                                                        <td width="15%" class="text-center">{{ $bankOrCashInfo->credit }}</td>
                                                    </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4">{{ $supplier->comment ?? '---' }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if($saleFG->isNotEmpty())
                                        @foreach ($saleFG as $sale)
                                            @php
                                                $dealerInfo = $coa->where('id' , $sale->ref_id)->whereIn('ac_sub_sub_account_id',[15])->first();
                                            @endphp
                                            @if($dealerInfo )
                                            <tr>
                                                <td style="vertical-align: middle">{{ \Carbon\Carbon::parse($key)->format('d M, Y') }}</td>
                                                <td  width="55%" style="padding:0px;" colspan="3">
                                                    <table class="table table-bordered" style="margin:0px"  width="100%">
                                                        <tr>
                                                            <td  width="55%" >{{$dealerInfo->acIndividualAccount?->title  }} (Dealer) A/C</td>
                                                            <td width="15%" class="text-center">{{ $dealerInfo->debit}}</td>
                                                            <td width="15%" class="text-center"></td>
                                                        </tr>
                                                        <tr>
                                                            <td  width="55%"><span style="margin-left: 200px">To  {{ $sale->acSubSubAccount?->title}}A/C </span></td>
                                                            <td width="15%" class="text-center"></td>
                                                            <td width="15%" class="text-center">{{ $sale->credit }}</td>
                                                        </tr>
                                                    
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4">{{ $dealerInfo->comment ?? '---' }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if($saleRM->isNotEmpty())
                                        @foreach ($saleRM as $srm)
                                            @php
                                                $dealerInfo = $coa->where('id' , $srm->ref_id)->whereIn('ac_sub_sub_account_id',[15])->first();
                                            @endphp
                                            @if($dealerInfo )
                                            <tr>
                                                <td style="vertical-align: middle">{{ \Carbon\Carbon::parse($key)->format('d M, Y') }}</td>
                                                <td  width="55%" style="padding:0px;" colspan="3">
                                                    <table class="table table-bordered" style="margin:0px"  width="100%">
                                                        <tr>
                                                            <td  width="55%" >{{$dealerInfo->acIndividualAccount?->title  }} (Dealer) A/C</td>
                                                            <td width="15%" class="text-center">{{ $dealerInfo->debit}}</td>
                                                            <td width="15%" class="text-center"></td>
                                                        </tr>
                                                        <tr>
                                                            <td  width="55%"><span style="margin-left: 200px">To  {{ $srm->acSubSubAccount?->title}}A/C </span></td>
                                                            <td width="15%" class="text-center"></td>
                                                            <td width="15%" class="text-center">{{ $srm->credit }}</td>
                                                        </tr>
                                                    
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4">{{ $dealerInfo->comment ?? '---' }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if( $receiveDealer->isNotEmpty())
                                        @foreach ($receiveDealer as $receiver)
                                            @php
                                                $bankOrCashReInfo = $coa->where('id' , $receiver->ref_id)->whereIn('ac_sub_sub_account_id',[4,7])->first();
                                            @endphp
                                            @if($bankOrCashReInfo )
                                            <tr>
                                                <td style="vertical-align: middle">{{ \Carbon\Carbon::parse($key)->format('d M, Y') }}</td>
                                                <td  width="55%" style="padding:0px;" colspan="3">
                                                    <table class="table table-bordered" style="margin:0px"  width="100%">
                                                        <tr>
                                                            <td  width="55%">{{ $bankOrCashReInfo->acSubSubAccount?->title}} A/C</td>
                                                            <td width="15%" class="text-center">{{ $bankOrCashReInfo->debit}}</td>
                                                            <td width="15%" class="text-center"></td>
                                                        </tr>
                                                    
                                                
                                                    <tr>
                                                        <td  width="55%" ><span style="margin-left: 200px">To {{$receiver->acIndividualAccount?->title  }} (Dealer) A/C</span></td>
                                                        <td width="15%" class="text-center"></td>
                                                        <td width="15%" class="text-center">{{ $receiver->credit }}</td>
                                                    </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4">{{ $receiver->comment ?? '---' }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if( $bankOrCash->isNotEmpty())
                                    @foreach ($bankOrCash as $boc)
                                        @php
                                            $expenseInfo = $coa->where('id' , $boc->ref_id)->whereNotIn('ac_sub_sub_account_id',[6,15])->first();
                                        @endphp
                                        @if($expenseInfo )
                                        <tr>
                                            <td style="vertical-align: middle">{{ \Carbon\Carbon::parse($key)->format('d M, Y') }}</td>
                                            <td  width="55%" style="padding:0px;" colspan="3">
                                                <table class="table table-bordered" style="margin:0px"  width="100%">
                                                    <tr>
                                                        <td  width="55%">{{ $expenseInfo->acSubSubAccount?->title}} A/C</td>
                                                        <td width="15%" class="text-center">{{ $expenseInfo->debit}}</td>
                                                        <td width="15%" class="text-center"></td>
                                                    </tr>
                                                
                                            
                                                <tr>
                                                    <td  width="55%" ><span style="margin-left: 200px">To {{$boc->acSubSubAccount?->title  }} A/C</span></td>
                                                    <td width="15%" class="text-center"></td>
                                                    <td width="15%" class="text-center">{{ $boc->credit }}</td>
                                                </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="4">{{ $boc->comment ?? '---' }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @endif
                                @endforeach
                            </tbody>

                            <tfoot>
                                {{-- <tr style="background: #C641CF; color: #fff;">
                                    <td>Total</td>
                                    <td align="right">{{ number_format($totalDebit, 2) }}</td>
                                   <td align="right">{{ number_format($totalCredit, 2) }}</td>
                                </tr> --}}

                            </tfoot>




                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


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
                filename: "Trail_balance.xls"
            });
        });
    });
</script>

@endsection
