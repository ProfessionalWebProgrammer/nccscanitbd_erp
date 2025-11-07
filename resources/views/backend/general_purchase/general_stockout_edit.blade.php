@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <div class="container-fluid">
            <div class="row" style="min-height: 85vh">
                <div class="col-md-12" style="border-right: solid #003B46">

                    <div class="content px-4 ">

                        <form class="floating-labels m-t-40" action="{{ route('general.purchase.stockout.update') }}"
                            method="POST">
                            @csrf
                            <div class="container-fluid">
                                <div class="pt-4 text-center">
                                    <h4 class="font-weight-bolder text-uppercase">Create General Stockout</h4>
                                    <hr width="33%">
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="">Date:</label>
                                                    <input type="date" name="date" value="{{$editdata->date}}"
                                                        class="form-control">
                                                  	<input type="hidden" name="id" value="{{$editdata->id }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  <div class="col-md-4">
                                       <div class="form-group">
                                                                    <label for=""> Wirehouse Name:</label>
                                                                    <select class="form-control select2" name="wirehouses_id"
                                                                        id="" required>
                                                                        <option value="">Select Wirehouse</option>
                                                                        @foreach ($wirehouses as $wh)
                                                                            <option style="color:#000;font-weight:600;"
                                                                                value="{{ $wh->wirehouse_id  }}" @if($wh->wirehouse_id ==$editdata->wirehouse_id) selected @endif>
                                                                                {{ $wh->wirehouse_name  }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Referance</label>
                                            <input type="text" class="form-control" value="{{$editdata->Referance}}" name="referance"
                                                placeholder="Enter Referance">
                                        </div>
                                    </div>
                                </div>
                                {{-- Multiple add button code start from here! --}}
                                <div class="row mt-3">
                                    <div id="field" class="col-md-12 m-auto">
                                        <div class="row fieldGroup rowname">
                                            <div class="col-md-12 mb-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="">Product Name:</label>
                                                                <select class="form-control select2 products_id"
                                                                    name="products_id" id="products_id" required>
                                                                    <option value=""> == Select == </option>
                                                                    @foreach ($gproducts as $product)
                                                                        <option style="color:#000;font-weight:600;"
                                                                            value="{{ $product->id }}"  @if($product->id ==$editdata->product_id) selected @endif>
                                                                            {{ $product->gproduct_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
															
                                                            
                                                            <div class="col-md-3">
                                                                <label for="">Quantity :</label>
                                                                <input type="number" step="any" value="{{$editdata->quantity}}" class="form-control" name="p_qty"
                                                                    placeholder="Quantity">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="">Dimension :</label>
                                                                <input type="text" class="form-control dimension"
                                                                    name="dimension" value="{{$editdata->dimensions}}" placeholder="Dimension">
                                                            </div>
                                                          <div class="col-md-3">
                                                                <label for="">Price :</label>
                                                                <input type="text" value="{{$editdata->price}}" class="form-control price" name="price"
                                                                    placeholder="Price">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- multiple add end on here --}}
                              	<div class="row">
                                    <div class="col-md-6 m-auto">
                                        <div class="form-group">
                                            <label for="">Note:</label>
                                          	<textarea rows="2" class="form-control" name="note"
                                                placeholder="Note">{{$editdata->note}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pb-5">
                                    <div class="col-md-12 mt-3 text-center">
                                        <button type="submit" class="btn custom-btn-sbms-submit" style=""> Stockout Confirm
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
                    '<div class="row fieldGroup rowname"> <div class="col-md-12 mb-3"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-3"> <select class="form-control select2 products_id" name="products_id[]" id="products_id" required> <option value="">==Select==</option> @foreach ($gproducts as $product) <option style="color:#000;font-weight:600;" value="{{$product->id}}">{{$product->gproduct_name}}</option> @endforeach </select> </div><div class="col-md-3"> <input type="number" step="any" class="form-control" name="p_qty[]" placeholder="Quantity"> </div><div class="col-md-3"> <input type="text" class="form-control dimension" name="dimension[]" placeholder="Dimension"> </div><div class="col-md-3"> <input type="text" class="form-control price" name="price[]" placeholder="Price"> </div></div></div><div class="col-md-1 text-center"> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"><i class="fas fa-minus-circle"></i></a> <a href="javascript:void(0)" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> </div></div></div></div>';

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
                         //console.log(data);
                        var product_dimen = data.dimensions;
                        var product_price = parseInt(data.rate);
                        parent.find('.price').val(product_price);
                        parent.find('.dimension').val(product_dimen);


                    }
                });
            })

        });
    </script>
@endsection
