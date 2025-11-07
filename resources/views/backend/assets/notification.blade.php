@extends('layouts.account_dashboard')

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

@section('header_menu')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('asset.notification.list') }}" class=" btn btn-success mr-2">Notification List</a>
    </li>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ Route('asset.notification.store') }}" method="POST">
                @csrf
                <div class="container-fluid pt-5">
                  
                      
                      
                      
                      



                   

                        
                        
                             
                         
                          
                          <div class="row mt-2">
                            
                            <div class="col-md-4 " ><h2>Asset Notification</h2></div>
                              <div class="col-md-4 ">
                                <label class="switch mt-1">
                                    <input type="checkbox" name="status">
                                    <span class="slider round"></span>
                                  </label><span class="pl-2 offclass d-none">OFF</span> <span class="pl-2 onclass d-none">OFF</span>
                              </div>
                            <div class="col-md-4 " ></div>
                            
                             <div class="col-md-4">
                                          <div class="form-group" >
                                              <label class=" col-form-label">Asset Category Name:</label>
                                              <select name="category_id" class="form-control select2">
                                                  <option value="">== Select Category ==</option>
                                                  @foreach ($assetcat as $data)
                                                      <option value="{{ $data->id }}">
                                                          {{ $data->name }}</option>
                                                  @endforeach
                                              </select>
                             		</div>
                             </div>
                            <div class="col-md-4">
                                                <div class="form-group">
                                                  <label class=" col-form-label">Asset Product:</label>
                                                  <select name="product_id" class="form-control select2 assetProduct" required>
                                                    <option value="">== Select Product ==</option>
                                                    @foreach ($product as $item)
                                                    <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                                    @endforeach  
                                                  </select>
                              			</div> 
                             </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-3">
                                                <div class="form-group">
                                                  <label class=" col-form-label">Type:</label>
                                                  <select class="form-control select2"  name="type" required>
                                                    <option >===Select Type===</option>
                                                    <option value="warranty">Warranty</option>
                                                    <option value="license">Lisence</option>
                                                  
                                                    </select>
                              			</div> 
                             </div>
                             
                            
                               <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class=" col-form-label">Notification Date:</label>
                                                  <input type="date" name="before_day" class="form-control">
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
