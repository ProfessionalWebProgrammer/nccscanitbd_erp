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
                        <h4 class="font-weight-bolder text-uppercase">Rental Goods Delivery Create</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-7 m-auto"> 
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="date">Date :</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="date" name="date" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Assign Rental Customer:</label>
                                <div class="col-sm-9">

                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="market_id">
                                        <option value="">Select Assign Rental Customer</option>
                                        <option value="1">Mr Abdul Karim</option>
                                        <option value="2">Mr Alom Miya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Type of Bag:</label>
                                <div class="col-sm-9">

                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="market_id">
                                        <option value="">Select Type of Bag</option>
                                        <option value="1">PP Bag</option>
                                        <option value="2">Poli Bag</option>
                                        <option value="3">Cloth Bag</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="qty">Quantity :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="qty" name="qty" placeholder="Bag Quantity">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="rate">Rate :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="rate" name="rate" placeholder="Rate">
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
