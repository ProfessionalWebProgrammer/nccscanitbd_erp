@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ route('employee.target.set.store') }}" method="post">
                @csrf
                <div class="container-fluid">
                    <div class="row pt-5">

                        <div class="col-md-3 ">
                            <h5>Select Month: <span id="today" style="color: lime; display:inline-block">This Month</span>
                            </h5>
                            <div class="form-group m-b-40">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="month" name="month" class="form-control float-right" id="slectmonth"
                                        value="{{ date('Y-m') }}">

                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <h5>Employee : </h5>
                            <div class="form-group m-b-40">
                                    <select name="emp_id" class="form-control select2" required>
                                        <option value=""> == Select Employee == </option>
                                        @foreach ($emps as $item)
                                            <option value="{{ $item->id }}">{{ $item->emp_name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <h5>Employee  Zone: </h5>
                            <div class="form-group m-b-40">
                                    <select name="employe_zone_id" class="form-control select2" required>
                                        <option value=""> == Select Employee == </option>
                                        @foreach ($zones as $item)
                                            <option value="{{ $item->id }}">{{ $item->zone_title }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <h5>Employee Area: </h5>
                            <div class="form-group m-b-40">
                                    <select name="employe_area_id" class="form-control select2" required>
                                        <option value=""> == Select Employee == </option>
                                        @foreach ($areas as $item)
                                            <option value="{{ $item->id }}">{{ $item->area_title }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-4">
                                                </div>
                                                <div class="col-md-5 pr-3">
                                                    <div class="form-group row">
                                                        <label for="">Category :</label>
                                                        <select required class="form-control select2" name="category_id[]" required>
                                                            <option value="">Select Category</option>
                                                            @foreach ($categorys as $data)
                                                                <option style="color:#000;font-weight:600;"
                                                                    value="{{ $data->id }}">
                                                                    {{ $data->category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="">Target (Ton) :</label>
                                                        <input type="text" required  name="target_amount[]" class="form-control amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Action :</label> <br>
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


                    <div class="row my-4">
                        <div class="col-md-6  m-auto font-weight-bold">
                            <h5 class="text-center ">Total Target : <span id="total_amount">/-</span></h5>
                        </div>

                    </div>
                    <div class="row py-4">
                        <div class="col-md-6 m-auto">
                            <div class="text-center">
                                <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                            </div>
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


            var invoice = '';
            $.ajax({
                url: '{{ url('get/payment/invoice') }}',
                type: "GET",
                dataType: 'json',
                success: function(data) {

                    console.log(data);
                    var dln = data;
                    invoice = dln;
                    $('.invoiceNo').html(dln);

                }
            });

            var x = 1;
            //add more fields group
            $("body").on("click", ".addMore", function() {
                x = x + 1;
                invoice = invoice + 1;
                var fieldHTML = '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-8"> <div class="row"> <div class="col-md-4"> </div><div class="col-md-5 pr-3"> <div class="form-group row"> <select required class="form-control select2" name="category_id[]" required> <option value="">Select Category</option> @foreach ($categorys as $data) <option style="color:#000;font-weight:600;" value="{{$data->id}}">{{$data->category_name}}</option> @endforeach </select> </div></div><div class="col-md-3"> <div class="form-group row"> <input type="text" required name="target_amount[]" class="form-control amount"> </div></div></div></div><div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div>';
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

                total();
            });


            $('#field').on('input', '.amount', function() {



                total();


            });





            function total() {
                var total = 0;
                $(".amount").each(function() {
                    var totalvalueid = $(this).val() - 0;
                    total += totalvalueid;
                    $('#total_amount').html(total);
                    // console.log(total);
                })
                $('#total_amount').html(total_with_discount);
            }


            $("#slectmonth").change(function() {
                var a = document.getElementById("today");
                a.style.display = "none";
            });








        });


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
