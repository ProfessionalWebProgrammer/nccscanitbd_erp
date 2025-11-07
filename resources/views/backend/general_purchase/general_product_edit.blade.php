@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row" style="min-height: 85vh">
                    <div class="col-md-12">
                        <form class="floating-labels m-t-40"
                            action="{{ route('general.purchase.general.product.restore') }}" method="POST">
                            @csrf
                            <div class="pt-4 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Edit General Product</h4>
                                <hr width="33%">
                            </div>

                            <div class="row pt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" col-form-label">Product Name :</label>
                                        <input type="text" name="product_name" value="{{ $gproduct->gproduct_name }}"
                                            class="form-control" placeholder="Product Name">
                                        <input type="hidden" name="id" value="{{ $gproduct->id }}">
                                    </div>
                                    <div class="form-group">
                                        <label class=" col-form-label">Opening Balance:</label>
                                        <input type="text" name="opening_balance" value="{{ $gproduct->opening_balance }}"
                                            class="form-control" placeholder="Opening Balance">
                                    </div>
                                    <div class="form-group">
                                        <label class=" col-form-label">Product Rate:</label>
                                        <input type="number" name="product_rate" value="{{ $gproduct->rate }}" step="any"
                                            class="form-control" placeholder="Product Rate">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" col-form-label">Dimension:</label>
                                        <input type="text" name="product_dimension" value="{{ $gproduct->dimensions }}"
                                            class="form-control" placeholder="Product Dimension">
                                    </div>
                                    <div class="form-group">
                                        <label class=" col-form-label">Category Name :</label>
                                        <select class="form-control select2" name="category_id" id="main_cat">
                                            <option value="">== Select Category ==</option>
                                            @foreach ($gcategory as $item)
                                                <option value="{{ $item->id }}" @if ($item->id == $gproduct->general_category_id) selected @endif>
                                                    {{ $item->gcategory_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class=" col-form-label">Sub-Category Name:</label>
                                        <select class="form-control select2" name="sub_category_id" id="sub_cat">
                                            @foreach ($subcat as $scat)
                                                <option value="{{ $scat->id }}" @if ($scat->id == $gproduct->general_sub_category_id) selected @endif>
                                                    {{ $scat->general_sub_category_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-5">
                                    <div class="text-center">
                                        <button type="submit" class="btn custom-btn-sbms-submit"> Update </button>
                                    </div>
                                </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /.content-wrapper -->
    <script>
        $(document).ready(function() {
            $('#main_cat').on('change', function() {
                var main_cat = $(this).val();
                // alert(main_cat);
                if (main_cat != '') {
                    $.ajax({
                        url: '{{ url('get/gsubcat/by/maincat/') }}/' + main_cat,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // alert(data);
                            var str = '<option value=""> == Select Sub-Category == </option>';
                            $(data).each(function(i, v) {
                                str += '<option value="' + v.id + '">' + v
                                    .general_sub_category_name +
                                    '</option>';
                            });

                            $('#sub_cat').html(str);
                        }
                    });
                } //endif

            });
        });
    </script>
@endsection
