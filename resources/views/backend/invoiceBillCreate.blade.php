@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ Route('invoiceBill.store') }}" method="POST" >
                @csrf
                <div class="container-fluid">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Invoice Bill Create</h4>
                        <hr width="33%">
                    </div>
                  <h4>Invoice From:</h4>
                    <div class="row pt-4">
                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date:</label>
                                <div class="col-sm-9">
                                    <input type="date" name="date" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row"> 
                                <label class="col-sm-3 col-form-label">Company Name :</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="f_company" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Address :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="f_address" class="form-control" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Phone :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="f_phone" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email:</label>
                                <div class="col-sm-9">
                                    <input type="email" name="f_email" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Bank Name:</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="f_bankname" class="form-control" >
                                </div>
                            </div>
                        </div>

                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Account Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="f_account" class="form-control" >
                                </div>
                            </div>
                        </div>
                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Account No:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="f_accountno" class="form-control" >
                                </div>
                            </div>
                        </div>
                      </div>
                      <h4 class="pt-4">Invoice To:</h4>
                      <div class="row">
                      <div class="col-md-6">
                            <div class="form-group row"> 
                                <label class="col-sm-3 col-form-label">Company Name :</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="t_company" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Address :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="t_address" class="form-control" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Phone :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="t_phone" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email:</label>
                                <div class="col-sm-9">
                                    <input type="email" name="t_email" class="form-control">
                                </div>
                            </div>
                        </div>
                        </div>
                  		<h4 class="pt-4">Item 1:</h4>
                  		<div id="field">
                          <div class="fieldGroup">
                      	<div class="row">
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="p_name1" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Type:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="p_type1" class="form-control" >
                                </div>
                            </div>
                        </div>
                          <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Rate:</label>
                                <div class="col-sm-9">
                                    <input type="number" name="p_rate1" class="form-control p_rate1" >
                                </div>
                            </div>
                        </div>
                          <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Quantity:</label>
                                <div class="col-sm-9">
                                    <input type="number" name="p_qty1" class="form-control p_qty1" >
                                </div>
                            </div>
                        </div>
                          <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Amount:</label>
                                <div class="col-sm-9">
                                    <input type="number" name="p_amount1" class="form-control p_amount1" >
                                </div>
                            </div>
                        </div>
                        </div>
                  		<h4 class="pt-4">Item 2:</h4>
                      	<div class="row">
                         <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="p_name2" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Type:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="p_type2" class="form-control" >
                                </div>
                            </div>
                        </div>
                          <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Rate:</label>
                                <div class="col-sm-9">
                                    <input type="number" name="p_rate2" class="form-control p_rate2" >
                                </div>
                            </div>
                        </div>
                          <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Quantity:</label>
                                <div class="col-sm-9">
                                    <input type="number" name="p_qty2" class="form-control p_qty2" >
                                </div>
                            </div>
                        </div>
                          <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Amount:</label>
                                <div class="col-sm-9">
                                    <input type="number" name="p_amount2" class="form-control p_amount2">
                                </div>
                            </div>
                        </div>
                          <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Total Amount:</label>
                                <div class="col-sm-9">
                                    <input type="number" name="p_total" class="form-control p_total" >
                                </div>
                            </div>
                        </div>
                        </div> 
                  		<h4 class="pt-4">Payment Terms:</h4>
                      	<div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Total Bill:</label>
                                <div class="col-sm-9">
                                    <input type="number" name="pay_total_bill" class="form-control pay_total_bill" >
                                </div>
                            </div>
                        </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Bill Remarks:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="pay_total_bill_remark" class="form-control" >
                                </div>
                            </div>
                        </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Advance Amount:</label>
                                <div class="col-sm-9">
                                    <input type="number" name="pay_advn_amount" class="form-control pay_advn_amount" >
                                </div>
                            </div>
                        </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Advance Remarks:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="pay_advn_amount_remark" class="form-control" >
                                </div>
                            </div>
                        </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Due Amount:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="due_amount" class="form-control due_amount" disabled>
                                </div>
                            </div>
                        </div>
                        </div></div></div>

                </div>
                <div class="row pb-5">
                    <div class="col-md-6 mt-3">
                        <div class="text-right">
                            <button type="submit" class="btn custom-btn-sbms-submit"> Save </button>
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
@endsection

@push('end_js')
<script>
        $(document).ready(function() {
          $('#field').on('input','.p_rate1, .p_qty1, .p_rate2, .p_qty2, .pay_advn_amount',function(){
          var parent = $(this).closest('.fieldGroup');
            var p_rate1 = parent.find('.p_rate1').val();
			var p_qty1 = parent.find('.p_qty1').val();
            const sub_total_a = p_rate1*p_qty1;
            
            parent.find('.p_amount1').val(sub_total_a);
            
            var p_rate2 = parent.find('.p_rate2').val();
			var p_qty2 = parent.find('.p_qty2').val();
           const sub_total_b = p_rate2*p_qty2;
            parent.find('.p_amount2').val(sub_total_b);
            
            const total  = sub_total_a + sub_total_b;
           
            parent.find('.p_total').val(total);
            parent.find('.pay_total_bill').val(total);
			const advance =  parent.find('.pay_advn_amount').val();
            const due = total - advance;
            parent.find('.due_amount').val(due);
          });
        });
 </script>
@endpush
