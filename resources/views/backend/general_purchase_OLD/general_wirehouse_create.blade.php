@extends('layouts.purchase_deshboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <!-- Main content -->
    <div class="content px-4 ">
        <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
            <div class="pt-3 text-center">
                <h4 class="font-weight-bolder text-uppercase">General Warehouse Create</h4>
                <hr width="33%">
            </div>

            <form class="floating-labels m-t-40" action="{{Route('general.purchase.general.wirehouse.store')}}" method="POST">
                @csrf
                <div class="row pt-4">
                    <div class="col-md-10 m-auto">
                      <div class="row pt-4">
                           <div class="col-md-6">
                                <div class="form-group">
                                    <label class="">Warehouse Name :</label>
                                    <div class="">
                                        <input type="Text" name="wirehouse_name" class="form-control" placeholder="Warehouse Name">
                                    </div>
                                </div>
                            </div>
                        	<div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Opening Balancce:</label>
                                  <div class="">
                                      <input type="Text" name="wirehouse_opb" class="form-control" placeholder="Opening Balancce">
                                  </div>
                        		</div>
                           </div> 
                        	<div class="col-md-12 mt-4">
                                <div class="form-group">
                                  <label class="">Warehouse Address:</label>
                                  <div class="">
                                      <input type="Text" name="wirehouse_address" class="form-control" placeholder="Warehouse Address">
                                  </div>
                        		</div>
                           </div>
                       </div>                        
                    </div>
               </div>
        <div class="col-md-6">

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

        </form>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection