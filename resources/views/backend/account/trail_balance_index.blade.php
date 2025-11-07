@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Compared Trail Banalce Input</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ route('chat.of.account.compared.trail.balance') }}" method="POST">
                        @csrf
                        <div class="row">

                          {{--  <div class="col-md-4 ">
                                <h5>Select Date: </h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">

                                        <input type="date" name="date"
                                            class="form-control float-right" value="{{date('Y-m-d')}}">

                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-md-4 m-auto ">
                                <h5>Select Daterange: <span id="today" style="color: lime; display:inline-block">Today</span></h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date"
                                            class="form-control float-right" id="daterangepicker">

                                    </div>
                                </div>
                            </div>
                          {{--  <div class="col-md-3">
                              <h5>Select Month</h5>
                              <div class="form-group m-b-40">
                                <select class="form-control selectpicker" data-show-subtext="true"
                                       data-live-search="true"  data-actions-box="true" multiple name="months[]">
                                   <option value="">Select Months</option>
                                   <option style="color: #FF0000; font-weight:bold" value="01">January  </option>
                                   <option style="color: #FF0000; font-weight:bold" value="02">February </option>
                                   <option style="color: #FF0000; font-weight:bold" value="03">March </option>
                                   <option style="color: #FF0000; font-weight:bold" value="04">April </option>
                                  <option style="color: #FF0000; font-weight:bold" value="05"> May</option>
                                  <option style="color: #FF0000; font-weight:bold" value="06">June </option>
                                  <option style="color: #FF0000; font-weight:bold" value="07">July</option>
                                   <option style="color: #FF0000; font-weight:bold" value="08">August </option>
                                   <option style="color: #FF0000; font-weight:bold" value="09">September </option>
                                   <option style="color: #FF0000; font-weight:bold" value="10">October  </option>
                                  <option style="color: #FF0000; font-weight:bold" value="11">November</option>
                                  <option style="color: #FF0000; font-weight:bold" value="12">December </option>
                               </select>
                              </div>
                            </div> --}}

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
