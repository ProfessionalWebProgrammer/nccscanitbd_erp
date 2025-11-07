@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('meter.update')}}" method="post">
                @csrf
                <div class="container-fluid">
                    <h3 class="text-center">Meter Edit</h3>
                    <div class="row pt-4">
                      <div class="col-md-3"></div>
                        <div class="col-md-6">
                           <input type="hidden"  class="form-control" name="id" value="{{$meter->id}}">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Meter No : </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" value="{{$meter->meter_no}}" name="meter_no" required>
                                </div>
                            </div>
                           <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Meter Name : </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" value="{{$meter->meter_name}}" name="meter_name">
                                </div>
                            </div>
                          
                            
                        {{--   <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label"> Date: </label>
                                <div class="col-sm-9">
                                    <input type="date"  class="form-control" name="date" value="{{date('Y-m-d')}}">
                                </div>
                            </div>
                          
                          <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label"> Time: </label>
                                <div class="col-sm-9">
                                    <input type="time"  class="form-control" name="time">
                                </div>
                            </div> 
                          
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label"> Present Reading: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" name="input_reading">
                                </div>
                            </div>
                          
                          --}}
                          
                           <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label"> Opening Reading: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" value="{{$meter->opening_reading}}" name="opening_reading">
                                </div>
                            </div>
                          
                         
                          
                           <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label"> Production Per Hour: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" value="{{$meter->producton_per_hour}}" name="producton_per_hour">
                                </div>
                            </div>
                          
                          
                          <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label"> Per Cycle Rotation: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" value="{{$meter->per_cycle_rotation}}" name="per_cycle_rotation">
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
