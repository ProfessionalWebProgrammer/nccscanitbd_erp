@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('purchase.return.update')}}" method="post">
                @csrf
                <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                    <div class="text-center py-4">
                        <h3 class="text-uppercase font-weight-bold text-danger">Create Purchase Return</h3>
                    </div>

                    <div class="row pt-5">
                        <div class="col-md-4">
                            <label class="col-form-label text-right text-primary">Date: </label>
                            <input type="hidden"  value="{{$trdetails->id}}" name="id" class="form-control">
                            <input type="date"  value="{{$trdetails->date}}" name="date" class="form-control">
                               
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label text-right text-primary">Transport Vehicle: </label>
                            <input type="Text" id="vehicle"  value="{{$trdetails->vehicle_no}}" name="vehicle_no" class="form-control" placeholder="Transport Vehicle">

                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label text-right text-primary">Transport Fare: </label>
                            <input type="Text" id="vehicle"  value="{{$trdetails->transport_fare}}" name="transport_fare" class="form-control" placeholder="Transport Fare">

                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label text-right text-primary" style="padding-top: 10px;"> Supplier Name</label>
                            <select class="form-control select2" name="raw_supplier_id" id="supplier_id" required>
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option style="color:#000;font-weight:600;" value="{{ $supplier->id }}" @if($supplier->id == $trdetails->raw_supplier_id) selected @endif>
                                        {{ $supplier->supplier_name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label style="padding-top: 10px;" class="text-primary"> Warehouse Name:</label>
                            <select class="form-control select2" name="wirehouse_id" id="wirehouse" required>
                                <option value="">Select Warehouse</option>
                                @foreach ($factoryes as $factorye)
                                    <option style="color:#000;font-weight:600;" value="{{ $factorye->id }}" @if($factorye->id == $trdetails->wirehouse_id) selected @endif>
                                        {{ $factorye->factory_name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-1">
                                                </div>
                                                <div class="col-md-5 pr-3">
                                                    <div class="form-group row">
                                                        <label for="">Product :</label>
                                                        <select class="form-control select2" name="product_id" required>
                                                            <option value="" class="text-primary">Select Product</option>
                                                           @foreach ($product as $item)
                                                           <option value="{{$item->id}}" @if($item->id == $trdetails->product_id) selected @endif>{{$item->product_name}}</option>
                                                           @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 pr-3">
                                                    <div class="form-group row">
                                                        <label for="" class="text-primary">Quantity :</label>
                                                        <input type="text"  value="{{$trdetails->return_quantity}}" required name="return_quantity" class="form-control amount"
                                                            placeholder="Return Quantity">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="" class="text-primary">Rate :</label>
                                                        <input type="text"  value="{{$trdetails->return_rate}}" name="return_rate" class="form-control "
                                                            placeholder="Rate">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            {{-- <label for="">Action :</label> <br>
                                            <a href="javascript:void(0)" style="margin-top: 3px;"
                                                class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                    class="fas fa-plus-circle"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"
                                                style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a> --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row my-4">
                        {{-- <div class="col-md-6  m-auto font-weight-bold">
                            <h5 class="text-center ">Total Quantity : <span id="total_amount">/-</span></h5>
                        </div> --}}

                    </div>
                    <div class="row py-4">
                        <div class="col-md-6 m-auto">
                            <div class="text-center">
                                <button type="submit" class="btn custom-btn-sbms-submit btn-primary"> Submit </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script>
        $(document).ready(function() {


            var invoice = '';
            $.ajax({
                url: '{{ url('get/payment/invoice') }}',
                type: "GET",
                dataType: 'json',
                success: function(data) {

                    console.log(data);
                    var dln = data;
                    invoice = dln;
                    $('.invoiceNo').html(dln);

                }
            });

            var x = 1;
            //add more fields group
            $("body").on("click", ".addMore", function() {
                x = x + 1;
                invoice = invoice + 1;
                var fieldHTML =
                '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-1"> </div><div class="col-md-5 pr-3"> <div class="form-group row">  <select class="form-control select2" name="product_id[]" required> <option value="">Select Product</option>  @foreach ($product as $item)<option value="{{$item->id}}">{{$item->product_name}}</option>@endforeach </select> </div></div><div class="col-md-3 pr-3"> <div class="form-group row">  <input type="text" name="return_qty[]" class="form-control amount" placeholder="Return Quantity"> </div></div><div class="col-md-3"> <div class="form-group row">  <input type="text" name="return_rate[]" class="form-control " placeholder="Rate"> </div></div></div></div><div class="col-md-2"><a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div>';
                if (x <= 12) {
                    $(this).parents('.fieldGroup:last').after(fieldHTML);

                    $('.select2').select2({
                        theme: 'bootstrap4'
                    })

                } else {
                    $(function() {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000
                        });
                        $(function() {
                            Toast.fire({
                                icon: 'error',
                                title: 'Sorry! You can submit Only 12 entry.'
                            })

                        });

                    });
                }




            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();

                total();
            });


            $('#field').on('input', '.amount', function() {



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
                $('#total_amount').html(total_with_discount);
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
@endsection
