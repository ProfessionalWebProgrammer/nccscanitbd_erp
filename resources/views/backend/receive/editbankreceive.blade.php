@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ route('bank.receive.update') }}" method="post">
                @csrf
               <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                    <div class="row pt-4">
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Date : </label>
                                <div class="col-sm-9">
                                    <input type="date" value="{{ $bankreceivedata->payment_date }}" name="payment_date"
                                        class="form-control" id="inputEmail3">
                                </div>
                            </div>
                        </div>
                      <div class="col-md-7">
                            <div class="form-group row">
                                <label for="payment_description" class="col-sm-2 col-form-label">Naration: </label>
                                <div class="col-sm-10">
                                    <input type="text" name="payment_description" class="form-control" value="{{ $bankreceivedata->payment_description}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                           <label for="">Invoice : {{ $bankreceivedata->invoice }}</label>
                              <input type="hidden" name="id" value="{{ $bankreceivedata->id }}">
                              <input type="hidden" name="invoice" value="{{ $bankreceivedata->invoice }}">

                            <div class="row">
                                <div class="col-md-8">

                                </div>
                                <div class="col-md-4">
                                    {{-- <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">C/B : </label>
                                        <div class="col-sm-9">
                                            <input type="number" disabled class="form-control" >
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="row">

                                                <div class="col-md-3 pr-3">
                                                    <div class="form-group row">
                                                        <label for="">Bank :</label>
                                                        <select class="form-control select2" name="bank_id" >
                                                            <option value="">Select Bank</option>

                                                            @foreach ($allBanks as $data)
                                                                <option style="color:#000;font-weight:600;"
                                                                    value="{{ $data->bank_id }}" @if ($data->bank_id == $bankreceivedata->bank_id)
                                                                    selected
                                                            @endif>
                                                            {{ $data->bank_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @if($bankreceivedata->vendor_id)
                                                <div class="col-md-3 pr-3">
                                                    <div class="form-group row">
                                                        <label for="">Dealer :</label>
                                                        <select class="form-control select2 dealer_id" name="dealer_id"
                                                            required>
                                                            <option value="">Select Dealer</option>

                                                            @foreach ($allDealers as $data)
                                                                <option style="color:#000;font-weight:600;"
                                                                    value="{{ $data->id }}" @if ($data->id == $bankreceivedata->vendor_id) selected  @endif>
                                                                    {{ $data->d_s_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($bankreceivedata->sister_concern_id)
                                                <div class="col-md-3 pr-3" >
                                                    <div class="form-group ">
                                                            <label >Sister Concern :</label>
                                                            <select class="form-control select2 "  name="company_id[]"  >
                                                            <option value="">Select Sister Concern</option>

                                                            @foreach ($allCompanies as $data)
                                                                <option style="color:#000;font-weight:600;" value="{{ $data->id }}" @if($data->id == $bankreceivedata->sister_concern_id) selected  @endif>
                                                                    {{ $data->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="col-md-3 pr-3 " >
                                                    <div class="form-group ">
                                                            <label >Product Category :</label>
                                                            <select class="form-control select2 "  name="category_id"  >
                                                            <option value="">Select Product Category</option>

                                                            @foreach ($category as $data)
                                                                <option style="color:#000;font-weight:600;" value="{{ $data->id }}" @if($data->id == $bankreceivedata->category_id)  selected  @endif>
                                                                    {{ $data->category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                  <div class="row">
                                                    <div class="col-md-6">
                                                          <div class="form-group">
                                                               <label >Bank Charge:</label>
                                                               <input type="number" name="bank_charge" class="form-control bank_charge" step="any" value="{{$bankCharge ?? 0}}">
                                                         </div>
                                                    </div>
                                                      <div class="col-md-6">
                                                          <div class="form-group row">
                                                              <label for="">Amount :</label>
                                                              <input type="text" value="{{ $bankreceivedata->amount }}" name="amount" class="form-control amount">
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


                    <div class="row ">
                        <div class="col-md-6">

                        </div>
                        {{-- <div class="col-md-4  mt-5 font-weight-bold">
                            <h5>Total Amount : <span id="total_amount">/-</span></h5>
                        </div> --}}

                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <div class="text-right">
                                <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">

                        </div>
                    </div>
                </div>
            </form>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script>


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
@endsection
