@extends('layouts.sales_dashboard')

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
        <div class="col-md-2 ">
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


             @endphp

                <div class="row pt-3">
                    <div class="col-md-4 m-auto sales_main_button">

                        <a href="{{route('sales.dashboard')}}" class="text-center pt-1 pb-2 py-3 btn btn-block text-center salesdashboardname linkbtn">Sales Department</a>
                    </div>
                </div>

					@if($userId == 169)
                     <div class="row pt-5 px-3 text-center">
                       <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                          <div class="mx-1">
                            <a href="{{route('delivery.status')}}" class="btn btn-block text-dark text-center py-3 linkbtn">D.C</a>
                          </div>
                      </div>
                        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                          <div class="mx-1">
                            <a href="{{route('transfer.status')}}" class="btn btn-block text-dark text-center py-3 linkbtn">T.C</a>
                          </div>
                      </div>
                       <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                          <div class="mx-1">
                            <a href="{{route('product.transfer.list')}}" class="btn btn-block text-center py-3 linkbtn">Transfer</a>
                          </div>
                      </div>
                     </div>
             
             		@else 
                  <div class="row pt-5 px-3 text-center">
                     @if (in_array('salesentry', $salesdata))
                      <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                          <div class="mx-1">
                            <a href="{{route('sales.create')}}" class="btn btn-block  text-center py-3 linkbtn">Sales Entry</a>
                          </div>
                      </div>

                      <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                          <div class="mx-1">
                            <a href="{{route('sales.index')}}" class="btn btn-block  text-center py-3 linkbtn">Sales List</a>
                          </div>
                      </div>
                  @endif
                  
                  @if (in_array('salesdc', $salesdata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('delivery.status')}}" class="btn btn-block text-dark text-center py-3 linkbtn">D.C</a>
                        </div>
                    </div>
                 @endif
                 @if (in_array('salestc', $salesdata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('transfer.status')}}" class="btn btn-block text-dark text-center py-3 linkbtn">T.C</a>
                        </div>
                    </div>
                @endif
                    @if (in_array('salesledger', $salesdata))

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.ledger.index')}}" class="btn btn-block  text-center py-3 linkbtn">Sales Ledger</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('all.sales.report.index')}}" class="btn btn-block  text-center py-3 linkbtn">Sales Report</a>
                        </div>
                    </div>
                    @endif


                       @if (in_array('order', $salesdata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.order.index')}}" class="btn btn-block text-dark text-center py-3 linkbtn">Order & List</a>
                        </div>
                    </div>
                    @endif

                    @if (in_array('screate', $salesdata))

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('dealer.index')}}" class="btn btn-block text-center py-3 linkbtn">Dealers</a>
                        </div>
                   </div>


                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.item.index')}}" class="btn btn-block text-center py-3 linkbtn">Products</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.damage.index')}}" class="btn btn-block  text-center py-3 linkbtn">Damage</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('product.transfer.list')}}" class="btn btn-block text-center py-3 linkbtn">Transfer</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.return.index')}}" class="btn btn-block text-center py-3 linkbtn">Return</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.return.report.index')}}" class="btn btn-block text-center py-3 linkbtn">Return Report</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.set_margin.index')}}" class="btn btn-block  text-center py-3 linkbtn">Set Margin</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.monthly.incentive')}}" class="btn btn-block  text-center py-3 linkbtn">Incentives</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('production.stock.in.list')}}" class="btn btn-block text-center py-3 linkbtn">F.G Stocks</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button " style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('special.rate.create')}}" class="btn btn-block text-center py-3 linkbtn">Spacial Rate</a>
                        </div>
                    </div>
                     @endif

                    @if (in_array('salesreport', $salesdata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1 ">
                          <a href="{{route('reports.index')}}" class="btn btn-block text-center py-3 linkbtn">Reports</a>
                        </div>
                    </div>
                    @endif
                  </div>
                
				@endif 
				</div>
                 {{--   <div class="col-lg-12" style="height:390px;">
                           <h4 style="    display: flex;align-items: center;justify-content: center;width: 100%;height: 100%;">Sales Deshboard</h4>

                    </div>
                    <div class="col-lg-12 px-5" style="">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search here" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="button" id="button-addon2" style="margin-left: -9px;"><i class="fas fa-search"></i></button>
                        </div>
                      </div>
                    </div>

         --}}

                   <div class="col-lg-12">
                        <div class="card" style="color: black;">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Sales</h3>
                                    <a href="javascript:void(0);">View Report</a>
                                </div>
                            </div>
                            <div class="card-body">

                                <!-- /.d-flex -->

                                <div class="position-relative mb-4">
                                   {{-- <canvas id="sales-chart" height="200"></canvas> --}}
                                  <div id="chartContainer" style="height: 400px; width: 100%;">
                                </div>
                                </div>


                            </div>
                        </div>
                        <!-- /.card -->
            </div>
        </div>
      </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
    <!-- /.content -->
  </div>
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
        text: "Sales And Collection Chart (Monthly)"
    },

    axisX: {
    //  title: "States",
       interval: 1
    },
  axisY: {
        title: "Sales",
        titleFontColor: "#4F81BC",
        lineColor: "#4F81BC",
        labelFontColor: "#4F81BC",
        tickColor: "#4F81BC",
        includeZero: true
    },
    axisY2: {
        title: "Collection",
        titleFontColor: "#C0504E",
        lineColor: "#C0504E",
        labelFontColor: "#C0504E",
        tickColor: "#C0504E",
        includeZero: true
    },

    toolTip: {
        shared: true
    },
    legend: {
        cursor: "pointer",

    },

    data: [{
        type: "column",
        name: "Sales",
        showInLegend: true,
        yValueFormatString: "#,##0.# Ton",
        dataPoints: [
         @foreach($month12datasales as $data)
        @php
        $monthname = date('F,Y',strtotime($data->year.'-'.$data->month));
        @endphp
            { label: "{{$monthname}}", y: {{$data->total_qty/1000}} },
        @endforeach

        ]
    },
    {
        type: "column",
        name: "Collection",
        axisYType: "secondary",
        showInLegend: true,
        yValueFormatString: "#,##0.# BDT",
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
chart.render();



}







</script>




@endpush
