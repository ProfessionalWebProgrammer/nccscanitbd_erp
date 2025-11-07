@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="pt-3 text-center">
                <h5 class="font-weight-bolder text-uppercase">Employee Other Amount Entry</h5>
                <hr width="33%">
            </div>
            <form class="floating-labels m-t-40" action="{{route('employee.other.amount.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="content px-4 ">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class=" col-form-label">Month:</label>
                                        <input type="month" value="{{ date('Y-m') }}" name="month" class="form-control">
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

                                                          <div class="form-group col-md-4 "  >
                                                                <label class=" col-form-label">Select Employee:</label>
                                                                <select class="form-control select2 emp_id"

                                                                name="emp_id[]"  required>
                                                                <option value="">Select Employee</option>

                                                                @foreach ($employee as $data)
                                                                    <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                        {{ $data->emp_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            </div>



                                                            <div class="form-group col-md-4" >
                                                                <label class=" col-form-label">Type:</label>
                                                                <select class="form-control select2 type"

                                                                name="type[]" required >
                                                                <option value="">Select Type</option>

                                                                    <option  value="PerformanceB">Performance Bonus</option>
                                                                    <option  value="Holiday">Holiday</option>
                                                                    <option  value="Advance">Advance</option>
                                                            </select>
                                                            </div>







                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label">Amount:
                                                                     </label>
                                                                    <input type="text" name="amount[]"
                                                                        class="form-control" required placeholder="Amount">
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
    </div>


@endsection


@push('end_js')
        <script>
        $(document).ready(function() {

            selected();
            //add more fields group
            $("body").on("click", ".addMore", function() {
                var fieldHTML =
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="form-group col-md-4 " > <select class="form-control select2 emp_id" name="emp_id[]" required> <option value="">Select Employee</option> @foreach ($employee as $data) <option style="color:#000;font-weight:600;" value="{{$data->id}}">{{$data->emp_name}}</option> @endforeach </select> </div><div class="form-group col-md-4" > <select class="form-control select2 type" name="type[]" required > <option value="">Select Type</option> <option value="PerformanceB">Performance Bonus</option> <option value="Holiday">Holiday</option> <option value="Advance">Advance</option> </select> </div><div class="col-md-2"> <div class="form-group"> <input type="text" name="amount[]" class="form-control" required placeholder="Amount"> </div></div></div></div><div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 8px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 8px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div></div>';
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




    function selected(){

        var x =  $('#payment_by').val();

        if(x=="bank")
        {

            var elems = document.getElementsByClassName('bankid');
            var elems2 = document.getElementsByClassName('warehouseid');
                for (var i=0;i<elems.length;i+=1){
                elems[i].style.display = 'block';
                elems2[i].style.display = 'none';
                }




        }
        if(x=="cash")
        {


            var elems = document.getElementsByClassName('warehouseid');
            var elems2 = document.getElementsByClassName('bankid');
                for (var i=0;i<elems.length;i+=1){
                elems[i].style.display = 'block';
                elems2[i].style.display = 'none';
                }




         }
      }


      $('#field').on('change','.bank_id',function(){

                    // $('.totalvalueid').attr("value", "0");
                    var parent = $(this).closest('.fieldGroup');

                  var bankid =  parent.find('.bank_id').val();

                    console.log(bankid);

                    $.ajax({
                                url : '{{url('/get/bank/balance/')}}/'+bankid,
                                type: "GET",
                                dataType: 'json',
                                success : function(data){
                                  console.log(data);

                                 parent.find('.balanceBC').val(data);

                                }
                            });







                    })


                    $('#field').on('change','.cash_id',function(){

                        // $('.totalvalueid').attr("value", "0");
                        var parent = $(this).closest('.fieldGroup');
                          var warehouseid =  parent.find('.cash_id').val();


                        $.ajax({
                                    url : '{{url('/get/cash/balance/')}}/'+warehouseid,
                                    type: "GET",
                                    dataType: 'json',
                                    success : function(data){
                                      console.log(data);



                                 parent.find('.balanceBC').val(data);

                                    }
                                });







                    })



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
