@extends('layouts.sales_dashboard')

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


@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="contentbody">


        <!-- Main content -->
        <div class="content px-4 ">
          	<div class="row pt-2">
                  	<div class="col-md-12 text-right">
                      	<button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                    </div>
                </div>

            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="py-4">

                  <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Sales C.O.G.S Report</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>

                    <div class="py-4 col-md-8 m-auto table-responsive">
                        <table id="" class="table table-bordered table-striped table-fixed"
                            style="font-size: 6;table-layout: inherit;">
                            <thead>
                                <tr>
                                    <th>Head </th>
                                    <th>Amount</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Product Name</td>
                                    <td>{{ $productname }}</td>

                                </tr>

                                <tr>
                                    <td>Opening Balance</td>
                                    <td>{{ number_format($openingbalance,2) }}</td>

                                </tr>

                                <tr>
                                    <td>Stock Value</td>
                                    <td>{{ number_format($todaystock,2) }}</td>

                                </tr>
                                <tr>
                                    <td>Closing Balance </td>
                                    <td>{{ number_format($clsingbalance,2) }}</td>

                                </tr>
                                <tr style="font-weight: bold">
                                    <td>Used Value</td>
                                    <td>{{ number_format($openingbalance + $todaystock - $clsingbalance,2) }}</td>

                                </tr>


                                <tr>
                                    <td>Direct Labor Cost </td>
                                    <td>{{ number_format($dir_labor,2) }}</td>

                                </tr>
                                <tr>
                                    <td>Indirect Cost </td>
                                    <td>{{ number_format($ind_labor,2) }}</td>

                                </tr>



                            </tbody>

                            <tfoot>
                                <tr style="color:red">
                                    <th>C.O.G.S.</th>
                                    <th>{{ number_format(($openingbalance + $todaystock - $clsingbalance)+($dir_labor+$ind_labor),2) }}</th>

                                </tr>

                            </tfoot>




                        </table>
                    </div>
                    {{-- <table id="" class="table table-bordered table-striped mt-4" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>Product Name</th>
                                <th>Wirehouse</th>
                                <th>Opening</th>
                                <th>Purchase</th>
                                <th>Closing</th>
                                <th>Used</th>
                                <th>Direct Labor </th>
                                <th>Indirect Cost </th>
                                <th>C.O.G.S. </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-left">{{ $productname }}</td>
                                <td class="text-left">{{ $factories,2 }}</td>
                                <td class="text-right">{{ number_format($openingbalance,2) }}</td>
                                <td class="text-right">{{ number_format($todaystock,2) }}</td>
                                <td class="text-right">{{ number_format($clsingbalance,2) }}</td>
                                <td class="text-right">{{ number_format($openingbalance + $todaystock - $clsingbalance,2) }}</td>
                                <td class="text-right">{{ number_format($dir_labor,2) }}</td>
                                <td class="text-right">{{ number_format($ind_labor,2) }}</td>
                                <td>0</td>
                            </tr>
                        </tbody>
                    </table> --}}
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
                filename: "DailySalesReport.xls"
            });
        });
    });
</script>

@endsection
