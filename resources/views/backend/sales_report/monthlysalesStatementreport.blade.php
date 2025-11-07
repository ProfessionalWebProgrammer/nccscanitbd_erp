@extends('layouts.backendbase')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Monthly Sales Statement Report</h5>
                    <hr>
                </div>
                <div class="py-4">
                    <table class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Area</th>
                                <th>Vendor</th>
                                <th>Current Month</th>
                                <th>Previous Month</th>
                                <th>Pre Previous Month</th>
                                <th>Monthly Target</th>
                                <th>Quarterly Total</th>
                                <th>Current Month Credit</th>
                                <th>Previous Month Credit</th>
                                <th>Target Credit</th>
                                <th>BF/SF/DF</th>
                                <th>Layer Feed</th>
                                <th>Fish Feed</th>
                                <th>Cattle Feed</th>
                                <th>Home Feed</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">

                        </tbody>
                    </table>
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
