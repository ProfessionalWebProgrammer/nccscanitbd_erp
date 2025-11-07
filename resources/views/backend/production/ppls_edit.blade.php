@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content px-4 ">
            <div class="row">
                <div class="col-md-6 m-auto" >

                    <div class="content px-4 ">

                        <form class="floating-labels m-t-40" action="{{ Route('production.process.loss.update') }}" method="POST">
                            @csrf

                            <div class="container-fluid">
                                <div class="pt-3 text-center">
                                    <h4 class="font-weight-bolder text-uppercase">Production Process Loss Update</h4>
                                    <hr width="33%">
                                </div>
								<input type="hidden" name="id" value="{{$data->id}}" />
                                <div class="row pt-4">
                                    <div class="form-group col-md-12">
                                        <label class="col-form-label">Amount :( % )</label>
                                        <input type="text" name="amount" class="form-control"
                                            value="{{$data->amount}}">
                                    </div>

                                </div>
                                <div class="row pb-5">
                                    <div class="col-md-6 mt-3">
                                        <div class="text-right">
                                            <button type="submit" class="btn custom-btn-sbms-submit"> Update </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3"></div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- /.content-wrapper -->

 
@endsection