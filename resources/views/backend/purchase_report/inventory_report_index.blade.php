@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Purchase inventory Report Input</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ Route('purchase.inventory.report') }}" method="POST">
                        @csrf
                        <div class="row">

                          

                            <div class="col-md-4">
                                <h5>Select Daterange: <span id="today" style="color: lime; display:inline-block">Today</span></h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date" value=""
                                            class="form-control float-right" id="daterangepicker">

                                    </div>
                                </div>
                            </div>


                           


                             <div class="col-md-4">
                                <h5>Select Invoice </h5>
                                <div class="form-group m-b-40">


                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple
                                        name="invoice[]">
                                        @foreach ($invoice as $data)
                                            <option style="color: #FF0000; font-weight:bold" value="{{ $data->purchase_id }}">
                                                INV-{{ $data->purchase_id }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            {{-- <div class="col-md-4">
                                <h5>Select Supplier </h5>
                                <div class="form-group m-b-40">


                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple
                                        name="supplier_id[]">
                                        @foreach ($suppliers as $data)
                                            <option style="color: #FF0000; font-weight:bold" value="{{ $data->id }}">
                                                {{ $data->supplier_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}


                            <div class="col-md-4">
                                <h5>Select Warehouse </h5>
                                <div class="form-group m-b-40">


                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple
                                        name="wirehouse_id[]">
                                        @foreach ($factoryes as $data)
                                            <option style="color: #FF0000; font-weight:bold" value="{{ $data->id }}">
                                                {{ $data->factory_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <h5>Select Products </h5>
                                <div class="form-group m-b-40">


                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple
                                        name="product_id[]">
                                        @foreach ($rm_products as $data)
                                            <option style="color: #ff0000; font-weight:bold" value="{{ $data->id }}">
                                                {{ $data->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h5>Select Vehicle </h5>
                                <div class="form-group m-b-40">


                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple
                                        name="transport_vehicle[]">
                                        @foreach ($vehicle as $data)
                                            <option style="color: #ff0000; font-weight:bold" value="{{ $data->transport_vehicle }}">
                                                {{ $data->transport_vehicle }}
                                            </option>
                                        @endforeach
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

    <script>
        $(document).ready(function() {

            $("#daterangepicker").change(function() {
                var a = document.getElementById("today");
               a.style.display = "none";
            });

            

           


        });
    </script>

@endpush
