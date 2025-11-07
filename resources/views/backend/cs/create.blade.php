@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row" style="min-height: 85vh">
                    <div class="col-md-12">
                            <form class="floating-labels m-t-40" action="{{route('cs.store')}}" method="POST">
                                @csrf
                                <div class="pt-4 text-center">
                                    <h4 class="font-weight-bolder text-uppercase">Comparative Statement</h4>
                                    <hr width="33%">
                                </div>

                                <div class="row pt-3">
                                    <div class="col-md-12" id="field">
                                      <div class="fieldGroup">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class=" col-form-label col-md-4">Issue Date:</label>
                                                    <input type="date" name="issue_date" value="{{ date('Y-m-d') }}"
                                                        class="form-control col-md-8">
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <div class="form-group row">
                                                    <label class=" col-form-label col-md-5 pl-3"> Item Name:</label>
                                                     <select name="item" class="form-control select2 orderProduct col-md-7 " required>
                                                        <option value="">== Select Item ==</option>
                                                        @foreach ($products as $item)
                                                            <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                          <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class=" col-form-label col-md-4 "> Quantity :</label>
                                                    <input type="text" name="qty"  class="form-control col-md-8">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">

                                                    <label class=" col-form-label col-md-4 "> UOM (Kg):</label>
                                                    <input type="text" name="unit"  class="form-control orderUnit col-md-8" value="" readonly>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                   <label class=" col-form-label col-md-4"> Supplier-1:</label>
                                                   <select name="supplier1" class="form-control select2 col-md-8" >
                                                         <option value="">Select Supplier </option>
                                                              @foreach ($suppliers as $val)
                                                              <option value="{{ $val->id }}">{{ $val->supplier_name }}</option>
                                                              @endforeach
                                                  </select>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group row">
                                                    <label class=" col-form-label col-md-4"> Rate-1:</label>
                                                    <input type="number" name="rate1" step="any" class="form-control col-md-8"  placeholder="Supplier-1 rate">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                  <div class="col-md-1">  </div>
                                                    <label class=" col-form-label col-md-3"> Supplier-2:</label>
                                                   <select name="supplier2" class="form-control select2 col-md-8" >
                                                         <option value="">Select Supplier </option>
                                                              @foreach ($suppliers as $val)
                                                              <option value="{{ $val->id }}">{{ $val->supplier_name }}</option>
                                                              @endforeach
                                                  </select>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group row">
                                                    <label class=" col-form-label col-md-4"> Rate-2:</label>
                                                    <input type="number" name="rate2" step="any" class="form-control col-md-8"  placeholder="Supplier-2 rate">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                   <label class=" col-form-label col-md-4"> Supplier-3:</label>
                                                   <select name="supplier3" class="form-control select2 col-md-8" >
                                                         <option value="">Select Supplier </option>
                                                              @foreach ($suppliers as $val)
                                                              <option value="{{ $val->id }}">{{ $val->supplier_name }}</option>
                                                              @endforeach
                                                  </select>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group row">
                                                    <label class=" col-form-label col-md-4"> Rate-3:</label>
                                                    <input type="number" name="rate3" step="any" class="form-control col-md-8"  placeholder="Supplier-3 rate">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                  <div class="col-md-1">  </div>
                                                    <label class=" col-form-label col-md-3"> Supplier-4:</label>
                                                   <select name="supplier4" class="form-control select2 col-md-8" >
                                                         <option value="">Select Supplier </option>
                                                              @foreach ($suppliers as $val)
                                                              <option value="{{ $val->id }}">{{ $val->supplier_name }}</option>
                                                              @endforeach
                                                  </select>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group row">
                                                    <label class=" col-form-label col-md-4"> Rate-4:</label>
                                                    <input type="number" name="rate4" step="any" class="form-control col-md-8"  placeholder="Supplier-4 rate">
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                </div>

                                {{--
                                <div class="row mt-3">
                                    <div id="field" class="col-md-12">

                                        <div class="row fieldGroup rowname">
                                            <div class="col-md-12">
                                                <div class="row">

                                                    <div class="col-md-11">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label">Product Name:</label>
                                                                    <select name="item[]" class="form-control select2 orderProduct" required>
                                                                        <option value="">== Select Product ==</option>
                                                                                @foreach ($products as $item)
                                                                                    <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                                                                @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                          <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Description:</label>
                                                                    <input type="text"  name="specification[]" class="form-control" placeholder="Product Specification">
                                                                </div>
                                                            </div>
                                                          	<div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Unit :</label>
                                                                    <input type="text" name="unit[]"  class="form-control orderUnit" value="" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Quantity:</label>
                                                                    <input type="text"  name="qty[]" required class="form-control qty" placeholder="Quantity">

                                                                </div>
                                                            </div>
															                             <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Price:</label>
                                                                    <input type="text"  name="rate[]" required class="form-control rate" placeholder="Unit Price">
                                                                    <input type="hidden"  name="amount[]" class="form-control amount" >
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 mt-2">
                                                        <label for="">Action :</label>
                                                        <a href="javascript:void(0)" style="margin-top: 3px;"
                                                            class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-sm custom-btn-sbms-remove remove"
                                                            style="margin-top: 3px;"><i
                                                                class="fas  fa-minus-circle"></i></a>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                --}}

                                <div class="row col-md-12">
                                  <div class="col-md-3">
                                                          
															 <div class="form-group">
                                                                    <label class=" col-form-label">RFQ No:</label>
                                                                    <select name="rfq_no" class="form-control select2 orderProduct" >
                                                                        <option value=""> Select RFQ No </option>
                                                                                @foreach ($rfqs as $item)
                                                                                    <option value="{{ $item->invoice }}">{{ $item->invoice }}</option>
                                                                                @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                  <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class=" col-form-label "> Specification :</label>
                                                  <textarea name="specification" class="form-control" cols="30"
                                                rows="3"></textarea>
                                                   
                                                </div>
                                            </div>
                                  
                                    <div class="col-md-5">
										                      <div class="form-group">
                                            <label class=" col-form-label">Remarks:</label>
                                            <textarea name="description" class="form-control" cols="30"
                                                rows="3"></textarea>
                                        </div>
                                    </div>
                                  
                                  
                                  {{-- <div class="col-md-4  mt-5 font-weight-bold">
                                        <h5>Total Amount : <span id="total_amount"></span> /-</h5>
                                      <input type="hidden"  name="total_amount" class="form-control" id="total_amount_get" >
                                    </div> --}}

                                </div>
                                    </div>

                                    <div class="col-md-12 my-5">
                                        <div class="text-center">
                                            <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
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
            //add more fields group
    /*        $("body").on("click", ".addMore", function() {
                var fieldHTML =
                    '<div class="row fieldGroup rowname"><div class="col-md-12"><div class="row"><div class="col-md-11"><div class="row"><div class="col-md-3"> <div class="form-group"> <select name="item[]" class="form-control select2 orderProduct" required> <option value="">== Select Product ==</option> @foreach ($products as $item) <option value="{{ $item->id }}">{{ $item->product_name }}</option> @endforeach </select> </div> </div> <div class="col-md-3"> <div class="form-group"> <input type="text" name="specification[]" class="form-control" placeholder="Product Specification"> </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="text" name="unit[]" class="form-control orderUnit" value="" readonly> </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="text" name="qty[]" required class="form-control qty" placeholder="Quantity">  </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="text" name="rate[]" required class="form-control rate" placeholder="Unit Price"> <input type="hidden" name="amount[]" class="form-control amount" > </div> </div> </div> </div> <div class="col-md-1 mt-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> </div>';
                $(this).parents('.fieldGroup:last').after(fieldHTML);
            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
              total();
            });

           $('#field').on('input', '.rate, .qty', function() {
                var parent = $(this).closest('.fieldGroup');
                var rate = parent.find('.rate').val();
                var qty = parent.find('.qty').val();
                var total_price = rate * qty;

				parent.find('.amount').val(total_price);
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
                $('#total_amount').html(total);
          		$('#total_amount_get').val(total);
            }
*/

         $('#field').on('change','.orderProduct', function() {
		var parent = $(this).closest('.fieldGroup');
        var id = parent.find('.orderProduct').val();
        //var url = '{{ url('/settings/get/category/') }}/' + id;
        //alert(url);
        $.ajax({
                    url: '{{ url('/settings/get/category/') }}/' + id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $(data).each(function() {
                          //console.log(data);
                          parent.find('.orderUnit').val(data.unit);
                        });
                    }
                });

            })
        });
    </script>
@endsection
