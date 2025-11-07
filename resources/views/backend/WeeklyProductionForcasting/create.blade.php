@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">
      <style media="screen">
        input[name="date"].form-control{
          border-radius: 0px!important;
        }
      </style>
        <!-- Main content -->
        <div class="content px-4 ">

            <form action="{{route('wpf.store')}}" method="post">
                @csrf
                <div class="container" style="background:#f5f5f5; padding:0px 40px;min-height:85vh">
                  <div class="row">
                      <div class="col-md-12 text-center pt-3">
                          <h3 class="text-uppercase">Weekly Production Forcasting Create</h3>
                          <hr width="60%" style="background: #003c3f;">
                      </div>
                  </div>
                    <div class="row pt-4">


                          <h5>Select Dalivery Date: <span id="today" style="color: lime; display:inline-block">Today</span></h5>
                          <div class="form-group m-b-40">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text">
                                          <i class="far fa-calendar-alt"></i>
                                      </span>
                                  </div>
                                  <input type="text" name="date"
                                      class="form-control float-right" id="daterangepicker">

                              </div>
                          </div>


                         <div class="col-md-5">
                            <div class="form-group row">
                                    <label for="inputEmail3" class="col-form-label col-md-4">Select Supplier: </label>
                                    <select name="supplier_id"  class="form-control select2 col-md-8" >
                                        <option value=""> Select Supplier </option>
                                        @foreach ($suppliers as $item)
                                            <option value="{{ $item->id }}">{{ $item->supplier_name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                      </div>
                    </div>

                    {{-- Multiple add button code start from here! --}}
                    <div class="row mt-3">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname mb-3">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label for="">Product Name:</label>

                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Quantity (kg):</label>

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
                          <div class="row fieldGroup rowname mb-3">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <select class="form-control select2 product_id" name="product_id[]"
                                                        data-live-search-style="startsWith" required>
                                                        <option value=" " selectedS>Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option style="color:#000;font-weight:600;"
                                                                value="{{ $product->id }}">{{ $product->product_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                   <input type="text" class="form-control p_qty" name="qty[]" placeholder="Quantity">
                                                   
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
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- multiple add end on here --}}
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group mt-2">
                              <label class=" col-form-label "> Narration:</label>
                              <input type="text" name="note" class="form-control"  placeholder="Type here">
                          </div>
                        </div>
                        <div class="col-md-6  mt-5">
                            <table class="table  border table-sm">
                                <thead>

                                </thead>
                                <tfoot>
                                    <tr class="font-weight-bold">
                                        <td>Total Qty (kg):</td>
                                        <td> <span id="total_qty"></span></td>
                                        <input type="hidden" class="form-control total_qty"
                                            name="total">
                                    </tr>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3">
                            <button type="submit" class="btn custom-btn-sbms-submit" style="width: 100%"> Save </button>
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
          $("#daterangepicker").change(function() {
              var a = document.getElementById("today");
             a.style.display = "none";
          });
            var x = 1
            //add more fields group
            $("body").on("click", ".addMore", function() {
                x = x + 1;
                var fieldHTML =
                    '<div class="row fieldGroup rowname mb-3"> <div class="col-md-12"> <div class="row"> <div class="col-md-6"> <div class="row"> <div class="col-md-8"> <select class="form-control select2 product_id" name="product_id[]" data-live-search-style="startsWith" required> <option value=" " selectedS>Select Product</option> @foreach ($products as $product) <option style="color:#000;font-weight:600;" value="{{ $product->id }}">{{ $product->product_name }} </option> @endforeach </select> </div> <div class="col-md-4"> <input type="text" class="form-control p_qty" name="qty[]" placeholder="Quantity"> </div> </div> </div> <div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> </div>';

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
