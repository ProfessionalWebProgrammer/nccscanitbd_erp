@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <form class="floating-labels m-t-40" action="{{Route('supplier.store')}}" method="POST">
            @csrf

        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="pt-3 text-center">
                    <h4 class="font-weight-bolder text-uppercase text-danger">Supplier Create</h4>
                    <hr width="33%">
                </div>

                <div class="row pt-4">
                    <div class="col-md-12">
                      <div class="row">


                        <div class="form-group col-md-6 row">
                            <label class="col-sm-3 col-form-label text-primary font-weight-bold" >Agent Name :</label>
                            <div class="col-sm-9">
                                <input type="text" name="supplier_name" class="form-control" placeholder="Agent Name">
                            </div>
                        </div>
                        <div class="form-group col-md-6 row">
                            <label class="col-sm-3 col-form-label text-primary font-weight-bold" >Contact No :</label>
                            <div class="col-sm-9">
                                <input type="text" name="supplier_name" class="form-control" placeholder="Contact No">
                            </div>
                        </div>
                        <div class="form-group col-md-6 row">
                            <label class="col-sm-3 col-form-label text-primary font-weight-bold" >Area:</label>
                            <div class="col-sm-9">
                                <input type="text" name="supplier_name" class="form-control" placeholder="Area ">
                            </div>
                        </div>

                        <div class="form-group col-md-6 row">
                            <label class="col-sm-3 col-form-label text-primary"> Address : </label>
                            <div class="col-sm-9">
                                <input type="Text" name="address" class="form-control" placeholder="Address">
                            </div>
                        </div>

                        </div>


                    </div>
                </div>
              <div class="row pb-5">
                <div class="col-md-6 mt-3">
                    <div class="text-right">
                        <button type="submit" class="btn custom-btn-sbms-submit btn-primary"> Submit </button>
                    </div>
                </div>
                <div class="col-md-6 mt-3">

                </div>
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
            //add more fields group

        });
    </script>
@endsection
