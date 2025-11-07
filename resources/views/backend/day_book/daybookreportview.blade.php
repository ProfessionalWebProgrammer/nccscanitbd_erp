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

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h4 class="text-uppercase font-weight-bold">Day Book View</h4>
                        <h6 class="text-uppercase font-weight-bold">{{$tdate}}</h6>
                        <hr style="background: #ffffff78;">
                    </div>

                    <div class="py-4 col-md-8 m-auto table-responsive">
                        <table id="" class="table table-bordered table-striped table-fixed"
                            style="font-size: 6;table-layout: inherit;">
                            <thead>
                                <tr style="background: antiquewhite;">
                                    <th class="text-center">Head </th>
                                    <th class="text-center">Debit</th>
                                    <th class="text-center">Credit</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sales Amount</td>
                                  	<td align="right">0</td>
                                    <td align="right">{{number_format($totalsalesamount)}}</td>

                                </tr>
                              	<tr>
                                    <td>Sales Return Amount</td>
                                    <td align="right">{{number_format($totalsalesreturnamount)}}</td>
                                    <td align="right">0</td>
                                </tr>
                                <tr>
                                    <td>Purchase Amount</td>
                                    <td align="right">{{number_format($totalpurchase)}}</td>
                                    <td align="right">0</td>
                                </tr>
                               	<tr>
                                    <td>Purchase Bag Amount</td>
                                    <td align="right">{{number_format($totalpurchaseinbag)}}</td>
                                    <td align="right">0</td>
                                </tr>
								<tr>
                                    <td>Purchase Return Amount</td>
                                    <td align="right">0</td>
                                    <td align="right">{{number_format($purchasereturn)}}</td>
                                </tr>
                             	<tr>
                                    <td>General Purchase Amount</td>
                                    <td align="right">{{number_format($generalpurchase)}}</td>
                                    <td align="right">0</td>
                                </tr>
                              	<tr>
                                    <td>Bank Received Amount</td>
                                    <td align="right">{{number_format($bankreceivedamount)}}</td>
                                    <td align="right">0</td>
                                </tr>
                              	<tr>
                                    <td>Bank Payment Amount</td>
                                  	<td align="right">0</td>
                                    <td align="right">{{number_format($bankpaymentamount)}}</td>
                                </tr>
                                <tr>
                                    <td>Cash Received Amount</td>
                                  	<td align="right">{{number_format($cashreceivedamount)}}</td>
                                    <td align="right">0</td>
                                </tr>
                              	<tr>
                                    <td>Cash Payment Amount</td>
                                  	<td align="right">0</td>
                                    <td align="right">{{number_format($cashpaymentamount)}}</td>
                                </tr>
                               <tr>
                                    <td>General Bank Received Amount</td>
                                  	<td align="right">{{number_format($generalbankpaymentreceive)}}</td>
                                    <td align="right">0</td>
                                </tr>
                              	<tr>
                                    <td>General Cash Received Amount</td>
                                  	<td align="right">{{number_format($generalcashpaymentreceive)}}</td>
                                    <td align="right">0</td>
                                </tr>
                               <tr>
                                    <td>Transfer Amount</td>
                                  	<td align="right">{{number_format($trnasferreceiveamount)}}</td>
                                    <td align="right">{{number_format($trnasferpyamentamount)}}</td>
                                </tr>
								<tr>
                                    <td>Expance Amount</td>
                                  	<td align="right">{{number_format($totalexpance)}}</td>
                                    <td align="right">0</td>
                                </tr>
                              	<tr>
                                    <td>Asset Amount</td>
                                  	<td align="right">{{number_format($totasset)}}</td>
                                    <td align="right">{{number_format($totassetpayment)}}</td>
                                </tr>
                              	<tr>
                                    <td>Joural Amount</td>
                                  	<td class="text-right">{{number_format($journaldramount)}}</td>
                                    <td class="text-right">{{number_format($journalcramount)}}</td>
                                </tr>



                            </tbody>

                            <tfoot>
								<tr style="background: antiquewhite;">
                                    <th>Total</th>
                                  	<th class="text-right">{{number_format($generalbankpaymentreceive+$generalcashpaymentreceive+$totalsalesreturnamount+$totalpurchase+$totalpurchaseinbag+$generalpurchase+$bankreceivedamount+$cashreceivedamount+$totalexpance+$totasset+$journaldramount)}}</th>
                                    <th class="text-right">{{number_format($totalsalesamount+$purchasereturn+$bankpaymentamount+$cashpaymentamount+$totassetpayment+$journalcramount)}}</th>
                                </tr>
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
@endsection
