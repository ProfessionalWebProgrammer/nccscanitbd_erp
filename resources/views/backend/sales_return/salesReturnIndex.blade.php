@extends('layouts.sales_dashboard')

@push('addcss')
<style>

</style>

@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background: #ffffff; padding: 0px 40px;min-height:85vh">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Sales Return Report Input</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ route('sales.return.report.view') }}" method="POST">
                        @csrf
                        <div class="row mb-5">
                            <div class="col-md-6 m-auto">
                                <h5>Select Daterange: <span id="today" style="color: lime; display:inline-block">Today</span></h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date"
                                            class="form-control float-right" id="daterangepicker" >

                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h5> Category: </h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true" multiple name="category_id[]">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $cat)
                                            <option style="color: #FF0000" value="{{ $cat->id }}">
                                                {{ $cat->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <strong class="text-danger">{{$errors->first('category_id')}}</strong>
                                </div>
                            </div>
                                    
                          {{--   <div class="col-md-3">
                                <h5>Select Zone</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true"  multiple
                                        name="dlr_zone_id[]">
                                        <option value="">Select Zone</option>
                                        @foreach ($zones as $zone)
                                            <option style=" font-weight:bold" value="{{ $zone->id }}">
                                                {{ $zone->zone_title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <h5>Select Region</h5>
                                <div class="form-group m-b-40" id="regions">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple name="dlr_region_id[]">
                                        @foreach ($regions as $area)
                                            <option style=" font-weight:bold" value="{{ $area->id }}">
                                                {{ $area->subzone_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
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

                           {{-- <div class="col-md-4">
                                <h5>Select Dealer</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple name="vendor_id[]">
                                        @foreach  ($dealers as $d)
                                            <option style=" font-weight:bold"  value="{{ $d->id }}">
                                                {{ $d->d_s_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-4">
                                <h5 >Select Warehouse</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple name="warehouse_id[]">
                                        @foreach ($factory as $w)
                                            <option style=" font-weight:bold" value="{{ $w->id }}"
                                                >{{ $w->factory_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                           {{-- <div class="col-md-4">

                                <h5>Select Product</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple  name="product_id[]">
                                        @foreach ($products as $d)
                                            <option style=" font-weight:bold" value="{{ $d->id }}">
                                                {{ $d->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                        </div>


                        <div class="class row">
                            <div class="class col-md-3 m-auto px-5 mt-5">
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
