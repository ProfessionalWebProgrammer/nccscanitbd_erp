@extends('layouts.account_dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <!-- Main content -->
    <div class="content px-4 ">
        <div class="container-fluid">
            <div class="pt-3 text-center">
                <h4 class="font-weight-bolder text-uppercase">Bank Edit</h4>
                <hr width="33%">
            </div>

            <form class="floating-labels m-t-40" action="{{Route('master.bank.update')}}" method="POST">
                @csrf
                <div class="row pt-4">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Bank Name :</label>
                            <div class="col-sm-9">
                                <input type="Text" name="bank_name" value="{{$masterBank->bank_name}}" class="form-control" placeholder="Bank Name">
                            </div>
                        </div>
                    </div>
 					<input type="hidden" name="bank_id" value="{{$masterBank->bank_id}}" class="form-control">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Main Bank :</label>
                            <div class="col-sm-9">
                                <select name="main_bank_id" class="form-control select2">
                                    <option value="">Select Main Bank</option>

                                    @foreach ($mainbank as $item)
                                    <option value="{{$item->id}}" @if($masterBank->main_bank_id == $item->id) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                              </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Bank A/C :</label>
                            <div class="col-sm-9">
                                <input type="Text" name="bank_licence" value="{{$masterBank->bank_licence}}" class="form-control" placeholder="Bank A/C">
                            </div>
                        </div>
                    </div>
                  <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Opening Balance:</label>
                            <div class="col-sm-9">
                                <input type="Text" name="bank_op" value="{{$masterBank->bank_op}}" class="form-control" placeholder="Opening Balance">
                            </div>
                        </div>

                    </div>
                  
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Starting Balacen:</label>
                            <div class="col-sm-9">
                                <input type="Text" name="bank_starting_balance"  value="{{$masterBank->bank_starting_balance}}" class="form-control" placeholder="Starting Balance">
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
                                    <option value="{{$item->id}}" @if($masterBank->loan_type == $item->id) selected @endif>{{$item->type}}</option>
                                    @endforeach
                                </select>
                              </div>
                        </div>
                    </div>
                  <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Loan Amount:</label>
                            <div class="col-sm-9">
                                <input type="Text" name="loan_amount"  value="{{$masterBank->loan_amount}}" class="form-control" placeholder="Loan Amount">
                            </div>
                        </div>

                    </div>
                   <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Loan From Date:</label>
                            <div class="col-sm-9">
                                <input type="date" name="loan_fdate"  value="{{$masterBank->loan_fdate}}" class="form-control" >
                            </div>
                        </div>

                    </div>
                  <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Loan To Date:</label>
                            <div class="col-sm-9">
                                <input type="date" name="loan_tdate"  value="{{$masterBank->loan_tdate}}" class="form-control" >
                            </div>
                        </div>

                    </div>

                   

                    
                    <div class="col-md-6">  
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"> Address:</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="bank_address"  rows="3" placeholder=" Address">{{$masterBank->bank_address}}</textarea>
                                <!-- <input type="Text" class="form-control" placeholder="Warehouse Address"> -->
                            </div>
                        </div>
                    </div> <label ></label>
                                                        
                   {{-- <div class="col-md-6">
                             <div class="form-group">
                                  <label class="col-form-label">Cheque Book No:</label>
                                       <input type="text" name="cheque_book_no[]" class="form-control" placeholder="Example:100">
                               			
                               		   <!-- <input type="text" name="cheque_book_no[]" class="form-control mt-3" placeholder="Example:100"> -->
                              </div>
                      </div>
                  <div class="col-md-6">
                             <div class="form-group">
                                  <label class="col-form-label">Checkbook Serial No:</label>
                                       <input type="number" name="cheque_book_serial_no[]" class="form-control" placeholder="Example:1001-200">
                               			@php 
                               			$cheque_book_serials = DB::table('cheque_books')->select('cheque_books.cheque_book_serial_no')->where('cheque_books.bank_id', '$masterBank->bank_id')->get();
                               			@endphp 
                               			@foreach($cheque_book_serials as $data)
                               		   <input type="number" name="cheque_book_serial_no[]" value="{{$data->cheque_book_serial_no}}" class="form-control mt-3" placeholder="Example:1001-200">
                               			@endforeach
                              </div>
                      </div> --}}
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

        </form>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(document).ready(function() {
        //add more fields group
        $("body").on("click", ".addMore", function() {
            var fieldHTML =
                '<div class="row fieldGroup rowname"> <div class="col-md-12 "> <div class="row"> <div class="col-md-12 ml-auto"> <div class="row"> <div class="col-md-4"> <label for="">Wirehouse Name:</label> <select name="" class="form-control" id=""> <option value="">==Select One==</option> <option value="">Saver, Dhaka</option> <option value="">Mirpur, Dhaka</option> <option value="">Gulsan Dhaka</option> <option value="">Rangpur</option> <option value="">Pabna</option> </select> </div><div class="col-md-3"> <label for=""> Trasnsport Cost per Bag :</label> <input type="email" class="form-control" id="exampleFormControlInput1"> </div><div class="col-md-1"> <label for="">Action :</label> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> <a href="" class=""></a> </div></div></div><div class="col-md-2"></div></div></div></div>';
            $(this).parents('.fieldGroup:last').after(fieldHTML);
        });
        //remove fields group
        $("body").on("click", ".remove", function() {
            $(this).parents(".fieldGroup").remove();
        });
    });
</script>
@endsection