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
                      <h6 class=" font-weight-bold" style="font-size:24px;">Individual  Account  List</h6>
                        <hr>
                    </div>
                    <div class="flex float-right">
                        <a href="{{ route('individual.account.create') }}" class="btn btn-success ">Create Individual Account</a>
                        <a href="{{ route('sub.sub.account.list') }}" class="btn btn-danger ">Sub Sub Account List</a>
                        <a href="{{ route('sub.account.list') }}" class="btn btn-info">Sub Account List</a>
                    </div>
                    <table id="exampleWithoutPag" class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead class="text-center">

                            <tr>
                                <th style=" font-weight: bold;">SI</th>
                                <th style=" font-weight: bold;">Individual Account</th>
                                <th style=" font-weight: bold;">Sub Sub Account</th>
                                <th style=" font-weight: bold;">Sub Account</th>
                                <th style=" font-weight: bold;">Main Account</th>
                                <th style=" font-weight: bold;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $startSerial = ($individualAccounts->currentPage() - 1) * $individualAccounts->perPage() + 1;
                        @endphp
                         @foreach ($individualAccounts as $individualAccount)
                            <tr>
                              <td>{{ $startSerial++}}</td>    
                              <td> <span style="color:green">Name</span> : {{ $individualAccount->title }}<br/>
                                <span style="color:red">Code</span> : {{ $individualAccount->code }}
                                </td>  
                              <td> <span style="color:green">Name</span> : {{ $individualAccount?->acSubSubAccount?->title }} <br/>
                                <span style="color:red">Code</span> : {{ $individualAccount?->acSubSubAccount?->code }}</td>    
                              <td> <span style="color:green">Name</span> : {{ $individualAccount?->acSubSubAccount?->acSubAccount?->title }} <br/>
                                <span style="color:red">Code</span> : {{ $individualAccount?->acSubSubAccount?->acSubAccount?->code }}</td>    
                              <td><span style="color:green">Name</span> : {{ $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->title }} <br/>
                                <span style="color:red">Code</span> : {{ $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->code }}</td>    
                              <td class="text-center">
                                <a class="btn btn-xs btn-danger salesdelete" href="" data-toggle="modal" data-target="#delete"
                                data-myid="{{ $individualAccount->id }}"><i class="far fa-trash-alt"></i>
                </a>
                            </td>    
                            </tr> 
                         @endforeach

                        </tbody>

                       
                    </table>
                    <div>
                        {{ $individualAccounts->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>


       <!-- modal -->
       <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('individual.account.delete')}}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this Account?</p>

                        <input type="hidden" id="mid" name="id">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-light">Confirm</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<!-- /.modal -->
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
