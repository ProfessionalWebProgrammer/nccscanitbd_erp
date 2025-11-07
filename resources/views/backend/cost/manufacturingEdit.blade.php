@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
      <div class="content px-4 ">
        <div class="container">
            
            <div class="pt-3 text-center">
                <h5 class="font-weight-bolder text-uppercase">Manufacturing Cost Edit Form</h5>
                <hr width="33%">
            </div>
            <form class="floating-labels m-t-40" action="{{route('manufacturing.cost.update')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                      			<input type="hidden" name="invoice" value="{{$data->invoice}}" />
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class=" col-form-label">Date:</label>
                                        <input type="date" value="{{$data->date }}" name="date" class="form-control">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class=" col-form-label">Finished Goods :</label>
                                        <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true" data-actions-box="true" multiple
                                        name="fg_id[]" >
                                        <option value="">Select Finished Goods</option>
                                          
                                        @foreach ($fg_ids as $index => $val)
                                        	@foreach ($fgs as $key =>$data)
                                          	
                                              @if($data->id == $val->fg_id)
                                              <option style="color: #ff0000; font-weight:bold" value="{{ $data->id }}" @if($data->id == $val->fg_id) selected @else  @endif>
                                                   {{++$key}} - {{ $data->product_name }}
                                              </option>
                                              @else 
                                              @endif
                                      		@endforeach
                                        @endforeach
                                          @php 
                                          $count= 0; 
                                          $count = $index + 1; 
                                          @endphp 
                                      {{-- @foreach ($fgs as $data)
                                      	 <option style="color: #ff0000; font-weight:bold" value="{{ $data->id }}">
                                                {{ $data->product_name }}
                                            </option>
                                       @endforeach --}}
                                    </select>
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
                                                                    <label class=" col-form-label"> Head:</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Quantity:</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Rate:</label>
                                                                </div>
                                                            </div>
                                                            
                                                          
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Total Cost:</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="">Action :</label>
                                                    </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                      @foreach($datas as $val)
                                     
                                        <div class="row fieldGroup rowname">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <input type="text" name="head[]"
                                                                        class="form-control"  value="{{$val->head}}">
                                                                  <input type="hidden" name="head_id[]" value="{{$val->head_id}}"/>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" name="qty[]"
                                                                     class="form-control qty" value="{{$val->qty}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" name="rate[]"
                                                                      class="form-control rate" step="any" value="{{$val->rate*$count}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <input type="number" name="total_cost[]"
                                                                        class="form-control total_cost" step="any" value="{{$val->total_cost*$count}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a href="javascript:void(0)" style="margin-top: 8px;"
                                                            class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a>
                                                        <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"
                                                            style="margin-top: 8px;"><i class="fas  fa-minus-circle"></i></a>
                                                    </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                      			@endforeach
                      
                                </div>
                            </div>

                            <div class="col-md-12 pb-5 mt-5">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button type="submit" class="btn custom-btn-sbms-submit"> Supdate </button>
                                    </div>
                                </div>
                              
                            </div>
                        </div>                  
            </form>
        </div>
        </div>
    </div>
  
@endsection


@push('end_js')
  <script>
        $(document).ready(function() {
            //add more fields group
            $("body").on("click", ".addMore", function() {
                var fieldHTML =
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-5"> <div class="form-group"> <input type="text" name="head[]" class="form-control" required placeholder=" Head"> <input type="hidden" name="head_id[]" value=""/> </div></div><div class="col-md-2"> <div class="form-group"> <input type="number" required name="qty[]" class="form-control qty" placeholder=""> </div></div><div class="col-md-2"> <div class="form-group"> <input type="number" required name="rate[]" class="form-control rate" placeholder=""> </div></div><div class="col-md-3"> <div class="form-group"> <input type="number" name="total_cost[]"  class="form-control total_cost" placeholder=""> </div></div></div></div><div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 8px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 8px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div>';
                $(this).parents('.fieldGroup:last').after(fieldHTML);

                $('.select2').select2({
                    theme: 'bootstrap4'
                    })        
            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
            });

            $('#field').on('input','.rate, .qty',function(){

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');

                var qty=parent.find('.qty').val();
                var rate=parent.find('.rate').val();
               // var per_person_cost = parent.find('.per_person_cost').val();
              
                parent.find('.total_cost').val(qty*rate);

                //   parent.find('.totalvalueid').val(parseFloat(qt)* parseFloat(up));
              //  total();

                });
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
