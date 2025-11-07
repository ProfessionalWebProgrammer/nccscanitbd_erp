@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('machine.update')}}" method="post">
                @csrf
                <div class="container-fluid">
                    <h3 class="text-center">Machine Edit</h3>
                    <div class="row pt-4">
                      <div class="col-md-3"></div>
                        <div class="col-md-6">
                           <input type="hidden"  class="form-control" name="id" value="{{$machine->id}}">
                          <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Select Factory: </label>
                            <div class="col-sm-9">
                            <select name="factory_id" class="form-control select2 ">
                                    <option value="">== Select Factory ==</option>
                                       @foreach ($factory as $item)
                                        <option value="{{ $item->id }}" @if($machine->factory_id == $item->id) selected  @else @endif>{{ $item->factory_name }}</option>
                                       @endforeach
                             </select>
                          	</div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Machine Name : </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" value="{{$machine->name}}" name="name">
                                </div>
                            </div>
                          
                            
                           <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Machine Type: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" value="{{$machine->type}}" name="type">
                                </div>
                            </div>
                         
                          
                           <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Work: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" value="{{$machine->work}}" name="work">
                                </div>
                            </div>
                          
                          <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Production Per Hour: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" value="{{$machine->production_per_hour}}" name="production_per_hour">
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Lifecycle: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" value="{{$machine->lifecycle}}" name="lifecycle">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Efficiency: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" value="{{$machine->efficiency}}" name="efficiency">
                                </div>
                            </div>
                          
                          
                          <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Machine Description: </label>
                                <div class="col-sm-9">
                                    <textarea id="w3review" class="form-control" name="description" rows="4" cols="50">{{$machine->description}}</textarea>
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
