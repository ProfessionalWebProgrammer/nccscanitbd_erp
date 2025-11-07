@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">


        <!-- Main content -->
        <div class="content px-4 ">
            
            <form action="{{route('row.materials.issues.store')}}" method="post">
                @csrf
                <div class="container" style="background: #ffffff; padding: 0px 40px; min-height:85vh">
                  <div class="text-center py-2"> 
                      <h3>Stock Out Create</h3>
                      <hr>
                  </div>
                    <div class="row pt-3">
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Date : </label>
                                <div class="col-sm-9">
                                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                             <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right" for="dealer">Supplier Name :</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2"   name="dealer_id" id="dealer" >
                                        <option value="">Select Supplier</option>
                                        @foreach ($dealers as $dealer)
                                            <option style="color:#000;font-weight:600;" value="{{ $dealer->id }}">
                                                {{ $dealer->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                          </div>
                          <div class="col-md-3">
                             <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right" for="wirehouse">Factory :</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2"   name="warehouse_id" id="wirehouse" >
                                       
                                        <option value="">Select Factory</option>

                                        @foreach ($factoryes as $factorye)
                                            <option style="color:#000;font-weight:600;" value="{{ $factorye->id }}">
                                                {{ $factorye->factory_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                           
                        </div>
                        
                      
                          <div class="col-md-3">
                                  <div class="form-group row">
                                      <label class=" col-form-label col-md-4 text-right">Issued By:</label>
                                    	<input type="text" name="issued_by" class="form-control col-md-8" placeholder="Issued By">
                                   </div>
                               </div> 
                    </div>
                    {{-- Multiple add button code start from here! --}}
                    <div class="row ">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname">
                                <div class="col-md-10 m-auto">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-5">
                                                    <label for="">Product Name:</label>
                                                    <select class="form-control select2 orderProduct"  
                                                        name="products_id[]"
                                                        data-live-search-style="startsWith" id="products_id" required>
                                                        <option value=" " selectedS>Select Product</option>
                                                        @foreach ($data as $product)
                                                            <option style="color:#000;font-weight:600;"
                                                                value="{{ $product->id }}">{{ $product->product_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Unit :</label>
                                                    <input type="text" class="form-control orderUnit" name="unit[]" placeholder="Unit">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Quantity :</label>
                                                    <input type="text" class="form-control p_qty" name="qty[]" placeholder="Quantity">
                                                </div>
                                               
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Action :</label> </br>
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
                <div class="col-md-6 mt-4">
                        	<div class="form-group row">
                              <label class="col-sm-2 col-form-label text-primary text-right"> Note: </label>
                              <div class="col-sm-10">
                                <textarea name="note" rows="2" cols="60%"></textarea>
                              </div>
                        	</div>
                          </div>
                </div>
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-4  mt-5">
                            <table class="table  border table-sm">
                                <thead>
                                    
                                </thead>
                                <tbody>
                                
                                    
                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold">
                                        <td >Total Qty :</td>
                                        <td> <span id="total_qty"></span></td>
                                        <input type="hidden" class="form-control " id="grand_total_qty"  name="grand_total_qty">

                                    </tr>
                                    <input type="hidden" class="form-control " id="grand_total_value"  name="grand_total_value">
                                   
                                </tfoot>
                            </table>
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
                '<div class="row fieldGroup rowname mt-3"> <div class="col-md-10 m-auto"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-1"></div> <div class="col-md-5"> <select class="form-control select2 orderProduct" name="products_id[]" data-live-search-style="startsWith" id="products_id" required> <option value=" " selectedS>Select Product</option> @foreach ($data as $product) <option style="color:#000;font-weight:600;" value="{{ $product->id }}">{{ $product->product_name }} </option> @endforeach </select> </div> <div class="col-md-3"> <input type="text" class="form-control orderUnit" name="unit[]" placeholder="Unit"> </div> <div class="col-md-3"> <input type="text" class="form-control p_qty" name="qty[]" placeholder="Quantity"> </div> </div> </div> <div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> <div class="col-md-2"></div> </div> </div> </div>';
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
            //console.log(x);
            
        });


      
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
                          parent.find('.orderUnit').val(data.unit);
                        });
                    }
                });

            })


      

        $('#field').on('input','.p_qty',function(){

            var parent = $(this).closest('.fieldGroup');
           
            
            var product_qty=parent.find('.p_qty').val();
            
            var total_price = product_qty;
            
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




/*
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
                            url : '{{url('/sales/product/price/')}}/'+product_id+'/'+vendor_id,
                            type: "GET",
                            dataType: 'json',
                            success : function(data){
                                //console.log(data);
                               //var product_price = parseInt(data.price);

                               parent.find('.p_price').val(data.price);
                        }
                        });
                
                }




                // parent.find('.total_price').val(totalvalueid);
                // parent.find('.discount_amount').val(total_discount);

                //   parent.find('.totalvalueid').val(parseFloat(qt)* parseFloat(up));

         }); */


}); 




  
</script>


    
@endpush
