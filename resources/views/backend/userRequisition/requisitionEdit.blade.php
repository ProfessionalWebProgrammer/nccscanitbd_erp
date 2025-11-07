@extends('layouts.backendbase')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('user.multiFunction.requisition.store')}}" method="post" enctype="multipart/form-data">
                @csrf
              <div class="container-fluid" id="field">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Requisition Form</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4 col-md-12">

                        <div class="col-md-4">
                          <div class="form-group row">
                              <label for="date" class="col-sm-3 col-form-label"> Date : </label>
                              <div class="col-sm-9">
                                  <input type="date" class="form-control" name="date" value="{{date('d-m-Y', strtotime($data->date))}}">
                              </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Supplier :</label>
                                    <div class="col-sm-9">
                                        <!-- <select name="user_id[]" class="form-control select2" multiple required>  -->
                                           <select class="form-control selectpicker border border-secondary" data-show-subtext="true"
                                        data-live-search="true" data-actions-box="true"  name="supplier_id">
                                        <option value="0">Select Supplier</option>
                                            @foreach ($suppliers as $item)
                                                <option value="{{$item->id}}" @if($item->id == $data->supplier_id) selected @else  @endif>{{$item->supplier_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Reference:</label>
                                <div class="col-sm-9">
                                   <input type="Text" name="reference"  class="form-control"  value="{{$data->reference}}">
                                </div>
                            </div>
                        </div>

                      {{--   <div class="col-md-3">
                          <div class="form-group row">
                              <label for="last_purchase_date" class="col-sm-4 col-form-label">Last Purchase Date : </label>
                              <div class="col-sm-8">
                                  <input type="date" class="form-control" name="last_purchase_date">
                                </div>
                          </div>
                        </div> --}}
                        <!-- multiple data start -->
                      {{--  <div class="row mt-3">

                                <div class="fieldGroup rowname">

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class=" col-form-label">Product Name:</label>
                                                            <select name="item[]" class="form-control select2 orderProduct" required>
                                                                <option value="">== Select Product ==</option>
                                                                        @foreach ($products as $item)
                                                                            <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                                                        @endforeach
                                                            </select>
                                                            <span>Remaining Days : </span><span class="day"> </span> </br>
                                                            <span>Live Days : </span><span class="liveDay"> </span>
                                                        </div>

                                                    </div>
                                                    <input type="hidden" name="remainingDay[]" class="day"  value="">
                                                    <input type="hidden" name="liveDay[]"  class="liveDay" value="">
                                                  <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class=" col-form-label"> Specification:</label>
                                                            <input type="text"  name="specification[]" class="form-control" placeholder="Product Specification">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class=" col-form-label"> UOM (Kg):</label>
                                                            <input type="text" name="unit[]"  class="form-control orderUnit"  readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class=" col-form-label"> Stock In:</label>
                                                            <input type="text"  name="stock[]" required class="form-control stock"  readonly>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <label class=" col-form-label"> Quantity:</label>
                                                            <input type="text"  name="qty[]" required class="form-control qty" placeholder="Required Quantity">

                                                        </div>
                                                    </div>

                                                   <div class="col-md-1">
                                                        <div class="form-group">
                                                            <label class=" col-form-label"> LUP:</label>
                                                            <input type="text"  name="lup[]" required class="form-control rate" placeholder="Last Unit Price">
                                                            <input type="hidden"  name="amount[]" class="form-control amount" >
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="col-md-1 mt-2">
                                                <label for="">Action :</label>
                                                <a href="javascript:void(0)" style="margin-top: 3px;"
                                                    class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                        class="fas fa-plus-circle"></i></a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm custom-btn-sbms-remove remove"
                                                    style="margin-top: 3px;"><i
                                                        class="fas  fa-minus-circle"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div> --}}
                        <!-- multiple data end -->
                      </div>
                      <div class=" mt-3">
                      <div class="col-md-12 row">
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label"> Amount:</label>
                            <div class="col-sm-9">
                                <input type="text" name="amount" class="form-control" value="{{$data->amount}}">
                            </div>

                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label"> Document:</label>

                            <div class="col-sm-9">
                              <input type="file" name="doc" value="">
                            <span class="mt-2"> <a href="{{URL::to('/public/uploads/requisition/')}}/{{$item->doc}}" class="mt-2" target="_blank" download>{{$data->doc}}</a> </span>

                            </div>

                          </div>
                        </div>
                        <div class="col-md-8">
                          <div class="form-group row">
                              <label class="col-sm-2 col-form-label"> Note:</label>
                              <div class="col-sm-10">
                                  <textarea name="description" class="form-control" required  rows="4" placeholder="Note">{{$data->description}}</textarea>
                              </div>
                          </div>
                      </div>

                      {{--  <div class="col-md-6">
                          <div class="form-group row">
                              <label class="col-sm-4 col-form-label"> Select Approved User:</label>
                              <div class="col-sm-8">
                                  <select class="form-control selectpicker border border-secondary" data-show-subtext="true"
                               data-live-search="true" data-actions-box="true" multiple  name="approved_user[]" required>
                                   @foreach ($users as $item)
                                     @if($item->id == Auth::id())
                                     @else
                                       <option value="{{$item->id}}">{{$item->name}}</option>
                                     @endif
                                   @endforeach
                               </select>
                              </div>
                          </div>
                      </div> --}}
                      </div>
                      </div>
                  </div>


                <div class="row pb-5 mt-3">
                    <!-- <div class="col-md-3"></div> -->

                    <div class="col-md-2 m-auto ">
                            <button type="submit" class="btn btn-md btn-primary w-100"> Submit </button>
                    </div>
                    <!-- <div class="col-md-6 mt-3"></div> -->
                </div>
            </form>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- /.content-wrapper -->

@endsection
