-@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="pt-3 text-center">
                    <h5 class="font-weight-bolder text-uppercase">Journal Entry</h5>
                    <hr width="33%">
                </div>
                <form class="floating-labels m-t-40" action="{{ url('/normalJournal/entry/store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class=" col-form-label">Date:</label>
                                    <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control">
                                </div>
                                <div class="form-group col-md-8">
                                    <label class=" col-form-label">Reference:</label>
                                    <input type="text" name="reference" class="form-control" placeholder="Reference"
                                        required>
                                </div>
                            </div>

                             {{-- Multiple Fields Others--}}
                            <div class="row mt-5  others" >
                                <div id="field" class="col-md-12">
                                    <div class="row fieldGroup rowname">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">First Ledger:</label>
                                                              <select class="form-control select2 " name="ledger_id1[]" >
                                                                    <option value="">Select 1st Ledger </option>
                                                                   @foreach ($ledgerInfo as $data)
                                                                        <option style="color:#000;font-weight:600;" value="{{ $data['title'] }}">
                                                                            {{ $data['title'] }} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                      {{--  <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">Ledger Type:</label>
                                                              <select class="form-control select2 " name="exp_type_one"  id="exp_type_one" required>
                                                                        <option value="">Select One </option>
                                                                        <option style="color:#000;font-weight:600;" value="accrued ">Accrued Expense </option>
                                                                        <option style="color:#000;font-weight:600;" value="normal"> Normal Expense </option>

                                                                </select>
                                                            </div>
                                                        </div> --}}

                                                        <div class="col-md-6 first_option">
                                                                 <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Dr: <span
                                                                                    class="debitchange text-danger"></span></label>
                                                                            <input type="number" name="debit[]" class="form-control"
                                                                                placeholder="Amount" min="0" step="any" id="first_debit">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Cr: <span
                                                                                    class="creditchange  text-danger"></span></label>
                                                                            <input type="number" name="credit[]" min="0" class="form-control"
                                                                                placeholder="Amount" step="any" id="first_credit">
                                                                        </div>
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                          <input type="hidden" name="ledgerType" id="other_ledger_type">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class=" col-form-label"> Second Ledger:</label>
                                                                <select class="form-control select2 " name="ledger_id2[]" >
                                                                    <option value="">Select 2nd Ledger </option>
                                                                    @foreach ($ledgerInfo as $data)
                                                                         <option style="color:#000;font-weight:600;" value="{{ $data['title'] }}">
                                                                             {{ $data['title'] }} </option>
                                                                     @endforeach

                                                                </select>
                                                            </div>
                                                        </div>
                                                    {{--    <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">Ledger Type:</label>
                                                              <select class="form-control select2 " name="exp_type_two" id="exp_type_two" required>
                                                                        <option value="">Select One </option>
                                                                        <option style="color:#000;font-weight:600;" value="accrued ">Accrued Expense </option>
                                                                        <option style="color:#000;font-weight:600;" value="normal"> Normal Expense </option>

                                                                </select>
                                                            </div>
                                                        </div> --}}

                                                        <div class="col-md-6 second_option">
                                                         <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Dr: <span
                                                                        class="debitchange text-danger"></span></label>
                                                                <input type="number" name="debit[]" class="form-control"
                                                                    placeholder="Amount" step="any" min="0" id="second_debit">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Cr: <span
                                                                        class="creditchange  text-danger"></span></label>
                                                                <input type="number" id="second_credit" name="credit[]" class="form-control"
                                                                    placeholder="Amount" step="any" min="0">
                                                            </div>
                                                        </div>
                                                         </div>
                                                      </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
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
    <script>
        $(document).ready(function() {
          $('#rentdc').css('display', 'none');
          $('#rentdcs').removeAttr('required');

            selected();

            //add more fields group
            $("body").on("click", ".addMore", function() {
                      var fieldHTML = '';
                      $(this).parents('.fieldGroup:last').after(fieldHTML);


                selected();

                $('.select2').select2({
                    theme: 'bootstrap4'
                })




            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
            });

            $('#journal_type').on('change', function() {

                // console.log(x);
                selected();
                // console.log(x);

            });


            function selected() {
            /*  $('#vendordc').css('display', 'none');
              $('#vendordcs').removeAttr('required');
              $('#supplierdc').css('display', 'none');
              $('#supplierdcs').removeAttr('required');
              $('#supplierExpType').removeAttr('required');
              $(".otherstype").val("2").change();

              $(".others").addClass('d-block');
              $(".others").removeClass('d-none');
              $(".noOthers").addClass('d-none');
              $(".noOthers").removeClass('d-block'); */

              function toggleFields(disable) {
                  $('.noOthers #field .rowname select[name="ledger_id[]"]').prop('disabled', disable);
                  $('.noOthers #field .rowname select[name="sub_ledger_id[]"]').prop('disabled', disable);
                  $('.noOthers #field .rowname input[name="debit[]"]').prop('disabled', disable);
                  $('.noOthers #field .rowname input[name="credit[]"]').prop('disabled', disable);
              }

              function toggleFields1(disable) {
                  $('.others #field .rowname select[name="ledger_id[]"]').prop('disabled', disable);
                  $('.others #field .rowname select[name="sub_ledger_id[]"]').prop('disabled', disable);
                  $('.others #field .rowname input[name="debit[]"]').prop('disabled', disable);
                  $('.others #field .rowname input[name="credit[]"]').prop('disabled', disable);
              }

              toggleFields(true);
              toggleFields1(false);


              var elems = document.getElementsByClassName('supplierid');
              var elems2 = document.getElementsByClassName('vendorid');

              for (var i = 0; i < elems.length; i += 1) {
                  elems[i].style.display = 'none';
                  elems2[i].style.display = 'none';

              }
              for (var i = 0; i < elems2.length; i += 1) {
                  elems[i].style.display = 'none';
                  elems2[i].style.display = 'none';

              }


                var x = $('#journal_type').val();

                if (x == "vendor") {

                    $('#dc_type').val(null);

                    $('#vendordc').css('display', 'block');
                    $('#supplierdc').css('display', 'none');
                    $('#supplierdcs').removeAttr('required');
					$('#rentdc').css('display', 'none');
                    $('#rentdcs').removeAttr('required');
                    $('#supplierExpType').removeAttr('required');
                    $('#exp_type_one').removeAttr('required');
                    $('#exp_type_two').removeAttr('required');

                    $(".otherstype").val("").change();
                    $(".others").addClass('d-none');
                    $(".others").removeClass('d-block');
                    $(".noOthers").addClass('d-block');
                    $(".noOthers").removeClass('d-none');

                     function toggleFields(disable) {
                        $('.noOthers #field .rowname .dealerCredit').prop('disabled', disable);
                        $('.noOthers #field .rowname .ledgerDebit').prop('disabled', disable);

                        $('.noOthers #field .rowname select[name="ledger_id[]"]').prop('disabled', disable);
                        $('.noOthers #field .rowname select[name="sub_ledger_id[]"]').prop('disabled', disable);
                        $('.noOthers #field .rowname input[name="debit[]"]').prop('disabled', disable);
                        $('.noOthers #field .rowname input[name="credit[]"]').prop('disabled', disable);
                    }

                    function toggleFields1(disable) {
                        $('.noOthers #field .rowname .supplierDebit').prop('disabled', disable);
                        $('.noOthers #field .rowname .ledgerCredit').prop('disabled', disable);

                        $('.others #field .rowname select[name="ledger_id[]"]').prop('disabled', disable);
                        $('.others #field .rowname select[name="sub_ledger_id[]"]').prop('disabled', disable);
                        $('.others #field .rowname input[name="debit[]"]').prop('disabled', disable);
                        $('.others #field .rowname input[name="credit[]"]').prop('disabled', disable);
                    }

                    // Initial state
                    toggleFields(false);
                    toggleFields1(true);


                    var elems = document.getElementsByClassName('vendorid');
                    var elems2 = document.getElementsByClassName('supplierid');

                    for (var i = 0; i < elems.length; i += 1) {
                        elems[i].style.display = 'block';
                        elems2[i].style.display = 'none';
                       }




                }
                if (x == "supplier") {
                    $('#dc_type').val(null);

                    $('#supplierdc').css('display', 'block');
                    $('#vendordc').css('display', 'none');
                    $('#vendordcs').removeAttr('required');
                    $('#exp_type_one').removeAttr('required');
                    $('#exp_type_two').removeAttr('required');
					          $('#rentdc').css('display', 'none');
                    $('#rentdcs').removeAttr('required');
                    $(".otherstype").val("2").change();
                   $(".others").addClass('d-none');
                    $(".others").removeClass('d-block');
                    $(".noOthers").addClass('d-block');
                    $(".noOthers").removeClass('d-none');

                  function toggleFields(disable) {

                        $('.noOthers #field .rowname .supplierDebit').prop('disabled', disable);
                        $('.noOthers #field .rowname .ledgerCredit').prop('disabled', disable);


                        $('.noOthers #field .rowname select[name="ledger_id[]"]').prop('disabled', disable);
                        $('.noOthers #field .rowname select[name="sub_ledger_id[]"]').prop('disabled', disable);
                        $('.noOthers #field .rowname input[name="debit[]"]').prop('disabled', disable);
                        $('.noOthers #field .rowname input[name="credit[]"]').prop('disabled', disable);
                    }

                    function toggleFields1(disable) {
                        $('.noOthers #field .rowname .dealerCredit').prop('disabled', disable);
                        $('.noOthers #field .rowname .ledgerDebit').prop('disabled', disable);


                        $('.others #field .rowname select[name="ledger_id[]"]').prop('disabled', disable);
                        $('.others #field .rowname select[name="sub_ledger_id[]"]').prop('disabled', disable);
                        $('.others #field .rowname input[name="debit[]"]').prop('disabled', disable);
                        $('.others #field .rowname input[name="credit[]"]').prop('disabled', disable);
                    }

                    // Initial state
                    toggleFields(false);
                    toggleFields1(true);


                  //  $('.otherstype').removeAttr('required');

                    var elems = document.getElementsByClassName('supplierid');
                    var elems2 = document.getElementsByClassName('vendorid');

                    for (var i = 0; i < elems.length; i += 1) {
                        elems[i].style.display = 'block';
                        elems2[i].style.display = 'none';
                    }

                }

              if (x == 'rent' || x == 'accured') {
                    $('#dc_type').val(null);

                  //  $('#rentdc').css('display', 'none');


                }

            }


           /* $('.dcoption').on('change', function() {

                var val = $(this).val();
                $('#dc_type').val(val);

            });
            */
             $('#field').on('input','.credit',function(){


                var parent = $(this).closest('.fieldGroup');

                var total = parent.find('.credit').val();
   				// alert(total);

                // parent.find('.debit').val(total);
                // parent.find('.debit').prop('readonly', true);
           });




            $('.others #field').on('keyup input', '.rowname .first_option input[name="debit[]"]', function() {
                var value = $('#first_debit').val();
                $('#other_ledger_type').val('ledger_debit');
               
                $(this).closest('.rowname').find('.first_option input[name="credit[]"]').prop('disabled', true);
               
                $(this).closest('.rowname').find('.second_option input[name="debit[]"]').prop('disabled', true);
          
                $('#second_credit').val(value);
                $('#dc_type').val(6);
            });

            $('.others #field').on('keyup input', '.rowname .first_option input[name="credit[]"]', function() {

                var value = $('#first_credit').val();
                $('#other_ledger_type').val('ledger_credit');
               
                $(this).closest('.rowname').find('.first_option input[name="debit[]"]').prop('disabled', true);
                
                $(this).closest('.rowname').find('.second_option input[name="credit[]"]').prop('disabled', true);
                 

                $('#second_debit').val(value);
                $('#dc_type').val(5);
            });

           $('.others #field').on('keyup input', '.rowname .second_option input[name="debit[]"]', function() {
                var value = $('#second_debit').val();
                $('#other_ledger_type').val('ledger_credit');
              
                $(this).closest('.rowname').find('.second_option input[name="credit[]"]').prop('disabled', true);
              
                $(this).closest('.rowname').find('.first_option input[name="debit[]"]').prop('disabled', true);
               

                $('#first_credit').val(value);
                $('#dc_type').val(5);
            });

            $('.others #field').on('keyup input', '.rowname .second_option input[name="credit[]"]', function() {

                var value = $('#second_credit').val();
                $('#other_ledger_type').val('ledger_debit');
               
                $(this).closest('.rowname').find('.second_option input[name="debit[]"]').prop('disabled', true);
               
                $(this).closest('.rowname').find('.first_option input[name="credit[]"]').prop('disabled', true);
               
                $('#first_debit').val(value);
                $('#dc_type').val(6);
            });


        });
    </script>
@endsection
