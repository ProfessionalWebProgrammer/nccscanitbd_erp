@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="pt-3 text-center">
                    <h5 class="font-weight-bolder text-uppercase">General Supplier Payment Create</h5>
                    <hr width="33%">
                </div>
                <form class="floating-labels m-t-40" action="{{ route('general.payment.supplier.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label class=" col-form-label">Date:</label>
                                    <input type="date" value="{{ date('Y-m-d') }}" name="payment_date"
                                        class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class=" col-form-label">Select Bank OR Cash <span style="color: red">*</span>
                                    </label>
                                    <select class="form-control select2" id="payment_by" name="payment_by" required>
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="BANK" selected>Bank</option>
                                        <option value="CASH">Cash</option>


                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class=" col-form-label">Narration <span style="color: red"></span> </label>
                                    <input type="text" name="payment_description" class="form-control">



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
                                                            <select class="form-control select2 bank_id" name="bank_id">
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
                                                            <select class="form-control select2 cash_id"
                                                                name="wirehouse_id">
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

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">General Supplier
                                                                    :</label>
                                                                <select class="form-control select2 "
                                                                    name="general_supplier_id">
                                                                    <option value="">Select Supplier</option>

                                                                    @foreach ($suppliers as $data)
                                                                        <option style="color:#000;font-weight:600;"
                                                                            value="{{ $data->id }}">
                                                                            {{ $data->supplier_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">Amount:
                                                                </label>
                                                                <input type="text" name="amount" class="form-control"
                                                                    required placeholder="Amount">
                                                            </div>
                                                        </div>




                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-1">
                                                        <label for="">Action :</label>
                                                        <a href="javascript:void(0)" style="margin-top: 8px;"
                                                            class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-sm custom-btn-sbms-remove remove"
                                                            style="margin-top: 8px;"><i
                                                                class="fas  fa-minus-circle"></i></a>
                                                    </div> --}}
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


@endsection


@push('end_js')
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




            $('#payment_by').on('change', function() {

                // console.log(x);

                selected();





                // console.log(x);

            });




            function selected() {

                var x = $('#payment_by').val();

                if (x == "BANK") {

                    var elems = document.getElementsByClassName('bankid');
                    var elems2 = document.getElementsByClassName('warehouseid');
                    for (var i = 0; i < elems.length; i += 1) {
                        elems[i].style.display = 'block';
                        elems2[i].style.display = 'none';
                    }




                }
                if (x == "CASH") {


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










        });
    </script>

@endpush
