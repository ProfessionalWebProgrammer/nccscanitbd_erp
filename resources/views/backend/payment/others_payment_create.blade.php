@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="pt-3 text-center">
                    <h5 class="font-weight-bolder text-uppercase">Loan Repay</h5>
                    <hr width="33%">
                </div>
                <form class="floating-labels m-t-40" action="{{ route('others.payment.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label class=" col-form-label">Date:</label>
                                    <input type="date" value="{{ date('Y-m-d') }}" name="payment_date" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class=" col-form-label">Select Bank OR Cash <span style="color: red">*</span>
                                    </label>
                                    <select class="form-control select2" id="payment_by" name="payment_by" required>
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="bank" selected>Bank</option>
                                        <option value="cash">Cash</option>
    
    
                                    </select>
                                </div>
    
                                <div class="form-group col-md-4"></div>
    
                                <div class="form-group col-md-4">
                                    <label class=" col-form-label">Select Types <span style="color: red">*</span>
                                    </label>
                                    <select class="form-control select2" id="payment_for" name="payment_for" required>
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="loan">Loan</option>
                                        <option value="borrow">Borrow</option>
                                        <option value="lease">Lease</option>
                                        <option value="tax">Tax</option>
                                        <option value="dividend">Dividend</option>
    
    
                                    </select>
                                </div>
    
    
                                <div class="form-group col-md-4 " id="loanbankid" style="display: none">
                                    <label class=" col-form-label">Loan Bank:</label>
                                    <select class="form-control select2 bank_id" name="loan_bank_id" id="loan_bank_id">
                                        <option value="">Select Bank</option>
    
                                        @foreach ($loanBanks as $data)
                                            <option style="color:#000;font-weight:600;" value="{{ $data->bank_id }}">
                                                {{ $data->bank_name }} ({{ $data->loan_amount }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 " id="assetclient" style="display: none">
                                    <label class=" col-form-label">Clint name :</label>
                                    <select name="clint_id" id="clint_id" class="form-control select2">
                                        <option value="">== Select Clint ==</option>
                                        @foreach ($assetclint as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 " id="forborrow" style="display: none">
                                    <label class=" col-form-label">Select Borrows :</label>
                                    <select name="borrow_id" id="borrow_id" class="form-control select2">
                                        <option value="">== Select Clint ==</option>
                                        @foreach ($borrows as $item)
                                            @php
                                                
                                                $fromname = '';
                                                if ($item->from_client_id != null) {
                                                    $fromname = DB::table('asset_clints')
                                                        ->where('id', $item->from_client_id)
                                                        ->value('name');
                                                }
                                                if ($item->from_company_id != null) {
                                                    $fromname = DB::table('company_names')
                                                        ->where('id', $item->from_company_id)
                                                        ->value('name');
                                                }
                                                
                                                $toname = '';
                                                if ($item->to_client_id != null) {
                                                    $toname = DB::table('asset_clints')
                                                        ->where('id', $item->to_client_id)
                                                        ->value('name');
                                                }
                                                if ($item->to_company_id != null) {
                                                    $toname = DB::table('company_names')
                                                        ->where('id', $item->to_company_id)
                                                        ->value('name');
                                                }
                                            @endphp
    
                                            <option value="{{ $item->id }}">{{ $fromname }} --To--
                                                {{ $toname }} ({{ $item->amount }})</option>
                                        @endforeach
                                    </select>
                                </div>
    
    
                                <div class="form-group col-md-4 " id="forlease" style="display: none">
                                    <label class=" col-form-label">Lease Head :</label>
                                    <select name="lease_id" id="lease_id" class="form-control select2">
                                        <option value="">== Select Lease ==</option>
                                        @foreach ($leases as $item)
                                            <option value="{{ $item->id }}">{{ $item->head }}
                                                ({{ $item->amount }})</option>
                                        @endforeach
                                    </select>
                                </div>
    
                                <div class="form-group col-md-4 " id="inputhead" style="display: none">
                                    <label class=" col-form-label"> Head :</label>
                                    <input type="text" name="inputhead" class="form-control " placeholder="Head">
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
    
                                                        <div class="form-group col-md-4 bankid" style="display: none">
                                                            <label class=" col-form-label">Bank:</label>
                                                            <select class="form-control select2 bank_id" name="bank_id[]">
                                                                <option value="">Select Bank</option>
    
                                                                @foreach ($allBanks as $data)
                                                                    <option style="color:#000;font-weight:600;"
                                                                        value="{{ $data->bank_id }}">
                                                                        {{ $data->bank_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
    
    
                                                        <div class="form-group col-md-4 warehouseid" style="display: none">
                                                            <label class=" col-form-label">Depot/ Wirehouse:</label>
                                                            <select class="form-control select2 cash_id" name="cash_id[]">
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
    
                                                        {{-- <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class=" col-form-label"> Supplier
                                                                            :</label>
                                                                        <select class="form-control select2 "
                                                                            name="supplier_id[]" >
                                                                            <option value="">Select Supplier</option>
    
                                                                            @foreach ($allSuppliers as $data)
                                                                                <option style="color:#000;font-weight:600;"
                                                                                    value="{{ $data->id }}">
                                                                                    {{ $data->supplier_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div> --}}
    
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">Amount:
                                                                </label>
                                                                <input type="text" name="amount[]" class="form-control amount"
                                                                    required placeholder="Amount">
                                                            </div>
                                                        </div>
    
    
    
    
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="">Action :</label>
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
                                </div>
                            </div>
    
                            <div class="row ">
                                <div class="col-md-6">
    
                                </div>
                                <div class="col-md-4  mt-5 font-weight-bold">
                                    <h5>Total Amount : <span id="total_amount">/-</span></h5>
                                    <input type="hidden" name="total_amount" class="form-control total_amount"
                                        id="total_amountinput">
                                </div>
    
                            </div>
    
    
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
            //add more fields group
            $("body").on("click", ".addMore", function() {
                var fieldHTML =
                    ' <div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="form-group col-md-4 bankid" style="display: none" > <select class="form-control select2 bank_id" name="bank_id[]" ><option value="">Select Bank</option> @foreach ($allBanks as $data)<option style="color:#000;font-weight:600;" value="{{ $data->bank_id }}"> {{ $data->bank_name }}</option> @endforeach </select></div> <div class="form-group col-md-4 warehouseid" style="display: none" > <select class="form-control select2 cash_id" name="cash_id[]"  ><option value="">Select Cash</option> @foreach ($allcashs as $data)<option style="color:#000;font-weight:600;" value="{{ $data->wirehouse_id }}"> {{ $data->wirehouse_name }}</option> @endforeach </select></div><div class="col-md-2"> <div class="form-group">  <input type="number"  class="form-control balanceBC" readonly placeholder=""> </div></div> {{-- <div class="col-md-4"> <div class="form-group">  <select class="form-control select2 " name="supplier_id[]" > <option value="">Select Supplier</option> @foreach ($allSuppliers as $data) <option style="color:#000;font-weight:600;" value="{{$data->id}}">{{$data->supplier_name}}</option> @endforeach </select> </div></div> --}}<div class="col-md-2"> <div class="form-group">  <input type="number" name="amount[]" class="form-control amount" placeholder=" Amount"> </div></div></div></div><div class="col-md-1">  <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div>';
                $(this).parents('.fieldGroup:last').after(fieldHTML);

                $('.select2').select2({
                    theme: 'bootstrap4'
                })

                selected();

            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
                total();
            });


            $('#field').on('input', '.amount', function() {



                total();


            });



            $('#payment_by').on('change', function() {

                // console.log(x);

                selected();





                // console.log(x);

            });

            function total() {
                var total = 0;
                $(".amount").each(function() {
                    var totalvalueid = $(this).val() - 0;
                    total += totalvalueid;
                    $('#total_amount').html(total);
                    $('#total_amountinput').val(total);
                    // console.log(total);
                })
                $('#total_amount').html(total_with_discount);
                $('#total_amountinput').val(total_with_discount);
            }




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


            $('#field').on('change', '.bank_id', function() {

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');

                var bankid = parent.find('.bank_id').val();

                console.log(bankid);

                $.ajax({
                    url: '{{ url('/get/bank/balance/') }}/' + bankid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);

                        parent.find('.balanceBC').val(data);

                    }
                });







            })


            $('#field').on('change', '.cash_id', function() {

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');
                var warehouseid = parent.find('.cash_id').val();


                $.ajax({
                    url: '{{ url('/get/cash/balance/') }}/' + warehouseid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);



                        parent.find('.balanceBC').val(data);

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







            $('#payment_for').on('change', function() {

                var x = $(this).val();

                if (x == "loan") {

                    var elems = $('#loanbankid').css('display', 'block');
                    var elems2 = $('#assetclient').css('display', 'none');
                    var elems3 = $('#forlease').css('display', 'none');
                    var elems4 = $('#forborrow').css('display', 'none');
                    var elems5 = $('#inputhead').css('display', 'none');

                    $('#loan_bank_id').attr("required", true);


                    $('#lease_id').removeAttr('required');
                    $('#clint_id').removeAttr('required');







                }
                if (x == "borrow") {


                    var elems = $('#loanbankid').css('display', 'none');
                    var elems2 = $('#assetclient').css('display', 'none');
                    var elems3 = $('#forlease').css('display', 'none');
                    var elems4 = $('#forborrow').css('display', 'block');
                    var elems5 = $('#inputhead').css('display', 'none');

                    $('#borrow_id').attr("required", true);

                    $('#loan_bank_id').removeAttr('required');
                    $('#lease_id').removeAttr('required');
                    $('#clint_id').removeAttr('required');





                }
                if (x == "lease") {


                    var elems = $('#loanbankid').css('display', 'none');
                    var elems2 = $('#assetclient').css('display', 'block');
                    var elems3 = $('#forlease').css('display', 'block');
                    var elems4 = $('#forborrow').css('display', 'none');
                    var elems5 = $('#inputhead').css('display', 'none');

                    $('#lease_id').attr("required", true);
                    $('#clint_id').attr("required", true);

                    $('#borrow_id').removeAttr('required');
                    $('#loan_bank_id').removeAttr('required');






                }
                if (x == "") {


                    var elems = $('#loanbankid').css('display', 'none');
                    var elems2 = $('#assetclient').css('display', 'none');

                    var elems3 = $('#forlease').css('display', 'none');
                    var elems4 = $('#forborrow').css('display', 'none');
                    var elems5 = $('#inputhead').css('display', 'none');



                }
                if (x == "tax" || x == "dividend") {


                    var elems = $('#loanbankid').css('display', 'none');
                    var elems2 = $('#assetclient').css('display', 'none');

                    var elems3 = $('#forlease').css('display', 'none');
                    var elems4 = $('#forborrow').css('display', 'none');

                    var elems5 = $('#inputhead').css('display', 'block');




                }

            });





        });
    </script>

@endpush
