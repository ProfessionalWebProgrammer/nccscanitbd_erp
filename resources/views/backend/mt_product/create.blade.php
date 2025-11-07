@extends('layouts.crm_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <form class="floating-labels m-t-40" action="{{ Route('marketing.item.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="content px-4 ">


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
                                    <input type="text" class="form-control" id="pname" name="name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Unit :</label>
                                <div class="col-sm-9">

                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="unit">
                                        <option value="">Select Item Weight Unit</option>
                                        <option value="KG">KG</option>
                                        <option value="gm">gm</option>
                                        <option value="Litter">Litter</option>
                                        <option value="ml">ml</option>
                                      	<option value="pcs">Pcs</option>
                                      	<option value="dojon">Dojon</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Code :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="pcode" name="code">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">



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
                                <label class="col-sm-3 col-form-label">Item Sub Category :</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="sub_category_id">
                                        <option value="">Select Item Sub Category</option>

                                        @foreach ($subCategories as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Image:</label>
                                <div class="col-sm-9">
                                    <input type="file"  name="image">
                                <span class="text-danger"></span>
                                </div>
                            </div>

                            </div>
                            {{-- <div class="col-md-12">
                              <div class="form-group row">
                                  <label class="col-sm-2 col-form-label">Specification :</label>
                                  <div class="col-sm-10">
                                      <textarea class="form-control" rows="4" id="input7" name="specification"></textarea>
                                  </div>
                              </div>
                            </div> --}}
                        </div>

                        <h5 class="mt-3 text-uppercase">Product Specification</h5>
                          <hr class="bg-light mt-0 pt-0">
                          {{-- Production Multiple add button code start from here! --}}
                        	<div class="row">
                              <div id="field" class="col-md-12">
                                  <div class="row fieldGroup rowname mb-2">
                                      <div class="col-md-8">
                                        <div class="row">
                                              <div class="col-md-10">
                                                <div class="row">
                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label  class="col-form-label">Specification Name : </label>
                                                          <select name="specification_id[]" class="form-control select2 " >
                                                              <option value="">== Select Specification ==</option>
                                                              @foreach ($specifications as $item)
                                                                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                              @endforeach
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label for="value" class="col-form-label" required>Value:  </label>
                                                          <input type="text" class="form-control" name="value[]" id="value">
                                                      </div>
                                                  </div>
                                                </div>
                                               </div>
                                          	<div class="col-md-2">
                                                <label for="">Action :</label><br>
                                                <a href="javascript:void(0)" style="margin-top: 3px;"
                                                      class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                          class="fas fa-plus-circle"></i></a>
                                                  <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"
                                                      style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>
                                            	</div>
                              				</div>
                        					</div>
                                    	<div class="col-md-4">
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
    <script>
    $(document).ready(function() {

        var x = 1
        //add more fields group
        $("body").on("click", ".addMore", function() {
            x = x+1;
            var fieldHTML =
                '<div class="row fieldGroup rowname mb-2"> <div class="col-md-8"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-6"> <div class="form-group"> <select name="specification_id[]" class="form-control select2 finish_goods_id" id="finish_goods_id" required> <option value="">== Select Specification ==</option> @foreach ($specifications as $item) <option value="{{ $item->id }}">{{ $item->name }}</option> @endforeach </select> </div> </div> <div class="col-md-6"> <div class="form-group"> <input type="text" class="form-control" name="value[]" id="value"> </div> </div> </div> </div> <div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> <div class="col-md-5"> </div> </div>';

          $(this).parents('.fieldGroup:last').after(fieldHTML);

         selected();
          $('.select2').select2({
            theme: 'bootstrap4'
            })

        });


        //remove fields group
        $("body").on("click", ".remove", function() {
            $(this).parents(".fieldGroup").remove();
          //  total();
            x = x-1;
            //console.log(x);

        });
});
    </script>
@endsection
