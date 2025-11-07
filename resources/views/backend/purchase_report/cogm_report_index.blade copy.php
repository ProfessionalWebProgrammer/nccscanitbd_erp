@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">C.O.G.M Report</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ Route('production.cogm.report') }}" method="POST">
                        @csrf
                        <div class="row">


                            <div class="col-md-8">
                                <div class="form-group row m-b-40">
                                    <label class="col-sm-4 col-form-label text-right">Select Month: <span id="today"
                                            style="color: lime; display:inline-block">This Month </span></label>
                                    <div class="input-group col-sm-8">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="month" name="month" class="form-control float-right" id="slectmonth"
                                            value="{{ date('Y-m') }}">

                                    </div>
                                </div>
                            </div>

                            <div class="class col-md-4">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Generate Report</button>


                            </div>


                            {{-- <div class="col-md-4">
                                <h5>Select Products </h5>
                                <div class="form-group m-b-40">


                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple
                                        name="product_id[]" required>
                                        @foreach ($products as $data)
                                            <option style="color: #ff0000; font-weight:bold" value="{{ $data->id }}">
                                                {{ $data->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}


                        </div>

                    </form>
                </div>

                <div class="py-4 col-md-8 m-auto table-responsive">
                    <table id="" class="table table-bordered table-striped table-fixed"
                        style="font-size: 6;table-layout: inherit;">
                        <thead>
                            <tr>
                                <th>Head </th>
                                <th>Amount</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Raw Materials Opening Balance </td>
                                <td>000</td>

                            </tr>

                            <tr>
                                <td>Raw Materials Purchase Qantity </td>
                                <td>000</td>

                            </tr>
                            <tr>
                                <td>Raw Materials Closing Balance </td>
                                <td>000</td>

                            </tr>
                            <tr style="font-weight: bold">
                                <td>Raw Materials Used</td>
                                <td>000</td>

                            </tr>
                            <tr style="font-weight: bold">
                                <td>Total Raw Materials Cost</td>
                                <td>000</td>

                            </tr>

                            <tr>
                                <td>Direct Labor Cost </td>
                                <td>000</td>

                            </tr>
                            <tr>
                                <td>Manufacturing Overhead </td>
                                <td>000</td>

                            </tr>



                        </tbody>

                        <tfoot>
                            <tr style="color:red">
                                <th>Total Cost </th>
                                <th>0000</th>

                            </tr>

                        </tfoot>




                    </table>
                </div>





            </div>
        </div>
    </div>

@endsection

@push('end_js')

    <script>
        $(document).ready(function() {

            $("#slectmonth").change(function() {
                var a = document.getElementById("today");
                a.style.display = "none";
            });






        });
    </script>

@endpush
