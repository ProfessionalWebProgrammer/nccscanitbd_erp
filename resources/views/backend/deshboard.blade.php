@extends('layouts.backendbase')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="float-sm-right">
                        <li class="breadcrumb">
                          <form class="" action="{{route('get.marketingOrder.tracking.invoice')}}" method="post">
                            @csrf
                          <div class="input-group">
                          <input type="text" class="form-control" name="invoice" placeholder="Search Purchase Tracking No">
                          <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                              <i class="fa fa-search"></i>
                            </button>
                          </div>
                          </form>
                        </li>
                      </ol>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

      {{--@if(Auth::id() == 101)--}}
      @if(Auth::id())
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
              <div class="row">
                  <div class="col-lg-3 col-6" >
                    <!-- small box -->
                    <div class="small-box bg-info" >
                       <div class="small-box-footer">Today Sales</div>
                      <div class="inner">
                        <h6>Invoice: {{$today_sales[0]->total_invoice}}</h6>
                        {{-- <h6>Qty (Bag): {{$today_sales[0]->total_qty}}</h6>
                        <h6>Qty (Ton): {{$today_sales_kg[0]->qty_kg/1000}}</h6> --}}
                         <hr>
                        <h6>Amount: {{$today_sales[0]->total_price}} ৳</h6>

                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="small-box-footer">Today Collection</div>
                      <div class="inner">
                           <h6>Bank: {{$today_bank_rcv[0]->total_amount}}  ({{$today_bank_rcv[0]->total_invoice}}) ৳</h6>
                        <h6>Cash: {{$today_cash_rcv[0]->total_amount}}  ({{$today_cash_rcv[0]->total_invoice}}) ৳</h6>
                        <h6>Others:</h6>
                        <hr>
                        <h6>Total: {{$today_cash_rcv[0]->total_amount+$today_bank_rcv[0]->total_amount}}({{$today_bank_rcv[0]->total_invoice+$today_cash_rcv[0]->total_invoice}}) ৳</h6>

                       </div>
                      <div class="icon">
                        <i class="ion ion-person-add"></i>
                      </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                       <div class="small-box-footer">Today Purchase</div>
                      <div class="inner">
                          <h6>Invoice: {{$today_purchase[0]->total_invoice}}</h6>
                      {{--  <h6>Qty (KG): {{$today_purchase[0]->total_qty}}</h6>
                        <h6>Qty (Ton): {{$today_purchase[0]->total_qty/1000}}</h6> --}}
                         <hr>
                        <h6>Amount: {{$today_purchase[0]->total_price + $todayFgPurchase}} ৳</h6>

                      </div>
                      <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->

                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                       <div class="small-box-footer">Today Payment</div>
                      <div class="inner">
                        <h6>Bank: {{$today_bank_pmnt[0]->total_amount}} ({{$today_bank_pmnt[0]->total_invoice}}) ৳</h6>
                        <h6>Cash: {{$today_cash_pmnt[0]->total_amount}}  ({{$today_cash_pmnt[0]->total_invoice}}) ৳</h6>
                        <h6>Expanse:</h6>
                        <hr>
                        <h6>Total: {{$today_cash_pmnt[0]->total_amount+$today_bank_pmnt[0]->total_amount}}  ({{$today_bank_pmnt[0]->total_invoice+$today_cash_pmnt[0]->total_invoice}}) ৳ </h6>

                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>

                    </div>
                  </div>
                  <!-- ./col -->
                     <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                       <div class="small-box-footer">Raw Materials</div>
                      <div class="inner">
                        <h6>Today Stock (Amount): {{number_format($data['totalRawStock'],2) }} ৳</h6> 
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                       <div class="small-box-footer">Finished Goods</div>
                      <div class="inner">
                        <h6>Today Stock (Amount): {{number_format($data['totalFgStock'],2) }}  ৳</h6>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                       <div class="small-box-footer">Finished Goods Production</div>
                      <div class="inner">
                        <h6>Today Production (Amount): {{number_format($data['todayProduction'],2) }}  ৳</h6>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                       <div class="small-box-footer">Accounts Receivable </div>
                      <div class="inner">
                        <h6> {{number_format($data['totalAcReceivable'],2) }}  ৳</h6>
                      </div>
                    </div>
                  </div>
                  
                  
                  
                  <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                       <div class="small-box-footer">Accounts Payable </div>
                      <div class="inner">
                        <h6> {{number_format($data['totalAcPayable'],2) }}  ৳</h6>
                      </div>
                    </div>
                  </div>
                  
                  
                  <div class="col-lg-12 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                       <div class="small-box-footer">Daily Category Wise Short Sumary </div>
                      <div class="inner">
                        
                        
                        <table  id="reporttable" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr  class="table-header-fixt-top text-center" style="font-size: 18px;  font-weight:600;">
                                <th>Category Name</th>
                                <th>Sales</th>
                                <th>Discount</th>
                                <th>Return</th>
                                <th>Net Sales</th>
                                <th>Collection Amount</th>
                                <th>Due Amount</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $grnd_tvalue = 0;
                                $grnd_t_discount_v = 0;
                                $grnd_t_net_sale_v = 0;
                                $grand_t_return_v = 0;
                                $grand_t_collection_v = 0;
                                $grand_t_due_v = 0;
                                $datefrom = date('Y-m-d');
                                $dateto = date('Y-m-d');
                                $category = \DB::table('sales_categories')->whereNotIn('id',[39])->get();
                            @endphp
                            @foreach ($category as $data)

                                @php
                                    $product_data = DB::table('sales_ledgers')
                                    ->select('product_id', 'product_name', DB::raw('SUM(qty_pcs) as total_qty'), DB::raw('SUM(qty_kg) as total_qty_kg'), DB::raw('SUM(total_price) as grand_total'), DB::raw('SUM(discount_amount) as grand_total_discount_amount'))
                                    ->whereBetween('ledger_date', [$datefrom, $dateto])
                                    ->where('category_id', $data->id);
                                
                                    $product_data =$product_data->groupBy('product_id')
                                    ->groupBy('product_name')
                                    ->get();
                                            
                                @endphp
                                @php
                                    $sub_tvalue = 0;
                                    $sub_t_discount_v = 0;
                                    $sub_t_net_sale_v = 0;
                                    $sub_t_return_v = 0;
                                    $sub_t_collection_v = 0;
                                    $sub_t_due_v = 0;
                                @endphp
                                @foreach ($product_data as $product)
                                    @php
                                        $grnd_tvalue += $product->grand_total;
                                        $sub_tvalue += $product->grand_total;
                                        $unit = \App\Models\SalesProduct::where('id', $product->product_id)->first();
                                        $sales_product = DB::table('sales_products')->where('id', $product->product_id)->first();
                                        $salesReturnAmount = DB::table('sales_return_items')
                                            ->whereBetween('date', [$datefrom, $dateto])
                                            ->where('product_id', $product->product_id)->sum('total_price');
                                            
                                        $collectionAmount = DB::table('payments')
                                            ->where('category_id', $data->id)
                                            ->whereBetween('payment_date', [$datefrom, $dateto])
                                            ->where('payment_type', 'RECEIVE')
                                            ->whereNull('deleted_by')
                                            ->sum('amount');
                                        
                                        
                                        $net_Sale_amount = $product->grand_total - $product->grand_total_discount_amount - $salesReturnAmount;
                                        $sub_t_discount_v += $product->grand_total_discount_amount;
                                        $sub_t_net_sale_v += $net_Sale_amount;
                                        $grnd_t_discount_v += $product->grand_total_discount_amount;
                                        $grnd_t_net_sale_v += $net_Sale_amount;
                                        
                                        
                                        $sub_t_return_v += $salesReturnAmount;
                                        $grand_t_return_v += $salesReturnAmount;
                                        
                                        $sub_t_collection_v += $collectionAmount;
                                        $grand_t_collection_v += $collectionAmount;
                                
                                    @endphp
                                @endforeach
                                <tr style="background-color: #fdc6964f;">
                                    <th  style="text-align:right">{{ $data->category_name }}</th>
                                    <th  style="text-align:right">{{ number_format($sub_tvalue, 2) }}</th>
                                    <th  style="text-align:right">{{ number_format($sub_t_discount_v, 2) }}</th>
                                    <th  style="text-align:right">{{ number_format($sub_t_return_v, 2) }}</th>
                                    <th  style="text-align:right">{{ number_format($sub_t_net_sale_v, 2) }}</th>
                                    <th  style="text-align:right">{{ number_format($sub_t_collection_v, 2) }}</th>
                                    <th  style="text-align:right">{{ number_format(($sub_t_net_sale_v - $sub_t_collection_v), 2) }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background-color: #80a5087c">
                                <th  style="text-align:right">Grand Total:</th>
                                <th  style="text-align:right">{{ number_format($grnd_tvalue, 2) }}</th>
                                <th  style="text-align:right">{{ number_format($grnd_t_discount_v, 2) }}</th>
                                <th  style="text-align:right">{{ number_format($grand_t_return_v, 2) }}</th>
                                <th  style="text-align:right">{{ number_format($grnd_t_net_sale_v, 2) }}</th>
                                <th  style="text-align:right">{{ number_format($grand_t_collection_v, 2) }}</th>
                                <th  style="text-align:right">{{ number_format(($grnd_t_net_sale_v - $grand_t_collection_v), 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                        
                        
                      </div>
                    </div>
                  </div>
                  
                  
                  
                </div>

                <div class="row">


                   <div class="col-lg-12">
                        <div class="card" style="color: black;">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Sales</h3>
                                    <a href="javascript:void(0);">View Report</a>
                                </div>
                            </div>
                            <div class="card-body">
                              {{--  <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg">$18,230.00</span>
                                        <span>Sales Over Time</span>
                                    </p>
                                    <p class="ml-auto d-flex flex-column text-right">
                                        <span class="text-success">
                                            <i class="fas fa-arrow-up"></i> 33.1%
                                        </span>
                                        <span class="text-muted">Since last month</span>
                                    </p>
                                </div>  --}}
                                <!-- /.d-flex -->

                                <div class="position-relative mb-4">
                                  <div id="chartContainer" style="height: 400px; width: 100%;"></div>
                                </div>
                                <div class="position-relative mb-4">
                                  <div id="chartContainer1" style="height: 400px; width: 100%;"></div>
                                </div>


                            </div>
                        </div>
                        <!-- /.card -->

                      <div class="card" style="color: black;">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Purchase</h3>
                                    <a href="javascript:void(0);">View Report</a>
                                </div>
                            </div>
                            <div class="card-body">
                              {{--  <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg">$18,230.00</span>
                                        <span>Sales Over Time</span>
                                    </p>
                                    <p class="ml-auto d-flex flex-column text-right">
                                        <span class="text-success">
                                            <i class="fas fa-arrow-up"></i> 33.1%
                                        </span>
                                        <span class="text-muted">Since last month</span>
                                    </p>
                                </div>  --}}
                                <!-- /.d-flex -->

                                <div class="position-relative mb-4">
                                   {{-- <canvas id="sales-chart" height="200"></canvas> --}}
                                  <div id="chartContainer3" style="height: 400px; width: 100%;">
      							              </div>
                                </div>
                                <div class="position-relative mb-4">

                                  <div id="chartContainer4" style="height: 400px; width: 100%;">
      							              </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col-md-6 -->

                    {{-- <div class="col-lg-12">
                        <div class="card " style="color:black">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Prodcution </h3>
                                    <a href="javascript:void(0);">View Report</a>
                                </div>
                            </div>
                            <div class="card-body">

                               <div class="row">
                                    <div class="col-lg-6">
                                        <h3 >Raw Materials</h3>
                                      <hr>
                                      <h5>Today Stock IN (Amount): {{number_format($today_purchase[0]->total_price,2) }} ৳</h5>
                                      <h5>Today Stock Out (Amount): {{number_format($today_rm_so[0]->totalAmount,2) }} ৳</h5>
                                      <hr>
                                       <h5>Total  Stock IN (Amount): {{number_format($total_rm_si[0]->total_price,2) }} ৳</h5>
                                      <h5>Total Stock Out (Amount): {{number_format($total_rm_so[0]->totalAmount,2) }} ৳</h5>


                                	 </div>
                                  <div class="col-lg-6">
                                      <h3 >Finished Goods</h3>
                                    <hr>
                                    	 <h5>Today Stock IN(Amount):{{number_format($today_fg_si[0]->totalAmount,2) }}  ৳</h5>
                                      <h5>Today Stock Out(Amount): {{number_format($today_sales[0]->total_price,2) }} ৳</h5>
                                      <hr>
                                       <h5>Total  Stock IN(Amount): {{number_format($total_fg_si[0]->totalAmount,2) }} ৳</h5>
                                      <h5>Total Stock Out(Amount):  {{number_format($total_sales[0]->total_price,2) }} ৳</h5>
                                	 </div>
                                </div>
                                <!-- /.d-flex -->
                            </div>
                            </div>
                        </div> --}}
                    </div>

              <!-- /.row -->
                </div>
            </div>
      @endif
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->

    <!-- /.content-wrapper -->



@endsection


@push('end_js')
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
 window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	exportEnabled: true,
	animationEnabled: true,
	title:{
		text: "Sales Bar Chart (Monthly)"
	},

	axisX: {
	//	title: "States",
       interval: 1
	},
  axisY: {
		title: "Sales",
		titleFontColor: "#24963e",
		lineColor: "#24963e",
		labelFontColor: "#24963e",
		tickColor: "#24963e",
		includeZero: true
	},


	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},

	data: [{
		type: "column",
		name: "Sales",
    color: "#24963e",
		showInLegend: true,
		yValueFormatString: "#,##0.# ৳",
		dataPoints: [
		 @foreach($month12datasales as $data)
        @php
        $monthname = date('F,Y',strtotime($data->year.'-'.$data->month));
        @endphp
			{ label: "{{$monthname}}", y: {{$data->totalAmount}} },
			// { label: "{{$monthname}}", y: {{$data->total_value/1000}} },
		@endforeach

		]
	}
	/*{
		type: "column",
		name: "Collection",
		// axisYType: "secondary",
		showInLegend: true,
		yValueFormatString: "#,##0.# ৳",
		dataPoints: [
			 @foreach($month12datarcv as $data)
            @php
            $monthname = date('F,Y',strtotime($data->year.'-'.$data->month));
            @endphp
                { label: "{{$monthname}}", y: {{$data->amount}} },
            @endforeach
		]
	}*/]
});
chart.render();

 function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}

var chart1 = new CanvasJS.Chart("chartContainer1", {
	exportEnabled: true,
	animationEnabled: true,
	title:{
		text: "Collection Bar Chart (Monthly)"
	},

	axisX: {
	//	title: "States",
       interval: 1
	},

	axisY: {
		title: "Collection",
		titleFontColor: "#13abc5",
		lineColor: "#13abc5",
		labelFontColor: "#13abc5",
		tickColor: "#13abc5",
		includeZero: true
	},

	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},

	data: [{
		type: "column",
		name: "Collection",
		// axisYType: "secondary",
    color: "#13abc5",
		showInLegend: true,
		yValueFormatString: "#,##0.# ৳",
		dataPoints: [
			 @foreach($month12datarcv as $data)
            @php
            $monthname = date('F,Y',strtotime($data->year.'-'.$data->month));
            @endphp
                { label: "{{$monthname}}", y: {{$data->amount}} },
            @endforeach
		]
	}]
});
chart1.render();


  var chart3 = new CanvasJS.Chart("chartContainer3", {
	exportEnabled: true,
	animationEnabled: true,
	title:{
		text: "Purchase Bar Chart (Monthly)"
	},

	axisX: {
		//title: "States",
       interval: 1
	},
  axisY: {
		title: "Purchase",
		titleFontColor: "#0667d0",
		lineColor: "#0667d0",
		labelFontColor: "#0667d0",
		tickColor: "#0667d0",
		includeZero: true
	},

	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Purchase",
    color: "#0667d0",
		showInLegend: true,
		yValueFormatString: "#,##0.# ৳",
		dataPoints: [
		 @foreach($month12datapurchae as $data)
        @php
        $monthname = date('F,Y',strtotime($data->year.'-'.$data->month));
        @endphp
			{ label: "{{$monthname}}", y: {{$data->total_value}} },
		@endforeach

		]
	} ]
});
chart3.render();

var chart4 = new CanvasJS.Chart("chartContainer4", {
exportEnabled: true,
animationEnabled: true,
title:{
  text: "Payment Bar Chart (Monthly)"
},

axisX: {
  //title: "States",
     interval: 1
},
axisY: {
  title: "Payment",
  titleFontColor: "#bd7e0b",
  lineColor: "#bd7e0b",
  labelFontColor: "#bd7e0b",
  tickColor: "#bd7e0b",
  includeZero: true
},

toolTip: {
  shared: true
},
legend: {
  cursor: "pointer",
  itemclick: toggleDataSeries
},
data: [
{
  type: "column",
  name: "Payment",
  // axisYType: "secondary",
  color: "#bd7e0b",
  showInLegend: true,
  yValueFormatString: "#,##0.# ৳",
  dataPoints: [
     @foreach($month12datapmt as $data)
          @php
          $monthname = date('F,Y',strtotime($data->year.'-'.$data->month));
          @endphp
              { label: "{{$monthname}}", y: {{$data->amount}} },
          @endforeach
  ]
} ]
});
chart4.render();


}

</script>


@endpush
