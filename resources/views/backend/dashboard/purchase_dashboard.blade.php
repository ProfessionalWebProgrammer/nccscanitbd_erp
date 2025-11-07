@extends('layouts.purchase_deshboard')

@section('content')
<style>

  .menuclass{
  display: none;
  }
  </style>

<div class="content-wrapper">
    <!-- Main content -->
    <div class="content" >
      <div class="container-fluid" style="background:#fff!important; min-height:85vh;">

       <div class="row">
        <div class="col-md-2 mt-5">
             <!-- Main Sidebar Container -->
        <aside >
            @include('_partials_.sidebar')
        </aside>
        </div>
         <div class="col-md-10">

          <div class="mb-3" >
                  @php
                 $authid = Auth::id();
                  $salesdata = DB::table('permissions')
                 ->where('head', 'Sales')
                 ->where('user_id', $authid)
                 ->pluck('name')
                 ->toArray();
             $purchasedata = DB::table('permissions')
                 ->where('head', 'Purchase')
                 ->where('user_id', $authid)
                 ->pluck('name')
                 ->toArray();
             $accountsdata = DB::table('permissions')
                 ->where('head', 'Accounts')
                 ->where('user_id', $authid)
                 ->pluck('name')
                 ->toArray();
             $settingsdata = DB::table('permissions')
                 ->where('head', 'Settings')
                 ->where('user_id', $authid)
                 ->pluck('name')
                 ->toArray();
             @endphp


                <div class="row pt-3">
                    <div class="col-md-4 m-auto sales_main_button">
                        <a href="{{route('purchase.dashboard')}}" class="text-center pt-1 pb-2 py-3 btn btn-block text-center linkbtn" >Purchase Department</a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                   @if (in_array('purchaseentry', $purchasedata))

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.entry')}}" class="btn btn-block  linkbtn text-center py-3" >GRR Entry</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.index')}}" class="btn btn-block linkbtn text-center py-3" >Purchase List</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.bag.entry')}}" class="btn btn-block linkbtn text-center py-3" >MRR Entry (Bag)</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.bag.index')}}" class="btn btn-block linkbtn text-center py-3" >Bag List</a>
                        </div>
                    </div>
                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('finish.goods.manual.purchse.create')}}" class="btn btn-block  linkbtn text-center py-3" >MRR Entry (F.G)</a>
                        </div>
                    </div>
                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('finish.goods.manual.purchse.list')}}" class="btn btn-block linkbtn text-center py-3">F.G. Purchase List</a>
                        </div>
                    </div>
                    @endif
                    @if (in_array('production', $purchasedata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('production.stock.out.list')}}" class="btn btn-block text-center linkbtn py-3">Production</a>
                        </div>
                    </div>
                  @endif
                   @if (in_array('purchaseentry', $purchasedata))
                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                      <div class="mx-1">
                        @if($authid != 169) <a href="{{route('production.cost.menu')}}" class="btn btn-block text-center linkbtn py-3">Cost</a> @endif
                      </div>
                  </div>
                  @endif
                   @if (in_array('purchaseledger', $purchasedata))
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                       <div class="mx-1">
                           <a href="{{route('purchase.reports')}}" class="btn btn-block  text-center py-3 linkbtn" >Purchase Report</a>
                       </div>
                   </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.ledger.index')}}" class="btn btn-block linkbtn text-center py-3" >Ledger</a>
                        </div>
                    </div>
                  @endif
                  @if (in_array('generalpurchase', $purchasedata))


                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('general.purchase.page.index')}}" class="btn btn-block text-center linkbtn py-3" >General</a>
                        </div>
                    </div>
                   @endif
                  @if (in_array('purchaseentry', $purchasedata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.return.index')}}" class="btn btn-block  text-center linkbtn py-3" >Return</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.transfer.index')}}" class="btn btn-block text-center linkbtn py-3" >Transfer</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.damage.index')}}" class="btn btn-block text-center linkbtn py-3">Damage</a>
                        </div>
                    </div>

                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.set_margin.index')}}" class="btn btn-block text-center linkbtn py-3" >Set Margin</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('supplier.index')}}" class="btn btn-block  text-center linkbtn py-3" >Supplier</a>
                        </div>
                    </div>
                    @endif
                    @if (in_array('lcentry', $purchasedata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('lcEntryIndex')}}" class="btn btn-block  text-center linkbtn py-3" >L.C</a>
                        </div>
                    </div>
                    @endif
            @if (in_array('purchaseentry', $purchasedata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('row.materials.index')}}" class="btn btn-block text-center linkbtn py-3" >R. Materials</a>
                        </div>
                    </div>
                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('row.materials.issues.index')}}" class="btn btn-block text-center linkbtn py-3" >Stock Out Issues</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('rfq.list')}}" class="btn btn-block text-center linkbtn py-3" >RFQ Order</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('cs.list')}}" class="btn btn-block text-center linkbtn py-3" >Comparative Statement</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchaseOrderList')}}" class="btn btn-block text-center linkbtn py-3" >Purchase Order</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('marketingQualityControlList')}}" class="btn btn-block text-center linkbtn py-3" >Marketing Q.C</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('qualityControlList')}}" class="btn btn-block text-center linkbtn py-3" >Quality Control</a>
                        </div>
                    </div>
                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('fgQualityControlList')}}" class="btn btn-block text-center linkbtn py-3" >F G Quality Control</a>
                        </div>
                    </div>

                  @endif
                  @if (in_array('purchasereport', $purchasedata))
                    {{-- <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          @if($authid != 169) <a href="{{route('purchase.reports')}}" class="btn btn-block text-center linkbtn py-3">GRR Reports</a> @endif
                        </div>
                    </div> --}}

                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('production.reports')}}" class="btn btn-block text-center linkbtn py-3">Production Reports</a>
                        </div>
                    </div>
					@endif
					         <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('rentalProfileIndex')}}" class="btn btn-block text-center linkbtn py-3">Rental</a>
                        </div>
                    </div>
					         <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('rental.goods.allReports')}}" class="btn btn-block text-center linkbtn py-3">Rental Report</a>
                        </div>
                    </div>
                  </div>
                </div>
           <div class="col-md-12 m-t-5" style="min-height:390px;">
             <div class="row">
             <h1 class="col-md-12 text-center p-5">Stock Level Management Report</h1>

               <div class="py-4 table-responsive tableFixHead">
                 @if($authid != 169)
                    <table id="example3" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top" style="font-size: 16px;text-align: center;font-weight: bold;color: rgb(0, 0, 0);top: -25px;">
                            {{--  <th>SL</th> --}}
                              <th>Product Name</th>
                             <th>Stock Qty (Kg)</th>
                              <th>Stock Qty (Ton)</th>
                              <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 0;
                                @endphp
                                @foreach($products as $data)

                                @php
                              	$rmOpen = 0;

                                    $stocko = DB::table('purchase_stockouts as p')->select([DB::raw("SUM(p.stock_out_quantity) soQty")])
                                        ->where('p.product_id',$data->id)
                                        ->whereBetween('p.date',[$fdate,$tdate])->get();

                                   $pre_stocko = DB::select('SELECT SUM(purchases.receive_quantity) as stockout FROM `purchases`
                                                    WHERE purchases.product_id = "'.$data->id.'" and  purchases.date between "'.$sdate.'" and "'.$pdate.'" ');

                                   $stocin = DB::table('purchases as pp')->select([DB::raw("SUM(pp.inventory_receive) stock_in")])
                                            ->where('pp.product_id',$data->id)->whereBetween('pp.date',[$fdate,$tdate])->get();
                                   $rmOpen = $data->opening_balance;

                                   $closingData = ($rmOpen + $stocin[0]->stock_in + $pre_stocko[0]->stockout) - $stocko[0]->soQty;
                                   $name = \App\Models\RowMaterialsProduct::where('id', $data->id)->value('product_name');
                             		$i += 1;
                              	@endphp
								@if($closingData <= $data->min_stock)

                                <tr>
                              		{{-- <td>{{ $i }}</td> --}}
                                    <td>{{$name}}</td>
                                   	<td>{{number_format($closingData,2)}}</td>
                                    <td>{{number_format($closingData/1000,2)}}</td>
                                    <td>Stock Qty Below {{$data->min_stock ?? 25}} - {{$data->unit}}</td>
                                </tr>
                                 @else

                                 @endif
                                @endforeach
                              </tbody>
                           {{-- <tfoot>

                                <tr style="background-color: rgb(52 161 158 / 59%);">
                                    <td><b>Total : </b></td>
                                    <td><b></b></td>
                                    <td><b></b></td>
                                    <td><b></b></td>
                                </tr>
                            </tfoot> --}}

                    </table>
                 @endif
                </div>
             </div>
           </div>

                 {{--   <div class="col-lg-12" style="height:390px;">
                      <h4 style="    display: flex;align-items: center;justify-content: center;width: 100%;height: 100%;">Purchase Deshboard</h4>
                    </div>
                    <div class="col-lg-12 px-5" style="">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search here" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="button" id="button-addon2" style="margin-left: -9px;"><i class="fas fa-search"></i></button>
                        </div>
                      </div>
                    </div>  --}}

        </div>
        </div>

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->













@endsection


@push('end_js')
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


@endpush
