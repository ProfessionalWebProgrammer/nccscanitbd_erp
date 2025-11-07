@extends('layouts.purchase_deshboard')
@push('addcss')
<style>
    .alerts-border {
        border: 3px solid #000;
    }
  
  .linkbutton{
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
        <div class="container  pt-5" style="position:relative;min-height:90vh !important">
          <div class="py-2"></div>
            <div class="alerts-border pt-3 pb-3">
                <div class="row  pt-3">
                    <div class="col-md-4 m-auto sales_main_button">
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block text-light text-center" style=" border: 3px solid #003064; border-radius: 8px;font-weight: 800;font-size: 24px; background-image:url({{asset('public/ruby.jpg')}});background-size: contain;">List & Entry</a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.create')}}" class="btn btn-block text-light text-center py-3 linkbutton" style="background-image:url({{asset('public/ruby.jpg')}});background-size: contain;">G. Purchase Entry</a>
                        </div>
                    </div>
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.product.list')}}" class="btn btn-block text-light text-center py-3 linkbutton" style="background-image:url({{asset('public/ruby.jpg')}});background-size: contain;">G. Product</a>
                        </div>
                    </div>
                  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.index')}}" class="btn btn-block text-light text-center py-3 linkbutton" style="background-image:url({{asset('public/ruby.jpg')}});background-size: contain;">G. Purchase List</a>
                        </div>
                    </div>
                   
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.generalcategory')}}" class="btn btn-block text-light text-center py-3 linkbutton" style="background-image:url({{asset('public/ruby.jpg')}});background-size: contain;">G. Category</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.generalsubcategory')}}" class="btn btn-block text-light text-center py-3 linkbutton" style="background-image:url({{asset('public/ruby.jpg')}});background-size: contain;">G. Sub-Category</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.supplier.index')}}" class="btn btn-block text-light text-center py-3 linkbutton" style="background-image:url({{asset('public/ruby.jpg')}});background-size: contain;">G. Supplier</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.general.wirehouse.index')}}" class="btn btn-block text-light text-center py-3 linkbutton" style="background-image:url({{asset('public/ruby.jpg')}});background-size: contain;">G. Wirehouse</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.transfer.index')}}" class="btn btn-block text-light text-center py-3 linkbutton" style="background-image:url({{asset('public/ruby.jpg')}});background-size: contain;">G. Transfer</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.stockout.index')}}" class="btn btn-block text-light text-center py-3 linkbutton" style="background-image:url({{asset('public/ruby.jpg')}});background-size: contain;">G. Stock Out</a>
                        </div>
                    </div>
                  
                </div>
            </div> <!-- /.alert Border -->
          <div class="alerts-border mt-3 pb-3 pt-2">
                <div class="row  pt-3">
                    <div class="col-md-4 m-auto sales_main_button">
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block text-center" style=" border: 3px solid #003064; border-radius: 8px;font-weight: 800;font-size: 24px;background-image:url({{asset('public/592e.jpg')}});background-size: contain;
">Reports</a>
                    </div>
                </div>
            
                <div class="row pt-5 px-3">
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.stock.report.index')}}" class="btn btn-block text-center py-3 linkbutton" style="background-image:url({{asset('public/592e.jpg')}});background-size: contain;
">G.P. Stock Report</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.ledger.index')}}" class="btn btn-block  text-center py-3 linkbutton" style="background-image:url({{asset('public/592e.jpg')}});background-size: contain;
">G. Ledger</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.total.stock.report.input')}}" class="btn btn-block text-center py-3 linkbutton" style="background-image:url({{asset('public/592e.jpg')}});background-size: contain;
">Total Stock Report</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('comparison.report.index')}}" class="btn btn-block text-center py-3 linkbutton" style="background-image:url({{asset('public/592e.jpg')}});background-size: contain;
">Comparison R.</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.stockout.report.index')}}" class="btn btn-block text-center py-3 linkbutton" style="background-image:url({{asset('public/592e.jpg')}});background-size: contain;
">Stock Out Report</a>
                        </div>
                    </div>
                  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.report.index')}}" class="btn btn-block text-center py-3 linkbutton" style="background-image:url({{asset('public/592e.jpg')}});background-size: contain;
">G.P. Report</a>
                        </div>
                    </div>
                    
                    
                   
					
                </div>
            </div> <!-- /.alert Border -->
          <div class="py-2"></div>
        </div>
    </div><!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection