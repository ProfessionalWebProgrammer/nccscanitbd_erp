@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row" style="min-height: 85vh">
                    <div class="col-md-10 mx-auto">
                        <form class="floating-labels m-t-40" action="{{ route('asset.clint.store') }}" method="POST">
                            @csrf
                            <div class="pt-4 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Create Asset Client </h4>
                                <hr width="33%">
                            </div>

                            <div class="row pt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" col-form-label">Client Name :</label>
                                        <input type="text" name="client_name" class="form-control"
                                            placeholder="Enter Client Name">
                                    </div>
                                    <div class="form-group">
                                        <label class=" col-form-label">Phone No:</label>
                                        <input type="text" name="phone_no" class="form-control" value="+880">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" col-form-label">Opening Balance:</label>
                                        <input type="text" name="op_balance" class="form-control"
                                            placeholder="Opening Balance">
                                    </div>
                                    <div class="form-group">
                                        <label class=" col-form-label">Address:</label>
                                        <input type="text" name="address" class="form-control" placeholder="Address">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-5">
                                    <div class="text-center">
                                        <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
    {{-- <script>
        $(document).ready(function() {
            $('#payment_type').on('change', function() {
                var payment_type = $(this).val();
                // console.log(payment_type);
                if (payment_type != '') {

                    if (payment_type == "Bank") {
                        // console.log("Value is" + payment_type);
                        $("#werehouse_name").css("display", "none")
                        $("#bank_name").css("display", "block");
                    }

                    if (payment_type == "Cash") {
                        // console.log("Value is two" + payment_type);
                        $("#werehouse_name").css("display", "block")
                        $("#bank_name").css("display", "none");
                    }
                } else {
                    // console.log("Value Not Founded");
                    $("#werehouse_name").css("display", "none")
                    $("#bank_name").css("display", "none");
                }

            });
        });
    </script> --}}
@endsection
