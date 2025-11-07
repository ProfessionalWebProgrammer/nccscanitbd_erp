@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Balance Sheet Input</h5>
                    
                </div>
			<div id="exTab2" class="container">	
		<ul class="nav nav-tabs mt-4 pt-4">
			<li class="active">
        <a  href="#normal" class="btn btn-sm btn-primary" data-toggle="tab">Normal Method </a>
			</li>
			<li><a href="#weighted" class="btn btn-sm btn-success" data-toggle="tab">Weighted Method</a>
			</li>

		</ul>

			<div class="tab-content ">
			  <div class="tab-pane active" id="normal">
          {{-- Normal Method start  --}}
                <div class="form mt-3">
                    <form class="floating-labels m-t-40" action="{{ Route('balance.sheet.report') }}" method="POST">
                        @csrf
                      <input type="hidden" name="type" value="1">
                        <div class="row">
                            <div class="col-md-2 "></div>
                            {{-- <div class="col-md-4 ">
                                <h5>Select Date: </h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                       
                                        <input type="date" name="date" 
                                            class="form-control float-right" value="{{date('Y-m-d')}}">

                                    </div>
                                </div>
                            </div> --}}
                          <div class="col-md-4 ">
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
                          
                          
                           <div class="col-md-3">
                               <h5>Taxes(%) : </h5>
                                        <div class="form-group m-b-40">
                                                 <input type="
                                                number" name="taxes"  class="form-control" placeholder="Taxes">
                                        </div>
                                    </div>

                            {{-- <div class="col-md-4">
                                <h5 >Select Area</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple name="dlr_area_id[]">
                                      <option value="">Select Area</option> 
                                        @foreach ($areas as $area)

                                            <option style=" font-weight:bold" value="{{$area->id}}">
                                                {{ $area->area_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                          

                        </div> 

                        <div class="class row">
                            <div class="class col-md-4"></div>
                            <div class="class col-md-4 px-5">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Generate Report</button>


                            </div>
                            <div class="class col-md-4">
                            </div>
                        </div>

                    </form>
                </div>
              {{--  Weighted Method end  --}}

				</div>
				<div class="tab-pane" id="weighted">
          			{{-- Normal Method start  --}}
                <div class="form mt-3">
                    <form class="floating-labels m-t-40" action="{{ Route('balance.sheet.report') }}" method="POST">
                        @csrf
                      <input type="hidden" name="type" value="2">
                        <div class="row">
                            <div class="col-md-2 "></div>
                           {{-- <div class="col-md-4 ">
                                <h5>Select Date: </h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                       
                                        <input type="date" name="date" 
                                            class="form-control float-right" value="{{date('Y-m-d')}}">

                                    </div>
                                </div>
                            </div> --}}
                          
                          <div class="col-md-4 ">
                                <h5>Select Daterange: <span id="today2" style="color: lime; display:inline-block">Today</span></h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date"
                                            class="form-control float-right" id="daterangepicker2">

                                    </div>
                                </div>
                            </div>
                          
                           <div class="col-md-3">
                               <h5>Taxes(%) : </h5>
                                        <div class="form-group m-b-40">
                                                 <input type="
                                                number" name="taxes"  class="form-control" placeholder="Taxes">
                                        </div>
                                    </div>

                            {{-- <div class="col-md-4">
                                <h5 >Select Area</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple name="dlr_area_id[]">
                                      <option value="">Select Area</option> 
                                        @foreach ($areas as $area)

                                            <option style=" font-weight:bold" value="{{$area->id}}">
                                                {{ $area->area_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                          

                        </div> 

                        <div class="class row">
                            <div class="class col-md-4"></div>
                            <div class="class col-md-4 px-5">
                                <button type="submit" class="btn btn-success" style="width: 100%;">Generate Report</button>


                            </div>
                            <div class="class col-md-4">
                            </div>
                        </div>

                    </form>
                </div>
              {{--  Weighted Method end  --}}
				</div>
       
			</div>
  </div> 			
       </div>
        </div>
    </div>
    </div>

@endsection

@push('end_js')

    <script>
        $(document).ready(function() {
			$('#daterangepicker2').daterangepicker({
            timePicker: false,

            locale: {
                format: 'Y-MM-DD'
            }
        });
          
            $("#daterangepicker").change(function() {
                var a = document.getElementById("today");
               a.style.display = "none";
            });
          
          $("#daterangepicker2").change(function() {
                var a = document.getElementById("today2");
               a.style.display = "none";
            });
       
        });
    </script>

@endpush
