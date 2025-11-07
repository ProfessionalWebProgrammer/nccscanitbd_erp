@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">

        <!-- Main content -->
        <div class="content px-4 ">
          <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
          <div class="row pt-2 pb-2 ml-3">
                      <div class="col-md-4 text-left ml-5">
                        <a href="{{route('production.packing.consumption.list')}}" class="btn btn-sm btn-success">Packing List</a>
                    </div>

                </div>
            <form action="{{route('production.packing.consumption.store')}}" method="post">
                @csrf

                  <div class="row">
                      <div class="col-md-12 text-center pt-3">
                          <h3 class="text-uppercase">Production Bag Stock Out</h3>
                          <hr width="30%" style="background: #003c3f;">
                      </div>
                  </div>
                    <div class="row pt-4">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label">Date : </label>
                                <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="date">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label">Production Invoice : </label>
                                <select class="form-control select2 product_id" name="pro_invoice"
                                    data-live-search-style="startsWith" required>
                                    <option value=" " selectedS>Select Invoice</option>
                                  @foreach ($invoices as $val)
                                    <option value="{{ $val->invoice }}">{{ $val->invoice }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>


                       <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label" required>Narration : </label>
                                <input type="text" class="form-control" name="note">
                            </div>
                        </div>
                    </div>
                   {{-- <h5 class="mt-3 text-uppercase">Production Bag Stock Out</h5>
                    <hr class="bg-light mt-0 pt-0"> --}}
                    {{-- Multiple add button code start from here! --}}
                    <div class="row mt-3">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname mb-1">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">F G Product Name :</label>

                                                </div>
                                              <div class="col-md-4">
                                                    <label for="">Bag Type :</label>

                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Stock (Qty):</label>

                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Quantity (Pices):</label>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Action :</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          <div class="row fieldGroup rowname mb-3">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select class="form-control select2 product_id" name="product_id[]"
                                                        data-live-search-style="startsWith" required>
                                                        <option value=" " selectedS>Select Finish Goods Product</option>
                                                      @foreach ($finishedgoods as $item)
                                                        <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                              <div class="col-md-4">
                                                    <select class="form-control select2 bag_id" name="bag_id[]"
                                                        data-live-search-style="startsWith" required>
                                                        <option value=" " selectedS>Select Bag Type</option>
                                                      @foreach ($purchases as $val)
                                                        <option value="{{ $val->id }}">{{ $val->product_name }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                   <input type="text" class="form-control stock_qty"  readonly>
                                                </div>
                                                <div class="col-md-2">
                                                   <input type="text" class="form-control p_qty" name="qty[]" placeholder="Quantity">
                                                </div>

                                            </div>
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
                            </div>

                        </div>
                    </div>
                    {{-- multiple add end on here --}}
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
                                        <td>Total Qty (Pices):</td>
                                        <td> <span id="total_qty"></span></td>
                                        <input type="hidden" class="form-control total_qty"
                                            name="total_qty">
                                    </tr>

                                </tfoot>
                            </table>
                        </div>
                      <div class="col-md-2  mt-5"></div>
                    </div>
                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3">
                            <button type="submit" class="btn custom-btn-sbms-submit"  id="autoProduction-submit" style="width: 100%"> Submit  </button>
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
            var x = 1
            //add more fields group
            $("body").on("click", ".addMore", function() {
                x = x + 1;
                var fieldHTML =
                    '<div class="row fieldGroup rowname mb-3"> <div class="col-md-12"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-4"> <select class="form-control select2 product_id" name="product_id[]" data-live-search-style="startsWith" required> <option value=" " selectedS>Select Finish Goods Product</option> @foreach ($finishedgoods as $item) <option value="{{ $item->id }}">{{ $item->product_name }}</option> @endforeach </select> </div> <div class="col-md-4"> <select class="form-control select2 bag_id" name="bag_id[]" data-live-search-style="startsWith" required> <option value=" " selectedS>Select Bag Type</option> @foreach ($purchases as $val) <option value="{{ $val->id }}">{{ $val->product_name }}</option> @endforeach </select> </div> <div class="col-md-2"> <input type="text" class="form-control stock_qty" readonly> </div> <div class="col-md-2"> <input type="text" class="form-control p_qty" name="qty[]" placeholder="Quantity"> </div> </div> </div> <div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> </div>';
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
              //  console.log(x);

            });


            $('#field').on('change', '.bag_id', function() {

                    // $('.totalvalueid').attr("value", "0");
                    var parent = $(this).closest('.fieldGroup');

                    var bag_id = parent.find('.bag_id').val();
                    var a = document.getElementById("autoProduction-submit");
                   // console.log(product_id);
                    $.ajax({
                        url: '{{ url('/stock/bag/') }}/' + bag_id,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {
                            //console.log(data);
                            var stock = data.stock ;
                            var name = data.name ;
                              if(stock > 0) {
                            parent.find('.stock_qty').val(stock.toFixed(2));
                          //  var pcost= parent.find('.stock_qty').val();
                            //parent.find('.stock_value').val(data);
                            //parent.find('.remaning').val(data-pcost);
                            a.style.display = "block";
                          } else {
                            alert('Sorry! The ' +name+ ' is out of Stock or Rate is not available .');
                            a.style.display = "none";
                          }
                        }
                    });
                    //total();

                  });

                    $('#field').on('input', '.p_qty', function() {

                        // $('.totalvalueid').attr("value", "0");
                        var parent = $(this).closest('.fieldGroup');

                        var p_qty = parent.find('.p_qty').val();
                       // var stock = parent.find('.stock_value').val();

                   // parent.find('.remaning').val(stock-p_qty);

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
                $('.total_qty').val(qty)
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
/*
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

        }); */
    </script>



@endpush
