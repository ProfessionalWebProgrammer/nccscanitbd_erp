@extends('layouts.account_dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <!-- Main content -->
    <div class="content px-4 ">
        <div class="container-fluid">
            <div class="pt-3 text-center">
                <h4 class="font-weight-bolder text-uppercase">Master Cash Update</h4>
                <hr width="33%">
            </div>

            <form class="floating-labels m-t-40" action="{{Route('master.cash.update')}}" method="POST">
                @csrf
              <input type="hidden" name="id" value="{{$data->wirehouse_id}}"/>
                <div class="row pt-4">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Warehouse Name :</label>
                            <div class="col-sm-9">
                                <input type="Text" name="wirehouse_name" class="form-control" value="{{$data->wirehouse_name}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Opening Balacen:</label>
                            <div class="col-sm-9">
                                <input type="Text" name="wirehouse_opb" class="form-control" value="{{$data->wirehouse_opb}}">
                            </div>
                        </div>

                    </div>

                   

                    
                    <div class="col-md-6">  
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"> Address:</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="wirehouse_address" rows="3" >{{$data->wirehouse_address}}</textarea>
                                <!-- <input type="Text" class="form-control" placeholder="Warehouse Address"> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">

                    </div>
                </div>
                <div class="row pb-5">
                    <div class="col-md-6 mt-3">
                        <div class="text-right">
                            <button type="submit" class="btn custom-btn-sbms-submit"> Update </button>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
        
                    </div>
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