@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('commission.store')}}" method="post">
                @csrf
                <div class="container-fluid">
                    <h3 class="text-center">Commission Set</h3>
                    <div class="row pt-4">
                      <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Commission Rate: </label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control" name="commission">
                                </div>
                            </div>
                          <div class="col-md-4 mt-3">
                                 <button type="submit" class="btn custom-btn-sbms-submit" style="width: 100%"> Submit</button>
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
