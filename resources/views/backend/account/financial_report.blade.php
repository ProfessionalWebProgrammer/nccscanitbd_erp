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
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                    </div>
                </div>

            <div class="container-fluid" id="contentbody">



 				<div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Financial Report</h5>
                      <p>{{date('d F, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                      <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
              <hr>

                <div class="py-4 ">

				<div class="row">
                    <div class=" col-md-6 table-responsive  m-auto">
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


                              <tr style="font-weight:bold;color:red">
                                     <td colspan="100%">Non Current Assets</td>


                                </tr>
                              <tr>
                                    @php
                                  $totalfa = $data['assets_amount'];
                                     @endphp
                                    <td>Property, Plant & Equipment </td>
                                     <td align="right">{{number_format($data['assets_amount'], 2)}}</td>

                                </tr>


                         {{--     @if($data['asset_depreciations'])
                               <tr style="font-weight:bold">
                                    <td colspan="100%">Depreciation Amount </td>

                                </tr>
                              @php
                              $tpped = 0;
                              @endphp
                              @foreach($data['asset_depreciations'] as $item)
                             	 <tr>
                                      @php
                                     $tpped += $item->yearly_amount;
                                  $totalfa -= $item->yearly_amount;
                                     @endphp
                                    <td style="padding-left:30px">{{$item->asset_head}}-{{$item->product_name}}</td>
                                    <td align="right">{{$item->yearly_amount}}</td>

                                </tr>
                              @endforeach
                              <tr style="font-weight:bold">
                                   <td>Total  Depreciation Amount</td>
                                    <td align="right">{{$tpped}}</td>

                                </tr>
                              @endif

                              <tr style="font-weight:bold">
                                   <td>Total Non Current Asset After Depreciation</td>
                                    <td align="right">{{$totalfa}}</td>

                                </tr>
                              --}}

                                <tr>
                                    @php
                                  $totalfa += $data['assets_intangible'];
                                     @endphp
                                    <td>Intengibles Assets</td>
                                    <td align="right">{{number_format($data['assets_intangible'], 2)}}</td>

                                </tr>

                               <tr style="font-weight:bold">
                                   <td>Total Non Current Asset</td>
                                    <td align="right">{{number_format($totalfa, 2)}}</td>

                                </tr>


                              <tr style="font-weight:bold;color:red">
                                     <td colspan="100%">Other Assets</td>


                                </tr>
                              @foreach($data['expanse_type'] as $dataex)
                                <tr>
                                       <td>{{$dataex->title}}</td>
                                     <td align="right">{{number_format($dataex->amount, 2)}}</td>

                                </tr>

                              @endforeach

                              <tr>
                                       <td>Research and Development</td>
                                     <td align="right">0</td>

                                </tr>


                                @php
                                    $totalca = 0;
                                    $totalamount = 0;
                                 @endphp

  								<tr style="font-weight:bold;color:red">
                                     <td colspan="100%">Current Assets</td>


                                </tr>
                                <tr>
                                     @php
                                  $totalca += $data['inventory_sales']+$data['inventory_purchase'];
                                     @endphp
                                    <td>Inventory</td>
                                    <td align="right">{{number_format($data['inventory_sales']+$data['inventory_purchase'], 2)}}</td>

                                </tr>

                               <tr>
                                    @php
                                  $totalca += $data['sales_amount'] - $data['receive_amount'];
                                     @endphp
                                    <td>Account Receiveable</td>
                                    <td align="right">{{ number_format($data['sales_amount'] - $data['receive_amount'], 2) }}</td>

                                </tr>






                                <tr>
                                    @php
                                  $totalca +=  $data['receive_amount']-$data['payment_amount']+$data['borrow_from']+$data['non_borrow'];
                                     @endphp
                                    <td>Cash Amount & Equivalents</td>
                                     <td align="right">{{ number_format($data['receive_amount']-$data['payment_amount']+$data['borrow_from']+$data['non_borrow'], 2) }}</td>

                                </tr>


                               @foreach($data['assets_type'] as $dataex)
                                <tr>
                                       <td>{{$dataex->asset_type_name}}</td>
                                     <td align="right">{{number_format($dataex->asset_value, 2)}}</td>

                                </tr>

                              @endforeach




                               <tr>
                                    @php
                                   $totalca += $data['loan_amount'];

                                     @endphp
                                    <td>Loan Receivable</td>
                                     <td align="right">{{number_format($data['loan_amount'], 2)}}</td>

                                </tr>


                              <tr style="font-weight:bold">
                                   <td>Total Current Asset</td>
                                    <td align="right">{{number_format($totalca, 2)}}</td>

                                </tr>

                            </tbody>

                            <tfoot>
                                <tr style="color:red">
                                    <th>Total</th>
                                    <td align="right">{{number_format($totalfa+$totalca, 2) }}</td>

                                </tr>

                            </tfoot>




                        </table>



                      <h5>Equity and Liabilities </h5>
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
                          $totalliability = 0;
                          @endphp

                              <tr style="font-weight:bold;color:red">
                                     <td colspan="100%">Equity</td>

                                     @php
                                  $totaleq = 0 ;
                                     @endphp


                                </tr>




                          @foreach($data['equitiy'] as $item)
                                <tr>
                                    @php
                                  $totaleq += $item->amount ;
                                  $totalliability +=  $item->amount ;
                                     @endphp
                                    <td>{{$item->name}}</td>
                                     <td align="right">{{number_format($item->amount, 2)}}</td>

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
                                  $totalrte +=  $data['sales_amount'];
                                     @endphp
                                    <td>Sales Revenues</td>
                                     <td align="right">{{ number_format($data['sales_amount'], 2)}}</td>

                                </tr>
                            <tr>
                                    @php
                                  $totalrte -=  $data['cogs'];
                                     @endphp
                                    <td>C.O.G.S</td>
                                     <td align="right">{{ number_format($data['cogs'], 2)}}</td>

                                </tr>
                            <tr>
                                    @php
                                  $totalrte -=  $data['expanse_amount'];
                                     @endphp
                                    <td>Expanse</td>
                                     <td align="right">{{ number_format($data['expanse_amount'], 2)}}</td>

                                </tr>

                             <tr>


                               <tr style="font-weight:bold">
                                   <td>Total Retained Earning</td>
                                    <td align="right">{{number_format($totalrte, 2)}}</td>


                                </tr>
                               <tr>
                                  <td>Tax Payable</td>
                                  @php
                                  $totalrte -=  $data['taxtamount'];
                                     @endphp
                                     <td align="right">{{number_format($data['taxtamount'], 2)}}</td>

                                </tr>

                              <tr style="font-weight:bold">
                                   <td>Total Retained Earning After Tax</td>
                                    <td align="right">{{number_format($totalrte, 2)}}</td>
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
                                    <td align="right">{{number_format($data['assets_investment'], 2)}}</td>

                                </tr>




                               <tr style="font-weight:bold">
                                   <td>Total Equity</td>
                                    <td align="right">{{number_format($totaleq, 2)}}</td>

                                </tr>


                                                       <tr style="font-weight:bold">
                                     <td colspan="100%"></td>

                               </tr>


                          <tr style="font-weight:bold;color:red">
                                     <td colspan="100%">Non Current Liabilities</td>

                                     @php
                                  $totaldebt = 0 ;
                                     @endphp


                                </tr>
                                <tr>
                                    @php
                                  $totaldebt += $totalfa - $data['assets_intangible'];
                                  $totalliability += $totalfa - $data['assets_intangible'];
                                     @endphp
                                    <td>Long Term Debts (Non Current Assets)</td>
                                     <td align="right">{{ number_format($totalfa - $data['assets_intangible'], 2)}}</td>

                                </tr>

                             <tr>
                                    @php
                                  $totaldebt += $data['non_borrow'];
                                $totalliability +=  $data['non_borrow'];
                             	      @endphp
                                    <td> Borrowing</td>
                                     <td align="right">{{number_format($data['non_borrow'], 2)}}</td>

                                </tr>

                             <tr>
                                    @php
                                  $totaldebt += $data['lease'];
                                $totalliability +=  $data['lease'];
                             	      @endphp
                                    <td> Lease</td>
                                     <td align="right">{{number_format($data['lease'], 2)}}</td>

                                </tr>


                               <tr style="font-weight:bold;color:red">
                                   <td>Total Non Current Liabilities</td>
                                    <td align="right">{{number_format($totaldebt, 2)}}</td>

                                </tr>

                           <tr style="font-weight:bold;color:red">
                                     <td colspan="100%">Current Liabilities</td>

                                </tr>
                                <tr>
                                    @php
                                  $totalcl =  $data['purchase_amount'] - $data['payment_amount'];
                                  $totalliability +=  $data['purchase_amount'] - $data['payment_amount'];
                                     @endphp
                                    <td>Account Payable</td>
                                     <td align="right">{{ number_format($data['purchase_amount'] - $data['payment_amount'], 2)}}</td>

                                </tr>
                             <tr>
                                    @php
                                  $totalcl += $data['bank_overderft'];
                             	  $totalliability +=  $data['bank_overderft'];
                                     @endphp
                                    <td>Bank OverDraft</td>
                                     <td align="right">{{number_format($data['bank_overderft'], 2)}}</td>

                                </tr>
                             <tr>
                                    @php
                                  $totalcl += $data['loan_amount'];
                             	  $totalliability +=  $data['loan_amount'];
                                     @endphp
                                    <td>Loan </td>
                                     <td align="right">{{number_format($data['loan_amount'], 2)}}</td>

                                </tr>

                            <tr>
                                    @php
                                  $totalcl += $data['borrow_from'];
                             	  $totalliability +=  $data['borrow_from'];
                                     @endphp
                                    <td> Borrowing</td>
                                     <td align="right">{{number_format($data['borrow_from'], 2)}}</td>

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
                                  $totalcl += $data['ltrs'];
                             $totalliability +=  $data['ltrs'];
                                     @endphp
                                    <td>LTR</td>
                                     <td align="right">{{number_format($data['ltrs'], 2)}}</td>

                                </tr>
                             <tr>
                                    @php
                                  $totalcl += $data['bad_debt_amount'];
                             $totalliability +=  $data['bad_debt_amount'];
                                     @endphp
                                    <td>Bad Debt Amount</td>
                                     <td align="right">{{number_format($data['bad_debt_amount'],2)}}</td>

                                </tr>



                               <tr style="font-weight:bold">
                                   <td>Total Current Liabilities</td>
                                    <td align="right">{{number_format($totalcl,2)}}</td>

                                </tr>



 						 </tbody>

                           <tfoot>
                                <tr style="color:red">
                                    <th>Total</th>
                                    <td align="right">{{ number_format($totalliability,2) }}</td>

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
