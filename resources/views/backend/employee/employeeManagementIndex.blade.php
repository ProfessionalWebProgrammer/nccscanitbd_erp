@extends('layouts.hrPayroll_dashboard')

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
              $settingsdata = DB::table('permissions')
                  ->where('head', 'Settings')
                  ->where('user_id', $authid)
                  ->pluck('name')
                  ->toArray();

           @endphp


        <div class="row pt-3">
            <div class="col-md-4 m-auto sales_main_button">
                <a href="{{route('employee.management.list')}}" class="text-center pt-1 pb-2 py-3 btn btn-block  text-center linkbtn" >Employee Management</a>
            </div>
        </div>


          <div class="row pt-5 px-3 text-center">

            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('employee.list')}}" class="btn btn-block  text-center py-3 linkbtn">Employee Information</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.brach.transfer.list') }}" class="btn btn-block  text-center py-3 linkbtn">Employee Management</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('employee.extended.pim.list')}}" class="btn btn-block  text-center py-3 linkbtn">Extended PIM</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('hrpayroll.employee.promotion.list')}}" class="btn btn-block  text-center py-3 linkbtn">Promotion</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('hrpayroll.employee.increment.list')}}" class="btn btn-block  text-center py-3 linkbtn">Increment</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('hrpayroll.employee.reward.list')}}" class="btn btn-block  text-center py-3 linkbtn">Reward</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('hrpayroll.employee.product.list')}}" class="btn btn-block  text-center py-3 linkbtn">Product </a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('hrpayroll.employee.production.list')}}" class="btn btn-block  text-center py-3 linkbtn">Production</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('employee.AppointmentLetter.form')}}" class="btn btn-block  text-center py-3 linkbtn">Appointment Letter</a>
                </div>
            </div>

          {{--  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.overtime.list') }}" class="btn btn-block  text-center py-3 linkbtn">E. Overtime List</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.leave.of.absent.form') }}" class="btn btn-block  text-center py-3 linkbtn">E. Leave Of Absence</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.leave.of.absent.list') }}" class="btn btn-block  text-center py-3 linkbtn">Leave Of Absence List</a>
                </div>
            </div>

              <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                  <div class="mx-1">
                    <a href="{{route('client.index')}}" class="btn btn-block  text-center py-3 linkbtn"></a>
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
