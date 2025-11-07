@extends('layouts.employee_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 pt-5">
            <div class="form container ">
                    <form class="floating-labels pt-4" action="#" method="POST">
                        @csrf
                        <div class="row">

                           <div class="col-md-12">
                                <h3 class="text-center mb-4"> Leave Application  Form </h3> <hr>
                            </div>
                           <div class="col-md-6 m-auto">
                                <label>My Name: </label>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                      <input type="text" class="form-control" name="emp_name" value="">
                                    </div>
                                </div>
                            </div>
                           <div class="col-md-6 m-auto">
                                <label>My ID: </label>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                      <input type="text" class="form-control" name="emp_name" value="">
                                    </div>
                                </div>
                            </div>

                           <div class="col-md-6 m-auto">
                                <label>Email: </label>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                      <input type="text" class="form-control" name="emp_name" value="">
                                    </div>
                                </div>
                            </div>
                           <div class="col-md-6 m-auto">
                                <label>Phone: </label>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                      <input type="text" class="form-control" name="emp_name" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 m-auto">
                                 <label>Position: </label>
                                 <div class="form-group m-b-40">
                                     <div class="input-group">
                                       <input type="text" class="form-control" name="emp_name" value="">
                                     </div>
                                 </div>
                             </div>
                            <div class="col-md-6 m-auto">
                                 <label>Leave Type: </label>
                                 <div class="form-group m-b-40">
                                     <div class="input-group">
                                       <input type="text" class="form-control" name="emp_name" value="">
                                     </div>
                                 </div>
                             </div>
                            <div class="col-md-6 m-auto">
                                 <label>Manager Name: </label>
                                 <div class="form-group m-b-40">
                                     <div class="input-group">
                                       <input type="text" class="form-control" name="emp_name" value="">
                                     </div>
                                 </div>
                             </div>
                            <div class="col-md-6 m-auto">
                                 <label>Manager Email: </label>
                                 <div class="form-group m-b-40">
                                     <div class="input-group">
                                       <input type="text" class="form-control" name="emp_name" value="">
                                     </div>
                                 </div>
                             </div>

                          	<div class="col-md-6 m-auto">
                                <label>Request Date or Hours: </label>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                      	<input type="text" name="date"
                                            class="form-control float-right" >
                                    </div>
                                </div>
                            </div>
                          	<div class="col-md-6 m-auto">
                                <label>Date: </label>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                      	<input type="date" name="date"
                                            class="form-control float-right" >
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-12 m-auto">
                                    <label>Leave Resone: </label>
                                    <div class="input-group">
                                      	<textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                                    </div>
                                </div>

                           	</div>
                            <div class="row">
                                <div class="col-md-12 text-center mt-3 pb-5">
                                      <button class="btn btn-sm btn-primary px-5" type="submit">Submit</button>
                                </div>
                              </div>
                    </form>
                </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
@push('end_js')

    <script>
        $(document).ready(function() {


            $("#daterangepicker").change(function() {
                var a = document.getElementById("today");
               a.style.display = "none";
            });






        });
    </script>

@endpush
@endsection
