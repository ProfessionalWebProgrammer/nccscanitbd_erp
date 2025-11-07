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
                <form class="floating-labels m-t-40" action="{{ url('/journal/entry/store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class=" col-form-label">Date:</label>
                                    <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control">
                                </div>
                                <div class="form-group col-md-8">
                                    <label class=" col-form-label">Reference:</label>
                                    <input type="text" name="reference" class="form-control" placeholder="Reference"
                                        required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class=" col-form-label">Select Dealer OR Supplier OR Others<span
                                            style="color: red">*</span>
                                    </label>
                                    <select class="form-control select" id="journal_type" name="journal_type" required>
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="vendor" >Dealer</option>
                                        <option value="supplier">Supplier</option>
                                        <option value="company">Inter Company</option>
										<option value="accured">Accrued Expenses</option>
									    <option value="rent">Others</option>
                                    </select>
                                </div>

                                {{-- <div class="form-group col-md-4" id="vendordc" style="display: none">
                                    <label class=" col-form-label">Select Debit And Credit Option <span
                                            style="color: red">*</span> </label>
                                    <select class="form-control select2 dcoption" id="vendordcs" name="dcoption" required>
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="1">Dealer Credit O D</option>
                                        <option value="2">Dealer Debit O C</option>


                                    </select>
                                </div>
                                 --}}
                                <div class="form-group col-md-4 supplierid" id="supplierdc" style="display: none">
                                    <label class=" col-form-label">Select Debit And Credit Option <span
                                            style="color: red">*</span> </label>
                                    <select class="form-control select2 dcoption" id="supplierdcs" name="dcoption" required>
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="1">Supplier Debit L C</option>
                                        <option value="2">Supplier Credit L D</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4 companyid" id="companydc" style="display: none">
                                    <label class=" col-form-label">Select Debit And Credit Option <span
                                            style="color: red">*</span> </label>
                                    <select class="form-control select2 company" id="companys" name="dcoption2" required>
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="1">Inter Company Debit L C</option>
                                        <option value="2">Inter Company Credit L D</option>
                                    </select>
                                </div>

                              <!--<div class="form-group col-md-4" id="rentdcs" style="display: none">-->
                              <!--      <label class=" col-form-label">Select Debit And Credit Option<span-->
                              <!--              style="color: red">*</span> </label>-->
                              <!--      <select class="form-control select2 dcoption" id="rentdcs" name="dcoption" required>-->
                              <!--          <option value="">Select One Must <span style="color: red">*</span></option>-->
                              <!--          <option value="5">Others Credit Account Debit</option>-->
                              <!--          <option value="6">Others Debit Account Credit</option>-->
                              <!--      </select>-->
                              <!--  </div>-->

                                <input type="hidden" name="dc_type" id="dc_type" class="form-control">

                            </div>
                            {{-- Multiple Fields --}}
                            <div class="row mt-5 noOthers">
                                <div id="field" class="col-md-12">
                                    <div class="row fieldGroup rowname">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="row">
                                                        <div class="col-md-3 vendorid" style="display: none">
                                                            <div class="form-group ">
                                                                <label class=" col-form-label"> Dealer:</label>
                                                                <select class="form-control select2 dealer_id"
                                                                    name="dealer_id[]">
                                                                    <option value="">Select Dealer</option>

                                                                    @foreach ($allDealers as $data)
                                                                        <option style="color:#000;font-weight:600;"
                                                                            value="{{ $data->id }}">
                                                                            {{ $data->d_s_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3  supplierid" style="display: none">
                                                            <div class="form-group">
                                                                <label class=" col-form-label"> Supplier:</label>
                                                                <select class="form-control select2 " name="supplier_id[]">
                                                                    <option value="">Select Supplier</option>

                                                                    @foreach ($allSuppliers as $data)
                                                                        <option style="color:#000;font-weight:600;"
                                                                            value="{{ $data->id }}">
                                                                            {{ $data->supplier_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3  companyid" style="display: none">
                                                            <div class="form-group">
                                                                <label class=" col-form-label"> Inter Company:</label>
                                                                <select class="form-control select2 " name="company_id[]">
                                                                    <option value="">Select Inter Company</option>

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
                                                                <label class=" col-form-label">Ledger:</label>
                                                              <select class="form-control select2 " name="ledger_id[]" >
                                                                    <option value="">Select Ledger </option>
                                                                    @foreach ($subgroups as $data)
                                                                        <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                            {{ $data->subgroup_name }} - {{ $data->group_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 vendorid">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">
                                                                    Sub-Ledger:</label>
                                                                <select class="form-control select2 " name="sub_ledger_id[]" >
                                                                    <option value="">Select  Sub Ledger </option>

                                                                    @foreach ($subSubGroups as $data)
                                                                        <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                           {{$data->subSubgroup_name}} - {{ $data->subgroup_name }} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 supplierid" style="display: none">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">Ledger Type:</label>
                                                                <select class="form-control select2 " name="ledger_type" id="supplierExpType"   required>
                                                                        <option value="">Select One </option>
                                                                        <option style="color:#000;font-weight:600;" value="accrued ">Accrued Expense </option>
                                                                        <option style="color:#000;font-weight:600;" value="normal"> Normal Expense </option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                       <div class="col-md-3 vendorid" style="display: none">
                                                         <div class="row">
                                                             <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Dealer Cr: <span
                                                                        class="creditchange  text-danger"></span></label>
                                                                <input type="number" name="credit[]" class="form-control dealerCredit credit"
                                                                    placeholder="Amount" step="any">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Ledger Dr: <span
                                                                        class="debitchange text-danger"></span></label>
                                                                <input type="number" name="debit[]" class="form-control ledgerDebit debit"
                                                                    placeholder="Amount" step="any">
                                                            </div>
                                                        </div>

                                                         </div>
                                                      </div>
                                                      <div class="col-md-3 supplierid" style="display: none">
                                                         <div class="row">
                                                             <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Dr: <span
                                                                        class="debitchange text-danger"></span></label>
                                                                <input type="number" name="debit[]" class="form-control supplierDebit debit"
                                                                    placeholder="Amount" step="any">
                                                            </div>
                                                        </div>
                                                             <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Cr: <span
                                                                        class="creditchange  text-danger"></span></label>
                                                                <input type="number" name="credit[]" class="form-control ledgerCredit credit"
                                                                    placeholder="Amount" step="any">
                                                            </div>
                                                        </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-3 companyid" style="display: none">
                                                         <div class="row">
                                                             <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Dr: <span
                                                                        class="debitchange text-danger"></span></label>
                                                                <input type="number" name="com_debit[]" class="form-control supplierDebit debit"
                                                                    placeholder="Amount" step="any">
                                                            </div>
                                                        </div>
                                                             <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Cr: <span
                                                                        class="creditchange  text-danger"></span></label>
                                                                <input type="number" name="com_credit[]" class="form-control ledgerCredit credit"
                                                                    placeholder="Amount" step="any">
                                                            </div>
                                                        </div>
                                                         </div>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="">Action :</label>
                                                    <a href="javascript:void(0)" style="margin-top: 3px;"
                                                        class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                            class="fas fa-plus-circle"></i></a>
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-sm custom-btn-sbms-remove remove"
                                                        style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                             {{-- Multiple Fields Others--}}
                            <div class="row mt-5  others" style="display:none;">
                                <div id="field" class="col-md-12">
                                    <div class="row fieldGroup rowname">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="row">

                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">Ledger:</label>
                                                              <select class="form-control select2 " name="ledger_id[]" >
                                                                    <option value="">Select Ledger </option>
                                                                   @foreach ($subgroups as $data)
                                                                        <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                            {{ $data->subgroup_name }} - {{ $data->group_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">Ledger Type:</label>
                                                              <select class="form-control select2 " name="exp_type_one"  id="exp_type_one" required>
                                                                        <option value="">Select One </option>
                                                                        <option style="color:#000;font-weight:600;" value="accrued ">Accrued Expense </option>
                                                                        <option style="color:#000;font-weight:600;" value="normal"> Normal Expense </option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-5 first_option">
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
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">  Ledger:</label>
                                                                <select class="form-control select2 " name="sub_ledger_id[]" >
                                                                    <option value="">Select Ledger </option>
                                                                    @foreach ($subgroups as $data)
                                                                         <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                             {{ $data->subgroup_name }} - {{ $data->group_name }}</option>
                                                                     @endforeach
                                                                    {{--  @foreach ($subSubGroups as $data)
                                                                        <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                           {{$data->subSubgroup_name}} - {{ $data->subgroup_name }} </option>
                                                                    @endforeach --}}
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">Ledger Type:</label>
                                                              <select class="form-control select2 " name="exp_type_two" id="exp_type_two" required>
                                                                        <option value="">Select One </option>
                                                                        <option style="color:#000;font-weight:600;" value="accrued ">Accrued Expense </option>
                                                                        <option style="color:#000;font-weight:600;" value="normal"> Normal Expense </option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-5 second_option">
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
                                                <!--<div class="col-md-1">-->
                                                <!--    <label for="">Action :</label>-->
                                                <!--    <a href="javascript:void(0)" style="margin-top: 3px;"-->
                                                <!--        class="btn custom-btn-sbms-add btn-sm addMore"><i-->
                                                <!--            class="fas fa-plus-circle"></i></a>-->
                                                <!--    <a href="javascript:void(0)"-->
                                                <!--        class="btn btn-sm custom-btn-sbms-remove remove"-->
                                                <!--        style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>-->
                                                <!--</div>-->
                                                <div class="col-md-2"></div>
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
                var fieldHTML =
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-3 vendorid" style="display: none"> <div class="form-group "> <select class="form-control select2 dealer_id" name="dealer_id[]"> <option value="">Select Dealer</option> @foreach ($allDealers as $data) <option style="color:#000;font-weight:600;" value="{{ $data->id }}"> {{ $data->d_s_name }}</option> @endforeach </select> </div> </div> <div class="col-md-3 supplierid" style="display: none"> <div class="form-group"> <select class="form-control select2 " name="supplier_id[]"> <option value="">Select Supplier</option> @foreach ($allSuppliers as $data) <option style="color:#000;font-weight:600;" value="{{ $data->id }}"> {{ $data->supplier_name }}</option> @endforeach </select> </div> </div> <div class="col-md-3"> <div class="form-group"> <select class="form-control select2 " name="ledger_id[]" > <option value="">Select Ledger </option> @foreach ($subgroups as $data) <option style="color:#000;font-weight:600;" value="{{ $data->id }}"> {{ $data->subgroup_name }} - {{ $data->group_name }}</option> @endforeach </select> </div> </div> <div class="col-md-3 vendorid"> <div class="form-group"> <select class="form-control select2 " name="sub_ledger_id[]" > <option value="">Select Sub Ledger </option> @foreach ($subSubGroups as $data) <option style="color:#000;font-weight:600;" value="{{ $data->id }}"> {{$data->subSubgroup_name}} - {{ $data->subgroup_name }} </option> @endforeach </select> </div> </div> <div class="col-md-3 supplierid" style="display: none"> <div class="form-group"> <select class="form-control select2 " name="ledger_type" required> <option value="">Select One </option> <option style="color:#000;font-weight:600;" value="accrued ">Accrued Expense </option> <option style="color:#000;font-weight:600;" value="normal"> Normal Expense </option> </select> </div> </div> <div class="col-md-3 vendorid" style="display: none"> <div class="row"> <div class="col-md-6"> <div class="form-group"> <input type="number" name="credit[]" class="form-control dealerCredit credit" placeholder="Amount" step="any"> </div> </div> <div class="col-md-6"> <div class="form-group"> <input type="number" name="debit[]" class="form-control ledgerDebit debit" placeholder="Amount" step="any"> </div> </div> </div> </div> <div class="col-md-3 supplierid" style="display: none"> <div class="row"> <div class="col-md-6"> <div class="form-group"> <input type="number" name="debit[]" class="form-control supplierDebit debit" placeholder="Amount" step="any"> </div> </div> <div class="col-md-6"> <div class="form-group"> <input type="number" name="credit[]" class="form-control ledgerCredit credit" placeholder="Amount" step="any"> </div> </div> </div> </div> </div> </div> <div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> <div class="col-md-2"></div> </div> </div> </div>';
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

                var x = $('#journal_type').val();

                if (x == "vendor") {

                    $('#dc_type').val(null);

                    $('#vendordc').css('display', 'block');
                    $('#supplierdc').css('display', 'none');
                    $('#supplierdcs').removeAttr('required');
                    $('#companydc').css('display', 'none');
                    $('#companys').removeAttr('required');
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
                    var elems3 = document.getElementsByClassName('companyid');
                    for (var i = 0; i < elems.length; i += 1) {
                        elems[i].style.display = 'block';
                        elems2[i].style.display = 'none';
                        elems3[i].style.display = 'none';
                       }
                }

                if (x == "supplier") {
                    $('#dc_type').val(null);

                    $('#supplierdc').css('display', 'block');
                    $('#vendordc').css('display', 'none');
                    $('#vendordcs').removeAttr('required');
                    $('#companydc').css('display', 'none');
                    $('#companys').removeAttr('required');
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
                    var elems3 = document.getElementsByClassName('companyid');

                    for (var i = 0; i < elems.length; i += 1) {
                        elems[i].style.display = 'block';
                        elems2[i].style.display = 'none';
                        elems3[i].style.display = 'none';
                    }

                }
                if (x == "company") {
                    $('#dc_type').val(null);

                    $('#companydc').css('display', 'block');
                    $('#vendordc').css('display', 'none');
                    $('#vendordcs').removeAttr('required');
                    $('#supplierdc').css('display', 'none');
                    $('#supplierdcs').removeAttr('required');
                    $('#supplierExpType').removeAttr('required');
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

                    var elems = document.getElementsByClassName('companyid');
                    var elems2 = document.getElementsByClassName('supplierid');
                    var elems3 = document.getElementsByClassName('vendorid');
                    //var elems2 = document.getElementsByClassName('vendorid');

                    for (var i = 0; i < elems.length; i += 1) {
                        elems[i].style.display = 'block';
                        elems2[i].style.display = 'none';
                        elems3[i].style.display = 'none';
                    }

                }
                //end Inter Company

              if (x == 'rent' || x == 'accured') {
                    $('#dc_type').val(null);

                  //  $('#rentdc').css('display', 'none');
                    $('#vendordc').css('display', 'none');
                    $('#vendordcs').removeAttr('required');
					          $('#supplierdc').css('display', 'none');
                    $('#supplierdcs').removeAttr('required');
                    $('#companydc').css('display', 'none');
                    $('#companys').removeAttr('required');
                    $('#supplierExpType').removeAttr('required');
                    $(".otherstype").val("2").change();

                    $(".others").addClass('d-block');
                    $(".others").removeClass('d-none');
                    $(".noOthers").addClass('d-none');
                    $(".noOthers").removeClass('d-block');

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

                    // Initial state
                    toggleFields(true);
                    toggleFields1(false);



                  //  $('.otherstype').removeAttr('required');

                    var elems = document.getElementsByClassName('supplierid');
                    var elems2 = document.getElementsByClassName('vendorid');
                    var elems3 = document.getElementsByClassName('companyid');

                    for (var i = 0; i < elems.length; i += 1) {
                        elems[i].style.display = 'none';
                        elems2[i].style.display = 'none';
                        elems3[i].style.display = 'none';

                    }


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
                $(this).closest('.rowname').find('.first_option input[name="credit[]"]').prop('readonly', true);
                $(this).closest('.rowname').find('.first_option input[name="credit[]"]').prop('disabled', true);
                $(this).closest('.rowname').find('.second_option input[name="debit[]"]').prop('readonly', true);
                $(this).closest('.rowname').find('.second_option input[name="debit[]"]').prop('disabled', true);
                $(this).closest('.rowname').find('.second_option input[name="credit[]"]').prop('readonly', true);
                $('#second_credit').val(value);
                $('#dc_type').val(6);
            });

            $('.others #field').on('keyup input', '.rowname .first_option input[name="credit[]"]', function() {

                var value = $('#first_credit').val();
                $('#other_ledger_type').val('ledger_credit');
                $(this).closest('.rowname').find('.first_option input[name="debit[]"]').prop('readonly', true);
                $(this).closest('.rowname').find('.first_option input[name="debit[]"]').prop('disabled', true);
                $(this).closest('.rowname').find('.second_option input[name="credit[]"]').prop('readonly', true);
                $(this).closest('.rowname').find('.second_option input[name="credit[]"]').prop('disabled', true);
                $(this).closest('.rowname').find('.second_option input[name="debit[]"]').prop('readonly', true);

                $('#second_debit').val(value);
                $('#dc_type').val(5);
            });

           $('.others #field').on('keyup input', '.rowname .second_option input[name="debit[]"]', function() {
                var value = $('#second_debit').val();
                $('#other_ledger_type').val('ledger_credit');
                $(this).closest('.rowname').find('.second_option input[name="credit[]"]').prop('readonly', true);
                $(this).closest('.rowname').find('.second_option input[name="credit[]"]').prop('disabled', true);
                $(this).closest('.rowname').find('.first_option input[name="debit[]"]').prop('readonly', true);
                $(this).closest('.rowname').find('.first_option input[name="debit[]"]').prop('disabled', true);
                $(this).closest('.rowname').find('.first_option input[name="credit[]"]').prop('readonly', true);

                $('#first_credit').val(value);
                $('#dc_type').val(5);
            });

            $('.others #field').on('keyup input', '.rowname .second_option input[name="credit[]"]', function() {

                var value = $('#second_credit').val();
                $('#other_ledger_type').val('ledger_debit');
                $(this).closest('.rowname').find('.second_option input[name="debit[]"]').prop('readonly', true);
                $(this).closest('.rowname').find('.second_option input[name="debit[]"]').prop('disabled', true);
                $(this).closest('.rowname').find('.first_option input[name="credit[]"]').prop('readonly', true);
                $(this).closest('.rowname').find('.first_option input[name="credit[]"]').prop('disabled', true);
                $(this).closest('.rowname').find('.first_option input[name="debit[]"]').prop('readonly', true);
                $('#first_debit').val(value);
                $('#dc_type').val(6);
            });


        });
    </script>
@endsection
