@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Asset Report Input</h5>
                    <hr>
                </div>


                <div class="row">
                    <div class="col-md-12 m-auto">
                        <div class="form">
                            <form class="floating-labels m-t-40" action="{{ Route('asset.report.view') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 m-auto">
                                        <h5>Select Daterange: </h5>
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
                                    <div class="col-md-4">
                                        <h5>Asset Type</h5>
                                        <div class="form-group m-b-40" id="areaS">
                                            <select class="form-control select2" name="asset_type">
                                                <option value="">Select Asset Type </option>
                                                @foreach ($assettype as $item)
                                                    <option value="{{ $item->id }}">{{ $item->asset_type_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                  
                                  <div class="col-md-4">
                                        <h5>All Asset</h5>
                                        <div class="form-group m-b-40" id="areaS">
                                            <select class="form-control select2" name="all_assets">
                                                <option value="">Select Asset </option>
                                                <option value="1"> Assets </option>
                                                <option value="2">Investment Assets </option>
                                                <option value="3">Intangible Assets </option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                  
                                    

                                </div>

                                <div class="class row mt-4">
                                    <div class="class col-md-4"></div>
                                    <div class="class col-md-4 px-5">
                                        <button type="submit" class="btn btn-primary" style="width: 100%;">Generate
                                            Report</button>


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
