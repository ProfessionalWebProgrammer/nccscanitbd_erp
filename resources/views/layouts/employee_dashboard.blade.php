<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NCC | V.3.5</title>




    @include('_partials_.css')

    <link rel="stylesheet" href="{{ asset('public/css/customcss_sales.css') }}">

    <style>
    #pushnavbar{
    	display:none;
    }

      .hovermanu{
          display: inline-block;
        font-size:25px;


      }
       .linkbtn{
      	font-size: 16px;
        font-weight: 800;
        border: 3px solid #003064;
        border-radius: 8px;
        padding: 20px 8px !important
      }

            .content-wrapper .container-fluid, .content-wrapper .container{

      background:#ffffff !important;
        padding:0px 40px !important;
        min-height:85vh !important;
}



  </style>

</head>


<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
@section('headernavmanuname')
  <li class="nav-item mr-3">
   <a href="{{url('/')}}" class="navbar-brand">
        <img src="{{ asset('public/backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">SBMS | V.3.5</span>
      </a>
    </li>
 @endsection
<body class="hold-transition sidebar-collapse layout-top-nav">
<div class="wrapper">
        <!-- Navbar -->
        @include('_partials_.navbar')

  {{-- FOr Manu --}}



    <div class="container-fluid" style="position:relative;">
       <div class="hover_manu_content" >
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
              	<a href="{{route('hrpayroll.employee.selfServiceProfile.dashboard')}}" class="text-center pt-1 pb-2 py-3 btn btn-block  text-center linkbtn" >Employee Profile</a>
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
      </div><!-- /.container-fluid -->

   {{-- <div style="position: absolute; padding:10px"  class="menuclass">
      <a href="{{route('crm.dashboard')}}" class="btn btn-sm btn-primary">Menu </a>

  </div> --}}


        @yield('content')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
      @include('_partials_.notification_modal')

        @include('_partials_.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->


    @include('_partials_.js')

    @include('_partials_.sales_js')

</body>

</html>
