@extends('layouts.sales_dashboard')

<style>
/* ==============new scc start ============= */
  
 

table {

  font-size: 11px!important;
  white-space: nowrap;
  margin: 0;
  border: none;
  border-collapse: separate;
  border-spacing: 0;
  table-layout: fixed;
  border: 1px solid black;
  overflow-y: scroll;
}
table td,
table th {
  border: 1px solid black;
  padding: 0.5rem 1rem;
  
}
  .content-wrapper{
    z-index: 1;
  margin-top:-43%!important;
  }
table thead th {
  padding: 8px;
  position: sticky;
  top: 0;
  z-index: 1;
  width: 45vw;
  background: #FA621C;
  color:#000;
}
   
table td {
  padding-bottom: 7px;
  text-align: center;
  
}

table tbody td:first-child {
  font-weight: 100;
  text-align: left;
  position: relative;
}
table thead th:first-child {
  position: sticky!important;
  left: 0;
  z-index: 1;
}
table tbody td:first-child {
  position: sticky;
  left: 0;
  background: #f5f5f5;
  z-index: 1;
}
caption {
  text-align: left;
  padding: 0.25rem;
  position: sticky;
  left: 0;
}

[role="region"][aria-labelledby][tabindex] {
  width: 100%;
  max-height: 600px;
  overflow: auto;
}
[role="region"][aria-labelledby][tabindex]:focus {
  //box-shadow: 0 0 0.5em rgba(0, 0, 0, 0.5);
  outline: 0;
}
  footer.main-footer{
  display: none!important;
    z-index: -1;
  }
  .hover_manu_content{
	    position: absolute;
    width: 100%;
    float: left;
    top: -390px;
    opacity: 0;
  background: #fff;
   margin-left: -15px;
}
  /* ========new css end====== */
</style>
@section('print_menu')

			<li class="nav-item">

                </li>
			<li class="nav-item ml-1">

                </li>
<li class="nav-item ml-1">

                </li>

@endsection

@section('content')
 
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


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
                 	<button class="btn btn-sm  btn-warning mt-1"  onclick="printland()"  id="printland"  >
                       PrintLands.
                    </button>

               </div>
           </div>

            <div class="container-fluid" style=" padding:0px 40px;min-height:85vh" id="contentbody">


              <div class="row pt-2">
                  	<div class="col-md-5 text-left">
                      <h5 class="text-uppercase font-weight-bold">Monthly Dealer Sales Product Wise Report <br> {{$month_name}} {{$year}}</h5>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
				<div role="region" aria-labelledby="caption" tabindex="0" style="min-height:600px;">
                <table id="reporttable">
                  <caption id="caption"></caption>
                  <thead>
                    <tr>
                      <th class="w-70">Dealer Name </th>
                               @foreach($product_categorys as $key=>$p_c)
									@php 
                              			$productQty = DB::table('sales_products')->where('category_id',$p_c->category_id)->count('id');
                              		@endphp 
                              <th colspan="{{$productQty}}" style="color: rgb(20, 88, 20); font-weight: bold;text-align: center">{{$p_c->category_name}}</th>


                               @endforeach
                              @foreach($product_categorys as $key=>$p_c)
                              <th style="color: rgb(0, 0, 0); font-weight: bold;text-align: center">{{$p_c->category_name}}</th>
							 @endforeach
                              <th>Total(Kg)</th>
                    </tr>
                    <tr>
                               
                               <th></th>
                             @foreach($product_categorys as $key=>$p_c)
                                @php 
                                $products = DB::table('sales_products')->where('category_id',$p_c->category_id)->orderby('product_name', 'asc')->get();
                                @endphp 
								@foreach($products as $key=>$val)
                               <th>{{$val->product_name}}</th>
								@endforeach 
							@endforeach 
                            @foreach($product_categorys as $key=>$p_c)
                              <th></th>
							 @endforeach
                            <th></th>
                          </tr>
                          </thead>
                           @php
								 $grand_total_kg = 0;
                           @endphp
                  	<tbody>
                       @foreach($dealers as $val)
                             

                          
                            		@php 
                            			$subTotal = 0;
                            		@endphp 
                                    <tr>
                                      <td>{{$val->name}}</td>
                                      @foreach($product_categorys as $key=>$p_c)
                                               
                                     	@php 
                                      		$products = DB::table('sales_products')->where('category_id',$p_c->category_id)->orderby('product_name', 'asc')->get();
                                      		
                                      
                                      @endphp 
                                       @foreach($products as $key=>$product)
                                      			@php
                                               
                                                   $data = DB::table('montly_sales_targets as t1')
                                                              ->where('t1.product_id',$product->id)->where('t1.category_id',$p_c->category_id)
                                                              ->where('t1.dealer_id',$val->dealer_id)->whereBetween('t1.date', [$fdate, $tdate])->groupBy('t1.dealer_id')->sum('t1.qty_kg');

                                                        $grand_total_kg += $data ?? 0;
                                      					$subTotal += $data ?? 0;
                                      					
                                                    @endphp 
                                      	@if(!empty($data))
                                         <td  style="text-align: center;padding-top:7px;">{{number_format($data,2)}}  </td>
                                        @else 
                  						<td></td>
                                        @endif 
                  						 @endforeach
                  						
                                      @endforeach
                                      @foreach($product_categorys as $key=>$p_c)
                                      	@php 
                                      		$subTotalCate = DB::table('montly_sales_targets as t1')->where('t1.category_id',$p_c->category_id)
                                                              ->where('t1.dealer_id',$val->dealer_id)->whereBetween('t1.date', [$fdate, $tdate])->sum('t1.qty_kg');
                                      	@endphp 
                                      <th>{{number_format($subTotalCate,2)}}</th>
                                     @endforeach
                                      <th>{{number_format($subTotal,2)}}</th>
                                    </tr>
                              @endforeach
                      <tr style="color: black;font-size:16px; font-weight: 600;">
                         <td > <b>Grand Total:</b></td>
                         <td colspan="100%" style="text-align:left; padding-left:20px;"><b>{{$grand_total_kg}} (Kg)</b></td>                           
                     </tr>
                    </tbody>
                  </table>
                  

               {{--  <div class="py-4 ">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed table-responsive" style="font-size: 8px; text-transform: capitalize;">
                        <thead style="border: 1px solid #515151;">
                            <tr>
                            <td class="w-70">Dealer Name </td>
                               @foreach($product_categorys as $key=>$p_c)
									@php 
                              			$productQty = DB::table('sales_products')->where('category_id',$p_c->category_id)->count('id');
                              		@endphp 
                              <th colspan="{{$productQty}}" style="color: rgb(20, 88, 20); font-weight: bold;text-align: center">{{$p_c->category_name}}</th>


                               @endforeach
                              @foreach($product_categorys as $key=>$p_c)
                              <th style="color: rgb(20, 88, 20); font-weight: bold;text-align: center">{{$p_c->category_name}}</th>
							 @endforeach
                              <th>Total(Kg)</th>
                         
                              
                            </tr>
                          <tr class="table-header-fixt-top">
                               
                               <th></th>
                             @foreach($product_categorys as $key=>$p_c)
                                @php 
                                $products = DB::table('sales_products')->where('category_id',$p_c->category_id)->orderby('product_name', 'asc')->get();
                                @endphp 
								@foreach($products as $key=>$val)
                               <th>{{$val->product_name}}</th>
								@endforeach 
							@endforeach 
                            @foreach($product_categorys as $key=>$p_c)
                              <th></th>
							 @endforeach
                            <th></th>
                          </tr>
                          </thead>
                           @php
								 $grand_total_kg = 0;
                           @endphp

                          <tbody>
 

                        
                          @foreach($dealers as $val)
                             

                          
                            		@php 
                            			$subTotal = 0;
                            		@endphp 
                                    <tr>
                                      <td>{{$val->name}}</td>
                                      @foreach($product_categorys as $key=>$p_c)
                                               
                                     	@php 
                                      		$products = DB::table('sales_products')->where('category_id',$p_c->category_id)->orderby('product_name', 'asc')->get();
                                      		
                                      
                                      @endphp 
                                       @foreach($products as $key=>$product)
                                      			@php
                                               
                                                   $data = DB::table('montly_sales_targets as t1')
                                                              ->where('t1.product_id',$product->id)->where('t1.category_id',$p_c->category_id)
                                                              ->where('t1.dealer_id',$val->dealer_id)->whereBetween('t1.date', [$fdate, $tdate])->groupBy('t1.dealer_id')->sum('t1.qty_kg');

                                                        $grand_total_kg += $data ?? 0;
                                      					$subTotal += $data ?? 0;
                                      					
                                                    @endphp 
                                      	@if(!empty($data))
                                         <td  style="text-align: center;padding-top:11px">{{number_format($data,2)}}  </td>
                                        @else 
                  						<td></td>
                                        @endif 
                  						 @endforeach
                  						
                                      @endforeach
                                      @foreach($product_categorys as $key=>$p_c)
                                      	@php 
                                      		$subTotalCate = DB::table('montly_sales_targets as t1')->where('t1.category_id',$p_c->category_id)
                                                              ->where('t1.dealer_id',$val->dealer_id)->whereBetween('t1.date', [$fdate, $tdate])->sum('t1.qty_kg');
                                      	@endphp 
                                      <th>{{number_format($subTotalCate,2)}}</th>
                                     @endforeach
                                      <th>{{number_format($subTotal,2)}}</th>
                                    </tr>
                              @endforeach
                        
                       

                           <tr style="color: black;background-color: #827d789c; font-size:16px; font-weight: bold;">
                               <td colspan="2"> <b>Grand Total:</b></td>
                               <td colspan="100%"><b>{{$grand_total_kg}} (Kg)</b></td>                           
                         </tr>
                         </tbody>
                    </table>
                </div> --}}
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
                filename: "Monthly Employee Target Report.xls"
            });
        });
    });
</script>
@endsection
