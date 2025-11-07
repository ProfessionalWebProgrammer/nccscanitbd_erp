@extends('layouts.purchase_deshboard')

@push('addcss')
    <style>
        .text_sale {
            color: #f7ee79;
        }

        .text_credit {
            color: lime;
        }

    </style>
@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container">
                <div class="py-4">
                    <div class="text-center">
                        <h4 class="text-uppercase font-weight-bold">COGS Report</h4>
                        <hr style="background: #ffffff78;">
                    </div>
                    <form action="{{ route('cogs.report.view') }}" method="POST">
                        @csrf
                        <div class="row pt-3">
                            <div class="col-md-12">
                                <div class="row ">
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label class="col-form-label">Date :</label>
                                            <div class="">
                                                <input class="
                                                form-control" type="date"
                                                value="{{ date('Y-m-d', strtotime(' -1 days')) }}" name="date"
                                                placeholder="Product Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Wirehouse :</label>
                                            <div class="">
                                                <select  class="
                                                form-control select2" id="factory_id" name="factory_id" required>
                                                <option value="">== Select Item ==</option>
                                                @foreach ($factories as $item)
                                                    <option value="{{ $item->id }}"> {{ $item->factory_name }}
                                                    </option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Row Meterial :</label>
                                            <div class="">
                                                <select  class="
                                                form-control select2" id="products_id" name="   products" required>
                                                <option value="">== Select Item ==</option>
                                                @foreach ($rawmeterial as $item)
                                                    <option value="{{ $item->id }}"> {{ $item->product_name }}
                                                    </option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label class=" col-form-label">Direct Labor :</label>
                                            <div class="">
                                                <input type="
                                                number" name="dir_labor" class="form-control" placeholder="Direct Labor">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label class="col-form-label">Indirect Cost :</label>
                                            <div class="">
                                                <input type="
                                                number" name="ind_labor" class="form-control" placeholder="Indirect Cost">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                    <div class="class row">
                                        <div class="class col-md-4"></div>
                                        <div class="class col-md-4 px-5">
                                            <button type="submit" class="btn btn-primary" style="width: 100%;">Generate Report</button>


                                        </div>
                                        <div class="class col-md-4">
                                        </div>
                                    </div>

                            </div>
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <script>
        $(document).ready(function() {

            $("#products_id").on('change', function() {

                var product_id = $(this).val();

                alert(product_id);

                $.ajax({
                    url: '{{ url('/scale/data/get/') }}/' + id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);



                        $("#data").val(data.date);
                        $("#vehicle").val(data.vehicle);
                        $("#supplier_chalan_qty").val(data.chalan_qty).attr('readonly',
                            'readonly');
                        $("#receive_quantity").val(data.actual_weight).attr('readonly',
                            'readonly');

                        $("#supplier_id").val(data.supplier_id);
                        $("#wirehouse").val(data.warehouse_id);
                        $("#product_id").val(data.rm_product_id);

                        $('.select2').select2({
                            theme: 'bootstrap4'
                        })

                    }
                });


                calculation();


            });
        });
    </script> --}}


@endsection
