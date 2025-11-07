@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <form class="floating-labels m-t-40" action="{{ Route('row.materials.scale.generate') }}" method="POST">
            @csrf

            <div class="content px-4 ">


                <div class="container-fluid">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Scale Create</h4>
                        <hr width="33%">
                    </div>

                    <div class="row pt-4">

                        <div class="col-md-4" style="">
                            <label style="padding-top: 10px;"> Supplier Name</label>
                            <select class="form-control select2"  name="supplier_id" id="" required>
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option style="color:#000;font-weight:600;" value="{{ $supplier->id }}">
                                        {{ $supplier->supplier_name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-4" style="">
                            <label style="padding-top: 10px;"> Vehicle No </label>
                            <input class="form-control" name="vehicle" type="text" id="" required />
                        </div>

                        <div class="col-md-4" style="padding-bottom: 10px;">
                            <label style="padding-top: 10px;"> Date</label>
                            <div class="input-group ">
                                <input class="form-control" type="date" name="testdate" value="{{ $date }}"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-4" style="padding-bottom: 20px;">
                            <label> Factory</label>
                            <select class="form-control select2" name="warehouse_id" id="" required>
                                <option value="">Select Factory</option>
                                @foreach ($factoryes as $factorye)
                                    <option style="color:#000;font-weight:600;" value="{{ $factorye->id }}">
                                        {{ $factorye->factory_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4" style=" padding-bottom: 20px;">
                            <label>Product Name<span id="pstock" style="color: red"></span></label>
                            <select class="form-control select2" name="rm_product_id" required>
                                <option value="">Select Product</option>
                                @foreach ($rm_products as $rm_products)
                                    <option style="color:#000;font-weight:600;" value="{{ $rm_products->id }}">
                                        {{ $rm_products->product_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4" style=" padding-bottom: 20px;">
                            <label>Chalan Quantity (kg) <span id="pstock" style="color: red"></span></label>
                            <input class="form-control" name="chalan_qty" type="text" id="chalan_qty" />
                        </div>


                        <div class="col-md-3" style="padding-bottom: 20px;">
                            <label style="padding-top: 10px;">Load Weight (kg)</label>
                            <input class="form-control" required oninput="actualweight()" name="load_weight" type="number"
                                step="any" id="load_weight" />
                        </div>

                        <div class="col-md-3" style="padding-bottom: 20px;">
                            <label style="padding-top: 10px;">Unload Weight (kg)</label>
                            <input class="form-control" oninput="actualweight()" name="unload_weight" type="number"
                                step="any" id="unload_weight" />
                        </div>


                        <div class="col-md-3" style=" padding-bottom: 20px;">
                            <label style="padding-top: 10px;">Actual Weight (kg)</label>
                            <input class="form-control" name="actual_weight" type="number" step="any"
                                id="actual_weight" />
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

      $(document).ready(function() {


    $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
        $(this).closest(".select2-container").siblings('select:enabled').select2('open');
        });

        // steal focus during close - only capture once and stop propogation
        $('select.select2').on('select2:closing', function (e) {
        $(e.target).data("select2").$selection.one('focus focusin', function (e) {
            e.stopPropagation();
            });
        });


 	});


    </script>
@endpush
