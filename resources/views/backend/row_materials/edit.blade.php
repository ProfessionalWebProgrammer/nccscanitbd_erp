@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <form class="floating-labels m-t-40" action="{{route('row.materials.update',$data->id)}}" method="POST">
            @csrf
<input type="hidden" name="type" value="raw">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="pt-3 text-center">
                    <h4 class="font-weight-bolder text-uppercase text-danger">Raw Materials Product Create</h4>
                    <hr width="33%">
                </div>

                <div class="row pt-4">
                    <div class="col-md-8 m-auto">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary">Product Name :</label>
                            <div class="col-sm-9">
                                <input type="text" name="product_name" class="form-control" value="{{$data->product_name}}">
                            </div>
                        </div>
                      <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary">Product Code :</label>
                            <div class="col-sm-9">
                                <input type="text" name="code" class="form-control" value="{{$data->code}}">
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-sm-3 col-form-label ">Raw Materials Category : </label>
                            <div class="col-sm-9">
                                <select name="category_id" class="form-control select2" id="">
                                    <option value="">Seleter Product Category</option>
                                  @foreach ($categorys as $item)
                                      <option value="{{$item->id}}" @if($data->category_id == $item->id) selected @else  @endif >{{$item->category_name}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary">Product Unit :</label>
                            <div class="col-sm-9">
                                <input type="text" name="unit" class="form-control" value="{{$data->unit}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary">Product Rate:</label>
                            <div class="col-sm-9">
                                <input type="number" name="rate" class="form-control" value="{{$data->rate}}" step="any">
                            </div>
                        </div>
                        <div class="form-group row">
                           <label class="col-sm-3 col-form-label ">Select Department : </label>
                           <div class="col-sm-9">
                               <select name="department_id" class="form-control select2" id="">
                                   <option value="">Seleter Department</option>
                                 @foreach ($departments as $item)
                                     <option value="{{$item->id}}" @if($data->department_id == $item->id) selected @else  @endif>{{$item->department_title}}</option>
                                 @endforeach
                               </select>
                           </div>
                       </div>
                      {{--   <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary"> Opening Balance : </label>
                            <div class="col-sm-9">
                                <input type="text" name="opening_balance" class="form-control" value="{{$data->opening_balance}}">
                            </div>
                        </div> --}}
                      <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary"> Product Delivery Days : </label>
                            <div class="col-sm-9">
                                <input type="text" name="days" class="form-control" value="{{$data->days}}">
                            </div>
                        </div>
                      <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary"> Minimum Stock Quantity : </label>
                            <div class="col-sm-9">
                                <input type="Text" name="min_stock" class="form-control" value="{{$data->min_stock}}" >
                            </div>
                        </div>
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
                                                              value="{{ $val->id }}" >{{ $val->factory_name }}
                                                          </option>
                                                      @endforeach
                                                  </select>

                                              </div>
                                              <div class="col-md-4">
                                                  <label for="">Opening Balance :</label>
                                                  <input type="text" class="form-control p_qty" name="opening[]" value="">
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
                </div>
              <div class="row pb-5 mt-3">
                <div class="col-md-12 m-auto">
                    <div class="text-center">
                        <button type="submit" class="btn custom-btn-sbms-submit btn-primary"> Submit </button>
                    </div>
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
