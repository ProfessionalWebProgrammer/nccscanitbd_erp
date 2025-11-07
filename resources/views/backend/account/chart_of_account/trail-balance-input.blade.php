@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Trail Balance Input</h5>
                    
                </div>
			<div id="exTab2" class="container">	
		{{-- <ul class="nav nav-tabs mt-4 pt-4">
			<li class="active">
        <a  href="#normal" class="btn btn-sm btn-primary" data-toggle="tab">Normal Method </a>
			</li>
			<li><a href="#weighted" class="btn btn-sm btn-success" data-toggle="tab">Weighted Method</a>
			</li>

		</ul> --}}

			<div class="tab-content ">
			  <div class="tab-pane active" id="normal">
          {{-- Normal Method start  --}}
                <div class="form mt-3">
                    <form class="floating-labels m-t-40" action="{{ Route('chat.of.account.trail.balance') }}" method="GET">
                       
                      <input type="hidden" name="type" value="1">
                        <div class="row">
                            <div class="col-md-2 "></div>
                           
                          <div class="offset-md-2 col-md-4 ">
                                <h5>Select Daterange: <span id="today" style="color: lime; display:inline-block">Today</span></h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date"
                                            class="form-control float-right" id="daterangepicker" required>

                                    </div>
                                </div>
                            </div>
                          
                          
                         
                          

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
