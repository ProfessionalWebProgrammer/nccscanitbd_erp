@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <style media="screen">
        .form-check-input {
          position: absolute;
          margin-top: 0.3rem;
          margin-left: -1.8rem;
          width: 20px;
          height: 20px;}
        </style>

    <div class="content-wrapper">

      <form class="floating-labels m-t-40" action="{{route('qualityControl.update', $data->id)}}" method="POST">
          @csrf

      <!-- Main content -->
      <div class="content px-4 ">
          <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="pt-3 text-center">
                  <h4 class="font-weight-bolder text-uppercase text-danger">Quality Control Create</h4>
                  <hr width="33%">
              </div>
            <div class="row pt-3">
                    <div class="col-md-12">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class=" col-form-label col-md-4">Chalan No:</label>
                                     <input type="text" name="chalan_no"  class="form-control col-md-8" value="{{$data->chalan_no}}">
                                 </div>
                             </div>
                          <div class="col-md-3">
                                <div class="form-group row">
                                      <label class=" col-form-label col-md-4 pl-3"> Select Supplier:</label>
                                       <select name="supplier_id" class="form-control select2 col-md-8 " required>
                                              <option value="">== Select Supplier ==</option>
                                               @foreach ($supplier as $item)
                                               <option value="{{$item->id}}" @if($data->supplier_id == $item->id) selected @else  @endif>{{$item->supplier_name}}</option>
                                               @endforeach
                                       </select>
                                 </div>
                          </div>
                          <div class="col-md-3">
                                <div class="form-group row">
                                      <label class=" col-form-label col-md-4 pl-3"> Product Name:</label>
                                       <select name="product_id" class="form-control select2 col-md-8 " required>
                                              <option value="">== Seleter Product ==</option>
                                               @foreach ($products as $item)
                                              <option value="{{$item->id}}"  @if($data->product_id == $item->id) selected @else  @endif >{{$item->product_name}}</option>
                                              @endforeach
                                       </select>
                                 </div>
                          </div>
                          <div class="col-md-3">
                                <div class="form-group row">
                                    <label class=" col-form-label col-md-4">Quantity:</label>
                                    <input type="number" name="qty" class="form-control col-md-8" value="{{$data->qty}}">
                                 </div>
                             </div>

                         </div>
                     </div>
              </div>
            @php
            $all = DB::table('qc_details')->where('item_type',2)->where('qc_id',$data->id)->get();
            @endphp
            <div class="row mt-3">
                                  <div id="field" class="col-md-12">
                                    @foreach($all as $val)
                                      <div class="row fieldGroup rowname">
                                          <div class="col-md-12">
                                              <div class="row">
                                                  <input type="hidden" name="id[]" value="{{$val->id}}">
                                                  <div class="col-md-11">
                                                      <div class="row">
                                                          <div class="col-md-4">
                                                              <div class="form-group">
                                                                  <label class=" col-form-label">Select Parameter:</label>
                                                                  <select name="parameter_id[]" class="form-control select2 orderProduct" >
                                                                      <option value="">== Select Parameter ==</option>
                                                                               @foreach ($qcParameters as $item)
                                                                                <option value="{{$item->id}}" @if($val->parameter_id == $item->id) selected @else  @endif >{{$item->name}}</option>
                                                                                @endforeach
                                                                  </select>
                                                              </div>
                                                          </div>
                                                        <div class="col-md-2">
                                                              <div class="form-group">
                                                                  <label class=" col-form-label"> Standard Value :</label>
                                                                  <input type="text" name="standard_qty[]"  class="form-control orderUnit" value="{{$val->standard_qty}}" readonly>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-3">
                                                              <div class="form-group">
                                                                  <label class=" col-form-label">Parameter Type:</label>
                                                                  <select name="parameter_type_id[]" class="form-control select2 " >
                                                                      <option value="">== Select Parameter Type ==</option>
                                                                               @foreach ($qcTypes as $item)
                                                                                <option value="{{$item->id}}" @if($val->parameter_type_id == $item->id) selected @else  @endif>{{$item->name}}</option>
                                                                                @endforeach
                                                                  </select>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-3">
                                                              <div class="form-group">
                                                                  <label class=" col-form-label"> Parameter Quantity:</label>
                                                                  <input type="text"  name="parameter_qty[]" required class="form-control" value="{{$val->parameter_qty}}">

                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                                 <div class="col-md-1 mt-2">
                                                      <label for="">Action :</label>
                                                      <a href="javascript:void(0)" style="margin-top: 3px;"
                                                          class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                              class="fas fa-plus-circle"></i></a>
                                                      <a href="javascript:void(0)"
                                                          class="btn btn-sm custom-btn-sbms-remove remove"
                                                          style="margin-top: 3px;"><i
                                                              class="fas  fa-minus-circle"></i></a>

                                                  </div>

                                              </div>
                                          </div>
                                      </div>
@endforeach
                                  </div>
                              </div>

                              <!-- multiple data end -->



                  <div class="col-md-12">
                    <div class="row pt-4">
                    <div class="col-md-3">
                         <div class="form-check h5">
                             <input class="form-check-input" type="radio" @if($data->status == 1)  checked @else  @endif name="status" id="s1" value="1" >
                               <label class="form-check-label" for="s1">Accept </label>
            </div>
                     </div>
                    <div class="col-md-3">
                         <div class="form-check h5">
                             <input class="form-check-input" type="radio" @if($data->status == 0)  checked @else  @endif name="status" id="s2" value="0" >
                               <label class="form-check-label" for="s2">Reject </label>
            </div>
                     </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-primary"> Remarks: </label>
                            <div class="col-sm-10">
                              <textarea name="remarks" rows="3" cols="51%">{{$data->remarks}}</textarea>
                            </div>
                        </div>
                      </div>
                  </div>
              </div>
            <div class="row pb-5">

              <div class="col-md-6 mt-3">
                  <div class="text-right">
                      <button type="submit" class="btn custom-btn-sbms-submit btn-primary"> Submit </button>
                  </div>
              </div>
              <div class="col-md-6 mt-3"></div>
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
               //add more fields group
               $("body").on("click", ".addMore", function() {
                   var fieldHTML =
                       '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-4"> <div class="form-group"> <select name="parameter_id[]" class="form-control select2 orderProduct" required> <option value="">== Select Parameter ==</option> @foreach ($qcParameters as $item) <option value="{{$item->id}}">{{$item->name}}</option> @endforeach </select> </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="text" name="standard_qty[]" class="form-control orderUnit" value="" readonly> </div> </div> <div class="col-md-3"> <div class="form-group"> <select name="parameter_type_id[]" class="form-control select2 " required> <option value="">== Select Parameter Type ==</option> @foreach ($qcTypes as $item) <option value="{{$item->id}}">{{$item->name}}</option> @endforeach </select> </div> </div> <div class="col-md-3"> <div class="form-group"> <input type="text" name="parameter_qty[]" required class="form-control" placeholder="Parameter Quantity"> </div> </div> </div> </div> <div class="col-md-1 mt-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> </div>';
                   $(this).parents('.fieldGroup:last').after(fieldHTML);
               });
               //remove fields group
               $("body").on("click", ".remove", function() {
                   $(this).parents(".fieldGroup").remove();
                 //total();
               });
   /*
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
   */

            $('#field').on('change','.orderProduct', function() {
   		var parent = $(this).closest('.fieldGroup');
           var id = parent.find('.orderProduct').val();

           //alert(id);
           $.ajax({
                       url: '{{ url('purchase/qualitycontrol/getParameter/value/') }}/' + id,
                       type: "GET",
                       dataType: 'json',
                       success: function(data) {
                           $(data).each(function() {
                             //console.log(data);
                             parent.find('.orderUnit').val(data);
                           });
                       }
                   });

               })
           });
       </script>

@endsection
