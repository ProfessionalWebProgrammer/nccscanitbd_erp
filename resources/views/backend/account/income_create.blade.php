@extends('layouts.account_dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <!-- Main content -->
    <div class="content px-4 ">
        <div class="container-fluid">
            <div class="pt-3 text-center">
                <h4 class="font-weight-bolder text-uppercase">Income Entry</h4>
                <hr width="33%">
            </div>

            <form class="floating-labels m-t-40" action="{{Route('all.income.store')}}" method="POST">
                @csrf


        <div class="row">
                    <div class="col-md-12">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3">
                                         <div class="form-group">
                                            <label class=" col-form-label">Date:</label>
                                            <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control">
                                    	</div>
                                    </div>
                                  	<div class="form-group col-md-4">
                                    <label class=" col-form-label">Select Bank OR Cash <span style="color: red">*</span>
                                    </label>
                                    <select class="form-control select2" id="payment_by" name="payment_by" required>
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
                                    <label class=" col-form-label">Depot/ Wirehouse:</label>
                                    <select class="form-control select2" name="wirehouse_id" id="wirehouse_id">
                                        <option value="">Select Cash</option>

                                        @foreach ($allcashs as $data)
                                            <option style="color:#000;font-weight:600;" value="{{ $data->wirehouse_id }}">
                                                {{ $data->wirehouse_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                   <div class="col-md-5">
                                       <div class=" form-group row">
                                           <label class=" col-form-label">Desciption:</label>
                                              <input type="Text" name="description" class="form-control" placeholder=" Description" >
                                      </div>
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
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Head
                                                                        :</label>
                                                                      <input type="text" name="head[]"
                                                                        class="form-control" placeholder="Head">
                                                                </div>
                                                            </div>
                                                           <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Inocome Source : (Product)</label>
                                                                 <select class="form-control select2" name="income_source_id[]">
                                                                    <option value="">Select Product</option>
                                                                       @foreach ($assetProduct as $data)
                                                                            <option value="{{ $data->id }}">{{ $data->product_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Amount:</label>
                                                                    <input type="number" name="amount[]"
                                                                        class="form-control" placeholder=" Amount">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 p-0">
                                                        <label for="">Action :</label>
                                                        <a href="javascript:void(0)" style="margin-top: 8px;"
                                                            class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-sm custom-btn-sbms-remove remove"
                                                            style="margin-top: 8px;"><i
                                                                class="fas  fa-minus-circle"></i></a>
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
                            </div>


                    </div>
                </div>
            </form>

    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(document).ready(function() {
        //add more fields group
        $("body").on("click", ".addMore", function() {
            var fieldHTML =
                ' <div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-5"> <div class="form-group"> <input type="text" name="head[]" class="form-control" placeholder="Head"> </div></div><div class="col-md-4"> <div class="form-group"> <select  class="form-control select2" name="inocome_source_id[]"> <option value="">Select Source</option> @foreach ($assetProduct as $data) <option value="{{$data->id}}">{{$data->product_name}}</option> @endforeach </select> </div></div><div class="col-md-3"> <div class="form-group"> <input type="number" name="amount[]" class="form-control" placeholder=" Amount"> </div></div></div></div><div class="col-md-1 p-0">  <a href="javascript:void(0)" style="margin-top: 8px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 8px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div></div>';
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


                // console.log(x);
            });
    });
</script>
@endsection
