@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content px-4 " id="investment">

            <div class="container-fluid">
                <div class="row" style="min-height: 85vh">
                    <div class="col-md-10 mx-auto">

                        <form class="floating-labels m-t-40" action="{{ route('asset.Intangible.store') }}" method="POST">
                            @csrf
                            <div class="pt-4 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Create Asset Intangible </h4>
                                <hr width="33%">
                            </div>

                            <div class="row pt-3">

                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class=" col-form-label">Date :</label>
                                        <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control"
                                            id="inputEmail3">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class=" col-form-label">Asset Category:</label>
                                        <select name="category_id" id="category_id" class="form-control select2" required>
                                            <option value="">== Select Category ==</option>
                                            @foreach ($assetcat as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class=" col-form-label"> Amount:</label>
                                        <input type="text" id="amount" name="amount" class="form-control"
                                            placeholder="Amount">
                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class=" col-form-label"> Description:</label>
                                        <input type="text" id="description" name="description" class="form-control"
                                            placeholder="Description">
                                    </div>

                                </div>


                            </div>
                            <div class="col-md-12 mt-5">
                                <div class="text-center">
                                    <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /.content-wrapper -->
    <script>
        $(document).ready(function() {
            $('#share_qty, #share_rate').on('input', function() {
                var qty = $('#share_qty').val();
                var rate = $('#share_rate').val();

                $('#share_value').val(qty * rate);
            });
        });
    </script>
@endsection
