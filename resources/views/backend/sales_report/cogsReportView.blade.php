@extends('layouts.sales_dashboard')


@section('print_menu')


@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      <button class="btn btn-sm  btn-success mt-1" id="btnExport"> Export  </button>
                      <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  > Print  </button>
                      <button class="btn btn-sm btn-info mt-1"  onclick="printland()"><i class="fa fa-print" aria-hidden="true"> </i> PrintLands. </button>
                    </div>
          </div>

            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh"  id="contentbody">
              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Sales COGS Report</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  		<p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
                <div class="py-4">
                    <table id="reporttable"  class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="table-header-fixt-top">
                                <th>SI No</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>F.G Product</th>
                                <th>Raw Material</th>
                                <th>Packing Item</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                         @php
                         $totalAmount = 0;
                          $rawQty = 0;
                          $rawAmount = 0;
                        @endphp
                                <tr style="background-color: rgba(255, 7, 80, 0.5);">
                                  <td colspan="100%">COGS of Raw Materials Product</td>
                                </tr>
                                @foreach($allRawProducts as $raw)
                                @php
                                $rawQty += $raw->qty;
                                $rawAmount += $raw->amount;
                                $totalAmount += $raw->amount;
                                @endphp

                                <tr style="font-size: 13x; @if($raw->qty < 0)  color: red; @else  @endif">
                                  <td>{{$loop->iteration}}</td>
                                  <td>{{date('d-m-Y',strtotime($raw->date))}}</td>
                                  <td>{{$raw->invoice}}</td>
                                  <td>{{$raw->product->product_name ?? ''}}</td>
                                  <td>{{$raw->rawProduct->product_name ?? ''}}</td>
                                  <td></td>
                                  <td>{{$raw->qty}} {{$raw->rawProduct->unit}}</td>
                                  <td>{{$raw->rate}}</td>
                                  <td class="text-right">{{number_format($raw->amount,2)}}</td>
                                </tr>
                                @endforeach

                                @foreach($rawProducts as $val)
                                @php
                                $rawQty += $val->stock_out_quantity;
                                $rawAmount += $val->total_amount;
                                $totalAmount += $val->total_amount;
                                @endphp

                                <tr style="font-size: 13x; @if($val->stock_out_quantity < 0)  color: red; @else  @endif">
                                  <td>{{$loop->iteration}}</td>
                                  <td>{{date('d-m-Y',strtotime($val->date))}}</td>
                                  <td>{{$val->sout_number}}</td>
                                  <td>{{$val->product->product_name ?? ''}}</td>
                                  <td>{{$val->product->product_name ?? ''}}</td>
                                  <td></td>
                                  <td>{{$val->stock_out_quantity}} {{$val->product->unit}}</td>
                                  <td>{{$val->stock_out_rate}}</td>
                                  <td class="text-right">{{number_format($val->total_amount,2)}}</td>
                                </tr>
                                @endforeach

                                <tr style="background-color: rgba(255, 7, 80, 0.5);">
                                  <td colspan="6">Sub Total</td>
                                  <td>{{$rawQty}}</td>
                                  <td colspan="2" class="text-right">{{number_format($rawAmount,2)}}</td>
                                </tr>
                                <tr style="background-color: rgba(22, 227, 80, 0.5);">
                                  <td colspan="100%">COGS of Finish Goods Product</td>
                                </tr>
                                @php
                                $fgQty = 0;
                                $fgAmount = 0;
                                @endphp
                                @foreach($allFgProducts as $fg)
                                @php
                                $fgQty += $fg->qty;
                                $fgAmount += $fg->amount;
                                $totalAmount += $fg->amount;
                                @endphp

                                <tr style="font-size: 13x; @if($fg->qty < 0)  color: red; @else  @endif">
                                  <td>{{$loop->iteration}}</td>
                                  <td>{{date('d-m-Y',strtotime($fg->date))}}</td>
                                  <td>{{$fg->invoice}}</td>
                                  <td>{{$fg->product->product_name ?? ''}}</td>
                                  <td></td>
                                  <td></td>
                                  <td>{{$fg->qty}} {{$fg->product->unit->unit_name}}</td>
                                  <td>{{$fg->rate}}</td>
                                  <td class="text-right">{{number_format($fg->amount,2)}}</td>
                                </tr>
                                @endforeach
                                <tr style="background-color: rgba(22, 227, 80, 0.5);">
                                  <td colspan="6">Sub Total</td>
                                  <td>{{$fgQty}}</td>
                                  <td colspan="2" class="text-right">{{number_format($fgAmount,2)}}</td>
                                </tr>

                                <tr style="background-color: #7cb7ee;">
                                  <td colspan="100%">COGS of Packing Materials</td>
                                </tr>
                                @php
                                $packQty = 0;
                                $packAmount = 0;
                                @endphp
                                @foreach($allPackingProducts as $pack)
                                @php
                                $packQty += $pack->qty;
                                $packAmount += $pack->amount;
                                $totalAmount += $pack->amount;
                                @endphp

                                <tr style="font-size: 13x; @if($pack->qty < 0)  color: red; @else  @endif">
                                  <td>{{$loop->iteration}}</td>
                                  <td>{{date('d-m-Y',strtotime($pack->date))}}</td>
                                  <td>{{$pack->invoice}}</td>
                                  <td>{{$pack->product->product_name ?? ''}}</td>
                                  <td></td>
                                  <td>{{$pack->packing->product_name ?? ''}}</td>
                                  <td>{{$pack->qty}} {{$pack->packing->unit}}</td>
                                  <td>{{$pack->rate}}</td>
                                  <td class="text-right">{{number_format($pack->amount,2)}}</td>
                                </tr>
                                @endforeach
                                <tr style="background-color: #7cb7ee;">
                                  <td colspan="6">Sub Total</td>
                                  <td>{{$packQty}}</td>
                                  <td colspan="2" class="text-right">{{number_format($packAmount,2)}}</td>
                                </tr>
                                
                                
                                @php
                                $totalAmount -= ($returnData->fgReturn + $returnData->rawReturn + $returnData->bagReturn);
                                @endphp
                                <tr style="color:red;">
                                  <td colspan="8">Raw Material and Finish Good Return </td>
                                  <td class="text-right">{{number_format(($returnData->fgReturn + $returnData->rawReturn),2)}}</td>
                                </tr>
                                <tr style="color:red;">
                                  <td colspan="8">Packing Materials Return</td>
                                  <td class="text-right">{{number_format( $returnData->bagReturn,2)}}</td>
                                </tr>  
                         </tbody>
                           <tfoot>
                            <tr style="background-color: #e1936e;">

                                    <th colspan="8">Grand Total</th>
                              		  <td  class="text-right">{{number_format($totalAmount,2)}}</td>
                            </tr>
                        </tfoot>
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

        function printland() {

                  	printJS({
                      printable: 'contentbody',
                      type: 'html',
                       font_size: '16px;',
                      style: ' @page  { size: A4 landscape; max-height:100%; max-width:100%} table, th, td {border: 1px solid black; font-size:16px!important; border-collapse: collapse; padding: 0px 3px} h3{margin: 0!important;padding: 0 !important; text-align:center;} h5{margin: 0!important;padding: 0 !important; text-align:center;} p{margin: 0!important;padding: 0 !important; text-align:center;} h6{margin: 0!important;padding: 0 !important; text-align:center;} .cominfo{text-align:center;margin-left:8rem;} .pageinfo{text-align:center;margin-left:8rem;margin-bottom:2rem;padding: 0 !important;}'
                    });
              }
</script>

<script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#reporttable").table2excel({
                filename: "Sales_cogs_Report.xls"
            });
        });
    });
</script>
@endsection
