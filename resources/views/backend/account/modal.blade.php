<style type="text/css" media="screen">
           
  .modal-body .table th{
                padding: 0.45rem!important;
                font-size: 18px!important;
                font-weight: 600!important;
  }
  .modal-body .table .sub-head{
    			padding: 0.40rem!important;
                font-size: 17px!important;
                font-weight: 500!important;
    			color: green;
  }
  .modal-body .table .sub-head2{
    			padding: 0.40rem!important;
                font-size: 17px!important;
                font-weight: 500!important;
    			color: red;
  }
  .modal-body .table th:nth-child(2){
  text-align:right;
  }
  .modal-body .table td{
                padding: 0.25rem!important;
                font-size: 15px!important;
                font-weight: 300!important;
            }

        </style>

   
  <!-- modal amountReceiveable start -->
    <div class="modal fade" id="amountReceiveable">
            <div class="modal-dialog">
                <div class="modal-content bg-light">
                    <div class="modal-header">
                        <h4 class="modal-title">Account Receiveable</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body">
                           <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Head </th>
                                    <th align="right">Amount</th>
                                </tr>
                          </thead>
                             
                            <tbody>
                              @php 
                              $allData = DB::table('sales_ledgers')->select(DB::raw('sum(debit) debit,sum(credit) credit, dealers.d_s_name as name'))
                              					->leftJoin('dealers', 'dealers.id', 'sales_ledgers.vendor_id')
                              					->whereBetween('sales_ledgers.ledger_date', [$fdate, $tdate])->groupBy('sales_ledgers.vendor_id')->get();
                              $value = 0;
                              $total = 0;
                              @endphp
                              @if(count($allData) > 0)
                                @foreach($allData as $val)
                              		@php 
                              		$value = $val->debit - $val->credit; 
                              		$total += $value; 
                              		@endphp 
                              		<tr>
                                      <td>{{$val->name}}</td>
                                      <td align="right">{{number_format($value,2)}}</td>
                                    </tr>
                                @endforeach
                                  <tr>
                                    <td class="sub-head">Total:</td>
                                    <td class="sub-head" align="right">{{number_format($total,2) ?? '0'}}/-</td>
                                	</tr>
                              @endif 
                              
                              {{-- 
                              @if(!empty($allSales_amount))
                              <tr>
                                <td class="sub-head" colspan="2">All Sales Amount</td>
                              </tr>
                              @foreach($allSales_amount as $val)
                              @php 
                              $total_sales += $val->amount;
                              @endphp 
                              <tr>
                                <td>{{$val->name}}</td>
                                <td align="right">{{number_format($val->amount,2)}}</td>
                              </tr>
                              @endforeach 
                              	<tr>
                                <td class="sub-head">Sub-Total:</td>
                                <td class="sub-head" align="right">{{number_format($total_sales,2) ?? '0'}}/-</td>
                              </tr>
                              @endif
                              
                               @php 
                              $allSales_return = DB::table('sales_ledgers')->select(DB::raw('sum(total_price) amount, dealers.d_s_name as name'))
                              					->leftJoin('dealers', 'dealers.id', 'sales_ledgers.vendor_id')
                              					->whereNotNull('sales_ledgers.return_id')->whereBetween('sales_ledgers.ledger_date', [$fdate, $tdate])->groupBy('sales_ledgers.vendor_id')->get();
                              $total_return = 0;
                              @endphp
                              @if(!empty($allSales_return))
                              <tr>
                                <td class="sub-head" colspan="2">All Sales Return Amount</td>
                              </tr>
                              @foreach($allSales_return as $val)
                              @php 
                              $total_return += $val->amount;
                              @endphp 
                              <tr>
                                <td>{{$val->name}}</td>
                                <td align="right">{{number_format($val->amount,2)}}</td>
                              </tr>
                              @endforeach 
                              	<tr>
                                <td class="sub-head">Sub-Total:</td>
                                <td class="sub-head" align="right">{{number_format($total_return,2) ?? '0'}}/-</td>
                              </tr>
                              @endif
                              
                               @php 
                              $all_received = DB::table('payments')->select(DB::raw('sum(amount) amount, bank_name, wirehouse_name'))
                              				->where('payment_type', 'RECEIVE')->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->groupBy('bank_id','wirehouse_id')->get();
                              $total_received = 0;
                              @endphp
                              @if(!empty($allSales_return))
                              <tr>
                                <td class="sub-head" colspan="2">All Received Amount</td>
                              </tr>
                              @foreach($all_received as $val)
                              @php 
                              $total_received += $val->amount;
                              @endphp 
                              <tr>
                                @if($val->bank_name == 'null')
                                  <td>{{$val->wirehouse_name}}</td>
                                  @else 
                                  <td>{{$val->bank_name}}</td>
                                @endif
                                <td align="right">{{number_format($val->amount,2)}}</td>
                              </tr>
                              @endforeach 
                              	<tr>
                                <td class="sub-head">Sub-Total:</td>
                                <td class="sub-head" align="right">{{number_format($total_received,2) ?? '0'}}/-</td>
                              </tr>
                              @endif
                              <tr>
                                  @php 
                                  $total = $total_sales + $total_return - $total_received;
                                  @endphp
                                <th>Grand Total:</th>
                                <th  align="right">{{number_format($total,2) ?? '0'}}/-</th>
                              </tr>
                              --}}
                              
                          
                            </tbody>
                             </table>
                        </div>                     
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    <!-- /.modal end -->        


<!-- modal accountPayable start -->
    <div class="modal fade" id="accountPayable">
            <div class="modal-dialog">
                <div class="modal-content bg-light">
                    <div class="modal-header">
                        <h4 class="modal-title">Account Payable</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body">
                           <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Head </th>
                                    <th align="right">Amount</th>
                                </tr>
                          </thead>
                             
                            <tbody>
                              @php 
                               $allPurchase = DB::table('purchase_ledgers')->select(DB::raw('sum(credit) amount, supplier_id as id'))->whereBetween('date', [$fdate, $tdate])->groupBy('purchase_ledgers.supplier_id')->get();
                              $total = DB::table('purchase_ledgers')->whereNotNull('purcahse_id')
                                      			 ->whereBetween('date', [$fdate, $tdate])->groupBy('purchase_ledgers.supplier_id')->sum('credit');
                              
                              $totalPayable = 0;
                              $allSID = [];
                              
                              @endphp
                              
                              @if(count($allPurchase) > 0)
                                @foreach($allPurchase as $val)
                                  @php 
                              		$data = DB::table('purchase_ledgers')->select(DB::raw('sum(debit) amount, suppliers.supplier_name as name'))
                              			         ->leftJoin('suppliers', 'suppliers.id', 'purchase_ledgers.supplier_id')->where('supplier_id', $val->id)
                                      			 ->whereBetween('date', [$fdate, $tdate])->groupBy('purchase_ledgers.supplier_id')->first();
                              
                              		array_push($allSID, $val->id);
                                    $value = $val->amount - $data->amount; 
                              		$totalPayable += $value;
                                  @endphp 
                              	
                                <tr>
                                  <td>{{$data->name}}</td>
                                  <td align="right">{{number_format($value,2)}}</td>
                                </tr>
                                @endforeach 
                              @endif
                              
                              {{-- ->whereNotIn('supplier_id', [$convertId]) --}}
                               @php 
                                   $convertId = implode(',', $allSID);
                              	   $AllData = DB::table('purchase_ledgers')->select(DB::raw('sum(debit) amount, suppliers.supplier_name as name'))
                                        ->leftJoin('suppliers', 'suppliers.id', 'purchase_ledgers.supplier_id')->whereNotNull('warehouse_bank_id')
                                        ->whereBetween('date', [$fdate, $tdate])->groupBy('purchase_ledgers.supplier_id')->get();
                                @endphp
                              
                             {{--  @if(count($AllData) > 0)
                              	 @foreach($AllData as $val)
                                  @php 

                                    $value = 0 - $val->amount; 
                              		$totalPayable += $value;
                                  @endphp 
                              	
                                <tr>
                                  <td>{{$val->name}}</td>
                                  <td align="right">{{number_format($value,2)}}</td>
                                </tr>
                                @endforeach 
                              @endif --}}
                              
                              <tr>
                                   <th>Total:</th>
                                <th  align="right">{{number_format($totalPayable,2) ?? '0'}}/-</th>
                                </tr>
                              
                            </tbody>
                             </table>
                        </div>                     
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    <!-- /.modal end -->


<!-- modal expanse start -->
    <div class="modal fade" id="expanse">
            <div class="modal-dialog">
                <div class="modal-content bg-light">
                    <div class="modal-header">
                        <h4 class="modal-title">Expanse Amount</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                        <div class="modal-body">
                           <table class="table table-bordered table-striped">
                            <thead>
                                <tr><th>Head </th> <th align="right">Amount</th></tr>
                          </thead>
                             
                            <tbody>
                              @php 
                              $expanse = DB::table('payments')->select(DB::raw('SUM(amount) as amount, expanse_groups.group_name as name'))
                              			->leftJoin('expanse_groups', 'expanse_groups.id', 'payments.expanse_type_id')
                              			->where('expanse_status', 1)->where('status', 1)->whereNotNull('expanse_type_id')
                                    	->whereBetween('payment_date', [$fdate, $tdate])->groupby('expanse_type_id')->get();
                              $totalExpanse = 0;
                              @endphp 
                              @if(count($expanse) > 0)
                              @foreach($expanse as $data)
                               @php $totalExpanse += $data->amount; @endphp 
                              <tr>        
                                <td>{{$data->name ?? ''}}</td>    
                                <td align="right">{{number_format($data->amount,2) ?? '0'}}/-</td>
                              </tr>
                              @endforeach 
                              <tr><th>Total:</th><th  align="right">{{number_format($totalExpanse,2) ?? '0'}}/-</th></tr>
                              @endif 
                            </tbody>
                             </table>
                        </div>                     
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    <!-- /.modal end -->