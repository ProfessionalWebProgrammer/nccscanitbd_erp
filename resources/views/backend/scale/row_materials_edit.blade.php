@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <form class="floating-labels m-t-40" action="{{ Route('row.materials.scale.edit.store') }}" method="POST">
            @csrf

            <div class="content px-4 ">


                <div class="container-fluid">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Scale Edit</h4>
                        <hr width="33%">
                    </div>

                    <div class="row pt-4">

                        <input class="form-control" name="id" value="{{ $scale->id }}" type="hidden" id="" required />
                        <div class="col-md-4" style="">
                            <label style="padding-top: 10px;"> Supplier Name</label>
                            <select class="form-control selectpicker" data-show-subtext="true" data-live-search="true"
                                data-live-search-style="startsWith" name="supplier_id" id="wirehouse" required>
                                <option value=""></option>
                                @foreach ($suppliers as $supplier)
                                    <option style="color:#000;font-weight:600;" value="{{ $supplier->id }}"
                                        @if ($supplier->id == $scale->supplier_id) selected @endif>{{ $supplier->supplier_name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-4" style="">
                            <label style="padding-top: 10px;"> Vehicle No </label>
                            <input class="form-control" name="vehicle" value="{{ $scale->vehicle }}" type="text" id=""
                                required />
                        </div>

                        <div class="col-md-4" style="padding-bottom: 10px;">
                            <label style="padding-top: 10px;"> Date</label>
                            <div class="input-group ">
                                <input class="form-control" type="date" name="testdate" value="{{ $scale->date }}"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-4" style="padding-bottom: 20px;">
                            <label> Factory</label>
                            <select class="form-control selectpicker" data-show-subtext="true" data-live-search="true"
                                data-live-search-style="startsWith" name="warehouse_id" id="wirehouse" required>
                                <option value=""></option>
                                @foreach ($factoryes as $factorye)
                                    <option style="color:#000;font-weight:600;" value="{{ $factorye->id }}"
                                        @if ($factorye->id == $scale->warehouse_id) selected @endif>{{ $factorye->factory_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4" style=" padding-bottom: 20px;">
                            <label>Product Name<span id="pstock" style="color: red"></span></label>
                            <select class="form-control selectpicker" data-show-subtext="true" data-live-search="true"
                                data-live-search-style="startsWith" name="rm_product_id" required>
                                <option value=""></option>
                                @foreach ($rm_products as $rm_products)
                                    <option style="color:#000;font-weight:600;" value="{{ $rm_products->id }}"
                                        @if ($rm_products->id == $scale->rm_product_id) selected @endif>{{ $rm_products->product_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4" style=" padding-bottom: 20px;">
                            <label>Chalan Quantity <span id="pstock" style="color: red"></span></label>
                            <input class="form-control" name="chalan_qty" value="{{ $scale->chalan_qty }}" type="text"
                                id="chalan_qty" />
                        </div>


                        <div class="col-md-3" style="padding-bottom: 20px;">
                            <label style="padding-top: 10px;">Load Weight</label>
                            <input class="form-control" oninput="actualweight()" value="{{ $scale->load_weight }}"
                                name="load_weight" type="number" step="any" id="load_weight" />
                        </div>

                        <div class="col-md-3" style="padding-bottom: 20px;">
                            <label style="padding-top: 10px;">Unload Weight</label>
                            <input class="form-control" oninput="actualweight()" value="{{ $scale->unload_weight }}"
                                name="unload_weight" type="number" step="any" id="unload_weight" />
                        </div>


                        <div class="col-md-3" style=" padding-bottom: 20px;">
                            <label style="padding-top: 10px;">Actual Weight</label>
                            <input class="form-control" name="actual_weight" value="{{ $scale->actual_weight }}"
                                type="number" step="any" id="actual_weight" />
                        </div>


                    </div>

                    <div class="row pb-5">
                        <div class="col-md-6 mt-3">
                            <div class="text-right">
                                <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">

                        </div>
                    </div>


                    <!-- /.container-fluid -->
                </div>
            </div>

        </form>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script>

    </script>
@endsection


@push('end_js')
    <script>
        function actualweight() {
            var unload = $('#unload_weight').val();
            var load = $('#load_weight').val();
            var aw = load - unload;
            $('#actual_weight').val(aw);
        }
    </script>
@endpush
