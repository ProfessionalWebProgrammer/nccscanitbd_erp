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
				<div class="text-right">
                      	<button class="btn btn-xs  btn-success mr-1 mt-2" id="btnExport"  >
                       Export
                    </button>
                    <button class="btn btn-xs  btn-warning mt-2"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                    </div>
            </li>


@endsection

@section('content')
   
      

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >

        <!-- Main content -->
        <div class="content px-4 ">

            <div class="container-fluid" id="contentbody">
 				<div class="row pt-5">
                  	<div class="col-md-3 text-left">
                      <h5 class="text-uppercase font-weight-bold">Balance Sheet</h5>
                      <p>{{date('d F, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-6 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
              <hr>

                <div class="py-4 ">
				<div class="row">
                    <div class=" col-md-6 table-responsive">
                      <h5>Assets</h5>
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 6;table-layout: inherit;">
                            <thead>
                                <tr>
                                    <th>Head </th>
                                    <th align="right">Amount</th>
                                </tr>
                          </thead>
                            <tbody>
                                @php
                                    $totalca = 0;
                                    $totalamount = 0;
                                 @endphp

  								<tr >
                                     <td colspan="2">Current Assets</td>
                                </tr>
                                <tr>
                                  <!-- here calculate only bank amount + $data['cash_open'] -->
                                    @php
									// $totalca +=  ($data['bank_receive_amount'] + $data['cash'] + $data['bank_transfer_amount'] + $data['bank_open']) - ($data['payment_amount']+$data['bank_transfer_payment']+$data['expanse_amount_bank']+$data['loan_amount']+ $data['bank_overderft']+$data['borrow_from']+$data['non_borrow']+$data['lease']);
                                  		$totalca += $totalBankCash - ($loan_amount+ $bank_overderft+$borrow_from+$non_borrow+$lease);
                                     @endphp
                                    <td>Cash Amount & Equivalents </td>
                                     <td align="right">{{ number_format($totalBankCash - ($loan_amount+ $bank_overderft+$borrow_from+$non_borrow+$lease),2) }}</td>

                                </tr>
                                <tr>
                                    @php
                                  $totalca += $accountRece + $data['bankCharge_amount'];
                                     @endphp
                                    <td>Account Receiveable</td>
                                    <td align="right">{{ number_format(($accountRece + $data['bankCharge_amount']),2) }}</td>
                                </tr>

                               <tr>
                                     @php
                                  $totalca += $inventory;
                                  //$totalca += $purchaseamount - $totalPurchaseOut;
                                     @endphp
                                    <td>Inventory</td>
                                 <td align="right">{{ number_format($inventory,2) }}</td>
                        
                                 {{-- <td align="right">{{ number_format(($purchaseamount - $totalPurchaseOut),2) }}</td>
                                 	 
                                 	 <td align="right">{{$data['inventory_purchase']}}</td> --}}
                                </tr>
                             {{-- <tr>
                                @php
                                $totalca += $data['purchase_amount'];
                                @endphp
                                <td>Inventory</td>
                                <td align="right">{{$data['purchase_amount']}}</td>
                              </tr> --}}
                               <tr>
                                    @php
                                   		$totalca += $loan_amount;
                                     @endphp
                                    <td>Loan Receivable</td>
                                     <td align="right">{{number_format($loan_amount,2)}}</td>

                                </tr>


                              <tr style="font-weight:bold; font-size: 20px; color:#ed0b0b;">
                                   <td>Total Current Asset</td>
                                   <td align="right">{{number_format($totalca,2)}}</td>
                                </tr>

                              <tr>
                                     <td colspan="100%">Non Current Assets</td>
                                </tr>
                              <tr>
                                    @php
                                  $totalfa = $assets_amount;
                                     @endphp
                                    <td>Property, Plant & Equipment </td>
                                     <td align="right">{{number_format($assets_amount,2)}}</td>

                                </tr>


                              @if($asset_depreciations)
                               <tr style="font-weight:bold">
                                    <td colspan="100%">Depreciation Amount </td>
                                </tr>
                              @php
                              $tpped = 0;
                              @endphp
                              @foreach($asset_depreciations as $item)
                             	 <tr>
                                      @php
                                     $tpped += $item->yearly_amount;
                                  $totalfa -= $item->yearly_amount;
                                     @endphp
                                    <td style="padding-left:30px">{{$item->asset_head}}-{{$item->product_name}}</td>
                                    <td align="right">{{number_format($item->yearly_amount,2)}}</td>

                                </tr>
                              @endforeach
                              <tr style="font-weight:bold">
                                   <td>Total  Depreciation Amount</td>
                                    <td align="right">{{number_format($tpped,2)}}</td>

                                </tr>
                              @endif

                              <tr style="font-weight:bold">
                                   <td>Total Non Current Asset After Depreciation</td>
                                    <td align="right">{{number_format($totalfa,2)}}</td>

                                </tr>


                                <tr>
                                    @php
                                  $totalfa += $assets_intangible;
                                     @endphp
                                    <td>Intangibles Assets</td>
                                    <td align="right">{{number_format($assets_intangible,2)}}</td>

                                </tr>

                               <tr style="font-weight:bold">
                                   <td>Total Non Current Asset</td>
                                    <td align="right">{{number_format($totalfa,2)}}</td>
                                </tr>

                            </tbody>

                            <tfoot>
                                <tr style="background: #c641cf; color:#f5f5f5; font-weight:bold;">
                                    <th>Total</th>
                                    <td align="right">{{ number_format($totalfa+$totalca,2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                   <div class=" col-md-6 table-responsive">
                      <h5>Liabilities And Equity</h5>
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 6;table-layout: inherit;">
                            <thead>
                                <tr>
                                    <th>Head </th>
                                    <th align="right">Amount</th>

                                </tr>
                          </thead>
                          <tbody>
                          @php
                            $totalcl = 0;
                          	$totalliability = 0;
                          @endphp

                           <tr >
                                     <td colspan="100%">Current Liabilities</td>

                                </tr>
                                <tr>
                                    @php
                                  $totalcl +=  $purchase_amount - $data['totalDamageVal'];
                                  $totalliability +=  $purchase_amount - $data['totalDamageVal'];
                                     @endphp
                                    <td>Account Payable</td>
                                     <td align="right">{{ number_format($purchase_amount - $data['totalDamageVal'],2)}}</td>

                                </tr>
                            	<tr>
                                    @php
                                    $totalcl +=  $laibilities;
                                    $totalliability +=  $laibilities;
                                     @endphp
                                    <td>Current Liabilities (Inter Company)</td>
                                     <td align="right">{{ number_format($laibilities,2)}}</td>
                                </tr>

                             <tr>
                                    @php
                                  $totalcl += $bank_overderft;
                             	  $totalliability +=  $bank_overderft;
                                     @endphp
                                    <td>Bank OverDraft</td>
                                     <td align="right">{{number_format($bank_overderft,2)}}</td>

                                </tr>
                             <tr>
                                    @php
                                  $totalcl += $loan_amount;
                             	  $totalliability +=  $loan_amount;
                                     @endphp
                                    <td>Loan </td>
                                     <td align="right">{{number_format($loan_amount,2)}}</td>

                                </tr>

                            <tr>
                                    @php
                                  $totalcl += $borrow_from;
                             	  $totalliability +=  $borrow_from;
                                     @endphp
                                    <td> Borrowing</td>
                                     <td align="right">{{number_format($borrow_from,2)}}</td>

                                </tr>
                          <tr>
                                    @php
                                  $totalcl +=  0;
                            $totalliability +=  0;
                                     @endphp
                                    <td>Notes Payable</td>
                                     <td align="right"></td>

                                </tr>
                            <tr>
                                    @php
                                  $totalcl += $bad_debt_amount;
                             $totalliability +=  $bad_debt_amount;
                                     @endphp
                                    <td>Bad Debt Amount</td>
                                     <td align="right">{{number_format($bad_debt_amount,2)}}</td>

                                </tr>



                               <tr style="font-weight:bold; font-size: 20px; color:#ed0b0b;">
                                   <td>Total Current Liabilities</td>
                                    <td align="right">{{number_format($totalcl,2)}}</td>

                                </tr>

                          <tr>
                                     <td colspan="100%">Non Current Liabilities</td>

                                     @php
                                  $totaldebt = 0 ;
                                     @endphp


                                </tr>
                                {{-- <tr>
                                    @php
                                  $totaldebt += $totalfa - $data['assets_intangible'];
                                  $totalliability += $totalfa - $data['assets_intangible'];
                                     @endphp
                                    <td>Long Term Debts (Non Current Assets)</td>
                                     <td align="right">{{ number_format($totalfa - $data['assets_intangible'],2)}}</td>

                                </tr> --}}

                             <tr>
                                    @php
                                  $totaldebt += $non_borrow;
                                $totalliability +=  $non_borrow;
                             	      @endphp
                                    <td> Borrowing</td>
                                     <td align="right">{{number_format($non_borrow,2)}}</td>

                                </tr>

                             <tr>
                                    @php
                                  $totaldebt += $lease;
                                $totalliability +=  $lease;
                             	      @endphp
                                    <td> Lease</td>
                                     <td align="right">{{number_format($lease,2)}}</td>
                                </tr>

                               <tr style="font-weight:bold">
                                   <td>Non Current Liabilities</td>
                                    <td align="right">{{number_format($totaldebt,2)}}</td>
                                </tr>
                           <tr>
                                     <td colspan="100%"></td>
                               </tr>
                          <tr>
                                     <td colspan="100%">Equity</td>

                                     @php
                                  $totaleq = 0 ;
                                     @endphp
                                </tr>
                          @foreach($equitiy as $item)
                                <tr>
                                    @php
                                  $totaleq += $item->amount;
                                  $totalliability +=  $item->amount;
                                     @endphp
                                    <td>{{$item->name}}</td>
                                     <td align="right">{{number_format($item->amount,2)}}</td>
                                </tr>
                          @endforeach
                            <tr style="font-weight:bold">
                                     <td colspan="100%">Retained Earning</td>
                                     @php
                                     $totalrte = 0 ;
                                     @endphp
                                </tr>
                            <tr>
                                    @php
                                  $totalrte +=  $sales_amount;
                                     @endphp
                                    <td>Sales Revenues</td>
                                     <td align="right">{{ number_format($sales_amount,2)}}</td>

                                </tr>
                             <tr>
                                    @php
                                  $totalrte +=  $otherIncome;
                                     @endphp
                                    <td>Others Income</td>
                                     <td align="right">{{ number_format($otherIncome,2)}}</td>
                                </tr>
                            <tr>
                                    @php
                                  	$totalrte -=  $cogs;
                                   //$totalrte -=  $totalPurchaseOut;
                                    @endphp
                                    <td>C.O.G.S </td>
                                    {{-- <td align="right">{{ number_format($totalPurchaseOut,2)}}</td> --}}
                            		  <td align="right">{{ number_format($cogs,2)}}</td> 
                                </tr>
                            <tr>
                                    @php
                                  $totalrte -=  $expanseAmountTotal;
                                     @endphp
                                    <td>Expanse</td>
                                     <td align="right">{{ number_format($expanseAmountTotal,2)}}</td>
                                </tr>

                             <tr>


                               <tr style="font-weight:bold">
                                   <td>Total Retained Earning</td>
                                    <td align="right">{{number_format($totalrte,2)}}</td>
                                </tr>
                               <tr>
                                  <td>Tax Payable</td>
                                  @php
                                  $totalrte -=  $taxtamount;
                                     @endphp
                                     <td align="right">{{number_format($taxtamount,2) ?? 0}}</td>

                                </tr>

                              <tr style="font-weight:bold;">
                                   <td>Total Retained Earning After Tax</td>
                                    <td align="right">{{number_format($totalrte,2)}}</td>
                                @php
                                  $totaleq +=  $totalrte;
                                  $totalliability +=  $totalrte;
                                     @endphp
                                </tr>

                               <tr>
                                      @php
                                  $totaleq += $assets_investment;
                                  $totalliability += $assets_investment;
                                     @endphp
                                    <td>Investments</td>
                                    <td align="right">{{number_format($assets_investment,2)}}</td>

                                </tr>

                               <tr style="font-weight:bold">
                                   <td>Total Equity</td>
                                    <td align="right">{{number_format($totaleq,2)}}</td>
                                </tr>
 						 </tbody>
                           <tfoot>
                                <tr style="background: #c641cf; color:#f5f5f5; font-weight:bold;">
                                    <th>Total: </th>
                                    <td align="right">{{number_format($totalliability,2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                  </div>

                </div>
            </div>
        </div>
    </div>
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
                filename: "Balance_sheet.xls"
            });
        });
    });
</script>

@endsection
