@extends('layouts.sales_dashboard')
@section('header_menu')
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper salescontent">

        <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
            <div class="row">
                <div class="col-md-6 m-auto">

                    <div class="content px-4 ">

                        <form class="floating-labels m-t-40" action="{{ Route('sales.yearly.incentive.update') }}"
                            method="POST">
                            @csrf

                            <div class="">
                                <div class="pt-3 text-center">
                                    <h4 class="font-weight-bolder text-uppercase">Yearly Incentive Edit</h4>
                                    <hr width="33%">
                                </div>

                                <div class="row pt-4">
                                  <div class="form-group col-md-12">
                                        <label class=" col-form-label">Category :</label>
                                        <select name="category_id" class="form-control select2 " required>
                                               <option value=""> Select Category </option>
                                                  @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}" @if($item->id == $yearlyedit->category_id) selected  @else  @endif>{{ $item->category_name }}</option>
                                                  @endforeach
                                         </select>

                                    </div>
                                   {{--  <div class="form-group col-md-12">
                                        <label class=" col-form-label">Title :</label>

                                        <input type="text" name="type_title" class="form-control" value="{{$yearlyedit->title}}">
                                      	<input type="hidden" name="id" value="{{$yearlyedit->id}}">
                                    </div> --}}
                                    <div class="form-group col-md-12">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label class=" col-form-label">Min Target:</label>
                                                <input type="text" name="min_target" required class="form-control" value="{{$yearlyedit->min_target_amount}}" >
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class=" col-form-label">Max Target:</label>
                                                <input type="text" name="max_target" required class="form-control" value="{{$yearlyedit->max_target_amount}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="col-form-label">Incentive :</label>
                                        <input type="text" name="incentive" required class="form-control" value="{{$yearlyedit->incentive}}" >
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="col-form-label">Type Description :</label>
                                        <textarea name="description" class="form-control" id="" cols="30" rows="5" >{{$yearlyedit->description}}</textarea>
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
