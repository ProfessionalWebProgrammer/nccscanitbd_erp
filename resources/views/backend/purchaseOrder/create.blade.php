@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row" style="min-height: 85vh">
                    <div class="col-md-12">
                            <form class="floating-labels m-t-40" action="{{route('purchaseOrder.store')}}" method="POST">
                                @csrf
                                <div class="pt-4 text-center">
                                    <h4 class="font-weight-bolder text-uppercase">Purchase Order</h4>
                                    <hr width="33%">
                                </div>

                                <div class="row pt-3">
                                    <div class="col-md-12">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class=" col-form-label col-md-4">Date:</label>
                                                    <input type="date" name="date" value="{{ date('Y-m-d') }}"
                                                        class="form-control col-md-8">
                                                </div>
                                            </div>
                                            <div class="col-md-4 ">
                                                <div class="form-group row">
                                                    <label class=" col-form-label col-md-4 pl-3"> Supplier :</label>
                                                    <select name="supplier_id" class="form-control select2 col-md-8 " required>
                                                        <option value="">== Select Supplier ==</option>
                                                        @foreach ($suppliers as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->supplier_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                          <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class=" col-form-label col-md-5 pl-1">Delivery Date:</label>
                                                    <input type="date" name="deliveryDate" value="{{ date('Y-m-d') }}"
                                                        class="form-control col-md-7">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                  <div class="form-group row">
                                                    <label class=" col-form-label col-md-6">Reference:</label>
                                                    <input type="text" name="reference_no" class="form-control col-md-6" required >
                                                  </div>
                                            </div>
                                    </div>

                                </div>
                                <div class="row mt-3">
                                    <div id="field" class="col-md-12">

                                        <div class="row fieldGroup rowname">
                                            <div class="col-md-12">
                                                <div class="row">

                                                    <div class="col-md-11">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label">Product Name:</label>
                                                                    <select name="product_id[]" class="form-control select2 orderProduct" required>
                                                                        <option value="">== Select Product ==</option>
                                                                                @foreach ($rawMaterials as $item)
                                                                                    <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                                                                @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                          <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Specification:</label>
                                                                    <input type="text"  name="specification[]" class="form-control" placeholder="Product Specification">
                                                                </div>
                                                            </div>
                                                          <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label">Product Category:</label>
                                                                  <input type="hidden" name="category_id[]"  class="form-control orderCategoryId" value="" >
                                                                  <input type="text"  class="form-control orderCategory" value="" readonly>

                                                                </div>
                                                            </div>
                                                          	<div class="col-md-1">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> UOM (kg):</label>
                                                                    <input type="text" name="unit[]"  class="form-control orderUnit" value="" readonly>
                                                                </div>
                                                            </div>
															<div class="col-md-1">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Price:</label>
                                                                    <input type="text"  name="rate[]" required
                                                                        class="form-control rate" placeholder="Unit Price">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-1">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Quantity:</label>
                                                                    <input type="text"  name="quantity[]" required class="form-control qty" >
                                                                </div>
                                                            </div>


                                                            <div class="col-md-2">

                                                                <div class="form-group">
                                                                    <label class=" col-form-label">Amount:</label>
                                                                    <input type="text"  name="amount[]" readonly  class="form-control amount" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 mt-2">
                                                        <label for="">Action :</label></br>
                                                        <a href="javascript:void(0)"
                                                            class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-sm custom-btn-sbms-remove remove"
                                                            ><i
                                                                class="fas  fa-minus-circle"></i></a>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row col-md-12">
                                    <div class="col-md-4">
										<div class="form-group">
                                            <label class=" col-form-label">Note:</label>
                                            <textarea name="description" class="form-control" cols="30"
                                                rows="4"></textarea>
                                        </div>
                                    </div>
                                  <div class="col-md-2">
															 <div class="form-group">
                                      <label class=" col-form-label">CS No:</label>
                                                                    <select name="cs_no" class="form-control select2 orderProduct">
                                                                        <option value=""> Select CS No </option>
                                                                                @foreach ($cs_no as $item)
                                                                                    <option value="{{ $item->invoice }}">{{ $item->invoice }}</option>
                                                                                @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                          															 <div class="form-group">
                                                                <label class=" col-form-label">MT Invoice:</label>
                                                                                              <select name="mtInvoice_no" class="form-control select2 orderProduct">
                                                                                                  <option value=""> Select MT Invoice No </option>
                                                                                                          @foreach ($marketingInvoice as $item)
                                                                                                              <option value="{{ $item->invoice }}">{{ $item->invoice }}</option>
                                                                                                          @endforeach
                                                                                              </select>
                                                                                          </div>
                                                                                      </div>

                                    <div class="col-md-4  mt-5 font-weight-bold">
                                        <h6>Total Amount : <span id="total_amount"></span> /-</h6>
                                      <input type="hidden"  name="total_amount" class="form-control" id="total_amount_get" >
                                    </div>

                                </div>
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
    <script>


        $(document).ready(function() {
            //add more fields group
            $("body").on("click", ".addMore", function() {
                var fieldHTML =
                    '<div class="row fieldGroup rowname"><div class="col-md-12"><div class="row"><div class="col-md-11"><div class="row"><div class="col-md-3"><div class="form-group"><select name="product_id[]" class="form-control select2 orderProduct" required><option value="">== Select Product ==</option> @foreach ($rawMaterials as $item) <option value="{{ $item->id }}">{{ $item->product_name }}</option> @endforeach </select></div></div><div class="col-md-2"><div class="form-group"><input type="text"  name="specification[]" class="form-control" placeholder="Product Specification"></div></div><div class="col-md-2"><div class="form-group"><input type="hidden" name="category_id[]"  class="form-control orderCategoryId" value="" ><input type="text"  class="form-control orderCategory" value="" readonly></div></div><div class="col-md-1"><div class="form-group"> <input type="text" name="unit[]"  class="form-control orderUnit" value="" readonly></div></div><div class="col-md-1"><div class="form-group"><input type="text"  name="rate[]" required class="form-control rate" placeholder="Unit Price"></div></div><div class="col-md-1"><div class="form-group"><input type="text"  name="quantity[]" required class="form-control qty" ></div></div><div class="col-md-2"><div class="form-group"><input type="text"  name="amount[]" readonly  class="form-control amount" ></div></div></div></div><div class="col-md-1 mt-2"><a href="javascript:void(0)" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a><a href="javascript:void(0)" class="ml-2 btn btn-sm custom-btn-sbms-remove remove" ><i class="fas  fa-minus-circle"></i></a></div></div></div></div>';
                $(this).parents('.fieldGroup:last').after(fieldHTML);
            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
              total();
            });

           $('#field').on('input', '.rate, .qty', function() {
                var parent = $(this).closest('.fieldGroup');
                var rate = parent.find('.rate').val();
                var qty = parent.find('.qty').val();
                var total_price = rate * qty;

				parent.find('.amount').val(total_price);
                total();
            });

        function total() {
                var total = 0;
                $(".amount").each(function() {
                    var totalvalueid = $(this).val() - 0;
                    total += totalvalueid;
                    $('#total_amount').html(total);

                    // console.log(total);
                })
                $('#total_amount').html(total);
          		$('#total_amount_get').val(total);
            }


         $('#field').on('change','.orderProduct', function() {
		var parent = $(this).closest('.fieldGroup');
        var id = parent.find('.orderProduct').val();
        //var url = '{{ url('/settings/get/category/') }}/' + id;
        //alert(url);
        $.ajax({
                    url: '{{ url('/settings/get/category/') }}/' + id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $(data).each(function() {
                          //console.log(data);
                          parent.find('.orderCategoryId').val(data.cat_id);
                          parent.find('.orderCategory').val(data.cat);
                          parent.find('.orderUnit').val(data.unit);
                        });
                    }
                });

            })
        });
    </script>
@endsection
