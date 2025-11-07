@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ Route('user.setting.store') }}" method="POST">
                @csrf
                <div class="container-fluid">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">User Create</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Employee:</label>
                                <div class="col-sm-9">
                                    <select name="emp_id" id="emp" class="form-control select2">
                                        <option value="">Select Employee</option>
                                        @foreach ($emp as $data)
                                            <option value="{{ $data->id }}">{{ $data->emp_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> User Tree Setup:</label>
                                <div class="col-sm-9">
                                    <select name="parent_id[]" id="user" class="form-control selectpicker"  data-show-subtext="true"
                                        data-live-search="true" data-actions-box="true" multiple>
                                        <option value="">Select Manager</option>
                                        @foreach ($users as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> User Name :</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="name" id="name" class="form-control" placeholder="User Name">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 offset-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email :</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="email" id="email" class="form-control" placeholder="Email">


                                @error('email')
                                <span style="color:rgb(255, 123, 123)">This Eamil Already Userd, Please Secelt Another Email</span>
                                @enderror
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-3">
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
                    <div class="col-md-2 mt-3 m-auto">
                        <div class="text-center">
                            <button type="submit" class="btn custom-btn-sbms-submit w-100"> Submit </button>
                        </div>
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


@push('end_js')


    <script>
        $(document).ready(function() {
            $("#emp").change(function(event) {
               var empid =  $(this).val();
                $.ajax({
                    url: '{{ url('get/employee/') }}/'+empid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $("#name").val(data.emp_name)
                        $("#email").val(data.emp_mail_id)
                    }
                });
            });
        });
    </script>

@endpush
