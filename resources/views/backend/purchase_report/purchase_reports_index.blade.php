@extends('layouts.purchase_deshboard')
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
        <div class="container  py-5" style="position:relative;min-height:85vh">
            <div class="py-3">
            <div class="alerts-border pb-3 pt-2">
                <div class="row  pt-3">
                    <div class="col-md-4 m-auto sales_main_button">
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block  text-center linkbtn" >Quick Purchase Reports</a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('purchase.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Purchase Report</a>
                        </div>
                    </div>
                  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('bag.purchase.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Purchase Bag</a>
                        </div>
                    </div>
                  
                  {{--  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('purchase.stock.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >RM Medicine Stock Report</a>
                        </div>
                    </div>
                  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('purchase.inventory.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >RM Inv Rec Report</a>
                        </div>
                    </div>  --}}
                  
                  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('current.liabilities.report')}}" class="btn btn-block  text-center py-3 linkbtn" >Current Liabilities</a>
                        </div>
                    </div>
                  
                  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{url('/top/ten/purchase/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Top Ten Purchase Report</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('lcEntry.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >LC Report</a>
                        </div>
                    </div>
                   
                  
                </div>
            </div> <!-- /.alert Border -->
              
              
              
              
          <div class="alerts-border my-3 pb-3 pt-2">
                <div class="row  pt-3">
                    <div class="col-md-4 m-auto sales_main_button">
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block text-dark text-center linkbtn" >M/Y Reports</a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('monthly.purchase.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Monthly Purchase Report</a>
                        </div>
                    </div>
                  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('cogs.report')}}" class="btn btn-block text-center py-3 linkbtn" >C.O.G.S Report</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('yearly.purchase.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Yearly Purchase Report</a>
                        </div>
                    </div>
					<div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('clpo.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >CL.PO Report</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('purchase.delivery.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Purchase Order Report</a>
                        </div>
                    </div>
                </div>
            
            
            
            
            </div> <!-- /.alert Border -->
         {{-- <div class="alerts-border pb-3 pt-2">
                <div class="row  pt-3">
                    <div class="col-md-4 m-auto sales_main_button">
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block text-dark text-center linkbtn" >Production Reports</a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('production.stockout.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Production Stockout Report</a>
                        </div>
                    </div> 
                  
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('production.cogm.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >C.O.G.M Report</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('production.newCogm.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >New C.O.G.M Report</a>
                        </div>
                    </div>
                  
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('production.progress.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Production Progress Report</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('individual.production.stockout.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Individual Production Stockout Report</a>
                        </div>
                    </div> 

                </div>
            </div>  --}}<!-- /.alert Border -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection