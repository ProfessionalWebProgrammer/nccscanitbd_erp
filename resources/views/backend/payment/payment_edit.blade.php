@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
      <div class="content px-4 ">
        <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
            <div class="pt-3 text-center">
                <h5 class="font-weight-bolder text-uppercase">Payment Edit Form</h5>
                <hr width="33%">
            </div>
            <form class="floating-labels m-t-40" action="{{route('payment.update')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class=" col-form-label">Date:</label>
                                        <input type="date" value="{{ $data->payment_date }}"  name="payment_date" class="form-control">
                                    </div>
                                  
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                   
                                  
                                </div>
                                 {{-- Multiple Fields --}}
                                <div class="row mt-5">
                                    <div id="field" class="col-md-12">
                                        <div class="row fieldGroup rowname">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <div class="row">

                                                            @if($data->bank_id != null )  
                                                            
                                                            <div class="form-group col-md-4 bankid"  >
                                                                <label class=" col-form-label">Bank:</label>
                                                                <select class="form-control select2" 
                                                                                
                                                                name="bank_id" >
                                                                <option value="">Select Bank</option>
                        
                                                                @foreach ($allBanks as $bbb)
                                                                    <option style="color:#000;font-weight:600;" value="{{ $bbb->bank_id }}"
                                                                        @if($data->bank_id == $bbb->bank_id) selected @endif>
                                                                        {{ $bbb->bank_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            </div>

                                                            @endif

                                                            @if($data->wirehouse_id != null )  

                                                                    <div class="form-group col-md-4 warehouseid" >
                                                                        <label class=" col-form-label">Depot/ Wirehouse:</label>
                                                                        <select class="form-control select2" 
                                                                                        
                                                                        name="cash_id"  >
                                                                        <option value="">Select Cash</option>
                                
                                                                        @foreach ($allcashs as $ccc)
                                                                            <option style="color:#000;font-weight:600;" value="{{ $ccc->wirehouse_id }}"
                                                                                @if($data->wirehouse_id == $ccc->wirehouse_id) selected @endif >
                                                                                {{ $ccc->wirehouse_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    </div>

                                                            @endif

                                                                <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label"> Supplier
                                                                        :</label>
                                                                    <select class="form-control select2 "
                                                                        name="supplier_id" >
                                                                        <option value="">Select Supplier</option>

                                                                        @foreach ($allSuppliers as $sss)
                                                                            <option style="color:#000;font-weight:600;"
                                                                                value="{{ $sss->id }}" @if($data->supplier_id == $sss->id) selected @endif>
                                                                                {{ $sss->supplier_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class=" col-form-label">Amount:
                                                                     </label>
                                                                    <input type="text" name="amount"
                                                                        class="form-control" value="{{ $data->amount }}" required>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>

                            <div class="row pb-5 ">
                                <div class="col-md-6 m-auto text-center">
                                        <button type="submit" class="btn custom-btn-sbms-submit mt-5"> Submit </button>
                                </div>
                        	</div>
                
            </form>
          </div>
        </div>
    </div>
    <script>
       




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
@endsection
