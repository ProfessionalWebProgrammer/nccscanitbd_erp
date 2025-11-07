@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row pt-5">
                    <div class="col-md-6 m-auto">
                        <form class="floating-labels m-t-40" action="{{ route('expanse.group.update') }}" method="POST">
                            @csrf
                            <div class="px-3">
                                <div class="pt-3 text-center">
                                    <h5 class="font-weight-bolder text-uppercase">Edit Expanse Group</h5>
                                    <hr width="33%">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class=" col-form-label">Expanse Group Name :</label>
                                        <input type="hidden" value="{{$group->id}}" name="id">
                                        <input type="text" name="expanse_group_name" class="form-control"
                                            value="{{$group->group_name}}" required>
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
