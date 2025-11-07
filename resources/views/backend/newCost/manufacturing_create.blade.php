@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
      <div class="content px-4 ">
        <div class="container">
            
            <div class="pt-3 text-center">
                <h5 class="font-weight-bolder text-uppercase">Manufacturing Cost Create Form</h5>
                <hr width="33%">
            </div>
            <form class="floating-labels m-t-40" action="{{route('manufacturing.newCost.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                      
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label class=" col-form-label">Date:</label>
                                        <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control">
                                    </div>
                                  	<div class="form-group col-md-4">
                                    <label class=" col-form-label">Select Bank OR Cash <span style="color: red">*</span>
                                    </label>
                                    <select class="form-control select2" id="payment_by" name="payment_by" >
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="bank">Bank</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4" style="display: none" id="bankid">
                                    <label class=" col-form-label">Bank:</label>
                                    <select class="form-control select2" name="bank_id" id="bank_id">
                                        <option value="">Select Bank</option>

                                        @foreach ($allBanks as $data)
                                            <option style="color:#000;font-weight:600;" value="{{ $data->bank_id }}">
                                                {{ $data->bank_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4" style="display: none" id="warehouseid">
                                    <label class=" col-form-label">Cash Name:</label>
                                    <select class="form-control select2" name="wirehouse_id" id="wirehouse_id">
                                        <option value="">Select Cash</option>

                                        @foreach ($allcashs as $data)
                                            <option style="color:#000;font-weight:600;" value="{{ $data->wirehouse_id }}">
                                                {{ $data->wirehouse_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                    <div class="form-group col-md-2">
                                  <label class=" col-form-label">Quantity :</label>
                                   <input type="text" class="form-control" name="quantity"/>     
                                  {{-- <label class=" col-form-label">Finished Goods :</label>
                                        <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true" data-actions-box="true" multiple
                                        name="fg_id[]" >
                                        @foreach ($fgs as $key =>$data)
                                            <option style="color: #ff0000; font-weight:bold" value="{{ $data->id }}">
                                               {{++$key}} - {{ $data->product_name }} 
                                            </option>
                                        @endforeach
                                    </select> --}}
                                    </div>    
                                </div>
                      
                                {{-- Multiple Fields --}}
                                <div class="row mt-3">
                                    <div id="field" class="col-md-12">
                                        <div class="row fieldGroup rowname">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <div class="row">
                                                           
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Head:</label>
                                                                    {{-- <input type="text" name="head[]"
                                                                        class="form-control" required placeholder=" Head"> --}}
                                                                  <select class="form-control select2" data-show-subtext="true" data-live-search="true" data-actions-box="true" required name="head[]">
                                                                    <option value="0">Select Expense Ledger </option>
                                                                    @foreach ($leadger as $data)
                                                                        <option style="color: #000; font-weight:500" value="{{ $data->id }}">
                                                                             {{ $data->subgroup_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select> 
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Quantity:</label>
                                                                    <input type="number" name="qty[]"
                                                                    required class="form-control qty" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Rate:</label>
                                                                    <input type="number" name="rate[]"
                                                                    required  class="form-control rate" placeholder="">
                                                                </div>
                                                            </div>
                                                            
                                                          
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Total Cost:</label>
                                                                    <input type="number" name="total_cost[]"
                                                                        class="form-control total_cost" placeholder="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="">Action :</label></br>
                                                        <a href="javascript:void(0)" style="margin-top: 8px;" class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                        <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"
                                                            style="margin-top: 8px;"><i class="fas  fa-minus-circle"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 pb-5 mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
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
            //add more fields group
            $("body").on("click", ".addMore", function() {
                var fieldHTML =
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-5"> <div class="form-group"> <select class="form-control select2" data-show-subtext="true" data-live-search="true" data-actions-box="true" required name="head[]"> <option value="0">Select Expense Ledger </option> @foreach ($leadger as $data) <option style="color: #000; font-weight:500" value="{{ $data->id }}"> {{ $data->subgroup_name }} </option> @endforeach </select> </div></div><div class="col-md-2"> <div class="form-group"> <input type="number" required name="qty[]" class="form-control qty" placeholder=""> </div></div><div class="col-md-2"> <div class="form-group"> <input type="number" required name="rate[]" class="form-control rate" placeholder=""> </div></div><div class="col-md-3"> <div class="form-group"> <input type="number" name="total_cost[]"  class="form-control total_cost" placeholder=""> </div></div></div></div><div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 8px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 8px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div>';
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
                    a.style.display = "";
                    b.style.display = "none";

                    $("#bank_id").prop('required', true);
                }
                if (x == "cash") {
                    var a = document.getElementById("bankid");
                    var b = document.getElementById("warehouseid");
                    a.style.display = "none";
                    b.style.display = "";

                    $("#wirehouse_id").prop('required', true);
                }
            });

            $('#field').on('input','.rate, .qty',function(){

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');

                var qty=parent.find('.qty').val();
                var rate=parent.find('.rate').val();


               // var per_person_cost = parent.find('.per_person_cost').val();

               
                parent.find('.total_cost').val(qty*rate);

                //   parent.find('.totalvalueid').val(parseFloat(qt)* parseFloat(up));




              //  total();

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

@endpush
