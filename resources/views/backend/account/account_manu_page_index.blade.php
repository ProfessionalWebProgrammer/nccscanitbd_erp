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
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block  text-center linkbtn"  >List & Entry</a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/others/type/create')}}" class="btn btn-block  text-center py-3 linkbtn" >Others Type</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('/company/name/create')}}" class="btn btn-block  text-center py-3 linkbtn" >Company Name</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('loan/borrowing/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Borrow Entry</a>
                        </div>
                    </div>
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('ltr/index')}}" class="btn btn-block  text-center py-3 linkbtn" >LTR Entry</a>
                        </div>
                    </div>
                  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('lease/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Lease Entry</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('bad/debt/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Bad Debt Entry</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('/all/income/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Income Entry</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('budget/index')}}" class="btn btn-block text-center py-3 linkbtn" >Budget</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('tax/create')}}" class="btn btn-block text-center py-3 linkbtn" >Taxes</a>
                        </div>
                    </div>
                  
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('financialExpense.create')}}" class="btn btn-block text-center py-3 linkbtn" >Financial Expense</a>
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