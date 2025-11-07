@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Top Ten Dealer Report</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ Route('top.ten.dealer.report') }}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-md-4">

                            </div>

                            <div class="col-md-4 mt-3">
                                <h5>Select Daterange: <span id="today" style="color: lime; display:inline-block">Today</span></h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date" 
                                            class="form-control float-right" id="daterangepicker">

                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">

                            </div>



                       {{--     <div class="col-md-4">
                                <h5>Select Zone</h5>
                                <div class="form-group m-b-40">


                                    <select onchange="getArea(this.value)" id="zone-search" class="form-control select2"
                                        name="dlr_zone_id">
                                        <option value="">Select Zone</option>
                                        @foreach ($zones as $zone)
                                            <option style="color: #FF0000" value="{{ $zone->id }}">
                                                {{ $zone->zone_title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5>Select Area</h5>
                                <div class="form-group m-b-40" id="areaS">
                                    <select class="form-control select2" name="dlr_area_id">
                                        <option value="">Select Area</option>
                                        @foreach ($areas as $area)

                                            <option style="color: #FF0000" value="{{ $area->dlr_area_id }}">
                                                {{ $area->area_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>  --}}

                        

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
