@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                <div class="pt-3 text-center">
                    <h5 class="font-weight-bolder text-uppercase">Create Form</h5>
                    <hr width="33%">
                </div>
                <form class="floating-labels m-t-40" action="{{ route('direct.labour.cost.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class=" col-form-label">Date:</label>
                                    <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control">
                                </div>

                                <div class="form-group col-md-4">
                                    <label class=" col-form-label">Finished Goods :</label>
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true" data-actions-box="true" multiple name="fg_id[]">
                                        {{--  <option value="">Select Finished Goods</option>  --}}
                                        @foreach ($fgs as $data)
                                            <option style="color: #ff0000; font-weight:bold" value="{{ $data->id }}">
                                                {{ $data->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
							<div class="form-group col-md-3">
                                    <label class=" col-form-label">Cost Chalan No:<span class="text-danger">*</span></label>
                                    <input type="text"  name="chalan_no" class="form-control" required>
                              		<span class="text-danger">Cost Chalan No must be Unique</span>
                                </div>

                            </div>
                            {{-- Multiple Fields --}}
                            <div class="row mt-2">
                                <div id="field" class="col-md-12">
                                    <div class="row fieldGroup rowname">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="row">

                                                        <div class="col-md-4">
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
                                                                <label class="col-form-label">Unit Cost:</label>
                                                            </div>
                                                        </div>
                                                      <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Day:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
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
                                  
                                    <div class="row fieldGroup rowname">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="row">

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="text" name="head[]" class="form-control"
                                                                    required placeholder=" Head">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="number" name="labour_qty[]"
                                                                    class="form-control labour_qty" placeholder="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="number" name="per_person_cost[]"
                                                                    class="form-control per_person_cost" placeholder="">
                                                            </div>
                                                        </div>
                                                      <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="number" name="day[]"
                                                                    class="form-control day" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="number" readonly name="total_cost[]"
                                                                    class="form-control total_cost" placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <a href="javascript:void(0)" style="margin-top: 8px;"
                                                        class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                            class="fas fa-plus-circle"></i></a>
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-sm custom-btn-sbms-remove remove"
                                                        style="margin-top: 8px;"><i class="fas  fa-minus-circle"></i></a>
                                                </div>
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
                    '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-4"> <div class="form-group"> <input type="text" name="head[]" class="form-control" required placeholder=" Head"> </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="number" name="labour_qty[]" class="form-control labour_qty" placeholder=""> </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="number" name="per_person_cost[]" class="form-control per_person_cost" placeholder=""> </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="number" name="day[]" class="form-control day" placeholder=""> </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="number" readonly name="total_cost[]" class="form-control total_cost" placeholder=""> </div> </div> </div> </div> <div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 8px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 8px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> </div>';
                     $(this).parents('.fieldGroup:last').after(fieldHTML);

                $('.select2').select2({
                    theme: 'bootstrap4'
                })

            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
            });




            $('#field').on('input', '.labour_qty, .per_person_cost, .day', function() {

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.fieldGroup');

                var labour_qty = parent.find('.labour_qty').val();
                var per_person_cost = parent.find('.per_person_cost').val();
				var day = parent.find('.day').val();
				if(day){
                parent.find('.total_cost').val(labour_qty * per_person_cost*day);
                } else {
                parent.find('.total_cost').val(labour_qty * per_person_cost);
                }
                

                //   parent.find('.totalvalueid').val(parseFloat(qt)* parseFloat(up));




                //  total();

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
@endpush
