@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content">
            <div class="container" style="min-height: 85vh">
                <div class="row">
                    <div class="col-md-12">
                        <form class="floating-labels m-t-40" action="{{ route('store.asset.product') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="pt-4 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Create Asset Product</h4>
                                <hr width="33%">
                            </div>


                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class=" col-form-label">Product Name:</label>
                                        <input type="text" name="product_name" class="form-control"
                                            placeholder="Product Name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class=" col-form-label">Asset Group Name:</label>
                                        <select name="group_id" class="form-control select2">
                                            <option value="">== Select Group ==</option>
                                            @foreach ($assetcat as $data)
                                                <option value="{{ $data->id }}">
                                                    {{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class=" col-form-label">Image:</label>
                                        <input type="file" name="image" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class=" col-form-label"> Depreciation Rate:</label>
                                        <input type="text" name="depreciation_rate" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class=" col-form-label">Depreciation Year:</label>
                                        <input type="text" name="depreciation_year" class="form-control">
                                    </div>
                                </div>
                                {{-- <div class="col-md-2">
                                    <div class="form-group">
                                        <label class=" col-form-label">Opening Balance:</label>
                                        <input type="text" name="balance" class="form-control">
                                    </div>
                                </div> --}}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class=" col-form-label">Date:</label>
                                        <input type="date" name="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class=" col-form-label">Warranty Date:</label>
                                        <input type="date" name="warranty_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class=" col-form-label">Guarantee Date:</label>
                                        <input type="date" name="guarantee_date" class="form-control">
                                    </div>
                                </div>


                            </div>
                            <div class="row mt-3">
                                <div id="field" class="col-md-12">
                                    <div class="row fieldGroup rowname">
                                        <div class="col-md-12">
                                            <div class="row">

                                                <div class="col-md-10">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-5 pr-3">
                                                            <div class="form-group row">
                                                                <label for="">Specification Head :</label>
                                                                <input type="text" name="specification[]"
                                                                    class="form-control amount"
                                                                    placeholder="Specification head 1">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group row">
                                                                <label for="">Specification Value :</label>
                                                                <input type="text" name="value[]" class="form-control value"
                                                                    placeholder="Specification value 1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Action :</label> <br>
                                                    <a href="javascript:void(0)" style="margin-top: 3px;"
                                                        class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                            class="fas fa-plus-circle"></i></a>
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-sm custom-btn-sbms-remove remove"
                                                        style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class=" col-form-label">Description:</label>
                                    <textarea name="description" class="form-control" cols="30" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <div class="text-center">
                                    <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
    <script>
        $(document).ready(function() {

            var x = 1;
            //add more fields group
            $("body").on("click", ".addMore", function() {
                x = x + 1;

                var fieldHTML =
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-2"> </div><div class="col-md-5 pr-3"> <div class="form-group row"> <input type="text" name="specification[]" class="form-control amount" placeholder="Specification head ' +
                    x +
                    '"> </div></div><div class="col-md-3"> <div class="form-group row"> <input type="text" name="value[]" class="form-control value" placeholder="Specification value ' +
                    x +
                    '"> </div></div></div></div><div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div>';
                if (x <= 12) {
                    $(this).parents('.fieldGroup:last').after(fieldHTML);

                    $('.select2').select2({
                        theme: 'bootstrap4'
                    })

                } else {
                    $(function() {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000
                        });
                        $(function() {
                            Toast.fire({
                                icon: 'error',
                                title: 'Sorry! You can submit Only 12 entry.'
                            })

                        });

                    });
                }




            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();


            });


            $('#payment_type').on('change', function() {
                var payment_type = $(this).val();
                console.log(payment_type);
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
            $('#client_type').on('change', function() {
                var client_type = $(this).val();
                console.log(client_type);
                if (client_type != '') {

                    if (client_type == "short") {
                        // console.log("Value is" + payment_type);
                        $("#sclient").css("display", "block")
                        $("#lclient").css("display", "none");
                    }

                    if (client_type == "long") {
                        // console.log("Value is two" + payment_type);
                        $("#sclient").css("display", "none")
                        $("#lclient").css("display", "block");
                    }
                } else {
                    // console.log("Value Not Founded");
                    $("#werehouse_name").css("display", "none")
                    $("#bank_name").css("display", "none");
                }

            });
        });
    </script>
@endsection
