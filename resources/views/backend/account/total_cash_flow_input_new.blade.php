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
                        <h4 class="text-uppercase font-weight-bold">Cash Flow Input</h4>
                        <hr style="background: #ffffff78;">
                    </div>
                    <form action="{{ route('new.total.cash.flow.report') }}" method="POST">
                        @csrf
                        <div class="row pt-3">
                            <div class="col-md-12">
                                <div class="row ">
                                  <div class="col-md-4 "></div>
                    		 <div class="col-md-4 ">
                                <h5>Select Date:</h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="date" name="date" value="{{date('Y-m-d')}}"
                                            class="form-control float-right" >

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

                            </div>
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {


           
            //add more fields group
            $("body").on("click", ".addMore", function() {
             
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
          });

     







        });


      
         $(document).ready(function() {

            $("#daterangepicker").change(function() {
                var a = document.getElementById("today");
               a.style.display = "none";
            });

            

           


        });
      
     
    </script>
    
@endsection
