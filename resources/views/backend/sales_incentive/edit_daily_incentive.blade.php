@extends('layouts.sales_dashboard')
@section('header_menu') 
    <li class="nav-item d-none d-sm-inline-block mr-2">
        <a href="{{route('sales.yearly.incentive')}}" class="btn btn-success">Yearly Incentive</a>
	</li>
<li class="nav-item d-none d-sm-inline-block mr-2">
        <a href="{{route('sales.monthly.incentive')}}" class="btn btn-success">Monthly Incentive</a>
	</li>
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper salescontent">

    <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
    <div class="row">
        <div class="col-md-6 m-auto">

            <div class="content px-4 ">

                <form class="floating-labels m-t-40" action="{{ Route('sales.daily.incentive.update') }}" method="POST">
                    @csrf

                    <div class="">
                        <div class="pt-3 text-center">
                            <h4 class="font-weight-bolder text-uppercase">Daily Incentive Edit</h4>
                            <hr width="33%">
                        </div>
						<input type="hidden" name="id" value="{{$data->id}}">
                        <div class="row pt-4">
                            <div class="form-group col-md-12">
                                <label class=" col-form-label">Product Name :</label>
                              	<select name="product_id" class="form-control select2  " >
                                       <option value=""> Select Product </option>
                                          @foreach ($products as $item)
                                            <option value="{{ $item->id }}" @if($data->product_id == $item->id) selected @else  @endif>{{ $item->product_name }}</option>
                                          @endforeach
                                 </select>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class=" col-form-label">Min Target:</label>
                                        <input type="text" name="min_target" class="form-control" value="{{$data->min_target}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class=" col-form-label">Max Target:</label>
                                        <input type="text" name="max_target"  class="form-control" value="{{$data->max_target}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-form-label">Achive Commission:</label>
                                <input type="number" name="achive_commision"  class="form-control" step="any" value="{{$data->achive_commision}}">
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-form-label">Description:</label>
                                <textarea name="description" class="form-control" id="" cols="30" rows="5" >{{$data->description}}</textarea>
                            </div>

                        </div>
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
        </div>

    </div>
    </div>

</div>
<!-- /.content-wrapper -->

@endsection