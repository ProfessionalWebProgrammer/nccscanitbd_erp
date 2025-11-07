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
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block  text-center linkbtn" >Production Reports</a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                   
                  {{-- <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('sales.stock.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >F.G Stock/Production Report </a>
                        </div>
                    </div>  --}}
                  @if($userId != 169)
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('purchase.stock.ledger.index')}}" class="btn btn-block text-center py-3 linkbtn" >R. M Stock Ledger </a>
                        </div>
                    </div>
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('purchase.bag.stock.ledger.index')}}" class="btn btn-block text-center py-3 linkbtn" >PP Bag Stock Ledger </a>
                        </div>
                    </div>
                  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('purchase.stock.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >R.M - Medicine Stock Report</a>
                        </div>
                    </div>
                  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('purchase.inventory.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >RM Inv Rec Report</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('production.stockout.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Production J.V Report</a>
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
                            <a href="{{route('daily.production.summary.details.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Daily Production Summary Report</a>
                        </div>
                    </div>
                  @endif
                  
                </div>
            </div> <!-- /.alert Border -->
         
            </div>
        </div>
    </div><!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection