@extends('layouts.sales_dashboard')
@section('header_menu')
    <li class="nav-item d-none d-sm-inline-block mr-2">
        <a href="{{ route('sales.yearly.incentive') }}" class="btn btn-success">Yearly Incentive</a>
    </li>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper salescontent">

        <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
            <div class="row">
                <div class="col-md-6 m-auto">

                    <div class="content px-4 ">

                        <form class="floating-labels m-t-40" action="{{ Route('sales.monthly.incentive.update') }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$monthlyedit->id}}">
                            <div class="">
                                <div class="pt-3 text-center">
                                    <h4 class="font-weight-bolder text-uppercase">Monthly Incentive Edit</h4>
                                    <hr width="33%">
                                </div>

                                <div class="row pt-4">
                                  {{-- <div class="form-group col-md-12">
                                        <label class=" col-form-label">Title :</label>

                                        <input type="text" name="type_title" class="form-control" value="{{$monthlyedit->title}}"
                                            placeholder="Monthly Incentive Title">
                                      	<input type="hidden" name="id" value="{{$monthlyedit->id}}">
                                    </div> --}}
                                    <div class="form-group col-md-12">
                                        <label class=" col-form-label">Category :</label>
                                        <select name="category_id" class="form-control select2 " required>
                                               <option value=""> Select Category </option>
                                                  @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}" @if($item->id == $monthlyedit->category_id) selected  @else  @endif>{{ $item->category_name }}</option>
                                                  @endforeach
                                         </select>

                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label class=" col-form-label">Min Target:</label>
                                                <input type="text" name="min_target" required class="form-control" value="{{$monthlyedit->target_amount}}"
                                                    placeholder="Min Target">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class=" col-form-label">Max Target:</label>
                                                <input type="text" name="max_target" required class="form-control" value="{{$monthlyedit->max_target_amount}}"
                                                    placeholder="Max Target">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="col-form-label">Achive Commision :</label>
                                        <input type="text" name="achive_commission" required class="form-control" value="{{$monthlyedit->achive_commision}}"
                                            placeholder="Achive Commision">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="col-form-label">Type Description :</label>
                                        <textarea name="description" class="form-control" id="" cols="30" rows="5"
                                            placeholder="Monthly Incentive Description">{{$monthlyedit->description}}</textarea>
                                    </div>

                                </div>
                            </div>
                          <div class="row pb-5">
                        <div class="col-md-6 m-auto">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary custom-btn-sbms-submit"> Update </button>
                            </div>
                        </div>
                    </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>

    @endsection
