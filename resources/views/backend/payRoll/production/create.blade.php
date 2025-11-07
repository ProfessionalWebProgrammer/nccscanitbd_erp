@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    @section('content')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper posclass">
    				<div class="row pt-2 pb-2">
                      	<div class="col-md-1"></div>
                          <div class="col-md-3 text-left">
                          	<a href="{{route('hrpayroll.employee.production.list')}}" class="btn btn-sm btn-success">Production List</a>
                        </div>
                    </div>

            <!-- Main content -->
            <div class="content px-4 ">

                <form action="{{route('hrpayroll.employee.production.store')}}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$urerid}}">
                    <div class="container" style="background: #ffffff; padding: 0px 40px; min-height:85vh">
                      <div class="text-center py-2">
                          <h3>Production Create</h3>
                          <hr>
                      </div>
                        <div class="row pt-4">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label text-right">Date : </label>
                                    <div class="col-sm-9">
                                        <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-right">Employee Name :</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2"  name="emp_id" id="employee">
                                            <option value="">Select Employee</option>
                                            @foreach ($employees as $val)
                                                <option style="color:#000;font-weight:600;" value="{{ $val->id }}">
                                                    {{ $val->emp_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 text-right">

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div id="field" class="col-md-12">

                                <div class="row fieldGroup rowname">
                                    <div class="col-md-12">
                                        <div class="row">

                                            <div class="col-md-11">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class=" col-form-label">Product Name:</label>
                                                            <select name="item_id[]" class="form-control select2 empProduct" required>
                                                                <option value="">== Select Product ==</option>
                                                                @foreach ($items as $val)
                                                                    <option style="color:#000;font-weight:600;"
                                                                        value="{{ $val->id }}">{{ $val->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class=" col-form-label">Product Category:</label>
                                                          <input type="hidden" name="cat[]"  class="form-control empCategoryId" value="" >
                                                          <input type="text"  class="form-control empCategory" value="" readonly>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">Rate :</label>
                                                        <input type="text" class="form-control rate" name="rate[]" placeholder="Rate">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">Quantity :</label>
                                                        <input type="text" class="form-control qty" name="qty[]" placeholder="Quantity">
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="">Total :</label>
                                                        <input type="text" readonly class="form-control total"  name="amount[]" placeholder="total">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1 mt-2">
                                                <label for="">Action :</label></br>
                                                <a href="javascript:void(0)"
                                                    class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                        class="fas fa-plus-circle"></i></a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm custom-btn-sbms-remove remove"
                                                    ><i
                                                        class="fas  fa-minus-circle"></i></a>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- loop end -->

                            </div>
                        </div>
<!-- end multiple Data -->


                        <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-4  mt-5">
                                <table class="table  border table-sm">
                                    <thead></thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr class="font-weight-bold">
                                            <td >Total Qty :</td>
                                            <td> <span id="total_qty"></span></td>
                                            <input type="hidden" class="form-control " id="grand_total_qty"  name="grand_total_qty">
                                        </tr>
                                        <input type="hidden" class="form-control " id="grand_total_value"  name="grand_total_value">
                                        <tr class="font-weight-bold">
                                            <td >Payable :</td>
                                            <td> <span id="total_amount"></td>
                                            <input type="hidden" class="form-control " id="total_payable"  name="total_payable">
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row pb-5">
                            <div class="col-md-4 mt-3">

                            </div>
                            <div class="col-md-4 mt-3">
                                     <button type="submit" class="btn btn-primary custom-btn-sbms-submit" style="width: 100%"> Submit</button>
                             </div>
                            <div class="col-md-4 mt-3">

                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </form>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


    <script>
        $(document).ready(function(){
            $("body").on("click", ".addMore", function() {
                var fieldHTML =
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-4"> <div class="form-group"> <select name="item_id[]" class="form-control select2 empProduct" required> <option value="">== Select Product ==</option> @foreach ($items as $val) <option style="color:#000;font-weight:600;" value="{{ $val->id }}">{{ $val->name }} </option> @endforeach </select> </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="hidden" name="cat[]" class="form-control empCategoryId" value="" > <input type="text" class="form-control empCategory" value="" readonly> </div> </div> <div class="col-md-2"> <input type="text" class="form-control rate" name="rate[]" placeholder="Rate"> </div> <div class="col-md-2"> <input type="text" class="form-control qty" name="qty[]" placeholder="Quantity"> </div> <div class="col-md-2"> <input type="text" readonly class="form-control total" name="amount[]" placeholder="total"> </div> </div> </div> <div class="col-md-1 mt-2"> <a href="javascript:void(0)" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" ><i class="fas fa-minus-circle"></i></a> </div> </div> </div> </div>';
                $(this).parents('.fieldGroup:last').after(fieldHTML);
            });

            //remove fields group
            $("#field").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
                //total();
                x = x-1;
                //console.log(x);

            });

            $('#field').on('change','.empProduct', function() {
   		         var parent = $(this).closest('.fieldGroup');
               var id = parent.find('.empProduct').val();
               var emp_id = $('#employee').val();
               //var url = '{{ url('/settings/get/category/') }}/' + id;
               if(emp_id == ''){
                    parent.find('.empProduct').val("");
                     alert("Please Select Employee First");
                   } else {

               $.ajax({
                           url: '{{ url('/hrpayroll/employee/product/rate/') }}/' + id,
                           type: "GET",
                           dataType: 'json',
                           success: function(data) {
                               $(data).each(function() {
                                 console.log(data);
                                 parent.find('.empCategoryId').val(data.cat_id);
                                 parent.find('.empCategory').val(data.cat);
                                 parent.find('.rate').val(data.rate);
                               });
                           }
                       });
                     }
               })

               $('#field').on('input', '.rate, .qty', function() {
                    var parent = $(this).closest('.fieldGroup');
                    var rate = parent.find('.rate').val();
                    var qty = parent.find('.qty').val();
                    var total_price = rate * qty;

                    parent.find('.total').val(total_price);
                    total();
                });

            function total() {
                    var total = 0;
                    var qty = 0;
                    $(".total").each(function() {
                        var totalvalueid = $(this).val() - 0;
                        total += totalvalueid;
                        $('#total_amount').html(total);
                    });

                    $(".qty").each(function(){
                        var totalqtyid = $(this).val()-0;
                        qty +=totalqtyid;
                        $('#total_qty').html(qty);
                    })
                    $('#total_qty').html(qty);
                }

/*
           $('#field').on('change','.products_id',function(){

                        var parent = $(this).closest('.fieldGroup');
                        var product_id = parent.find('.products_id').val();

                          alert(product_id);
                        $.ajax({
                                url : '{{url('/sales/product/price/')}}/'+product_id,
                                type: "GET",
                                dataType: 'json',
                                success : function(data){
                                    console.log(data);
                                    parent.find('.cat').val(data.stock);
                                    parent.find('.p_price').val(data.price);


                            }
                            });

                      });
                      */
        });
        </script>
    @endsection
