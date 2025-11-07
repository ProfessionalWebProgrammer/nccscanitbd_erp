@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ Route('employee.team.report.view') }}" method="POST">
                @csrf
                <div class="container-fluid">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase"> Employee Daily Report</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4 " >
                        <div class="col-md-3">
                            <div class="form-group ">
                                <label class=" col-form-label">Select DateRange :</label>
                                <div class="">
                                   <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date"
                                            class="form-control float-right" id="daterangepicker" >

                                    </div>
                                </div>
                            </div>
                        </div>


                     <div class="col-md-3" >
                            <div class="form-group ">
                                <label class=" col-form-label"> Subject :</label>
                                <div class="">
                                    <select name="subject" class="form-control select2" id="">
                                         <option value="">== Select Subject ==</option>
                                        @foreach ($subject as $item)
                                            <option value="{{ $item->subject }}">{{ $item->subject }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-3" >
                            <div class="form-group ">
                                <label class=" col-form-label"> Employee Team :</label>
                                <div class="">
                                    <select name="team_id" class="form-control select2" id="">
                                         <option value="">== Select Employee Team ==</option>
                                        @foreach ($employeeteam as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                       <div class="col-md-3" >
                            <div class="form-group ">
                                <label class="col-form-label"> Employee :</label>
                                <div class="">
                                    <select name="emp_id" class="form-control select2" id="">
                                         <option value="">== Select Employee ==</option>
                                        @foreach ($employee as $item)
                                            <option value="{{ $item->id }}">{{ $item->emp_name }}</option>

                                        @endforeach
                                    </select>
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

    $("#selecttype").on('change', function() {
     var thisval = $(this).val();

      if(thisval == 1){
      	$("#empsection").css('display',"none");
      	$("#teamsection").css('display',"block");
      }else if(thisval == 2){
      	$("#empsection").css('display',"block");
      	$("#teamsection").css('display',"none");
      }else{
       	$("#empsection").css('display',"none");
      	$("#teamsection").css('display',"none");

      }
    });


  });

</script>
@endsection
