@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="row py-5">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                            <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                            <h6>01712345678 , 86458415</h6>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-4"></div>
                    <div class="col-md-5"> </div>
                    <div class="col-md-3">
                        <div class="text-right">
                            <h4>Invoice : 102030</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col-md-1"></div> --}}
                    <div class="col-md-12 mt-5">
                        <table class="table table-sm border" style="font-size:22px;">
                            <thead>
                                <tr class="text-center">
                                    <th colspan="2">Money Receipt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Payment Date </td>
                                    <td>{{ date('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Bank Name</td>
                                    <td>Duch Bangla Bank - Mirpur Branch</td>
                                </tr>
                                <tr>
                                    <td>Received Amount</td>
                                    <td>2,75,125/-</td>
                                </tr>
                                <tr>
                                    <td>Current Balance</td>
                                    <td>3,70,125/-</td>
                                </tr>
                                <tr>
                                    <td>Closing Balance</td>
                                    <td>1,20,125/-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="col-md-1"></div> --}}
                </div>
                <div class="row mt-5 pb-5">
                    <div class="col-md-3">
                        {{-- <div class="text-center " style="font-size:22px;">
                            <p>Sahhin Reza</p>
                            <hr class="bg-light my-0" width="70%">
                            <p>Delivered By</p>
                        </div> --}}
                    </div>
                    <div class="col-md-6">
                        {{-- <div class="text-center" style="font-size:22px;">
                            <p>Sahhin Reza</p>
                            <hr class="bg-light my-0" width="70%">
                            <p>Printed By</p>
                        </div> --}}
                    </div>
                    <div class="col-md-3 text-center" style="font-size:22px;">
                        <p>Sahhin Reza</p>
                        <hr class="bg-light my-0" width="70%">
                        <p>Autorise Signature</p>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
