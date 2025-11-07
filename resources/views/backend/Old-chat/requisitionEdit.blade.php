@extends('layouts.backendbase')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('user.chat.update')}}" method="post">
                @csrf
              <input type="hidden" name="id" value="{{$data->id}}">
              <div class="container-fluid" id="field">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Purchase Requisition Form Update</h4>
                        <hr width="33%">
                    </div>
                <input type="hidden" name="id" value="{{$data->id}}">
                    <div class="row fieldGroup pt-4 col-md-12">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"> Select User :</label>
                                <div class="col-sm-8">
                                    <select class="form-control selectpicker border border-secondary" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple  name="user_id[]">
                                      
                                      @foreach ($selectedUser as $item)
                                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                        @endforeach
                                      
                                        @foreach ($users as $item)                                       
                                            <option value="{{$item->id}}">{{$item->name ?? ''}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"> Reference:</label>
                                <div class="col-sm-8">
                                   <input type="text" name="reference"  class="form-control"  value="{{$data->reference ?? ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                              <label for="required_date" class="col-sm-4 col-form-label">Required Date : </label>
                              <div class="col-sm-8">
                                  <input type="date" class="form-control" name="required_date" value="{{$data->required_date ?? ''}}">
                              </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                              <label for="last_purchase_date" class="col-sm-4 col-form-label">Last Purchase Date : </label>
                              <div class="col-sm-8">
                                  <input type="date" class="form-control" name="last_purchase_date" value="{{$data->last_purchase_date ?? ''}}">
                                </div>
                          </div>
                        </div>
                        <!-- multiple data start -->
                        <div class="row mt-3">
                                <div class="fieldGroup rowname">
                                  <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class=" col-form-label">Product Name:</label>  
                                                        </div>
                                                    </div>
                                                  <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class=" col-form-label"> Specification:</label> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class=" col-form-label"> UOM (Kg):</label>  
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <label class=" col-form-label"> Stock In:</label>                                                           
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <label class=" col-form-label"> Quantity:</label>
                                                        </div>
                                                    </div>

                                                   <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class=" col-form-label"> LUP:</label>                                                         
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1 mt-2">
                                                <label for="">Action :</label>
                                                
                                            </div>
                                        </div>
                                    </div>
									@foreach($details as $val)
                                    <div class="col-md-12">
                                        <div class="row">
                                          <input type="hidden" name="item_id[]" value="{{$val->id}}">
                                            <div class="col-md-11">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <select name="item[]" class="form-control select2 orderProduct" required>
                                                                        @foreach ($products as $item)
                                                                            <option value="{{ $item->id }}" @if($val->item == $item->id) selected  @else  @endif>{{ $item->product_name }}</option>
                                                                        @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                  <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text"  name="specification[]" class="form-control" value="{{$val->specification}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <input type="text" name="unit[]"  class="form-control orderUnit"  value="{{$val->unit}}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <input type="text"  name="stock[]" required class="form-control stock" value="{{$val->stock}}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <input type="text"  name="qty[]" required class="form-control qty" value="{{$val->qty}}">

                                                        </div>
                                                    </div>

                                                   <div class="col-md-2">
                                                        <div class="form-group">
                                                            <input type="text"  name="lup[]" required class="form-control rate" value="{{$val->lup}}">
                                                            <input type="hidden"  name="amount[]" class="form-control amount" >
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-1 mt-2">
                                                <a href="javascript:void(0)" class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                        class="fas fa-plus-circle"></i></a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm custom-btn-sbms-remove remove"><i
                                                        class="fas  fa-minus-circle"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                  @endforeach
                                  
                                
                        </div>
                        <!-- multiple data end -->
                      </div>
                  </div>
                        <div class="row col-md-12 mt-3">
                        <div class="col-md-12 row">
                          <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"> Remarks:</label>
                                <div class="col-sm-8">
                                    <textarea name="description" class="form-control" required  rows="2">{{$data->description}}</textarea>
                                </div>
                            </div>
                        </div>
                          
                          <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"> Select Approved User:</label>
                                <div class="col-sm-8">
                                    <select name="approved_user" class="form-control select2" required>
                                        @foreach ($users as $item)
                                            <option value="{{$item->id}}" @if($data->approved_user == $item->id) selected  @else  @endif>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>

                <div class="row pb-5">
                    <div class="col-md-3"></div>

                    <div class="col-md-6 mt-3">
                        <div class="text-center">
                            <button type="submit" class="btn custom-btn-sbms-submit"> Update </button>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">

                    </div>
                </div>
            </form>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

<script type="text/javascript">
$(document).ready(function() {
    //add more fields group
    $("body").on("click", ".addMore", function() {
        var fieldHTML =
            '<div class="row fieldGroup rowname"><div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-3"> <div class="form-group"> <select name="item[]" class="form-control select2 orderProduct" required> <option value="">== Select Product ==</option> @foreach ($products as $item) <option value="{{ $item->id }}">{{ $item->product_name }}</option> @endforeach </select> </div> </div> <div class="col-md-3"> <div class="form-group">  <input type="text" name="specification[]" class="form-control" placeholder="Product Specification"> </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="text" name="unit[]" class="form-control orderUnit" readonly> </div> </div> <div class="col-md-1"> <div class="form-group"> <input type="text" name="stock[]" required class="form-control stock" readonly> </div> </div> <div class="col-md-1"> <div class="form-group"> <input type="text" name="qty[]" required class="form-control qty" placeholder="Required Quantity"> </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="text" name="lup[]" required class="form-control rate" placeholder="Last Unit Price"> <input type="hidden" name="amount[]" class="form-control amount" > </div> </div> </div> </div> <div class="col-md-1 mt-2"> <a href="javascript:void(0)" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" ><i class="fas fa-minus-circle"></i></a> </div>  </div> </div></div> </div>';
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
                  parent.find('.orderUnit').val(data.unit);
                  parent.find('.stock').val(data.stock);
                });
            }
        });

    })
});
</script>


<!-- <script type="text/javascript">
  $(document).ready(function() {
  $('#field').on('change','.orderProduct', function() {
    var parent = $(this).closest('.fieldGroup');
    var id = parent.find('.orderProduct').val();
    // alert(id);
    $.ajax({
             url: '{{ url('/settings/get/category/') }}/' + id,
             type: "GET",
             dataType: 'json',
             success: function(data) {
                 $(data).each(function() {
                   console.log(data);
                   parent.find('.orderUnit').val(data.unit);
                   parent.find('.stock').val(data.stock);
                 });
             }
         });

     });
});
</script> -->


@endsection
