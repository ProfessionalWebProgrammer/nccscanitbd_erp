@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('cash.payment.store')}}" method="post">
                @csrf
               <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                    <div class="row pt-4">
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Date : </label>
                                <div class="col-sm-9">
                                    <input type="date" value="{{ date('Y-m-d') }}" name="payment_date" class="form-control" id="inputEmail3">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="type" class="col-sm-4 col-form-label">Product Type :  <span style="color: red">*</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2 " name="type" required>
                                      <option value="">Select Product Type</option>
                                      <option style="color:#000;font-weight:500;" value="1"> Finish Goods</option>
                                      <option style="color:#000;font-weight:500;" value="2"> Raw Materials</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group row">
                          <label for="naration" class="col-md-1">Narration</label>
                          <input type="text" class="form-control col-md-11" name="narration" value="" placeholder="Narration">
                        </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-8">

                                </div>
                                <div class="col-md-4">
                                    {{-- <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">C/B : </label>
                                        <div class="col-sm-9">
                                            <input type="number" disabled class="form-control" >
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">

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
                                                        <label for="">Cash :</label>
                                                            <select class="form-control select2 cash_id"

                                                            name="cash_id[]" required>
                                                            <option value="">Select Cash</option>

                                                            @foreach ($allcashs as $data)
                                                                <option style="color:#000;font-weight:600;" value="{{ $data->wirehouse_id }}">
                                                                    {{ $data->wirehouse_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label >Balance:
                                                                     </label>
                                                                    <input type="text"
                                                                        class="form-control balanceBC" readonly  placeholder="">
                                                                </div>
                                                            </div>
                                                <div class="col-md-4 pr-3">
                                                    <div class="form-group row">
                                                            <label for="">Supplier :</label>
                                                            <select class="form-control select2 dealer_id"

                                                            name="dealer_id[]"  required>
                                                            <option value="">Select Supplier</option>

                                                            @foreach ($allSuppliers as $data)
                                                                <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                    {{ $data->supplier_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group row">
                                                            <label for="">Amount :</label>
                                                            <input type="text" name="amount[]" class="form-control amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label for="">Action :</label>
                                            <a href="javascript:void(0)" style="margin-top: 3px;"
                                                class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                    class="fas fa-plus-circle"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"
                                                style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>

                                        </div>
                                        <div class="col-md-1"> <label for="">Invoice :</label>
                                        <span id="invoice" class="invoiceNo"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row ">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-4  mt-5 font-weight-bold">
                        <h5>Total Amount : <span id="total_amount">/-</span></h5>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <div class="text-right">
                                <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">

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
                    url : '{{url('get/payment/invoice')}}',
                    type: "GET",
                    dataType: 'json',
                    success : function(data){

                        //console.log(data);
                            var dln = data;
                            invoice = dln;
                            $('.invoiceNo').html(dln);

                }
                });

                var x = 1;
            //add more fields group
            $("body").on("click", ".addMore", function() {
                x = x+1;
                invoice  = invoice+1;
                var fieldHTML =
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-4 pr-3"> <div class="form-group row">  <select class="form-control select2 cash_id" name="cash_id[]" required> <option value="">Select cash</option> @foreach ($allcashs as $data) <option style="color:#000;font-weight:600;" value="{{$data->wirehouse_id}}">{{$data->wirehouse_name}}</option> @endforeach </select> </div></div> <div class="col-md-2"> <div class="form-group">  <input type="number"  class="form-control balanceBC" readonly placeholder=""> </div></div><div class="col-md-4 pr-3"> <div class="form-group row">  <select class="form-control select2 dealer_id" name="dealer_id[]" required> <option value="">Select Supplier</option> @foreach ($allSuppliers as $data) <option style="color:#000;font-weight:600;" value="{{$data->id}}">{{$data->supplier_name}}</option> @endforeach </select> </div></div><div class="col-md-2"> <div class="form-group row">  <input type="text" name="amount[]" class="form-control amount"> </div></div></div></div><div class="col-md-1">  <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> <div class="col-md-1"><span class="invoiceNo">'+invoice+'</span></div></div></div></div>';
                if(x<=12){
                    $(this).parents('.fieldGroup:last').after(fieldHTML);

                    $('.select2').select2({
                    theme: 'bootstrap4'
                    })

                }else{
                    $(function() {
                            const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000
                            });
                                $(function () {
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
               x = x-1;
                total();
            });


            $('#field').on('input','.amount',function(){



                total();


            });





            function total(){
                var total = 0;
               $(".amount").each(function(){
                    var totalvalueid = $(this).val()-0;
                    total +=totalvalueid;
                    $('#total_amount').html(total);
                    // console.log(total);
                })
                $('#total_amount').html(total);
             }



          $('#field').on('change','.cash_id',function(){

                        // $('.totalvalueid').attr("value", "0");
                        var parent = $(this).closest('.fieldGroup');
                          var warehouseid =  parent.find('.cash_id').val();


                        $.ajax({
                                    url : '{{url('/get/cash/balance/')}}/'+warehouseid,
                                    type: "GET",
                                    dataType: 'json',
                                    success : function(data){
                                      console.log(data);

                                 parent.find('.balanceBC').val(data);

                                    }
                                });
                    })
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
@endsection
