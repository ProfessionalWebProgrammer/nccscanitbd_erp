@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('cash.receive.store')}}" method="post">
                @csrf
                 <div class="container" style="background:#ffffff; padding:0px 40px;min-height:80vh">
                   <div class="col-md-12 pb-2 pt-2 text-left">
                        <a href="{{route('cash.receive.index')}}" class="btn btn-sm btn-success"> Cash Received List </a>
                      </div>
                      <div class="col-md-12 pb-4 text-center">
                        <h4>Create Cash Received</h4>
                      </div> <hr>
                    <div class="row pt-4">
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Date : </label>
                                <div class="col-sm-9">
                                    <input type="date" value="{{date('Y-m-d')}}" name="payment_date" class="form-control" id="inputEmail3">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group row">
                                <label for="payment_description" class="col-sm-2 col-form-label">Naration: </label>
                                <div class="col-sm-10">
                                    <input type="text" name="payment_description" class="form-control" placeholder="Naration">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
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
                    </div>
                    <div class="row mt-3">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-11">
                                            <div class="row">

                                                <div class="col-md-3 pr-3">
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
                                                   <div class="balancehide" style="color:red;margin-top: -18px; display:none">Balance: <span class="balanceBC"></span></div>
                                                </div>

                                                <div class="col-md-4 pr-3">
                                                    <div class="form-group row">
                                                            <label for="">Dealer :</label>
                                                            <select class="form-control select2 dealer_id"

                                                            name="dealer_id[]"  required>
                                                            <option value="">Select Dealer</option>

                                                            @foreach ($allDealers as $data)
                                                                <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                    {{ $data->d_s_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 pr-3 " >
                                                    <div class="form-group ">
                                                            <label >Product Category :</label>
                                                            <select class="form-control select2 "  name="category_id[]"  >
                                                            <option value="">Select Product Category</option>

                                                            @foreach ($category as $data)
                                                                <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                    {{ $data->category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                          {{-- <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label >Sales Invoice:</label>
                                                                     <select class=" form-control  sales_invoice"  data-show-subtext="true" data-live-search="true"   name="sales_invoice[]">

                                                                    </select>
                                                                </div>
                                                            </div> --}}

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
                                      {{--   <div class="col-md-1"> <label for="">Invoice :</label>
                                        <span id="invoice" class="invoiceNo"></span>
                                      </div> --}}
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
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-3 pr-3"> <div class="form-group row"> <select class="form-control select2 cash_id" name="cash_id[]" required> <option value="">Select Cash</option> @foreach ($allcashs as $data) <option style="color:#000;font-weight:600;" value="{{ $data->wirehouse_id }}"> {{ $data->wirehouse_name }}</option> @endforeach </select> </div> <div class="balancehide" style="color:red;margin-top: -18px; display:none">Balance: <span class="balanceBC"></span></div> </div> <div class="col-md-4 pr-3"> <div class="form-group row"> <select class="form-control select2 dealer_id" name="dealer_id[]" required> <option value="">Select Vendor</option> @foreach ($allDealers as $data) <option style="color:#000;font-weight:600;" value="{{ $data->id }}"> {{ $data->d_s_name }}</option> @endforeach </select> </div> </div> <div class="col-md-3 pr-3 " > <div class="form-group "> <select class="form-control select2 " name="category_id[]" > <option value="">Select Product Category</option> @foreach ($category as $data) <option style="color:#000;font-weight:600;" value="{{ $data->id }}"> {{ $data->category_name }}</option> @endforeach </select> </div> </div> <div class="col-md-2"> <div class="form-group row"> <input type="text" name="amount[]" class="form-control amount"> </div> </div> </div> </div> <div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> </div>';

                    $(this).parents('.fieldGroup:last').after(fieldHTML);

                    $('.select2').select2({
                    theme: 'bootstrap4'
                  });
              /*  if(x<=12){
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
*/



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



                                 parent.find('.balanceBC').html(data);

                               //  parent.find('.balanceBC').val(data);
                                  parent.find('.balancehide').css('display',"block");

                                    }
                                });







                    })




       $('#field').on('change','.dealer_id',function(){

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');
                var vendorid = $(this).val();

               //console.log(parent);

                    $.ajax({
                            url : '{{url('vendor/sales/invoice/')}}/'+vendorid,
                            type: "GET",
                            dataType: 'json',
                            success : function(data){
                              //  console.log(data);
                     	 var str='';
                        str+='<option value="">Select Invoice</option>';
                         $(data).each(function (i,v){
                         		var tamount = Math.round(v.grand_total);
                              str+='<option style="color:black;font-weight:bold" data-value="'+tamount+'"  value="'+v.invoice_no+'">'+v.invoice_no+'</option>';
                          });
                        //  alert(str);
                          parent.find('.sales_invoice').html(str);
                          //$('.sales_invoice').selectpicker('refresh');



                        }
                        });









         });


        $('#field').on('change','.sales_invoice',function(){

                        // $('.totalvalueid').attr("value", "0");
                        var parent = $(this).closest('.fieldGroup');

             var thisvalue =  $(this).find(':selected').attr("data-value");
            // var thisvalue =  $(this).val();
			//alert(thisvalue);
           parent.find('.amount').val(thisvalue);

          {{--         $.ajax({
                                    url : '{{url('vendor/sales/invoice/value')}}/'+thisvalue,
                                    type: "GET",
                                    dataType: 'json',
                                    success : function(data){
                                       // console.log(data);



                                }
                                });  --}}


           //    parent.find('.inputv').val(thisvalue);
              total();
           //   console.log(thisvalue);

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
@endsection
