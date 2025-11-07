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
                  	<div class="col-md-12 text-right">
                         <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                           Export
                        </button>
                        <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                           Print
                        </button>
                    </div>
                </div>

                <div class="text-center pt-3">
                 
                </div>
                <div class="py-4">
                    <div class="text-center">
                      <h6 class=" font-weight-bold" style="font-size:24px;">Chart of  Account</h6>
                        <hr>
                    </div>
                    <div class="flex float-right">
            

                    </div>
                    <div class="offset-md-2 col-md-8">
                        <div id="accordion" class="accordion">
                            @foreach ($mainAccounts as $key => $mainAccount)
                            <a href="#collapseOne-{{ $mainAccount->id }}" class="card-link" data-toggle="collapse">
                                <div class="card">
                                    <div class="card-header collapsed" id="headingOne-{{ $mainAccount->id }}" style="background-color:orange;color:black">
                                        <h5 class="mb-0" style="font-weight:bold">
                                            {{ $mainAccount->title }}
                                            <button class="btn btn-link float-right" data-toggle="collapse" data-target="#collapseOne-{{ $mainAccount->id }}" aria-expanded="{{ $key === 0 ? 'true' : 'false' }}" aria-controls="collapseOne-{{ $mainAccount->id }}">
                                                <span style="color:black;font-weight:bold">Code : {{ $mainAccount->code }}</span>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseOne-{{ $mainAccount->id }}" class="collapse {{ $key === 0 ? 'show' : '' }}" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body">
                                           <h4>Acccount Details</h4>
                                           <table class="table table-bordered table-sm">
                                              <tr style="background-color:green;color:white">
                                                 <th>Sub Account</th>
                                                 <th>Sub Sub Account & Individual Account</th>
                                              </tr>
                                              @if ($mainAccount->subAccounts && count($mainAccount->subAccounts) > 0)
                                              @foreach ($mainAccount->subAccounts as $subAccount)
                                              <tr>
                                                <td style="vertical-align: middle;" >
                                                    <span style="color:green">Name</span> : {{ $subAccount->title }} <br/>
                                                    <span style="color:red">Code</span> : {{ $subAccount->code }}
                                                </td>
                                                <td style="padding: 0px">
                                                    <table class="table table-bordered table-sm" style="margin: 0;">
                                                       @foreach ($subAccount->subSubAccounts as $subSubAccount)
                                                       <tr>
                                                            <td style="vertical-align: middle;">
                                                            <span style="color:green">Name</span> : {{ $subSubAccount->title }} <br/>
                                                            <span style="color:red">Code</span> : {{ $subSubAccount->code }} 
                                                            </td>
                                                            <td style="padding: 0px;">
                                                                <table class="table table-bordered table-sm" style="margin: 0;">
                                                                    @foreach ($subSubAccount->individualAccounts as $individualAccount)
                                                                    <tr>
                                                                        <td style="vertical-align: middle;">
                                                                            <span style="color:green">Name</span> : {{ $individualAccount->title }} <br/>
                                                                            <span style="color:red">Code</span> : {{ $individualAccount->code }} 
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </table>
                                                            </td>
                                                        </tr>
                                                       @endforeach
                                                       
                                                    </table>
                                                </td>
                                              </tr> 
                                              @endforeach
                                              @else
                                              <tr class="text-center">
                                                <td colspan="3">No data found</td>
                                             </tr> 
                                              @endif
                                           </table>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        
                        
                    </div>
                    {{-- <table id="exampleWithoutPag" class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead class="text-center">

                            <tr>
                                <th style=" font-weight: bold;">SI</th>
                                <th style=" font-weight: bold;">Date</th>
                                <th style=" font-weight: bold;">Main Account</th>
                                <th style=" font-weight: bold;">Sub Account</th>
                                <th style=" font-weight: bold;">Sub Sub Account</th>
                                <th style=" font-weight: bold;">Individual Account</th>
                                <th style=" font-weight: bold;">Description</th>
                                <th style=" font-weight: bold;">Created By</th>
                                <th style=" font-weight: bold;">Debit</th>
                                <th style=" font-weight: bold;">Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $startSerial = ($chartOfAccounts->currentPage() - 1) * $chartOfAccounts->perPage() + 1;
                        @endphp
                         @foreach ($chartOfAccounts as $chartOfAccount)
                            <tr>
                              <td>{{ $startSerial++}}</td> 
                              <td>{{ \Carbon\Carbon::parse($chartOfAccount->date)->format('j F ,Y')}}</td>    
                              <td>{{ $chartOfAccount?->acMainAccount->title }} ({{ $chartOfAccount?->acMainAccount->code }})</td>  
                              <td>{{ $chartOfAccount?->acSubAccount?->title }} ({{ $chartOfAccount?->acSubAccount?->code }})</td>    
                              <td>{{ $chartOfAccount?->acSubSubAccount?->title }}  ({{ $chartOfAccount?->acSubSubAccount?->code }})</td>    
                              <td>{{ $chartOfAccount?->acIndividualAccount?->title }}  ({{ $chartOfAccount?->acIndividualAccount?->code }})</td> 
                              <td>{{ $chartOfAccount?->comment}}</td>    
                              <td>{{ $chartOfAccount?->user->name}}</td>  
                              <td>{{ $chartOfAccount?->debit}}</td>  
                              <td>{{ $chartOfAccount?->credit}}</td>    
                             
                            </tr> 
                         @endforeach

                        </tbody>

                       
                    </table> --}}
                </div>
            </div>

        </div>
    </div>


      
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

@endpush









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
