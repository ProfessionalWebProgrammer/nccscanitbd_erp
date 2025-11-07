@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper ">


        <!-- Main content -->
        <form class="floating-labels m-t-50" action="#" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="content px-4 ">

                <div class="container" style="background:#fff;padding:0px 40px; min-height:85vh;">
                    <div class="pt-5 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Rental Organization Create</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-6"> 
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="name">Organization Name :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="pname" name="name" placeholder="Organization Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="person">Contact Person :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="person" name="person" placeholder="Contact Person Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="address">Address:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Contact Address">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="phone">Phone:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Contact Phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="mobile">Mobile:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Contact Mobile">
                                </div>
                            </div>
   
                        </div>

                        <div class="col-md-6">
                           <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="email">Email:</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Contact Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Market Assign :</label>
                                <div class="col-sm-9">

                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="market_id">
                                        <option value="">Select Market Assign</option>
                                        <option value="1">Courier Services</option>
                                        <option value="2">Food Services</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Agent Assign :</label>
                                <div class="col-sm-9">

                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="agent_id">
                                        <option value="">Select Agent Assign</option>
                                        <option value="1">Global Courier Services</option>
                                        <option value="2">Deshi Foods</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="balance">Opening Balance:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="balance" name="balance" placeholder="Opening Balance">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Image:</label>
                                <div class="col-sm-9">
                                    <input type="file"  name="image">
                                <span class="text-danger"></span>
                                </div>
                            </div>

                            </div>
                            
                        </div>

                    <div class="row pb-5">
                        <div class="col-md-6 mt-3">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary custom-btn-sbms-submit"> Submit </button>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">

                        </div>
                    </div>

					</div>
                    <!-- /.container-fluid -->
                </div>

        </form>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script>
    $(document).ready(function() {

        var x = 1
        //add more fields group
        $("body").on("click", ".addMore", function() {
            x = x+1;
            var fieldHTML =
                '';
          $(this).parents('.fieldGroup:last').after(fieldHTML);

         selected();
          $('.select2').select2({
            theme: 'bootstrap4'
            })

        });


        //remove fields group
        $("body").on("click", ".remove", function() {
            $(this).parents(".fieldGroup").remove();
          //  total();
            x = x-1;
            //console.log(x);

        });
});
    </script>
@endsection
