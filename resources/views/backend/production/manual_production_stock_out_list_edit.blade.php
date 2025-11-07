@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">
				<div class="row pt-2 pb-2 ml-3">
                      <div class="col-md-4 text-left ml-5">
                      	<a href="{{route('production.stock.out.list')}}" class="btn btn-sm btn-success">Production List Edit</a>
                    </div>
                </div>
      
        <!-- Main content -->
        <div class="content px-4 ">

            <form action="{{route('manual.production.stock.out.update')}}" method="post">
                @csrf
                <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                  <div class="row">
                      <div class="col-md-12 text-center pt-3">
                          <h3 class="text-uppercase">Production Stock Out</h3>
                          <hr width="30%" style="background: #003c3f;">
                      </div>
                  </div>
                    <div class="row pt-4">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label">Date : </label>
                                <input type="date" class="form-control" name="date" value="{{$data->date}}">
                            </div>
                        </div>
                      @php
                      $date1 = strtotime($data->date);
                      $date2 = strtotime($data->expire_date);
                      $diff = $date2 - $date1;
                      $days = floor($diff / (60 * 60 * 24));
                      @endphp 
                       <div class="col-md-1">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label">Expire Day : </label>
                                <input type="number" class="form-control" name="expire_date" value="{{$days}}">
                                <input type="hidden" name="invoice" value="{{$invoice}}">
                            </div>
                        </div>

                       <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label" >Referance/Narration : </label>
                                <input type="text" class="form-control" name="referance" value=""{{$data->referance}}>
                            </div>
                        </div>

                         {{-- <div class="col-md-2">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label" required>Bach No : <span style="color:red;" title="Bach No Must be Number and Unique">*</span> </label>
                                <input type="number" class="form-control" name="batch" placeholder="123456" required>  <span style="color:red; font-size:11px;">Bach No must be Unique</span>
                            </div>
                        </div> --}}

                         <div class="col-md-3">
                            <div class="form-group">
                                    <label for="inputEmail3" class="col-form-label">Production Factory : </label>
                                    <select name="production_factory_id"  class="form-control select2" >
                                        <option value="">== Select Factory ==</option>
                                        @foreach ($pfactory as $item)
                                            <option value="{{ $item->id }}" @if($data->production_factory_id == $item->id) selected  @else  @endif>{{ $item->factory_name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                      </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label">Store/Warehouse : </label>
                                <select name="wirehouse_id"  class="form-control select2" required>
                                    <option value="">== Select Store ==</option>
                                    @foreach ($stores as $item)
                                        <option value="{{$item->id}}" @if($data->factory_id == $item->id) selected  @else  @endif >{{ $item->factory_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                      </div>
                  <h5 class="mt-3 text-uppercase">Finish Good Stock Out</h5>
                    <hr class="bg-light mt-0 pt-0">
                    {{-- Production Multiple add button code start from here! --}}
                  	<div class="row">
                        <div id="field_finishGood" class="col-md-12">
                            <div class="row fieldGroup rowname mb-1">
                                <div class="col-md-7">
                                  <div class="row">
                                        <div class="col-md-10">
                                          <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="finish_goods_id" class="col-form-label">Finish Goods Name : </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fg_qty" class="col-form-label" required>Quantity (Bag):  </label>
                                                </div>
                                            </div>
                                          </div>
                                         </div>
                                    	<div class="col-md-2">
                                          <label for="">Action :</label>
                                      	</div>
                        				</div>    
                  					</div>
                              	<div class="col-md-5">
                              </div>
                        	</div>
                          {{-- Multiple Start  --}}
                          @foreach($fGoods as $val)
                          <div class="row fieldGroup rowname mb-2">
                                <div class="col-md-7">
                                  <div class="row">
                                    <input type="hidden" name="fgstock_id[]" value="{{$val->fgId}}">
                                        <div class="col-md-10">
                                          <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    
                                                    <select name="finish_goods_id[]" class="form-control select2 finish_goods_id" id="finish_goods_id" >
                                                        <option value="">== Select Store ==</option>
                                                        @foreach ($finishedgoods as $item)
                                                            <option value="{{ $item->id }}" @if($val->id == $item->id) selected  @else  @endif >{{ $item->product_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    
                                                    <input type="text" class="form-control" name="fg_qty[]" id="fg_qty" value="{{$val->qty}}">
                                                </div>
                                            </div>
                                          </div>
                                         </div>
                                    	<div class="col-md-2">
                                          
                                          <a href="javascript:void(0)" style="margin-top: 3px;"
                                                class="btn custom-btn-sbms-add btn-sm addMoreFG"><i
                                                    class="fas fa-plus-circle"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove removeFG"
                                                style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>
                                      	</div>
                        				</div>    
                  					</div>
                              	<div class="col-md-5">
                              </div>
                        	</div>
                          @endforeach
                          {{-- Multiple End --}}
                      	</div>
                      </div>
                  
                    <h5 class="mt-3 text-uppercase">Production Stock Out</h5>
                    <hr class="bg-light mt-0 pt-0">
                    {{-- Multiple add button code start from here! --}}
                    <div class="row mt-3">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname mb-3">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">Product Name:</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Quantity (kg):</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Stock Balance:</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Remaining Stock Balance:</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label for="">Action :</label><br>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>
                            </div>
                          @php 
                          $totalQty = 0; 
                          @endphp 
                          @foreach($rowProducts as $val)
                          @php 
                          $totalQty += $val->qty;
                          @endphp 
                          <div class="row fieldGroup rowname mb-3">
                                <div class="col-md-12">
                                 
                                    <div class="row">
                                      <input type="hidden" name="rmstockOut_id[]" value="{{$val->rmId}}">
                                        <div class="col-md-11">
                                            <div class="row">
                                              
                                                <div class="col-md-4">
                                                    <select class="form-control select2 product_id" name="product_id[]"
                                                        data-live-search-style="startsWith" required>
                                                        <option value=" " selectedS>Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option style="color:#000;font-weight:600;"
                                                                value="{{ $product->id }}" @if($val->id == $product->id) selected  @else  @endif >{{ $product->product_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                   
                                                   <input type="text" class="form-control p_qty" name="p_qty[]" value="{{$val->qty}}">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" readonly class="form-control stock_value" name="stock[]"
                                                        placeholder="Stock">
                                                </div>
                                                <div class="col-md-3">
                                                     <input type="text" readonly class="form-control  remaning" name="remaning[]"
                                                        placeholder="Remaining Stock">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                           <a href="javascript:void(0)" style="margin-top: 3px;"
                                                class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                    class="fas fa-plus-circle"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"
                                                style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>

                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>
                            </div>
							@endforeach 
                        </div>
                    </div>
                  
                    {{-- multiple add end on here --}}
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6  mt-5">
                            <table class="table  border table-sm">
                                <thead>

                                </thead>
                                <tbody>


                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold">
                                        <td>Total Qty (kg):</td>
                                        <td> <span id="total_qty">{{$totalQty}}</span></td>
                                        <input type="hidden" class="form-control total_qty"
                                            name="total_qty">
                                    </tr>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3">
                            <button type="submit" id="customBtn" class="btn custom-btn-sbms-submit" style="width: 100%"> Update Stock Out
                            </button>
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

            var x = 1
            //add more fields group
            $("#field").on("click", ".addMore", function() {
                x = x + 1;
                var fieldHTML =
                    '<div class="row fieldGroup rowname mb-3"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-4"> <select class="form-control select2 product_id" name="product_id[]" data-live-search-style="startsWith" required> <option value=" " selectedS>Select Product</option> @foreach ($products as $product) <option style="color:#000;font-weight:600;" value="{{ $product->id }}">{{ $product->product_name }}</option> @endforeach </select> </div><div class="col-md-2"> <input type="hidden" name="rmstockOut_id[]" value=" "> <input type="text" class="form-control p_qty" name="p_qty[]" placeholder="Quantity"> </div><div class="col-md-3"> <input type="text" class="form-control stock_value" readonly name="stock[]" placeholder="Stock"> </div><div class="col-md-3"> <input type="text" class="form-control remaning" name="remaning[]" readonly placeholder="Remaining Stock"> </div></div></div><div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div><div class="col-md-2"></div></div></div></div>';

                $(this).parents('.fieldGroup:last').after(fieldHTML);
                $('.select2').select2({
                    theme: 'bootstrap4'
                })

            });


            //remove fields group
            $("#field").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
                total();
                x = x - 1;
            });

          
          /* Finished Goods multiple add */
          $("#field_finishGood").on("click", ".addMoreFG", function() {
                var fieldHTML =
                    '<div class="row fieldGroup rowname mb-2"> <div class="col-md-7"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-6"> <div class="form-group"> <select name="finish_goods_id[]" class="form-control select2 finish_goods_id" id="finish_goods_id" required> <option value="">== Select Store ==</option> @foreach ($finishedgoods as $item) <option value="{{ $item->id }}">{{ $item->product_name }}</option> @endforeach </select> </div> </div> <div class="col-md-6"> <div class="form-group"> <input type="hidden" name="fgstock_id[]" value="">  <input type="text" class="form-control" name="fg_qty[]" id="fg_qty"> </div> </div> </div> </div> <div class="col-md-2"><a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMoreFG"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove removeFG" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> <div class="col-md-5"> </div> </div>';
                $(this).parents('.fieldGroup:last').after(fieldHTML);
                $('.select2').select2({
                    theme: 'bootstrap4'
                })

            });


            //remove fields group
            $("#field_finishGood").on("click", ".removeFG", function() {
                $(this).parents(".fieldGroup").remove();
            });

          /* End */

          
           $('#field_finishGood').on('change', '.finish_goods_id', function() {
          	var current_value = $(this).val();
            const btn = document.getElementById("customBtn");
                    $(this).attr('value',current_value);
                    if ($('.finish_goods_id[value="' + current_value + '"]').not($(this)).length > 0 || current_value.length == 0 ) {
                      $(this).focus();
                        alert('Please select another Item');
                      btn.style.display = 'none';
                    } else {
                    	 btn.style.display = "";
                    }
          });
          
            $('#field').on('change', '.product_id', function() {

                    // $('.totalvalueid').attr("value", "0");
                    var parent = $(this).closest('.fieldGroup');

                    var product_id = parent.find('.product_id').val();
					const btn = document.getElementById("customBtn");
                    var current_value = $(this).val();
                    $(this).attr('value',current_value);
                    if ($('.product_id[value="' + current_value + '"]').not($(this)).length > 0 || current_value.length == 0 ) {
                      $(this).focus();
                        alert('Please select another Item');
                      btn.style.display = 'none';
                    } else {
                    	 btn.style.display = "";
                    }
                    //console.log(product_id);
                    $.ajax({
                        url: '{{ url('/stock/product/') }}/' + product_id,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);

                            var pcost= parent.find('.p_qty').val();
                            parent.find('.stock_value').val(data);
                            parent.find('.remaning').val(data-pcost);
                        }
                    });
                    total();
                    })

                    $('#field').on('input', '.p_qty', function() {

                        // $('.totalvalueid').attr("value", "0");
                        var parent = $(this).closest('.fieldGroup');
                        var p_qty = parent.find('.p_qty').val();
                        var stock = parent.find('.stock_value').val();

                    parent.find('.remaning').val(stock-p_qty);
                    total();

                    })
            //calculate total value
            function total() {
                var qty = 0;
                var total = 0;
                var discount = 0;
                var total_with_discount = 0;

                $(".p_qty").each(function() {
                    var totalqtyid = $(this).val() - 0;
                    qty += totalqtyid;
                    $('#total_qty').html(qty);
                    // console.log(total);
                })
                $('#total_qty').html(qty);
                $('.total_qty').val(qty);
            }



         /*   $('select[name="finish_goods_id"]').on('change',function() {
                    var fg_id = $(this).val();
                     console.log(fg_id);

                    $.ajax({
                        url : '{{url('get/production/fg/set/')}}/'+fg_id,
                        type:"GET",
                        dataType: 'json',
                        success : function(data) {
                            // console.log('hello');

                          if(data != ''){

                             $.each(data , function(index, val) {

                                 var fieldHTML ='<div class="row fieldGroup rowname mb-3"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-4"> <select class="form-control select2 product_id" name="product_id[]" data-live-search-style="startsWith" required>  <option value="'+val.rm_id+'" selected >'+val.product_name+'</option> @foreach ($products as $product) <option style="color:#000;font-weight:600;" value="{{ $product->id }}">{{ $product->product_name }}</option> @endforeach </select> </div><div class="col-md-2"> <input type="hidden" name="" value="1" > <input type="text" class="form-control p_qty" value="'+val.rm_qty+'" name="p_qty[]" placeholder="Quantity"> </div><div class="col-md-3"> <input type="text" class="form-control stock_value" readonly name="stock[]" placeholder="Stock"> </div><div class="col-md-3"> <input type="text" class="form-control remaning" name="remaning[]" readonly placeholder="Remaining Stock"> </div></div></div><div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div><div class="col-md-2"></div></div></div></div>';
                          //console.log(fieldHTML);
                                $('.fieldGroup:first').after(fieldHTML);


                                $('.select2').select2({
                                    theme: 'bootstrap4'
                                })

                          	 });
                          }


                            },
                        });
             });


		*/

        });

        $(document).ready(function() {
            $(document).on('focus', '.select2-selection.select2-selection--single', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            });

            // steal focus during close - only capture once and stop propogation
            $('select.select2').on('select2:closing', function(e) {
                $(e.target).data("select2").$selection.one('focus focusin', function(e) {
                    e.stopPropagation();
                });
            });
        });

        $(document).ready(function() {

            $('select[name="product_id"]').on('change',function() {
                    var pro_id = $(this).val();
                    var parent = $(this).closest('.fieldGroup');
                    // console.log(pro_id);

                    $.ajax({
                        url : '/stock/product/'+pro_id,
                        type:"GET",
                        dataType: 'json',
                        success : function(data) {
                            // console.log('hello');
                            // console.log(data);
                            document.getElementById("stock").value = data;
                            },
                        });
                    });


            $("#sbtn").click(function(event) {
                $.ajax({
                    url: '{{ url('sales/salesNumber') }}',
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.length != 0) {
                            var dln = parseInt(data[0].invoice_no) + 1;
                            document.getElementById("invoiceNo").innerHTML = dln;
                        } else {
                            document.getElementById("invoiceNo").innerHTML = 100001;
                        }

                    }
                });
            });
        });
    </script>
@endpush
