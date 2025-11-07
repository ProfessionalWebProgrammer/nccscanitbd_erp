@extends('layouts.crm_dashboard')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass" >
		

        <!-- Main content -->
        <div class="content px-4 ">
          <div class="container" style="background: #ffffff;  min-height: 85vh;">
            <form action="{{route('progress.store')}}" method="post">
                @csrf
                
                    <div class="row pt-3">
                        <div class="col-md-4">
                               <label for="inputEmail3" class="">Date : </label>
                                    <input type="date" value="" class="form-control" name="date">
                              
                          
                        </div>
                        <div class="col-md-4">
                                <label class="text-right">Client Name :</label>
                                     <select class="form-control select2" style="border-radius: 12px !important;font-weight: 800;" required name="dealer_id" id="dealer">
                                        <option value="">Select Vandor</option>
                                        @foreach ($clients as $data)
                                            <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                {{ $data->client_name }}</option>
                                        @endforeach
                                    </select>
                            
                        </div>
                      <div class="col-md-4">
                               <label for="inputEmail3" class="">Contacts Person : </label>
                                    <input type="text" value="" class="form-control" name="contact_person">
                              
                          
                        </div>
                      <div class="col-md-4 pt-2">
                               <label for="inputEmail3" class="">Reference : </label>
                                    <input type="text"  value="" class="form-control" name="reference">
                              
                          
                        </div>
                      
                       <div class="col-md-8 pt-2">
                               <label for="inputEmail3" class="">Note/Description : </label>
                                  <textarea class="form-control" name="description" rows="3"></textarea>
                              
                          
                        </div>
                      
                      
                      {{--  <div class="col-md-2 ">
                            <div class="mb-3">
                                Invoice No: <span class="mt-4 font-weight-bold" id="invoiceNo"> </span>

                            </div>
                          <div class="mb-3 pt-3">
                               Credite Limit: <span class="mt-4 font-weight-bold" id="creditlimit"> </span>
                             <input type="hidden" class="form-control " id="creditl"  >
                             <input type="hidden" class="form-control " id="dlrbalance"  >
                            
                             <input type="hidden" class="form-control " id="clamount"  >

                            </div>
                        </div>  --}}
                    </div>  
                    {{-- Multiple add button code start from here! --}}
                    <div class="row mt-5">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="row">
                                              
                                                <div class="col-md-4"></div>
                                              <div class="col-md-4"> 
                                                <label for="">Subject :</label>
                                                <input type="text" class="form-control "    name="subject[]">
                                              </div>
                                                <div class="col-md-4">
                                                    <label for="">Note :</label>
                                                    <input type="text" class="form-control " name="note[]" placeholder="Note">
                                                </div>
                                               
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label for="">Action :</label>
                                            <a href="javascript:void(0)" style="margin-top: 3px;"
                                                class="btn custom-btn-sbms-add btn-light btn-sm addMore"><i
                                                    class="fas fa-plus-circle"></i></a>
                                            <a href="javascript:void(0)"  class="btn btn-danger btn-sm custom-btn-sbms-remove remove"
                                                style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>
                                        
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- multiple add end on here --}}
                     <div class="row pb-5 mt-5">
                       
                       <div class="col-md-6 pt-2">
                                       <label for="inputEmail3" class="">Client Feedback : </label>
                                          <textarea class="form-control" name="feedback"  rows="3"></textarea>

                        </div>
              			<div class="col-md-6 pt-2">
                          		<div class="row">
                                  	<div class="col-md-6 ml-auto">
                                       <label for="inputEmail3" class="">Progress Ratio : </label>
                                       <input type="number"  class="form-control" name="converted_percent">
                          			</div>
                          		</div>
                          <div class="row">	
                            <div class="mt-3 col-md-6 ml-auto">
                            
                            <label class="pt-2">Deal Status:</label>
                            <div class="row">
                              <div class="pt-2 col-6">
                            	<div class="form-group row">
                                  <label class="col-9 text-right">Done</label>                             
                                  <input type="radio" name="deal_status" value="done" style="height: 25px;" class="form-control col-3">
                          		</div>
                          	</div>
                            <div class="pt-2 col-6">
                              	<div class="form-group row">
                                  <label class="col-9 text-right">Not Done</label>                             
                                  <input style="height: 25px;" name="deal_status" value="not_done"  type="radio" class="form-control col-3 text-left">
                          		</div>
                          	</div>
                            </div>
                          </div>

                         </div>              
                         </div>              
                         </div>              
                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3">
                             <button type="submit" class="btn custom-btn-sbms-submit btn-primary" id="showsubmit" style="width: 100%">Progress Entry</button>
                                 
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
</div>

 <!-- /.modal-Warning -->

 	<div class="modal fade" id="modal-warning">
        <div class="modal-dialog">
          <div class="modal-content bg-warning">
            <div class="modal-header">
              <h4 class="modal-title">Warning</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p id="warningmodaltext"></p>
            </div>
            <div class="modal-footer justify-content-between">
              <p  ></p>
              <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
              
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->   
    
@endsection


@push('end_js')


<script>
    $(document).ready(function() {
      
        

        var x = 1
        //add more fields group
        $("body").on("click", ".addMore", function() {
            x = x+1;
            var fieldHTML =
                '<div class="row fieldGroup rowname pt-2"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-4"></div><div class="col-md-4"> <input type="text" class="form-control " name="subject[]"> </div><div class="col-md-4"> <input type="text" class="form-control " name="note[]" placeholder="Note"> </div></div></div><div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-light btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-danger btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div><div class="col-md-2"></div></div></div></div>';

          $(this).parents('.fieldGroup:last').after(fieldHTML);
         
         
          $('.select2').select2({
            theme: 'bootstrap4'
            })
         
       
        

           
           
          
        });


       
       


        
        //remove fields group
        $("body").on("click", ".remove", function() {
            $(this).parents(".fieldGroup").remove();
            total();
            x = x-1;
            console.log(x);
            
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
    
 $(document).ready(function() {
   
  
 

   
    
    	$("#sbtn" ).click(function( event ){
        $.ajax({
            url : '{{url('sales/salesNumber')}}',
            type: "GET",
            dataType: 'json',
            success : function(data){
              if(data.length!=0)
              {
                  var dln = parseInt(data[0].invoice_no)+1;
                  document.getElementById("invoiceNo").innerHTML = dln;
              }
              else{
                  document.getElementById("invoiceNo").innerHTML = 100001;
              }
              
          }
        });
    });





 
 

}); 
 
</script>


    
@endpush
