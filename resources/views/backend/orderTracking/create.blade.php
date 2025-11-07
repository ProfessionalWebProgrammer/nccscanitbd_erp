@extends('layouts.crm_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <form class="floating-labels m-t-40" action="{{ Route('marketingOrder.tracking.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="content px-4 ">
              <input type="hidden" name="user_id" value="{{$userId}}">
                <div class="container" style="background:#fff;padding:0px 40px; min-height:85vh;">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Tracking Entry</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date:</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="date" name="date">
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">PO No :</label>
                                <div class="col-sm-9">

                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="invoice" id="purchaseOrderId">
                                        <option value="">Select PO No</option>
                                         @foreach ($purchaseOrder as $val)
                                            <option value="{{ $val->order_no }}">{{ $val->order_no }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4 " id="orderTracking">
                              <!-- <a href="#" class="btn btn-primary btn-sm mt-1"><span
                                        class="fa fa-eye"></span> View Order</a> -->
                              </div>



                        </div>

                        <h5 class="mt-3 text-uppercase">Product Specification</h5>
                          <hr class="bg-light mt-0 pt-0">
                          {{-- Production Multiple add button code start from here! --}}
                        	<div class="row">
                              <div id="field" class="col-md-12">
                                  <div class="row fieldGroup rowname mb-2">
                                      <div class="col-md-12">
                                        <div class="row">
                                              <div class="col-md-11">
                                                <div class="row">
                                                  <div class="col-md-3">
                                                      <div class="form-group">
                                                          <label  class="col-form-label">Stage : </label>
                                                          <select name="stage[]" class="form-control select2 " required>
                                                              <option value="">== Select Stage ==</option>
                                                              {{-- @foreach ($specifications as $item)
                                                                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                              @endforeach --}}
                                                              @for($i = 1; $i <= 5; $i++)
                                                              <option value="{{$i}}">
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
                                                          <label for="value" class="col-form-label" required>Progress Value (%):  </label>
                                                          <input type="text" class="form-control" name="value[]" id="value">
                                                      </div>
                                                  </div>
                                                  <div class="col-md-7">
                                                      <div class="form-group">
                                                          <label for="value" class="col-form-label" required>Remarks:  </label>
                                                          <input type="text" class="form-control" name="remarks[]" id="value">
                                                      </div>
                                                  </div>
                                                </div>
                                               </div>
                                          	<div class="col-md-1">
                                                <label for="">Action :</label><br>
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
                '<div class="row fieldGroup rowname mb-1"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-3"> <div class="form-group"> <select name="stage[]" class="form-control select2 " > <option value="">== Select Stage ==</option> {{-- @foreach ($specifications as $item) <option value="{{ $item->id }}">{{ $item->name }}</option> @endforeach --}} @for($i = 1; $i <= 5; $i++) <option value="{{$i}}"> {{$i}}- @if($i == 1) st @elseif($i == 2) nd @elseif($i == 3) rd @else th @endif Stage</option> @endfor </select> </div> </div> <div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" name="value[]" id="value"> </div> </div> <div class="col-md-7"> <div class="form-group"> <input type="text" class="form-control" name="remarks[]" id="value"> </div> </div> </div> </div> <div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> </div>';

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

$('#purchaseOrderId').on("change",function(){
  var id = $('#purchaseOrderId').val();
  //alert(id);
  $.ajax({
              url: '{{ url('/marketing/item/purchaseOrder/getId/') }}/' + id,
              type: "GET",
              dataType: 'json',
              success: function(data) {
                //var id = data;
                var str = '<a href="{{url("/settings/purchaseOrder/view/")}}/' + data + '" class="btn btn-primary btn-sm mt-1" target="_blank">View Purchase Order</a>';

                    //console.log(data);
                    $('#orderTracking').html(str);
              }
          });
});
});
    </script>
@endsection
