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
                  	<div class="col-md-3 text-left">
                      <h5 class="text-uppercase font-weight-bold">Trail Balance</h5>
                      <p class="text-uppercase font-weight-bold">From {{date('d m, Y',strtotime($date))}} to {{date('d m, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-6 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    	<p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>

                <div class="py-4">
                    <div class="py-4 col-md-8 m-auto table-responsive">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 6;table-layout: inherit;">
                            <thead>
                                <tr style="background: #FA621C; color: #fff;">
                                    <th>Head </th>
                                    <th align="right">Debit</th>
                                    <th align="right">Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                               @php
                          		$uid = Auth::id();
                              
                           @endphp
                              {{-- @php	$totalBankAmount = 0;
                                    $totaldebit = 0;
                                    $totalcredit = 0;
                              		$predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
                              		$bankTransfer =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"bankTransfer")->value('change_name');
                              // + $data['bank_open']  
                              @endphp --}}
                                 @php
                                    $totaldebit = 0;
                                    $totalcredit = 0;
                              		$bankTransfer =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"bankTransfer")->value('change_name');
                                @endphp
                              <tr>
                                @php
                                $totaldebit += ($data['bank_transfer_amount']  + $data['bank_receive_amount']) - ( $data['bank_payment_amount']+$data['expanse_amount_bank']+$data['bank_transfer_payment']+$data['loan_amount']+$data['bank_overderft']+$data['borrow_from']+$data['lease']);
                                $totalcredit += 0;
                                @endphp
                                <td>{{$bankTransfer ? $bankTransfer:'Bank Amount'}}</td>
                                <td align="right">{{number_format(($data['bank_transfer_amount'] + $data['bank_receive_amount']) - ( $data['bank_payment_amount']+$data['expanse_amount_bank']+$data['bank_transfer_payment']+$data['loan_amount']+$data['bank_overderft']+$data['borrow_from']+$data['lease']), 2) ?? 0}} </td>
                                <td align="right">0</td>
                              </tr> 
                            {{--  @foreach($allBanks as $key => $bank_list)
                              @php 
								$totaldata = DB::table('payments')
                          				->select('bank_id',
                             		DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND type = "BANK" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as oprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "BANK" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as oppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND type = "BANK" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "BANK" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "BANK" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as troprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "BANK" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as troppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "BANK" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as trtotalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "BANK" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as trtotalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "BANK" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as otoprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "BANK" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as otoppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "BANK" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as ottotalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "BANK" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as ottotalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "BANK" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as exoppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "BANK" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as extotalrcv'),

                         			DB::raw('sum(CASE WHEN payment_type = "COLLECTION" AND type = "BANK" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as cloppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "COLLECTION" AND type = "BANK" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as cltotalrcv'),

                          			)->where('status', 1)->where('bank_id', $bank_list->bank_id)->first();
	$loandcheck = DB::table('master_banks')->whereBetween('loan_fdate',[$fdate,$tdate])->where('bank_id', $bank_list->bank_id)->value('loan_amount');
                          			$preloandcheck = DB::table('master_banks')->whereBetween('loan_fdate',[$startdate,$predate])->where('bank_id', $bank_list->bank_id)->value('loan_amount');
									$bankChargeAmount = DB::table('payments')->select([DB::raw("SUM(amount) expamount")])->where('payment_type','EXPANSE')->where('type','BANK')->where('others_payment_type','OTHERS')->whereBetween('payment_date',[$fdate,$tdate])->where('bank_id', $bank_list->bank_id)->first();

                          			$oprcv = $totaldata->oprcv+$totaldata->troprcv+$totaldata->otoprcv+$totaldata->cltotalrcv+$preloandcheck;
                          			$oppay = $totaldata->oppay+$totaldata->troppay+$totaldata->otoppay+$totaldata->exoppay;

                          			$totalrcv = $totaldata->totalrcv+$totaldata->trtotalrcv+$totaldata->ottotalrcv+$totaldata->cltotalrcv+$loandcheck;
                          			$totalpay = $totaldata->totalpay+$totaldata->trtotalpay+$totaldata->ottotalpay+$totaldata->extotalrcv - $bankChargeAmount->expamount;

                          			$opb = $oprcv - $oppay + $bank_list->bank_op;
                            		$clb = $opb + $totalrcv - $totalpay;
                            $totalBankAmount += $clb;
                            @endphp 
                            @endforeach
                                
                              <tr>
                                @php
                                $totaldebit += $totalBankAmount;
                                $totalcredit += 0;
                                @endphp
                                <td>{{$bankTransfer ? $bankTransfer:'Bank Amount'}}</td>
                                <td align="right">{{number_format($totalBankAmount,2)}}</td>
                                <td align="right">0</td>
                                // $data['cash_open'] +
                              </tr> --}}
                             <tr >
                                    @php
                                        $totalcredit += 0;
										 $totaldebit += (( $data['cash_receive_amount'] + $data['cash_transfer_receive_amount']) - ($data['cash_payment_amount'] + $data['expanse_amount_cash']+$data['cash_transfer_payment_amount'])) ;
                                    @endphp
                                  @php
                               		$cashamount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"cashamount")->value('change_name');
                                 @endphp

                                    <td>{{$cashamount ? $cashamount:'Cash Amount'}}</td> {{-- $data['cash_open'] --}}
                                    <td align="right">{{ number_format(( $data['cash_receive_amount'] + $data['cash_transfer_receive_amount']) - ($data['cash_payment_amount'] + $data['expanse_amount_cash']+$data['cash_transfer_payment_amount']), 2) }}</td>
                                    <td align="right">0</td>

                                </tr>
                                <tr>
                                    @php
                                  		$total = 0;
                                        $totaldebit += $data['purchase_amount'] - ($cogsData + $data['totalDamageVal']+$data['purchase_return']);
                                        $totalcredit += 0;
                                    @endphp
                                    @php
                               $purchaseaccount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"purchaseaccount")->value('change_name');

                                 @endphp
                                  <td>{{$purchaseaccount ? $purchaseaccount:'Purchase Amount'}} </td>
                                    <td align="right">{{ number_format($data['purchase_amount'] - ($cogsData+$data['totalDamageVal']+$data['purchase_return']), 2) }}</td>
                                    <td align="right">0</td>

                                </tr>
                             {{--  <tr>
                                @php
                                       $totaldebit += $data['inventory'];
                                       $totalcredit += 0;
                                    @endphp
                                <td>Inventory </td>
                                    <td align="right">{{ number_format($data['inventory'], 2) }}</td>
                                    <td align="right">0</td>
                                </tr>  --}}
                              {{-- <tr>
                                @php
                                $totaldebit += $data['payment_amount'] + $data['expence_amount'];
                                $totalcredit += 0;
                                $paymentAmount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"paymentAmount")->value('change_name');
                                @endphp

                                <td>{{$paymentAmount ? $paymentAmount:'Payment Amount'}}</td>
                                <td align="right">{{number_format($data['payment_amount'] + $data['expence_amount'], 2)?? 0}}</td>
                                <td align="right">0</td>
                              </tr> --}}
                                <tr>
                                    @php
                                        $totaldebit += 0;
                                        $totalcredit += $data['purchase_amount'] - ($data['purchase_sup_payment_amount']+$data['totalDamageVal']+$data['purchase_return']);
                                    @endphp
                                     @php
                               $accountpayable =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"accountpayable")->value('change_name');

                                 @endphp
                                  <td><a href="" data-toggle="modal" data-target="#accountPayable" >{{$accountpayable ? $accountpayable:'Account Payable'}}</a></td>
                                    <td align="right">0</td>
                                   {{-- <td align="right">{{number_format($data['purchase_amount'] - $data['sub_payment_amount'], 2) }}</td> --}}
                                  	<td align="right">{{number_format($data['purchase_amount'] - ($data['purchase_sup_payment_amount']+ $data['totalDamageVal']+$data['purchase_return']), 2) }}</td>
                                </tr>
                                <tr>
                                    @php
                                        $totaldebit += $data['general_purchase_amount'];
                                        $totalcredit += 0;
                                    @endphp
                                       @php
                               $gpurchaseaccount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"gpurchaseaccount")->value('change_name');

                                 @endphp
                                   <td>{{$gpurchaseaccount ? $gpurchaseaccount:'General Purchae Account'}}</td>
                                     <td align="right">{{ number_format($data['general_purchase_amount'], 2) }}</td>
                                    <td align="right">0</td>

                                </tr>

                                <tr>
                                    @php
                                        $totaldebit += 0;
                                        $totalcredit += $data['general_purchase_amount'];
                                    @endphp

                                   @php
                               		$gpurchaseaccountpayable =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"gpurchaseaccountpayable")->value('change_name');
                                  @endphp

								 <td>{{$gpurchaseaccountpayable ? $gpurchaseaccountpayable:'General Purchae Account Payable (Account Payable)'}}</td>
                                    <td align="right">0</td>
                                    <td align="right">{{ number_format($data['general_purchase_amount'], 2) ?? 0 }}</td>

                                </tr>

                                <tr>
                                    @php
                                        $totaldebit += 0;
                                        $totalcredit += $data['purchase_return'];
                                    @endphp
                                   @php
                               $purchasereturn =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"purchasereturn")->value('change_name');

                                 @endphp
                                   <td>{{$purchasereturn ? $purchasereturn:'Purchase Return'}}</td>
                                    <td align="right">0</td>
                                    <td align="right">{{ number_format($data['purchase_return'], 2) ?? 0 }}</td>
                                </tr>

                                <tr>
                                    @php
                                        $totaldebit += 0;
                                        $totalcredit += $data['sales_amount'];
                                    @endphp

                                   @php
                               $salesacount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"salesacount")->value('change_name');
                                 @endphp
                                   <td>{{$salesacount ? $salesacount:'Sales Account'}}</td>
                                    <td align="right">0</td>
                                    <td align="right">{{ number_format($data['sales_amount'], 2)}}</td>

                                </tr>
                                <tr>
                                    @php
                                  		$total_temp = $data['receive_amount'] + $data['sales_return'] - $data['bankCharge_amount'];
                                        $totaldebit += ($data['sales_amount'] - $total_temp );
                                        $totalcredit += 0;
                                    @endphp

                                   @php
                               $accountreceivable =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"accountreceivable")->value('change_name');

                                 @endphp
                                   <td><a href="" data-toggle="modal" data-target="#amountReceiveable" > {{$accountreceivable ? $accountreceivable:'Account Receivable'}}</a></td>
                                    <td align="right">{{ number_format($data['sales_amount'] - $total_temp , 2)}}</td>
                                    <td align="right">0</td>

                                </tr>
                                <tr>
                                    @php
                                        $totaldebit += $data['sales_return'];
                                        $totalcredit += 0;
                                    @endphp

                                   @php
                               $salesreturn =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"salesreturn")->value('change_name');

                                 @endphp
                                   <td>{{$salesreturn ? $salesreturn:'Sales Return'}}</td>
                                    <td align="right">{{ number_format($data['sales_return'], 2) }}</td>
                                    <td align="right">0</td>

                                </tr>

                                 <tr>
                                 @php
                               		$expansedetails =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"expansedetails")->value('change_name');
									
                                 @endphp
                                     <td colspan="100%">{{$expansedetails ? $expansedetails:'Expense Details'}}</td>
									
                                </tr>
                               
                             @foreach($data['expanse_details'] as $item)
                               <tr >
                                     <td class="pl-5">{{$item->group_name ? $item->group_name : "Other Expense"}}</td>
                                    <td align="right">{{ number_format($item->expamount, 2)?? 0}}</td>
                                    <td align="right">0</td>

                                </tr>

                              @endforeach
                              
                            {{--  @if($tdate <= '2023-01-31')
                              <tr>
                              <td class="pl-5">Admnistrative Expenses</td>
                                <td align="right">3,686,308</td>
                                <td align="right">0</td>
                              </tr>
                              <tr>
                              <td class="pl-5">Marketing Expenses</td>
                                <td align="right">359,015</td>
                                <td align="right">0</td>
                              </tr>
                              <tr>
                              <td class="pl-5">Field Force Expenses</td>
                                <td align="right">2,361,237</td>
                                <td align="right">0</td>
                              </tr>
                              <tr>
                              <td class="pl-5">Distribution Expenses</td>
                                <td align="right">576,229</td>
                                <td align="right">0</td>
                              </tr> --}}
                              
                                <tr style="font-weight:bold">
                                    @php
                                        $totaldebit += $data['expanse_amount']; 
                                        $totalcredit += 0;
                                    @endphp

                                    @php
                               $texpnaseamount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"texpnaseamount")->value('change_name');

                                 @endphp
                                    <td>{{$texpnaseamount ? $texpnaseamount:'Total Expense Amount'}}</td>

                                    
                                 <td align="right">{{ number_format($data['expanse_amount'], 2) }}</td> 
                                    <td align="right">0</td>

                                </tr>
                      
			
                               <tr>
                                    @php
                                        $totaldebit += 0;
                                        $totalcredit += $data['otherIncome'];
                                    @endphp

                                   <td>Others Income</td>
                                  <td align="right">0</td>
                                    <td align="right">{{ number_format($data['otherIncome'], 2) }}</td>
                                </tr>
                            
								<tr>
                                    @php
                                        $totaldebit += $data['assets_amount']-$data['asset_depreciations'];
                                        $totalcredit += 0;
                                    @endphp
                                    @php
                               $assetamount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"assetamount")->value('change_name');

                                 @endphp
                                   <td>{{$assetamount ? $assetamount:'Assets Amount'}}</td>
                                    <td align="right">{{ number_format($data['assets_amount'] - $data['asset_depreciations'], 2) }}</td>
                                    <td align="right">0</td>

                                </tr>

                                <tr>
                                    @php
                                        $totaldebit += $cogsData;
                                        $totalcredit += 0;
                                    @endphp
                                   @php
                               $cogs =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"cogs")->value('change_name');

                                 @endphp
                                   <td>{{$cogs ? $cogs:'C.O.G.S'}}</td>
                                   <td align="right">{{ number_format($cogsData, 2) }}</td>
                                    <td align="right">0</td>

                                </tr>
                              <tr>
                              @php
                               $capital =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"capital")->value('change_name');
								$totaldebit += 0;
                                $totalcredit += $data['shimul_amount'];
                                 @endphp
                                <td>Current Liabilities - (Shimul Enterprise) </td> {{-- {{$data['cash_transfer_receive_amount']}} --}}
                                <td  align="right">0</td>
                                <td  align="right">{{number_format($data['shimul_amount'], 2)}}</td>
                              </tr>
                              {{-- <tr>
                                    @php
                                        $totaldebit += $data['journal_credit'];
                                        $totalcredit += $data['journal_credit'];
                                    @endphp
                                    @php
                               $journalamount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"journalamount")->value('change_name');

                                 @endphp
 								<td>{{$journalamount ? $journalamount:'Tds'}}</td>
                                    <td align="right">{{ number_format($data['journal_debit'], 2) }}</td>
                                    <td align="right">{{ number_format($data['journal_credit'], 2) }}</td>

                                </tr> --}}
                               <tr>
                                @php
                               $equitiy =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"equitiy")->value('change_name');
								$totaldebit += 0;
                                $totalcredit += $data['equitiy'];

                                 @endphp

                                   <td>{{$equitiy ? $equitiy:'Equity Amount'}}</td>
                                    <td align="right">0</td>
                                 	<td align="right">{{number_format($data['equitiy'], 2)}}</td>
                                   {{-- <td align="right">{{$data['assets_amount']-$data['asset_depreciations']+$data['equitiy']+$data['loan_amount']+$data['bank_overderft']+$data['borrow_from']+$data['lease']+ $data['bad_debt_amount']}}</td> --}}

                                </tr>

                            </tbody>

                            <tfoot>
                                <tr style="background: #C641CF; color: #fff;">
                                    <td>Total</td>
                                    <td align="right">{{ number_format($totaldebit, 2) }}</td>
                                   <td align="right">{{ number_format($totalcredit, 2) }}</td>


                                </tr>

                            </tfoot>




                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@include('backend.account.modal')
    {{-- <script>
        $(document).ready(function() {

            $("#products_id").on('change', function() {

                var product_id = $(this).val();

                alert(product_id);

                $.ajax({
                    url: '{{ url('/scale/data/get/') }}/' + id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);



                        $("#data").val(data.date);
                        $("#vehicle").val(data.vehicle);
                        $("#supplier_chalan_qty").val(data.chalan_qty).attr('readonly',
                            'readonly');
                        $("#receive_quantity").val(data.actual_weight).attr('readonly',
                            'readonly');

                        $("#supplier_id").val(data.supplier_id);
                        $("#wirehouse").val(data.warehouse_id);
                        $("#product_id").val(data.rm_product_id);

                        $('.select2').select2({
                            theme: 'bootstrap4'
                        })

                    }
                });


                calculation();


            });
        });
    </script> --}}


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
