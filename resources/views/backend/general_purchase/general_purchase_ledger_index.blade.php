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
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">General Purchase Ledger</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ Route('general.purchase.ledger.view') }}"
                        method="POST">
                        @csrf
                        <div class="row mt-5">
                          <div class="col-md-8 m-auto">
                            <div class="row">
                            <div class="col-md-6">
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
                            <div class="col-md-6">

                                <h5>Select Supplier</h5>
                                <div class="form-group m-b-40">

                                    <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true" data-actions-box="true" multiple name="supplier_id[]">
                                        {{-- <option value="">Select supplier</option> --}}
                                        @foreach ($supplier as $s)
                                            <option style=" font-weight:bold" value="{{ $s->id }}">
                                                {{ $s->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                          </div>
                        </div>

                        <div class="class row mt-4">
                            <div class="class col-md-4"></div>
                            <div class="class col-md-4 px-5">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Generate Ledger</button>


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
