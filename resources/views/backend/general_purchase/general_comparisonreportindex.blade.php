@extends('layouts.purchase_deshboard')

@push('addcss')
    <style>

    </style>

@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Comparison Report</h5>
                    <hr style="background: #ffffff78;">
                </div>


                <div class="form container">
                    <form class="floating-labels m-t-40" action="{{ Route('general.purchase.comparison.report.view') }}"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label>Select Daterange: </label>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date" class="form-control float-right"
                                            id="daterangepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <label>Select Suppliers</label>
                                <div class="form-group m-b-40">

                                    <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true" data-actions-box="true" multiple name="suppliers[]">
                                        {{-- <option value="">Select Vendor</option> --}}
                                        @foreach ($suppliers as $sup)
                                            <option style=" font-weight:bold" value="{{ $sup->id }}">
                                                {{ $sup->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <label>Select Product</label>
                                <div class="form-group m-b-40">

                                    <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true" data-actions-box="true" multiple name="products_id[]">
                                        {{-- <option value="">Select Product</option> --}}
                                        @foreach ($gproducts as $gp)
                                            <option style=" font-weight:bold" value="{{ $gp->id }}">
                                                {{ $gp->gproduct_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <label>Select Wirehouse</label>
                                <div class="form-group m-b-40">

                                    <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true" data-actions-box="true" multiple name="factories[]" required>
                                        {{-- <option value="">Select Wirehouse</option> --}}
                                        @foreach ($wirehouse as $wh)
                                            <option style=" font-weight:bold" value="{{ $wh->wirehouse_id  }}">
                                                {{ $wh->wirehouse_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="class row mt-3">
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
