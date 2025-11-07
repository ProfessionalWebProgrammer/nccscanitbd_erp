@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('submit.reminder')}}" method="POST">
                @csrf
                <div class="container-fluid">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Set Reminder</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
		
                        <div class="col-md-6 m-auto">
                            <div class="row">
                              <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"> Date :</label>
                                        <div class="col-sm-6">
                                            <input type="date" name="date"  value="" class="form-control">
                                        </div>
                                    </div>
                              </div>

                              <div class="col-md-12">
                                  <div class="form-group row">
                                      <label class="col-sm-3 col-form-label"> Subject: </label>
                                      <div class="col-sm-9">
                                          <input type="text" name="subject" class="form-control" placeholder="Reminder Subject">
                                      </div>
                                  </div>
                              </div>
                               <div class="col-md-12">
                                  <div class="form-group row">
                                      <label class="col-sm-3 col-form-label"> Select Dealer: </label>
                                      <div class="col-sm-9">
                                          <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="dlr_id">
                                              <option value="">Select Dealer</option>
                                              @foreach ($dealers as $dlr)
                                                  <option value="{{ $dlr->id }}">{{ $dlr->d_s_name }}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
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
