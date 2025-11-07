@extends('layouts.sales_dashboard')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass" >
        <!-- Main content -->
        <div class="content px-4 ">
          <div class="container-fluid" style="background: #ffffff;  min-height: 85vh;">
            <form action="{{route('sales.store')}}" method="post">
                @csrf
                    <div class="row pt-4">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Date : </label>
                                <div class="col-sm-9">
                                    <input type="date" value="{{ $date }}" class="form-control" name="testdate">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">P.R. Date</label>
                                <div class="col-sm-9">
                                    <input type="date"  class="form-control" name="payment_date">
                                </div>
                            </div>

                        </div>
                      
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Dealer Name :</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" style="border-radius: 12px !important;font-weight: 800;" required name="dealer_id" id="dealer">
                                        <option value="">Select Dealer</option>
                                        @foreach ($dealers as $dealer)
                                            <option style="color:#000;font-weight:600;" value="{{ $dealer->id }}">
                                                {{ $dealer->d_s_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" id="all_warehouse">
                                <label class="col-sm-4 col-form-label text-right">Branch/Warehouse :</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2"

                                        name="warehouse_id" id="wirehouse" required>
                                        {{-- <option value="{{$wr_id}}">{{$wr_info}}</option> --}}
                                        <option value="">Select Warehouse</option>

                                        @foreach ($factoryes as $factorye)
                                            <option style="color:#000;font-weight:600;" value="{{ $factorye->id }}" @if($wr_id == $factorye->id) selected @endif>
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
                        <div class="col-md-2 ">
                            <div class="mb-3">
                                Invoice No: <span class="mt-4 font-weight-bold" id="invoiceNo"> </span>

                            </div>
                          <div class="mb-3 pt-3">
                               Credit Limit: <span class="mt-4 font-weight-bold" id="creditlimit"> </span>
                             <input type="hidden" class="form-control " id="creditl"  >
                             <input type="hidden" class="form-control " id="dlrbalance"  >

                             <input type="hidden" class="form-control " id="clamount"  >

                            </div>
                        </div>
                    </div>
                    {{-- Multiple add button code start from here! --}}
                    <div class="row mt-5">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="row">

                                                <div class="col-md-3">
                                                  <label for="">Product Name:</label>
                                                    <select class="form-control select2 products_id" name="products_id[]"
                                                        data-live-search-style="startsWith" required>
                                                        <option value=" " selectedS>Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option style="color:#000;font-weight:600;"
                                                                value="{{ $product->id }}">{{ $product->product_name }} ({{$product->product_weight_unit}})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <!-- <input type="hidden" class="form-control productallid"  > -->

                                                </div>
                                              <div class="col-md-1"> <label for="">Stock :</label>
                                                <input type="text" class="form-control pstock" readonly tabIndex="-1">
                                              </div>
                                              <div class="col-md-1">
                                                    <label for="">Batch :</label>
                                                    <select name="batch_number[]" class="form-control select2 batchNo">
                                                        <option value=""> Batch No. </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Price :</label>
                                                    <input type="text" class="form-control p_price" name="p_price[]" placeholder="Price">
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="">Qty :</label>
                                                    <input type="text" class="form-control p_qty" name="p_qty[]" required placeholder="Quantity">
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="">Discount:</label>
                                                    <input type="text" class="form-control discount"  name="discount[]" placeholder="%">
                                                    <input type="hidden" class="form-control discount_amount"  name="discount_amount[]">
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="">Bonus :</label>
                                                    <input type="text" class="form-control bonus"  name="bonus[]" placeholder="">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Total :</label>
                                                    <input type="text" readonly tabIndex="-1" class="form-control total_price"  name="total_price[]" placeholder="total">
                                                    <!-- <input type="text" readonly    tabIndex="-1" class="form-control total_price_without_discount"  name="total_price_without_discount[]"> -->

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label for="">Action :</label> <br>
                                            <a href="javascript:void(0)" style="margin-top: 3px;"
                                                class="btn custom-btn-sbms-add btn-light btn-sm addMore"><i
                                                    class="fas fa-plus-circle"></i></a>
                                            <a href="javascript:void(0)"  class="btn btn-danger btn-sm custom-btn-sbms-remove remove"
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

                        </div>
                        <div class="col-md-6  mt-5">
                            <table class="table  border table-sm border-light">
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
                                <tfoot class="">
                                    <tr class="font-weight-bold">
                                        <td >Total Qty :</td>
                                        <td> <span id="total_qty"></span></td>
                                        <input type="hidden" class="form-control " id="grand_total_qty"  name="grand_total_qty">

                                    </tr>
                                    <tr class=" font-weight-bold">
                                        <td >Total Price :</td>
                                        <td> <span id="total_value"></span></td>
                                        <input type="hidden" class="form-control " id="grand_total_value"  name="grand_total_value">

                                    </tr>
                                   {{-- <tr class="font-weight-bold">
                                        <td >Discount :</td>
                                        <td> <span id="total_discount"></span></td>
                                        <input type="hidden" class="form-control " id="grand_total_discount"  name="grand_total_discount"> --}}

                                {{--    </tr>  --}}
                                    <tr class="font-weight-bold">
                                        <td >Payable :</td>
                                        <td> <span id="total_with_discount"></span></td>
                                        <input type="hidden" class="form-control " id="total_payable"  name="total_payable">

                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td >Remaining Credit Limite :</td>
                                        <td> <span id="rm_cl"></span></td>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3">
                             <button type="submit" class="btn custom-btn-sbms-submit btn-primary" id="showsubmit" style="width: 100%"> Sales Confirm </button>
                                 <button type="button" class="btn custom-btn-sbms-submit " id="hidesubmit" style="width: 100%;background:red;border: none;display:none" data-toggle="modal" data-target="#modal-default">
                                   Sales Confirm
                          		</button>
                      </div>
                        <div class="col-md-4 mt-3">

                        </div>
                    </div>

                <!-- /.container-fluid -->
            </form>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>

 <!-- /.Modal -->
<div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Sorry ! invoice can't generate, because your credit limit already exist.</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body row">

              <div class="col-md-6">
                <h5>Vendor Credit Limite </h5>
                <h5>Vendor Closing Balance </h5>
                <h5>Present Credit Limite </h5>
                <h5>Total Invoice Value </h5>
                <hr/>
                <h5>Invoice Need To Generate </h5>

                </div>
              <div class="col-md-6">
                <h5>: <span id="mcl"></span>/- BDT</h5>
                <h5>: <span id="mcb"></span>/- BDT</h5>
                <h5>: <span id="mfcl"></span>/- BDT</h5>
                <h5>: <span id="minv"></span>/- BDT</h5>
                <hr/>
                <h5>: <span id="mneed"></span>/- BDT</h5>

                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <p  ></p>
              <button type="button" class="btn btn-primary"data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>



 <!-- /.Modal -->
<div class="modal fade" id="stockend">
        <div class="modal-dialog">
          <div class="modal-content bg-danger" >
            <div class="modal-header">
              <h4 class="modal-title">Product Stock Out</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body ">

               <p>Sorry..! This Product Out Of Stock. </p>
            </div>
            <div class="modal-footer justify-content-between">
                <p  ></p>
              <button type="button" class="btn btn-primary"data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

 <!-- /.modal-Warning -->

 	<div class="modal fade" id="modal-warning">
        <div class="modal-dialog">
          <div class="modal-content bg-warning">
            <div class="modal-header">
              <h4 class="modal-title">Warning</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p id="warningmodaltext"></p>
            </div>
            <div class="modal-footer justify-content-between">
              <p  ></p>
              <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>

            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

@endsection


@push('end_js')


<script>
    $(document).ready(function() {

        $('#modal-default').on('show.bs.modal', function(event) {
           // console.log('hello test');

             var totalval =  $('#total_payable').val();
              var cl = $('#creditl').val();
			  var cb= $('#dlrbalance').val();
              var fcl= $('#clamount').val();


        		var need = Number(totalval)-Number(fcl);

         var modal = $(this)
            modal.find('.modal-body #mcl').html(cl);
            modal.find('.modal-body #mcb').html(cb);
            modal.find('.modal-body #mfcl').html(fcl);
            modal.find('.modal-body #minv').html(totalval);



            modal.find('.modal-body #mneed').html(need);


        })


        $('#dealer').select2('open');



        var x = 1
        //add more fields group
        $("body").on("click", ".addMore", function() {
            x = x+1;
            var fieldHTML =
                '<div class="row fieldGroup rowname mt-2"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-3"> <select class="form-control select2 products_id" name="products_id[]" data-live-search-style="startsWith" required> <option value=" " selectedS>Select Product</option> @foreach ($products as $product) <option style="color:#000;font-weight:600;" value="{{$product->id}}">{{$product->product_name}}({{$product->product_weight_unit}}) </option> @endforeach </select> <input type="hidden" class="form-control productallid" > </div><div class="col-md-1"> <input type="text" class="form-control pstock" readonly tabIndex="-1"> </div><div class="col-md-1"> <select name="batch_number[]" class="form-control select2 batchNo"> <option value=""> Select Lot </option> </select> </div><div class="col-md-2"> <input type="text" class="form-control p_price" name="p_price[]" placeholder="Price"> </div><div class="col-md-1"> <input type="text" class="form-control p_qty" name="p_qty[]" required placeholder="Quantity"> </div><div class="col-md-1"> <input type="text" class="form-control discount" name="discount[]" placeholder="%"> <input type="hidden" class="form-control discount_amount" name="discount_amount[]"> </div><div class="col-md-1"> <input type="text" class="form-control bonus" name="bonus[]" placeholder=""> </div><div class="col-md-2"> <input type="text" readonly tabIndex="-1" class="form-control total_price" name="total_price[]" placeholder="total"></div></div></div><div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-light btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-danger btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div><div class="col-md-2"></div></div></div></div>';

          $(this).parents('.fieldGroup:last').after(fieldHTML);


          $('.select2').select2({
            theme: 'bootstrap4'
            })

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


            //parent.find('.total_price_without_discount').val(total_price);
            parent.find('.total_price').val(total_price);
     
          				var stock = parent.find('.pstock').val();
                               if(Number(stock) < Number(product_qty)){

                                 $('#stockend').modal('show');
                                  // parent.find('.products_id').val("");
                                  parent.find('.p_qty').val("");
                                  parent.find('.total_price').val("");
                                //  parent.find('.total_price_without_discount').val("");

                                } else {

                                }
            total();

        });

/*
        $('#field').on('input','.discount',function(){

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

*/


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

                 /*
                 $(".discount_amount").each(function(){
                    var totaldiscountid = $(this).val()-0;
                    discount +=totaldiscountid;
                    $('#total_discount').html(discount);
                    // console.log(total);
                })
                $('#total_discount').html(discount);
                $('#grand_total_discount').val(discount);
                */

                $(".total_price").each(function(){
                    var totalvalueid = $(this).val()-0;
                    total_with_discount +=totalvalueid;
                    $('#total_with_discount').html(total_with_discount);
                    // console.log(total);
                })
                $('#total_with_discount').html(total_with_discount);
                $('#total_payable').val(total_with_discount);

              creditlimitcalculation();
            }




       $('#dealer').on('change',function(){

                // $('.totalvalueid').attr("value", "0");

             //   changewarehouse();

              creaditlimitget();
				checkwarehouse();
         })

       setInterval(() => {
            creaditlimitget();

        }, 1000);

      // this function not working
   function changewarehouse(){
   var did =   $('#dealer').val()
           $.ajax({
                url : '{{url('/get/warehous/by/vendor/')}}/'+did,
                type: "GET",
                dataType: 'json',
                success : function(data){

                  var warehousedata = '<option value="">Select Warehouse</option>';
                  $(data).each(function(i, obj) {
                   warehousedata += '<option value="'+obj.warehouse_id+'">'+obj.factory_name+'</option>';
                  });
                  if(warehousedata == ''){
                    $('#wirehouse').val("");
                  }else{
                   	$('#wirehouse').html(warehousedata);
                  }

                 var wid = $('#wirehouse').val();
                  //console.log(wid);

              }
            });


      $('#wirehouse').select2({
            theme: 'bootstrap4'
            });


   //console.log(did);
   }


      function creaditlimitget(){
       var vendor_id = $('#dealer').val();


            //   console.log(vendor_id);
        if(vendor_id != ''){
      				  $.ajax({
                       //     url : 'https://sbms2.rrpagrofarms.net/sales/get/vendor/creditlimit/'+vendor_id,
                            url : '{{url('/sales/get/vendor/creditlimit/')}}/'+vendor_id,

                            type: "GET",
                            dataType: 'json',
                            success : function(data){
                              var cl = Number(data.dlr_police_station)+Number(data.ex_credit_limit);
                              var opb = data.dlr_base;
                              var cb = Number(opb) + ( Number(data.debit_a)- Number(data.credit_a));

                              var fcb = Number(cl)-Number(cb);

                         //  console.log(data);

                              $('#creditlimit').html(fcb.toFixed(2));

                              $('#creditl').val(cl);
                               $('#dlrbalance').val(cb);
                              $('#clamount').val(fcb.toFixed(2));
                        }
                        });
        }
      }


       $('#wirehouse').on('change',function(){
    		checkwarehouse();
        })


      function checkwarehouse(){
      var warehouse_id =   $('#wirehouse').val();

     	var vendor_id= $('#dealer').val();
     //alert(thisval);

        if(vendor_id != '' && warehouse_id != ''){
     			$.ajax({
                            url : '{{url('/sales/warehouse/check/')}}/'+vendor_id+'/'+warehouse_id,
                            type: "GET",
                            dataType: 'json',
                            success : function(data){

                              if(data == 0){
                                var alr = "This depo is not in the contact list";
                                $('#warningmodaltext').html(alr);
                               $('#modal-warning').modal('show');

                              }
                        }
                        });

        }


      }


        function creditlimitcalculation(){

               var totalval =  $('#total_payable').val();
              var cl = $('#creditl').val();
			  var cb= $('#dlrbalance').val();
              var fcl= $('#clamount').val();

           					//console.log(cl);
                            //    console.log(cb);
                            //   console.log(fcl);
                            //   console.log(totalval);
               $('#rm_cl').html(Number(fcl)-Number(totalval));

          		if (Number(totalval)>=Number(fcl)) {

                    $("#showsubmit").css("display","none");
                    $("#hidesubmit").css("display","");
                   }else{
                    $("#showsubmit").css("display","");
                    $("#hidesubmit").css("display","none");
                   }

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
                var warehouse_id= $('#wirehouse').val();
                //console.log(vendor_id);

      			if(vendor_id == '' || warehouse_id == '' ){
                  parent.find('.products_id').val("");
                  alert("Please Select Vendor Aan Warehouse First");
                }else{
                  $.ajax({
                          url : '{{url('/sales/product/price/')}}/'+product_id+'/'+vendor_id,
                          type: "GET",
                          dataType: 'json',
                          success : function(data){
                             //var product_price = parseInt(data.price);
                             parent.find('.p_price').val(data.price);

                      }
                    });

                    $.ajax({
                              url : '{{url('/sales/product/stock/')}}/'+product_id+'/'+warehouse_id,
                              type: "GET",
                              dataType: 'json',
                              success : function(data){
                               //   console.log(data);
                                var stock = data.stock;

                                parent.find('.pstock').val(stock);

                                 if(stock <= 0 && data.wirehouse_limite == 1){
                                  //  parent.find('.products_id').val("");

                                   $('#stockend').modal('show');
                                    parent.find('.p_qty').val("");

                                  }else{

                                  }

                          }
                          });
                  /*
                  $('.productallid').each(function(i, obj) {
                      var api = $( obj ).val();

                    if(api == product_id){

						var alr = "This Product Already Selected";
                                $('#warningmodaltext').html(alr);
     							$('#modal-warning').modal('show');


                      console.log( api );
                  	}
                  });


                  parent.find('.productallid').val(product_id);

                    $.ajax({
                            url : '{{url('/sales/product/price/')}}/'+product_id+'/'+vendor_id,
                            type: "GET",
                            dataType: 'json',
                            success : function(data){
                              //  console.log(data);
                               var product_price = parseInt(data.price);

                               parent.find('.p_price').val(product_price);

                              var unit = data.unit;

                              //console.log(unit);
                              /*
                              if(unit == 'KG'){
                               	parent.find('.discount').attr('readonly', true);
                           		parent.find('.bonus').attr('readonly', true);

                                	parent.find('.discount').attr( 'tabIndex','-1')
                           		parent.find('.bonus').attr( 'tabIndex','-1')



                              }else{
                              parent.find('.discount').attr('readonly', false);
                           		parent.find('.bonus').attr('readonly', false);
                              }

                              */
                    /*
                        }
                      }); */

                  //batch no. ajax
                  /* $.ajax({
                        url: '{{ url('get/batch/numbers/by/') }}/'+warehouse_id,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {
                          var bdata = "<option value=''>Select Batch</option>";

                          $.each(data, function(data, v) {
                              bdata += "<option value='"+v.batch_id+"'>"+v.batch_id+"</option>";
                          });
                            parent.find('.batchNo').html(bdata);

                        }
                      }); */

                }

         })


});

</script>



@endpush
