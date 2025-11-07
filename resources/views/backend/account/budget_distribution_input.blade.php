@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <div class="container-fluid">
            <div class="row" style="min-height: 85vh">
                <div class="col-md-12" style="border-right: solid #003B46">

                    <div class="content px-4 ">

                        <form class="floating-labels m-t-40" action="{{ route('budget.distribution.store') }}" method="POST" >
                            @csrf
                            <div class="container-fluid">
                                <div class="pt-4 text-center">
                                    <h4 class="font-weight-bolder text-uppercase">Budget Distribution Create </h4>
                                    <hr width="33%">
                                </div>
                               
                              <h4>Company Name: {{$budgets->company}}</h4>
                              <h4>Budget Amount: {{$budgets->budget_amount}}</h4>
                              <h4>Budget Year: {{$budgets->budget_year}}</h4>

                                <input type="hidden" name="budget_id" value="{{$budgets->id}}" class="form-control">
                                     <div class="row mt-3">
                                        <div id="field" class="col-md-12">
                                            <div class="row fieldGroup rowname">
                                                <div class="col-md-12">
                                                    <div class="row">

                                                        <div class="col-md-11">
                                                            <div class="row">
                                                              
                                                             <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label >Expance
                                                                        Sub-Group:</label>
                                                                    <select class="form-control select2 "
                                                                        name="expanse_subgroup_id[]" required>
                                                                        <option value="">Select Supplier</option>

                                                                        @foreach ($subgroups as $data)
                                                                            <option style="color:#000;font-weight:600;"
                                                                                value="{{ $data->id }}">
                                                                                {{ $data->subgroup_name }} -
                                                                                {{ $data->group_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                                <div class="col-md-3 pr-3">
                                                                    <div class="form-group row">
                                                                        <label for="">Month :</label>
                                                                           <input type="month" name="month[]" class="form-control amount">
                                                                    </div>
                                                                </div>
                                                               <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label >Select Zone:
                                                                                     </label>
                                                                                     <select class="form-control select2 dealer_id" 
                                        
                                                                                        name="zone_id[]"  required>
                                                                                        <option value="">Select Zone</option>

                                                                                        @foreach ($zones as $data)
                                                                                            <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                                                                {{ $data->zone_title }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                               
                                                                <div class="col-md-2">
                                                                    <div class="form-group row">
                                                                            <label for="">Amount :</label>
                                                                            <input type="text" name="amount[]" class="form-control amount">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <label for="">Action :</label>
                                                            <a href="javascript:void(0)" style="margin-top: 3px;"
                                                                class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                                    class="fas fa-plus-circle"></i></a>
                                                            <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"
                                                                style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>

                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              
								<div class="row mt-3">
                                  
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
          
            var x = 1;
            //add more fields group
            $("body").on("click", ".addMore", function() {
                x = x + 1;
              
                var fieldHTML =
                    ' <div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-4"> <div class="form-group"> <select class="form-control select2 " name="expanse_subgroup_id[]" required> <option value="">Select Supplier</option> @foreach ($subgroups as $data) <option style="color:#000;font-weight:600;" value="{{$data->id}}">{{$data->subgroup_name}}-{{$data->group_name}}</option> @endforeach </select> </div></div><div class="col-md-3 pr-3"> <div class="form-group row"> <input type="month" name="month[]" class="form-control amount"> </div></div><div class="col-md-3"> <div class="form-group"> <select class="form-control select2 dealer_id" name="zone_id[]" required> <option value="">Select Zone</option> @foreach ($zones as $data) <option style="color:#000;font-weight:600;" value="{{$data->id}}">{{$data->zone_title}}</option> @endforeach </select> </div></div><div class="col-md-2"> <div class="form-group row"> <input type="text" name="amount[]" class="form-control amount"> </div></div></div></div><div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div>';
                if (x <= 12) {
                    $(this).parents('.fieldGroup:last').after(fieldHTML);

                    $('.select2').select2({
                        theme: 'bootstrap4'
                    })

                } else {
                    $(function() {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000
                        });
                        $(function() {
                            Toast.fire({
                                icon: 'error',
                                title: 'Sorry! You can submit Only 12 entry.'
                            })

                        });

                    });
                }




            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();

              
            });
          
          
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
