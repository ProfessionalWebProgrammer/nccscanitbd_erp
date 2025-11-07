@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
          <div class="row pt-2 pb-2 ml-3">
                      <div class="col-md-4 text-left ml-5">
                      	<a href="{{route('production.stock.out.list')}}" class="btn btn-sm btn-success">Production List</a>
                    </div>

                </div>

            <form action="{{route('production.stock.out.store')}}" method="post">
                @csrf

                  <div class="row">
                      <div class="col-md-12 text-center pt-3">
                          <h3 class="text-uppercase">Auto Production Stock Out Create</h3>
                          <hr width="60%" style="background: #003c3f;">
                      </div>
                  </div>
                    <div class="row pt-4">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label">Date : </label>
                                <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="date">
                            </div>
                        </div>
                       <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label">Expire Day : </label>
                                <input type="number" class="form-control" name="expire_date" placeholder="60 Days">
                            </div>
                        </div>



                       <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label" required>Referance/Narration : </label>
                                <input type="text" class="form-control" name="referance" placeholder="Text Here">
                            </div>
                        </div>
                     {{-- <div class="col-md-2">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label" required>Per Bag Qty: </label>
                                <input type="number" class="form-control" name="bag" placeholder="25 kg">
                            </div>
                        </div> --}}

                         <div class="col-md-2">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label" title="Please set the Bach No, It's must be Unique" required>Bach No : </label>
                                <input type="text" class="form-control" name="batch" placeholder="1001">
                              <span style="font-size:13px; color:red;">It's must be Unique</span>
                            </div>
                        </div>

                         <div class="col-md-3">
                            <div class="form-group">
                                    <label for="inputEmail3" class="col-form-label">Production Factory : </label>
                                    <select name="production_factory_id"  class="form-control select2" >
                                        <option value="">== Select Factory ==</option>
                                        @foreach ($pfactory as $item)
                                            <option value="{{ $item->id }}">{{ $item->factory_name }}</option>
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
                                        <option value="{{ $item->id }}">{{ $item->factory_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label">Finish Goods Name : </label>
                                <select name="finish_goods_id" class="form-control select2" id="finish_goods_id" required>
                                    <option value="">== Select Item ==</option>
                                    @foreach ($finishedgoods as $item)
                                        <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label" required>Quantity (kg):  </label>
                                <input type="number" class="form-control" name="fg_qty"  id="fg_qty" placeholder="10000">
                            </div>
                        </div>
                      <div class="col-md-3">
                            <div class="form-group">
                                <label for="wastage" class="col-form-label" > Wastage (kg):  </label>
                                <input type="text" class="form-control" name="wastage"  id="wastage" placeholder="10">
                            </div>
                        </div>
                      <div class="col-md-3">
                            <div class="form-group">
                                <label for="reject_qty" class="col-form-label" >QC Reject Quantity (kg):  </label>
                                <input type="text" class="form-control" name="reject_qty"  id="reject_qty" placeholder="10">
                            </div>
                        </div>
						<div class="col-md-3">
                            <div class="form-group">
                                <label for="reject_qty" class="col-form-label" >WIP (kg):  </label>
                                <input type="text" class="form-control" name="wip_qty"  id="wip_qty" value="" readonly >
                            </div>
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
                                                <div class="col-md-4">
                                                    <label for="">Product Name:</label>

                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Per Unit Qty (kg):</label>

                                                </div>
                                               <div class="col-md-2">
                                                    <label for="">Total Qty (kg):</label>

                                                </div>

                                                <div class="col-md-2">
                                                    <label for="">Stock Balance (kg):</label>

                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Remaining Stock Balance (kg):</label>

                                                </div>
                                            </div>
                                        </div>

                                </div>
                            </div>


                        </div>
                  <div class="row">
                    	<h5 class="mt-3 text-uppercase col-md-12 text-danger">Reprocess Finish Good</h5>
                      <div class="col-md-3">
                            <div class="form-group">
                                <label for="refinish_goods_id" class="col-form-label text-danger">Finish Goods Name : </label>
                                <select name="reprocess_finish_goods_id" class="form-control select2" id="refinish_goods_id" >
                                    <option value="">== Select Item ==</option>
                                    @foreach ($finishedgoods as $item)
                                        <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label text-danger" >Quantity (Bag):  </label>
                                <input type="number" class="form-control" name="reprocess_qty"  id="reprocess_qty" placeholder="2">
                            </div>
                        </div>
              		</div>
                    </div>
                    {{-- multiple add end on here --}}

                    <div class="row">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4  mt-5">
                            <table class="table  border table-sm">
                                <thead></thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr class="font-weight-bold">
                                        <td>Total Qty (kg):</td>
                                        <td> <span id="total_qty"></span></td>
                                        <input type="hidden" class="form-control total_qty" name="total_qty">
                                    </tr>
                              </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3">
                            <button type="submit" class="btn custom-btn-sbms-submit" id="autoProduction-submit" style="width: 100%"> Confirm Stock Out
                            </button>
                        </div>
                        <div class="col-md-4 mt-3">

                        </div>
                    </div>
                    </form>
                </div>
                <!-- /.container-fluid -->

        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection


@push('end_js')


    <script>
        $(document).ready(function() {
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".removeable").remove();
                total();
                x = x - 1;
                //console.log(x);

            });


            $('#field').on('change', '.product_id', function() {

                    // $('.totalvalueid').attr("value", "0");
                    var parent = $(this).closest('.fieldGroup');

                    var product_id = parent.find('.product_id').val();

                    //console.log(product_id);
                    $.ajax({
                        url: '{{ url('/stock/product/') }}/' + product_id,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {
                            //console.log(data);

                            var pcost= parent.find('.p_qty').val();
                            parent.find('.stock_value').val(data.toFixed(2));
                            parent.find('.remaning').val(data-pcost.toFixed(2));
                        }
                    });
                    total();

                    })


                    $('#field').on('input', '.p_qty', function() {

                        // $('.totalvalueid').attr("value", "0");
                        var parent = $(this).closest('.fieldGroup');

                        var p_qty = parent.find('.p_qty').val();
                        var stock = parent.find('.stock_value').val();

                    parent.find('.remaning').val(stock-p_qty.toFixed(2));

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
                    $('#total_qty').html(qty.toFixed(2));
                    // console.log(total);
                })
                $('#total_qty').html(qty.toFixed(2));
                $('.total_qty').val(qty.toFixed(2));

            }


           $('select[name="finish_goods_id"]').on('change',function() {
                    var fg_id = $(this).val();
                     //console.log(fg_id);

					 $.ajax({
                                      url: '{{ url('/stock/product/wip/') }}/' +fg_id,
                                      type: "GET",
                                      dataType: 'json',
                                      success: function(data) {
                                        //  console.log(data);

                                        document.getElementById("wip_qty").value = data.toFixed(2);
                                          /*var pcost= parent.find('.p_qty').val();
                                          parent.find('.stock_value').val(data.toFixed(2));
                                        */

                                      }
                                  });

               $(".removeable").remove();

                    $.ajax({
                        url : '{{url('get/production/fg/set/')}}/'+fg_id,
                        type:"GET",
                        dataType: 'json',
                        success : function(data) {
                            // console.log('hello');

                          if(data != ''){

                             $.each(data , function(index, val) {

                                 var fieldHTML ='<div class="row fieldGroup rowname mb-3 removeable"> <div class="col-md-12">  <div class="row"> <div class="col-md-4"> <select class="form-control select2 product_id" name="product_id[]" data-live-search-style="startsWith" required>  <option value="'+val.rm_id+'" selected >'+val.product_name+'</option> @foreach ($products as $product) <option style="color:#000;font-weight:600;" value="{{ $product->id }}">{{ $product->product_name }}</option> @endforeach </select> </div><div class="col-md-2"> <input type="text" class="form-control u_qty" readonly value="'+val.rm_qty+'" name="u_qty[]" placeholder="Quantity"> </div><div class="col-md-2"> <input type="text" class="form-control p_qty" value="" name="p_qty[]" placeholder="Quantity"> </div><div class="col-md-2"> <input type="text" class="form-control stock_value" readonly name="stock[]" placeholder="Stock"> </div><div class="col-md-2"> <input type="text" class="form-control remaning" name="remaning[]" readonly placeholder="Remaining Stock"> </div></div></div></div>';
                         // console.log(fieldHTML);
                                $('.fieldGroup:first').after(fieldHTML);


                                $('.select2').select2({
                                    theme: 'bootstrap4'
                                })

                          	 });




                              $('.product_id').each(function() {

                                 var parent = $(this).closest('.fieldGroup');

                                  var product_id = parent.find('.product_id').val();

                                  //console.log(product_id);
                                  $.ajax({
                                      url: '{{ url('/stock/product/') }}/' + product_id,
                                      type: "GET",
                                      dataType: 'json',
                                      success: function(data) {
                                         //console.log(data);
                                            //alert(data.toFixed(2));
                                            var stock = data.stock ;
                                            var name = data.name ;
                                            if(stock > 0) {
                                                var pcost= parent.find('.p_qty').val();
                                                parent.find('.stock_value').val(stock.toFixed(2));
                                                parent.find('.remaning').val(stock-pcost.toFixed(2));
                                            } else {
                                                alert('Sorry! The ' +name+ ' is out of Stock or Rate is not available.');

                                                var a = document.getElementById("autoProduction-submit");
                                                a.style.display = "none";
                                            }

                                      }
                                  });

                              });



                          }


                            },
                        });
             });



        $('#fg_qty').on('input',function() {
                    var fg_qty = $(this).val();

                     $('.product_id').each(function() {

                      // $('.totalvalueid').attr("value", "0");
                      var parent = $(this).closest('.fieldGroup');

              			  var product_id=parent.find('.product_id').val();
              			  var u_qty=parent.find('.u_qty').val();

                       var tqty = fg_qty*u_qty;

              			  parent.find('.p_qty').val(tqty);

                         var stock = parent.find('.stock_value').val();

						var remaning = stock-tqty.toFixed(2);
                    parent.find('.remaning').val(remaning);
                         //console.log(p_qty);

                    });


           total();

             });


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
                            document.getElementById("stock").value = data.toFixed(2);
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
