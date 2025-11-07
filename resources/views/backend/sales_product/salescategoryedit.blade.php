@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-6 m-auto" >

                <div class="content px-4 ">

                    <form class="floating-labels m-t-40" action="{{ Route('sales.category.update') }}" method="POST">
                        @csrf

                        <div class="container-fluid">
                            <div class="pt-3 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Sales Category Edit</h4>
                                <hr width="33%">
                            </div>
                            <input type="hidden" name="id" value="{{$editabledata->id}}">

                            <div class="row pt-4">
                                <div class="form-group col-md-12">
                                    <label class=" col-form-label">Category Name :</label>

                                    <input type="text" name="category_name"  value="{{$editabledata->category_name}}" required class="form-control" >
                                </div>

                            </div>
                        </div>
                        <div class="row pb-5">
                            <div class="col-md-12 mt-3">
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
