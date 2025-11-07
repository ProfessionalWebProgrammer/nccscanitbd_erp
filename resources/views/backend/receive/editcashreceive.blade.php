@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ route('cash.receive.update') }}" method="post">
                @csrf
                <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                  <div class="col-md-12 pt-3 text-center">
                        <h4>Edit Cash Received</h4>
                     </div> <hr>
                    <div class="row pt-4">
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Date : </label>
                                <div class="col-sm-9">
                                    <input type="date" value="{{ $cashreceivedata->payment_date }}" name="payment_date"
                                        class="form-control" id="inputEmail3">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group row">
                                <label for="payment_description" class="col-sm-2 col-form-label">Naration: </label>
                                <div class="col-sm-10">
                                    <input type="text" name="payment_description" class="form-control" value="{{ $cashreceivedata->payment_description}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
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
                                        <div class="col-md-11">
                                            <div class="row">
                                                <div class="col-md-3 pr-3">
                                                    <div class="form-group row">
                                                        <label for="">Cash :</label>
                                                        <select class="form-control select2" name="cash_id" required>
                                                            <option value="">Select Cash</option>

                                                            @foreach ($allcashs as $data)
                                                                <option style="color:#000;font-weight:600;"
                                                                    value="{{ $data->wirehouse_id }}" @if ($data->wirehouse_id == $cashreceivedata->wirehouse_id)
                                                                    selected
                                                            @endif>
                                                            {{ $data->wirehouse_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 pr-3">
                                                    <div class="form-group row">
                                                        <label for="">Dealer :</label>
                                                        <select class="form-control select2 dealer_id" name="dealer_id"
                                                            required>
                                                            <option value="">Select Dealer</option>

                                                            @foreach ($allDealers as $data)
                                                                <option style="color:#000;font-weight:600;"
                                                                    value="{{ $data->id }}" @if ($data->id == $cashreceivedata->vendor_id)
                                                                    selected
                                                            @endif>
                                                            {{ $data->d_s_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 pr-3 " >
                                                    <div class="form-group ">
                                                            <label >Product Category :</label>
                                                            <select class="form-control select2 "  name="category_id"  >
                                                            <option value="">Select Product Category</option>
                                                            @foreach ($category as $data)
                                                                <option style="color:#000;font-weight:600;" value="{{ $data->id }}" @if ($data->id == $cashreceivedata->category_id)  selected  @endif >
                                                                    {{ $data->category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="">Amount :</label>
                                                        <input type="text" value="{{ $cashreceivedata->amount }}"
                                                            name="amount" class="form-control amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1"> <label for="">Invoice : <br> <span class="mt-2">{{ $cashreceivedata->invoice }}</span> </label>

                                           <input type="hidden" name="id" value="{{ $cashreceivedata->id }}">
                                           <input type="hidden" name="invoice" value="{{ $cashreceivedata->invoice }}">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- <div class="row ">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-4  mt-5 font-weight-bold">
                            <h5>Total Amount : <span id="total_amount">/-</span></h5>
                        </div>

                    </div> --}}
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
