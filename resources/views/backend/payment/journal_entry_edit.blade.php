@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
     <div class="content px-4 ">
       <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
            <div class="pt-3 text-center">
                <h5 class="font-weight-bolder text-uppercase">Journal Entry Edit</h5>
                <hr width="33%">
            </div>
            <form class="floating-labels m-t-40" action="{{url('/journal/entry/update')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class=" col-form-label">Date:</label>
                                        <input type="date" value="{{ $jedata->date }}" name="date"
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class=" col-form-label">Reference:</label>
                                        <input type="text" name="reference" class="form-control" value="{{ $jedata->subject }}" placeholder="Reference" required>
                                    </div>
                                  <div class="form-group col-md-4">
                                    <label class=" col-form-label">Select Dealer OR Supplier OR Depo Rent<span
                                            style="color: red">*</span>
                                    </label>
                                    <select class="form-control select2" id="journal_type" name="journal_type" required>
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="vendor" @if ($jedata->vendor_id != null) selected @endif>Dealer</option>
                                        <option value="supplier" @if ($jedata->supplier_id != null) selected @endif>Supplier</option>
                                        <option value="rent" @if ($jedata->supplier_id == null && $jedata->vendor_id == null) selected @endif>Others</option>

                                    </select>
                                </div>

                                <div class="form-group col-md-4" id="vendordc" style="display: none">
                                    <label class=" col-form-label">Select Dr And Cr Option <span
                                            style="color: red">*</span> </label>
                                    <select class="form-control select2 dcoption" id="vendordcs" name="dcoption" required>
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="1" @if ($jedata->dc_type == 1) selected @endif>Dealer Credit O D</option>
                                        <option value="2" @if ($jedata->dc_type == 2) selected @endif>Dealer Debit O C</option>


                                    </select>
                                </div>

                                <div class="form-group col-md-4" id="supplierdc" style="display: none">
                                    <label class=" col-form-label">Select Dr And Cr Option <span
                                            style="color: red">*</span> </label>
                                    <select class="form-control select2 dcoption" id="supplierdcs" name="dcoption" required>
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="3" @if ($jedata->dc_type == 3) selected @endif>Supplier Debit P C</option>
                                        <option value="4" @if ($jedata->dc_type == 4) selected @endif>Supplier Credit P D</option>



                                    </select>
                                </div>
                                <div class="form-group col-md-4" id="rentdc" style="display: none">
                                    <label class=" col-form-label">Select Dr And Cr Option <span
                                            style="color: red">*</span> </label>
                                    <select class="form-control select2 dcoption" id="rentdcs" name="dcoption" required>
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="5" @if ($jedata->dc_type == 5) selected @endif>Others Credit Account Debit</option>
                                        <option value="6" @if ($jedata->dc_type == 6) selected @endif>Others Debit Account Credit</option>


                                    </select>
                                </div>

                                </div>
                                <input type="hidden" name="id" value="{{ $jedata->id }}">
                                {{-- Multiple Fields --}}
                                <div class="row mt-5">
                                    <div id="field" class="col-md-12">
                                        <div class="row fieldGroup rowname">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            @if ($jedata->vendor_id != null)

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Dealer:</label>
                                                                    <select class="form-control select2 dealer_id" 
                                        
                                                                    name="dealer_id"  >
                                                                    <option value="">Select Dealer</option>
                            
                                                                    @foreach ($allDealers as $data)
                                                                        <option style="color:#000;font-weight:600;" value="{{ $data->id }}"
                                                                            @if ($jedata->vendor_id == $data->id ) selected @endif>
                                                                            {{ $data->d_s_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                </div>
                                                            </div>
                                                            
                                                                
                                                            @endif
                                                            @if ($jedata->supplier_id != null)
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Supplier:</label>
                                                                    <select class="form-control select2 " 
                                        
                                                                    name="supplier_id"  >
                                                                    <option value="">Select Supplier</option>
                            
                                                                    @foreach ($allSuppliers as $data)
                                                                        <option style="color:#000;font-weight:600;" value="{{ $data->id }}"
                                                                            @if ($jedata->supplier_id == $data->id ) selected @endif>
                                                                            {{ $data->supplier_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                </div>
                                                            </div>

                                                            @endif
                                                          
                                                            <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">Ledger:</label>
                                                              <select class="form-control select2 " name="ledger_id" >
                                                                    <option value="">Select Ledger </option>
                                                                    @foreach ($subgroups as $data)
                                                                        <option style="color:#000;font-weight:600;" value="{{ $data->id }}" @if ($jedata->ledger_id == $data->id ) selected @endif>
                                                                            {{ $data->subgroup_name }} - {{ $data->group_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">
                                                                    Ledger:</label>
                                                                <select class="form-control select2 " name="sub_ledger_id" >
                                                                    <option value="">Select Ledger </option>

                                                                    @foreach ($subSubGroups as $data)
                                                                        <option style="color:#000;font-weight:600;" value="{{ $data->id }}" @if ($jedata->sub_ledger_id == $data->id ) selected @endif>
                                                                           {{ $data->subgroup_name }} - {{ $data->group_name }} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                       <div class="col-md-3">
                                                         <div class="row">
                                                            <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Dr: <span
                                                                        class="debitchange text-danger"></span></label>
                                                                <input type="number" name="debit" class="form-control"
                                                                   value="{{ $jedata->debit }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Cr: <span
                                                                        class="creditchange  text-danger"></span></label>
                                                                <input type="number" name="credit" class="form-control"
                                                                    value="{{ $jedata->credit }}">
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
                            </div>

                            
                  
                        </div>
         					<div class="row pb-5">
                                <div class="col-md-6 mt-5">
                                    <div class="text-right">
                                        <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                                    </div>
                                </div>
                            </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
          
        });
    </script>
          <script>
        $(document).ready(function() {


            selected();

            //add more fields group
            $("body").on("click", ".addMore", function() {
                var fieldHTML =
                   '';
                    $(this).parents('.fieldGroup:last').after(fieldHTML);

                $('.select2').select2({
                    theme: 'bootstrap4'
                })

                selected();


            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
            });

            $('#journal_type').on('change', function() {

                // console.log(x);

                selected();

            });



            function selected() {

                var x = $('#journal_type').val();

                if (x == "vendor") {

                    $('#dc_type').val(null);
						
                    $('#vendordc').css('display', 'block');
                    $('#supplierdc').css('display', 'none');
                    $('#supplierdcs').removeAttr('required');
					$('#rentdc').css('display', 'none');
                    $('#rentdcs').removeAttr('required');
				
                    $(".otherstype").val("").change();




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
					$('#rentdc').css('display', 'none');
                    $('#rentdcs').removeAttr('required');
                  $(".otherstype").val("2").change();
                 
                  
                  
                  //  $('.otherstype').removeAttr('required');

                    var elems = document.getElementsByClassName('supplierid');
                    var elems2 = document.getElementsByClassName('vendorid');
                
                    for (var i = 0; i < elems.length; i += 1) {
                        elems[i].style.display = 'block';
                        elems2[i].style.display = 'none';

                


                    }

                }
              
              if (x == "rent") {
                    $('#dc_type').val(null);
					
                    $('#rentdc').css('display', 'block');
                    $('#vendordc').css('display', 'none');
                    $('#vendordcs').removeAttr('required');
					 $('#supplierdc').css('display', 'none');
                    $('#supplierdcs').removeAttr('required');
                  $(".otherstype").val("2").change();
                 
                  
                  
                  //  $('.otherstype').removeAttr('required');

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

                }
              
            }


            $('.dcoption').on('change', function() {

                var val = $(this).val();

                $('#dc_type').val(val);

            });


        });
    </script>
@endsection
