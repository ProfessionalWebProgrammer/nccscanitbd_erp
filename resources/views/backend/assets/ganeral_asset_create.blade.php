@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                <div class="row" style="min-height: 85vh">
                    <div class="col-md-12">
                            <form class="floating-labels m-t-40" action="{{ route('asset.store') }}" method="POST">
                                @csrf
                                <div class="pt-4 text-center">
                                    <h4 class="font-weight-bolder text-uppercase">Create Asset</h4>
                                    <hr width="33%">
                                </div>

                                <div class="row pt-3">
                                    <div class="col-md-12">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class=" col-form-label">Date :</label>
                                                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <div class="form-group">
                                                    <label class=" col-form-label"> Asset Type :</label>
                                                    <select name="asset_type" class="form-control select2 "  >
                                                        <option value="">== Select Type ==</option>
                                                        @foreach ($assettype as $item)
                                                            <option value="{{ $item->id }}" @if ($item->id == 1) selected @endif>
                                                                {{ $item->asset_type_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                          <div class="col-md-3 ">
                                                <div class="form-group">
                                                     <label class=" col-form-label">Client name :</label>
                                                    <select name="clint_id" class="form-control select2" >
                                                        <option value="">== Select Client ==</option>
                                                        @foreach ($assetclint as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                          <div class="col-md-3">
                                        <div class="form-group">
                                          {{--  <label class=" col-form-label">Asset Category:</label>
                                            <select name="category_id" id="category_id" class="form-control select2"
                                                required>
                                                <option value="">== Select Category ==</option>
                                                @foreach ($assetcat as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select> --}}
                                            <label class=" col-form-label">Asset Group Name:</label>
                                            <select name="group_id" class="form-control select2" id="category_id" required>
                                                <option value="">== Select Group ==</option>
                                                @foreach ($assetcat as $data)
                                                    <option value="{{ $data->id }}">
                                                        {{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                        </div>
                                    </div>

                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=" col-form-label ">Property, Plant & Equipment:</label>
                                            <input type="text" name="asset_head" class="form-control ">
                                        </div>
                                    </div> --}}

                                </div>
                                <div class="row mt-3">
                                    <div id="field" class="col-md-12">

                                        <div class="row fieldGroup rowname">
                                            <div class="col-md-12">
                                                <div class="row">

                                                    <div class="col-md-11">
                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label">Product:</label>
                                                                    <select name="product_id"
                                                                        class="form-control select2 assetProduct" required>
                                                                        {{-- <option value="">== Select Head ==</option>
                                                                                @foreach ($assetproduct as $item)
                                                                                    <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                                                                @endforeach --}}
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">

                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Quantity:</label>
                                                                    <input type="text" name="asset_qty" required
                                                                        class="form-control aqty" placeholder="Asset Qty">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">

                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Unit Price:</label>
                                                                    <input type="text" name="asset_unit_price" required
                                                                        class="form-control aup" placeholder="Asset Price">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">

                                                                <div class="form-group">
                                                                    <label class=" col-form-label">Value (Dr):</label>
                                                                    <input type="text" name="asset_value_dr" readonly
                                                                        class="form-control aamount"
                                                                        placeholder="Asset Value (Dr)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 mt-2">
                                                      {{--  <label for="">Action :</label></br>
                                                        <a href="javascript:void(0)" style="margin-top: 3px;"
                                                            class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-sm custom-btn-sbms-remove remove"
                                                            style="margin-top: 3px;"><i
                                                                class="fas  fa-minus-circle"></i></a>
                                                                --}}

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-4  mt-5 font-weight-bold">
                                        <h5>Total Amount : <span id="total_amount">/-</span></h5>

                                        <input type="hidden" name="total_amount" class="form-control"
                                            id="total_amount_get">
                                    </div>

                                </div>



                                <div class="row ">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=" col-form-label">Asset Payment Term:</label>
                                            <select name="asset_term" class="form-control select2" >
                                                <option value="">== Select Asset Payment Term ==</option>
                                                <option value="Short_Term">Short Term Asset</option>
                                                <option value="Long_Term">Long Term Asset</option>
                                                <option value="Paid">Paid</option>
                                                <option value="Company_to_Company">Company To Company</option>
                                                <option value="Bank_to_Company">Company To Bank</option>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=" col-form-label">Payment Mode:</label>
                                            <select name="payment_mode" class="form-control select2" id="payment_type">
                                                <option value="">== Select Type ==</option>
                                                <option value="Bank">Bank Payment</option>
                                                <option value="Cash">Cash Payment</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" id="bank_name" style="display: none">
                                            <label class=" col-form-label">Bank Name:</label>
                                            <select name="bank_id" class="form-control select2">
                                                <option value="">== Select Bank ==</option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->bank_id }}">{{ $bank->bank_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group" id="werehouse_name" style="display: none">
                                            <label class=" col-form-label">Wirehouse Name:</label>
                                            <select name="wirehouse_id" class="form-control select2">
                                                <option value="">== Select Wirehouse ==</option>
                                                @foreach ($cashes as $cash)
                                                    <option value="{{ $cash->wirehouse_id }}">
                                                        {{ $cash->wirehouse_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class=" col-form-label">Payment Value (Cr):</label>
                                            <input type="text" name="payment_value_cr" id="paymentvalue"
                                                class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class=" col-form-label">Remaining Value (Dr):</label>
                                            <input type="text" name="remaining_value_dr" id="remainingvalue" readonly
                                                class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class=" col-form-label">Description:</label>
                                            <textarea name="description" class="form-control"  rows="3"></textarea>
                                        </div>
                                    </div>
                                  <div class="col-md-1">
                                  </div>
                                    <div class="col-md-12 my-5">
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

@endsection

@push('end_js')

    <script>
        $(document).ready(function() {




            var x = 1;
            //add more fields group
            $("body").on("click", ".addMore", function() {
                x = x + 1;

                var fieldHTML =
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-4"> <div class="form-group"> <select name="product_id[]" class="form-control select2 assetProduct" required> {{-- <option value="">==Select Product==</option> @foreach ($assetproduct as $item) <option value="{{$item->id}}">{{$item->product_name}}</option> @endforeach --}} </select> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" name="asset_qty[]" required class="form-control aqty" placeholder="Asset Qty"> </div></div><div class="col-md-3"> <div class="form-group"> <input type="text" name="asset_unit_price[]" required class="form-control aup" placeholder="Asset Price"> </div></div><div class="col-md-3"> <div class="form-group"> <input type="text" name="asset_value_dr[]" readonly class="form-control aamount" placeholder="Asset Value (Dr)"> </div></div></div></div><div class="col-md-1 mt-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div>';
                if (x <= 12) {
                    $(this).parents('.fieldGroup:last').after(fieldHTML);

                    $('.select2').select2({
                        theme: 'bootstrap4'
                    })

                    getproduct();


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

                total();
            });


            $('#field').on('input', '.aqty, .aup', function() {


                var parent = $(this).closest('.fieldGroup');
                var aqty = parent.find('.aqty').val();

                var auprice = parent.find('.aup').val();

                var total_price = aqty * auprice;

                parent.find('.aamount').val(total_price);

                total();


            });





            function total() {
                var total = 0;
                $(".aamount").each(function() {
                    var totalvalueid = $(this).val() - 0;
                    total += totalvalueid;
                    $('#total_amount').html(total);
                    // console.log(total);
                })
                $('#total_amount').html(total);
                $('#total_amount_get').val(total);
            }




            $('#category_id').on('change', function() {

                // $('.totalvalueid').attr("value", "0");

                getproduct();

            })


            function getproduct() {

                var catid = $('#category_id').val();


                //console.log(catid);

                $.ajax({
                    // url: '{{ url('/asset/get/product/') }}/' + catid,
                    url: '{{ url('/asset/get/product/') }}/' + catid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);

                        //   parent.find('.balanceBC').val(data);

                        var str = '<option value="">Select Product</option>';
                        $(data).each(function(i, v) {
                            str += '<option value="' + v.id + '">' + v.product_name +
                                '</option>';
                        });
                        //alert(str);
                        $(".assetProduct").each(function() {
                            var thisp = $(this).val();
                            if (!$(this).val()) {

                                $(this).html(str);

                                $('.select2').select2({
                                    theme: 'bootstrap4'
                                })

                            }


                        })



                    }
                });


            }






            $('#paymentvalue').on('input', function() {

                var paymentval = $(this).val();
                var totalval = $('#total_amount_get').val();


                $('#remainingvalue').val(totalval - paymentval);




            });



        });


        $(document).ready(function() {


            $(document).on('focus', '.select2-selection.select2-selection--single', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            });

            // steal focus during close - only capture once and stop propogation
            $('select.select2').on('select2:closing', function(e) {
                $(e.target).data("select2").$selection.one('focus focusin', function(e) {
                    e.stopPropagation();
                });
            });


        });



        $(document).ready(function() {
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
@endpush
