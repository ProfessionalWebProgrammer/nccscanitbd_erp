@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ route('sales.damage.update') }}" method="post">
                @csrf
              <div class="container-fluid" style="background:#ffffff; padding:0px 40px; min-height:85vh;">
                    <h3 class="text-center">Sales Damage Edit</h3>
                    <div class="row pt-5">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Date : </label>
                                <div class="col-sm-8">
                                    <input type="date" value="{{ $damage->date }}" name="date" class="form-control">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label text-right"> Warehouse :
                                </label>
                                <div class="col-sm-8">
                                    <select name="warehouse_id" class="form-control select2" required>
                                        <option value=""> == Select Werehouse == </option>
                                        @foreach ($factoryes as $item)
                                            <option value="{{ $item->id }}" @if($damage->warehouse_id == $item->id) selected @endif>{{ $item->factory_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-5">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label text-right"> Product :
                                </label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" required name="product_id" required>
                                        <option value="">Select Product</option>
                                        @foreach ($salesProducts as $data)
                                            <option style="color:#000;font-weight:600;"
                                                value="{{ $data->id }}" @if($damage->product_id == $data->id) selected @endif>
                                                {{ $data->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{$damage->id}}">

                        <div class="col-md-4 mt-5">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label text-right"> Qantity :
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" name="product_qty" value="{{ $damage->quantity }}" required class="form-control amount">

                                </div>
                            </div>
                        </div>

                    </div>




                    <div class="row py-4">
                        <div class="col-md-6 m-auto">
                            <div class="text-center">
                                <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
