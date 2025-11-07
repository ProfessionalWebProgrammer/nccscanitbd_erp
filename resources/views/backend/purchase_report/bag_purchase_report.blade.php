@extends('layouts.purchase_deshboard')
@push('addcss')
    <style>
        .text_sale {
            color: #1fb715;
        }
        .text_credit{
            color: #f90b0b;
        }
          .tableFixHead  { overflow: auto; height: 600px; }
    	.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }

    </style>
@endpush
@section('print_menu')
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
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh" id="contentbody">

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Purchase In Bag Report</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                        <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>


                <div class="py-4 table-responsive tableFixHead">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed"
                        style="font-size: 10px;table-layout: inherit;">
                              <thead>
                                     <tr class="table-header-fixt-top">
                                         <td style="text-align:center;top: -35px; ">Date</td>
                                         <td style="text-align:center;top: -35px; ">Invoice no</td>
                                         <td style="text-align:center;top: -35px; ">Wirehouse</td>
                                         <td style="text-align:center;top: -35px; ">Transport Vehicle</td>
                                         <td style="text-align:center;top: -35px; ">Product Name</td>
                                         <td style="text-align:center;top: -35px; ">Bill Qty</td>
                                         <td style="text-align:center;top: -35px; ">Rate</td>
                                         <td style="text-align:center;top: -35px; ">Purchase Value</td>
                                         <td style="text-align:center;top: -35px; ">Transport Fare</td>
                                         <td style="text-align:center;top: -35px; ">Total Payable Amount</td>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>

                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                    </tr>
                             @php
                                  $gtotal_pv = 0;
                                  $gtotal_tf = 0;
                                 $gtotal_pay = 0;

                                 $gtotal_bill = 0;
                             @endphp
                              @foreach($supplier as $supplier_data)


                                 @php

                                 $pur = DB::table('purchases')
                                        ->select('purchases.*', 'suppliers.supplier_name','factories.factory_name as wirehouse_name')
                                        ->leftjoin('suppliers', 'suppliers.id', '=', 'purchases.raw_supplier_id')
                                         ->leftjoin('factories', 'factories.id', '=', 'purchases.wirehouse_id')
                                        ->where('purchases.purchas_unit',"bag")
                                        ->where('purchases.raw_supplier_id',$supplier_data->raw_supplier_id)
                                        ->whereBetween('purchases.date', [$fdate, $tdate]);


                                    if ($wir) {
                                        $pur = $pur->whereIn('purchases.wirehouse_id', $wir);
                                    }

                                    $pur = $pur->get();

                                //dd($pur);

                                 $total_tf= 0;
                                 $total_pv = 0;
                                 $total_pay = 0;

                                 $total_bill = 0;

                                 @endphp


                                 @if($pur)

                                    <tr>
                                         <td colspan="15" style="color: black;font-size: initial;font-weight: bold;"><b>{{$supplier_data->supplier_name}}</b> </td>
                                     </tr>


                                 @foreach($pur as $purchas_data)

                                 @if($purchas_data->purchas_unit == "bag")

                                 @php
                                 //$total_pv += ($purchas_data->bill_quantity)*($purchas_data->purchase_rate);
                                $total_pay +=$purchas_data->total_payable_amount;
                                $total_tf += $purchas_data->transport_fare;


                               //  $total_bill +=$purchas_data->bill_quantity;

                               //  $gtotal_pv += ($purchas_data->bill_quantity)*($purchas_data->purchase_rate);
                                $gtotal_pay +=$purchas_data->total_payable_amount;
                               //  $gtotal_bill +=$purchas_data->bill_quantity;
                                 $gtotal_tf += $purchas_data->transport_fare;
								
                                   
                                   
                                   
                                 if ($pro) {
                                    $purchaseinfo = DB::table('purchase_details')->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchase_details.product_id')
                                                                 ->where('purchase_id',$purchas_data->purchase_id)
                                                                 ->where('product_id',$pro)
                                                                 ->get();
                                    }else{
                                        $purchaseinfo = DB::table('purchase_details')->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchase_details.product_id')
                                                                 ->where('purchase_id',$purchas_data->purchase_id)
                                                                 ->get();

                                    }


                                  $billq = 0;
                                  $pvtotal = 0;


                                   @endphp
                                    <tr>
                                    <td colspan="100%" style="border-color: #ababab;"></td>
                                     </tr>
                                  @foreach($purchaseinfo as $pddata)
                                    @php
                                     $total_bill +=$pddata->bill_quantity;
                                     $total_pv += $pddata->amount;


                                      
									 $gtotal_bill +=$pddata->bill_quantity;
                                      $gtotal_pv += $pddata->amount;

                                      $billq +=$pddata->bill_quantity;
                                      $pvtotal += $pddata->amount;


                                    @endphp
                                    <tr>
                                         <td>{{$purchas_data->date}}</td>
                                         <td><a href="#">INV-{{$purchas_data->purchase_id}}</a></td>
                                         <td>-</td>
                                         <td>-</td>
                                         <td>{{$pddata->product_name}}</td>

                                         <td>{{number_format($pddata->bill_quantity,2)}}</td>
                                         <td>{{number_format($pddata->purchase_rate,2)}}</td>
                                         <td>{{number_format($pddata->amount,2)}} Tk</td>
                                          <td></td>
                                          <td></td>
                                     </tr>
                                  @endforeach

                                     <tr>
                                         <td>{{$purchas_data->date}}</td>
                                         <td><a href="#">INV-{{$purchas_data->purchase_id}}</a></td>
                                         <td>{{$purchas_data->wirehouse_name}}</td>
                                         <td>{{$purchas_data->transport_vehicle}}</td>
                                         <td>-</td>

                                         <td>{{number_format( $billq,2)}}</td>
                                         <td>-</td>
                                         <td>{{number_format($pvtotal,2)}} Tk</td>
                                         <td>{{number_format($purchas_data->transport_fare,2)}} Tk</td>
                                         <td>{{number_format($purchas_data->total_payable_amount,2)}} Tk (Cr)</td>
                                     </tr>

                                   @endif
                                 @endforeach

                                 <tr>
                                   <td colspan="100%" style="border-color: blue;"></td>
                                 </tr>
                                 <tr>
                                     @php
                                     @endphp
                                     <td><b> Sub Total</b></td>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td><b>{{number_format($total_bill,2)}}</b></td>
                                     <td></td>
                                     <td><b>{{number_format($total_pv,2)}} Tk </b></td>
                                     <td><b>{{number_format($total_tf,2)}} Tk </b></td>
                                     <td><b>{{number_format($total_pay,2)}} Tk (Cr) </b></td>
                                 </tr>
                                 <tr>
                                  <td colspan="100%" style="border-color: red;"></td>
                                 </tr>


                            @endif
                             @endforeach

                             <tr>
                               <td style="font-weight: bold;"><b>Grand Total</b></td>
                                 <td style="font-weight: bold;"></td>
                                 <td style="font-weight: bold;"></td>
                                 <td style="font-weight: bold;"></td>
                                 <td style="font-weight: bold;"></td>

                                 <td style="font-weight: bold;"><b>{{number_format($gtotal_bill,2)}}</b></td>
                                 <td style="font-weight: bold;"></td>
                                 <td style="font-weight: bold;"><b>{{number_format($gtotal_pv,2)}} Tk </b></td>
                                 <td style="font-weight: bold;"><b>{{number_format($gtotal_tf,2)}} Tk </b></td>
                                <td style="font-weight: bold;"><b>{{number_format($gtotal_pay,2)}} Tk (Cr) </b></td>
                              </tr>
                             </tbody>
                         </table>
                </div>











            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()




        })
    </script>



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
                filename: "BagPurchaseReport.xls"
            });
        });
    });
</script>
@endsection
