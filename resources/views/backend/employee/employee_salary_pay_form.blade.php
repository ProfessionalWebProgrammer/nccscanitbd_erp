@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="pt-3 text-center">
                <h5 class="font-weight-bolder text-uppercase">Employee Payment Entry</h5>
                <hr width="33%">
            </div>
            <form class="floating-labels m-t-40" action="{{route('employee.salary.pay.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="content px-4 ">
                            <div class="container-fluid">
                                <div class="row">

                                   <div class="form-group col-md-3">
                                        <label class=" col-form-label">Date:</label>
                                        <input type="date" value="{{ date('Y-m-d') }}" name="date"  class="form-control">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class=" col-form-label">Salary Month:</label>
                                        <input type="month" value="{{ date('Y-m') }}" name="month" id="month" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class=" col-form-label">Select Bank OR Cash <span style="color: red">*</span> </label>
                                        <select class="form-control select2" id="payment_by" name="payment_type" required>
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        <option value="BANK" selected>Bank</option>
                                        <option value="CASH">Cash</option>


                                    </select>
                                    </div>

                                    <div class="form-group col-md-4 bankid" style="display: none" >
                                                                <label class=" col-form-label">Bank:</label>
                                                                <select class="form-control select2 bank_id"

                                                                name="bank_id" >
                                                                <option value="">Select Bank</option>

                                                                @foreach ($allBanks as $data)
                                                                    <option style="color:#000;font-weight:600;" value="{{ $data->bank_id }}">
                                                                        {{ $data->bank_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            </div>


                                                            <div class="form-group col-md-4 warehouseid" style="display: none" >
                                                                <label class=" col-form-label">Depot/ Wirehouse:</label>
                                                                <select class="form-control select2 cash_id"

                                                                name="cash_id"  >
                                                                <option value="">Select Cash</option>

                                                                @foreach ($allcashs as $data)
                                                                    <option style="color:#000;font-weight:600;" value="{{ $data->wirehouse_id }}">
                                                                        {{ $data->wirehouse_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            </div>


                                 					  <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label">Expance Group and
                                                                        Sub-Group:</label>
                                                                    <select class="form-control select2 "
                                                                        name="expanse_subgroup_id" required>
                                                                        <option value="">Select Expnase Groups</option>

                                                                        @foreach ($subgroups as $data)
                                                                            <option style="color:#000;font-weight:600;"
                                                                                value="{{ $data->id }}">
                                                                                {{ $data->subgroup_name }} -
                                                                                {{ $data->group_name }}</option>
                                                                        @endforeach
                                                                    </select>
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
                                                             <div class="form-group col-md-2 "  ></div>
                                                          <div class="form-group col-md-4 "  >
                                                                <label class=" col-form-label">Select Employee:</label>
                                                                <select class="form-control select2 employee_id"

                                                                name="emp_id[]"  required>
                                                                <option value="">Select Employee</option>

                                                                @foreach ($employee as $data)
                                                                    <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                        {{ $data->emp_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            </div>

                                                          <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label">Net Salary:
                                                                     </label>
                                                                    <input type="text" name="net_salary[]"
                                                                        class="form-control net_salary" readonly placeholder="">
                                                                </div>
                                                            </div>








                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label">Amount:
                                                                     </label>
                                                                    <input type="text" name="amount[]"
                                                                        class="form-control amount" required placeholder="Amount">
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
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="form-group col-md-2 " ></div><div class="form-group col-md-4 " > <select class="form-control select2 employee_id" name="emp_id[]" required> <option value="">Select Employee</option> @foreach ($employee as $data) <option style="color:#000;font-weight:600;" value="{{$data->id}}">{{$data->emp_name}}</option> @endforeach </select> </div><div class="col-md-2"> <div class="form-group"> <input type="text" name="net_salary[]" class="form-control net_salary" readonly placeholder=""> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" name="amount[]" class="form-control amount" required placeholder="Amount"> </div></div></div></div><div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 8px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 8px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div></div>';
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

        if(x=="BANK")
        {

            var elems = document.getElementsByClassName('bankid');
            var elems2 = document.getElementsByClassName('warehouseid');
                for (var i=0;i<elems.length;i+=1){
                elems[i].style.display = 'block';
                elems2[i].style.display = 'none';
                }




        }
        if(x=="CASH")
        {


            var elems = document.getElementsByClassName('warehouseid');
            var elems2 = document.getElementsByClassName('bankid');
                for (var i=0;i<elems.length;i+=1){
                elems[i].style.display = 'block';
                elems2[i].style.display = 'none';
                }




         }
      }




                    $('#field').on('change','.employee_id',function(){

                        // $('.totalvalueid').attr("value", "0");
                        var parent = $(this).closest('.fieldGroup');
                          var month = $('#month').val();

                      parent.find('.net_salary').val('');

                      var emp_id = $(this).val();

                      if(month == null){
                      alert('Please Select Month First');
                      }else{
                       // alert(month);

                        $.ajax({
                                    url : '{{url('/employee/salary/get/')}}/'+emp_id+'/'+month,
                                    type: "GET",
                                    dataType: 'json',
                                    success : function(data){
                                      console.log(data);


                                   parent.find('.net_salary').val(data);



                                    }
                                });

                      }









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
