@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-4" ></div>
            <div class="col-md-4" >

                <div class="content px-4 ">

                    <form class="floating-labels m-t-40" action="{{ Route('dealer.area.update') }}" method="POST">
                        @csrf

                        <div class="container-fluid">
                            <div class="pt-3 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Delaer Area Create</h4>
                                <hr width="33%">
                            </div>
                            <input type="hidden" name="id" value="{{$dealerarea->id}}">

                            <div class="row pt-4">
                                <div class="form-group col-md-12">
                                    <label class=" col-form-label">Area Title :</label>

                                    <input type="text" name="area_title" value="{{$dealerarea->area_title}}" class="form-control"
                                        placeholder="Delar Area Title">
                                </div>

                                <div class="form-group col-md-12">
                                    <label class=" col-form-label">Subzone : (Optional)</label>

                                    <select name="subzone_id" class="form-control">
                                        <option value="">Select Subzone</option>

                                        @foreach ($dealersubzone as $item)
                                        <option value="{{$item->id}}" @if($dealerarea->subzone_id == $item->id ) selected @endif>{{$item->subzone_title}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group col-md-12">
                                    <label class="col-form-label">Area Description :</label>
                                    <input type="text" name="area_description"  value="{{$dealerarea->area_description}}" class="form-control"
                                        placeholder="Delar Area Description">
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
