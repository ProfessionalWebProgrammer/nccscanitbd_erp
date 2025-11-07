@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">


        <!-- Main content -->
        <div class="content px-4 pt-3">
            <form action="{{route('trip.store')}}" method="post">
                @csrf
                <div class="container-fluid">
                    <h3 class="text-center">Trip Create</h3> <hr>
                    <div class="row pt-4">
                     
                       <div class="col-md-4">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Date: </label>
                                <div class="col-sm-9">
                                    <input type="date" value="{{date('Y-m-d')}}" class="form-control" name="date">
                                </div>
                            </div>
                         </div>
                      <div class="col-md-4">
                      	<div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Note: </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="note">
                                </div>
                            </div>
                      </div>
                      <div class="col-md-4">   
                           <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Commission: </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="commission">
                                </div>
                            </div>                        
                        </div>
                      
                      <div class="col-md-6">   
                           <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Driver Name: </label>
                                <div class="col-sm-9">
                                     <select class="form-control select2" required name="driver_id" >
                                        <option value="">Select Driver name</option>
                                        @foreach ($drivers as $data)
                                            <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                {{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        
                        </div>
                  		<div class="col-md-6">   
                           <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Vehicle Number: </label>
                                <div class="col-sm-9">
                                   <select class="form-control select2" required name="vehicle_id" >
                                        <option value="">Select Vehicle Number</option>
                                        @foreach ($vehicles as $data)
                                            <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                {{ $data->vehicle_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>                        
                        </div>
                      
                      
                       <div class="col-md-12">
                      {{-- Multiple Fields --}}
                                <div class="row mt-3">
                                    <div id="field" class="col-md-12">
                                        <div class="row fieldGroup rowname">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                      <div class="row">
                                                        <div class="col-md-4">
                                                          <div class="form-group">
                                                              <label for="inputEmail3" class="col-form-label">From Plase: </label>
                                                              <div class="">
                                                                  <input type="text"  class="form-control" name="from_place[]">
                                                              </div>
                                                          </div>
                                                       </div>
                                                        <div class="col-md-4">   
                                                         <div class="form-group">
                                                              <label for="inputEmail3" class="col-form-label">To Plase:</label>
                                                              <div class="">
                                                                  <input type="text"  class="form-control" name="to_place[]">
                                                              </div>
                                                          </div>
                                                        </div> 
                                                        <div class="col-md-4">   
                                                         <div class="form-group ">
                                                              <label for="inputEmail3" class="col-form-label">Trip Amount:</label>
                                                              <div class="">
                                                                  <input type="text"  class="form-control income_value" name="trip_amount[]">
                                                              </div>
                                                          </div>
                                                        </div>
                                                  	  </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                      <div class="form-group ">
                                                        <label for="">Action :</label> <br>
                                                        <a href="javascript:void(0)" style="margin-top: 8px;"
                                                            class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-sm custom-btn-sbms-remove remove"
                                                            style="margin-top: 8px;"><i
                                                                class="fas  fa-minus-circle"></i></a>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                      {{--Multiple end--}}
                      </div>
                       </div>
                      	
                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3 text-center">
                          		 <h5 class="mb-3">Total Trip Amount: <span id="total_amount">0</span>/-</h5>
                          		 <input type="hidden" id="total_trip_amount"  class="form-control" name="total_trip_amount">
                                 <button type="submit" class="btn custom-btn-sbms-submit" style="width: 100%"> Submit</button>
                         </div>
                        <div class="col-md-4 mt-3">

                        </div>
                    </div>
                <!-- /.container-fluid -->
            </form>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    
@endsection


@push('end_js')
<script>
        $(document).ready(function() {
            //add more fields group
            $("body").on("click", ".addMore", function() {
                var fieldHTML =
                    ' <div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-4"> <div class="form-group"> <div class=""> <input type="text" class="form-control" name="from_place[]"> </div></div></div><div class="col-md-4"> <div class="form-group"> <div class=""> <input type="text" class="form-control" name="to_place[]"> </div></div></div><div class="col-md-4"> <div class="form-group "> <div class=""> <input type="text" class="form-control income_value" name="trip_amount[]"> </div></div></div></div></div><div class="col-md-1"> <div class="form-group "> <a href="javascript:void(0)" style="margin-top: 8px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 8px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div></div></div>';
                $(this).parents('.fieldGroup:last').after(fieldHTML);

                $('.select2').select2({
                    theme: 'bootstrap4'
                    })
         
            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
            });
 });
</script>

<script>
       function oilcalculation() {
            var qty = $('#oil_qty').val();
            var rate = $('#oil_rate').val();
            var aw = qty * rate;
            $('#oil_expanse').val(aw);
        }
  		
  		   $('#field').on('input','.income_value',function(){

                var parent = $(this).closest('.fieldGroup');
                var totalvalueid=parent.find('.total_price').val();
                parent.find('.total_price').val(totalvalueid);
			total();
           });
  
  			function total(){
                var total = 0;

                $(".income_value").each(function(){
                    var totalvalueid = $(this).val()-0;
                    total +=totalvalueid;
                    $('#total_value').html(total);
                    console.log(total);
                })
                 $('#total_amount').html(total);
                 $('#total_trip_amount').val(total);
              
            }
</script>


    
@endpush
