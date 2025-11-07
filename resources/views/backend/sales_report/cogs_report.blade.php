@extends('layouts.sales_dashboard')

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
    <div class="content-wrapper" id="contentbody">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="py-4">
                    <div class="text-center">
                        <h4 class="text-uppercase font-weight-bold">Sales COGS Report</h4>
                        <hr style="background: #ffffff78;">
                    </div>
                    <form action="{{ route('sales.cogs.report.view') }}" method="POST">
                        @csrf
                        <div class="row pt-3">
                            <div class="col-md-12">
                                <div class="row ">


                            <div class="col-md-4 m-auto">
                                <h5>Select Daterange: <span id="today" style="color: lime; display:inline-block">Today</span></h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date"
                                            class="form-control float-right" id="daterangepicker" required>

                                    </div>
                                </div>
                            </div>

                                    {{-- <div class="col-md-4">
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
                                    </div> --}}
                                  {{--   <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Finished Good :</label>
                                            <div class="">
                                                <select  class="
                                                form-control select2" id="products_id" name="   products" required>
                                                <option value="">== Select Item ==</option>
                                                @foreach ($salesproduct as $item)
                                                    <option value="{{ $item->id }}"> {{ $item->product_name }}
                                                    </option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-3">
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
                                    </div> --}}
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


    <script>
        $(document).ready(function() {

            $("#daterangepicker").change(function() {
                var a = document.getElementById("today");
               a.style.display = "none";
            });


        });
    </script>



@endsection
