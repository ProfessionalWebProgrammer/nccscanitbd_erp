@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
          <div class="container">
            <form action="{{route('hrpayroll.employee.product.store')}}" method="POST">
                @csrf

                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Product Create </h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">

                     <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Name:</label>
                                <div class="col-sm-9">
                                   <input type="text" class="form-control" name="name" placeholder="Item Name">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Category :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="category" placeholder="Item Category">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Item Style :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="style" placeholder="Item Style">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Item Process :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="process" placeholder="Item Process">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Item Rate :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="rate" placeholder="Item Rate">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label"> Remarks :</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" name="note" placeholder="Remarks">
                              </div>
                          </div>
                        </div>
                  </div>

                <div class="row pb-5">
                    <div class="col-md-12 mt-3">
                        <div class=" col-md-1 m-auto">
                            <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                        </div>
                    </div>

                </div>
            </form>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <!-- /. -->
@endsection
