@extends('layouts.crm_dashboard')

@section('content')
<style>

  .menuclass{
  display: none;
  }
  </style>

<div class="content-wrapper">
    <!-- Main content -->
    <div class="content" >
      <div class="container-fluid" style="background:#fff!important; min-height:85vh;">

       <div class="row">
        <div class="col-md-2 mt-5">
             <!-- Main Sidebar Container -->
        <aside >
            @include('_partials_.sidebar')
        </aside>
        </div>
         <div class="col-md-10">

          <div class="mb-3" >
          @php
              $authid = Auth::id();
              $salesdata = DB::table('permissions')
                   ->where('head', 'Sales')
                   ->where('user_id', $authid)
                   ->pluck('name')
                   ->toArray();
              $marketingdata = DB::table('permissions')
                       ->where('head', 'Marketing')
                       ->where('user_id', $authid)
                       ->pluck('name')
                       ->toArray();

           @endphp


        <div class="row pt-3">
            <div class="col-md-4 m-auto sales_main_button">

                <a href="{{route('crm.dashboard')}}" class="text-center pt-1 pb-2 py-3 btn btn-block  text-center linkbtn">Marketing Department</a>
            </div>
        </div>


          <div class="row pt-5 px-3 text-center">
            @if (in_array('marketing', $marketingdata))
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('marketing.item.index')}}" class="btn btn-block  text-center py-3 linkbtn">MT Products</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('inter.company.index')}}" class="btn btn-block  text-center py-3 linkbtn">Inter Company</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('marketingOrder.item.index')}}" class="btn btn-block  text-center py-3 linkbtn">Orders</a>
                </div>
            </div>
            @endif
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('marketingOrder.tracking.index')}}" class="btn btn-block  text-center py-3 linkbtn">Order Tracking</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('marketingOrder.report.index')}}" class="btn btn-block  text-center py-3 linkbtn">Order Report</a>
                </div>
            </div>
{{--
              <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                  <div class="mx-1">
                    <a href="{{route('client.index')}}" class="btn btn-block  text-center py-3 linkbtn">Client</a>
                  </div>
              </div>

              <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                  <div class="mx-1">
                    <a href="{{route('progress.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Progress</a>
                  </div>
              </div>

             <div class="col-md-4 p-1 sales_button" style="border-radius: 8px;">
                  <div class="mx-1">
                    <a href="{{route('progress.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Progress Report</a>
                  </div>
              </div>

             <div class="col-md-4 p-1 sales_button" style="border-radius: 8px;">
                  <div class="mx-1">
                    <a href="{{route('client.requirement.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Client Requirement</a>
                  </div>
              </div>

             <div class="col-md-4 p-1 sales_button" style="border-radius: 8px;">
                  <div class="mx-1">
                    <a href="{{route('requirement.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Client Requirement Report</a>
                  </div>
              </div> --}}



          </div>
        </div>


                {{--    <div class="col-lg-12" style="height:390px;">
                           <h4 style="    display: flex;align-items: center;justify-content: center;width: 100%;height: 100%;">CRM Deshboard</h4>

                    </div>
                    <div class="col-lg-12 px-5" style="">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search here" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="button" id="button-addon2" style="margin-left: -9px;"><i class="fas fa-search"></i></button>
                        </div>
                      </div>
                    </div>  --}}


        </div>

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
