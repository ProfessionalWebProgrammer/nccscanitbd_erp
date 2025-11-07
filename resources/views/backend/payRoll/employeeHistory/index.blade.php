@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ Route('employee.history.report.view') }}" method="POST">
                @csrf
                <div class="container">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase"> Employee History Report</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4 " >
                       <div class="col-md-3 m-auto" >
                            <div class="form-group ">
                                <label class="col-form-label"> Employee :</label>
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple name="emp_id[]">
                                       @foreach($employee as $val)
                                       <option value="{{$val->id}}">{{$val->emp_name}}</option>
                                       @endforeach
                                   </select>

                            </div>
                        </div>
                    </div>

                <div class="row pb-5">
                    <div class="col-md-2 m-auto  mt-3">
                            <button type="submit" class="btn custom-btn-sbms-submit w-100 "> View History </button>
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
