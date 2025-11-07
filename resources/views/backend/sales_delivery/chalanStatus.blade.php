@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">

        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('chalan.status.update', $salesdetails->invoice_no)}}" method="post">
                @csrf
                <div class="container" style="background:#f5f5f5; padding:0px 40px;min-height:85vh">
                    <div class="row pt-5">
                        <div class="col-md-2">
                          <h5>Date: {{date("d-m-Y", strtotime($salesdetails->date))}}</h5> </br>

                        </div>
                        <div class="col-md-4">
                           <h5>Vendor Name: {{$salesdetails->d_s_name}}</h5>


                          </div>
                        <div class="col-md-4">
                          <h5>Branch/Warehouse: {{$salesdetails->factory_name}}</h5>

                        </div>

                        <div class="col-md-2 text-right">
                          <span class="h5">Invoice No: {{$salesdetails->invoice_no}}</span> </br></br>

                                <input type="hidden" name="invoice" value="{{$salesdetails->invoice_no}}">
                        </div>
                        <div class="col-md-2">
                          <div class="form-group row mt-3 ">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Date: </label>
                                <div class="col-sm-9">
                                   <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="date">
                                 {{-- <input type="hidden" value="{{date("Y-m-d", strtotime($salesdetails->date))}}" name="date"> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                          <div class="form-group row pt-3">
                                <label for="driver" class="col-sm-4 col-form-label">Driver Name: </label>

                            <div class="col-sm-8">
                            	 <input type="text" value="" class="form-control" name="driver">
                            </div>

                            </div>

                          </div>
                        <div class="col-md-4">

                          <div class="form-group row pt-3">
                                <label for="driver" class="col-sm-4 col-form-label">Driver Phone: </label>

                            <div class="col-sm-8">
                            	 <input type="text" class="form-control" name="phone">
                            </div>

                            </div>
                        </div>

                        <div class="col-md-2 text-right">
                      		<div class="form-group row pt-3">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Vehicle: </label>
                                <div class="col-sm-9">
                                   <input type="text" value="{{$salesdetails->vehicle  ?? ''}}" class="form-control" name="vehicle">

                                </div>
                            </div>
                        </div>

          			<div class="col-md-9">
                      <div class="form-group row">
                                <label for="dlr_address" class="col-sm-2 col-form-label">Dealer Address: </label>
                                <div class="col-sm-10">
                                   <input type="text" class="form-control" id="dlr_address" value="{{$salesdetails->dlr_address ?? ''}}" name="dlr_address">
                                </div>
                            </div>
          			</div>

          			<div class="col-md-3 right">

                      		<div class="form-group row">
                                <label for="cost" class="col-sm-5 col-form-label">Transport Cost: </label>
                                <div class="col-sm-7">
                                   <input type="text" class="form-control" id="cost" value="{{$salesdetails->transport_cost ?? ''}}" name="transport_cost">
                                </div>
                            </div>

                      </div>
                      <div class="col-md-12">
                            <div class="form-group row">
                                      <label for="dlr_address" class="col-sm-1 col-form-label">Naration: </label>
                                      <div class="col-sm-11">
                                         <input type="text" class="form-control"  value="{{$salesdetails->narration ?? ''}}" name="narration">
                                      </div>
                                  </div>
                			</div>
                    </div>

                    {{-- Multiple add button code start from here! --}}
                    <div class="row mt-5">
                        <div id="field" class="col-md-12">
                            @foreach ($salesitems as $item)

                                <div class="row fieldGroup rowname">
                                    <div class="col-md-12">
                                        <div class="row">

                                                    <div class="col-md-6">
                                                        <label for="">Product Name:</label>
                                                         <input type="text" class="form-control product" name="products[]" value="{{ $item->product_name }}" readonly >
                                                         <input type="hidden" name="product_id[]" value="{{ $item->product_id }}" >
                                                         <input type="hidden" name="id[]" value="{{$item->id}}">
                                                         <input type="hidden" name="item_type[]" value="{{$item->item_type}}">
                                                         <input type="hidden" name="unit_price[]" value="{{$item->unit_price}}">
                                                         <input type="hidden" name="discount[]" value="{{$item->discount}}">
                                                      	 <input type="hidden" name="discount_amount[]" value="{{$item->discount_amount}}">
                                                         <input type="hidden" name="total_price[]" value="{{$item->total_price}}">
                                                    </div>


                                                    <div class="col-md-2">
                                                        <label for="">Total Quantity :</label>
                                                      @if(!empty($item->delivery_qty))
                                                      <input type="text" class="form-control p_qty" name="qty[]"  value="{{$item->qty - $item->delivery_qty}}" readonly>
                                                      @else
                                                        <input type="text" class="form-control p_qty" name="qty[]"  value="{{$item->qty}}" readonly>
                                                      @endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">Delivery Quantity:</label>
                                                        <input type="text" class="form-control d_qty"  name="delivery_qty[]" value="{{$item->qty - $item->delivery_qty}}">
                                                      	@if(!empty($item->delivery_qty))
                                                      	<input type="hidden" name="pre_delivery_qty[]" value="{{$item->delivery_qty}}">
                                                      	@endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">Remain Quantity:</label>
                                                       <input type="text" class="form-control r_qty"  name="remain_qty[]" readonly  value="0">
                                                     {{--  <input type="text" class="form-control r_qty"  name="remain_qty[]" readonly  @if(!empty($item->remain_qty)) value="{{$item->remain_qty}}" @else value="0"  @endif>  --}}
                                                    </div>

                                        </div>
                                    </div>
                                </div>


                            @endforeach

                        </div>
                    </div>
                    {{-- multiple add end on here --}}
                   {{-- <div class="row">
                        <div class="col-md-12 mt-3">

                          <div class="mt-5">
                            	<label for="narration">Narration :</label>
                            	<textarea name="narration" form="form-control col-md-6" rows="3" cols="100%">{{$salesdetails->narration}}</textarea>

                          </div>
                        </div>
                    </div> --}}
                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3">
                            {{--    <button type="submit" class="btn custom-btn-sbms-submit btn-primary"  onclick="myChalan()" style="width: 100%"> Chalan Update</button> --}}
                           <button type="submit" class="btn custom-btn-sbms-submit btn-primary" id="showsubmit" style="width:100%; display:none;"> Chalan Confirm </button>
                           {{-- <button type="button" class="btn custom-btn-sbms-submit btn-primary" id="hidesubmit"  style="width:100%" data-toggle="modal" data-target="#showchalanModal"> Chalan Update</button> --}}
                            <button type="submit" class="btn custom-btn-sbms-submit btn-primary" style="width:100%" > Chalan Confirm</button>

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

<!-- /.Modal -->
<div class="modal fade" id="showchalanModal">
        <div class="modal-dialog">
          <div class="modal-content text-danger" >
            <div class="modal-header">
              <h4 class="modal-title">Chalan Confirm Warning</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body ">

               <p>Please Check the Delivery Product Quantity! </p>
            </div>
            <div class="modal-footer justify-content-between">
                <p></p>
              <button type="button" class="btn btn-primary"data-dismiss="modal">Ok</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


@endsection


@push('end_js')


<script>
  /* function myChalan(){
  confirm("Please Check the Delivery Product Quantity!");
  } */


/*
  $(document).ready(function() {
		
    $("#showchalanModal").on('show.bs.modal', function(event) {
    	$("#showsubmit").css("display","block");
     	$("#hidesubmit").css("display","none");
    });

   $('#field').on('input','.d_qty',function(){

                var parent = $(this).closest('.fieldGroup');

                var tq = parent.find('.p_qty').val();
                var dq = parent.find('.d_qty').val();
     			var rq = tq - dq ;
     //alert(rq);
                parent.find('.r_qty').val(rq);

   });



    }); */
</script>



@endpush
