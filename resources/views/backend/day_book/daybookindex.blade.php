@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
              
              <div class="row pt-3">
                		<div class="col-md-6 text-right"></div>
                      <div class="col-md-6 text-right">
                        <a href="{{ route('sisterConcern.book.index') }}" class=" btn btn-info mr-2">Sister Concern Book </a> 
                      	<a href="{{ URL('/bank/book/index') }}" class=" btn btn-success mr-2">Bank Book </a> 
                      	<a href="{{ URL('/cash/book/index') }}" class=" btn btn-primary mr-2">Cash Book </a> 
                      	<a href="{{ URL('/master/bank/book/index') }}" class=" btn btn-warning mr-2">MB Account</a> 
                       </div>
                    
                </div>

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Day Book Input</h5>
                    <hr>
                </div>
                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ Route('report.daybook.view') }}" method="POST">
                        @csrf
                        <div class="row">

                            
                            <div class="col-md-4 "></div>
                            <div class="col-md-4 ">
                                <h5>Select Date: </h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                       
                                        <input type="date" name="date" 
                                            class="form-control float-right" value="{{date('Y-m-d')}}">
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="class row">
                            <div class="class col-md-4"></div>
                            <div class="class col-md-4 px-5">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Generate Report</button>
                            </div>
                            <div class="class col-md-4">
                            </div>
                        </div>

                    </form>
                </div>
            </div>



        </div>
    </div>
    </div>

@endsection

@push('end_js')

    <script>
        $(document).ready(function() {

            $("#daterangepicker").change(function() {
                var a = document.getElementById("today");
               a.style.display = "none";
            });

            

           


        });
    </script>

@endpush
