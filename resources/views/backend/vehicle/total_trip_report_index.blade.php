@extends('layouts.settings_dashboard')


@push('addcss')

<style>
  /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 25px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ff2e2e;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 17px;
  width: 17px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

  </style>
@endpush


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass">


        <!-- Main content -->
        <div class="content px-4 pt-4">
            <form action="{{route('total.trip.report.view')}}" method="post">
                @csrf
                <div class="container-fluid">
                    <h3 class="text-center">Total Trip Report Input</h3> <hr>
                    <div class="row pt-4">
                     
                      
                       <div class="col-md-4 m-auto">
                                <h5>Select Daterange: <span id="today" style="color: lime; display:inline-block">Today</span></h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date" 
                                            class="form-control float-right" id="daterangepicker">

                                    </div>
                                </div>
                            </div>
                    </div>
                  
                    <div class="row pb-5">
                        <div class="col-md-4 mt-3">

                        </div>
                        <div class="col-md-4 mt-3">
                                 <button type="submit" class="btn custom-btn-sbms-submit" style="width: 100%"> Submit</button>
                         </div>
                        <div class="col-md-4 mt-3">

                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </form>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    
@endsection


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
