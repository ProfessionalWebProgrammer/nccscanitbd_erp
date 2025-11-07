@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('sales.return.store')}}" method="post">
                @csrf
                <div class="container" style="background:#f5f5f5; padding:0px 40px; min-height:85vh">
                    <h3 class="text-center pt-3">Sales Return Create</h3>
                    <div class="row pt-4">
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Date : </label>
                                <div class="col-sm-9">
                                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="testdate">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Vendor Name :</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2"

                                        required name="dealer_id" id="dealer"
                                    >
                                        <option value="">Select Vandor</option>
                                        @foreach ($dealers as $dealer)
                                            <option style="color:#000;font-weight:600;" value="{{ $dealer->id }}">
                                                {{ $dealer->d_s_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Branch/Warehouse :</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2"

                                        name="warehouse_id" id="wirehouse" required>
                                        {{-- <option value="{{$wr_id}}">{{$wr_info}}</option> --}}
                                        <option value="">Select Warehouse</option>

                                        @foreach ($factoryes as $factorye)
                                            <option style="color:#000;font-weight:600;" value="{{ $factorye->id }}">
                                                {{ $factorye->factory_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Shiping : </label>
                                <div class="col-sm-8">
                                    <input type="Text" class="form-control" placeholder="Shiping">
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-md-2 text-right">
                            <div class="mb-3">
                                Invoice No: <span class="mt-4 font-weight-bold" id="invoiceNo"> </span>

                            </div>
                        </div>
                    </div>
                    {{-- Multiple add button code start from here! --}}
                    <div class="row mt-5">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-5">
                                                    <label for="">Product Name:</label>
                                                    <select class="form-control select2 products_id"
                                                        name="products_id[]"
                                                        data-live-search-style="startsWith" id="products_id" required>
                                                        <option value=" " selectedS>Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option style="color:#000;font-weight:600;"
                                                                value="{{ $product->id }}">{{ $product->product_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Price :</label>
                                                    <input type="text" class="form-control p_price" name="p_price[]" placeholder="Price">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Quantity :</label>
                                                    <input type="text" class="form-control p_qty" name="p_qty[]" placeholder="Quantity">
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="">Total :</label>
                                                    <input type="hidden"  class="form-control total_price"  name="total_price[]" placeholder="total">
                                                    <input type="text" readonly class="form-control total_price_without_discount"  name="total_price_without_discount[]">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Action :</label> <br>
                                            <a href="javascript:void(0)" style="margin-top: 3px;"
                                                class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                    class="fas fa-plus-circle"></i></a>
                                            <a href="javascript:void(0)"  class="btn btn-sm custom-btn-sbms-remove remove"
                                                style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>

                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- multiple add end on here --}}
                    <div class="row">
                        <div class="col-md-6">
                          <label for="naration" class="mt-5">Naration</label>
                          <input type="text" class="form-control" name="narration" value="">
                        </div>
                        <div class="col-md-4  mt-5">
                            <table class="table  border table-sm">
                                <thead>
                                    {{-- <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Discount</th>
                                        <th>Free</th>
                                        <th>Total</th>
                                    </tr> --}}
                                </thead>
                                <tbody>

                                    {{-- <tr>
                                        <td>2.</td>
                                        <td>Br</td>
                                        <td>1200</td>
                                        <td>200</td>
                                        <td>5%</td>
                                        <td>5</td>
                                        <td>24000</td>
                                    </tr> --}}
                                </tbody>
                                <tfoot>
                                    <tr class="text-dark font-weight-bold">
                                        <td >Total Qty :</td>
                                        <td> <span id="total_qty"></span></td>
                                        <input type="hidden" class="form-control " id="grand_total_qty"  name="grand_total_qty">

                                    </tr>
                                    <tr class="text-dark font-weight-bold">
                                        <td >Total Price :</td>
                                        <td> <span id="total_value"></span></td>
                                        <input type="hidden" class="form-control " id="grand_total_value"  name="grand_total_value">

                                    </tr>

                                    <tr class="text-dark font-weight-bold">
                                        <td >Payable :</td>
                                        <td> <span id="total_with_discount"></td>
                                        <input type="hidden" class="form-control " id="total_payable"  name="total_payable">

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3">
                                 <button type="submit" class="btn btn-primary custom-btn-sbms-submit" style="width: 100%"> Return Confirm </button>
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
        $("body").on("click", ".addMore", function() {
            x = x+1;
            var fieldHTML =
                '<div class="row fieldGroup rowname  mt-2"> <div class="col-md-12"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-1"></div><div class="col-md-5"> <select class="form-control select2 products_id" id="select2'+x+'"   name="products_id[]" data-live-search-style="startsWith" id="" required> <option value=" " >Select Product</option> @foreach ($products as $product) <option style="color:#000;font-weight:600;" value="{{$product->id}}">{{$product->product_name}}</option> @endforeach </select> </div><div class="col-md-2"> <input type="text" class="form-control p_price" name="p_price[]" placeholder="Price"> </div><div class="col-md-2"> <input type="text" class="form-control p_qty" name="p_qty[]" placeholder="Quantity"> </div><div class="col-md-2"> <input type="hidden" readonly class="form-control total_price"  name="total_price[]" placeholder="total"><input type="text" class="form-control total_price_without_discount"  name="total_price_without_discount[]"> </div></div></div><div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a>  <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></div><div class="col-md-2"></div></div></div></div>';

          $(this).parents('.fieldGroup:last').after(fieldHTML);


          $('.select2').select2({
            theme: 'bootstrap4'
          });

        });

        //remove fields group
        $("body").on("click", ".remove", function() {
            $(this).parents(".fieldGroup").remove();
            total();
            x = x-1;
            console.log(x);

        });




        $('#field').on('input','.p_price, .p_qty',function(){

            var parent = $(this).closest('.fieldGroup');
            var product_price=parent.find('.p_price').val();

            var product_qty=parent.find('.p_qty').val();

            var total_price = product_price*product_qty;




            parent.find('.total_price_without_discount').val(total_price);
            parent.find('.total_price').val(total_price);


            total();


        });


        $('#field').on('change','.discount',function(){

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');

                var totalvalueid=parent.find('.total_price').val();


                var discont = parent.find('.discount').val();

                var total_discount = (totalvalueid/100)*discont;
                var total_price_without_discount = totalvalueid - total_discount;
                //console.log(total_price_without_discount);
                //console.log(totalvalueid);

                   parent.find('.total_price_without_discount').val(total_price_without_discount);




                parent.find('.total_price').val(totalvalueid);
                parent.find('.discount_amount').val(total_discount);

                //   parent.find('.totalvalueid').val(parseFloat(qt)* parseFloat(up));




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

                 $(".discount_amount").each(function(){
                    var totaldiscountid = $(this).val()-0;
                    discount +=totaldiscountid;
                    $('#total_discount').html(discount);
                    // console.log(total);
                })
                $('#total_discount').html(discount);
                $('#grand_total_discount').val(discount);


                $(".total_price_without_discount").each(function(){
                    var totalvalueid = $(this).val()-0;
                    total_with_discount +=totalvalueid;
                    $('#total_with_discount').html(total_with_discount);
                    // console.log(total);
                })
                $('#total_with_discount').html(total_with_discount);
                $('#total_payable').val(total_with_discount);
            }


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
            url : '{{url('sales/salesNumber')}}',
            type: "GET",
            dataType: 'json',
            success : function(data){

              // console.log(data.length!=0)
              if(data.length!=0)
              {
                   var dln = parseInt(data[0].invoice_no)+1;
                  // console.log(dln);
                  document.getElementById("invoiceNo").innerHTML = dln;
              }
              else{
                  document.getElementById("invoiceNo").innerHTML = 100001;
              }
          }
        });
    });

    	$("#sbtn" ).click(function( event ){
        $.ajax({
            url : '{{url('sales/salesNumber')}}',
            type: "GET",
            dataType: 'json',
            success : function(data){
              if(data.length!=0)
              {
                  var dln = parseInt(data[0].invoice_no)+1;
                  document.getElementById("invoiceNo").innerHTML = dln;
              }
              else{
                  document.getElementById("invoiceNo").innerHTML = 100001;
              }

          }
        });
    });





    $('#field').on('change','.products_id',function(){

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');

                var product_id=parent.find('.products_id').val();

                var vendor_id= $('#dealer').val();

                //console.log(vendor_id);

      			if(vendor_id == ''){
                  parent.find('.products_id').val("");
                  alert("Please Select Vendor First");
                }else{
                    $.ajax({
                            url : '{{url('/sales/product/returnVal/')}}/'+product_id+'/'+vendor_id,
                            type: "GET",
                            dataType: 'json',
                            success : function(data){
                               //  console.log(data);
                               if(data.return > 0){
                                // var product_price = parseInt(data.price);
                                 parent.find('.p_price').val(data.price);
                               } else {
                                 alert("Sorry! This Item has not sold yet now.");
                                 //alert(data.return);
                               }
                        }
                        });

                }


                // parent.find('.total_price').val(totalvalueid);
                // parent.find('.discount_amount').val(total_discount);

                //   parent.find('.totalvalueid').val(parseFloat(qt)* parseFloat(up));

         })


});


</script>

@endpush
