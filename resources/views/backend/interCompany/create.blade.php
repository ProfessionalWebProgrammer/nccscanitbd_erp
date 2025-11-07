@extends('layouts.crm_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <form class="floating-labels m-t-40" action="{{ route('inter.company.store') }}" method="POST" >
            @csrf

            <div class="content px-4 ">


                <div class="container" style="background:#fff;padding:0px 40px; min-height:85vh;">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Item Create</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-8 m-auto" >
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Company Name :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="pname" name="name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Address :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control"  name="address">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Opening Balance :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control"  name="balance">
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

    </script>
@endsection
