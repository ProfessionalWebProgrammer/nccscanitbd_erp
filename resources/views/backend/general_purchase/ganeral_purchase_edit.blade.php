@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
      <div class="content px-4 ">
        <div class="container-fluid">
            <div class="row" style="min-height: 85vh">
                <div class="col-md-12">


                        <form class="floating-labels m-t-40" action="{{ route('general.purchase.update') }}" method="POST">
                            @csrf
                            <div class="container-fluid">
                                <div class="pt-4 text-center">
                                    <h4 class="font-weight-bolder text-uppercase">Create General Purchase</h4>
                                    <hr width="33%">
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="">Date:</label>
                                                    <input type="date" name="date" value="{{ date('Y-m-d') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="">Supplier Name:</label>
                                                    <select class="form-control select2" name="delar_id" id="">
                                                        <option value="">Select Supplier</option>
                                                        @foreach ($suppliers as $sup)
                                                            <option style="color:#000;font-weight:600;" value="{{ $sup->id }}" @if ($sup->id == $editabledata[0]->supplier_id) selected  @endif>
                                                                {{ $sup->supplier_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="">Wirehouse Name:</label>
                                                    <select class="form-control select2" name="factory_id" id="">
                                                        <option value="">Select Wirehouse</option>
                                                        @foreach ($factoryes as $factory)
                                                            <option style="color:#000;font-weight:600;"
                                                                value="{{ $factory->id }}" @if ($factory->id == $editabledata[0]->warehouse_id) selected  @endif>
                                                                {{ $factory->factory_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Invoice:</label>
                                                    <input type="text" value="{{ $id }}" id="invoiceNo"
                                                        name="invoice" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Referance:</label>
                                                    <input type="text" name="referance"
                                                        value="{{ $editabledata[0]->reference }}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Multiple add button code start from here! --}}
                                <div class="row mt-5">
                                    <div id="field" class="col-md-12">
                                        <div class="row fieldGroup rowname">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="">Product:</label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="">Rate :</label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label for="">Quantity :</label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label for="">Total :</label>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 text-center">
                                                        <label for="">Action :</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @foreach ($editabledata as $item)
                                            <div class="row fieldGroup rowname">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-11">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <select class="form-control select2 products_id"
                                                                        name="products_id[]" id="products_id[]" required>
                                                                        <option value=""> == Select == </option>
                                                                        @foreach ($gproducts as $product)
                                                                            <option style="color:#000;font-weight:600;"
                                                                                value="{{ $product->id }}"
                                                                                @if ($product->id == $item->product_id) selected  @endif>
                                                                                {{ $product->gproduct_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <input type="hidden" value="{{ $item->id }}"
                                                                        name="item_id[]">

                                                                </div>
                                                                <div class="col-md-3">
                                                                    <input type="number" value="{{ $item->rate }}"
                                                                        class="form-control p_price" name="rate[]"
                                                                        placeholder="Rate">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <input type="number" value="{{ $item->quantity }}"
                                                                        class="form-control p_qty" name="p_qty[]"
                                                                        placeholder="Quantity">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <input type="number" readonly
                                                                        class="form-control total_price"
                                                                        name="total_price[]"
                                                                        value="{{ $item->quantity * $item->rate }}"
                                                                        placeholder="total">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1 text-center">
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-sm custom-btn-sbms-remove remove"><i
                                                                    class="fas  fa-minus-circle"></i></a>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 my-2">
                                                            <a href="javascript:void(0)" style="margin-top: 3px;"
                                                                class="btn custom-btn-sbms-add btn-sm addMorenew"><i
                                                                    class="fas fa-plus-circle"></i> New
                                                            </a>
                                                            <a href="javascript:void(0)" style="margin-top: 3px;"
                                                                class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                                    class="fas fa-plus-circle"></i> Old</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                                {{-- multiple add end on here --}}
                                <div class="row pb-5">
                                    <div class="col-md-12 mt-3 text-center">
                                        <button type="submit" class="btn custom-btn-sbms-submit" style=""> Purchase Confirm
                                        </button>
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




            var x = 1
            //add more fields group
            $("body").on("click", ".addMore", function() {
                x = x + 1;
                console.log(x);
                if (x >= 2) {
                    $("#buttons").css("display", "none");
                } else {
                    $("#buttons").css("display", "block");
                }
                var fieldHTML =
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-3"> <select class="form-control select2 products_id" name="products_id[]" id="products_id" required> <option value="">==Select==</option> @foreach ($gproducts as $product) <option style="color:#000;font-weight:600;" value="{{ $product->id }}">{{ $product->gproduct_name }}</option> @endforeach </select> </div><div class="col-md-3"> <input type="text" class="form-control p_price" name="rate[]" placeholder="Rate"> </div><div class="col-md-3"> <input type="text" class="form-control p_qty" name="p_qty[]" placeholder="Quantity"> </div><div class="col-md-3"> <input type="hidden" readonly class="form-control total_price" name="total_price[]" placeholder="total"> <input type="text" class="form-control total_price_without_discount" name="total_price_without_discount[]" placeholder="total"> </div></div></div><div class="col-md-1 text-center"> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"><i class="fas fa-minus-circle"></i></a> </div></div><div class="row"> <div class="col-md-6 my-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMorenew"><i class="fas fa-plus-circle"></i> New </a> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i> Old</a> </div></div></div></div>';

                $(this).parents('.fieldGroup:last').after(fieldHTML);


                $('.select2').select2({
                    theme: 'bootstrap4'
                })

            });

            $("body").on("click", ".addMorenew", function() {
                x = x + 1;
                if (x >= 2) {
                    $("#buttons").css("display", "none");
                } else {
                    $("#buttons").css("display", "block");
                }
                var fieldHTML =
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-2"> <input type="text" name="newporoduct_name[]" class="form-control" placeholder="Product Name"> </div><div class="col-md-2"> <select class="form-control select2 maincat" name="main_cat[]" required> <option value=""> Select Main Cat </option> @foreach ($gcategory as $gcat) <option style="color:#000;font-weight:600;" value="{{ $gcat->id }}">{{ $gcat->gcategory_name }}</option> @endforeach </select> </div><div class="col-md-2"> <select class="form-control select2 sub_cat" name="sub_cat[]" required> <option value="">Select Sub Cat</option> </select> </div><div class="col-md-1"> <input type="text" class="form-control " name="dimensions[]" placeholder="Dimensions"> </div><div class="col-md-1"> <input type="text" class="form-control p_price" name="pnew_rate[]" placeholder="Rate"> </div><div class="col-md-2"> <input type="text" class="form-control p_qty" name="pnew_qty[]" placeholder="Quantity"> </div><div class="col-md-2"> <input type="text" readonly class="form-control total_price" name="newtotal_price[]" placeholder="total"> </div></div></div><div class="col-md-1 text-center"> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"><i class="fas fa-minus-circle"></i></a> </div></div><div class="row"> <div class="col-md-6 my-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMorenew"><i class="fas fa-plus-circle"></i> New </a> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i> Old</a> </div></div></div></div>';

                $(this).parents('.fieldGroup:last').after(fieldHTML);


                $('.select2').select2({
                    theme: 'bootstrap4'
                })
            });

            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
                total();
                x = x - 1;
                console.log(x);

            });

            $('#field').on('input', '.p_price, .p_qty', function() {

                var parent = $(this).closest('.fieldGroup');
                var product_price = parent.find('.p_price').val();

                var product_qty = parent.find('.p_qty').val();

                var total_price = product_price * product_qty;

                parent.find('.total_price_without_discount').val(total_price);
                parent.find('.total_price').val(total_price);


                total();


            });


            $('#field').on('change', '.discount', function() {

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');

                var totalvalueid = parent.find('.total_price').val();


                var discont = parent.find('.discount').val();

                var total_discount = (totalvalueid / 100) * discont;
                var total_price_without_discount = totalvalueid - total_discount;
                //console.log(total_price_without_discount);
                //console.log(totalvalueid);

                parent.find('.total_price_without_discount').val(total_price_without_discount);




                parent.find('.total_price').val(totalvalueid);
                parent.find('.discount_amount').val(total_discount);

                //   parent.find('.totalvalueid').val(parseFloat(qt)* parseFloat(up));




                total();

            });




            //calculate total value
            function total() {
                var qty = 0;
                var total = 0;
                var discount = 0;
                var total_with_discount = 0;

                $(".p_qty").each(function() {
                    var totalqtyid = $(this).val() - 0;
                    qty += totalqtyid;
                    $('#total_qty').html(qty);
                    // console.log(total);
                })
                $('#total_qty').html(qty);
                $('#grand_total_qty').val(qty);



                $(".total_price").each(function() {
                    var totalvalueid = $(this).val() - 0;
                    total += totalvalueid;
                    $('#total_value').html(total);
                    // console.log(total);
                })
                $('#total_value').html(total);
                $('#grand_total_value').val(total);

                $(".discount_amount").each(function() {
                    var totaldiscountid = $(this).val() - 0;
                    discount += totaldiscountid;
                    $('#total_discount').html(discount);
                    // console.log(total);
                })
                $('#total_discount').html(discount);
                $('#grand_total_discount').val(discount);


                $(".total_price_without_discount").each(function() {
                    var totalvalueid = $(this).val() - 0;
                    total_with_discount += totalvalueid;
                    $('#total_with_discount').html(total_with_discount);
                    // console.log(total);
                })
                $('#total_with_discount').html(total_with_discount);
                $('#total_payable').val(total_with_discount);
            }


        });

        $(document).ready(function() {


            $(document).on('focus', '.select2-selection.select2-selection--single', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2(
                    'open');
            });

            // steal focus during close - only capture once and stop propogation
            $('select.select2').on('select2:closing', function(e) {
                $(e.target).data("select2").$selection.one('focus focusin', function(e) {
                    e.stopPropagation();
                });
            });


        });

        $(document).ready(function() {

            // $("body").mousemove(function(event) {
            //     $.ajax({
            //         url: '{{ url('/get/last/general/purchase/invoice') }}',
            //         type: "GET",
            //         dataType: 'json',
            //         success: function(data) {

            //             // console.log(data.length!=0)
            //             if (data.length != 0) {
            //                 var dln = parseInt(data.invoice_no) + parseInt(1);
            //                 // var dft = parseInt('50001');
            //                 console.log(dln);
            //                 // document.getElementById("invoiceNo").innerHTML = dln;
            //                 $('#invoiceNo').val(dln);
            //             } else {
            //                 // $('#invoiceNo').val(dft);
            //             }

            //         }
            //     });
            // });

            $("#sbtn").click(function(event) {
                $.ajax({
                    url: '{{ url('sales/salesNumber') }}',
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.length != 0) {
                            var dln = parseInt(data[0].invoice_no) + 1;
                            document.getElementById("invoiceNo").innerHTML = dln;
                        } else {
                            document.getElementById("invoiceNo").innerHTML = 100001;
                        }

                    }
                });
            });





            $('#field').on('change', '.products_id', function() {

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');

                var product_id = parent.find('.products_id').val();

                console.log(product_id);
                $.ajax({
                    url: '{{ url('/general/purchase/product/price/') }}/' +
                        product_id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        var product_price = parseInt(data.rate);
                        parent.find('.p_price').val(product_price);


                    }
                });






                // parent.find('.total_price').val(totalvalueid);
                // parent.find('.discount_amount').val(total_discount);

                //   parent.find('.totalvalueid').val(parseFloat(qt)* parseFloat(up));

            })

            $('#field').on('change', '.maincat', function() {

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');
                var maincat = parent.find('.maincat').val();

                // alert(maincat);
                $.ajax({
                    url: '{{ url('get/gsubcat/by/maincat/') }}/' + maincat,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        // alert(data);
                        var str =
                            '<option value=""> == Select Sub-Category == </option>';
                        $(data).each(function(i, v) {
                            str += '<option value="' + v.id + '">' + v
                                .general_sub_category_name +
                                '</option>';
                        });

                        parent.find('.sub_cat').html(str);
                    }
                });






                // parent.find('.total_price').val(totalvalueid);
                // parent.find('.discount_amount').val(total_discount);

                //   parent.find('.totalvalueid').val(parseFloat(qt)* parseFloat(up));

            })

        });
    </script>
@endsection
