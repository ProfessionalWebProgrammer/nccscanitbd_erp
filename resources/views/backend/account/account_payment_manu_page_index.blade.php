@extends('layouts.account_dashboard')
@push('addcss')
<style>
    .alerts-border {
        border: 8px #ff0000 dotted;

        animation: blink 2s;
        animation-iteration-count: 10000;
    }
  .linkbtn{
  	border-radius: 15px; 
    font-weight: 800;
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
            
          <div class=" pb-3 pt-2">
                <div class="row  pt-3">
                    <div class="col-md-4 m-auto sales_main_button">
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block  text-center linkbtn" >Payment</a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                    
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('/bank/payment/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Bank Payment List</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('/all/payment/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Bank/Cash Payment</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('/cash/payment/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Cash Payment List</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ route('payment.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Payment Report</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ route('general.purchase.supplier.payment')}}" class="btn btn-block  text-center py-3 linkbtn" >General Supplier Payment</a>
                        </div>
                    </div>
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{  URL('/others/payment/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Others Payment </a>
                        </div>
                    </div>
                   
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ route('other.payment.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Other Payment Report</a>
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