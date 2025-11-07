@extends('layouts.purchase_deshboard')

@push('addcss')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
@endpush


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Yearly Purchase Report Input</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ Route('yearly.purchase.report') }}" method="POST">
                        @csrf
                        <div class="row">


                            <div class="col-md-4 ">
                            </div>
                            
                            <div class="col-md-4 ">
                                <h5>Select Year: </h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input autocomplete="off" type="text" value="{{ date('Y') }}" name="year"
                                            class="form-control float-right" id="selectyear">

                                    </div>
                                </div>
                            </div>
                           <div class="col-md-4">
                                <h5>Select Type </h5>
                                <div class="form-group m-b-40">


                                    <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true" data-actions-box="true"  name="warehouse" required>
                                        <option value="">Select One</option>
                                        <option value="1">With Warehouse</option>
                                        <option value="2">Without Warehouse</option>
                                     
                                    </select>
                                </div>
                            </div>



                           
















                        </div>

                        <div class="class row">
                            <div class="class col-md-4"></div>
                            <div class="class col-md-4 px-5">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Generate List</button>


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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {



            $("#selectyear").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true
            });






        });
    </script>

@endpush
