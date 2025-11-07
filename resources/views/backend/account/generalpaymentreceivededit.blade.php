@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 m-auto">

                    <div class="content px-4 ">

                        <form class="floating-labels m-t-40" action="{{route('general.payment.recived.restore')}}" method="POST">
                            @csrf
                            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                                <div class="pt-4 text-center">
                                    <h4 class="font-weight-bolder text-uppercase">GeneralPayment Recived</h4>
                                    <hr width="33%">
                                </div>

                                <div class="row pt-3">
                                    <div class="col-md-12">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class=" col-form-label">Date :</label>
                                                    <input type="date" name="date" value="{{$editdata->payment_date}}" class="form-control">
                                                  	<input type="hidden" name="id" value="{{$editdata->id}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                      	 <div class="form-group">
                                            <label class=" col-form-label">General Money Recived Head:</label>
                                            <input type="text" name="general_received_head" value="{{$editdata->payment_description}}" class="form-control"
                                                placeholder="General Received Head" required>
                                        </div>
                                        <div class="form-group">
                                            <label class=" col-form-label">Payment Collection Mode:</label>
                                            <select name="collection_mode" class="form-control select2" id="payment_type" required>
                                                <option value="">== Select Type ==</option>
                                              @if($editdata->type == 'BANK')   <option value="BANK" selected >Bank Payment</option>  @endif
                                              @if($editdata->type == 'CASH')  <option value="CASH" selected >Cash Payment</option>  @endif
                                            </select>
                                        </div>
                                      @if($editdata->type == 'BANK') 
                                        <div class="form-group" id="bank_name" >
                                            <label class=" col-form-label">Bank Name:</label>
                                            <select name="bank_id" class="form-control select2">
                                                <option value="">== Select Bank ==</option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->bank_id }}"  @if($editdata->bank_id == $bank->bank_id) selected @endif>{{ $bank->bank_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                      @endif
                                      @if($editdata->type == 'CASH')
                                        <div class="form-group" id="werehouse_name"  >
                                            <label class=" col-form-label">Wirehouse Name:</label>
                                            <select name="wirehouse_id" class="form-control select2">
                                                <option value="">== Select Wirehouse ==</option>
                                                @foreach ($cashes as $cash)
                                                    <option value="{{ $cash->wirehouse_id }}"  @if($editdata->wirehouse_id == $cash->wirehouse_id ) selected @endif>
                                                        {{ $cash->wirehouse_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                       @endif
                                      
                                        <div class="form-group" >
                                            <label class=" col-form-label">Vehicle Number:</label>
                                            <select name="vehicle_number" class="form-control select2">
                                                <option value="">== Select Vehicle Number ==</option>
                                                @foreach ($vehicles as $date)
                                                    <option value="{{ $date->vehicle_number }}" @if($date->vehicle_number == $editdata->vehicle_number ) selected @endif>
                                                        {{ $date->vehicle_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                      
                                        <div class="form-group">
                                            <label class=" col-form-label">Receive Amount:</label>
                                            <input type="text" name="received_amount" value="{{$editdata->amount}}" class="form-control"
                                                placeholder="Payment Amount" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-5">
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
        </div>
    </div>
    <!-- /.content-wrapper -->
    <script>
        $(document).ready(function() {
            $('#payment_type').on('change', function() {
                var payment_type = $(this).val();
                console.log(payment_type);
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
            $('#client_type').on('change', function() {
                var client_type = $(this).val();
                console.log(client_type);
                if (client_type != '') {

                    if (client_type == "short") {
                        // console.log("Value is" + payment_type);
                        $("#sclient").css("display", "block")
                        $("#lclient").css("display", "none");
                    }

                    if (client_type == "long") {
                        // console.log("Value is two" + payment_type);
                        $("#sclient").css("display", "none")
                        $("#lclient").css("display", "block");
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
