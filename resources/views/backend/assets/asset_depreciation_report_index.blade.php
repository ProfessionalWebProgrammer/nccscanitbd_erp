@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Asset Depreciation Report Input</h5>
                    <hr>
                </div>


                <div class="row">
                    <div class="col-md-12 m-auto">
                        <div class="form">
                            <form class="floating-labels m-t-40" action="{{ Route('asset.depreciation.report.view') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 m-auto">
                                        <h5>Select Month: </h5>
                                        <div class="form-group m-b-40">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="month" name="month" class="form-control float-right"  >

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-4">
                                    <div class=" col-md-2 px-5 m-auto">
                                        <button type="submit" class="btn btn-primary" style="width: 100%;">Generate  Report</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
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
