@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-6 m-auto" >

                <div class="content px-4 ">

                    <form class="floating-labels m-t-40" action="{{ Route('sales.sub.category.update') }}" method="POST">
                        @csrf

                        <div class="container-fluid">
                            <div class="pt-3 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Sales Sub Category Edit</h4>
                                <hr width="33%">
                            </div>
                            <input type="hidden" name="id" value="{{$editabledata->id}}">
                            <div class="form-group row pt-2">
                                  <label class="col-sm-3 col-form-label ">Category :</label>
                                  <div class="col-sm-9">
                                      <select class="form-control select2" name="cat_id" >
                                        <option value="">Select One Must <span style="color: red">*</span></option>
                                        @foreach($salesCats as $val )
                                          <option value="{{$val->id}}" @if($editabledata->cat_id = $val->id) selected  @else  @endif >{{$val->category_name}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                            <div class="row ">
                                <div class="form-group col-md-12">
                                    <label class=" col-form-label">Sub Category Name :</label>
                                    <input type="text" name="name"  value="{{$editabledata->name}}"  class="form-control" >
                                </div>

                            </div>
                        </div>
                        <div class="row pb-5">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                                </div>
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
