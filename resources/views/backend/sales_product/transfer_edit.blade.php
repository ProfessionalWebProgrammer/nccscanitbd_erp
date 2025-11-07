@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ route('product.transfer.update') }}" method="post">
                @csrf
               <div class="container-fluid" style="background:#ffffff; padding:0px 40px; min-height:85vh;">
                    <div class="row pt-5">
                        <div class="col-md-4 px-3">
                            <div class="form-group row">
                                <label class="col-form-label text-right">Date : </label>
                                     <input type="date" value="{{ $trdata[0]->date }}" name="date" class="form-control">
                              </div>
                        </div>

                        <div class="col-md-4 px-3">
                            <div class="form-group row">
                                <label class=" col-form-label text-right">Vehicle : </label>
                                    <input type="text" name="vehicle" value="{{$trdata[0]->vehicle}}" class="form-control" placeholder="Vehicle">
                            </div>
                        </div>
                        <div class="col-md-4 px-3">
                            <div class="form-group row">
                                <label class=" col-form-label text-right">Transport Fare :
                                </label>
                                    <input type="text" name="transfer_fare" value="{{$trdata[0]->transfer_fare}}" class="form-control"
                                        placeholder="Transport Fare">
                             </div>
                        </div>
                    </div>
                    <input type="hidden" name="invoice_no" value="{{$trdata[0]->invoice}}" class="form-control"
                                       >
                    <div class="row ">
                        <div class="col-md-4 px-3">
                            <div class="form-group row">
                                <label for="inputEmail3" class=" col-form-label text-right">From Warehouse :
                                </label>
                                    <select name="from_wirehouse" class="form-control select2">
                                        <option value=""> == Select Werehouse == </option>
                                        @foreach ($factory as $item)
                                            <option value="{{ $item->id }}" @if($item->id == $trdata[0]->from_wirehouse)selected @endif>{{ $item->factory_name }}</option>
                                        @endforeach
                                    </select>
                             </div>
                        </div>
                        <div class="col-md-4 px-3">
                            <div class="form-group row">
                                <label for="inputEmail3" class=" col-form-label text-right">To Warehouse :
                                </label>
                                    <select name="to_wirehouse" class="form-control select2">
                                        <option value=""> == Select Werehouse == </option>
                                        @foreach ($factory as $item)
                                            <option value="{{ $item->id }}" @if($item->id == $trdata[0]->to_wirehouse)selected @endif>{{ $item->factory_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                      <div class="col-md-4 px-3">
                            <div class="form-group row">
                                <label class="col-form-label text-right">Note:
                                </label>
                                    <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="3">{{ $trdata[0]->note }}</textarea>
                             </div>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div id="field" class="col-md-12">
                          @foreach($trdata as $item)
                            <div class="row fieldGroup rowname">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-4">
                                                </div>
                                                <div class="col-md-5 pr-3">
                                                    <div class="form-group row">
                                                        <label for="">Product :</label>
                                                        <select class="form-control select2" name="product_id[]" required>
                                                            <option value="">Select Product</option>
                                                            @foreach ($salesProducts as $data)
                                                                <option style="color:#000;font-weight:600;"
                                                                    value="{{ $data->id }}"  @if($data->id == $item->product_id)selected @endif>
                                                                    {{ $data->product_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="">Quantity :</label>
                                                        <input type="text" name="product_qty[]"  value="{{$item->qty}}" class="form-control amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Action :</label> <br>
                                            <a href="javascript:void(0)" style="margin-top: 3px;"
                                                class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                    class="fas fa-plus-circle"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"
                                                style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                          @endforeach

                        </div>
                    </div>


                    <div class="row my-4">
                        <div class="col-md-6  m-auto font-weight-bold">
                            <h5 class="text-center ">Total Amount : <span id="total_amount">/-</span></h5>
                        </div>

                    </div>
                    <div class="row py-4">
                        <div class="col-md-6 m-auto">
                            <div class="text-center">
                                <button type="submit" class="btn custom-btn-sbms-submit"> Confirm </button>
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

          total();

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
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-8"> <div class="row"> <div class="col-md-4"> </div><div class="col-md-5 pr-3"> <div class="form-group row"> <select class="form-control select2" name="product_id[]" required> <option value="">Select Product</option> @foreach ($salesProducts as $data) <option style="color:#000;font-weight:600;" value="{{ $data->id }}">{{ $data->product_name }}</option> @endforeach </select> </div></div><div class="col-md-3"> <div class="form-group row"> <input type="text" name="product_qty[]" class="form-control amount"> </div></div></div></div><div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div>';
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
                $('#total_amount').html(total);
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
