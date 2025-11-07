@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center py-3">
                    <h3>Amount Transfer Edit</h3>
                </div>
                <div class="py-4">
                    <form action="{{ route('amount.transfer.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-10 m-auto ">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Date :</label>
                                            <div>
                                                <input type="date" id="journel_date"
                                                    value="{{ date('Y-m-d', strtotime($listData->payment_date)) }}"
                                                    class="form-control" name="journel_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Reference :</label>
                                            <div>
                                                <input type="text" class="form-control" name="subject" 
                                                    value="{{$editabledata[1]->expanse_head}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="id1" value="{{ $editabledata[0]->id }}">
                                <input type="hidden" name="id2" value="{{ $editabledata[1]->id }}">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>From :</label>
                                            <div>
                                                <select required class="form-control selectcls" name="type1">
                                                    <option value="">Select Type</option>
                                                    <option value="BANK" @if ($editabledata[0]->type == 'BANK') selected  @endif>Bank</option>
                                                    <option value="CASH" @if ($editabledata[0]->type == 'CASH') selected  @endif>Cash</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" @if ($editabledata[0]->type == 'BANK') @else style="display: none"  @endif id="bankid">
                                        <div class="form-group">
                                            <label>Select Bank</label>
                                            <div>
                                                <select class="form-control selectpicker" data-show-subtext="true"
                                                    data-live-search="true" data-live-search-style="startsWith"
                                                    name="bank_id1" id="">
                                                    <option value="">Select Bank</option>
                                                    @foreach ($banks as $bank)
                                                        <option value="{{ $bank->bank_id }}" @if ($editabledata[0]->bank_id == $bank->bank_id) selected  @endif>
                                                            {{ $bank->bank_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" @if ($editabledata[0]->type == 'CASH') @else style="display: none" @endif id="warehouseid">
                                        <div class="form-group">
                                            <label style="position: inherit;">Select
                                                Wirehouse</label>
                                            <div>
                                                <select class="form-control selectpicker" data-show-subtext="true"
                                                    data-live-search="true" data-live-search-style="startsWith"
                                                    name="wirehouse_id1" id="">
                                                    <option value="">Select Warehouse</option>
                                                    @foreach ($cashes as $cash)
                                                        <option value="{{ $cash->wirehouse_id }}"
                                                            @if ($editabledata[0]->wirehouse_id == $cash->wirehouse_id) selected  @endif>
                                                            {{ $cash->wirehouse_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Debit :</label>
                                            <div>
                                                <input type="text" @if ($editabledata[0]->transfer_type == 'PAYMENT')
                                                value="{{ $editabledata[0]->amount }}"
                                                @endif
                                                class="form-control" name="debit1" placeholder="Debit">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Credit :</label>
                                            <div>
                                                <input type="text" @if ($editabledata[0]->transfer_type == 'RECEIVE')
                                                value="{{ $editabledata[0]->amount }}" @endif class="form-control"
                                                name="credit1"
                                                placeholder="Credit">
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
                                                    <option value="BANK" @if ($editabledata[1]->type == 'BANK') selected  @endif>Bank</option>
                                                    <option value="CASH" @if ($editabledata[1]->type == 'CASH') selected  @endif>Cash</option>
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" @if ($editabledata[1]->type == 'BANK') @else style="display: none"  @endif id="bankid1">
                                        <div class="form-group">
                                            <label>Select Bank</label>
                                            <div>
                                                <select class="form-control selectpicker" data-show-subtext="true"
                                                    data-live-search="true" data-live-search-style="startsWith"
                                                    name="bank_id2" id="">
                                                    <option value="">Select Bank</option>
                                                    @foreach ($banks as $bank)
                                                        <option value="{{ $bank->bank_id }}" @if ($editabledata[1]->bank_id == $bank->bank_id) selected  @endif>
                                                            {{ $bank->bank_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" @if ($editabledata[1]->type == 'CASH') @else style="display: none" @endif id="warehouseid1">
                                        <div class="form-group">
                                            <label style="position: inherit;">Select
                                                Wirehouse</label>
                                            <div>
                                                <select class="form-control selectpicker" data-show-subtext="true"
                                                    data-live-search="true" data-live-search-style="startsWith"
                                                    name="wirehouse_id2" id="">
                                                    <option value="">Select Warehouse</option>
                                                    @foreach ($cashes as $cash)
                                                        <option value="{{ $cash->wirehouse_id }}"
                                                            @if ($editabledata[1]->wirehouse_id == $cash->wirehouse_id) selected  @endif>
                                                            {{ $cash->wirehouse_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label">Debit :</label>
                                            <div>
                                                <input type="text" @if ($editabledata[1]->transfer_type == 'PAYMENT')
                                                value="{{ $editabledata[1]->amount }}" @endif class="form-control"
                                                name="debit2" placeholder="Debit">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label">Credit :</label>
                                            <div>
                                                <input type="text" @if ($editabledata[1]->transfer_type == 'RECEIVE')
                                                value="{{ $editabledata[1]->amount }}" @endif class="form-control"
                                                name="credit2"
                                                placeholder="Credit">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 m-auto">
                                        <div class="form-group">
                                            <label>Narration :</label>
                                            <div>
                                                <input type="text" class="form-control" name="description"
                                                    value="{{$editabledata[1]->payment_description}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pb-5">
                                    <div class="col-md-6 mt-3">
                                        <div class="text-right">
                                            <button type="submit" class="btn custom-btn-sbms-submit"> Update </button>
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
    </script>
    {{-- <script>
        $(document).ready(function() {
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


        $(document).ready(function() {
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
    </script> --}}

@endsection
