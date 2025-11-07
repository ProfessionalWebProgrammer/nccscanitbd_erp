@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('vehicle.store')}}" method="post">
                @csrf
                <div class="container-fluid">
                    <h3 class="text-center">Vehicle Create</h3>
                    <div class="row pt-4">
                      <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Vehicle Name : </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" name="vehicle_title">
                                </div>
                            </div>
                          
                             <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Category Select:</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" required name="category_id" >
                                        <option value="">Select Category</option>
                                        @foreach ($category as $data)
                                            <option style="color:#000;font-weight:600;" value="{{ $data->id }}">
                                                {{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                           <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Vehicle Number: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" name="vehicle_number">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Oil Opening Balance: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" name="oil_opening">
                                </div>
                            </div>
                          
                          <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Vehicle Description: </label>
                                <div class="col-sm-9">
                                    <textarea id="w3review" class="form-control" name="description" rows="4" cols="50"></textarea>
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
