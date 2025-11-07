@extends('layouts.account_dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <!-- Main content -->
    <div class="content px-4 ">
        <div class="container-fluid">
            <div class="pt-3 text-center">
                <h4 class="font-weight-bolder text-uppercase">LTR Entry</h4>
                <hr width="33%">
            </div>

            <form class="floating-labels m-t-40" action="{{Route('ltr.store')}}" method="POST">
                @csrf
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-3">
                                         <div class="form-group">
                                            <label class=" col-form-label">Date:</label>
                                            <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control">
                                    	</div>
                                    </div>
                             
                                  
                                
                                  
                                  
                                   <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=" col-form-label">Payment Mode:</label>
                                            <select name="payment_mode" class="form-control select2" id="payment_type">
                                                <option value="">== Select Type ==</option>
                                                <option value="Bank">Bank Payment</option>
                                                <option value="Cash">Cash Payment</option>
                                            </select>
                                        </div>
                                       </div>
                                    <div class="col-md-4">
                                        <div class="form-group" id="bank_name" style="display: none" >
                                            <label class=" col-form-label">Bank Name:</label>
                                            <select name="bank_id" class="form-control select2">
                                                <option value="">== Select Bank ==</option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->bank_id }}">{{ $bank->bank_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group" id="werehouse_name" style="display: none">
                                            <label class=" col-form-label">Wirehouse Name:</label>
                                            <select name="warehouse_id" class="form-control select2">
                                                <option value="">== Select Wirehouse ==</option>
                                                @foreach ($cashes as $cash)
                                                    <option value="{{ $cash->wirehouse_id }}">
                                                        {{ $cash->wirehouse_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                       </div> 
                                      
                                  
                                     <div class="col-md-4">
                                       <div class=" form-group">
                                           <label class=" col-form-label">Head:</label>
                                              <input type="Text" name="head" class="form-control" placeholder=" Head" >
                                        
                                      </div>
                                    </div>
                                  
                                   <div class="col-md-3">
                                       <div class=" form-group">
                                           <label class=" col-form-label">Amount:</label>
                                              <input type="Text" name="amount" class="form-control" placeholder=" Amount" >
                                        
                                      </div>
                                    </div>
                                  
                                  
                                     <div class="col-lg-6">
                                       <div class=" form-group row">
                                           <label class=" col-form-label">Desciption:</label>
                                              <input type="Text" name="description" class="form-control" placeholder=" Description" >
                                        
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
                        </div>
             </form>
  
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
{{--
<script>
    $(document).ready(function() {
        //add more fields group
        $("body").on("click", ".addMore", function() {
            var fieldHTML =
                ' <div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-5"> <div class="form-group"> <input type="text" name="head[]" class="form-control" placeholder="Head"> </div></div><div class="col-md-4"> <div class="form-group"> <select  class="form-control select2" name="inocome_source_id[]"> <option value="">Select Source</option> @foreach ($iss as $data) <option value="{{$data->id}}">{{$data->name}}</option> @endforeach </select> </div></div><div class="col-md-3"> <div class="form-group"> <input type="number" name="amount[]" class="form-control" placeholder=" Amount"> </div></div></div></div><div class="col-md-1">  <a href="javascript:void(0)" style="margin-top: 8px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 8px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div></div>';
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
</script> --}}
@endsection
  
  @push('end_js')
  
  <script>
     $(document).ready(function() {
            $('#payment_type').on('change', function() {
                var payment_type = $(this).val();
                console.log(payment_type);
                if (payment_type != '') {

                    if (payment_type == "Bank") {
                        // console.log("Value is" + payment_type);
                        $("#werehouse_name").css("display", "none")
                        $("#bank_name").css("display", "block");
                    }

                    if (payment_type == "Cash") {
                        // console.log("Value is two" + payment_type);
                        $("#werehouse_name").css("display", "block")
                        $("#bank_name").css("display", "none");
                    }
                } else {
                    // console.log("Value Not Founded");
                    $("#werehouse_name").css("display", "none")
                    $("#bank_name").css("display", "none");
                }

            });
            
        });
  </script>
  @endpush