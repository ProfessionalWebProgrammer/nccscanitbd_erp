@extends('layouts.account_dashboard')

@push('addcss')
    <style>
        .text_sale {
            color: #f7ee79;
        }

        .text_credit {
            color: lime;
        }

    </style>
@endpush


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
    <div class="content-wrapper" id="contentbody">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                  
                  
                  @php
                  $uid = Auth::id();
                
                   @endphp
                  
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h4 class="text-uppercase font-weight-bold">Trail Balance Head Change</h4>
                        <hr style="background: #ffffff78;">
                    </div>

                    <div class="py-4 col-md-8 m-auto table-responsive">
                        <form class="floating-labels m-t-40" action="{{ Route('accounts.trail.balance.head.change.store') }}" method="POST">
                        @csrf
                          
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 6;table-layout: inherit;">
                            <thead>
                                <tr>
                                    <th>Head </th>
                                    <th align="right">Change Head Name </th>
                               
                                </tr>
                            </thead>
                            <tbody>
                                 <tr>
                                    <td>Cash Amount</td>
                                     
                                @php
                               $cashamount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"cashamount")->value('change_name');

                                 @endphp
                                      <td align="right"><input type="hidden" class="form-control" name="head[]" value="cashamount">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$cashamount ? $cashamount : ''}}">
                                   </td>

                                </tr>
                                <tr>
                                   <td>Purchae Account</td>
                                   @php
                               $purchaseaccount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"purchaseaccount")->value('change_name');

                                 @endphp
                                     <td align="right"><input type="hidden" class="form-control"  name="head[]" value="purchaseaccount">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$purchaseaccount ? $purchaseaccount : ''}}">
                                   </td>

                                </tr>
                                <tr>
                                   @php
                               $accountpayable =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"accountpayable")->value('change_name');

                                 @endphp
                                    <td>Account Payable</td>
                                    <td align="right"><input type="hidden"class="form-control"   name="head[]" value="accountpayable">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$accountpayable ? $accountpayable : ''}}">
                                   </td>
                            
                                </tr>
                                <tr>
                                   @php
                               $gpurchaseaccount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"gpurchaseaccount")->value('change_name');

                                 @endphp
                                    <td>General Purchae Account</td>
                                    <td align="right"><input type="hidden" class="form-control"  name="head[]" value="gpurchaseaccount">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$gpurchaseaccount ? $gpurchaseaccount : ''}}">
                                   </td>

                                </tr>



                                <tr>
                                   @php
                               $gpurchaseaccountpayable =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"gpurchaseaccountpayable")->value('change_name');

                                 @endphp
                               
                                    <td>General Purchae Account Payable (Account Payable)</td>
                                    <td align="right"><input type="hidden" class="form-control" name="head[]" value="gpurchaseaccountpayable">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$gpurchaseaccountpayable ? $gpurchaseaccountpayable : ''}}">
                                   </td>
                            
                                </tr>
                              
                                <tr>
                                   @php
                               $purchasereturn =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"purchasereturn")->value('change_name');

                                 @endphp
                                    <td>Purchae Return</td>
                                    <td align="right"><input type="hidden"class="form-control"   name="head[]" value="purchasereturn">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$purchasereturn ? $purchasereturn : ''}}">
                                   </td>
                          
                                </tr>

                                <tr>
                                   @php
                               $salesacount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"salesacount")->value('change_name');

                                 @endphp
                                    <td>Sales Account</td>
                                    <td align="right"><input type="hidden"class="form-control"   name="head[]" value="salesacount">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$salesacount ? $salesacount : ''}}">
                                   </td>
                             
                                </tr>
                                <tr>
                                   @php
                               $accountreceivable =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"accountreceivable")->value('change_name');

                                 @endphp
                                    <td>Account Receiveable</td>
                                    <td align="right"><input type="hidden"class="form-control"   name="head[]" value="accountreceivable">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$accountreceivable ? $accountreceivable : ''}}">
                                   </td>

                                </tr>
                                <tr>
                                   @php
                               $salesreturn =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"salesreturn")->value('change_name');

                                 @endphp
                                  <td>Sales Return</td>
                                    <td align="right"><input type="hidden" class="form-control"  name="head[]" value="salesreturn">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$salesreturn ? $salesreturn : ''}}">
                                   </td>

                                </tr>

                              
                              
                                <tr>
                                   @php
                               $expansedetails =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"expansedetails")->value('change_name');

                                 @endphp
                                    
                                    <td >Expanse Details</td>
                                    <td align="right"><input type="hidden"class="form-control"   name="head[]" value="expansedetails">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$expansedetails ? $expansedetails : ''}}">
                                   </td>
                                    

                                </tr>
                             @php
                               $texpnaseamount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"texpnaseamount")->value('change_name');

                                 @endphp
                                <tr style="font-weight:bold">
                                   <td> Total Expanse Amount</td>
                                    <td align="right"><input type="hidden"class="form-control"   name="head[]" value="texpnaseamount">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$texpnaseamount ? $texpnaseamount : ''}}">
                                   </td>

                                </tr>



                                <tr>
                                   @php
                               $journalamount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"journalamount")->value('change_name');

                                 @endphp
                                  
                             
                                    <td>Journal Amount</td>
                                    <td align="right"><input type="hidden"class="form-control"   name="head[]" value="journalamount">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$journalamount ? $journalamount : ''}}">
                                   </td>
                                 
                                </tr>
                                <tr>
                                   @php
                               $assetamount =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"assetamount")->value('change_name');

                                 @endphp
                                    <td>Assets Amount</td>
                                    <td align="right"><input type="hidden" class="form-control"  name="head[]" value="assetamount">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$assetamount ? $assetamount : ''}}">
                                   </td>

                                </tr>

                              
                                <tr>
                                      @php
                               $cogs =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"cogs")->value('change_name');

                                 @endphp
                                  
                                  
                                  <td>C.O.G.S</td>
                                    <td align="right"><input type="hidden"class="form-control"   name="head[]" value="cogs">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$cogs ? $cogs : ''}}">
                                   </td>

                                </tr>

                                <tr>
                                      @php
                               $liability =  DB::table('trail_balance_heads')->where('user_id',$uid)->where('head',"liability")->value('change_name');

                                 @endphp
                                  
                                    <td>Liabilitys </td>
                                    <td align="right"><input type="hidden" class="form-control"  name="head[]" value="liability">
                                   <input type="text" class="form-control" name="change_name[]" value="{{$liability ? $liability : ''}}">
                                   </td>
                                </tr>




                            </tbody>

                           




                        </table>
                          
                           <div class="class row">
                            <div class="class col-md-4"></div>
                            <div class="class col-md-4 px-5">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>


                            </div>
                            <div class="class col-md-4">
                            </div>
                        </div>
                          
                           </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- <script>
        $(document).ready(function() {

            $("#products_id").on('change', function() {

                var product_id = $(this).val();

                alert(product_id);

                $.ajax({
                    url: '{{ url('/scale/data/get/') }}/' + id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);



                        $("#data").val(data.date);
                        $("#vehicle").val(data.vehicle);
                        $("#supplier_chalan_qty").val(data.chalan_qty).attr('readonly',
                            'readonly');
                        $("#receive_quantity").val(data.actual_weight).attr('readonly',
                            'readonly');

                        $("#supplier_id").val(data.supplier_id);
                        $("#wirehouse").val(data.warehouse_id);
                        $("#product_id").val(data.rm_product_id);

                        $('.select2').select2({
                            theme: 'bootstrap4'
                        })

                    }
                });


                calculation();


            });
        });
    </script> --}}


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
            $("#reporttable").table2excel({
                filename: "Trail_balance.xls"
            });
        });
    });
</script>

@endsection
