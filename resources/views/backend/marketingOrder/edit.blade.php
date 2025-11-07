@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <form class="floating-labels m-t-40" action="{{ URL::to('/sales/item/update/' . $itemdata->id) }}" method="POST">
            @csrf

            <div class="content px-4 ">


                <div class="container" style="background: #ffffff; padding: 0px 40px; min-height:85vh">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Edit Item</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Name :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $itemdata->product_name }}"
                                        id="pname" name="product_name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Weight :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $itemdata->product_weight }}"
                                        id="Weight" name="product_weight">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Category :</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="category_id">
                                        <option value="">Select Item Category</option>

                                        @foreach ($categories as $data)
                                            <option value="{{ $data->id }}" @if ($itemdata->category_id == $data->id) selected @endif>
                                                {{ $data->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Sales Price :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $itemdata->product_dp_price }}"
                                        id="dpprice" name="product_dp_price">
                                    <span class="text-danger"></span>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">MRP :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $itemdata->product_mrp }}"
                                        id="dpprice" name="product_mrp">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
							<div class="form-group row">
                                <label for="openingbalance" class="col-sm-3 col-form-label">Opening Balance :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="openingbalance" value="{{$itemdata->opening_balance}}" name="opening_balance">
                                <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">


                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Code :</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{ $itemdata->product_code }}" class="form-control"
                                        id="pcode" name="product_code">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Code :</label>
                                <div class="col-sm-9">

                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="product_weight_unit">
                                        <option value="">Select Item Weight Unit</option>
                                        <option value="KG" @if ($itemdata->product_weight_unit == 'KG') selected @endif>KG</option>
                                        <option value="gm" @if ($itemdata->product_weight_unit == 'gm') selected @endif>gm</option>
                                        <option value="Litter" @if ($itemdata->product_weight_unit == 'Litter') selected @endif>Litter</option>
                                        <option value="ml" @if ($itemdata->product_weight_unit == 'ml') selected @endif>ml</option>
                                      	<option value="pcs" @if ($itemdata->product_weight_unit == 'pcs') selected @endif>Pcs</option>
                                      	<option value="dojon" @if ($itemdata->product_weight_unit == 'dojon') selected @endif>Dojon</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Production Price :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $itemdata->product_barcode }}"
                                        id="barcode" name="product_barcode">
                                    <span class="text-danger"></span>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Discount (%) :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"
                                        value="{{ $itemdata->product_dealer_commision }}" id="dc"
                                        name="product_dealer_commision">
                                    <span class="text-danger"></span>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Description :</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="4" id="input7"
                                        name="product_description">{{ $itemdata->product_description }}</textarea>
                                </div>
                            </div>





                        </div>

                    </div>
                  <div class="row pb-5  mt-3">
                    <div class="col-md-6 m-auto">
                        <div class="text-center">
                            <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                        </div>
                    </div>
                </div>
                </div>

                


                <!-- /.container-fluid -->
            </div>

        </form>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script>

    </script>
@endsection
