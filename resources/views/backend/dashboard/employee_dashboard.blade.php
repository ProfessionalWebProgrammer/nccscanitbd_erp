@extends('layouts.employee_dashboard')

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
                <a href="{{route('hrpayroll.employee.selfServiceProfile.dashboard')}}" class="text-center pt-1 pb-2 py-3 btn btn-block  text-center linkbtn">Employee Profile</a>
            </div>
        </div>

          <div class="row pt-5 px-3 text-center">
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('hrpayroll.employee.selfServiceProfile.index')}}" class="btn btn-block  text-center py-3 linkbtn">My Profile </a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('hrpayroll.employee.leaveApplication.index')}}" class="btn btn-block  text-center py-3 linkbtn">Leave Application</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('hrpayroll.employee.myAttendance.index')}}" class="btn btn-block  text-center py-3 linkbtn">My Attendance</a>
                </div>
            </div>
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
