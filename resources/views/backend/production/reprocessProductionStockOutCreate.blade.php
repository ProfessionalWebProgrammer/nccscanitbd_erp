@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">
				<div class="row pt-2 pb-2 ml-3">
                      <div class="col-md-4 text-left ml-5">
                      	<a href="{{route('production.stock.out.list')}}" class="btn btn-sm btn-success">Reprocess List</a>
                    </div>
                </div>
      
        <!-- Main content -->
        <div class="content px-4 ">

            <form action="{{route('reprocess.production.stock.out.store')}}" method="post">
                @csrf
                <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                  <div class="row">
                      <div class="col-md-12 text-center pt-3">
                          <h3 class="text-uppercase">Finished Good Reprocess Stock Out</h3>
                          <hr width="30%" style="background: #003c3f;">
                      </div>
                  </div>
                    <div class="row pt-4">

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label">Date : </label>
                                <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="date">
                            </div>
                        </div>
                       

                       <div class="col-md-10">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label" >Referance/Narration : </label>
                                <input type="text" class="form-control" name="referance">
                            </div>
                        </div>

                      </div>
                  <h5 class="mt-3 text-uppercase">Finish Good Stock Out</h5>
                    <hr class="bg-light mt-0 pt-0">
                    {{-- Production Multiple add button code start from here! --}}
                  	<div class="row">
                        <div id="field_finishGood" class="col-md-12">
                            <div class="row fieldGroup rowname mb-2">
                                <div class="col-md-7">
                                  <div class="row">
                                        <div class="col-md-10">
                                          <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="finish_goods_id" class="col-form-label">Finish Goods Name : </label>
                                                    <select name="finish_goods_id[]" class="form-control select2 finish_goods_id" id="finish_goods_id" required>
                                                        <option value="">== Select Store ==</option>
                                                        @foreach ($finishedgoods as $item)
                                                            <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="qty" class="col-form-label" required>Quantity (Kg):  </label>
                                                    <input type="text" class="form-control qty" name="qty[]" id="qty">
                                                </div>
                                            </div>
                                          </div>
                                         </div>
                                    	<div class="col-md-2">
                                          <label for="">Action :</label><br>
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
                      	</div>
                      </div>

                   
                    <div class="row">
                        
                        <div class="col-md-6  mt-5">
                            <table class="table  border table-sm">
                                <thead>

                                </thead>
                                <tbody>


                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold">
                                        <td>Total Qty (kg):</td>
                                        <td> <span id="total_qty"></span></td>
                                        <input type="hidden" class="form-control total_qty"
                                            name="total_qty">
                                    </tr>

                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3">
                            <button type="submit" id="customBtn" class="btn custom-btn-sbms-submit" style="width: 100%"> Confirm
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


          /* Finished Goods multiple add */
          $("#field_finishGood").on("click", ".addMoreFG", function() {
                var fieldHTML =
                    '<div class="row fieldGroup rowname mb-2"> <div class="col-md-7"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-6"> <div class="form-group"> <select name="finish_goods_id[]" class="form-control select2 finish_goods_id" id="finish_goods_id" required> <option value="">== Select Store ==</option> @foreach ($finishedgoods as $item) <option value="{{ $item->id }}">{{ $item->product_name }}</option> @endforeach </select> </div> </div> <div class="col-md-6"> <div class="form-group"> <input type="text" class="form-control qty" name="qty[]" > </div> </div> </div> </div> <div class="col-md-2"><a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMoreFG"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove removeFG" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> <div class="col-md-5"> </div> </div>';
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

           

                    $('#field_finishGood').on('input', '.qty', function() {

                        // $('.totalvalueid').attr("value", "0");
                        var parent = $(this).closest('.fieldGroup');
                        
                        var p_qty = parent.find('.qty').val();
                       // var stock = parent.find('.stock_value').val();
                        //alert(p_qty);
                   // parent.find('.remaning').val(stock-p_qty);


                    total();

                    })

            //calculate total value
            function total() {
                var qty = 0;
                var total = 0;
                var discount = 0;
                var total_with_discount = 0;

                $(".qty").each(function() {
                    var totalqtyid = $(this).val() - 0;
                    qty += totalqtyid;
                    $('#total_qty').html(qty);
                    // console.log(total);
                })
                $('#total_qty').html(qty);
                $('.total_qty').val(qty);


            }






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

       
    </script>



@endpush
