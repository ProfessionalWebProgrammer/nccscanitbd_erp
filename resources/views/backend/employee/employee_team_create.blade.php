@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ Route('employee.team.store') }}" method="POST">
                @csrf
                <div class="container-fluid">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase"> Team Combination</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Title :</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="title" class="form-control" placeholder="Team Title " required>
                                </div>
                            </div>
                        </div>
                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Head :</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="head" class="form-control" placeholder="Team Head " required>
                                </div>
                            </div>
                        </div>



                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Team Member :</label>
                                <div class="col-sm-9">
                                    <select name="emp_id[]" class="form-control select2" id="" multiple required>
                                        {{-- <option value="">== Select Team Member ==</option>  --}}
                                        @foreach ($employee as $item)
                                            <option value="{{ $item->id }}">{{ $item->emp_name }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Description : </label>
                                <div class="col-sm-9">
                                    <textarea name="description" class="form-control" id="" cols="30" rows="2"
                                        placeholder="Description"></textarea>
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

<script>

  $(document).ready(function() {
          $(".select2_multiple").select2({
            multiple: true,

        });

  });

</script>
@endsection
