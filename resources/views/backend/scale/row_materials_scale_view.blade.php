@extends('layouts.settings_dashboard')



@section('content')

    @include('_partials_.convert_number')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Scale View</h5>
                        <hr>
                    </div>

                    <div class="row" style="margin-top:50px; font-family:sans-serif;">

                        <div class="col-md-6" style=" height:auto">


                            <h5 style="margin-bottom:15px; color: #fff; font-family:sans-serif;"><b>Scale No :
                                    {{ $scale->scale_no }}</b></h5>

                            <h5 style="margin-bottom:15px; color: #fff; font-family:sans-serif;"><b>Vehicle :
                                    {{ $scale->vehicle }} </b></h5>
                            <h5 style="margin-bottom:15px; color: #fff; font-family:sans-serif;"><b>Unload Weight :
                                    {{ $scale->unload_weight }}</b></h5>
                            <h5 style="margin-bottom:15px; color: #fff; font-family:sans-serif;"><b>Load Weight
                                    :{{ $scale->load_weight }}</b></h5>
                            <h5 style="margin-bottom:15px; color: #fff; font-family:sans-serif;"><b>Actual Weight
                                    :{{ $scale->actual_weight }}</b></h5>

                        </div>

                    </div>

                    <div class="ctable" style="margin-top:10px;">
                        <div class="table-responsive">
                            <table id="" class="table table-bordered"
                                style="width:98%; font-size:16px; font-family:sans-serif; font-weight: bold;">
                                <thead>
                                    <tr align="center">
                                        <th style="font-weight: bold;">Supplier Name</th>
                                        <th style="font-weight: bold;">Product Name</th>
                                        <th style="font-weight: bold;">Chalan Qantity</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr align="center">
                                        <td>{{ $scale->supplier_name }}</td>
                                        <td>{{ $scale->product_name }}</td>
                                        <td>{{ $scale->chalan_qty }}</td>
                                    </tr>
                                </tbody>


                            </table>

                        </div>

                    </div>

                    <div class="row" align="center"
                        style="margin-top:60px;margin-bottom:60px; color:rgb(255, 255, 255); font-family:sans-serif;">
                        <div class="col-md-4">
                            ________________<br />Received by
                        </div>
                        <div class="col-md-4">
                            ________________</br>In-Charge (Delivery)
                        </div>
                        <div class="col-md-4">
                            ________________</br>Authorised by
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
