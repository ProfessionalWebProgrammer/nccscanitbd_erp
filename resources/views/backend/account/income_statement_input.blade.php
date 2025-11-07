@extends('layouts.account_dashboard')

@push('addcss')
    <style>
        .text_sale {
            color: #f7ee79;
        }

        .text_credit {
            color: lime;
        }

    </style>
@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="py-4">
                    <div class="text-center">
                        <h4 class="text-uppercase font-weight-bold">Income Statement Input</h4>
                        {{-- <hr style="background: #ffffff78;"> --}}
                    </div>
                  <div id="exTab2" class="container">	
			{{--	<ul class="nav nav-tabs mt-4 pt-4">
                  <li class="active">
              		<a  href="#normal" class="btn btn-sm btn-primary" data-toggle="tab">Normal Method </a>
                  </li>
                  <li>
                    <a href="#weighted" class="btn btn-sm btn-success" data-toggle="tab">Weighted Method</a>
                  </li>

              </ul> --}}

			<div class="tab-content ">
			  <div class="tab-pane active" id="normal">
          {{-- Normal Method start  --}}
                    <form action="{{ route('income.statement.report') }}" method="POST">
                        @csrf
                      <input type="hidden" name="type" value="1">
                        <div class="row pt-3">
                            <div class="col-md-12">
                                <div class="row ">
                                 {{--    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label class="col-form-label">Date :</label>
                                            <div class="">
                                                <input class="
                                                form-control" type="date"
                                                value="{{ date('Y-m-d') }}" name="date"
                                                placeholder="Product Name">
                                            </div>
                                        </div>
                                    </div>  --}}
                    		 <div class="col-md-4 m-auto">
                               <h5>Select Daterange: <span id="today" style="color: lime; display:inline-block">Today</span></h5> 
                               {{-- <h5>Select Daterange: </h5> --}}
                                <div class="form-group m-b-40">
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

                                {{-- <div class="row mt-3">
                                    <h3>All Incomes</h3>
                                    <hr>
                                    <div id="field" class="col-md-12">
                                        <div class="row fieldGroup rowname">
                                            <div class="col-md-12">
                                                <div class="row">
            
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                           
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="">Head</label>
                                                                    <input type="text" required  name="income_head[]" class="form-control ">
                                                                </div>
                                                               
                                                            </div>
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-4">
                                                                <div class="form-group row">
                                                                    <label for="">Amount</label>
                                                                    <input type="number" required  name="income_amount[]" class="form-control amount">
                                                                </div>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">Action :</label> <br>
                                                        <a href="javascript:void(0)" style="margin-top: 3px;"
                                                            class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                        <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"
                                                            style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>
            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <h3>All Expanse</h3>
                                    <hr>
                                    <div id="field2" class="col-md-12">
                                        <div class="row fieldGroup2 rowname2">
                                            <div class="col-md-12">
                                                <div class="row">
            
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                           
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="">Head</label>
                                                                    <input type="text" required  name="expanse_head[]" class="form-control amount">
                                                                </div>
                                                               
                                                            </div>
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-4">
                                                                <div class="form-group row">
                                                                    <label for="">Amount</label>
                                                                    <input type="number" required  name="expasne_amount[]" class="form-control amount">
                                                                </div>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">Action :</label> <br>
                                                        <a href="javascript:void(0)" style="margin-top: 3px;"
                                                            class="btn custom-btn-sbms-add btn-sm addMore2"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                        <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove2"
                                                            style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>
            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  --}}
         
                                    <div class="class row">
                                        <div class="class col-md-4"></div>
                                        <div class="class col-md-4 px-5">
                                            <button type="submit" class="btn btn-primary" style="width: 100%;">Generate Report</button>
                                        </div>
                                        <div class="class col-md-4">
                                        </div>
                                    </div>
                            </div>
                           
                        </div>
                    </form>
              {{--  Normal Method end  --}}

				</div>
				<div class="tab-pane" id="weighted">
          			{{-- Weighted Method start  --}}
                    <form action="{{ route('income.statement.report') }}" method="POST">
                        @csrf
                      <input type="hidden" name="type" value="2">
                        <div class="row pt-3">
                            <div class="col-md-12">
                                <div class="row ">
                                 {{--    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label class="col-form-label">Date :</label>
                                            <div class="">
                                                <input class="
                                                form-control" type="date"
                                                value="{{ date('Y-m-d') }}" name="date"
                                                placeholder="Product Name">
                                            </div>
                                        </div>
                                    </div>  --}}
                    		 <div class="col-md-4 m-auto">
                                <h5>Select Daterange: <span id="today2" style="color: lime; display:inline-block">Today</span></h5> 
                              {{-- <h5>Select Daterange:</h5> --}}
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
                                </div>

                                {{-- <div class="row mt-3">
                                    <h3>All Incomes</h3>
                                    <hr>
                                    <div id="field" class="col-md-12">
                                        <div class="row fieldGroup rowname">
                                            <div class="col-md-12">
                                                <div class="row">
            
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                           
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="">Head</label>
                                                                    <input type="text" required  name="income_head[]" class="form-control ">
                                                                </div>
                                                               
                                                            </div>
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-4">
                                                                <div class="form-group row">
                                                                    <label for="">Amount</label>
                                                                    <input type="number" required  name="income_amount[]" class="form-control amount">
                                                                </div>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">Action :</label> <br>
                                                        <a href="javascript:void(0)" style="margin-top: 3px;"
                                                            class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                        <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"
                                                            style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>
            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <h3>All Expanse</h3>
                                    <hr>
                                    <div id="field2" class="col-md-12">
                                        <div class="row fieldGroup2 rowname2">
                                            <div class="col-md-12">
                                                <div class="row">
            
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                           
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="">Head</label>
                                                                    <input type="text" required  name="expanse_head[]" class="form-control amount">
                                                                </div>
                                                               
                                                            </div>
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-4">
                                                                <div class="form-group row">
                                                                    <label for="">Amount</label>
                                                                    <input type="number" required  name="expasne_amount[]" class="form-control amount">
                                                                </div>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">Action :</label> <br>
                                                        <a href="javascript:void(0)" style="margin-top: 3px;"
                                                            class="btn custom-btn-sbms-add btn-sm addMore2"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                        <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove2"
                                                            style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>
            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  --}}
         
                                    <div class="class row">
                                        <div class="class col-md-4"></div>
                                        <div class="class col-md-4 px-5">
                                            <button type="submit" class="btn btn-success" style="width: 100%;">Generate Report</button>
                                        </div>
                                        <div class="class col-md-4">
                                        </div>
                                    </div>
                            </div>
                           
                        </div>
                    </form>
              {{--  Weighted Method end  --}}
				</div>
			</div>
  			</div>
                  
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {


           
            //add more fields group
           /* $("body").on("click", ".addMore", function() {
             
                var fieldHTML = '<div class="row fieldGroup rowname"> <div class="col-md-12"> <div class="row"> <div class="col-md-8"> <div class="row"> <div class="col-md-6"> <div class="form-group row"> <input type="text" required name="income_head[]" class="form-control amount"> </div></div><div class="col-md-1"></div><div class="col-md-4"> <div class="form-group row"> <input type="number" required name="income_amount[]" class="form-control amount"> </div></div></div></div><div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div>';
                    $(this).parents('.fieldGroup:last').after(fieldHTML);

                
              




            });


            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
            });


            $("body").on("click", ".addMore2", function() {
             
             var fieldHTML = '<div class="row fieldGroup2 rowname2"> <div class="col-md-12"> <div class="row"> <div class="col-md-8"> <div class="row"> <div class="col-md-6"> <div class="form-group row"> <input type="text" required name="expanse_head[]" class="form-control amount"> </div></div><div class="col-md-1"></div><div class="col-md-4"> <div class="form-group row"> <input type="number" required name="expasne_amount[]" class="form-control amount"> </div></div></div></div><div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore2"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove2" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div></div></div></div>';
                 $(this).parents('.fieldGroup2:last').after(fieldHTML);

         });

         $("body").on("click", ".remove2", function() {
             $(this).parents(".fieldGroup2").remove();
          }); */
          
           $('#daterangepicker2').daterangepicker({
            timePicker: false,

            locale: {
                format: 'Y-MM-DD'
            }
        });

        });
      
         $(document).ready(function() {

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
    
@endsection
