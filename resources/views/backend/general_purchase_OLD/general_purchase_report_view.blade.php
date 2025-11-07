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

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row mt-3">
                  	<div class="col-md-12 text-right">
                      	<button class="btn btn-sm  btn-success mt-1" id="btnExport">Export </button>
                    	<button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >Print </button>
                      
                    </div>
                </div>

            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh" id="contentbody">
                <div class="py-4">
                    <div class="text-center">
                        <h4 class="text-uppercase font-weight-bold">General Purchase Report</h4>
                        <hr style="background: #ffffff78;">
                    </div>
                    <table id="" class="table table-bordered table-striped mt-4" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top" >
                                <th>Date</th>
                                <th>Inv No</th>
                                <th>Supplier</th>
                                <th>Wirehouse</th>
                                <th>Product</th>
                                <th>Dimension </th>
                                <th>Qty </th>
                                <th>Rate </th>
                                <th>Total Value</th>
                            </tr>
                        </thead>

                        <tbody style="font-size: 14px;">
                            @php
                                $gtotalqntty = 0;
                                $gtotalvalue = 0;
                            @endphp
                            @foreach ($reportdata as $item)
                                @php
                                    $invoicedetailes = DB::table('general_purchases')
                                        ->where('invoice_no', $item->invoice_no)
                                        ->first();
                                @endphp
                                {{-- <tr class="text-danger font-weight-bold" style="background: papayawhip">
                                    <td>{{ $invoicedetailes->date }}</td>
                                    <td>{{ $invoicedetailes->invoice_no }}</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr> --}}
                                @php
                                    if ($products !== null) {
                                        $reportdetailes = DB::table('general_purchases')
                                            ->select('general_purchases.*', 'general_products.gproduct_name', 'general_suppliers.supplier_name', 'general_wirehouses.wirehouse_name')
                                            ->leftjoin('general_products', 'general_products.id', 'general_purchases.product_id')
                                            ->leftjoin('general_suppliers', 'general_suppliers.id', 'general_purchases.supplier_id')
                                            ->leftjoin('general_wirehouses', 'general_wirehouses.wirehouse_id', 'general_purchases.warehouse_id')
                                            ->where('general_purchases.invoice_no', $item->invoice_no)
                                            ->whereBetween('general_purchases.date', [$fdate, $tdate])
                                            ->whereIn('general_purchases.product_id', $products)
                                            ->get();
                                    } else {
                                        $reportdetailes = DB::table('general_purchases')
                                            ->select('general_purchases.*', 'general_products.gproduct_name', 'general_suppliers.supplier_name', 'general_wirehouses.wirehouse_name')
                                            ->leftjoin('general_products', 'general_products.id', 'general_purchases.product_id')
                                            ->leftjoin('general_suppliers', 'general_suppliers.id', 'general_purchases.supplier_id')
                                            ->leftjoin('general_wirehouses', 'general_wirehouses.wirehouse_id', 'general_purchases.warehouse_id')
                                            ->where('general_purchases.invoice_no', $item->invoice_no)
                                            ->whereBetween('general_purchases.date', [$fdate, $tdate])
                                            ->get();
                                    }
                          //dd($reportdetailes);
                                @endphp
                                @php
                                    $totlqntty = 0;
                                    $totalvalue = 0;
                                @endphp
                                @foreach ($reportdetailes as $item)
                                    @php
                                        $totlqntty += $item->quantity;
                                        $totalvalue += $item->rate * $item->quantity;
                                    @endphp
                                    <tr>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->invoice_no }}</td>
                                        <td>{{ $item->supplier_name }}</td>
                                        <td>{{ $item->wirehouse_name }}</td>
                                        <td>{{ $item->gproduct_name }}</td>
                                        <td>{{ $item->dimensions }}</td>
                                        <td class="text-right font-weight-bold">{{ number_format($item->quantity) }}</td>
                                        <td class="text-right font-weight-bold">{{ number_format($item->rate) }}</td>
                                        <td class="text-right font-weight-bold">
                                            {{ number_format($item->rate * $item->quantity) }}</td>
                                    </tr>
                                @endforeach
                                @php
                                    $gtotalqntty += $totlqntty;
                                    $gtotalvalue += $totalvalue;
                                @endphp
                                <tr class="font-weight-bold"
                                    style="color: #72199e; background: #ff00002e; font-size: 15px;">
                                    <td colspan="6" class="text-center">Total </td>
                                    <td class="text-right">{{ $totlqntty }}</td>
                                    <td class="text-center">-</td>
                                    
                                    <td class="text-right font-weight-bold">{{ number_format($totalvalue) }}</td>
                                </tr>
                            @endforeach

                            <tr style="font-size: 16px; font-weight:bold">
                                <td class="text-center" colspan="6">GrandTotal</td>
                                <td class="text-right">{{ number_format($gtotalqntty) }}</td>
                                <td class="text-center">-</td>
                                <td class="text-right">{{ number_format($gtotalvalue) }}</td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
              $("#contentbody").table2excel({
                  filename: "Comparison-Report.xls"
              });
          });
      });
  </script>

@endsection
