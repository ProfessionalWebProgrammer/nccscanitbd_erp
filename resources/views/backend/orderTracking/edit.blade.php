@extends('layouts.crm_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <form class="floating-labels m-t-40" action="{{ Route('marketingOrder.tracking.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="content px-4 ">
                <div class="container" style="background:#fff;padding:0px 40px; min-height:85vh;">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Tracking Edit</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date:</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="date" name="date" value={{$data->date}}>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">PO No :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="invoice" value="{{$data->invoice}}" readonly>
                                  {{--  <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="invoice">
                                        <option value="">Select PO No</option>
                                         @foreach ($purchaseOrder as $val)
                                            <option value="{{ $val->order_no }}" @if($data->invoice == $val->order_no) selected @else  @endif>{{ $val->order_no }}</option>
                                        @endforeach

                                    </select> --}}
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4 ">
                                <a href="{{route('purchaseOrder.view',$purchaseId)}}" class="btn btn-primary btn-ms " target="_blank"><span
                                                  class="fa fa-eye"></span> View Purchase Order</a>
                              </div>



                        </div>

                        <h5 class="mt-3 text-uppercase">Product Specification</h5>
                          <hr class="bg-light mt-0 pt-0">
                          {{-- Production Multiple add button code start from here! --}}
                        	<div class="row">
                              <div id="field" class="col-md-12">
                                  <div class="row fieldGroup rowname ">
                                      <div class="col-md-12">
                                        <div class="row">
                                              <div class="col-md-11">
                                                <div class="row">
                                                  <div class="col-md-3">
                                                      <div class="form-group">
                                                          <label  class="col-form-label">Stage : </label>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-2">
                                                      <div class="form-group">
                                                          <label for="value" class="col-form-label" required>Progress Value (%):  </label>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-7">
                                                      <div class="form-group">
                                                          <label for="value" class="col-form-label" required>Remarks:  </label>

                                                      </div>
                                                  </div>
                                                </div>
                                               </div>
                                          	<div class="col-md-1">
                                                <label for="">Action :</label><br>
                                            	</div>
                              				</div>
                        					</div>
                              	</div>
                                @foreach($datas as $val)
                                <div class="row fieldGroup rowname mb-1">
                                    <div class="col-md-12">
                                      <div class="row">
                                            <div class="col-md-11">
                                              <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <select name="stage[]" class="form-control select2 " required>
                                                            <option value="">== Select Stage ==</option>

                                                            @for($i = 1; $i <= 5; $i++)
                                                            <option value="{{$i}}" @if($val->stage == $i) selected @else  @endif>
                                                              {{$i}}-
                                                              @if($i == 1)
                                                              st
                                                              @elseif($i == 2)
                                                              nd
                                                              @elseif($i == 3)
                                                              rd
                                                              @else
                                                              th
                                                              @endif
                                                               Stage</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="hidden" name="id[]" value="{{ $val->id }}">
                                                        <input type="text" class="form-control" name="value[]" id="value" value="{{$val->value}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="form-group">

                                                        <input type="text" class="form-control" name="remarks[]" id="value" value="{{$val->remarks}}">
                                                    </div>
                                                </div>
                                              </div>
                                             </div>
                                          <div class="col-md-1">

                                              <a href="javascript:void(0)" style="margin-top: 3px;"
                                                    class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                        class="fas fa-plus-circle"></i></a>
                                                <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"
                                                    style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>
                                            </div>
                                    </div>
                                </div>
                              </div>
                              @endforeach

                            	</div>
                            </div>

                    <div class="row pb-5">
                        <div class="col-md-6 mt-3">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary custom-btn-sbms-submit"> Submit </button>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">

                        </div>
                    </div>

					</div>
                    <!-- /.container-fluid -->
                </div>

        </form>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script>
    $(document).ready(function() {

        var x = 1
        //add more fields group
        $("body").on("click", ".addMore", function() {
            x = x+1;
            var fieldHTML =
                '<div class="row fieldGroup rowname mb-1"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-3"> <div class="form-group"> <select name="stage[]" class="form-control select2 " > <option value="">== Select Stage ==</option> {{-- @foreach ($specifications as $item) <option value="{{ $item->id }}">{{ $item->name }}</option> @endforeach --}} @for($i = 1; $i <= 5; $i++) <option value="{{$i}}"> {{$i}}- @if($i == 1) st @elseif($i == 2) nd @elseif($i == 3) rd @else th @endif Stage</option> @endfor </select> </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="hidden" name="id[]" value="0"> <input type="text" class="form-control" name="value[]" id="value"> </div> </div> <div class="col-md-7"> <div class="form-group"> <input type="text" class="form-control" name="remarks[]" id="value"> </div> </div> </div> </div> <div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> <div class="col-md-4"> </div> </div>';

          $(this).parents('.fieldGroup:last').after(fieldHTML);

         selected();
          $('.select2').select2({
            theme: 'bootstrap4'
            })

        });


        //remove fields group
        $("body").on("click", ".remove", function() {
            $(this).parents(".fieldGroup").remove();
          //  total();
            x = x-1;
            //console.log(x);

        });
});
    </script>
@endsection
