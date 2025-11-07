@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <style media="screen">
    .form-check-input {
      position: absolute;
      margin-top: 0.3rem;
      margin-left: -1.8rem;
      width: 20px;
      height: 20px;
    </style>
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row" style="min-height: 85vh">
                    <div class="col-md-12">
                            <form class="floating-labels m-t-40" action="{{route('cs.update', $data->id)}}" method="POST">
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
                                                    <input type="date" name="issue_date" value="{{ $data->issue_date}}"
                                                        class="form-control col-md-8">
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <div class="form-group row">
                                                    <label class=" col-form-label col-md-5 pl-3"> Item Name:</label>
                                                     <select name="item" class="form-control select2 orderProduct col-md-7 " required>
                                                        <option value="">== Select Item ==</option>
                                                        @foreach ($products as $item)
                                                            <option value="{{ $item->id }}" @if($item->id == $data->item) selected @else @endif>{{ $item->product_name }} - item: {{$data->item}} - id: {{$item->id}}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                          <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class=" col-form-label col-md-4 "> Quantity :</label>
                                                    <input type="text" name="qty"  class="form-control col-md-8" value="{{ $data->qty }}">
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class=" col-form-label col-md-4 "> UOM (Kg):</label>
                                                    <input type="text" name="unit"  class="form-control orderUnit col-md-8" value="{{ $data->unit }}" readonly>
                                                </div>
                                            </div>
											@php 
                                            $s1 = DB::table('suppliers')->where('id', $data->supplier1)->value('supplier_name');
                                            $s2 = DB::table('suppliers')->where('id', $data->supplier2)->value('supplier_name');
                                            $s3 = DB::table('suppliers')->where('id', $data->supplier3)->value('supplier_name');
                                            $s4 = DB::table('suppliers')->where('id', $data->supplier4)->value('supplier_name');
                                            
                                           @endphp 
                                            
                                            <div class="col-md-3">
                                              <div class="form-check h5">
                                                <input class="form-check-input" type="radio" name="selected" id="s1" value="{{$data->supplier1}} - {{$data->rate1}}" >
                                                <label class="form-check-label" for="s1">
                                                  {{$s1}} - {{$data->rate1}}/-
                                                </label>

                                              </div>
                                            </div>
                                            <div class="col-md-3">
                                              <div class="form-check h5">
                                                <input class="form-check-input" type="radio" name="selected" id="s2" value="{{$data->supplier2}} - {{$data->rate2}}" >
                                                <label class="form-check-label" for="s2">
                                                  {{$s2}} - {{$data->rate2}}/-
                                                </label>

                                              </div>
                                            </div>
                                            <div class="col-md-3">
                                              <div class="form-check h5">
                                                <input class="form-check-input" type="radio" name="selected" id="s3" value="{{$data->supplier3}} - {{$data->rate3}}" >
                                                <label class="form-check-label" for="s3">
                                                  {{$s3}} - {{$data->rate3}}/-
                                                </label>

                                              </div>
                                            </div>
                                            <div class="col-md-3">
                                              <div class="form-check h5">
                                                <input class="form-check-input" type="radio" name="selected" id="s4" value="{{$data->supplier4}} - {{$data->rate4}}" >
                                                <label class="form-check-label" for="s4">
                                                  {{$s4}} - {{$data->rate4}}/-
                                                </label>
                                                
                                              </div>
                                            </div>

                                                    <input type="hidden" name="supplier1" value="{{$data->supplier1}}" >
                                                    <input type="hidden" name="rate1"  value="{{$data->rate1}}" >

                                                    <input type="hidden" name="supplier2" value="{{$data->supplier2}}" >
                                                    <input type="hidden" name="rate2"  value="{{$data->rate2}}" >

                                                    <input type="hidden" name="supplier3"  value="{{$data->supplier3}}" >
                                                    <input type="hidden" name="rate3"  value="{{$data->rate3}}" >

                                                    <input type="hidden" name="supplier4"  value="{{$data->supplier4}}" >
                                                    <input type="hidden" name="rate4"  value="{{$data->rate4}}">
                                    </div>
                                </div>
                                </div>

                                <div class="row col-md-12">
                                    <div class="col-md-6">
									<div class="form-group">
                                            <label class=" col-form-label">Specification:</label>
                                            <textarea name="specification" class="form-control" cols="30"
                                                rows="3">{{$data->specification}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3 font-weight-bold">
                                      <div class="form-group">
                                          <label class=" col-form-label"> Negotiate:</label>
                                          <input type="number" name="negotiate" class="form-control"  placeholder="Negotiate value">
                                      </div>
                                    </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                         <label class=" col-form-label">RFQ No:</label>
                                              <select name="rfq_no" class="form-control select2 orderProduct" >
                                                    <option value=""> Select RFQ No </option>
                                                          @foreach($rfqs as $item)
                                                          <option value="{{ $item->invoice }}" @if($item->invoice == $data->rfq_no) selected  @else  @endif>{{ $item->invoice }}</option>
                                                           @endforeach
                                               </select>
                                        </div>
                                   </div>
                                  
                                  <div class="col-md-12">
									<div class="form-group">
                                            <label class=" col-form-label">Remarks:</label>
                                            <textarea name="description" class="form-control" cols="30"
                                                rows="3">{{$data->description}}</textarea>
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
