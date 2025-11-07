@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('purchase.transfer.update')}}" method="post">
                @csrf
                <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                    <div class="text-center py-4">
                        <h3 class="text-uppercase font-weight-bold text-danger">Update Purchase Transfer</h3>
                    </div>
                    <input type="hidden" name="id" value="{{$trdetails->id}}">
                    <div class="row pt-5">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right text-primary">Date : </label>
                                <div class="col-sm-8">
                                    <input type="date" value="{{$trdetails->date}}" name="date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Vehicle : </label>
                                <div class="col-sm-8">
                                    <input type="text" name="vehicle" class="form-control" value="{{$trdetails->vehicle}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Transport Fare :
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" name="transfer_fare" class="form-control"
                                        value="{{$trdetails->transfer_fare}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">

                           <div class="form-group row">
                                <label class="col-sm-1 col-form-label text-right text-primary">Narration : </label>
                                <div class="col-sm-11">
                                    <input type="text" name="narration" class="form-control" value="{{$trdetails->narration}}">
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-md-4">
                             <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right text-primary">Vehicle : </label>
                                <div class="col-sm-8">
                                    <input type="text" name="vehicle" class="form-control" placeholder="Vehicle">
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label text-right text-primary">From Warehouse
                                </label>
                                <div class="col-sm-8">
                                    <select name="from_wirehouse_id" class="form-control select2" required>
                                        <option value=""> == Select Werehouse == </option>
                                        @foreach ($factoryes as $factorye)
                                        <option value="{{ $factorye->id }}" @if($factorye->id == $trdetails->from_wirehouse_id) selected @endif>
                                            {{ $factorye->factory_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label text-right text-primary">To Warehouse :
                                </label>
                                <div class="col-sm-8">
                                    <select name="to_wirehouse_id" class="form-control select2" required>
                                        <option value=""> == Select Werehouse == </option>
                                        @foreach ($factoryes as $factorye)
                                        <option value="{{ $factorye->id }}"  @if($factorye->id == $trdetails->to_wirehouse_id) selected @endif>
                                            {{ $factorye->factory_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div id="field" class="col-md-12">

                            <div class="row fieldGroup rowname">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-1">
                                                </div>
                                                <div class="col-md-5 pr-3">
                                                    <div class="form-group row">
                                                        <label for="" class="text-primary">Product :</label>
                                                        <select class="form-control select2" name="product_id" required>
                                                            <option value="">Select Product</option>
                                                           @foreach ($product as $item)
                                                           <option value="{{$item->id}}"  @if($item->id == $trdetails->product_id) selected @endif>{{$item->product_name}}</option>
                                                           @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 pr-3">
                                                    <div class="form-group row">
                                                        <label for="" class="text-primary">Quantity :</label>
                                                        <input type="text" value="{{$trdetails->qty}}" required name="qty" class="form-control amount"
                                                            placeholder="Transfer Quantity">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="" class="text-primary">Receive Quantity :</label>
                                                        <input type="text" name="receive_qty" value="{{$trdetails->receive_qty}}" class="form-control "
                                                            placeholder="Receive Quantity">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row my-4">
                        {{-- <div class="col-md-6  m-auto font-weight-bold">
                            <h5 class="text-center ">Total Quantity : <span id="total_amount">/-</span></h5>
                        </div> --}}

                    </div>
                    <div class="row py-4">
                        <div class="col-md-6 m-auto">
                            <div class="text-center">
                                <button type="submit" class="btn custom-btn-sbms-submit btn-primary"> Submit </button>
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
