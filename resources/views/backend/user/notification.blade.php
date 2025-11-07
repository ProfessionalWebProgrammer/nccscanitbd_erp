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
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ Route('user.setting.set.permission.store') }}" method="POST">
                @csrf
                <div class="container-fluid ml-5">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Set User Notification</h4>
                        <hr width="33%">
                        <h5>{{Auth::user()->name}}</h5>
                        <h6>{{Auth::user()->email}}</h6>
                    </div>
                    <div class="row pt-4 m-auto">
                      <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                      
                      
                      
                      



                   

                        
                        <div class="col-md-10 " >
                         
                         
                             
                           <div class="row mt-2">  
                              <div class="col-md-4 ">Stock Notification</div>
                              <div class="col-md-2 ">
                                <label class="switch mt-1">
                                    <input type="checkbox">
                                    <span class="slider round"></span>
                                  </label>
                              </div>
                              <div class="col-md-3 ">
                                <select class="form-control select2"  name="" >
                                    <option >===Select One===</option>
                                    <option value="1">1 Day</option>
                                    <option value="3">3 Day</option>
                                    <option value="5">5 Day</option>
                                    <option value="7">7 Day</option>
                                    <option value="10">10 Day</option>
                                    <option value="15">15 Day</option>
                                    <option value="30">30 Day</option>
                                    </select>
                           		</div>
                               <div class="col-md-3 ">
                                  <select class="form-control select2"  name="" >
                                    <option >===Select One===</option>
                                    <option value="1">1 Day</option>
                                    <option value="3">3 Day</option>
                                    <option value="5">5 Day</option>
                                    <option value="7">7 Day</option>
                                    <option value="10">10 Day</option>
                                    <option value="15">15 Day</option>
                                    <option value="30">30 Day</option>
                                    </select>
                                 
                           		</div>
                           </div> 
                          
                          <div class="row mt-2">
                              <div class="col-md-4 ">Asset Notification</div>
                              <div class="col-md-2 ">
                                <label class="switch mt-1">
                                    <input type="checkbox">
                                    <span class="slider round"></span>
                                  </label>
                              </div>
                              <div class="col-md-3 ">
                                <select class="form-control select2"  name="" >
                                    <option >===Select One===</option>
                                    <option value="1">1 Day</option>
                                    <option value="3">3 Day</option>
                                    <option value="5">5 Day</option>
                                    <option value="7">7 Day</option>
                                    <option value="10">10 Day</option>
                                    <option value="15">15 Day</option>
                                    <option value="30">30 Day</option>
                                    </select>
                           		</div>
                               <div class="col-md-3 ">
                                  <select class="form-control select2"  name="" >
                                    <option >===Select One===</option>
                                    <option value="1">1 Day</option>
                                    <option value="3">3 Day</option>
                                    <option value="5">5 Day</option>
                                    <option value="7">7 Day</option>
                                    <option value="10">10 Day</option>
                                    <option value="15">15 Day</option>
                                    <option value="30">30 Day</option>
                                    </select>
                                 
                           		</div>
                           </div> 
                          
                     	




                    </div>
                </div>
                <div class="row pb-5">
                  

                    <div class="col-md-12 mt-3">
                        <div class="text-center">
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
@endsection


@push('end_js')


    <script>
        $(document).ready(function() {
            $("#emp").change(function(event) {
                var empid = $(this).val();
                $.ajax({
                    url: '{{ url('get/employee/') }}/' + empid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $("#name").val(data.emp_name)
                        $("#email").val(data.emp_mail_id)
                    }
                });
            });



            $("#salesselect").click(function(){
                $(".salesclass").each(function(){
                  $(this).prop('checked',true); 
                }) 
            });
            $("#salesunselect").click(function(){
                $(".salesclass").each(function(){
                  $(this).prop('checked',false); 
                }) 
            });

            $("#purchaseselect").click(function(){
                $(".purchaseclass").each(function(){
                  $(this).prop('checked',true); 
                }) 
            });
            $("#purchaseunselect").click(function(){
                $(".purchaseclass").each(function(){
                  $(this).prop('checked',false); 
                }) 
            });

            $("#accountsselect").click(function(){
                $(".accountsclass").each(function(){
                  $(this).prop('checked',true); 
                }) 
            });
            $("#accountsunselect").click(function(){
                $(".accountsclass").each(function(){
                  $(this).prop('checked',false); 
                }) 
            });


            $("#settingsselect").click(function(){
                $(".settingsclass").each(function(){
                  $(this).prop('checked',true); 
                }) 
            });
            $("#settingsunselect").click(function(){
                $(".settingsclass").each(function(){
                  $(this).prop('checked',false); 
                }) 
            });
        });
    </script>

@endpush
