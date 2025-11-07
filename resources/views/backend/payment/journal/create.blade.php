@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="pt-3 text-center">
                    <h5 class="font-weight-bolder text-uppercase">Others Journal Entry</h5>
                    <hr width="33%">
                </div>
                <form class="floating-labels m-t-40" action="{{ route('otherJournal.entry.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class=" col-form-label">Date:</label>
                                    <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control">
                                </div>
                                <div class="form-group col-md-9">
                                    <label class=" col-form-label">Naration:</label>
                                    <input type="text" name="reference" class="form-control" placeholder="Reference"
                                        required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class=" col-form-label">Select Asset OR Expance <span
                                            style="color: red">*</span>
                                    </label>
                                    <select class="form-control select2" id="journal_type" name="journal_type" required>
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="vendor" selected>Assests</option>
                                        <option value="supplier">Expense</option>


                                    </select>
                                </div>
								<div class="col-md-8" id="vendordc" style="display: none">
                                 <div class="row">
                                <div class="form-group col-md-6" >
                                    <label class=" col-form-label">Asset Type : <span
                                            style="color: red">*</span> </label>
                                    <select name="asset_type" class="form-control select2 " >
                                            <option value="">== Select Type ==</option>
                                               @foreach ($assettype as $item)
                                                <option value="{{ $item->id }}" @if ($item->id == 1) selected @endif>
                                                    {{ $item->asset_type_name }}
                                                </option>
                                              @endforeach
                                   </select>
                                </div>
                                  <div class="form-group col-md-6" >
                                    <label class=" col-form-label">Asset Category: <span
                                            style="color: red">*</span> </label>
                                    <select name="category_id" id="category_id" class="form-control select2 " >
                                            <option value="">== Select Category ==</option>
                                               @foreach ($assetcat as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                   </select>
                                </div>
                                </div>
								</div> 
                              {{-- ========end vendordc======== --}}
                              <div class="col-md-8" id="supplierdc" style="display: none">
                                <div class="row">
                                <div class="form-group col-md-6" >
                                    <label class=" col-form-label">Group</label>
                                    <select class="form-control select2" name="expanse_type_id" >
                                      <option value="">Select Group</option>

                                        @foreach ($expansesubgroups as $data)
                                            <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                {{ $data->title }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                  <label class=" col-form-label">Sub-Ledger:</label>
                                        <select class="form-control select2" name="expanse_subgroup_id" >
                                               <option value="">Select  Sub Ledger </option>
												 @foreach ($subgroups as $data)
                                                 <option style="color:#000;font-weight:600;"value="{{ $data->id }}">{{ $data->subgroup_name }} - {{ $data->group_name }}</option>
                                                 @endforeach
                                        </select>
								</div>
                                </div>
                                </div>
                              {{-- ========end supplierdc======== --}}
	
                            </div>
                            {{-- Multiple Fields --}}
                            <div class="row mt-5">
                                <div id="field" class="col-md-12">
                                    <div class="row fieldGroup rowname">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="row">
                                                        <div class="col-md-4 vendorid" style="display: none">
                                                            <div class="form-group ">
                                                                <label class=" col-form-label">Asset Head:</label>
                                                                     <select name="product_id[]"
                                                                        class="form-control select2 assetProduct">
                                                                    </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4  supplierid" style="display: none">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">Expense Head:</label>
                                                              	<input type="text" name="expanse_head[]" class="form-control" placeholder="Expense Head">
                                                                {{-- <select class="form-control select2 " name="supplier_id[]">
                                                                    <option value="">Select Head</option>
                                                                    @foreach ($allSuppliers as $data)
                                                                        <option style="color:#000;font-weight:600;"
                                                                            value="{{ $data->id }}">
                                                                            {{ $data->supplier_name }}</option>
                                                                    @endforeach
                                                                </select> --}}
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Debit: <span
                                                                        class="debitchange text-danger"></span></label>
                                                                <input type="number" name="debit[]" class="form-control debit"
                                                                    placeholder="Amount">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Credit: <span
                                                                        class="creditchange  text-danger"></span></label>
                                                                <input type="number" name="credit[]" class="form-control credit"
                                                                    placeholder="Amount">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          <div class="row">
                            <div class="form-group col-md-4">
                                      <label class=" col-form-label">Payment Mode:</label>
                                       <select name="payment_mode" class="form-control select2" id="payment_type">
                                           <option value="">== Select Type ==</option>
                                           <option value="Bank">Bank Payment</option>
                                           <option value="Cash">Cash Payment</option>
                                        </select>
                             </div>
                            <div class="col-md-4">
                                  <div class="form-group" id="bank_name" style="display: none">
                                      <label class=" col-form-label">Bank Name:</label>
                                            <select name="bank_id" class="form-control select2">
                                                <option value="">== Select Bank ==</option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->bank_id }}">{{ $bank->bank_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group" id="werehouse_name" style="display: none">
                                            <label class=" col-form-label">Cash Name:</label>
                                            <select name="wirehouse_id" class="form-control select2">
                                                <option value="">== Select Cash ==</option>
                                                @foreach ($cashes as $cash)
                                                    <option value="{{ $cash->wirehouse_id }}">
                                                        {{ $cash->wirehouse_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                            		<div class="col-md-4  mt-5 font-weight-bold">
                                        <h5>Total Amount : <span id="total_amount">/-</span></h5>
                                        <input type="hidden" name="total_amount" class="form-control" id="total_amount_get">
                                    </div>
                            
                          </div>
                          <div class="row">
                             <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label">Payment Value (Cr):</label>
                                            <input type="text" name="payment_value_cr" id="paymentvalue"
                                                class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label">Remaining Value (Dr):</label>
                                            <input type="text" name="remaining_value_dr" id="remainingvalue" readonly
                                                class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Description:</label>
                                            <textarea name="description" class="form-control" cols="30"
                                                rows="3"></textarea>
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

            selected();

            //add more fields group
            $("body").on("click", ".addMore", function() {
                var fieldHTML =
                    '<div class="row fieldGroup rowname"><div class="col-md-12"><div class="row"><div class="col-md-11"><div class="row"><div class="col-md-4 vendorid" style="display: none"><div class="form-group "><select name="product_id[]" class="form-control select2 assetProduct"></select></div></div><div class="col-md-4  supplierid" style="display: none"><div class="form-group"><input type="text" name="expanse_head[]" class="form-control" placeholder="Expense Head"></div></div><div class="col-md-4"><div class="form-group"><input type="number" name="debit[]" class="form-control debit" placeholder="Amount"></div></div><div class="col-md-4"><div class="form-group"><input type="number" name="credit[]" class="form-control credit" placeholder="Amount"></div></div></div></div><div class="col-md-1"><a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a></div></div></div></div>';
                $(this).parents('.fieldGroup:last').after(fieldHTML);
          
                selected();
              
                $('.select2').select2({
                    theme: 'bootstrap4'
                })

              


            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                
              	$(this).parents(".fieldGroup").remove();
                total();
            }); 
          
            $("body").on("click", ".cremove", function() {
                
              	$(this).parents(".fieldGroup").remove();
                ctotal();
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

                  $(".otherstype").val("2").change();
                 
                  
                  
                  //  $('.otherstype').removeAttr('required');

                    var elems = document.getElementsByClassName('supplierid');
                    var elems2 = document.getElementsByClassName('vendorid');
                
                    for (var i = 0; i < elems.length; i += 1) {
                        elems[i].style.display = 'block';
                        elems2[i].style.display = 'none';               

                    }

                }
            }

            $('.dcoption').on('change', function() {

                var val = $(this).val();

                $('#dc_type').val(val);

            });
			
          $('#field').on('input', '.debit', function() {
          		var parent = $(this).closest('.fieldGroup');
            
                var debit = parent.find('.debit').val();
            	var credit = parent.find('.credit').val();
                    	
                  total();
          });
          function total() {
            	var total = 0;
                $(".debit").each(function() {
                    var totalvalueid = $(this).val() - 0;
                    total += totalvalueid;
                    $('#total_amount').html(total);
                    // console.log(total);
                })
                $('#total_amount').html(total);
                $('#total_amount_get').val(total);
            }
          
          $('#field').on('input', '.credit', function() {
          		var parent = $(this).closest('.fieldGroup');

            	var credit = parent.find('.credit').val();
                    	
                  ctotal();
          });
          
          
			function ctotal(){
            	var total = 0;
                $(".credit").each(function() {
                    var totalvalueid = $(this).val() - 0;
                    total += totalvalueid;
                    $('#total_amount').html(total);
                })
                $('#total_amount').html(total);
                $('#total_amount_get').val(total);
            }
          
          $('#paymentvalue').on('input', function() {

                var paymentval = $(this).val();
                var totalval = $('#total_amount_get').val();

                $('#remainingvalue').val(totalval - paymentval);

            });
          
          $('#category_id').on('change', function() {
                getproduct();
            })


            function getproduct() {

                var catid = $('#category_id').val();


                //console.log(catid);

                $.ajax({
                    url: '{{ url('/asset/get/product/') }}/' + catid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        //console.log(data);
                        var str = '<option value="">Asset Head</option>';
                        $(data).each(function(i, v) {
                            str += '<option value="' + v.id + '">' + v.product_name +
                                '</option>';
                        });
                        //alert(str);
                        $(".assetProduct").each(function() {
                            var thisp = $(this).val();
                            if (!$(this).val()) {

                                $(this).html(str);

                                $('.select2').select2({
                                    theme: 'bootstrap4'
                                })

                            }


                        })


                    }
                });


            }
		

            $('#payment_type').on('change', function() {
                var payment_type = $(this).val();
                //console.log(payment_type);
                if (payment_type != '') {

                    if (payment_type == "Bank") {
                        // console.log("Value is" + payment_type);
                        $("#werehouse_name").css("display", "none")
                        $("#bank_name").css("display", "block");
                    }

                    if (payment_type == "Cash") {
                        // console.log("Value is two" + payment_type);
                        $("#werehouse_name").css("display", "block")
                        $("#bank_name").css("display", "none");
                    }
                } else {
                    // console.log("Value Not Founded");
                    $("#werehouse_name").css("display", "none")
                    $("#bank_name").css("display", "none");
                }

            });
        });
    </script>
@endsection
