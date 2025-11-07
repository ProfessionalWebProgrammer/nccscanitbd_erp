@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ Route('employee.team.report.update') }}" method="POST">
                @csrf
                <div class="container-fluid">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase"> Employee Daily Report edit</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4 " style="width:80%; margin: 0 auto">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class=" col-form-label">Date :</label>
                                <div class="">
                                    <input type="date" name="date" class="form-control" value="{{$edata->date}}"  required>
                                    <input type="hidden" name="id" class="form-control" value="{{$edata->id}}"  required>
                                </div>
                            </div>
                        </div>
                      <div class="col-md-6">
                            <div class="form-group ">
                                <label class=" col-form-label">Subject :</label>
                                <div class="">
                                    <input type="Text" name="subject" class="form-control" value="{{$edata->subject}}" placeholder="Subject" required>
                                </div>
                            </div>
                        </div>

                      <div class="col-md-6">
                            <div class="form-group ">
                                <label class=" col-form-label">Type :</label>
                                <div class="">
                                      <select name="type" id="selecttype" class="form-control select2" required>
                                         <option value="" >== Select Type ==</option>
                                         <option value="1" @if($edata->type == 1) selected @endif >Team</option>
                                         <option value="2" @if($edata->type == 2) selected @endif >Employee</option>

                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-6" id="teamsection" style="display:none">
                            <div class="form-group ">
                                <label class=" col-form-label"> Employee Team :</label>
                                <div class="">
                                    <select name="team_id" class="form-control select2" id="">
                                         <option value="">== Select Employee Team ==</option>
                                        @foreach ($employeeteam as $item)
                                            <option value="{{ $item->id }}" @if($edata->emp_team_id == $item->id ) selected @endif>{{ $item->title }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                       <div class="col-md-6" id="empsection"  style="display:none">
                            <div class="form-group ">
                                <label class="col-form-label"> Employee :</label>
                                <div class="">
                                    <select name="emp_id" class="form-control select2" id="">
                                         <option value="">== Select Employee ==</option>
                                        @foreach ($employee as $item)
                                            <option value="{{ $item->id }}" @if($edata->emp_id == $item->id ) selected @endif>{{ $item->emp_name }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                      <div class="col-md-12"></div>




                       <div class="col-md-12">
                            <div class="form-group ">
                                <label class="col-form-label">Report Description : </label>
                                <div class="">
                                    <textarea name="description" class="form-control" id="" cols="30" rows="6"
                                        placeholder="Description">{{$edata->note}}</textarea>
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
   var thisval = $("#selecttype").val();
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
