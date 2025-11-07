@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
		<div class="content px-4 ">
        <div class="row">
            <div class="col-md-6 m-auto" >

                

                    <form class="floating-labels m-t-40" action="{{ Route('product.unit.update') }}" method="POST">
                        @csrf

                        <div class="container-fluid">
                            <div class="pt-3 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Product Unit Edit</h4>
                                <hr width="33%">
                            </div>
                            <input type="hidden" name="id" value="{{$units->id}}">

                            <div class="row pt-4">
                                <div class="form-group col-md-12">
                                    <label class=" col-form-label">Unit Name :</label>
                                    <input type="text" name="unit_name"  value="{{$units->unit_name}}" required class="form-control" >
                                </div>
                              	<div class="form-group col-md-12">
                                    <label class=" col-form-label">Unit Pcs :</label>
                                    <input type="text" name="unit_pcs"  value="{{$units->unit_pcs}}" required class="form-control" >
                                </div>

                            </div>
                           <div class="row pb-5">
                              <div class="col-md-12 mt-3">
                                  <div class="text-center">
                                      <button type="submit" class="btn custom-btn-sbms-submit"> Update </button>
                                  </div>
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
