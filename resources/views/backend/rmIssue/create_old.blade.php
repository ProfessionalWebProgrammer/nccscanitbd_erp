@extends('layouts.purchase_deshboard')

@section('content')
<style media="screen">
    .form-check-input {
      position: absolute;
      margin-top: 0.3rem;
      margin-left: -1.8rem;
      width: 20px;
      height: 20px;
    </style>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <form class="floating-labels m-t-40" action="{{route('row.materials.issues.store')}}" method="POST">
            @csrf

        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="pt-3 text-center">
                    <h4 class="font-weight-bolder text-uppercase text-danger">Stock Out Issue</h4>
                    <hr width="33%">
                </div>
              <div class="row pt-3">
                      <div class="col-md-12">
                          <div class="row mb-3">
                              <div class="col-md-3">
                                  <div class="form-group row">
                                      <label class=" col-form-label col-md-4">Date:</label>
                                       <input type="date" name="date" value="{{ date('Y-m-d') }}" class="form-control col-md-8">
                                   </div>
                               </div>
                           <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Party Name :</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" style="border-radius: 12px !important;font-weight: 800;"  name="dealer_id" id="dealer">
                                        <option value="">Select Party</option>
                                        @foreach ($dealers as $dealer)
                                            <option style="color:#000;font-weight:600;" value="{{ $dealer->id }}">
                                                {{ $dealer->d_s_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                           </div>
                            <div class="col-md-3">
                               <div class="form-group row" id="all_warehouse">
                                <label class="col-sm-3 col-form-label text-right">Storage :</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2"

                                        name="warehouse_id" id="wirehouse" >
                                        
                                        <option value="">Select Storage</option>

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
                                <label for="rack" class="col-sm-4 col-form-label">Select Rack</label>
                                <div class="col-sm-8">
                                   
                                   <select class="form-control select2" style="border-radius: 12px !important;font-weight: 800;"  name="rack" id="rack">
                                        <option value="">Select Rack</option>
                                            <option style="color:#000;font-weight:600;" value="1"> Center 01 </option>
                                      		<option style="color:#000;font-weight:600;" value="2"> North 01 </option>
                                            <option style="color:#000;font-weight:600;" value="3"> North East 01 </option>
                                            <option style="color:#000;font-weight:600;" value="4"> North West 01 </option>
                                            <option style="color:#000;font-weight:600;" value="5"> South 01 </option>
                                     		<option style="color:#000;font-weight:600;" value="6"> South East 01 </option>
                                     		<option style="color:#000;font-weight:600;" value="7"> South West 01 </option>
                                     		<option style="color:#000;font-weight:600;" value="8"> East 01 </option>
                                     		<option style="color:#000;font-weight:600;" value="9"> West 01 </option>
                                    </select>
                                </div>
                            </div>

                            </div>
                            
                       </div>
                </div>

              <div class="row mt-3">
                                    <div id="field">

                                        <div class="row fieldGroup rowname">
                                            <div class="">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label">Product Name:</label>
                                                                    <select name="product_id[]" class="form-control select2 orderProduct" >
                                                                        <option value="">== Select Product ==</option>
                                                                                @foreach ($data as $item)
                                                                                    <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                                                                @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                          <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> UOM:</label>
                                                                    <input type="text" name="unit[]"  class="form-control orderUnit" value="" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                   <label class=" col-form-label"> Quantity:</label>
                                                                    <input type="text"  name="quantity[]" required class="form-control qty" >
                                                                </div>
                                                            </div> 

                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">Action :</label> </br>
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

                                    </div>
                                </div>

                                <!-- multiple data end -->



                    <div class="col-md-10 m-auto">
                      <div class="row pt-4">
                     

                      	<div class="col-md-7">
                        	<div class="form-group row">
                              <label class="col-sm-2 col-form-label text-primary"> Note: </label>
                              <div class="col-sm-10">
                                <textarea name="note" rows="3" cols="40%"></textarea>
                              </div>
                        	</div>
                          </div>
                          <div class="col-md-5">
                                  <div class="form-group row">
                                      <label class=" col-form-label col-md-4">Issued By:</label>
                                    	<input type="text" name="issued_by" class="form-control col-md-8" placeholder="Issued By">
                                   </div>
                               </div> 
                        </div>
                    
                </div>
              <div class="col-md-12">
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
                    '<div class="row fieldGroup rowname"> <div class=""> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-5"> <div class="form-group"> <select name="product_id[]" class="form-control select2 orderProduct" required> <option value="">== Select Product ==</option> @foreach ($data as $item) <option value="{{ $item->id }}">{{ $item->product_name }}</option> @endforeach </select> </div> </div> <div class="col-md-3"> <div class="form-group">  <input type="text" name="unit[]" class="form-control orderUnit" value="" readonly> </div> </div> <div class="col-md-4"> <div class="form-group">  <input type="text" name="quantity[]" required class="form-control qty" > </div> </div> </div> </div> <div class="col-md-2 mt-2">  <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> </div>';
                $(this).parents('.fieldGroup:last').after(fieldHTML);
            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
              //total();
            });

           /*$('#field').on('input', '.rate, .qty', function() {
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
        });
    </script>

@endsection
