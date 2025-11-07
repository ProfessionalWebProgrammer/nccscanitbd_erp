@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Cash Flow Statement Input</h5>
                    <hr>
                </div>

                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ Route('cashFlowStatement.report.view') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 m-auto">
                                <h5>Select Daterange: <span id="today" style="color: lime; display:inline-block">Today</span></h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date" class="form-control float-right" id="daterangepicker">
                                    </div>
                                </div>

                              {{--  <div id="thisMonth2">

                                   <h6>Select Month: </h6>
                                   <div class="form-group m-b-40">
                                       <div class="input-group">
                                           <div class="input-group-prepend">
                                               <span class="input-group-text">
                                                   <i class="far fa-calendar-alt"></i>
                                               </span>
                                           </div>
                                           <input type="month" name="monthYear" class="form-control float-right" id="slectmonth"  placeholder="Select Month" style="border-radius: 0px 12px 12px 0px!important;">
                                       </div>
                                   </div>
                               </div> --}}
                            </div>
                        </div>


                        <div class="class row">
                            <div class="class col-md-2 px-5 m-auto">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Generate Report</button>
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
