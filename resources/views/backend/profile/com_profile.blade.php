@extends('layouts.backendbase')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('company.profile.store')}}" method="post" enctype="multipart/form-data">
                @csrf
              <div class="container-fluid">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Company Profile</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-8  m-auto">
                           <div class="row pt-4">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Company Name :</label>
                                    <div class="col-sm-9">
                                       <input type="Text" name="com_name" value="{{$comdata->com_name ?? ''}}" class="form-control" required placeholder="Company Name">
                                       <input type="hidden" name="id" value="{{$comdata->id?? ''}}">
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Company Logo :</label>
                                    <div class="col-sm-9">
                                       <input type="file" name="com_logo" class="form-control p-1 form-control-file">
                                       <input type="hidden" name="com_logo_old" value="{{$comdata->com_logo?? ''}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Phone :</label>
                                    <div class="col-sm-9">
                                       <input type="Text" name="com_phone" value="{{$comdata->com_phone ?? ''}}" class="form-control" required placeholder="Company Phone">
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Email :</label>
                                    <div class="col-sm-9">
                                       <input type="Text" name="com_email" value="{{$comdata->com_email?? ''}}" class="form-control" required placeholder="Company Email">
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Address Line 1 :</label>
                                    <div class="col-sm-9">
                                       <input type="Text" name="com_address1" value="{{$comdata->com_address_l1 ?? ''}}" class="form-control" required placeholder="Company Address Line 1 ">
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Address Line 2 :</label>
                                    <div class="col-sm-9">
                                       <input type="Text" name="com_address2" value="{{$comdata->com_address_l2?? ''}}" class="form-control" required placeholder="Company Address Line 2">
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="row  mt-3 pb-5">
                    <div class="col-md-6 m-auto">
                        <div class="text-center">
                          @if(!empty($comdata->com_logo?? ''))
                          <img src="{{asset('public/'.$comdata->com_logo)}}" style="width: 78px; border-radius: 50px;" alt="img">
                          @endif 
                            <button type="submit" class="btn custom-btn-sbms-submit "> UPDATE </button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  
@endsection
