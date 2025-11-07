@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center py-3">
                    <h3>Amount Transfer Create</h3>
                </div>
                <div class="py-4">
                    <form action="{{ route('amount.transfer.store') }}" method="POST">
                        @csrf
                        <div class="row" id="field">
                            <div class="col-md-10 m-auto fieldGroup ">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Date :</label>
                                            <div>
                                                <input type="date" id="journel_date" value="{{ date('Y-m-d') }}" class="form-control" name="journel_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Reference :</label>
                                                {{-- <textarea name="" id="" class="form-control" cols="30" rows="3"></textarea> --}}
                                                <input type="text" class="form-control" name="subject"
                                                    placeholder="Reference">
                                        </div>
                                    </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                            <label>Narration :</label>
                                            <div>
                                                <input type="text" class="form-control" name="description"
                                                    placeholder="Narration">
                                            </div>
                                        </div>
                                  </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>From :</label>
                                            <div>
                                                <select required class="form-control selectcls" name="type1">
                                                    <option value="">Select Type</option>
                                                    <option value="BANK">Bank</option>
                                                    <option value="CASH">Cash</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="display: none" id="bankid">
                                        <div class="form-group">
                                            <label>Select Bank</label>
                                            <div>
                                                <select class="form-control selectpicker" data-show-subtext="true"
                                                    data-live-search="true" data-live-search-style="startsWith"
                                                    name="bank_id1" id="selectBankId1">
                                                    <option value="">Select Bank</option>
                                                    @foreach ($banks as $bank)
                                                        <option value="{{ $bank->bank_id }}">{{ $bank->bank_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="display: none" id="warehouseid">
                                        <div class="form-group">
                                            <label style="position: inherit;">Select
                                                Wirehouse</label>
                                            <div>
                                                <select class="form-control selectpicker" data-show-subtext="true"
                                                    data-live-search="true" data-live-search-style="startsWith"
                                                    name="wirehouse_id1" id="selectCashId1">
                                                    <option value="">Select Warehouse</option>
                                                    @foreach ($cashes as $cash)
                                                        <option value="{{ $cash->wirehouse_id }}">
                                                            {{ $cash->wirehouse_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                   {{-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Debit :</label>
                                            <div>
                                                <input type="text" class="form-control" name="credit1" placeholder="Debit">
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Credit :</label>
                                            <div>
                                                <input type="text" class="form-control credit" name="debit1" placeholder="Credit">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>To :</label>
                                            <div>
                                                <select required class="form-control selectcls1" name="type2">
                                                    <option value="">Select Type</option>
                                                    <option value="BANK">Bank</option>
                                                    <option value="CASH">Cash</option>
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="display: none" id="bankid1">
                                        <div class="form-group">
                                            <label>Select Bank</label>
                                            <div>
                                                <select class="form-control selectpicker" data-show-subtext="true"
                                                    data-live-search="true" data-live-search-style="startsWith"
                                                    name="bank_id2" id="selectBankId2">
                                                    <option value="">Select Bank</option>
                                                    @foreach ($banks as $bank)
                                                        <option value="{{ $bank->bank_id }}">{{ $bank->bank_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="display: none" id="warehouseid1">
                                        <div class="form-group">
                                            <label style="position: inherit;">Select
                                                Wirehouse</label>
                                            <div>
                                                <select class="form-control selectpicker" data-show-subtext="true"
                                                    data-live-search="true" data-live-search-style="startsWith"
                                                    name="wirehouse_id2" id="selectCashId2">
                                                    <option value="">Select Warehouse</option>
                                                    @foreach ($cashes as $cash)
                                                        <option value="{{ $cash->wirehouse_id }}">
                                                            {{ $cash->wirehouse_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label">Balance :</label>
                                            <div>
                                                <input type="text" class="form-control balanceBC" name="balance"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label">Debit :</label>
                                            <div>
                                                <input type="text" class="form-control debit" name="credit2" value="">
                                              <div id="total"> </div>
                                            </div>
                                        </div>
                                    </div>
                                  {{--
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label">Credit :</label>
                                            <div>
                                                <input type="text" class="form-control" name="debit2"
                                                    placeholder="Credit">
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="row pb-5">
                                    <div class="col-md-6 mt-3">
                                        <div class="text-right" id="submitButton">
                                            <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.selectcls').on('change', function() {
            var x = $(this).find(":selected").val();
            // console.log(x);


            if (x == "BANK") {
                var b = document.getElementById("bankid");
                var c = document.getElementById("warehouseid");
                b.style.display = "";
                c.style.display = "none";
            }
            if (x == "CASH") {
                var b = document.getElementById("bankid");
                var c = document.getElementById("warehouseid");
                b.style.display = "none";
                c.style.display = "";
            }

            if (x == "") {
                var b = document.getElementById("bankid");
                var c = document.getElementById("warehouseid");
                b.style.display = "none";
                c.style.display = "none";
            }
            // console.log(x);
        });


        $('.selectcls1').on('change', function() {
            var x = $(this).find(":selected").val();
            // console.log(x);


            if (x == "BANK") {
                var b = document.getElementById("bankid1");
                var c = document.getElementById("warehouseid1");
                b.style.display = "";
                c.style.display = "none";
            }
            if (x == "CASH") {
                var b = document.getElementById("bankid1");
                var c = document.getElementById("warehouseid1");
                b.style.display = "none";
                c.style.display = "";
            }

            if (x == "") {
                var b = document.getElementById("bankid1");
                var c = document.getElementById("warehouseid1");
                b.style.display = "none";
                c.style.display = "none";
            }
            // console.log(x);
        });

      $('#field').on('change','#selectBankId2',function(){
       		var parent = $(this).closest('.fieldGroup');
          	var selectedBankId1 = parent.find('#selectBankId1').val();
           	var selectedBankId2 = parent.find('#selectBankId2').val();
        	var b = document.getElementById("submitButton");
           if(selectedBankId1 == selectedBankId2){
           alert('Please change the Bank ID!');
             b.style.display = "none";
           } else {
           	b.style.display = "";
           }

         });
       $('#field').on('change','#selectCashId2',function(){
       		var parent = $(this).closest('.fieldGroup');
          	var selectedCashId1 = parent.find('#selectCashId1').val();
           	var selectedCashId2 = parent.find('#selectCashId2').val();
         	var b = document.getElementById("submitButton");
           if(selectedCashId1 == selectedCashId2){
           alert('Please change the Cash ID!');
           b.style.display = "none";
           } else {
           	b.style.display = "";
           }

         });

       $(document).ready(function() {

         $('#field').on('change','#selectBankId1',function(){
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

            $('#field').on('change','#selectCashId1',function() {
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

        $('#field').on('input','.credit',function(){

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');

                var total = parent.find('.credit').val();
   				//alert(total);
         		// alert(selectedBankId1);
                parent.find('.debit').val(total);
                parent.find('.debit').prop('readonly', true);
                });

       });
    </script>

@endsection
