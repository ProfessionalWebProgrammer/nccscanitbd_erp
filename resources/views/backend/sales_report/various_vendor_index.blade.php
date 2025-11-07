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
                    <h5 class="text-uppercase font-weight-bold">Various Type Vendor Report Input</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ Route('various.vendor.report') }}"
                        method="POST">
                        @csrf
                        <div class="row">

                            {{-- <div class="col-md-4">

                            </div> --}}


                            <div class="col-md-4 ">
                                <h5>Select Month: </h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="month" name="month_year" 
                                            class="form-control float-right" id="slectmonth" value="{{date('Y-m')}}">

                                    </div>
                                </div>
                            </div>

                           

                            <div class="col-md-4">
                                <h5>Select Main Zone</h5>
                                <div class="form-group m-b-40">


                                    <select class="form-control select2" 
                                        name="vendor_main_zone">
                                       <option value="">Select All</option>
                                       <option value="EAST">EAST</option>
                                       <option value="WEST">WEST</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">
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


                            <div class="col-md-4">
                                <h5>Select Vendor Type</h5>
                                <div class="form-group m-b-40">


                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true"  required
                                        name="dlr_type">
                                        <option value="">Select Dealer Type</option>
                                        @foreach ($dlrtype as $data)
                                            <option style=" font-weight:bold" value="{{ $data->id }}">
                                                {{ $data->type_title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            

                            {{-- <div class="col-md-4">
                                <h5>Select Area</h5>
                                <div class="form-group m-b-40" id="areaS">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple name="dlr_area_id[]">
                                        @foreach ($areas as $area)

                                            <option style=" font-weight:bold" value="{{ $area->id }}">
                                                {{ $area->area_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}


                         
                           



                          


                            

                            
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






        });
    </script>

@endpush
