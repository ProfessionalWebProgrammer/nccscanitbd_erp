@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">


        <!-- Main content -->
        <div class="content px-4 ">
            
            <form action="{{route('production.update.fg.set')}}" method="post">
                @csrf
                <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                  <div class="row">
                      <div class="col-md-12 text-center pt-3">
                          <h3 class="text-uppercase">Finised Good Production Set Update</h3>
                          <hr width="30%" style="background: #003c3f;">
                      </div>
                  </div>
                    <div class="row pt-4">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label">Select Finish Goods  : </label>
                                <select name="finish_goods_id" class="form-control select2" required>
                                    <option value="">== Select Finish Goods ==</option>
                                    @foreach ($finishedgoods as $item)
                                        <option value="{{ $item->id }}" @if($data->fg_id == $item->id) selected @else  @endif >{{ $item->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                      
                     
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label" required>Quantity(Kgs):  </label>
                                <input type="number" class="form-control" name="fg_qty" value="{{$data->fg_qty*1000}}">
                                <input type="hidden" name="invoice" value="{{$data->invoice}}">
                            </div>
                        </div>
                      
                    </div>
                  @php 
                  $rowProducts = DB::table('finished_good_sets')->select('finished_good_sets.*','row_materials_products.product_name')->leftjoin('row_materials_products','row_materials_products.id','finished_good_sets.rm_id')->where('invoice',$data->invoice)->where('fg_id',$data->fg_id)->get();
                  $total = 0;
                  @endphp 
                    <h5 class="mt-3 text-uppercase">Production Stock Out</h5>
                    <hr class="bg-light mt-0 pt-0">
                    {{-- Multiple add button code start from here! --}}
                  <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">Product Name: </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Quantity :</label>
                                                </div>
                                              <div class="col-md-2">
                                            <label for="">Action :</label>
                                        	</div>
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-6"></div>
                                    </div>
                                </div>
                    <div class="row mt-3">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname mb-3">
                              @foreach($rowProducts as $val)
                              @php 
                              $total += $val->rm_qty*1000;
                              @endphp 
                              <input type="hidden" name="id[]" value="{{$val->id}}"/>
                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select class="form-control select2 product_id" name="product_id[]"
                                                        data-live-search-style="startsWith" required>
                                                        <option value=" " selectedS>Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option style="color:#000;font-weight:600;"
                                                                value="{{ $product->id }}" @if($val->rm_id == $product->id) selected  @else  @endif >{{ $product->product_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" class="form-control p_qty" step="any" name="p_qty[]"
                                                        value="{{$val->rm_qty*1000}}">
                                                  <input type="hidden"  name="new_product" value="0">
                                                </div>
                                              <div class="col-md-2">
                                            <a href="javascript:void(0)" style="margin-top: 3px;"
                                                class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                    class="fas fa-plus-circle"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"
                                                style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>

                                        	</div>
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-6"></div>
                                    </div>
                                </div>
                              @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- multiple add end on here --}}
                    <div class="row">
                        
                        <div class="col-md-4  mt-5">
                            <table class="table  border table-sm">
                                <thead></thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr class="font-weight-bold">
                                        <td>Total Qty :</td>
                                        <td> <span id="total_qty">{{$total}}</span></td>
                                        <input type="hidden" class="form-control total_qty" 
                                            name="total_qty" value="">
                                    </tr>
                              
                                </tfoot>
                            </table>
                        </div>
                      <div class="col-md-8">

                        </div>
                    </div>
                    <div class="row pb-5 mt-3">
                        <div class="col-md-5">

                        </div>
                        <div class="col-md-2 m-auto">
                            <button type="submit" class="btn custom-btn-sbms-submit" style="width: 100%"> Update Stock Out
                            </button>
                        </div>
                        <div class="col-md-5">

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
                x = x + 1;
                var fieldHTML ='<div class="row fieldGroup rowname mb-3"> <div class="col-md-12"> <div class="row"> <div class="col-md-6"> <div class="row"> <div class="col-md-6"> <select class="form-control select2 product_id" name="product_id[]" data-live-search-style="startsWith" required> <option value=" " selectedS>Select Product</option> @foreach ($products as $product) <option style="color:#000;font-weight:600;" value="{{ $product->id }}">{{ $product->product_name }} </option> @endforeach </select> </div> <div class="col-md-4"> <input type="number" class="form-control p_qty" step="any" name="p_qty[]" placeholder="Quantity"> <input type="hidden"  name="new_product" value="1"> </div> <div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> <div class="col-md-6"></div> </div> </div> </div> </div>';
                $(this).parents('.fieldGroup:last').after(fieldHTML);


                $('.select2').select2({
                    theme: 'bootstrap4'
                })

            });


            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
                total();
                x = x - 1;
                console.log(x);

            });


            $('#field').on('change', '.product_id', function() {

                    // $('.totalvalueid').attr("value", "0");
                    var parent = $(this).closest('.fieldGroup');

                    var product_id = parent.find('.product_id').val();

                    console.log(product_id);
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
