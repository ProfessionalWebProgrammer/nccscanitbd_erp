@extends('layouts.backendbase')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <form class="floating-labels m-t-40" action="{{Route('general.purchase.supplier.update')}}" method="POST">
            @csrf
     
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3 text-center">
                    <h4 class="font-weight-bolder text-uppercase">General Supplier Edit</h4>
                    <hr width="33%">
                </div>
                
                <div class="row pt-4">
                    <div class="col-md-8 m-auto">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Supplier Name :</label>
                            <div class="col-sm-9">
                                <input type="text" name="supplier_name" value="{{$supplieredit->supplier_name}}" class="form-control" placeholder="Supplier Name">
                                <input type="hidden" name="id" value="{{$supplieredit->id}}" class="form-control" placeholder="Supplier Name">
                              	
                            </div>
                        </div>                       
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"> Opening Balance : </label>
                            <div class="col-sm-9">
                                <input type="Text" name="opening_balance" value="{{$supplieredit->opening_balance}}" class="form-control" placeholder="Opening Balance">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"> Phone : </label>
                            <div class="col-sm-9">
                                <input type="Text" name="phone" value="{{$supplieredit->phone}}" class="form-control" placeholder="Phone">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"> Address : </label>
                            <div class="col-sm-9">
                                <input type="Text" name="address" value="{{$supplieredit->address}}" class="form-control" placeholder="Address">
                            </div>
                        </div>
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
        </div>
        <!-- /.container-fluid -->
    </div>

    
</form>
    <!-- /.content -->
    </div>
@endsection
