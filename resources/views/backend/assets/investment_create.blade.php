@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
  		<div class="content px-4 " id="investment">
        <div class="container-fluid">
            <div class="row" >
                <div class="col-md-10 mx-auto">

                   

                        <form class="floating-labels m-t-40" action="{{ route('asset.investment.store') }}"
                            method="POST">
                            @csrf
                                  <div class="pt-4 text-center">
                                    <h4 class="font-weight-bolder text-uppercase">Create Asset Investment </h4>
                                    <hr width="33%">
                                </div>

                                <div class="row pt-3">
                                  
                                  <div class="col-md-4">
                                      <div class="form-group row">
                                           <label class=" col-form-label">Date :</label>
                                              <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control" id="inputEmail3">
                                       </div>
                                  </div>
                                  
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class=" col-form-label">Company Name :</label>
                                            <input type="text" name="company_name" class="form-control"
                                                placeholder="Enter Company Name">
                                        </div>
                                       
                                    </div>
                                  
                                  
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=" col-form-label"> Share Quantity:</label>
                                            <input type="text" id="share_qty" name="share_qty" class="form-control"
                                                placeholder="Share Quantity">
                                        </div>
                                        
                                    </div>
                                   <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=" col-form-label"> Share Rate:</label>
                                            <input type="text" id="share_rate" name="share_rate" class="form-control"
                                                placeholder="Share Rete">
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=" col-form-label">Total Share Value:</label>
                                            <input type="text" name="share_value" id="share_value" readonly class="form-control"
                                                placeholder="Total Share Value">
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-12 mt-5">
                                        <div class="text-center">
                                            <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

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
              
              $('#share_value').val(qty*rate);
            });
        });
    </script> 
@endsection
