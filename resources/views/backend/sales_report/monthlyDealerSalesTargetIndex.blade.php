@extends('layouts.sales_dashboard')
@push('addcss')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Dealer Sales Report Input</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ Route('monthly.dealer.sales.target.report') }}"
                        method="POST">
                        @csrf
                        <div class="row">

                            {{-- <div class="col-md-4">

                            </div> --}}

                           

                            <div class="col-md-3">
                                <h5>Select Main Zone</h5>
                                <div class="form-group m-b-40">


                                    <select class="form-control select2" 
                                        name="main_zone">
                                       <option value="">Select All</option>
                                       <option value="EAST">EAST</option>
                                       <option value="WEST">WEST</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <h5>Select Zone</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true"  multiple
                                        name="vendor_zone[]">
                                        @foreach ($zones as $zone)
                                            <option style=" font-weight:bold" value="{{ $zone->id }}">
                                                {{ $zone->zone_title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            

                            <div class="col-md-3">
                                <h5>Select Area</h5>
                                <div class="form-group m-b-40" id="areaS">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple name="dlr_area_id[]">
                                        {{-- <option value="">Select Area</option> --}}
                                        @foreach ($areas as $area)

                                            <option style=" font-weight:bold" value="{{ $area->id }}">
                                                {{ $area->area_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <h5>Select Dealer</h5>
                                <div class="form-group m-b-40" id="areaS">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple name="dealer_id[]">
                                        @foreach ($dealer as $data)
                                            <option style=" font-weight:bold" value="{{ $data->id }}">
                                                {{ $data->d_s_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
							<div class="col-md-3" id="thisDate">
                                <h5>Select Date:</h5>
                              	<div class="form-group m-b-40">
                                  <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date" class="form-control float-right" id="daterangepicker" style="border-radius: 0px 12px 12px 0px!important;">

                                    </div>
                              </div>
                          </div>
                            <div class="col-md-3 " id="thisMonth">
                                <h5>Select Month: </h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="month" name="month_year" class="form-control float-right" id="slectmonth" value="{{date('Y-m')}}" style="border-radius: 0px 12px 12px 0px!important;">

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">

                                <h4>Select Quaterly Month</h4>

                                <select class="form-control" name="q_month">
                                  <option value="">Select Quaterly Month</option>
                                  <option value="1">January, February, March</option>
                                  <option value="2">April, May, June</option>
                                  <option value="3">July, August, September</option>
                                  <option value="4">October, November, December</option>
                                </select>

                            </div> 
                             <div class="col-md-3">

                                <h4>Select Year</h4>

                                <select class="form-control" name="q_year">
                                      <option value="">Select Year </option>
                                      <option value="2020">2020</option>
                                      <option value="2021">2021</option>
                                      <option value="2022">2022</option>
                                      <option value="2023">2023</option>
                                      <option value="2024">2024</option>
                                      <option value="2025">2025</option>
                                      <option value="2026">2026</option>
                                      <option value="2027">2027</option>
                                      <option value="2028">2028</option>
                                      <option value="2029">2029</option>
                                      <option value="2030">2030</option>
                                      <option value="2031">2031</option>
                                      <option value="2032">2032</option>
                                      <option value="2033">2033</option>
                                      <option value="2034">2034</option>
                                      <option value="2035">2035</option>
                                      <option value="2036">2036</option>
                                      <option value="2037">2037</option>
                                      <option value="2038">2038</option>
                                      <option value="2039">2039</option>
                                      <option value="2040">2040</option>
                                      <option value="2041">2041</option>
                                      <option value="2042">2042</option>
                                      <option value="2043">2043</option>
                                      <option value="2044">2044</option>
                                      <option value="2045">2045</option>
                                      <option value="2046">2046</option>
                                      <option value="2047">2047</option>
                                      <option value="2048">2048</option>
                                      <option value="2049">2049</option>
                                      <option value="2050">2050</option>
                                  </select>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {

            $("#selectyear").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true
            });

			 $("#daterangepicker").change(function() {
              var a = document.getElementById("thisMonth");
              a.style.display = "none";
              });
          
           $("#slectmonth").change(function() {
              var a = document.getElementById("thisDate");
              a.style.display = "none";
              });

			
        });
    </script>


@endpush
