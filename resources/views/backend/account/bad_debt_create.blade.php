@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
		<div class="content px-4 " id="investment">
        <div class="container-fluid">
            <div class="row" style="min-height: 85vh">
                <div class="col-md-10 mx-auto">

                    

                        <form class="floating-labels m-t-40" action="{{ route('bad.debt.store') }}"
                            method="POST">
                            @csrf
                                <div class="pt-4 text-center">
                                    <h4 class="font-weight-bolder text-uppercase">Bad Debt Entry </h4>
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
                                            <label class=" col-form-label">Description :</label>
                                            <input type="text" name="description" class="form-control"
                                                placeholder="">
                                        </div>
                                       
                                    </div>
                                  
                                  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=" col-form-label"> Head:</label>
                                            <input type="text" name="head" class="form-control"
                                                placeholder="">
                                        </div>
                                        
                                    </div>
                                   <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=" col-form-label"> Amount:</label>
                                            <input type="text" id="amount" name="amount" class="form-control"
                                                placeholder="">
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
