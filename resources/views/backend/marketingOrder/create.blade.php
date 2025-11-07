@extends('layouts.crm_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">
				<div class="row pt-2 pb-2">
                  	<div class="col-md-1"></div>
                      <div class="col-md-3 text-left">
                      	<a href="{{route('marketingOrder.item.index')}}" class="btn btn-sm btn-success">Order List</a>
                    </div>
                </div>

        <!-- Main content -->
        <div class="content px-4 ">

            <form action="{{route('marketingOrder.item.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="container" style="background: #ffffff; padding: 0px 40px; min-height:85vh">
                  <div class="text-center py-2">
                      <h3>Order Create</h3>
                      <hr>
                  </div>
                    <div class="row pt-4">
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label text-right">Date : </label>
                                <div class="col-sm-9">
                                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label text-right">Delivery Date </label>
                                <div class="col-sm-8">
                                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="require_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Company Name :</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" required name="company_id"  >
                                        <option value="">Select Company</option>
                                        @foreach ($company as $data)
                                            <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                {{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                          {{--  <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Branch/Warehouse :</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2"
                                        name="warehouse_id" id="wirehouse" required>

                                        <option value="">Select Warehouse</option>

                                        @foreach ($factoryes as $factorye)
                                            <option style="color:#000;font-weight:600;" value="{{ $factorye->id }}">
                                                {{ $factorye->factory_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                        </div>
                        <div class="col-md-2 text-right">
                            <div class="mb-3">
                                Invoice No:<span class="mt-4 font-weight-bold"> Mt-</span><span class="mt-4 font-weight-bold" id="invoiceNo"> </span>
                                <input type="hidden" name="invoice" id="invoice" value="">
                            </div>
                        </div>
                        </div>
                        <div id="field" class="col-md-12">
                        <div class="row fieldGroup rowname">
                        <div class="col-md-3">
                          <div class="form-group row">
                               <label class="col-sm-4 col-form-label text-right">Approved By </label>
                               <div class="col-sm-8">
                                   <select class="form-control select2" name="approved_by" id="approvedId" required>
                                       <option value="">Select User</option>
                                       @foreach ($users as $val)
                                           <option style="color:#000;font-weight:600;" value="{{ $val->id }}">
                                               {{ $val->name }}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                        </div>

                          <div class="col-md-4 product" >
                            <div class="form-group row fieldGroup">
                              <label class="col-sm-3 col-form-label text-right">Product Name :</label>
                              <div class="col-sm-9">
                              <select class="form-control select2 products_id"
                                  name="products_id"
                                  data-live-search-style="startsWith" id="products_id" required>
                                  <option value=" " selected>Select Product</option>
                                  @foreach ($products as $product)
                                      <option style="color:#000;font-weight:600;"
                                          value="{{ $product->id }}">{{ $product->name }} - {{$product->code}}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                          </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-group row">
                              <label class="col-sm-4 col-form-label text-right">Quantity :</label>
                              <input type="text" class="form-control p_qty col-sm-8" name="qty" placeholder="Quantity" required>
                          </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label text-right">Image :</label>
                              <input type="file" class=" col-sm-9" name="image" placeholder="image">
                          </div>
                          </div>

                          {{--<div class="col-md-12">
                            <div class="form-group row">
                              <label class="col-sm-1 col-form-label text-right">Specification </label>
                              <input type="text" class="form-control specification col-sm-11" id="product_specin" name="specification" placeholder="Specification" >
                          </div>
                        </div> --}}
                          </div>
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
                                                  <label for="finish_goods_id" class="col-form-label">Specification Name : </label>

                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="value" class="col-form-label" required>Value:  </label>

                                              </div>
                                          </div>
                                        </div>
                                       </div>
                                    <div class="col-md-2">
                                        <label for="">Action :</label>

                                      </div>
                              </div>
                          </div>
                          <div class="col-md-4">
                          </div>
                          </div>
                            {{--  <div class="row fieldGroup rowname mb-2">
                                  <div class="col-md-8">
                                    <div class="row">
                                          <div class="col-md-10">
                                            <div class="row">
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label for="finish_goods_id" class="col-form-label">Specification Name : </label>
                                                      <select name="specification_id[]" class="form-control select2 finish_goods_id" id="finish_goods_id" required>
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
                          	</div> --}}

                        	</div>
                        </div>

                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3">
                                 <button type="submit" class="btn btn-primary custom-btn-sbms-submit" style="width: 100%"> Order Confirm </button>
                         </div>
                        <div class="col-md-4 mt-3">

                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </form>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection


@push('end_js')


<script>
    $(document).ready(function() {

      $('select[name="products_id"]').on('change',function() {
               var id = $(this).val();
              //alert(id);
              $.ajax({
                  url : '{{url('marketing/order/item/SpecificationData/')}}/'+id,
                  type:"GET",
                  dataType: 'json',
                  success : function(data) {
                      console.log(data);

                    if(data != ''){

                       $.each(data , function(index, val) {
                           var fieldHTML ='<div class="row fieldGroup rowname mb-2"> <div class="col-md-8"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-6"> <div class="form-group"> <select name="specification_id[]" class="form-control select2 finish_goods_id" id="finish_goods_id" required> <option value="'+val.specification_id+'" selected >'+val.name+'</option> @foreach ($specifications as $item) <option value="{{ $item->id }}">{{ $item->name }}</option> @endforeach </select> </div> </div> <div class="col-md-6"> <div class="form-group"> <input type="text" class="form-control" name="value[]" id="value" value="'+val.value+'">  </div> </div> </div> </div> <div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> <div class="col-md-5"> </div> </div>';
                          $('.fieldGroup:last').after(fieldHTML);

                          $('.select2').select2({
                              theme: 'bootstrap4'
                          })

                       })
                     } else {

                       var fieldHTML =
                           '<div class="row fieldGroup rowname mb-2"> <div class="col-md-8"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-6"> <div class="form-group"> <select name="specification_id[]" class="form-control select2 finish_goods_id" id="finish_goods_id" required> <option value="">== Select Specification ==</option> @foreach ($specifications as $item) <option value="{{ $item->id }}">{{ $item->name }}</option> @endforeach </select> </div> </div> <div class="col-md-6"> <div class="form-group"> <input type="text" class="form-control" name="value[]" id="value"> </div> </div> </div> </div> <div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> <div class="col-md-5"> </div> </div>';

                     $(this).parents('.fieldGroup:last').after(fieldHTML);


                     $('.select2').select2({
                       theme: 'bootstrap4'
                       })

                     }
             }

             });

             });


       var x = 1
        //add more fields group
        $("body").on("click", ".addMore", function() {
            x = x+1;
            var fieldHTML =
                '<div class="row fieldGroup rowname mb-2"> <div class="col-md-8"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-6"> <div class="form-group"> <select name="specification_id[]" class="form-control select2 finish_goods_id" id="finish_goods_id" required> <option value="">== Select Specification ==</option> @foreach ($specifications as $item) <option value="{{ $item->id }}">{{ $item->name }}</option> @endforeach </select> </div> </div> <div class="col-md-6"> <div class="form-group"> <input type="text" class="form-control" name="value[]" id="value"> </div> </div> </div> </div> <div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> <div class="col-md-5"> </div> </div>';

          $(this).parents('.fieldGroup:last').after(fieldHTML);


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
/*
        $('#field').on('input','.p_qty',function(){

            var parent = $(this).closest('.fieldGroup');
            //var product_price=parent.find('.p_price').val();

            var product_qty=parent.find('.p_qty').val();

            var total_price = product_qty;

          //  parent.find('.total_price_without_discount').val(total_price);
            parent.find('.total_price').val(total_price);


            total();


        });


                //calculate total value
            function total(){
                var qty = 0;
                var total = 0;
                var discount = 0;
                var total_with_discount = 0;

                $(".p_qty").each(function(){
                    var totalqtyid = $(this).val()-0;
                    qty +=totalqtyid;
                    $('#total_qty').html(qty);
                    // console.log(total);
                })
                $('#total_qty').html(qty);
                $('#grand_total_qty').val(qty);



                $(".total_price").each(function(){
                    var totalvalueid = $(this).val()-0;
                    total +=totalvalueid;
                    $('#total_value').html(total);
                    // console.log(total);
                })
                 $('#total_value').html(total);
                 $('#grand_total_value').val(total);




                $(".total_price_without_discount").each(function(){
                    var totalvalueid = $(this).val()-0;
                    total_with_discount +=totalvalueid;
                    $('#total_with_discount').html(total_with_discount);
                    // console.log(total);
                })
                $('#total_with_discount').html(total_with_discount);
                $('#total_payable').val(total_with_discount);
            }
*/

    });

$(document).ready(function() {


    $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
        $(this).closest(".select2-container").siblings('select:enabled').select2('open');
        });

        // steal focus during close - only capture once and stop propogation
        $('select.select2').on('select2:closing', function (e) {
        $(e.target).data("select2").$selection.one('focus focusin', function (e) {
            e.stopPropagation();
            });
        });


 });

 $(document).ready(function() {

    $("body" ).mousemove(function( event ){
        $.ajax({
            url : '{{url('marketing/order/item/invoiceNumber')}}',
            type: "GET",
            dataType: 'json',
            success : function(data){

              //console.log(data);
              if(data.length!=0)
              {
                   var dln = parseInt(data[0].id)+1001;
                  // console.log(dln);
                  document.getElementById("invoiceNo").innerHTML = dln;
                    $('#invoice').val(dln);
              }
              else{
                  document.getElementById("invoiceNo").innerHTML = 1001;
                  $('#invoice').val(1001);
              }

          }
        });
    });

    /*	$("#sbtn" ).click(function( event ){
        $.ajax({
            url : '{{url('marketing/order/item/invoiceNumber')}}',
            type: "GET",
            dataType: 'json',
            success : function(data){
              if(data.length!=0)
              {
                  var dln = parseInt(data[0].id)+1000;

                  document.getElementById("invoiceNo").innerHTML = dln;
                  $('#invoice').val(dln);
              }
              else{
                  document.getElementById("invoiceNo").innerHTML = 1001;
              }

          }
        });
    });
*/



/*
    $('#field').on('change','.products_id',function(){

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');

                var product_id=parent.find('.products_id').val();

                //alert(product_id);


                //console.log(vendor_id);

                    $.ajax({
                            url : '{{url('/get/product/data/')}}/'+product_id,
                            type: "GET",
                            dataType: 'json',
                            success : function(data){
                              console.log(data.specification);
                               document.getElementById("product_specin").val(data.specification);
                        }
                        });


         });
         */

});

</script>

@endpush
