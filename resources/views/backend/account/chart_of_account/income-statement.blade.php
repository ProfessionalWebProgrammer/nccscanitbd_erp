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

            <div class="container" id="contentbody">
 				<div class="row pt-5">
                  	<div class="col-md-12 pt-3 text-center">
                        <h5 class="text-uppercase font-weight-bold">Income Statement</h5>
                        <p>{{date('d F, Y',strtotime($tdate))}}</p>
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
              <hr>

                <div class="py-4 ">
				<div class="row">
                    <div class="col-md-12 table-responsive">
                        <table id="reporttable" class="table table-bordered table-fixed"
                            style="font-size: 6;table-layout: inherit;">
                            <thead style="background:orangered;" class="text-center">
                                 <th width="70%">Head</th>
                                 <th width="30%">Amount</th>
                            </thead>
                            <tbody>
                                @php
                                    $grossProfit = $assetData['sales'] - $assetData['cogs'];
                                    $netprofit = $grossProfit - $assetData['totalExpenses'];
                                @endphp
                                <tr>
                                    <td>Sales</td>
                                    <td class="text-center " >{{ $assetData['sales'] }}</td>
                                </tr>
                                <tr>
                                    <td>Costs of Goods Sold (Cogs)</td>
                                    <td class="text-center">{{ $assetData['cogs'] }}</td>
                                </tr>
                                <tr class="table-warning">
                                    <td  style="color:blue;font-size:17px">Gross Profit</td>
                                    <td class="text-right">{{ $grossProfit }} /-</td>
                                </tr>
                                <tr class="table-primary">
                                    <td style="color:red;font-size:17px" colspan="2"><strong>Operating Expanses</strong></td>
                                </tr>
                                @foreach ( $assetData['expenseInfo'] as $key => $val)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td class="text-center">{{ $val }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td>Depreciation Expense</td>
                                    <td class="text-center">{{ number_format($assetData['totalDepreciationExpense']) }}</td>
                                </tr>
                                <tr class="table-danger">
                                    <td style="color:red;">Total of Operating Expenses</td>
                                    <td class="text-right">{{ $assetData['totalExpenses'] }} /-</td>
                                </tr>
                                <tr class="table-warning">
                                    <td style="color:indigo;">Operating Profit</td>
                                    <td class="text-right">{{ number_format($grossProfit - $assetData['totalExpenses']) }} /-</td>
                                </tr>
                                <tr class="table-primary">
                                    <td style="color:red;font-size:17px" colspan="2"><strong>Others Income</strong></td>
                                </tr>
                                <tr>
                                    <td>Total Income</td>
                                    <td class="text-center">0.00</td>
                                </tr>
                                <tr class="table-primary">
                                    <td style="color:red;font-size:17px" colspan="2"><strong>Financial Expense</strong></td>
                                </tr>
                                <tr>
                                    <td>Taxes</td>
                                    <td class="text-center">% (0.00)</td>
                                </tr>
                               
                               
                            </tbody>

                            <tfoot>
                                <tr style="background: #c641cf; color:#f5f5f5; font-weight:bold;">
                                    <th>Net Profit</th>
                                    <td align="right">{{ $netprofit }} /-</td>
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
