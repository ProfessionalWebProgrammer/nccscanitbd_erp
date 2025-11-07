@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row pt-5">
                    <div class="col-md-6 m-auto">
                        <form class="floating-labels m-t-40" action="{{ route('qc.parameter.update', $data->id) }}" method="POST">
                            @csrf
                            <div class="px-3">
                                <div class="pt-3 text-center">
                                    <h5 class="font-weight-bolder text-uppercase">Edit Q C Parameter Group</h5>
                                    <hr width="33%">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class=" col-form-label">Name :</label>
                                      	<input type="hidden" name="item_type" value="{{$data->item_type}}">
                                        <input type="text" name="name" class="form-control" value="{{$data->name}}">
                                    </div>
                                  <div class="form-group col-md-12">
                                        <label class=" col-form-label">Standard Value:</label>
                                        <input type="number" name="standard" class="form-control" value="{{$data->standard}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row pb-5">
                                <div class="col-md-6 mt-3">
                                    <div class="text-right">
                                        <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
