@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-4" ></div>
            <div class="col-md-6" >

                <div class="content px-4 ">

                    <form class="floating-labels m-t-40" action="{{ Route('dealer.zone.update') }}" method="POST">
                        @csrf

                        <div class="container-fluid">
                            <div class="pt-3 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Delaer Zone Create</h4>
                                <hr width="33%">
                            </div>
                            <input type="hidden" name="id" value="{{$dealerzone->id}}">

                            <div class="row pt-4">
                                <div class="form-group col-md-12">
                                    <label class=" col-form-label">Zone Title :</label>

                                    <input type="text" name="zone_title"  value="{{$dealerzone->zone_title}}" required class="form-control"
                                        placeholder="Delar Zone Title">
                                </div>

                                <div class="form-group col-md-12">
                                    <label class=" col-form-label">Main Zone :</label>

                                    <select name="main_zone" class="form-control">
                                        <option value="">Select Main Zone</option>
                                        <option value="EAST" @if($dealerzone->main_zone =="EAST" ) selected @endif >EAST</option>
                                        <option value="WEST" @if($dealerzone->main_zone =="WEST" ) selected @endif >WEST</option>
                                    </select>
                                </div>


                                <div class="form-group col-md-12">
                                    <label class="col-form-label">Zone Description :</label>
                                    <input type="text"  value="{{$dealerzone->zone_description}}" name="zone_description" class="form-control"
                                        placeholder="Delar Zone Description">
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
