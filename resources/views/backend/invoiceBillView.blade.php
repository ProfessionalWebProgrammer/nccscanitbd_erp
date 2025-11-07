@extends('layouts.settings_dashboard')
@section('print_menu')
			<li class="nav-item">
                    <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export 
                    </button>
                </li>
			<li class="nav-item ml-1">
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print 
                    </button>
            </li>			
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent" id="contentbody">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid bg-white p-5">
              <div class="row">
                <div class="col-md-3">
                  <div class="imag">
                    <img src="{{ asset('public/uploads/logo.jpg') }}" class="w-60" style="width:80px" alt="User Image">
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="row">
                  <div class="col-md-9 mt-5">
                  	<h3 class="text-center mt-4"><u>Invoice </u></h3>
                  </div>
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="text-left">
                    DATE: {{$data->date}}
                </div>
                  </div>
                <div class="col-md-6">
                  <div class="text-right">
                    INVOICE NO: {{$data->invoice}}
                </div>
                  </div>
                <div class="col-md-12 mt-4">
                  <div class="text-left">
                    <h6><u>FROM</u></h6>
                    <span>Company Name: {{$data->f_company}}</span></br>
                  	<span>Address: {{$data->f_address}}</span></br>
                	<span>Phone: {{$data->f_phone}}</span></br>
              		<span>Email: {{$data->f_email}}</span></br>
      				<h6>Account Info:</h6>
      				<span>Bank Name: {{$data->f_bankname}}</span></br>
					<span>Account Name: {{$data->f_account}}</span></br>
					<span>Account No: {{$data->f_accountno}}</span></br></br>
					<h6><u>TO</u></h6>
					 <span>Company Name: {{$data->t_company}}</span></br>
                  	<span>Address: {{$data->t_address}}</span></br>
                	<span>Phone: {{$data->t_phone}}</span></br>
              		<span>Email: {{$data->t_email}}</span></br>
                </div>
                  </div>

              </div>
      <style>
        table{
        border-collapse: collapse;
        }
        .table td, .table th{
          border-top:none!important
        }
        table, .table td, .table th{
		border: 1px solid #666!important;
        }
        
      </style>
                <div class="py-2 ">
                  <h6>Details</h6>
                    <table class="table" style="font-size: 15px;">
                        <thead>
                            <tr >
                                <th>Product name</th>
                                <th>Type</th>
                                <th>Rate</th>
                                <th>Qty</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 16px;">
                          	  <tr>
                                    <td>{{$data->p_name1 ?? ' '}}</td>
                                    <td>{{$data->p_type1 ?? ' '}}</td>
                                    <td>{{$data->p_rate1 ?? 0}}/- </td> 
                                    <td>{{$data->p_qty1 ?? 0}}</td> 
                                    <td class="text-right">{{$data->p_amount1 ?? 0}}/-</td> 
                                </tr> 
                          		<tr>
                                    <td>{{$data->p_name2 ?? ' '}}</td>
                                    <td>{{$data->p_type2 ?? ' '}}</td>
                                    <td>{{$data->p_rate2 ?? 0}}/- </td> 
                                    <td>{{$data->p_qty2 ?? 0}}</td> 
                                    <td class="text-right">{{$data->p_amount2 ?? 0}}/-</td> 
                                </tr>

                          <tr>
                              <th >Total ($ in millions):</th>
                              <th colspan="4" style=" text-transform: capitalize;">{{$amountInWords}} tk only</th>                            
                             <tr>
                           </tbody> 
                    </table>
                </div>
				<div class="py-2 ">
                  <h6>Payment Terms </h6>
                    <table class="table" style="font-size: 15px;">
                        <thead>
                            <tr >
                                <th>Head</th>
                              	<th class="text-center">Amount</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 16px;">
                          	  <tr>
                                    <td>Total Bill:</td>
                                    <td class="text-center">{{$data->pay_total_bill ?? 0}}/-</td>
                                    <td>{{$data->pay_total_bill_remark ?? ' '}} </td> 
                                </tr> 
                          		<tr>
                                    <td>Advance Payment:</td>
                                    <td class="text-center">{{$data->pay_advn_amount ?? 0}}/-</td>
                                    <td>{{$data->pay_advn_amount_remark ?? ' '}} </td> 
                                </tr>

                          <tr >
                              <th >Due Amount After Payment:</th>
                              <th class="text-center">{{round($data->pay_total_bill - $data->pay_advn_amount) ?? 0}}/-</th> 
                              <th></th>
                             </tr>
                           </tbody> 
                    </table>
                </div>
			<div class="col-md-12 mt-5"> 
                                          <div class="text-right mt-5" > 
                                                                 <div class="imag" style="margin-top:100px;">
                                                                  <img src="{{ asset('public/uploads/signature.png') }}" class="w-60" style="width:80px; margin-right: 20px;" alt="User Image">
                                                                <div style="width:125px; height:1px; position: relative; margin-left:87%; margin-top:12px; background:#333;"></div>
                                                                </div>
                                                                 <p>Authorize signature </p>     
                                                                 </div>
                            </div>
            </div>
        </div>
    </div>
  
@endsection


@push('end_js')

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })


        $('#delete').on('show.bs.modal', function(event) {
            console.log('hello test');
            var button = $(event.relatedTarget)
            var title = button.data('mytitle')
            var id = button.data('myid')

            var modal = $(this)

            modal.find('.modal-body #mid').val(id);
        })
    </script>
<script type="text/javascript">
    function printDiv(divName) {
             var printContents = document.getElementById(divName).innerHTML;
             var originalContents = document.body.innerHTML;

             document.body.innerHTML = printContents;

             window.print();

             document.body.innerHTML = originalContents;
        }
</script>

<script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#datatablecustom").table2excel({
                filename: "Invoice.xls"
            });
        });
    });
  
</script>

@endpush

