@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
       <div class="container" style="background:#ffffff; padding:0px 40px;">
            <div class="pt-3 text-center">
                <h5 class="font-weight-bolder text-uppercase">Return Form</h5>
                <hr width="33%">
            </div>
            <form class="floating-labels m-t-40" action="{{route('expanse.payment.returnUpdate')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="content px-4 ">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class=" col-form-label">Date:</label>
                                        <input type="date" value="{{ $edata->payment_date }}" name="date" class="form-control">
                                    </div>
                                    
                                    <input type="hidden" name="id" value="{{ $edata->id }}">

                                    @if ($edata->bank_id != null)

                                    <div class="form-group col-md-4" >
                                        <label class=" col-form-label">Bank:</label>
                                        <select class="form-control select2" 
                                                        
                                        name="bank_id" id="bank_id">
                                        <option value="">Select Bank</option>

                                        @foreach ($allBanks as $data)
                                            <option style="color:#000;font-weight:600;"
                                            @if ($edata->bank_id == $data->bank_id) selected @endif
                                            value="{{ $data->bank_id }}">
                                                {{ $data->bank_name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                        
                                    @endif

                                    @if ($edata->wirehouse_id != null)
                                 
                                    <div class="form-group col-md-4" >
                                        <label class=" col-form-label">Depot/ Wirehouse:</label>
                                        <select class="form-control select2" 
                                                        
                                        name="wirehouse_id" id="wirehouse_id" >
                                        <option value="">Select Cash</option>

                                        @foreach ($allcashs as $data)
                                            <option style="color:#000;font-weight:600;"
                                            @if ($edata->wirehouse_id == $data->wirehouse_id) selected @endif
                                            value="{{ $data->wirehouse_id }}">
                                                {{ $data->wirehouse_name }}</option>
                                        @endforeach
                                    </select>
                                    </div>

                                    @endif
                                  
                                  {{-- <div class="form-group col-md-3" >
                                        <label class=" col-form-label">Narration:</label>
                                      <input type="text" name="payment_description" value="{{$edata->payment_description}}"
                                                                        class="form-control" >
                                    </div> --}}
                                  <div class="form-group col-md-4">
                                                                <label class=" col-form-label"> Supplier:</label>
                                                                <select class="form-control select2 " name="supplier_id">
                                                                    <option value="">Select Supplier</option>

                                                                    @foreach ($allSuppliers as $data)
                                                                        <option style="color:#000;font-weight:600;"
                                                                            value="{{ $data->id }}" @if($edata->supplier_id == $data->id) selected  @else  @endif>
                                                                            {{ $data->supplier_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                </div>
                                {{-- Multiple Fields --}}
                                <div class="row mt-2">
                                    <div id="field" class="col-md-12">
                                        <div class="row fieldGroup rowname">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                              {{-- <label class=" col-form-label">Expense Group </label>
                                                              <select class="form-control select2 group" name="expanse_type_id">
                                                                <option value="">Select Group</option>
                                                                  @foreach ($groups as $data)
                                                                      <option style="color:#000;font-weight:600;" value="{{ $data->id }}" @if($edata->expanse_type_id == $data->id) selected  @else  @endif >
                                                                          {{ $data->group_name }}</option>
                                                                  @endforeach
                                                              </select> --}}
                                                                  <label class=" col-form-label">Narration:</label>
                                      							<input type="text" name="payment_description" value="{{$edata->payment_description}}" class="form-control" >
                                                          </div>
                                                            </div>
                                                          <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">Ledger:</label>
                                                              <select class="form-control select2 " name="expanse_subgroup_id" >
                                                                    <option value="">Select Ledger </option>
                                                                    @foreach ($subgroups as $data)
                                                                        <option style="color:#000;font-weight:600;" value="{{ $data->id }}" @if($edata->expanse_subgroup_id == $data->id) selected  @else  @endif >
                                                                            {{ $data->subgroup_name }} - {{ $data->group_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                          
                                                            <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class=" col-form-label">
                                                                    Sub-Ledger:</label>
                                                                <select class="form-control select2 " name="expanse_subSubgroup_id" >
                                                                    <option value="">Select  Sub Ledger </option>

                                                                    @foreach ($subSubGroups as $data)
                                                                        <option style="color:#000;font-weight:600;" value="{{ $data->id }}" @if($edata->expanse_subSubgroup_id == $data->id) selected  @else  @endif>
                                                                           {{$data->subSubgroup_name}} - {{ $data->subgroup_name }} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class="col-form-label">Amount:</label>
                                                                    <input type="number" name="expanse_amount"
                                                                        class="form-control" placeholder="Expanse Amount"  value="{{$edata->amount }}">
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

                            <div class="row pb-5">
                                <div class="col-md-6">
                                    <div class="text-right">
                                        <button type="submit" class="btn custom-btn-sbms-submit"> Return </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
