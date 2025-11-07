@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3 text-center">
                    <h4 class="font-weight-bolder text-uppercase">Bank Create</h4>
                    <hr width="33%">
                </div>

                <form class="floating-labels m-t-40" action="{{ Route('master.bank.store') }}" method="POST">
                    @csrf
                    <div class="row pt-4">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Bank Name :</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="bank_name" class="form-control" placeholder="Bank Name">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Main Bank :</label>
                                <div class="col-sm-9">
                                    <select name="main_bank_id" class="form-control select2">
                                        <option value="">Select Main Bank</option>

                                        @foreach ($mainbank as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Bank A/C :</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="bank_licence" class="form-control" placeholder="Bank A/C">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Opening Balance:</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="bank_op" class="form-control" placeholder="Opening Balance">
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Starting Balacen:</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="bank_starting_balance" class="form-control"
                                        placeholder="Starting Balance">
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Loan Type :</label>
                                <div class="col-sm-9">
                                    <select name="loan_type" class="form-control select2">
                                        <option value="">Select Loan Type</option>

                                        @foreach ($loantype as $item)
                                            <option value="{{ $item->id }}">{{ $item->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Loan Amount:</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="loan_amount" class="form-control" placeholder="Loan Amount">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Loan From Date:</label>
                                <div class="col-sm-9">
                                    <input type="date" name="loan_fdate" class="form-control">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Loan To Date:</label>
                                <div class="col-sm-9">
                                    <input type="date" name="loan_tdate" class="form-control">
                                </div>
                            </div>

                        </div>




                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Address:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="bank_address" rows="3"
                                        placeholder=" Address"></textarea>
                                    <!-- <input type="Text" class="form-control" placeholder="Warehouse Address"> -->
                                </div>
                            </div>
                        </div>
                      <div class="col-md-6">
                             <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Cheque Book No:</label>
                                       <input type="text" name="cheque_book_no" class="col-sm-9 form-control" placeholder="Example:100">
                              </div>
                      </div>
                    </div>
                  <!-- Multiple Data Start-->
                  <div class="row mt-3">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname">
                                <div class="col-md-12">
                                    <div class="row">
                                                <div class="col-md-2 pr-3">
                                                        <div class="form-group">
                                                            <label >Checkbook Serial No:</label>
                                                        <input type="number" name="cheque_book_serial_no[]" class="form-control" placeholder="Example:1001-200">
                                                    </div>
                                                </div>
                                              
                                          
                                        <div class="col-md-1">
                                            <label for="">Action :</label>
                                            <a href="javascript:void(0)" style="margin-top: 3px;"
                                                class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                    class="fas fa-plus-circle"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove"
                                                style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- Multi Data End -->
                    <div class="row pb-5">
                        <div class="col-md-6 mt-3">
                            <div class="text-right">
                                <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
        
                        </div>
                    </div>
            </div>

            </form>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
     
    
@endsection
@push('end_js')
      <script>
        $(document).ready(function() {
            //add more fields group
            $("body").on("click", ".addMore", function() {
             // alert('Ok');
				var fieldHTML = '<div class="row fieldGroup rowname"><div class="col-md-12"><div class="row"><div class="col-md-2 pr-3"><div class="form-group"><input type="number" name="cheque_book_serial_no[]" class="form-control" placeholder="Example:1001-200"></div></div><div class="col-md-1"><a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a> </div> </div> </div></div>';
                $(this).parents('.fieldGroup:last').after(fieldHTML);
            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
            });
        });
    </script>
@endpush