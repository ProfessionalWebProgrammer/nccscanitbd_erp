@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">

            <form class="floating-labels m-t-40" action="{{ Route('finish.goods.manual.purchse.store') }}" method="POST">
                @csrf

                <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                    <div class="text-center py-4">
                        <h3 class="text-uppercase font-weight-bold">MATERIALS RECEIVING REPORT (MRR)</h3> <hr>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                          	<div class="row">
                              <div class="col-md-3">
                                <label class="col-form-label text-right">Date :</label>
                                <input type="date" id="data" name="date" value="{{date('Y-m-d')}}" class="form-control">
                              </div>
                              <div class="col-md-9">
                                <label class="col-form-label " style="padding-top: 10px;"> Narration</label>
                                <input type="text" class="form-control " name="narration" value="" placeholder="Narration">
                              </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <label class="col-form-label text-right" style="padding-top: 10px;"> Supplier Name</label>
                            <select class="form-control select2" name="raw_supplier_id" id="supplier_id" required>
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option style="color:#000;font-weight:600;" value="{{ $supplier->id }}">
                                        {{ $supplier->supplier_name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label style="padding-top: 10px;"> Warehouse Name:</label>
                            <select class="form-control select2" name="wirehouse_id" id="wirehouse" required>
                                <option value="">Select Warehouse</option>
                                @foreach ($factoryes as $factorye)
                                    <option style="color:#000;font-weight:600;" value="{{ $factorye->id }}">
                                        {{ $factorye->factory_name }}</option>
                                @endforeach
                            </select>
                        </div>
                       <div class="col-md-4">
                            <label class="col-form-label text-right">Transport Vehicle: </label>
                            <input type="Text" id="vehicle" name="transport_vehicle" class="form-control" placeholder="Transport Vehicle">

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
                                                <div class="col-md-4">
                                                    <label>Product Name</label>
                                                    <select class="form-control select2 product" name="product_id[]" required>
                                                        <option value="">Select Product</option>
                                                        @foreach ($products as $data)
                                                            <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                {{ $data->product_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                              	<div class="col-md-2">
                                                    <label for="">Unit :</label>

                                                  {{--   <select class="form-control select2" name="unit_id[]" required>
                                                        <option value="">Select Unit</option>
                                                        @foreach ($units as $unit)
                                                            <option style="color:#000;font-weight:600;" value="{{ $unit->id }}">
                                                                {{ $unit->unit_name }} ({{ $unit->unit_pcs }} Pcs)</option>
                                                        @endforeach
                                                    </select> --}}
                                                    <input type="text" name="unit[]"  class="form-control unit"  readonly>
                                                    <input type="hidden" name="unit_id[]"  class="form-control unitId">
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="">Quantity :</label>
                                                    <input type="text" class="form-control p_qty" name="p_qty[]" placeholder="Quantity">
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="">Purchase Price :</label>
                                                    <input type="text" class="form-control p_price" name="p_price[]" placeholder="Price">
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="">Total  value:</label>
                                                    <input type="hidden" readonly class="form-control total_price"   name="total_price[]" placeholder="total">
                                                    <input type="text" class="form-control total_price_without_discount" disabled  name="total_price_without_discount[]">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label for="">Action :</label>
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


                         <div class="row mt-3">
                            <div class="col-md-2"></div>

                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label ">Total Purchase Amount:</label>
                                    <input type="number" step="any" class="form-control" id="total_purchase_value"
                                        name="total_purchase_value" readonly placeholder="">

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label ">Transport Fare:</label>
                                    <input type="number" step="any" class="form-control " id="transport_fare" name="transport_fare"
                                        placeholder="Transport Fare">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label ">Net Payable Amount:</label>
                                    <input type="number" step="any" class="form-control" id="total_payable_amount"
                                        name="total_payable_amount" readonly placeholder="Net Payable Amount">

                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    <div class="row pb-5 pt-3">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success"><i class="fas fa-dolly"></i> Purchase</button>
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
            //add more fields group
            $("body").on("click", ".addMore", function() {
                var fieldHTML =
                    '<div class="row fieldGroup rowname mt-3"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-4"> <select class="form-control select2 product" name="product_id[]" required> <option value="">Select Product</option> @foreach ($products as $data) <option style="color:#000;font-weight:600;" value="{{$data->id}}">{{$data->product_name}}</option> @endforeach </select> </div><div class="col-md-2"> <input type="text" name="unit[]"  class="form-control unit"  readonly> <input type="hidden" name="unit_id[]"  class="form-control unitId"> </div><div class="col-md-2"> <input type="text" class="form-control p_qty" name="p_qty[]" placeholder="Quantity"> </div><div class="col-md-2"> <input type="text" class="form-control p_price" name="p_price[]" placeholder="Price"> </div><div class="col-md-2"> <input type="hidden" readonly class="form-control total_price" name="total_price[]" placeholder="total"> <input type="text" class="form-control total_price_without_discount" disabled name="total_price_without_discount[]"> </div></div></div><div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div><div class="col-md-2"></div></div></div></div>';
                $(this).parents('.fieldGroup:last').after(fieldHTML);

                $('.select2').select2({
                    theme: 'bootstrap4'
                    })
            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
                total();
            });



            $('#field').on('input','.p_price, .p_qty',function(){

                var parent = $(this).closest('.fieldGroup');
                var product_price=parent.find('.p_price').val();

                var product_qty=parent.find('.p_qty').val();

                var total_price = product_price*product_qty;




                parent.find('.total_price_without_discount').val(total_price);
                parent.find('.total_price').val(total_price);


                total();


                });


                function total(){
               var total = 0;
                var discount = 0;
                var total_with_discount = 0;



                $(".total_price").each(function(){
                    var totalvalueid = $(this).val()-0;
                    total +=totalvalueid;
                    $('#total_payable_amount').val(total);
                    // console.log(total);
                })

                var tv = $('#transport_fare').val();
                 $('#total_payable_amount').val(total-tv);
                 $('#total_purchase_value').val(total);


            }


            $('#transport_fare').on('input',function(){
               var tf =  $(this).val();

                var tv = $('#total_purchase_value').val();

                var tnv = tv -tf;

                $('#total_payable_amount').val(tnv);

                    });


                    $('#field').on('change','.product', function() {
                   var parent = $(this).closest('.fieldGroup');
                   var id = parent.find('.product').val();
                   //var url = '{{ url('/settings/get/category/') }}/' + id;
                   //alert(id);
                   $.ajax({
                               url: '{{ url('/get/salesProduct/unit/') }}/' + id,
                               type: "GET",
                               dataType: 'json',
                               success: function(data) {
                                   $(data).each(function() {
                                     //console.log(data);
                                   //  alert(data.days);
                                     parent.find('.unit').val(data.unit);
                                     parent.find('.unitId').val(data.id);

                                   });
                               }
                           });

                       });
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

    </script>

@endpush
