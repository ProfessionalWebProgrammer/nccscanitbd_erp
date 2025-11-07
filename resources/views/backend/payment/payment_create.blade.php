@extends('layouts.account_dashboard')

@section('header_menu')
    <li class="nav-item d-none d-sm-inline-block">
    </li>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">

                <div class="row pt-3">
                    <div class="col-md-6 text-left">
                        <a href="{{ URL('/expanse/payment/create') }}" class=" btn btn-success mr-2"> Expanse Payment</a>
                    </div>
                    <div class="col-md-6 text-right">

                    </div>
                </div>
                <div class="pt-3 text-center">
                    <h5 class="font-weight-bolder text-uppercase">Payment Create Form</h5>
                    <hr width="33%">
                </div>
                <form class="floating-labels m-t-40" action="{{ route('all.payment.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-2">
                                        <label class=" col-form-label">Date:</label>
                                        <input type="date" value="{{ date('Y-m-d') }}" name="payment_date"  class="form-control">
                                    </div>
                                </div>
                                
                                
                                <div class="form-group col-md-2">
                                    <label class=" col-form-label">Type  <span style="color: red">*</span>
                                    </label>
                                      <select class="form-control select2 " id="type" name="type" required>
                                        <option value="">Select Product Type</option>
                                        <option style="color:#000;font-weight:500;" value="1"> Finish Goods</option>
                                        <option style="color:#000;font-weight:500;" value="2"> Raw Materials</option>
                                        <option style="color:#000;font-weight:500;" value="3"> Sister Concern</option>
                                    </select>
                                </div>
                                
                                                        
                            </div>
                            {{-- Multiple Fields --}}
                            <div class="row mt-5">
                                <div id="field" class="col-md-12">
                                    <div class="row fieldGroup rowname">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="row">
                                                        
                                                        <div class="col-md-3 supplier" style="display: none">
                                                            <div class="form-group">
                                                                <label class=" col-form-label"> Supplier: (Dr)</label>
                                                                <select class="form-control select2 supplier_id " name="supplier_id[]">
                                                                    <option value="">Select Supplier</option>
                        
                                                                    @foreach ($allSuppliers as $data)
                                                                        <option style="color:#000;font-weight:600;"
                                                                            value="{{ $data->id }}">
                                                                            {{ $data->supplier_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 interCompany" style="display: none">
                                                            <div class="form-group">
                                                                <label class=" col-form-label"> Sister Concern: (Dr)</label>
                                                                <select class="form-control select2 " name="company_id[]">
                                                                    <option value="">Select Sister Concern</option>
                                                                    @foreach ($interCompany as $data)
                                                                        <option style="color:#000;font-weight:600;"
                                                                            value="{{ $data->id }}">
                                                                            {{ $data->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                      <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">S Balance:
                                                                </label>
                                                                <input type="text" class="form-control balanceS" readonly
                                                                    placeholder="">
                                                            </div>
                                                        </div>
                                                      <div class="col-md-3 vatTax" >
                                                            <div class="form-group">
                                                                <label class=" col-form-label">Vat/Tax:
                                                                </label>
                                                                <input type="text" class="form-control vat_tax" name="vat_tax[]" placeholder="Vat/Tax">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">Amount:
                                                                </label>
                                                                <input type="text" name="amount[]" class="form-control amount"
                                                                    required placeholder="Amount">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1 tds" >
                                                              <div class="form-group">
                                                                  <label class=" col-form-label">TDS:
                                                                  </label>
                                                                  <input type="text" class="form-control tds-val" name="tds[]" placeholder="TDS Payable">
                                                              </div>
                                                          </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="">Action :</label><br>
                                                    <a href="javascript:void(0)" style="margin-top: 8px;"
                                                        class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                            class="fas fa-plus-circle"></i></a>
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-sm custom-btn-sbms-remove remove"
                                                        style="margin-top: 8px;"><i class="fas  fa-minus-circle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end -->
                                </div>
                            </div>
							<div class="row ">
							    <div class="form-group col-md-3">
                                    <label class=" col-form-label">Narration:</label>
                                    <input type="text" name="payment_description" class="form-control"  placeholder="Narration ">
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label class=" col-form-label">Select Bank OR Cash: (Cr) <span style="color: red">*</span>
                                    </label>
                                    <select class="form-control select2" id="payment_by" name="payment_by" required>
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="bank" selected>Bank</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-2 bankid" style="display: none">
                                    <label class=" col-form-label">Bank: (Cr)</label>
                                    <select class="form-control select2 bank_id" name="bank_id[]" id="bankId">
                                        <option value="">Select Bank: </option>

                                        @foreach ($allBanks as $data)
                                            <option style="color:#000;font-weight:600;"
                                                value="{{ $data->bank_id }}">
                                                {{ $data->bank_name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group col-md-2 warehouseid" style="display: none">
                                    <label class=" col-form-label">Depot/ Wirehouse: (Cr)</label>
                                    <select class="form-control select2 cash_id" name="cash_id[]" id="cashId">
                                        <option value="">Select Cash</option>

                                        @foreach ($allcashs as $data)
                                            <option style="color:#000;font-weight:600;"
                                                value="{{ $data->wirehouse_id }}">
                                                {{ $data->wirehouse_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class=" col-form-label">Balance:
                                        </label>
                                        <input type="text" class="form-control balanceBC" readonly
                                            placeholder="">
                                    </div>
                                </div>
                                
                                <div class="col-md-3  mt-5 font-weight-bold">
                                    <h5>Total Amount : <span id="total_amount"></span>/-</h5>
                                </div>
                            </div><!--/.row-->
                            
                            <div class="row pb-5">
                                <div class="col-md-6 mt-5">
                                    <div class="text-right">
                                        <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    


@endsection


@push('end_js')
    <script>
        $(document).ready(function() {

            selected();
            interCompany();
            //add more fields group
            $("body").on("click", ".addMore", function() {
                var fieldHTML =
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row">  <div class="col-md-3 interCompany" style="display: none"><div class="form-group"><select class="form-control select2 " name="company_id[]"><option value="">Select Sister Concern</option>@foreach ($interCompany as $data) <option style="color:#000;font-weight:600;" value="{{ $data->id }}">{{ $data->name }}</option>@endforeach</select></div></div> <div class="col-md-3 supplier" style="display: none"><div class="form-group"><select class="form-control select2 supplier_id " name="supplier_id[]"><option value="">Select Supplier</option>@foreach ($allSuppliers as $data)<option style="color:#000;font-weight:600;" value="{{ $data->id }}">{{ $data->supplier_name }}</option>@endforeach</select></div></div> <div class="col-md-3"> <div class="form-group"> <input type="text" class="form-control balanceS" readonly placeholder=""> </div> </div> <div class="col-md-3 vatTax" style="display:none;" > <div class="form-group"> <input type="text" class="form-control vat_tax" name="vat_tax[]" placeholder="Vat/Tax"> </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="text" name="amount[]" class="form-control amount" required placeholder="Amount"> </div> </div> <div class="col-md-1 tds" style="display:none;"> <div class="form-group"> <input type="text" class="form-control tds-val" name="tds[]" placeholder="TDS Payable"> </div> </div> </div> </div> <div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 8px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 8px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> </div> ';
                    $(this).parents('.fieldGroup:last').after(fieldHTML);

                $('.select2').select2({
                    theme: 'bootstrap4'
                })

                selected();
                interCompany();
            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
            });


			 $('#field').on('input','.amount,.vat_tax,.tds',function(){
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
              $(".vat_tax").each(function(){
                    var charge = $(this).val()-0;
                    total += charge;
                    $('#total_amount').html(total);
                    // console.log(total);
                })
              $(".tds-val").each(function(){
                    var tds = $(this).val()-0;
                    total -= tds;
                    $('#total_amount').html(total);
                    // console.log(total);
                })

                $('#total_amount').html(total_with_discount);
             }



            $('#payment_by').on('change', function() {
                // console.log(x);
                selected();
                // console.log(x);
            });

            function selected() {

                var x = $('#payment_by').val();

                if (x == "bank") {

                    var elems = document.getElementsByClassName('bankid');
                    var elems2 = document.getElementsByClassName('warehouseid');
                    for (var i = 0; i < elems.length; i += 1) {
                        elems[i].style.display = 'block';
                        elems2[i].style.display = 'none';
                    }

                }
                if (x == "cash") {


                    var elems = document.getElementsByClassName('warehouseid');
                    var elems2 = document.getElementsByClassName('bankid');
                    for (var i = 0; i < elems.length; i += 1) {
                        elems[i].style.display = 'block';
                        elems2[i].style.display = 'none';
                    }

                }
            }

            $('#type').on('change', function() {
              interCompany();
            });

            function interCompany (){
              var x = $('#type').val();
              if (x == 3) {
                  var elems = document.getElementsByClassName('interCompany');
                  var elems2 = document.getElementsByClassName('supplier');
                  var elems3 = document.getElementsByClassName('vatTax');
                  var elems4 = document.getElementsByClassName('tds');

                  for (var i = 0; i < elems.length; i += 1) {
                      elems[i].style.display = 'block';
                      elems2[i].style.display = 'none';
                      elems3[i].style.display = 'none';
                      elems4[i].style.display = 'none';
                  }

              }
              if (x != 3) {
                  
                var elems = document.getElementsByClassName('interCompany');
                var elems2 = document.getElementsByClassName('supplier');
                var elems3 = document.getElementsByClassName('vatTax');
                var elems4 = document.getElementsByClassName('tds');

                for (var i = 0; i < elems2.length; i += 1) {
                    elems2[i].style.display = 'block';
                    elems3[i].style.display = 'block';
                    elems4[i].style.display = 'block';
                    elems[i].style.display = 'none';
                }
              }
            }

            $(document.body).on('change', '.bank_id', function() {

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');

                var bankid = $(this).val();
                /*alert(bankid);
                console.log(bankid);
                */

                $.ajax({
                    url: '{{ url('/get/bank/balance/') }}/' + bankid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                       if(data > 1)
                       {
                         $('.balanceBC').val(data);
                       } else {
                         alert("Sorry! Don`t enough Balance in this account.");
                       }
                    }
                });

            })


            $('#field').on('change', '.cash_id', function() {

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');
                var warehouseid = parent.find('.cash_id').val();

                if(warehouseid == 47){
                  $.ajax({
                      url: '{{ url('/get/cash/balance/') }}/' + warehouseid,
                      type: "GET",
                      dataType: 'json',
                      success: function(data) {
                         // console.log(data);
                           parent.find('.balanceBC').val(data);
                      }
                  });
                } else {
                $.ajax({
                    url: '{{ url('/get/cash/balance/') }}/' + warehouseid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                       // console.log(data);
                       if(data > 1)
                       {
                         parent.find('.balanceBC').val(data);
                       } else {
                         alert("Sorry! Don`t enough Balance in this account.");
                       }
                    }
                });
              }
            });

           $('#field').on('change', '.supplier_id', function() {



         var parent = $(this).closest('.fieldGroup');
                var supplier_id = parent.find('.supplier_id').val();


                $.ajax({
                    url: '{{ url('/supplier/get/balance') }}/' + supplier_id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                       // console.log(data);
                        parent.find('.balanceS').val(data);
                    }
                });

            })

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

@endpush
