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
									// $totalca +=  ($data['bank_receive_amount'] + $data['cash'] + $data['bank_transfer_amount'] + $data['bank_open']+$data['otherIncome']) - ($data['payment_amount']+$data['bank_transfer_payment']+$data['expanse_amount_bank']+$data['loan_amount']+ $data['bank_overderft']+$data['borrow_from']+$data['non_borrow']+$data['lease']);
                                  		$totalca += $totalBankCash - ($loan_amount+ $data['bank_overderft']+$data['borrow_from']+$data['non_borrow']+$data['lease']);
                                     @endphp
                                    <td>Cash Amount & Equivalents </td>
                                     <td align="right">{{ number_format($totalBankCash - ($loan_amount+ $data['bank_overderft']+$data['borrow_from']+$data['non_borrow']+$data['lease']),2) }}</td>

                                </tr>
                                <tr>
                                    @php
                                  $totalca += $accountRece;
                                     @endphp
                                    <td>Account Receiveable </td>
                                    <td align="right">{{ number_format($accountRece,2) }}</td>
                                </tr>


                               <tr>
                                     @php
                                  $totalca += $inventory;
                                     @endphp
                                    <td>Inventory</td>
                                    
                                 	<td align="right">{{ number_format($inventory,2) }}</td>
                                 	{{-- <td align="right">{{$data['inventory_purchase']}}</td> --}}
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


                              @if($data['asset_depreciations'])
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
                                    <td>Intengibles Assets</td>
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
                                  $totalcl +=  $purchase_amount;
                                  $totalliability +=  $data['purchase_amount'] - $data['supplier_payment_amount'];
                                     @endphp
                                    <td>Account Payable</td>
                                     <td align="right">{{ number_format($data['purchase_amount'] - $data['supplier_payment_amount'],2)}}</td>

                                </tr>
                            	<tr>
                                    @php
                                    $totalcl +=  $data['bank_transfer_amount'] + $data['shimul_amount'] - $data['bank_transfer_payment'];
                                    $totalliability +=  $data['bank_transfer_amount'] + $data['shimul_amount'] - $data['bank_transfer_payment'];
                                     @endphp
                                    <td>Current Liabilities (Inter Company)</td>
                                     <td align="right">{{ number_format(($data['bank_transfer_amount'] + $data['shimul_amount'] - $data['bank_transfer_payment']),2)}}</td>
                                </tr>

                             <tr>
                                    @php
                                  $totalcl += $data['bank_overderft'];
                             	  $totalliability +=  $data['bank_overderft'];
                                     @endphp
                                    <td>Bank OverDraft</td>
                                     <td align="right">{{number_format($data['bank_overderft'],2)}}</td>

                                </tr>
                             <tr>
                                    @php
                                  $totalcl += $data['loan_amount'];
                             	  $totalliability +=  $data['loan_amount'];
                                     @endphp
                                    <td>Loan </td>
                                     <td align="right">{{number_format($data['loan_amount'],2)}}</td>

                                </tr>

                            <tr>
                                    @php
                                  $totalcl += $data['borrow_from'];
                             	  $totalliability +=  $data['borrow_from'];
                                     @endphp
                                    <td> Borrowing</td>
                                     <td align="right">{{number_format($data['borrow_from'],2)}}</td>

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
                                  $totalcl += $data['bad_debt_amount'];
                             $totalliability +=  $data['bad_debt_amount'];
                                     @endphp
                                    <td>Bad Debt Amount</td>
                                     <td align="right">{{number_format($data['bad_debt_amount'],2)}}</td>

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
                                  $totaldebt += $data['non_borrow'];
                                $totalliability +=  $data['non_borrow'];
                             	      @endphp
                                    <td> Borrowing</td>
                                     <td align="right">{{number_format($data['non_borrow'],2)}}</td>

                                </tr>

                             <tr>
                                    @php
                                  $totaldebt += $data['lease'];
                                $totalliability +=  $data['lease'];
                             	      @endphp
                                    <td> Lease</td>
                                     <td align="right">{{number_format($data['lease'],2)}}</td>
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
                         {{-- @foreach($data['equitiy'] as $item)
                                <tr>
                                    @php
                                  $totaleq += $item->amount;
                                  $totalliability +=  $item->amount;
                                     @endphp
                                    <td>{{$item->name}}</td>
                                     <td align="right">{{number_format($item->amount,2)}}</td>
                                </tr>
                          @endforeach --}}
                            <tr style="font-weight:bold">
                                     <td colspan="100%">Retained Earning</td>
                                     @php
                                     $totalrte = 0 ;
                                     @endphp
                                </tr>
                            <tr>
                                    @php
                                  $totalrte +=  $data['sales_amount'];
                                     @endphp
                                    <td>Sales Revenues</td>
                                     <td align="right">{{ number_format($data['sales_amount'],2)}}</td>

                                </tr>
                             <tr>
                                    @php
                                  $totalrte +=  $data['otherIncome'];
                                     @endphp
                                    <td>Others Income</td>
                                     <td align="right">{{ number_format($data['otherIncome'],2)}}</td>
                                </tr>
                            <tr>
                                    @php
                                  	$totalrte -=  $cogs;
                                    @endphp
                                    <td>C.O.G.S </td>
                                     <td align="right">{{ number_format($cogs,2)}}</td>
                                </tr>
                            <tr>
                                    @php
                                  $totalrte -=  $data['expanse_amount'];
                                     @endphp
                                    <td>Expanse</td>
                                     <td align="right">{{ number_format($data['expanse_amount'],2)}}</td>
                                </tr>

                             <tr>


                               <tr style="font-weight:bold">
                                   <td>Total Retained Earning</td>
                                    <td align="right">{{number_format($totalrte,2)}}</td>
                                </tr>
                               <tr>
                                  <td>Tax Payable</td>
                                  @php
                                  $totalrte -=  $data['taxtamount'] - $cogs;
                                     @endphp
                                     <td align="right">{{number_format($data['taxtamount'] - $cogs ,2) ?? 0}}</td>

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
                                  $totaleq += $data['assets_investment'];
                                  $totalliability += $data['assets_investment'];

                                     @endphp
                                    <td>Investments</td>
                                    <td align="right">{{number_format($data['assets_investment'],2)}}</td>

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
