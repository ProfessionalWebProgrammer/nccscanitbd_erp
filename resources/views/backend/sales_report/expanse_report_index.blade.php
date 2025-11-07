@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Expense Report Input</h5>
                    <hr>
                </div>


                <div class="row ">
                <div class="form col-md-9 m-auto ">
                    <form class="floating-labels m-t-40" action="{{ Route('expasne.report') }}" method="POST">
                        @csrf
                        <div class="row">



                            <div class="col-md-4 ">
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
                                <h5 >Select Expense Group</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple style="padding: 0px 10px 10px 10;" name="group_id[]">
                                       @foreach ($groups as $data)
                                            <option value="{{ $data->id }}">{{ $data->group_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}


                            <div class="col-md-4" id="ledger-view">
                                <h5 >Ledger</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple style="padding: 0px 10px 10px 10;" name="subgroup_id[]" id="ledger">
                                    <!-- <option value="">Select Ledger</option> -->
                                       @foreach ($subgroups as $data)
                                            <option value="{{ $data->id }}">{{ $data->subgroup_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" id="sub-ledger-view">
                                <h5 >Sub Ledger</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple style="padding: 0px 10px 10px 10;" name="subSubLedger_id[]" id="sub-ledger">
                                    <!-- <option value="">Select Sub Ledger</option> -->
                                       @foreach ($subSubLedgers as $data)
                                            <option value="{{ $data->id }}">{{ $data->subSubgroup_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class=" col-md-3 px-5 m-auto ">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Generate Report</button>
                            </div>
                        </div>
                    </form>
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

            // $('#ledger').on('change', function() {
            //   var a = document.getElementById("sub-ledger-view");
            //  a.style.display = "none";
            // });

            // $('#sub-ledger').on('change', function() {
            //   var a = document.getElementById("ledger-view");
            //  a.style.display = "none";
            // });
        });
    </script>

@endpush
