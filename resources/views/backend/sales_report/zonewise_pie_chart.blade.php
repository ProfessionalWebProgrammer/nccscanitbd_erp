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
                      <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                    </div>
                </div>

            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="py-4">


                  <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Pie Chart</h5>
                      <p>{{$month_name}} </p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>


                    <div class="card" style="color: black;">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Pie Chart</h3>
                                </div>
                            </div>
                            <div class="card-body">


                                <div class="position-relative mb-4">

                                  <div id="chartContainer" style="height: 500px; width: 100%;">
      							</div>
                                </div>


                            </div>
                        </div>



                   <div class="card py-3" style="color: black;">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Product Bar Chart</h3>
                                </div>
                            </div>
                            <div class="card-body">


                                <div class="position-relative mb-4">

                                  <div id="chartContainer1" style="height: 500px; width: 100%;">
      							</div>
                                </div>


                            </div>
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


  window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	exportEnabled: true,
	animationEnabled: true,
	title: {
		text: "ZoneWise Sales Pie Chart"
	},
	data: [{
		type: "pie",
		startAngle: 25,
		toolTipContent: "<b>{label}</b>: {y}%",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - {y}%",
		dataPoints: [
          @php
          $zonesid = [];
          @endphp
        @foreach($zonedata as $key=> $data)
         @if($data->current_debit)
      		@php
  				$zonesid[$key] = $data->zone;
      				$totalpercent = $zonedataall[0]->current_debit/100;
  				$arr = explode(' ',trim($data->zone));
      		@endphp
			{ y: {{round($data->current_debit/$totalpercent,2)}}, label: "{{$arr[0]}}-{{$data->current_debit}}/" }@if($zonedata->keys()->last() != $key),@endif
		@endif
		@endforeach
		]
	}]
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
	animationEnabled: true,
	title:{
		text: "Categroy Wise Zone Chart "
	},

	axisY: {
		title: "Sales"

	},
	legend:{
		cursor: "pointer",
		fontSize: 16,
		itemclick: toggleDataSeries
	},
	toolTip:{
		shared: true
	},
	data: [
      @foreach($zonedata as $key=> $data)
         @if($data->current_debit)
     		@php
  				$arr = explode(' ',trim($data->zone));



      		@endphp

      {
		name: "{{$arr[0]}}",
		type: "spline",
		yValueFormatString: "#0.## ",
		showInLegend: true,
		dataPoints: [
           @foreach($categorys as $key=> $catid)

          	@php
          		 $categoryzonedata = DB::table('sales_ledgers as t1')
            // ->leftjoin('sales as t1','t1.id','t5.sale_id')
            ->leftjoin('dealers as t2', 't1.vendor_id', '=', 't2.id')
            ->leftjoin('dealer_areas as t6', 't2.dlr_area_id', '=', 't6.id')
            ->leftjoin('dealer_zones as t7', 't2.dlr_zone_id', '=', 't7.id')
             ->leftjoin('sales_products as t4','t1.product_id','=','t4.id')
            ->leftjoin('sales_categories as t9','t4.category_id','=','t9.id')
        	->where('t2.dlr_zone_id',$data->dlr_zone_id)
        	->where('t4.category_id',$catid->id)
        	->whereBetween('t1.ledger_date',[$fdate,$tdate])
          ->sum('total_price');
        	//->get();
    //    dd($categoryzonedata)
          	@endphp
			{ label: "{{$catid->category_name}}", y: {{$categoryzonedata}} },
			@endforeach

		]
	},

      	@endif
		@endforeach


	]
});
chart1.render();



}



</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


@endsection
