@extends('layouts.crm_dashboard')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass" >
		

        <!-- Main content -->
        <div class="content px-4 ">
          <div class="container" style="background: #ffffff;  min-height: 85vh;">
           <div class="row">            
           <div class="col-md-8 m-auto pt-5">     
             <h2 class="text-center"> Progress Report</h2> <hr/>
            <form action="{{route('progress.report.view')}}" method="post">
                @csrf
                
                    <div class="row pt-3">
                        <div class="col-md-6">
                               <label for="inputEmail3" class="">Date : </label> 
                                    <input type="text" value="" class="form-control" name="date" id="daterangepicker" required>
                              
                          
                        </div>
                        <div class="col-md-6">
                                <label class="text-right">Client Name :</label>
                                     <select class="form-control select2" required style="border-radius: 12px !important;font-weight: 800;"  name="dealer_id" id="dealer">
                                       <option style="color:#000;font-weight:600;" value=""> Select Client</option>
                                        @foreach ($clients as $data)
                                            <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                {{ $data->client_name }}</option>
                                        @endforeach
                                    </select>
                            
                        </div>
                      
                    </div>  
                    
                                  
                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3">
                             <button type="submit" class="btn custom-btn-sbms-submit btn-primary" id="showsubmit" style="width: 100%">View Report</button>
                                 
                      </div>
                        <div class="col-md-4 mt-3">

                        </div>
                    </div>
                
                <!-- /.container-fluid -->
            </form>
        </div>
        </div>
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

            $("#daterangepicker").change(function() {
                var a = document.getElementById("today");
               a.style.display = "none";
            });
        });
    </script>

    
@endpush
