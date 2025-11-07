@extends('layouts.purchase_deshboard')

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
    <div class="content-wrapper" >


        <!-- Main content -->
        <div class="content px-4 ">
         <div class="row">
           		<div class="col-md-12 text-right">
                   {{-- <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >  Export   </button> --}}
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  > Print  </button>
                </div>
         </div>
            <div class="container-fluid" id="contentbody">
                <div class="text-center pt-3">
                    {{-- <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6> --}}
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  	<p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Purchase Invoice View</h5>
                   {{-- <h6 style="margin-top:5px; font-size:18px;font-weight: bold;">{{$purchase_details->supplier_name}}</h6> --}}
                </div>
                <div class="py-4">
                   
                    <div class="py-4 ">
                       <div class="row" style="margin-top:50px;">
                    
                            <div class="col-md-6" style=" height:auto">
                                <h6 style="margin-bottom:10px;"><b>Invoice No : {{$purchase_details->invoice}}</b></h6>
                                <h6 style="margin-bottom:10px;"><b>Date : {{ \Carbon\Carbon::parse($purchase_details->date)->format('d M Y')}}</b></h6>

                              
                                <h6 style="margin-bottom:15px;"><b>Warehouse : {{$purchase_details->factory_name}}</b></h6>
                              </div>
                            <div class="col-md-6">
                                <!--<h6 style="margin-bottom:10px;"><b>Truck No : 11.4910</b></h6>-->
                                <!--<h6 style="margin-bottom:10px;"><b>Product Type : House Hold</b></h6>-->
                            </div>
                        </div>
                  
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 6;table-layout: inherit;">
                           <thead>
                              <tr class="table-header-fixt-top">
                                <th>Product Name</th>
                                <th>Chalan Qty</th>
                                <th>Receive Qty</th>
                                <th>Deduction Qty</th>
                                <th>Inventory Receive</th>
                                <th>Bill Qty</th>
                                <th>Rate</th>
                                <th>Transport Vehicle</th>
                                <th>Transport Fare</th>
                                <th>Total Payable Amount</th>

                              </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>{{$purchase_details->product_name}}</td>
                                  <td>{{$purchase_details->supplier_chalan_qty}} KG</td>

                                  <td>{{$purchase_details->receive_quantity}} KG </td>
                              
                                  <td>{{$purchase_details->deduction_quantity}} KG</td>
                                  <td>{{$purchase_details->inventory_receive}} KG</td>
                                  <td>{{number_format($purchase_details->bill_quantity)}} KG</td>
                                  <td>{{$purchase_details->purchase_rate}} Tk</td>
                                  <td>{{$purchase_details->transport_vehicle}} </td>
                                  <td>{{number_format($purchase_details->transport_fare,2)}} Tk</td>
                                  <td>{{number_format($purchase_details->total_payable_amount,2)}} Tk</td>
                             
                            </tr>
                              </tbody>
                              <tfoot>
                          <tr>
                              
                              <td colspan="9">Total Amount: {{ convert_number($purchase_details->total_payable_amount).convert_paisa((string)$purchase_details->total_payable_amount) }}</td>
                              @if($purchase_details->receive_quantity > $purchase_details->supplier_chalan_qty)
                              <td>{{number_format((($purchase_details->supplier_chalan_qty-$purchase_details->deduction_quantity)*$purchase_details->purchase_rate)-$purchase_details->transport_fare)}} KG </td>
                              @else
                              <td>{{number_format($purchase_details->total_payable_amount,2)}} Tk</td>
                              @endif
                            </tr>
                              </tfoot>
                        </table>
                        @php 
                        $aditionalDatas = \App\Models\PurchaseLedger::select('purchase_ledgers.*', 'suppliers.supplier_name as name')->where('invoice_no',$purchase_details->invoice)
                                        ->leftjoin('suppliers', 'suppliers.id', '=', 'purchase_ledgers.supplier_id')->get();
                                        $total= 0; 
                        @endphp 
                        <table class="table table-bordered table-striped table-fixed mt-3 col-md-6">
                            <thead>
                                <tr>
                                    <th>Supplier Name</th>
                                    <th>Amount</th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                @foreach($aditionalDatas as $val)
                                @php
                               $total += $val->credit;
                                @endphp 
                                <tr>
                                    <td>{{$val->name}}</td>
                                    <td>{{number_format($val->credit,2)}}</td> 
                                </tr>
                                @endforeach 
                                <tr style="background-color: #2abdc6;">
                                    <td>Total Amount: </td>
                                    <td>{{number_format($total,2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                  <div class="col-md-12 mt-5" ><br> <br><br></div>
                <div class="row mt-5 pb-5" >
                  <table style="width:100%">
                    <tr >
                      <th  width="33.33%" style="text-align:center;" ><span style=" margin-top:10px; border-top:1px solid #333;" >Delivered By</span></th>
                      <th  width="33.33%" style="text-align:center;"><span style=" margin-top:10px; border-top:1px solid #333;" >Printed By</span></th>
                      <th  width="33.33%" style="text-align:center;"><span style=" margin-top:10px; border-top:1px solid #333;" >Autorise By</span></th>
                    </tr>
                  </table>
                    <br><br>
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
                filename: "Trail_balance.xls"
            });
        });
    });
</script>

@endsection
