@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <div class="col-md-2 text-right">
        <a href="{{route('bank.payment.index')}}" class="btn btn-xs btn-primary">Payment List</a>
      </div>
        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('bank.payment.store')}}" method="post">
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
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="payment_description" class="col-sm-2 col-form-label">Naration: </label>
                                <div class="col-sm-10">
                                    <input type="text" name="payment_description" class="form-control" placeholder="Naration">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group row">
                              <label for="" class="col-sm-2 col-form-label">Type:</label>
                              <div class="col-sm-10">
                                  <select class="form-control select2 "
                                  name="type_id[]"  id="type_id" required>
                                      <option style="color:#000;font-weight:600;" value="dealer">Bank</option>
                                      <option style="color:#000;font-weight:600;" value="company">Sister Concern</option>
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
                                                <div class="col-md-4  dealer" style="display:none;">
                                                    <div class="form-group ">
                                                        <label for="">Bank :</label>
                                                            <select class="form-control select2 bank_id" name="bank_id[]" >
                                                            <option value="">Select Bank</option>

                                                            @foreach ($allBanks as $data)
                                                                <option style="color:#000;font-weight:600;" value="{{ $data->bank_id }}"> {{ $data->bank_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4  company" style="display:none;">
                                                    <div class="form-group ">
                                                            <label >Sister Concern :</label>
                                                            <select class="form-control select2 "  name="company_id[]"  >
                                                            <option value="">Select Sister Concern</option>

                                                            @foreach ($allCompanies as $data)
                                                                <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                    {{ $data->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                              <div class="col-md-2">
                                                   <div class="form-group">
                                                          <label >Balance:</label>
                                                           <input type="text" class="form-control balanceBC" readonly  placeholder="">
                                                       </div>
                                                   </div>

                                            {{--  <div class="col-md-2">
                                                     <div class="form-group">
                                                         <label >C. Book No:</label>
                                                         <select class="form-control select2 " id="cheque_book_id" name="cheque_book_no[]"  >
                                                            <option value="">Select C. Book No</option>
                                                            @foreach ($checkBooks as $data)
                                                                <option style="color:#000;font-weight:600;" value="{{ $data->cheque_book_no }}">
                                                                    {{ $data->cheque_book_no }}</option>
                                                            @endforeach
                                                        </select>
                                                     </div>
                                                 </div>
                                              <div class="col-md-2 ">
                                                     <div class="form-group">
                                                         <label >C. B. Serial No:</label>
                                                         <select class="form-control select2" id="cheque_book_serial_id" style="padding: 0px 10px 10px 10;" name="cheque_book_serial_no[]" >	</select>

                                                     </div>
                                                 </div>
                                               --}}
                                                <div class="col-md-4 " >
                                                    <div class="form-group ">
                                                            <label for="">Supplier :</label>
                                                            <select class="form-control select2 dealer_id"

                                                            name="dealer_id[]"  required >
                                                            <option value="">Select Supplier</option>

                                                            @foreach ($allSuppliers as $data)
                                                                <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                    {{ $data->supplier_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-2 pl-3">
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
                            <!-- End multiple -->
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

@endsection


@push('end_js')

 <script>
        $(document).ready(function() {
          selected();

            var invoice = '';
                $.ajax({
                    url : '{{url('get/payment/invoice')}}',
                    type: "GET",
                    dataType: 'json',
                    success : function(data){

                        console.log(data);
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
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-10"> <div class="row"> <div class="col-md-4 dealer" style="display:none;"> <div class="form-group "> <select class="form-control select2 bank_id" name="bank_id[]" > <option value="">Select Bank</option> @foreach ($allBanks as $data) <option style="color:#000;font-weight:600;" value="{{ $data->bank_id }}"> {{ $data->bank_name }}</option> @endforeach </select> </div> </div> <div class="col-md-4 company" style="display:none;"> <div class="form-group "> <select class="form-control select2 " name="company_id[]" > <option value="">Select Sister Concern</option> @foreach ($allCompanies as $data) <option style="color:#000;font-weight:600;" value="{{ $data->id }}"> {{ $data->name }}</option> @endforeach </select> </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control balanceBC" readonly placeholder=""> </div> </div> {{-- <div class="col-md-2"> <div class="form-group"> <label >C. Book No:</label> <select class="form-control select2 " id="cheque_book_id" name="cheque_book_no[]" > <option value="">Select C. Book No</option> @foreach ($checkBooks as $data) <option style="color:#000;font-weight:600;" value="{{ $data->cheque_book_no }}"> {{ $data->cheque_book_no }}</option> @endforeach </select> </div> </div> <div class="col-md-2 "> <div class="form-group"> <label >C. B. Serial No:</label> <select class="form-control select2" id="cheque_book_serial_id" style="padding: 0px 10px 10px 10;" name="cheque_book_serial_no[]" > </select> </div> </div> --}} <div class="col-md-4 " > <div class="form-group "> <select class="form-control select2 dealer_id" name="dealer_id[]" required > <option value="">Select Supplier</option> @foreach ($allSuppliers as $data) <option style="color:#000;font-weight:600;" value="{{ $data->id }}"> {{ $data->supplier_name }}</option> @endforeach </select> </div> </div> <div class="col-md-2 pl-3"> <div class="form-group row"> <input type="text" name="amount[]" class="form-control amount"> </div> </div> </div> </div> <div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> <div class="col-md-1"> <label for="">Invoice :</label> <span id="invoice" class="invoiceNo"></span> </div> </div> </div> </div>';
                if(x<=12){
                    $(this).parents('.fieldGroup:last').after(fieldHTML);
                    selected();
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
                $('#total_amount').html(total_with_discount);
             }


             $('#type_id').on('change', function() {
                 selected();
             });

             function selected() {

                 var x = $('#type_id').val();
                 if (x == "dealer") {

                     var elems = document.getElementsByClassName('dealer');
                     var elems2 = document.getElementsByClassName('company');
                     for (var i = 0; i < elems.length; i += 1) {
                         elems[i].style.display = 'block';
                         elems2[i].style.display = 'none';
                     }

                 }

                 if (x == "company") {
                     var elems = document.getElementsByClassName('company');
                     var elems2 = document.getElementsByClassName('dealer');
                     for (var i = 0; i < elems.length; i += 1) {
                         elems[i].style.display = 'block';
                         elems2[i].style.display = 'none';
                     }
                 }
             }
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


      $('#field').on('change','.bank_id',function(){

                    // $('.totalvalueid').attr("value", "0");
                    var parent = $(this).closest('.fieldGroup');

                  var bankid =  parent.find('.bank_id').val();

                    console.log(bankid);

                    $.ajax({
                                url : '{{url('/get/bank/balance/')}}/'+bankid,
                                type: "GET",
                                dataType: 'json',
                                success : function(data){
                                  console.log(data);

                                 parent.find('.balanceBC').val(data);

                                }
                            });







                    })





    </script>
<script>
  $(document).ready(function() {
         $('#field').on('change','#cheque_book_id', function(){
          var parent = $(this).closest('.fieldGroup');

            var cheque_book_id =  parent.find('#cheque_book_id').val();
          //console.log(cheque_book_id);
	if(cheque_book_id){
      $.ajax({
                url: '/bank/payment/checkBookSerial/'+cheque_book_id,
                type:"GET",
                dataType:'json',
                success: function(data){
                  console.log(data);
                    var str='';
              $(data).each(function (i,v){

                  str+='<option style="color:black;font-weight:bold" value="'+v.cheque_book_serial_no+'">'+v.cheque_book_serial_no+'</option>';
              });
              $('#cheque_book_serial_id').html(str);
              $('.select2').selectpicker('refresh');
              $('.colorchange').css("color", "red");
                    }
            });
        	}
  		});
    });

</script>


@endpush
