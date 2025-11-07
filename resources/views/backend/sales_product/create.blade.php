@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <form class="floating-labels m-t-40" action="{{ route('sales.item.store') }}" method="POST">
            @csrf

            <div class="content px-4 ">

              <input type="hidden" name="type" value="fg">
                <div class="container" style="background:#fff;padding:0px 40px; min-height:85vh;">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Item Create</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Name :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="pname" name="product_name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Weight/Count :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="Weight"
                                        name="product_weight">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Weight Unit :</label>
                                <div class="col-sm-9">

                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="product_weight_unit">
                                        <option value="">Select Item Weight Unit</option>
                                        @foreach ($units as $val)
                                            <option value="{{ $val->id }}">{{ $val->unit_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Category :</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="category_id">
                                        <option value="">Select Item Category</option>

                                        @foreach ($categories as $data)
                                            <option value="{{ $data->id }}">{{ $data->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dealer Price :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="dpprice"  name="product_dp_price">
                                <span class="text-danger"></span>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">MRP :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="dpprice"  name="product_mrp">
                                <span class="text-danger"></span>
                                </div>
                            </div>
							             {{-- <div class="form-group row">
                                <label for="openingbalance" class="col-sm-3 col-form-label">Opening Balance :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="openingbalance"  name="opening_balance">
                                <span class="text-danger"></span>
                                </div>
                            </div> --}}
                            <h6>Warehouse Setup</h6>
                            <div id="field" class="col-md-12">
                                <div class="row fieldGroup rowname">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="row">
                                                  <div class="col-md-8">
                                                    <label for="">Warehouse Name:</label>
                                                      <select class="form-control select2 products_id" name="warehouse_id[]"
                                                          data-live-search-style="startsWith" required>
                                                          <option value=" " selectedS>Select Warehouse</option>
                                                          @foreach ($warehous as $val)
                                                              <option style="color:#000;font-weight:600;"
                                                                  value="{{ $val->id }}">{{ $val->factory_name }}
                                                              </option>
                                                          @endforeach
                                                      </select>

                                                  </div>
                                                  <div class="col-md-4">
                                                      <label for="">Opening Balance :</label>
                                                      <input type="text" class="form-control p_qty" name="opening[]" required placeholder="Opening Balance">
                                                  </div>
                                                </div>
                                             </div>
                                             <div class="col-md-2">
                                               <label for="">Action :</label> <br>
                                               <a href="javascript:void(0)" style="margin-top: 3px;"
                                                   class="btn custom-btn-sbms-add btn-light btn-sm addMore"><i
                                                       class="fas fa-plus-circle"></i></a>
                                               <a href="javascript:void(0)"  class="btn btn-danger btn-sm custom-btn-sbms-remove remove"
                                                   style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                        </div>

                        <div class="col-md-6">


                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Code :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="pcode" name="product_code">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Unit :</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="product_unit">
                                        <option value="">Select Item Unit</option>
                                        @foreach ($units as $val)
                                            <option value="{{ $val->id }}">{{ $val->unit_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">BarCode :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="barcode" name="product_barcode">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Product Rate :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control"  name="rate">
                                    <span class="text-danger"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Discount (%) :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="dc"  name="product_dealer_commision">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Description :</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" rows="4" id="input7" name="product_description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <div class="row pb-5">
                        <div class="col-md-6 mt-3">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary custom-btn-sbms-submit"> Submit </button>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">

                        </div>
                    </div>

					</div>
                    <!-- /.container-fluid -->
                </div>

        </form>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@push('end_js')
<script>
  $(document).ready(function() {
$("body").on("click", ".addMore", function() {

    var fieldHTML =
        '<div class="row fieldGroup rowname mt-3"> <div class="col-md-12"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-8"> <select class="form-control select2 products_id" name="warehouse_id[]" data-live-search-style="startsWith" required> <option value=" " selectedS>Select Warehouse</option> @foreach ($warehous as $val) <option style="color:#000;font-weight:600;" value="{{ $val->id }}">{{ $val->factory_name }} </option> @endforeach </select> </div> <div class="col-md-4"> <input type="text" class="form-control p_qty" name="opening[]" required placeholder="Opening Balance"> </div> </div> </div> <div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-light btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)"  class="btn btn-danger btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a> </div> </div> </div> </div>';

  $(this).parents('.fieldGroup:last').after(fieldHTML);


  $('.select2').select2({
    theme: 'bootstrap4'
    })

});

//remove fields group
$("body").on("click", ".remove", function() {
    $(this).parents(".fieldGroup").remove();
});
});
</script>
@endpush
