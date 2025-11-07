@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold"> Budget Pie Chart Input</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ Route('budget.pie.chart.report') }}" method="POST">
                        @csrf
                        <div class="row">

                           
                            <div class="col-md-2 "></div>
                          {{--  <div class="col-md-4 ">
                                <h5>Select Date: </h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                       
                                        <input type="date" name="date" 
                                            class="form-control float-right" value="{{date('Y-m-d')}}">

                                    </div>
                                </div>
                            </div> --}}
                          
                        <div class="col-md-4 ">
                                <h5>Select Month:</h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="month" name="date"  
                                            class="form-control float-right" id=""  value="{{ date('Y-m') }}" required>

                                    </div>
                                </div>
                            </div>
                          
                          <div class="col-md-4 ">
                                <h5>Select Company:</h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                       <select class="form-control select2 "
                                                                        name="budget_id[]" required>
                                                                        <option value="">Select Company</option>

                                                                        @foreach ($budgets as $data)
                                                                            <option style="color:#000;font-weight:600;"
                                                                                value="{{ $data->id }}">
                                                                                {{ $data->company }}</option>
                                                                        @endforeach
                                                                    </select>

                                    </div>
                                </div>
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
