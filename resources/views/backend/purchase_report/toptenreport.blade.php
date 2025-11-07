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
                      <h5 class="text-uppercase font-weight-bold">Top Tan Dealer Pic Chart</h5>


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
            $("#reporttable").table2excel({
                filename: "Trail_balance.xls"
            });
        });
    });


  window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2", // "light2", "dark1", "dark2"
	animationEnabled: true, // change to true
	title:{
		text: "Top Ten Purchase Chart"
	},
    toolTip: {
		shared: true
	},

    data: [
	{
		// Change type to "bar", "area", "spline", "pie",etc.
		type: "column",
        name: "Purchase Amount",
      yValueFormatString: "#,##0.# BDT",
    	dataPoints: [
        @foreach($data as $d)

			{ label: "{{$d->supplier_name}}", y: {{$d->amount}} },
		@endforeach


		]
	}

	]
});
chart.render();



}



</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


@endsection
