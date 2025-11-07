@extends('layouts.crm_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ route('client.store') }}" method="POST">
                @csrf
                 <div class="container" style="background:#fff; min-height:85vh;">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Client Create</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Client Name:</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="client_name" class="form-control" required
                                        placeholder="Client Name">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Company Name  :</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="company_name" class="form-control" placeholder="Company Name ">
                                </div>
                            </div>
                        </div>
                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Designations:</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="designations" class="form-control" placeholder=" Designations">
                                </div>
                            </div>
                        </div>
                      
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Phone:</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="phone" class="form-control" placeholder=" Phone">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email:</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" class="form-control" placeholder=" Email">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Contact Person:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="contact_person" class="form-control" placeholder="Contact Person">
                                </div>
                            </div>
                        </div>
                      
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Contract Value:</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="contract_value" class="form-control" placeholder=" Contract Value">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Time Duration:</label>
                                <div class="col-sm-9">
                                    <input type="date" name="time_duration" class="form-control" placeholder=" Contract Value">
                                </div>
                            </div>
                        </div>
                      
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Address:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="address" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row pb-5">
                    <div class="col-md-6 mt-3">
                        <div class="text-right">
                            <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">

                    </div>
                </div>
            </form>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
