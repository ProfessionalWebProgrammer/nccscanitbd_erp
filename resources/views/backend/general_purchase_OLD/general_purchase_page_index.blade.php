@extends('layouts.purchase_deshboard')
@push('addcss')
<style>
    .alerts-border {
        border: 8px #ff0000 dotted;

        animation: blink 2s;
        animation-iteration-count: 10000;
    }

    @keyframes blink {
        25% {
            border-color: lime;
        }
        50% {
            border-color: blue;
        }
       75% {
            border-color: yellow;
        }
      
      100% {
            border-color: green;
        }
    }
</style>
@endpush
@section('content')

<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container  pt-5" style="position:relative;">
            <div class="alerts-border pb-3 pt-2">
                <div class="row  pt-3">
                    <div class="col-md-4 m-auto sales_main_button">
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block btn-outline-primary text-center" style=" border: 3px solid #003064; border-radius: 8px;font-weight: 800;font-size: 24px;">List & Entry</a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.create')}}" class="btn btn-block btn-primary text-center py-3" style="border-radius: 15px; font-weight: 800;">G. Purchase Entry</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.index')}}" class="btn btn-block btn-primary text-center py-3" style="border-radius: 15px; font-weight: 800;">G. Purchase List</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.product.list')}}" class="btn btn-block btn-primary text-center py-3" style="border-radius: 15px; font-weight: 800;">G. Product</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.generalcategory')}}" class="btn btn-block btn-primary text-center py-3" style="border-radius: 15px; font-weight: 800;">G. Category</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.generalsubcategory')}}" class="btn btn-block btn-primary text-center py-3" style="border-radius: 15px; font-weight: 800;">G. Sub-Category</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.supplier.index')}}" class="btn btn-block btn-primary text-center py-3" style="border-radius: 15px; font-weight: 800;">G. Supplier</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.general.wirehouse.index')}}" class="btn btn-block btn-primary text-center py-3" style="border-radius: 15px; font-weight: 800;">G. Wirehouse</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.transfer.index')}}" class="btn btn-block btn-primary text-center py-3" style="border-radius: 15px; font-weight: 800;">G. Transfer</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.stockout.index')}}" class="btn btn-block btn-primary text-center py-3" style="border-radius: 15px; font-weight: 800;">G. Stock Out</a>
                        </div>
                    </div>
                  
                </div>
            </div> <!-- /.alert Border -->
          <div class="alerts-border my-3 pb-3 pt-2">
                <div class="row  pt-3">
                    <div class="col-md-4 m-auto sales_main_button">
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block btn-outline-primary text-center" style=" border: 3px solid #003064; border-radius: 8px;font-weight: 800;font-size: 24px;">Reports</a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.ledger.index')}}" class="btn btn-block btn-primary text-center py-3" style="border-radius: 15px; font-weight: 800;">G. Ledger</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('comparison.report.index')}}" class="btn btn-block btn-primary text-center py-3" style="border-radius: 15px; font-weight: 800;">Comparison R.</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.report.index')}}" class="btn btn-block btn-primary text-center py-3" style="border-radius: 15px; font-weight: 800;">G.P. Report</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.stock.report.index')}}" class="btn btn-block btn-primary text-center py-3" style="border-radius: 15px; font-weight: 800;">G.P. Stock Report</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('general.purchase.total.stock.report.input')}}" class="btn btn-block btn-primary text-center py-3" style="border-radius: 15px; font-weight: 800;">Total Stock Report</a>
                        </div>
                    </div>

                </div>
            </div> <!-- /.alert Border -->
        </div>
    </div><!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection