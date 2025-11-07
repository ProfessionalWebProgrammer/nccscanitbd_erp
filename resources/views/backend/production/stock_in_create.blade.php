@extends('layouts.sales_dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper posclass">


    <!-- Main content -->
    <div class="content px-4 ">
        <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
        <div class="row">
            <div class="col-md-12 text-center pt-3">
                <h3 class="text-uppercase">Manual Stock In</h3>
                <hr width="30%" style="background: #003c3f;">
            </div>
        </div>
        <form action="{{route('production.stock.in.store')}}" method="post">
            @csrf
            <div class="container-fluid">
                <div class="row pt-4">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-form-label">Date : </label>
                            <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="date">
                        </div>
                    </div>
                    <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label">Expire Date : </label>
                                <input type="date" class="form-control" name="expire_date">
                            </div>
                        </div>
                 
                    <div class="col-md-3"> </div>
                   <div class="col-md-4">
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
                      
                  
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-form-label">Store/Warehouse : </label>
                            <select name="wirehouse_id" id="wirehouse" class="form-control select2" required>
                                <option value="">== Select Store ==</option>
                                @foreach ($stores as $item)
                                <option value="{{ $item->id }}">{{ $item->factory_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>







                </div>
                <div class="row mt-3">
                    <div id="field" class="col-md-12">
                        <div class="row fieldGroup rowname mb-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Product Name:</label>
                                                <select class="form-control select2 product_id" name="product_id[]" data-live-search-style="startsWith" required>
                                                    <option value=" " selectedS>Select Product</option>
                                                    @foreach ($finishedgoods as $item)
                                                    <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Current Stock :</label>
                                                <input type="text" tabindex="-1" class="form-control c_stock" placeholder="Quantity" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Quantity :</label>
                                                <input type="text" required class="form-control p_qty" name="p_qty[]" placeholder="Quantity">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Production Rate</label>
                                                <input type="text" required class="form-control production_rate" name="production_rate[]" placeholder="">
                                            </div>

                                            <div class="col-md-2">
                                                <label>Bach No : </label>
                                                <input type="text" class="form-control" name="batch[]">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="">Action :</label><br>
                                        <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-xs addMore"><i class="fas fa-plus-circle"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-xs custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>

                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- multiple add end on here --}}

                <div class="row pb-5">
                    <div class="col-md-4 mt-3">

                    </div>
                    <div class="col-md-4 mt-3">
                        <button type="submit" class="btn btn-primary custom-btn-sbms-submit" style="width: 100%"> Confirm Stock In
                        </button>
                    </div>
                    <div class="col-md-4 mt-3">

                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </form>
        </div>
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
            var fieldHTML = '<div class="row fieldGroup rowname mb-3"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-4"> <select class="form-control select2 product_id" name="product_id[]" data-live-search-style="startsWith" required> <option value=" " selectedS>Select Product</option> @foreach ($finishedgoods as $item) <option value="{{$item->id}}">{{$item->product_name}}</option> @endforeach </select> </div><div class="col-md-2"> <input type="text" tabindex="-1" class="form-control c_stock" placeholder="Quantity" readonly> </div><div class="col-md-2"> <input type="text" required class="form-control p_qty" name="p_qty[]" placeholder="Quantity"> </div><div class="col-md-2"> <input type="text" required class="form-control production_rate" name="production_rate[]" placeholder=""> </div><div class="col-md-2"> <input type="text" class="form-control" name="batch[]"> </div></div></div><div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-xs addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-xs custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div><div class="col-md-2"></div></div></div></div>';
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

        $('select[name="product_id"]').on('change', function() {
            var pro_id = $(this).val();
            var parent = $(this).closest('.fieldGroup');
            // console.log(pro_id);

            $.ajax({
                url: '/stock/product/' + pro_id,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    // console.log('hello');
                    // console.log(data);
                    document.getElementById("stock").value = data;
                },
            });
        });



        $("#sbtn").click(function(event) {
            $.ajax({
                url: '{{ url('sales/salesNumber ') }}',
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
<script>
    $(document).ready(function() {
        $('#field').on('change', '.product_id', function() {

            var parent = $(this).closest('.fieldGroup');

            var product_id = parent.find('.product_id').val();
            var warehouse_id = $('#wirehouse').val();
            //console.log(product_id);

            if (warehouse_id == '') {
                parent.find('.product_id').val("");
                alert("Please Select Warehouse First");
            } else {
                $.ajax({
                    url: '{{ url('/sales/product/stock/') }}/' + product_id + '/' +
                        warehouse_id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);

                        var stock = data.stock;

                        parent.find('.c_stock').val(stock);
                    }
                });

            }

        })

    });
</script>



@endpush