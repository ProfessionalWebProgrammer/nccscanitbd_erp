@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('meter.reading.store')}}" method="post">
                @csrf
                <div class="container-fluid">
                    <h3 class="text-center">Meter Reading Entry</h3>
                    <div class="row pt-4">
                      <div class="col-md-3"></div>
                        <div class="col-md-6">
                          
                          
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Meter Select : </label>
                                <div class="col-sm-9">
                                    <select name="meter_no" class="form-control" required>
                                    <option value="">Select Meter</option>

                                    @foreach ($meter as $item)
                                    <option value="{{$item->meter_no}}">{{$item->meter_no}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                           <div class="form-group row">
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
                          
                       {{--   <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label"> Opening Reading: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" name="opening_reading">
                                </div>
                            </div> 
                          --}}
                          
                          
                          
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label"> Present Reading: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" name="input_reading">
                                </div>
                            </div>
                          
                         
                          
                          
                         
                          
                        {{--   <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label"> Production Per Hour: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" name="producton_per_hour">
                                </div>
                            </div>
                          --}}
                          
                          
                    
                         
                          
                          
                          
                          
                          
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
