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
                    <h5 class="text-uppercase font-weight-bold">Sales Ledger Input</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ Route('sales.ledger') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
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

                            <div class="col-md-4">
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

                            

                            <div class="col-md-4">
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

                            <div class="col-md-4">
                                <h5>Select Dealer</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple name="vendor_id[]">
                                        {{-- <option value="">Select Vendor</option> --}}
                                        @foreach  ($dealers as $d)
                                            <option style=" font-weight:bold"  value="{{ $d->id }}">
                                                {{ $d->d_s_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h5 >Select Warehouse</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple name="warehouse_id[]">
                                        {{-- <option value="">Select Store</option> --}}
                                        @foreach ($factory as $w)
                                            <option style=" font-weight:bold" value="{{ $w->id }}"
                                                >{{ $w->factory_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">

                                <h5>Select Product</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple  name="product_id[]">
                                        {{-- <option value="">Select Product</option> --}}
                                        @foreach ($products as $d)
                                            <option style=" font-weight:bold" value="{{ $d->id }}">
                                                {{ $d->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        {{-- <div class="row">

                            <div class="col-md-4">
                                <h5 >Select Category</h5>
                                <div class="form-group m-b-40">
                                    <select id="category_id" class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true" name="category_id">
                                        <option value="">Select Item</option>
                                        @foreach ($category as $c)
                                            <option style="color: #FF0000" value="{{ $c->id }}">
                                                {{ $c->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                               <div class="col-md-4">
                                    <h5 >Select Item</h5>
                                    <div class="form-group m-b-40">
                                        <select id="" class="form-control" data-actions-box="true" multiple name="product_id[]">
                                            <option value="">Select Item</option>
                                            @foreach ($products as $p)
                                                <option style="color: #FF0000" value="{{ $p->id }}" {{ $product_id == $p->id ? 'selected' : null }}>{{ $p->product_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 

                            <div class="col-md-4">
                                <h5 >Select Item</h5>
                                <div class="form-group m-b-40">
                                    <select id="product_item" class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true" data-actions-box="true" multiple name="product_id[]">

                                    </select>
                                </div>
                            </div>


                           

                        </div> --}}

                        <div class="class row">
                            
                          <div class="col-md-4">
                                    <h5 >Report Type</h5>
                                    <div class="form-group m-b-40">
                                        <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true" data-actions-box="true"  name="report_id">
                                            <option value="1">This Month Dealer</option>
                                          	<option value="2">All Dealer</option>
                                        </select>
                                    </div>
                                </div> 
                          
                          <div class="class col-md-2">
                            </div>
                            <div class="class col-md-4 px-5 mt-4">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Generate Report</button>


                            </div>
                            <div class="class col-md-2">
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
