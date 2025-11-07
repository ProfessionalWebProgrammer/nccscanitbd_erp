@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
          <div class="container">
            <form action="#" method="POST">
                @csrf

                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Emploayee Loan Configuration Create </h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                      <div class="col-md-8 m-auto">
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Head :</label>
                              <div class="col-sm-9">
                                  <input type="text" name="head" class="form-control" placeholder="Loan Head">
                              </div>
                          </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Basic Salary:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="basic_salary" class="form-control" placeholder="Basic Salary">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Loan Amount :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="loan_amount" class="form-control" placeholder="Loan Amount">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Payment Method :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="pay_method" class="form-control" placeholder="Payment Method">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Remarks :</label>
                                <div class="col-sm-9">
                                  <textarea name="note" rows="8" cols="62"></textarea>
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
