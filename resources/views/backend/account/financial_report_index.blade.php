@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Financial Report Input</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ Route('financial.report.report') }}" method="POST">
                        @csrf
                        <div class="row">

                          
                            <div class="col-md-4 "></div>
                            <div class="col-md-4 ">
                                <h5>Select Date: </h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                       
                                        <input type="date" name="date" 
                                            class="form-control float-right" value="{{date('Y-m-d')}}">

                                    </div>
                                </div>
                            </div>
                          
                          
                        

                          


                          

                            {{-- <div class="col-md-4">
                                <h5 >Select Area</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple name="dlr_area_id[]">
                                      <option value="">Select Area</option> 
                                        @foreach ($areas as $area)

                                            <option style=" font-weight:bold" value="{{$area->id}}">
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

    <script>
        $(document).ready(function() {

            $("#daterangepicker").change(function() {
                var a = document.getElementById("today");
               a.style.display = "none";
            });

            

           


        });
    </script>

@endpush
