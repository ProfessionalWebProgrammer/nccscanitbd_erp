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
                      <h5 class="text-uppercase font-weight-bold">Company Summary Report</h5>
                      <p>From {{date('d F, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                      <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>


                <div class="py-4">
                    <div class="py-4 col-md-8 m-auto table-responsive">


                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 6;table-layout: inherit;">
                            <thead>
                                <tr>
                                    <th>Head </th>
                                    <th align="right">Debit</th>
                                    <th align="right">Credit</th>

                                </tr>
                            </thead>
                        <tbody>
                                 @php
                                    $totaldebit = 0;
                                    $totalcredit = 0;
                                @endphp
                                <tr>
                                    @php
                                       $totaldebit += $data['purchase_amount'];
                                    $totalcredit += 0;
                                     @endphp
                                    <td>Purchase Amount</td>
                                    <td align="right">{{ number_format($data['purchase_amount'], 2) }}</td>
                                   <td align="right">0</td>

                                </tr>


                           <tr>
                                    @php
                                           $totaldebit += 0;
                                    $totalcredit += $data['payment_amount'];
                                     @endphp
                                    <td>Payment Amount</td>
                             		<td align="right">0</td>
                                    <td align="right">{{ number_format($data['payment_amount'], 2) }}</td>

                                </tr>

                           		<tr>
                                    @php
                                          $totaldebit += $data['purchase_amount'] - $data['payment_amount'];
                                    $totalcredit += 0;
                                     @endphp
                                    <td>Current Liability Amount</td>
                                    <td align="right">{{ number_format($data['purchase_amount'] - $data['payment_amount'], 2)  }}</td>
                                  	<td align="right">0</td>

                                </tr>
                          <tr>
                                    @php
                                          $totaldebit += $data['general_purchase_amount'] + $data['assets_amount'] ;
                                    $totalcredit += 0;
                                     @endphp
                                    <td>Total Liability Amount</td>
                                    <td align="right">{{ number_format($data['general_purchase_amount'] + $data['assets_amount'], 2)  }}</td>
                            	<td align="right">0</td>

                                </tr>



                          		<tr>
                                    @php
                                             $totaldebit += $data['expanse_amount']  ;
                                    $totalcredit += 0;
                                     @endphp
                                    <td>Expanse Amount</td>

                                    <td align="right">{{ number_format($data['expanse_amount'], 2) }}</td>
                                  <td align="right">0</td>

                                </tr>

                            <tr>
                                    @php
                                             $totaldebit += 0  ;
                                    $totalcredit += $data['sales_amount'];
                                     @endphp
                                    <td>Sales Amount</td>
                              <td align="right">0</td>
                                    <td align="right">{{ number_format($data['sales_amount'], 2) }}</td>

                                </tr>

                           		<tr>
                                    @php
                                        $totaldebit += $data['receive_amount']  ;
                                    $totalcredit += 0;
                                     @endphp
                                    <td>Receive Amount</td>
                                    <td align="right">{{ number_format($data['receive_amount'], 2) }}</td>
                                  <td align="right">0</td>

                                </tr>


                           		<tr>
                                    @php
                                          $totaldebit += 0  ;
                                    $totalcredit += $data['sales_amount'] - $data['receive_amount'];
                                     @endphp
                                    <td>Market Due Amount</td>
                                  <td align="right">0</td>
                                    <td align="right">{{ number_format($data['sales_amount'] - $data['receive_amount'], 2) }}</td>
                                </tr>
                           		<tr>
                                    @php
                                          $totaldebit += $data['receive_amount'] - $data['payment_amount']  ;
                                    $totalcredit += 0;
                                     @endphp
                                    <td>Cash In Hand Amount</td>
                                    <td align="right">{{ number_format($data['receive_amount'] - $data['payment_amount'], 2) }}</td>
                                  <td align="right">0</td>
                                </tr>
                            </tbody>

                            <tfoot>
                              <tfoot>
                                <tr style="color:red">
                                    <th>Total</th>
                                    <td align="right">{{ number_format($totaldebit, 2) }}</td>
                                    <td align="right">{{ number_format($totalcredit, 2) }}</td>

                                </tr>

                            </tfoot>

                            </tfoot>
                        </table>
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
                filename: "Company_summary_report.xls"
            });
        });
    });
</script>
@endsection
