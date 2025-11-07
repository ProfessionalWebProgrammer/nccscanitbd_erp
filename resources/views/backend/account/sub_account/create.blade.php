@extends('layouts.account_dashboard')

@section('print_menu')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="contentbody">

        <!-- Main content -->
        <div class="content px-4 ">

            <div class="container-fluid"  >

               <div class="row pt-2">
                  	
                </div>

                <div class="text-center pt-3">
                    <div class="flex float-right">
                        <a href="{{ route('sub.account.list') }}" class="btn btn-primary text-white">Sub Account List</a>
                    </div>
                </div>
                <div class="py-4">
                    <div class="text-center">
                      <h6 class=" font-weight-bold" style="font-size:24px;">Sub Account Create</h6>
                        <hr>
                    </div>
                  
                    <form class="floating-labels m-t-40" action="{{ Route('sub.account.store') }}" method="POST">
                        @csrf
            
                        <div class="content px-4 ">
                          
            
                            <div class="container" style="background:#fff;padding:0px 40px; min-height:10vh;">
                            
                                <div class="row pt-4">
                                    <div class="form-group  col-md-6">
                                        <label class="col-sm-3 col-form-label">Main Account</label>
                                        {{-- <div class="col-sm-9"> --}}
        
                                            <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                                name="ac_main_account_id" required>
                                                  <option value="">Select Main Account</option>
                                                @foreach ($mainAccounts as $mainAccount)
                                                  <option value="{{ $mainAccount->id }}">{{ $mainAccount->title }} ({{ $mainAccount->code}})</option> 
                                                @endforeach
                                            </select>
                                        {{-- </div> --}}
                                    </div>
            
            
                                    <div class="form-group  col-md-6">
                                        <label class="col-sm-3 col-form-label">Sub Account:</label>
                                        {{-- <div class="col-sm-9"> --}}
                                            <input type="text" class="form-control" id="pcode" name="title" placeholder="Enter Sub Sub Account" required >
                                        {{-- </div> --}}
                                    </div> 
            
            
            
                                </div>
            
                            
                                <div class="row pb-5">
                                    <div class="col-md-6 mt-3">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary custom-btn-sbms-submit"> Submit </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
            
                                    </div>
                                </div>
            
                                </div>
                                <!-- /.container-fluid -->
                            </div>
            
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

<script type="text/javascript">
      $(document).ready(function(){
          $('body').mouseenter(function(){
            $('#btnExport').css("display","inline-block");
                        $('#printbtn').css("display","inline-block");
          });
        });

    function printDiv(divName) {
      			$('#btnExport').css("display","none");
      			$('#printbtn').css("display","none");
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
            $("#reporttable").table2excel({
                filename: "CashBook.xls"
            });
        });
    });
</script>
@endsection
