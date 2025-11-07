@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <div class="content px-4 " id="depreciation">
            <div class="container-fluid">
                <div class="row" style="min-height: 85vh">
                    <div class="col-md-12 mx-auto">


                        <form class="floating-labels m-t-40" action="{{ route('asset.depreciation.store') }}"
                            method="POST">
                            @csrf
                            <div class="pt-4 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Create Asset Depreciation </h4>
                                <hr width="33%">
                            </div>

                            <div class="row pt-3">

                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class=" col-form-label">Date :</label>
                                        <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control"
                                            id="inputEmail3">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class=" col-form-label">Select Asset:</label>
                                        <select name="asset_id" id="asset_id" class="form-control select2" required>
                                            <option value="">== Select Asset ==</option>
                                            @foreach ($assets as $item)
                                                <option value="{{ $item->id }}" data-value="{{ $item->asset_value }}">
                                                    {{ $item->asset_head }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>


                                <div class="col-md-4"></div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class=" col-form-label"> Select Product:</label>
                                        <select name="asset_details_id" class="form-control select2 assetProduct" required>
                                        </select>
                                    </div>

                                    <input type="hidden" id="asset_product_id" name="asset_product_id">

                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class=" col-form-label"> Asset Product Value:</label>
                                        <input type="text" id="asset_product_value" name="asset_product_value" readonly
                                            class="form-control">
                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class=" col-form-label">Salvage Value :</label>
                                        <input type="text" name="salvage_value" id="salvage_value" class="form-control"
                                            placeholder="Salvage Value">
                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class=" col-form-label">Remaining Value :</label>
                                        <input type="text" name="rm_value" id="rm_value" readonly class="form-control"
                                            placeholder="Remaining Value">
                                    </div>

                                </div>
                                <div class="col-md-2"></div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class=" col-form-label">Year Line :</label>
                                        <input type="text" name="year_line" id="year_line" class="form-control"
                                            placeholder="Year Line">
                                    </div>

                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class=" col-form-label">Year Line :</label>
                                        <input type="text" name="yearly_amount" id="yearly_amount" readonly
                                            class="form-control" placeholder="Yearly Amount">
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
    <script>
        $(document).ready(function() {
            $('#share_qty, #share_rate').on('input', function() {
                var qty = $('#share_qty').val();
                var rate = $('#share_rate').val();

                $('#share_value').val(qty * rate);
            });



            $('#asset_id').on('change', function() {

                // $('.totalvalueid').attr("value", "0");

                var asset_id = $('#asset_id').val();


                console.log(asset_id);

                $.ajax({
                    url: '{{ url('/asset/depreciation/get/asset/product/') }}/' + asset_id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        //  console.log(data);


                        var str = '<option value="">Select Product</option>';
                        $(data).each(function(i, v) {
                            str += '<option value="' + v.id + '">' + v.product_name +
                                '</option>';
                        });
                        //alert(str);
                        $(".assetProduct").html(str);


                        // 



                        $('.select2').select2({
                            theme: 'bootstrap4'
                        })






                    }
                });




            });



            $('.assetProduct').on('change', function() {

                var adid = $(this).val();
                // console.log(adid);

                $.ajax({
                    url: '{{ url('/asset/depreciation/get/asset/details/product/') }}/' + adid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        //  console.log();
                        var value = data.asset_value;





                        $("#asset_product_value").val(value);
                        $("#asset_product_id").val(data.product_id);




                    }
                });



            });



            $('#depreciation').on('input', '#salvage_value, #year_line', function() {


                var totalval = $("#asset_product_value").val();
                var salvage_value = $('#salvage_value').val();

                var rmval = totalval - salvage_value;
                $('#rm_value').val(rmval);

                var year_line = $('#year_line').val();


                $('#yearly_amount').val(Math.round(rmval / year_line));







            });



        });
    </script>
@endsection
