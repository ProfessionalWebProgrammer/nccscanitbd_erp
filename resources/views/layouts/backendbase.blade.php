<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NCC | V.3.5</title>

	
  
    @include('_partials_.css')

  
  <link rel="stylesheet" href="{{ asset('public/backend/dist/css/customcss.css') }}">
  
    <style>
      
    .hovermanue_icon{
          
    	display: none !important;
    
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

<body class="hold-transition sidebar-mini" style="font-family: auto !important;">
    <div class="wrapper">
        <!-- Navbar -->
        @include('_partials_.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ URL('/') }}" class="brand-link">
                <img src="{{ asset('public/backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">SBMS | V.3.5</span>
            </a>

            @include('_partials_.sidebar')
        </aside>

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

   
    

</body>

</html>
