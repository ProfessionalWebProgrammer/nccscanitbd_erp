@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Production Stock Out Invoice List</h5>


                </div>
                <div class="py-4 table-responsive">
                    <div class="pb-3" style="margin-left: 30px" >
                        <h4>Invoice No: {{$stock_out[0]->sout_number}}</h4>
                         <h4>Wirehouse Name: {{$stock_out[0]->wirehouse_name}}</h4>
                      <h4>Finished Goods Name: {{DB::table('sales_products')->where('id',$stock_out[0]->finish_goods_id)->value('product_name')}}</h4>
                         <h4>Finished Goods Quantity: {{$stock_out[0]->fg_out_qty}}</h4>
                         <h4>F.G Production Rate: {{$productionRate}}</h4>
                      </div>
                    <table id="datatable" class="table table-bordered table-striped table-fixed mt-2"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr>
                              <th>No</th>
                              <th>Date</th>
                              <th>Item</th>
                               <th>Opening</th>
                               <th>Quantity</th>
                               <th>Closing</th>
                              <th>Rate</th>
                              <th>Total Amount</th>
                             </tr>
                            </thead>
                            <tbody>

                            @php
                            $totalq = 0;

                            $totala = 0;
                            @endphp

                            @foreach($stock_out as $key=>$data)
                             @php
                            $totalq += $data->stock_out_quantity;

                            /* if(!empty($data->rate)){
                              $totala += $data->stock_out_quantity*$data->rate;
                              }
                            $totala += $data->total_amount; */

                              $fdate = '2023-10-01';
                              $tdate = date('Y-m-d');

                             /*
                              $dataRate = DB::table('purchases')->select('bill_quantity','purchase_value')->where('product_id', $data->product_id)->whereBetween('date',[$fdate,$tdate])->get();
                                $valueTemp = 0;
                                $valueQty = 0;
                                $rate = 0;
                                foreach($dataRate as $key => $val){
                                  $valueTemp += $val->purchase_value;
                                  $valueQty += $val->bill_quantity;
                                }

                                if($valueTemp > 0 && $valueQty > 0){
                                  $rate = $valueTemp / $valueQty;
                                  $rate = round($rate,2);
                                } else {
                                $rate = $data->stock_out_rate;
                              }

                               if(!empty($rate)){
                              $totala += $data->stock_out_quantity*$rate;
                              } else {
                               $totala += $data->total_amount;
                              }
                              */
                              $rate = $data->stock_out_rate;
                              $totala += $data->total_amount;

                            @endphp
                              <tr>
                                <td>{{++$key}}</td>
                                <td>{{$data->date}}</td>
                                <td>{{$data->product_name}}</td>
                                  <td>{{number_format($data->stock_opening,2)}}</td>
                                  <td>{{number_format($data->stock_out_quantity,2)}}</td>
                                  <td>{{number_format($data->stock_opening-$data->stock_out_quantity,2)}}</td>

                         {{--   <td>@if(!empty($data->stock_out_rate)){{$data->stock_out_rate}} @else {{$data->rate}} @endif</td>
                                <td>@if(!empty($data->total_amount)){{number_format($data->total_amount, 2)}}  @else {{number_format($data->stock_out_quantity*$data->rate, 2)}} @endif</td> --}}

                                <td>@if(!empty($rate)){{number_format($rate,2)}} @else {{number_format($data->stock_out_rate,2)}}   @endif</td>
                                <td>@if(!empty($rate)) {{number_format($data->fg_qty*$rate, 2)}} @else {{number_format($data->total_amount, 2)}} @endif</td>

                          </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr style="font-size: 18px;background: #FA621C; color:#fff;">

                              <th colspan="3" style="text-align:center">Total</th>
                              <th></th>

                               <th>{{number_format($totalq,2)}}</th>
                              <th></th>
                              <th></th>
                              <th>{{number_format($totala, 2)}}</th>
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
@endsection
