@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Brand Wise Sales Report Input</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ Route('brand.wise.sales.report') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 m-auto">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Select Daterange: <span id="today"
                                                style="color: lime; display:inline-block">Today</span></h5>
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
                                            <strong class="text-danger">{{$errors->first('date')}}</strong>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <h5> Type: </h5>
                                        <div class="form-group m-b-40">
                                            <select class="form-control selectpicker" data-show-subtext="true" name="report_type">
                                                <option value="0">Value Wise</option>
                                                <option value="1">Quantity Wise</option>
                                            </select>
                                            <strong class="text-danger">{{$errors->first('report_type')}}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="class row mt-4">
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
