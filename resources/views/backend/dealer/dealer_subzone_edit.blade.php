@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-6 m-auto" >

                <div class="content px-4 ">

                    <form class="floating-labels m-t-40" action="{{ Route('dealer.subzone.update') }}" method="POST">
                        @csrf

                        <div class="container-fluid">
                            <div class="pt-3 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Delaer SubZone Create</h4>
                                <hr width="33%">
                            </div>
                            <input type="hidden" name="id" value="{{$dealersubzone->id}}">

                            <div class="row pt-4">
                                <div class="form-group col-md-12">
                                    <label class=" col-form-label">SubZone Title :</label>

                                    <input type="text" name="subzone_title"  value="{{$dealersubzone->subzone_title}}" required class="form-control"
                                        placeholder="Delar SubZone Title">
                                </div>

                              


                                <div class="form-group col-md-12">
                                    <label class="col-form-label">SubZone Description :</label>
                                    <input type="text" name="subzone_description"  value="{{$dealersubzone->subzone_description}}" class="form-control"
                                        placeholder="Delar SubZone Description">
                                </div>

                            </div>
                        </div>
                        <div class="row pb-5">
                            <div class="col-md-6 mt-3">
                                <div class="text-right">
                                    <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">

                            </div>
                        </div>

                    </form>

                </div>
            </div>



          
        </div>

    </div>
    <!-- /.content-wrapper -->
    <script>
     
    </script>
@endsection
