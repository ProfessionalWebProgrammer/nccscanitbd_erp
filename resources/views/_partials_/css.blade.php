<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{ asset('public/backend/plugins/fontawesome-free/css/all.min.css') }}">
<!-- IonIcons 
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('public/backend/dist/css/adminlte.min.css') }}">



<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('public/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('public/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Theme style -->

 <script src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> 

<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('public/backend/plugins/daterangepicker/daterangepicker.css') }}">


<link rel="stylesheet" href="{{ asset('public\selectpicker/css/bootstrap-select.min.css') }}">

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('public/backend/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

 <!-- SweetAlert2 -->
 <link rel="stylesheet" href="{{ asset('public/backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
 <!-- Toastr -->
 <link rel="stylesheet" href="{{ asset('public/backend/plugins/toastr/toastr.min.css') }}">

<link rel="stylesheet" href="{{ asset('public/css/style.css') }}">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.css" integrity="sha512-zrPsLVYkdDha4rbMGgk9892aIBPeXti7W77FwOuOBV85bhRYi9Gh+gK+GWJzrUnaCiIEm7YfXOxW8rzYyTuI1A==" crossorigin="anonymous" />
 


<style>
  body{
  font-family: auto !important;
  
  }

</style>


@include('_partials_.permissioncss')

@stack('addcss')

