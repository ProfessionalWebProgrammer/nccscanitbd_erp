@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ Route('user.password.change') }}" method="POST">
                @csrf
                <div class="container-fluid">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Password</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">

                      

                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Email :</label>
                                <div class="col-sm-9">
                                    <input type="Text"  value="{{Auth::user()->email}}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                                    <input type="hidden" name="id"  value="{{Auth::id()}}" class="form-control" >
                       
                        <div class="col-md-3"></div>


                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Passord: </label>
                                <div class="col-sm-9">
                                    <input type="password" name="password" class="form-control" placeholder="*****">
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="row pb-5">
                    <div class="col-md-3"></div>

                    <div class="col-md-6 mt-3">
                        <div class="text-center">
                            <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">

                    </div>
                </div>
            </form>
        </div>
        <!-- /.container-fluid -->
   <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@push('end_js')


   

@endpush
