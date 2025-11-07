@extends('layouts.account_dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content px-4 ">
        <div class="container-fluid">
            <div class="pt-3 text-center">
                <h4 class="font-weight-bolder text-uppercase">Equity Create</h4>
                <hr width="33%">
            </div>

            <form class="floating-labels m-t-40" action="{{route('accounts.equity.store')}}" method="POST">
                @csrf
                              <div class="row">
                                    <div class="col-md-2">
                                         <div class="form-group">
                                            <label class=" col-form-label">Date:</label>
                                            <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control">
                                    	</div>
                                    </div>
                                <div class="col-md-2">
                                       <div class=" form-group">
                                          <label class=" col-form-label">Select Bank OR Cash {{-- <span style="color: red">*</span> --}}</label>
                                            <select class="form-control select2" id="payment_by" name="payment_by" >
                                                <option value="1">Select One Bank Or Cash{{-- Must <span style="color: red">*</span> --}}</option>
                                                <option value="bank" >Bank</option>
                                                <option value="cash">Cash</option>
                                            </select>
                                         </div>
                                    </div>
                                   <div class="col-md-4">
                                       <div class=" form-group">
                                           <label class=" col-form-label">Head:</label>
                                              <input type="Text" name="head" class="form-control" placeholder=" Head" required>

                                      </div>
                                    </div>
                                  <div class="col-md-3">
                                       <div class=" form-group">
                                           <label class=" col-form-label">Equity Category:</label>
                                                <select name="equity_category" class="form-control select2">
                                                <option value="">Select Category</option>

                                                @foreach ($ecats as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>

                                      </div>
                                    </div>
								<div class="col-md-1"></div>

                                </div>
                                {{-- Multiple Fields --}}
                                <div class="row mt-2 mb-3">
                                    <div id="field" class="col-md-12">
                                        <div class="row fieldGroup rowname">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <div class="row">
                                                          	<div class="form-group col-md-3 bankid" style="display: none">
                                                            <label class=" col-form-label">Bank:</label>
                                                            <select class="form-control select2 bank_id" name="bank_id[]">
                                                                <option value="">Select Bank</option>

                                                               		@foreach ($banks as $item)
                                                                        <option value="{{$item->bank_id}}">{{$item->bank_name}}</option>
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-3 warehouseid" style="display: none">
                                                            <label class=" col-form-label">Depot/ Wirehouse:</label>
                                                            <select class="form-control select2 cash_id" name="cash_id[]">
                                                                <option value="">Select Cash</option>

                                                                @foreach ($allcashs as $data)
                                                                    <option style="color:#000;font-weight:600;"
                                                                        value="{{ $data->wirehouse_id }}">
                                                                        {{ $data->wirehouse_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Name
                                                                        :</label>
                                                                      <input type="text" name="name[]"
                                                                        class="form-control" placeholder="Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Percentage(%):</label>
                                                                    <input type="number" name="percentage[]"
                                                                        class="form-control" placeholder="Percentaget">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Amount:</label>
                                                                    <input type="number" name="amount[]"
                                                                        class="form-control" placeholder=" Amount" step="any">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="">Action :</label></br>
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
                                <div class="col-md-6 m-auto">
                                    <div class="text-center">
                                        <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
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
      selected();
        //add more fields group
        $("body").on("click", ".addMore", function() {
            var fieldHTML =
                ' <div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"><div class="form-group col-md-3 bankid" style="display: none"> <select class="form-control select2 bank_id" name="bank_id[]"> <option value="">Select Bank</option> @foreach ($banks as $item) <option value="{{$item->bank_id}}">{{$item->bank_name}}</option> @endforeach </select> </div> <div class="form-group col-md-3 warehouseid" style="display: none"> <select class="form-control select2 cash_id" name="cash_id[]"> <option value="">Select Cash</option> @foreach ($allcashs as $data) <option style="color:#000;font-weight:600;" value="{{ $data->wirehouse_id }}"> {{ $data->wirehouse_name }}</option> @endforeach </select> </div><div class="col-md-4"> <div class="form-group"> <input type="text" name="name[]" class="form-control" placeholder="Name"> </div></div><div class="col-md-2"> <div class="form-group"> <input type="number" name="percentage[]" class="form-control" placeholder="Percentaget"> </div></div><div class="col-md-3"> <div class="form-group"> <input type="number" name="amount[]" class="form-control" placeholder=" Amount" step="any"> </div></div></div></div><div class="col-md-1">  <a href="javascript:void(0)" style="margin-top: 8px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 8px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div></div>';
            $(this).parents('.fieldGroup:last').after(fieldHTML);
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

                if (x == "bank") {

                    var elems = document.getElementsByClassName('bankid');
                    var elems2 = document.getElementsByClassName('warehouseid');
                    for (var i = 0; i < elems.length; i += 1) {
                        elems[i].style.display = 'block';
                        elems2[i].style.display = 'none';
                    }

                }
                if (x == "cash") {


                    var elems = document.getElementsByClassName('warehouseid');
                    var elems2 = document.getElementsByClassName('bankid');
                    for (var i = 0; i < elems.length; i += 1) {
                        elems[i].style.display = 'block';
                        elems2[i].style.display = 'none';
                    }

                }
            }
    });
</script>
@endsection
