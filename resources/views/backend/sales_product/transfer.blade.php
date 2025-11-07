@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ route('product.transfer.store') }}" method="post">
                @csrf
                <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                    <div class="row pt-5">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Date : </label>
                                <div class="col-sm-8">
                                    <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Vehicle : </label>
                                <div class="col-sm-8">
                                    <input type="text" name="vehicle" class="form-control" placeholder="Vehicle">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Transport Fare :
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" name="transfer_fare" class="form-control"
                                        placeholder="Transport Fare">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label text-right">From Warehouse :
                                </label>
                                <div class="col-sm-8">
                                    <select name="from_wirehouse" class="form-control select2 " id="fromwh">
                                        <option value=""> == Select Werehouse == </option>
                                        @foreach ($factory as $item)
                                            <option value="{{ $item->id }}">{{ $item->factory_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label text-right">To Warehouse :
                                </label>
                                <div class="col-sm-8">
                                    <select name="to_wirehouse" class="form-control select2">
                                        <option value=""> == Select Werehouse == </option>
                                        @foreach ($factory as $item)
                                            <option value="{{ $item->id }}">{{ $item->factory_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-4 pr-3">
                                                    <div class="form-group row">
                                                        <label for="">Product :</label>
                                                        <select class="form-control select2 product_id" name="product_id[]"  required>
                                                            <option value="">Select Product</option>
                                                            @foreach ($salesProducts as $data)
                                                                <option style="color:#000;font-weight:600;"
                                                                    value="{{ $data->id }}">
                                                                    {{ $data->product_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                              <div class="col-md-3 pr-3">
                                                    <div class="form-group row">
                                                        <label for="">Batch No. :</label>
                                                        <select name="batch_number[]" class="form-control select2 batchNo">
                                                            <option value=""> == Select Werehouse First == </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group row">
                                                        <label for="">Stock :</label>
                                                        <input type="text" name="stock_qty[]" class="form-control pstock mr-2" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="">Quantity :</label>
                                                        <input type="text" name="product_qty[]" class="form-control amount">
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
                                <button type="submit" class="btn btn-primary custom-btn-sbms-submit"> Submit </button>
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

    <div class="modal fade" id="stockend">
            <div class="modal-dialog">
              <div class="modal-content bg-danger" >
                <div class="modal-header">
                  <h4 class="modal-title">Product Stock Out</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body ">

                   <p>Sorry..! This Product Out Of Stock. </p>
                </div>
                <div class="modal-footer justify-content-between">
                    <p  ></p>
                  <button type="button" class="btn btn-primary"data-dismiss="modal">Close</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
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
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-4 pr-3"> <div class="form-group row"> <select class="form-control select2 product_id" name="product_id[]" required> <option value="">Select Product</option> @foreach ($salesProducts as $data) <option style="color:#000;font-weight:600;" value="{{ $data->id }}"> {{ $data->product_name }}</option> @endforeach </select> </div> </div> <div class="col-md-3 pr-3"> <div class="form-group row"> <select name="batch_number[]" class="form-control select2 batchNo"> <option value=""> == Select Werehouse First == </option> </select> </div> </div> <div class="col-md-2"> <div class="form-group row"> <input type="text" name="stock_qty[]" class="form-control pstock mr-2" readonly> </div> </div> <div class="col-md-3"> <div class="form-group row"> <label for="">Quantity :</label> <input type="text" name="product_qty[]" class="form-control amount"> </div> </div> </div> </div> <div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> </div>';
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
                //$('#total_amount').html(total_with_discount);
            }


			$("#field").on("change",'.product_id', function() {
              	var parent = $(this).closest('.fieldGroup');
                var fromwh = $('#fromwh').val();
                var product_id = $('.product_id').val();
              	if(fromwh ===''){
                	alert('Please Select Warehouse First!')
                }
              //	console.log(fromwh);
            //  alert(pId);
              $.ajax({
                        url : '{{url('/sales/product/stock/')}}/'+product_id+'/'+fromwh,
                        type: "GET",
                        dataType: 'json',
                        success : function(data){
                         //   console.log(data);
                          var stock = data.stock;
                          //alert(stock);
                          if(stock > 0) {
                            parent.find('.pstock').val(stock);
                            $(".custom-btn-sbms-submit").removeClass('d-none');
                            $(".custom-btn-sbms-submit").addClass('d-block');
                          } else {
                            parent.find('.pstock').val(stock);
                          //  $('.custom-btn-sbms-submit').style.display = 'none';
                            $(".custom-btn-sbms-submit").addClass('d-none');
                            $(".custom-btn-sbms-submit").removeClass('d-block');
                            $('#stockend').modal('show');
                            //alert('This Product is not available in This Warehouse');
                          }


                        }
                    });

                 $.ajax({
                  url: '{{ url('get/batch/numbers/by/') }}/'+fromwh,
                  type: "GET",
                  dataType: 'json',
                  success: function(data) {
					var bdata = "<option value=''>== Select Batch ==</option>";

                   	$.each(data, function(data, v) {
                        bdata += "<option value='"+v.batch_id+"'>"+v.batch_id+"</option>";
                    });
                      parent.find('.batchNo').html(bdata);

                  }
                });
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
    </script>
@endsection
