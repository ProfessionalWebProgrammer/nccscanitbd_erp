@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Journal Book Input</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ route('journal.report') }}" method="POST">
                        @csrf
                        <div class="row">


                          <div class="col-md-4">
                          </div>
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
                            <div class="col-md-4">
                            </div>




                        {{--  <div class="col-md-4">
                                <h5 >Select Supplier</h5>
                                <div class="form-group m-b-40">
                                    <select id="supplierid" class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true"  multiple style="padding: 0px 10px 10px 10;" name="supplier_id[]">
                                       @foreach ($supplier as $data)
                                            <option value="{{ $data->id }}">{{ $data->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <h5 >Select Vendor</h5>
                                <div class="form-group m-b-40">
                                    <select  id="vendorid"  class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple style="padding: 0px 10px 10px 10;" name="vendor_id[]">
                                       @foreach ($vendors as $data)
                                            <option value="{{ $data->id }}">{{ $data->d_s_name }}</option>
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





             $("#supplierid").change(function() {
               // $("#vendorid").val('');
             $('#vendorid').selectpicker('val', '');

            });
           $("#vendorid").change(function() {
            //   $("#supplierid").val('');
             $('#supplierid').selectpicker('val', '');
            });




        });
    </script>

@endpush
