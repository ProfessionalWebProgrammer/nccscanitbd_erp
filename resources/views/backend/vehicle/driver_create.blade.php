@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('driver.store')}}" method="post">
                @csrf
                <div class="container-fluid">
                    <h3 class="text-center">Driver Create</h3>
                    <div class="row pt-4">
                      <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Driver Name : </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" name="name">
                                </div>
                            </div>
                          
                            
                           <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Vehicle Number: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" name="vehicle_number">
                                </div>
                            </div>
                          
                           <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Driver Phone: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" name="phone">
                                </div>
                            </div>
                          
                          <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Address: </label>
                                <div class="col-sm-9">
                                    <textarea id="w3review" class="form-control" name="address" rows="4" cols="50"></textarea>
                                </div>
                            </div>
                        </div>
                       
                     
                    </div>
                  
                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3">
                                 <button type="submit" class="btn custom-btn-sbms-submit" style="width: 100%"> Submit</button>
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
    
@endsection


@push('end_js')


<script>
    $(document).ready(function() {

       

     

}); 




  
</script>


    
@endpush
