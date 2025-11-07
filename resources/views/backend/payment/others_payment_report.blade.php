@extends('layouts.account_dashboard')


@section('header_menu')
<li class="nav-item d-none d-sm-inline-block">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">

             <div class="row pt-3">
                      <div class="col-md-6 text-left">
                      	    <a href="{{ URL('/bank/payment/create') }}" class=" btn btn-success mr-2">Create Bank Payment</a>

                       </div>
                    <div class="col-md-6 text-right">

                      </div>
                  </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div>
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Others Payment Report</h5>
                        <hr>
                    </div>
                    <table id="datatablecustom" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>Sl</th>
                                <th>Bank\Cash Name</th>
                                <th> Loan Bank/Head/client</th>
                                <th>Payment Date</th>
                                <th>Type</th>
                                <th>Other Payment Type</th>
                                <th>Invoice</th>
                                <th>Total Amount</th>
                                <th>Pay Amount</th>
                                <th>Remaining </th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 0;
                                $total = 0;
                             @endphp
                            @foreach ($data as $item)

                                @php
                                $sl++;
                                $total += $item->amount;


                          			$loandetails ='';

                          			if($item->others_payment_type == "loan"){
                          				$loandetails = DB::table('loan_details')->where('id',$item->loan_id)->first();
                          			}

                          			$leasedetails = '';

                          			if($item->others_payment_type == "lease"){
                          				$leasedetails = DB::table('others_payment_details')->where('id',$item->borrow_lease_id)->first();
                          			}
                            		$borrowdetails = '';
                          			if($item->others_payment_type == "borrow"){

                         				 $borrowdetails = DB::table('others_payment_details')->where('id',$item->borrow_lease_id)->first();

                          			}

                        //  dd($leasedetails);
                                @endphp
                                    <tr>
                                        <td class="align-middle">{{ $sl }}</td>
                                        <td class="align-middle">{{$item->bank_name}} {{$item->wirehouse_name}}</td>
                                        <td class="align-middle">
                                      		@if($loandetails)
                                          	@php
                                        		$lonbankname = DB::table('master_banks')->where('bank_id',$loandetails->loan_bank_id)->value('bank_name');

                                          	@endphp
                                          {{$lonbankname}}
                                          @endif
                                          @if($leasedetails)

                                          @php
                                        		$leasehead= DB::table('leases')->select('leases.*','asset_clints.name')
                                          					->leftJoin('asset_clints', 'asset_clints.id', 'leases.client_id')
                                          					->where('leases.id',$leasedetails->lease_id)
                                          					->first();

                                          	@endphp

                                          {{$leasehead->head }} - {{ $leasehead->name}}
                                          @endif
                                          @if($borrowdetails)
                                           @php
                                          $borrowhead= DB::table('borrows')->where('id',$borrowdetails->borrow_id)->first();
                                        		$fromname = '';
                                                      if($borrowhead->from_client_id != null){
                                                              $fromname = DB::table('asset_clints')->where('id',$borrowhead->from_client_id)->where('id')->value('name');
                                                      }
                                                      if($borrowhead->from_company_id != null){
                                                              $fromname = DB::table('company_names')->where('id',$borrowhead->from_company_id)->value('name');
                                                      }


                                             $toname = '';
                                                      if($borrowhead->to_client_id != null){
                                                              $toname = DB::table('asset_clints')->where('id',$borrowhead->to_client_id)->value('name');
                                                      }
                                                      if($borrowhead->to_company_id != null){
                                                              $toname = DB::table('company_names')->where('id',$borrowhead->to_company_id)->value('name');
                                                      }

                                          	@endphp

                                          {{ $fromname }} --To-- {{ $toname }}
                                          @endif
                                      	</td>
                                        <td class="align-middle">{{$item->payment_date}}</td>
                                        <td class="align-middle">{{$item->type}}</td>
                                        <td class="align-middle">{{$item->others_payment_type}}</td>
                                        <td class="text-center align-middle">{{$item->invoice}}</td>

                                        <td class="text-right align-middle">
                                          @if($loandetails)
                                          {{$loandetails->total_loan}}
                                          @endif
                                          @if($leasedetails)
                                          {{$leasedetails->total_amount}}
                                          @endif
                                          @if($borrowdetails)
                                          {{$borrowdetails->total_amount}}
                                          @endif
                                         </td>
                                       <td class="text-right align-middle">
                                          {{$item->amount}}
                                         </td>
                                       <td class="text-right align-middle">
                                          @if($loandetails)
                                          {{$loandetails->loan_balance}}
                                          @endif
                                         @if($leasedetails)
                                          {{$leasedetails->balance}}
                                          @endif
                                          @if($borrowdetails)
                                          {{$borrowdetails->balance}}
                                          @endif
                                         </td>

                                   </tr>

                            @endforeach




                        </tbody>

                        <tfoot>
                            <tr style="background-color:rgba(238, 107, 107, 0.473); font-weight: bold;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td align="right">{{$total}}/-</td>
                              <td></td>
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
@endsection
