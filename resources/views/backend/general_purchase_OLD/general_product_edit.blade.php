@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
            <div class="row" style="min-height: 85vh">
                <div class="col-md-12">

                    <div class="content px-4 ">

                        <form class="floating-labels m-t-40" action="{{ route('general.purchase.general.product.restore') }}"
                            method="POST">
                            @csrf
                            <div class="container-fluid">
                                <div class="pt-4 text-center">
                                    <h4 class="font-weight-bolder text-uppercase text-danger">Edit General Product</h4>
                                    <hr width="33%">
                                </div>

                                <div class="row pt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=" col-form-label text-primary">Product Name :</label>
                                            <input type="text" name="product_name" value="{{$gproduct->gproduct_name}}" class="form-control"
                                                placeholder="Product Name">
                                          	<input type="hidden" name="id" value="{{$gproduct->id}}">
                                        </div>
                                        <div class="form-group">
                                            <label class=" col-form-label text-primary">Opening Balance:</label>
                                            <input type="text" name="opening_balance" value="{{$gproduct->opening_balance}}" class="form-control"
                                                placeholder="Opening Balance">
                                        </div>
                                        <div class="form-group">
                                            <label class=" col-form-label text-primary">Product Rate:</label>
                                            <input type="text" name="product_rate" value="{{$gproduct->rate}}" class="form-control"
                                                placeholder="Product Rate">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=" col-form-label text-primary">Dimension:</label>
                                            <input type="text" name="product_dimension" value="{{$gproduct->dimensions}}" class="form-control"
                                                placeholder="Product Dimension">
                                        </div>
                                        <div class="form-group">
                                            <label class=" col-form-label text-primary">Category Name :</label>
                                            <select class="form-control select2" name="category_id" id="main_cat">
                                                <option value="">== Select Category ==</option>
                                                @foreach ($gcategory as $item)
                                                    <option value="{{ $item->id }}" @if($item->id==$gproduct->general_category_id) selected @endif>{{ $item->gcategory_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class=" col-form-label text-primary">Sub-Category Name:</label>
                                            <select class="form-control select2" name="sub_category_id" id="sub_cat">
                                                @foreach ($subcat as $scat)
                                                    <option value="{{ $scat->id }}" @if($scat->id==$gproduct->general_sub_category_id) selected @endif>{{ $scat->general_sub_category_name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-5">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary custom-btn-sbms-submit"> Update </button>
                                        </div>
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
