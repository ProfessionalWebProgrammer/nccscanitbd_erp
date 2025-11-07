@extends('layouts.sales_dashboard')
@push('addcss')
<style>
    .alerts-border {
        border: 3px solid #000;
    }
  
  .linkbtn{
  	border-radius: 15px; 
    font-weight: 800;
    font-size: 18px;
  }
</style>
@endpush
@section('content')

<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container  pt-5" style="position:relative;">
        <div class="py-3">
            <div class="alerts-border pb-3 pt-2">
                <div class="row  pt-3">
                    <div class="col-md-4 m-auto sales_main_button">
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block  text-center linkbtn">Quick Sales Reports</a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('daily.sales.report.index')}}" class="btn  linkbtn  text-center py-3" >Daily Sales Report</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('daily.sales.order.report.index')}}" class="btn  linkbtn  text-center py-3" >Daily Order Report</a>
                        </div>
                    </div>
                    
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('brand.wise.sales.report.index')}}" class="btn   text-center py-3 linkbtn" >Brand Wise Sales R.</a>
                        </div>
                    </div>
                    
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('short.summary.report.index')}}" class="btn   text-center py-3 linkbtn" >Category Wise Sales R.</a>
                        </div>
                    </div>
                    
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('category.wise.summary.report.index')}}" class="btn   text-center py-3 linkbtn" >Category Wise Sumary R.</a>
                        </div>
                    </div>
                    
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('sku.wise.cogs.report.index')}}" class="btn   text-center py-3 linkbtn" >SKU Wise Cogs R.</a>
                        </div>
                    </div>
                    
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('sales.short.summary.cogs.report.index')}}" class="btn   text-center py-3 linkbtn" >Sales Category Wise Cogs R.</a>
                        </div>
                    </div>
                    
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('catSales.order.report.index')}}" class="btn   text-center py-3 linkbtn" >Category Wise Order R.</a>
                        </div>
                    </div>
                   

                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('trail.balance.index')}}" class="btn btn-block  linkbtn text-center py-3" >Trail Balance</a>
                          	
                        </div>
                    </div>

                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            
                          	<a href="{{route('zonewise.pie.chart.index')}}" class="btn btn-block   linkbtn text-center py-3" >Zone Pie Chart</a>
                        </div>
                    </div>
                  
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('sales.total.ledger.index')}}" class="btn  linkbtn text-center py-3" > Total Sales Ledger</a>
                        </div>
                    </div>
                    
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('sales.stock.total.report.index')}}" class="btn btn-block  linkbtn text-center py-3" >F.G Stock Report (Error n/a)</a>
                        </div>
                    </div>
                    
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('sales.cogs.report')}}" class="btn btn-block  linkbtn text-center py-3" >COGS</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('vendor.sales.summary.report.input')}}" class="btn btn-block  linkbtn text-center py-3" >Vendor Sales Summary Report</a>
                        </div>
                    </div>
                  
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{url('/sales/progress/report/individual/input')}}" class="btn btn-block  linkbtn text-center py-3" >Sales Progress Report (Individual)</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('stock.trunover.report.input')}}" class="btn btn-block  linkbtn text-center py-3" >Stock Trunover Report</a>
                        </div>
                    </div>
                  
                     <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('product.comparison.report.index')}}" class="btn btn-block  linkbtn text-center py-3" >Product Wise Comparison Report</a>
                        </div>
                    </div>

                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('emp.salesOrder.report.index')}}" class="btn btn-block  linkbtn text-center py-3" >Employee wise Order Report</a>
                        </div>
                    </div>

                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('emp.orderDelivery.report.index')}}" class="btn btn-block  linkbtn text-center py-3" >Employee wise Delivery Report</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('emp.salesDetails.report.index')}}" class="btn btn-block  linkbtn text-center py-3" >Sales Details Report</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('dealer.sales.report.index')}}" class="btn btn-block  linkbtn text-center py-3" >Dealer Wise Report</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.discount.report.index')}}" class="btn btn-block text-center py-3 linkbtn">Discount Report</a>
                        </div>
                    </div>

                </div>
              
              
              
            </div> <!-- /.alert Border -->
          <div class="alerts-border my-3 pb-3 pt-2">
                <div class="row  pt-3">
                    <div class="col-md-4 m-auto sales_main_button">
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block text-dark text-center linkbtn"  >Monthly Sales Reports</a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('monthly.sales.statement.report.index')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Monthly Sales Statement Report</a>
                        </div>
                    </div>

                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('various.vendor.report.index')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Various Report</a>
                        </div>
                    </div>

                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('zonewise.sales.statement.report.index')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Zone Report</a>
                        </div>
                    </div>
                  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('monthly.employee.target.report.index')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Employee Sales Report (Product wise) </a>
                          {{-- <a href="{{route('monthly.employee.target.report.index')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Monthly Employee Target Report</a> --}}
                        </div>
                    </div>
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('monthly.dealer.sales.target.report.index')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Dealer Sales Report (Product wise) </a>
                        </div>
                    </div>
                  

                </div>
            
            
            </div> <!-- /.alert Border -->
          
          <div class="alerts-border my-3 pb-3 pt-2">
            
                <div class="row  pt-3">
                    <div class="col-md-4 m-auto sales_main_button">
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block text-dark text-center linkbtn" >Yearly Sales Reports</a>
                    </div>
                </div>
            
                <div class="row pt-5 px-3">
                  
                  
                  
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('yearly.sales.statement.report.index')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Yearly Sales Statement Report</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('top.ten.dealer.d.report.index')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Top Ten Dealer Report</a>
                        </div>
                    </div>
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('top.ten.dealer.report.index')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Top Ten Dealer Pie Chart</a>
                        </div>
                    </div>
                  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('yearly.vendor.sales.report.index')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Yearly Vendor Sales Report</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('yearly.vendor.daterange.sales.report.index')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Yearly Vendor D. Sales Report</a>
                        </div>
                    </div>
                    
                  {{--    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('yearly.sales.target.report.index')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Yearly Sales Target Report</a>
                        </div>
                    </div> --}}
                  
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('salesReport.Yaerly_Shortsummary_target_report_input')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Yearly SS Target Report</a>
                        </div>
                    </div>  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('salesReport.Yaerly_Shortsummary_company_report_input')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Yearly SS Company Report</a>
                        </div>
                    </div>
                  
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('fiscal.year.report.index')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Fiscal Year Report</a>
                        </div>
                    </div>
                  
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('fiscal.year.comparison.report.index')}}" class="btn btn-block text-dark linkbtn text-center py-3" >Fiscal Year Comparison Report</a>
                        </div>
                    </div>

                </div>
            </div> <!-- /.alert Border -->
        </div>
        </div>
    </div><!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection