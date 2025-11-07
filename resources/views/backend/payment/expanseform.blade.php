@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
      <div class="row pt-2 pb-2 ml-3">
                      <div class="col-md-4 text-left ml-5">
                        <a href="{{ URL('all/payment/index') }}" class=" btn btn-sm btn-success mr-2"> Payment</a>
                      	<a href="{{route('expanse.payment.index')}}" class="btn btn-sm btn-success">Expense List</a>
                    </div>

                </div>

        <div class="content">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="row pt-3">


                </div>
                <div class="pt-3 text-center">
                    <h5 class="font-weight-bolder text-uppercase">Create Form</h5>
                    <hr width="33%">
                </div>
                <form class="floating-labels m-t-40" action="{{ route('expanse.payment.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class=" col-form-label">Date:</label>
                                    <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control">
                                </div>
                                
                                
                                
                                {{-- <div class="form-group col-md-6">
                                    <label class=" col-form-label">Narration:</label>
                                    <input type="text" name="payment_description" class="form-control" placeholder="Narration ">
                                </div> --}}

                                 {{-- <div class="form-group col-md-4" id="supplier">
                                     <label class=" col-form-label"> Supplier:</label>
                                    <select class="form-control select2 " id="supplier_id" name="supplier_id">
                                        <option value="">Select Supplier</option>

                                        @foreach ($allSuppliers as $data)
                                            <option style="color:#000;font-weight:600;" value="{{ $data->id }}"> {{ $data->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                
                              {{--<div class="form-group col-md-4" id="dealer">
                                     <label class=" col-form-label"> Dealer:</label>
                                    <select class="form-control select2 " id="dealer_id" name="dealer_id">
                                        <option value="">Select Dealer</option>

                                        @foreach ($allDealers as $data)
                                            <option style="color:#000;font-weight:600;" value="{{ $data->id }}"> {{ $data->d_s_name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                
                               
                                {{--
                              <div class="form-group col-md-6">
                                    <label class=" col-form-label">Narration:</label>
                                    <input type="text" name="payment_description" class="form-control" placeholder="Narration ">
                                </div>
                              --}}



                            </div>
                            {{-- Multiple Fields --}}
                            <div class="row mt-5">
                                <div id="field" class="col-md-12">
                                    <div class="row fieldGroup rowname">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="row">
                                                        {{--<div class="col-md-3">
                                                           <div class="form-group">
                                                              <label class=" col-form-label">Expense Group </label>
                                                              <select class="form-control select2 group" name="expanse_type_id[]" required>
                                                                <option value="">Select Group</option>

                                                                  @foreach ($expansesubgroups as $data)
                                                                      <option style="color:#000;font-weight:600;" value="{{ $data->id }}">{{ $data->group_name }}</option>
                                                                  @endforeach

                                                              </select>
                                                          </div> 
                                                          <div class="form-group">
                                                            <label class=" col-form-label">Narration:</label>
                                    						<input type="text" name="payment_description[]" class="form-control" placeholder="Narration ">
                                                            </div>
                                                        </div>--}}
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">Ledger: (Dr)</label>
                                                              <select class="form-control select2 " name="expanse_subgroup_id[]" >
                                                                    <option value="">Select Ledger </option>
                                                                    @foreach ($subgroups as $data)
                                                                        <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                            {{ $data->subgroup_name }} - {{ $data->group_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">
                                                                    Sub-Ledger: (Dr)</label>
                                                                <select class="form-control select2 " name="expanse_subSubgroup_id[]" >
                                                                    <option value="">Select  Sub Ledger: </option>

                                                                    @foreach ($subSubGroups as $data)
                                                                        <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                           {{$data->subSubgroup_name}} - {{ $data->subgroup_name }} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                      	<div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Value:</label>
                                                                <input type="number" name="expanse_rate[]" class="form-control rate" step="any" placeholder="Value">
                                                                <input type="hidden" class="amount" name="amount[]">
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
                                    
                                    <div class="col-md-12">
                                    <div class="row">
                                        
                                        <div class="form-group col-md-3">
                                            <label class=" col-form-label">Narration:</label>
                                            <input type="text" name="payment_description" class="form-control" placeholder="Narration ">
                                        </div>
                                        
                                        <div class="form-group col-md-3">
                                            <label class=" col-form-label">Select Bank OR Cash: (Cr)<span style="color: red">*</span>
                                            </label>
                                            <select class="form-control select2" id="payment_by" name="payment_by" required>
                                                <option value="">Select One Must <span style="color: red">*</span></option>
                                                <option value="bank">Bank</option>
                                                <option value="cash">Cash</option>
                                                <option value="company">Sister Concern</option>
                                            </select>
                                        </div>
        
        
        
                                        <div class="form-group col-md-3" style="display: none" id="bankid">
                                            <label class=" col-form-label">Bank: (Cr)</label>
                                            <select class="form-control select2" name="bank_id" id="bank_id">
                                                <option value="">Select Bank</option>
        
                                                @foreach ($allBanks as $data)
                                                    <option style="color:#000;font-weight:600;" value="{{ $data->bank_id }}">
                                                        {{ $data->bank_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-3" style="display: none" id="warehouseid">
                                            <label class=" col-form-label">Cash Name: (Cr)</label>
                                            <select class="form-control select2" name="wirehouse_id" id="wirehouse_id">
                                                <option value="">Select Cash</option>
        
                                                @foreach ($allcashs as $data)
                                                    <option style="color:#000;font-weight:600;" value="{{ $data->wirehouse_id }}">
                                                        {{ $data->wirehouse_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                       <div class="form-group col-md-3" style="display: none" id="companyid">
                                            <label class=" col-form-label">S.C Name: (Cr)</label>
                                            <select class="form-control select2" name="company_id" id="company_id">
                                                <option value="">Select S.C</option>
                                                @foreach ($company as $val)
                                                    <option style="color:#000;font-weight:600;" value="{{ $val->id }}">{{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-2">
                                            <label class=" col-form-label">Balance:</label>
                                            <input type="text" name="balance" class="form-control balanceBC" readonly>
                                        </div>
                                
                                    </div><!--.row-->
                                </div><!--/.col-md-12-->

                                  <div class="row">
                                    <div class="col-md-8">
                                        
                                    </div>
                                     <div class="col-md-4">
                                       <div class="form-group row mt-3">
                                        <label class="col-form-label mt-3">Total Amount: <span id="total" style="color:000;"> </span></label>
                                         <input type="hidden" name="expanse_amount" id="total" class="form-control total" value="">
                                      </div>
                                    </div>
                                    <div class="col-md-1"></div>
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
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            //add more fields group
            $("body").on("click", ".addMore", function() {
                var fieldHTML =
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-4"> <div class="form-group"> <select class="form-control select2 " name="expanse_subgroup_id[]" > <option value="">Select Ledger </option> @foreach ($subgroups as $data) <option style="color:#000;font-weight:600;" value="{{ $data->id }}"> {{ $data->subgroup_name }} - {{ $data->group_name }}</option> @endforeach </select> </div> </div> <div class="col-md-4"> <div class="form-group"> <select class="form-control select2 " name="expanse_subSubgroup_id[]" > <option value="">Select Sub Ledger </option> @foreach ($subSubGroups as $data) <option style="color:#000;font-weight:600;" value="{{ $data->id }}"> {{$data->subSubgroup_name}} - {{ $data->subgroup_name }} </option> @endforeach </select> </div> </div> <div class="col-md-3"> <div class="form-group"> <input type="number" name="expanse_rate[]" class="form-control rate" step="any" placeholder="Value"> <input type="hidden" class="amount" name="amount[]"> </div> </div> </div> </div> <div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 8px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 8px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> </div>';
                     $(this).parents('.fieldGroup:last').after(fieldHTML);

                $('.select2').select2({
                    theme: 'bootstrap4'
                })

            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
            });




            $('#payment_by').on('change', function() {
                var x = $(this).find(":selected").val();
                // console.log(x);

                if (x == "bank") {
                    var a = document.getElementById("bankid");
                    var b = document.getElementById("warehouseid");
                    var c = document.getElementById("companyid");
                    a.style.display = "";
                    b.style.display = "none";
                    c.style.display = "none";

                    $("#bank_id").prop('required', true);
                }
                if (x == "cash") {
                    var a = document.getElementById("bankid");
                    var b = document.getElementById("warehouseid");
                    var c = document.getElementById("companyid");
                    a.style.display = "none";
                    c.style.display = "none";
                    b.style.display = "";

                    $("#wirehouse_id").prop('required', true);
                }
                if (x == "company") {
                    var a = document.getElementById("bankid");
                    var b = document.getElementById("warehouseid");
                    var c = document.getElementById("companyid");
                    a.style.display = "none";
                    b.style.display = "none";
                    c.style.display = "";

                    $("#company_id").prop('required', true);
                }


                // console.log(x);
            });


            $('#bank_id').on('change', function() {
                var id = $(this).find(":selected").val();
                $.ajax({
                    url: '{{ url('/get/bank/balance/') }}/' + id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                       // console.log(data);

                       if(data > 1)
                       {
                         $('.balanceBC').val(data);
                       } else {
                         alert("Sorry! Don`t enough Balance in this account.");
                       }
                    }
                });
              });

              $('#wirehouse_id').on('change', function() {
                  var id = $(this).find(":selected").val();
                  if(id == 47){
                    $.ajax({
                        url: '{{ url('/get/cash/balance/') }}/' + id,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {
                           // console.log(data);

                             $('.balanceBC').val(data);
                        }
                    });
                  } else {
                    $.ajax({
                        url: '{{ url('/get/cash/balance/') }}/' + id,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {
                           // console.log(data);

                           if(data > 1)
                           {
                             $('.balanceBC').val(data);
                           } else {
                             alert("Sorry! Don`t enough Balance in this account.");
                           }


                        }
                    });
                  }
                });

        });


        $(document).ready(function() {

          $('#supplier_id').on('change', function()  {
              var a = document.getElementById("dealer");
              a.style.display = "none";
              });

           $('#dealer_id').on('change', function() {
              var a = document.getElementById("supplier");
              a.style.display = "none";
              });
           $('#company_id').on('change', function() {
              var a = document.getElementById("supplier");
              a.style.display = "none";
              });

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
      <script>
        $(document).ready(function() {
          $('#field').on('input', '.rate', function() {
                var parent = $(this).closest('.fieldGroup');
                var rate = parent.find('.rate').val();

                var total_price = rate;

                parent.find('.amount').val(total_price);
                total();
            });

        function total() {
                var total = 0;
                $(".amount").each(function() {
                    var totalvalueid = $(this).val() - 0;
                    total += totalvalueid;
                    $('#total').html(total);
					$('#total').val(total);
                    //console.log(total);
                })
               /* $('#total_amount').html(total);
                $('#total_amount_get').val(total); */
            }

            /*$('#field').on('change', '.group', function() {
				alert('Data');
                var parent = $(this).closest('.fieldGroup');


				var total = 0;
                var rate = parent.find('.rate').val();
              //alert(rate);
                var total += rate;
              	$('#total').val(total);
               // parent.find('.total').val(total);

            });
            */
        });
    </script>
@endsection
