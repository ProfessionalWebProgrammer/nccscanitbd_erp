@extends('layouts.purchase_deshboard')
<style media="screen">
    .form-check-input {
      position: absolute;
      margin-top: 0.1rem;
      margin-left: -1.8rem;
      width: 20px;
      height: 20px;
    </style>
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">
				<div class="row pt-2 pb-2">
                  	<div class="col-md-1"></div>
                      <div class="col-md-3 text-left">
                      	<a href="{{route('marketingQualityControlList')}}" class="btn btn-sm btn-success">Q.C List</a>
                    </div>
                </div>

        <!-- Main content -->
        <div class="content px-4 ">

            <form action="{{route('marketingOrder.cq.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="container" style="background: #ffffff; padding: 0px 40px; min-height:25vh">
                  <div class="text-center py-2">
                      <h3>Marketing Quality Control Create</h3>
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
                        {{-- <div class="col-md-3">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label text-right">Require Date </label>
                                <div class="col-sm-8">
                                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="require_date">
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Invoice :</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" required name="invoice"  >
                                        <option value="">Select Invoice</option>
                                        @foreach ($marketingOrderInvoice as $data)
                                            <option style="color:#000;font-weight:600;" value="{{ $data->invoice }}">
                                                {{ $data->invoice }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-12">
                          <div class="row pt-2">
                          <div class="col-md-2 text-right">
                               <div class="form-check h5">
                                   <input class="form-check-input" type="radio"  name="receive_ststus" id="s1" value="1" >
                                     <label class="form-check-label text-right ml-2 mt-1" for="s1">Receive </label>
                                  </div>
                           </div>
                           <div class="col-md-2">
                               <div class="form-group row">
                                 <label for="qty" class="col-sm-4 col-form-label text-right">Quantity </label>
                                 <div class="col-sm-8">
                                         <input type="text"  class="form-control"  name="qtyReceive">
                                 </div>
                               </div>
                           </div>
                           <div class="col-md-2 text-right">
                               <div class="form-check h5">
                                   <input class="form-check-input" type="radio"   name="receive_ststus" id="s2" value="2" >
                                     <label class="form-check-label text-right ml-2 mt-1" for="s2">Not Receive </label>
                                   </div>
                           </div>
                           <div class="col-md-2">
                               <div class="form-group row">
                                 <label for="qty" class="col-sm-4 col-form-label text-right">Quantity </label>
                                 <div class="col-sm-8">
                                         <input type="text"  class="form-control"  name="qtyNot">
                                 </div>
                               </div>
                           </div>
                           <div class="col-md-2 text-right">
                               <div class="form-check h5">
                                   <input class="form-check-input" type="radio"  name="receive_ststus" id="s3" value="3" >
                                     <label class="form-check-label text-right ml-2 mt-1" for="s3">Full Receive </label>
                                   </div>
                           </div>
                           <div class="col-md-2">
                               <div class="form-group row">
                                 <label for="qty" class="col-sm-4 col-form-label text-right">Quantity </label>
                                 <div class="col-sm-8">
                                         <input type="text"  class="form-control"  name="qtyFull">
                                 </div>
                               </div>
                           </div>
                            <div class="col-md-6">

                            </div>
                        </div>
                    </div>

                          <div class="col-md-12">
                            <div class="form-group row">
                              <label class="col-sm-1 col-form-label ">Note: </label>
                              <input type="text" class="form-control specification col-sm-11" id="product_specin" name="note" placeholder="Note" >
                          </div>
                          </div>
                          </div>


                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3">
                                 <button type="submit" class="btn btn-primary custom-btn-sbms-submit" style="width: 100%"> Submit </button>
                         </div>
                        <div class="col-md-4 mt-3">

                        </div>
                    </div>
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
                '';

          $(this).parents('.fieldGroup:last').after(fieldHTML);

         selected();
          $('.select2').select2({
            theme: 'bootstrap4'
            })

        });


        //remove fields group
        $("body").on("click", ".remove", function() {
            $(this).parents(".fieldGroup").remove();
            total();
            x = x-1;
            //console.log(x);

        });

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

              console.log(data);
              if(data.length!=0)
              {
                   var dln = parseInt(data[0].id)+1000;
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

});

</script>

@endpush
