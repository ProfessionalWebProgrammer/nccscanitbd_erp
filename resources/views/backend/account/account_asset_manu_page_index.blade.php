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
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block  text-center linkbtn" >Assets </a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                    
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('/asset/short/term/libilities/list')}}" class="btn btn-block  text-center py-3 linkbtn" >Short Term Libilities</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/asset/long/term/libilities/list')}}" class="btn btn-block  text-center py-3 linkbtn" >Long Term Libilities</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('/asset/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Assets Entry</a>
                        </div>
                    </div>
                  
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/asset/type')}}" class="btn btn-block  text-center py-3 linkbtn" >Assets Type</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/asset/clint/list')}}" class="btn btn-block  text-center py-3 linkbtn" >Assets Client</a>
                        </div>
                    </div>
                   
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/asset/category')}}" class="btn btn-block  text-center py-3 linkbtn" >Assets Category</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{  URL('/asset/product')}}" class="btn btn-block  text-center py-3 linkbtn" >Asset Head</a>
                        </div>
                    </div>
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/asset/license')}}" class="btn btn-block  text-center py-3 linkbtn" >Assets License</a>
                        </div>
                    </div>
                  
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/asset/investment/list')}}" class="btn btn-block  text-center py-3 linkbtn" >Assets Investment</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/asset/Intangible/list')}}" class="btn btn-block  text-center py-3 linkbtn" >Assets Intangible</a>
                        </div>
                    </div> 
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/asset/depreciation/list')}}" class="btn btn-block  text-center py-3 linkbtn" >Assets Depreciation</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{  URL('/asset/report/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Assets Report</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{  route('asset.depreciation.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Assets Depreciation Report</a>
                        </div>
                    </div>
                  {{--
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{  URL('/asset/notification/list')}}" class="btn btn-block  text-center py-3 linkbtn" >Assets Notification</a>
                        </div>  --}}
                  
                  
                  

                </div>
            </div> <!-- /.alert Border -->
        </div>
    </div><!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection