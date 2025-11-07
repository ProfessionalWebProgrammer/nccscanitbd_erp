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

      .content-wrapper .container{
      max-width: 1140px !important;
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
             $purchasedata = DB::table('permissions')
                 ->where('head', 'Purchase')
                 ->where('user_id', $authid)
                 ->pluck('name')
                 ->toArray();
             $accountsdata = DB::table('permissions')
                 ->where('head', 'Accounts')
                 ->where('user_id', $authid)
                 ->pluck('name')
                 ->toArray();
             $settingsdata = DB::table('permissions')
                 ->where('head', 'Settings')
                 ->where('user_id', $authid)
                 ->pluck('name')
                 ->toArray();


     @endphp
  {{-- style="background-image:url({{asset('public/ruby.jpg')}});background-size: contain;" --}}
        {{--  <div class="row pt-3">
           <div class="col-md-8 m-auto">
             <div class="row">
               <div class="col-md-3">
             	 @if (!empty($salesdata))
                      <a class="btn btn-primary btn-xl my-2  w-100 from-control mx-2 mainmanu" href="{{route('sales.dashboard')}}">Sales</a>
                  @endif
             	</div>
             <div class="col-md-3">
             	 @if (!empty($purchasedata))
                      <a class="btn btn-primary btn-xl my-2  w-100 from-control mx-2 mainmanu" href="{{route('purchase.dashboard')}}" style="background: #bd7e0b; border-color:#bd7e0b;">Purchase</a>
                  @endif
             </div>

               <div class="col-md-3">
                  @if (!empty($settingsdata))
                 <a class="btn btn-primary btn-xl my-2 w-100 from-control mx-2 mainmanu" href="{{route('settings.dashboard')}}" style="background: #DC3545; border-color:#DC3545;">Settings</a>
                 @endif
               </div>
               <div class="col-md-3">
                  @if (!empty($settingsdata))
                 <a class="btn btn-primary btn-xl my-2 w-100 from-control mx-2 mainmanu" href="{{route('crm.dashboard')}}" style="background: #ae15d5; border-color:#ae15d5;">CRM</a>
                 @endif
               </div>
             </div>
         	</div>
          </div> --}}
        <div class="row pt-3">
          	<div class="col-md-4 m-auto sales_main_button">
              	<a href="{{route('account.dashboard')}}" class="text-center pt-1 pb-2 py-3 btn btn-block text-center text-dark" style=" border: 3px solid #003064; border-radius: 8px;font-weight: 800;font-size: 24px;">Accounts Department</a>
        	</div>
        </div>
         <div class="row pt-5 px-3">
                   @if (in_array('receive', $accountsdata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{URL('/account/manu/receive')}}" class="btn btn-block text-center py-3 linkbtn" >Receive</a>
                        </div>
                    </div>
                  @endif

                  @if (in_array('payment', $accountsdata))

                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('account.manu.payment')}}" class="btn btn-block text-center py-3 linkbtn" >Payment</a>
                        </div>
                    </div>
                   @endif

                   @if (in_array('daybook', $accountsdata))

                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{URL('/report/daybook/index')}}" class="btn btn-block text-center py-3 linkbtn">Daybook</a>
                        </div>
                    </div>
                   @endif
                   @if (in_array('acreate', $accountsdata))
                   <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{URL('/amount/transfer/list')}}" class="btn btn-block text-center py-3 linkbtn" >Contra Entry</a>
                        </div>
                    </div>
                   <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{URL('/journal/entry/index')}}" class="btn btn-block text-center py-3 linkbtn" >Journal</a>
                        </div>
                    </div>
                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{URL('/expanse/payment/index')}}" class="btn btn-block text-center py-3 linkbtn">Expense</a>
                        </div>
                    </div>
                   <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('account.manu.asset')}}" class="btn btn-block text-center py-3 linkbtn" >Asset</a>
                        </div>
                    </div>
                   <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{URL('/accounts/equity/index')}}" class="btn btn-block text-center py-3 linkbtn" >Equity</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{URL('/direct/labour/cost/list')}}" class="btn btn-block text-center py-3 linkbtn" >Costing</a>
                        </div>
                    </div>

                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{ URL('/master/bank/index')}}" class="btn btn-block text-center py-3 linkbtn">Bank/Cash</a>
                        </div>
                    </div>



                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('account.manu.index')}}" class="btn btn-block text-center py-3 linkbtn" >Others </a>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                      <div class="mx-1">
                        <a href="{{route('chat.of.account.extended.trail.balance.input')}}" class="btn btn-block text-center py-3 linkbtn" >Extended Trail Balance</a>
                      </div>
                  </div>

                  @if (in_array('incomestement', $accountsdata))

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('account.manu.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Reports </a>
                        </div>
                    </div>
                  @endif
                  </div>
        </div>
      </div><!-- /.container-fluid -->

  {{-- <div style="position: absolute; padding:10px" class="menuclass">
      <a href="{{route('account.dashboard')}}" class="btn btn-sm btn-primary">Menu </a>

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

  <script>

  </script>








</body>

</html>
