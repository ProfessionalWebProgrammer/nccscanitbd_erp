@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ Route('user.setting.set.permission.store') }}" method="POST">
                @csrf
                <div class="container-fluid ml-5">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Set User Permission</h4>
                        <hr width="33%">
                        <h5>{{$user->name}}</h5>
                        <h6>{{$user->email}}</h6>
                    </div>
                    <div class="row pt-4 ">
                      <input type="hidden" name="user_id" value="{{$user->id}}">



                      @php
                      $uid = $user->id;
                        $salesdata = DB::table('permissions')->where('head',"Sales")->where('user_id',$uid)->pluck('name')->toArray();
                        $purchasedata = DB::table('permissions')->where('head',"Purchase")->where('user_id',$uid)->pluck('name')->toArray();
                        $accountsdata = DB::table('permissions')->where('head',"Accounts")->where('user_id',$uid)->pluck('name')->toArray();
                        $settingsdata = DB::table('permissions')->where('head',"Settings")->where('user_id',$uid)->pluck('name')->toArray();
                        $marketingdata = DB::table('permissions')->where('head',"Marketing")->where('user_id',$uid)->pluck('name')->toArray();


                      @endphp

                        <div class="col-md-12">
                          {{-- <input class="form-check-input" style="margin-top: 7px;" type="checkbox" name="sales[]"  value="sales" id="salessection">
                                <label class="form-check-label" for="salessection"> --}}
                                  <h4 style="color:rgb(211, 223, 41)">Sales Section

                                  </h4>


                                {{-- </label> --}}

                        </div>

                        <div class="col-md-2">
                        </div>

                        <div class="col-md-10 " style="font-size:20px">

                          <a  id="salesselect" style="cursor: pointer; color:rgb(255, 143, 143)">Select All </a>
                          <a  class="ml-4" id="salesunselect" style="cursor: pointer; color:rgb(143, 255, 177)">UnSelect All </a>
                            <div class="form-check">
                                <input class="form-check-input salesclass" style="margin-top: 10px;" type="checkbox" name="sales[]" value="salesentry" id="salesposting" @if(in_array("salesentry", $salesdata)) checked @endif>
                                <label class="form-check-label" for="salesposting">
                                  Sales Entry
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input salesclass" style="margin-top: 10px;" type="checkbox" name="sales[]" value="screate" id="screate" @if(in_array("screate", $salesdata)) checked @endif>
                                <label class="form-check-label" for="screate">
                                  All Create
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input salesclass" style="margin-top: 10px;" type="checkbox" name="sales[]" value="sedit" id="sedit" @if(in_array("sedit", $salesdata)) checked @endif>
                                <label class="form-check-label" for="sedit">
                                  All Edit
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input salesclass" style="margin-top: 10px;" type="checkbox" name="sales[]" value="sdelete" id="sdelete" @if(in_array("sdelete", $salesdata)) checked @endif>
                                <label class="form-check-label" for="sdelete">
                                  All Delete
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input salesclass" style="margin-top: 10px;" type="checkbox" name="sales[]" value="order" id="order" @if(in_array("order", $salesdata)) checked @endif>
                                <label class="form-check-label" for="order">
                                  Order
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input salesclass" style="margin-top: 10px;" type="checkbox" name="sales[]" value="salesledger" id="salseledger" @if(in_array("salesledger", $salesdata)) checked @endif>
                                <label class="form-check-label" for="salseledger">
                                  Sales Legers
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input salesclass" style="margin-top: 10px;" type="checkbox" name="sales[]" value="salesreport" id="salesreport" @if(in_array("salesreport", $salesdata)) checked @endif>
                                <label class="form-check-label" for="salesreport">
                                  Sales Report
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input salesclass" style="margin-top: 10px;" type="checkbox" name="sales[]" value="salesdc" id="salesdc" @if(in_array("salesdc", $salesdata)) checked @endif>
                                <label class="form-check-label" for="salesdc">
                                  D. C
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input salesclass" style="margin-top: 10px;" type="checkbox" name="sales[]" value="salestc" id="salestc" @if(in_array("salestc", $salesdata)) checked @endif>
                                <label class="form-check-label" for="salestc">
                                  T. C
                                </label>
                              </div>
                        </div>





                        <div class="col-md-12 mt-3">
                          {{-- <input class="form-check-input" style="margin-top: 7px;" type="checkbox"  name="purchase[]" value="purchase" id="purchasesection">
                          <label class="form-check-label" for="purchasesection"> --}}
                            <h4 style="color:rgb(211, 223, 41)">Purchase and Manufacture Section</h4>
                          {{-- </label> --}}

                        </div>

                        <div class="col-md-2">
                        </div>

                        <div class="col-md-10 " style="font-size:20px">
                          <a  id="purchaseselect" style="cursor: pointer; color:rgb(255, 143, 143)">Select All </a>
                          <a class="ml-4" id="purchaseunselect" style="cursor: pointer; color:rgb(143, 255, 177)">UnSelect All </a>

                            <div class="form-check">
                                <input class="form-check-input purchaseclass" style="margin-top: 10px;" type="checkbox" name="purchase[]" value="purchaseentry" id="purchaseentry"  @if(in_array("purchaseentry", $purchasedata)) checked @endif>
                                <label class="form-check-label" for="purchaseentry">
                                  Purchase Entry
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input purchaseclass" style="margin-top: 10px;" type="checkbox" name="purchase[]" value="lcentry" id="lcentry"  @if(in_array("lcentry", $purchasedata)) checked @endif>
                                <label class="form-check-label" for="lcentry">
                                  LC Entry
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input purchaseclass" style="margin-top: 10px;" type="checkbox" name="purchase[]" value="pcreate" id="pcreate"  @if(in_array("pcreate", $purchasedata)) checked @endif>
                                <label class="form-check-label" for="pcreate">
                                  All Create
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input purchaseclass" style="margin-top: 10px;" type="checkbox" name="purchase[]" value="pedit" id="pedit"  @if(in_array("pedit", $purchasedata)) checked @endif>
                                <label class="form-check-label" for="pedit">
                                  All Edit
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input purchaseclass" style="margin-top: 10px;" type="checkbox" name="purchase[]" value="pdelete" id="pdelete"  @if(in_array("pdelete", $purchasedata)) checked @endif>
                                <label class="form-check-label" for="pdelete">
                                  All Delete
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input purchaseclass" style="margin-top: 10px;" type="checkbox" name="purchase[]" value="production" id="production"  @if(in_array("production", $purchasedata)) checked @endif>
                                <label class="form-check-label" for="production">
                                Production
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input purchaseclass" style="margin-top: 10px;" type="checkbox" name="purchase[]" value="generalpurchase" id="generalpurchase"  @if(in_array("generalpurchase", $purchasedata)) checked @endif>
                                <label class="form-check-label" for="generalpurchase">
                                General Purchase
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input purchaseclass" style="margin-top: 10px;" type="checkbox" name="purchase[]" value="purchaseledger" id="purchaseledger"  @if(in_array("purchaseledger", $purchasedata)) checked @endif>
                                <label class="form-check-label" for="purchaseledger">
                                Purchase Legers
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input purchaseclass" style="margin-top: 10px;" type="checkbox" name="purchase[]" value="purchasereport" id="purchasereport"  @if(in_array("purchasereport", $purchasedata)) checked @endif>
                                <label class="form-check-label" for="purchasereport">
                                Purchase Report
                                </label>
                              </div>
                        </div>


                        <div class="col-md-12 mt-3">
                          {{-- <input class="form-check-input" style="margin-top: 7px;" type="checkbox" name="accounts[]" value="accounts" id="accountssection">
                          <label class="form-check-label" for="accountssection"> --}}
                            <h4 style="color:rgb(211, 223, 41)">Accounts</h4>
                          {{-- </label> --}}

                        </div>

                        <div class="col-md-2">
                        </div>



                        <div class="col-md-10 " style="font-size:20px">

                          <a  id="accountsselect" style="cursor: pointer; color:rgb(255, 143, 143)">Select All </a>
                          <a  class="ml-4" id="accountsunselect" style="cursor: pointer; color:rgb(143, 255, 177)">UnSelect All </a>

                              <div class="form-check">
                                <input class="form-check-input accountsclass" style="margin-top: 10px;"  name="accounts[]" type="checkbox" value="payment" id="payment"  @if(in_array("payment", $accountsdata)) checked @endif>
                                <label class="form-check-label" for="payment">
                                Payment
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input accountsclass" style="margin-top: 10px;"  name="accounts[]" type="checkbox" value="receive" id="receive"  @if(in_array("receive", $accountsdata)) checked @endif>
                                <label class="form-check-label" for="receive">
                                Receive
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input accountsclass" style="margin-top: 10px;"  name="accounts[]" type="checkbox" value="daybook" id="daybook"  @if(in_array("daybook", $accountsdata)) checked @endif>
                                <label class="form-check-label" for="daybook">
                                Daybook
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input accountsclass" style="margin-top: 10px;"  name="accounts[]" type="checkbox" value="acreate" id="acreate"  @if(in_array("acreate", $accountsdata)) checked @endif>
                                <label class="form-check-label" for="acreate">
                                  All Create
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input accountsclass" style="margin-top: 10px;"  name="accounts[]" type="checkbox" value="aedit" id="aedit"  @if(in_array("aedit", $accountsdata)) checked @endif>
                                <label class="form-check-label" for="aedit">
                                  All Edit
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input accountsclass" style="margin-top: 10px;"  name="accounts[]" type="checkbox" value="adelete" id="adelete"  @if(in_array("adelete", $accountsdata)) checked @endif>
                                <label class="form-check-label" for="adelete">
                                  All Delete
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input accountsclass" style="margin-top: 10px;" name="accounts[]" type="checkbox" value="tbalance" id="tbalance"  @if(in_array("tbalance", $accountsdata)) checked @endif>
                                <label class="form-check-label" for="tbalance">
                                Trail Balance
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input accountsclass" style="margin-top: 10px;"  name="accounts[]" type="checkbox" value="incomestement" id="incomestement"  @if(in_array("incomestement", $accountsdata)) checked @endif>
                                <label class="form-check-label" for="incomestement">
                                Income Statement
                                </label>
                              </div>
                        </div>


                        <div class="col-md-12 mt-3">
                          {{-- <input class="form-check-input" style="margin-top: 7px;"  name="settings[]" type="checkbox" value="" id="settingsection">
                          <label class="form-check-label" for="settingsection"> --}}
                             <h4 style="color:rgb(211, 223, 41)">Settings</h4>
                          {{-- </label> --}}

                        </div>

                        <div class="col-md-2">
                        </div>



                        <div class="col-md-10 " style="font-size:20px">
                          <a  id="settingsselect" style="cursor: pointer; color:rgb(255, 143, 143)">Select All </a>
                          <a  class="ml-4" id="settingsunselect" style="cursor: pointer; color:rgb(143, 255, 177)">UnSelect All </a>

                              <div class="form-check">
                                <input class="form-check-input settingsclass" style="margin-top: 10px;"  name="settings[]"  type="checkbox" value="warehouse" id="warehouse"  @if(in_array("warehouse", $settingsdata)) checked @endif>
                                <label class="form-check-label" for="warehouse">
                                Warehouse
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input settingsclass" style="margin-top: 10px;"  name="settings[]"  type="checkbox" value="employee" id="employee"  @if(in_array("employee", $settingsdata)) checked @endif>
                                <label class="form-check-label" for="employee">
                                Employee
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input settingsclass" style="margin-top: 10px;"  name="settings[]"  type="checkbox" value="scalerm" id="scalerm"  @if(in_array("scalerm", $settingsdata)) checked @endif>
                                <label class="form-check-label" for="scalerm">
                                Scale (Raw Materials)
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input settingsclass" style="margin-top: 10px;"  name="settings[]"  type="checkbox" value="usersetting" id="usersetting"  @if(in_array("usersetting", $settingsdata)) checked @endif>
                                <label class="form-check-label" for="usersetting">
                                  User Setting
                                </label>
                              </div>

                        </div>

                        <div class="col-md-12 mt-3">

                             <h4 style="color:rgb(211, 223, 41)">Marketing</h4>


                        </div>

                        <div class="col-md-2">
                        </div>



                        <div class="col-md-10 " style="font-size:20px">
                          <a  id="marketingselect" style="cursor: pointer; color:rgb(255, 143, 143)">Select All </a>
                          <a  class="ml-4" id="marketingunselect" style="cursor: pointer; color:rgb(143, 255, 177)">UnSelect All </a>

                              <div class="form-check">
                                <input class="form-check-input marketingclass" style="margin-top: 10px;"  name="marketing[]"  type="checkbox" value="marketing" id="marketing"  @if(in_array("marketing", $marketingdata)) checked @endif>
                                <label class="form-check-label" for="marketing">
                                Marketing
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input marketingclass" style="margin-top: 10px;"  name="marketing[]" type="checkbox" value="marketingCreate" id="marketingCreate"  @if(in_array("marketingCreate", $marketingdata)) checked @endif>
                                <label class="form-check-label" for="marketingCreate">
                                  All Create
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input marketingclass" style="margin-top: 10px;"  name="marketing[]" type="checkbox" value="marketingEdit" id="marketingEdit"  @if(in_array("marketingEdit", $marketingdata)) checked @endif>
                                <label class="form-check-label" for="marketingEdit">
                                  All Edit
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input marketingclass" style="margin-top: 10px;"  name="marketing[]" type="checkbox" value="marketingDelete" id="marketingDelete"  @if(in_array("marketingDelete", $marketingdata)) checked @endif>
                                <label class="form-check-label" for="marketingDelete">
                                  All Delete
                                </label>
                              </div>



                        </div>




                    </div>
                </div>
                <div class="row pb-5">
                    <div class="col-md-3"></div>

                    <div class="col-md-6 mt-3">
                        <div class="text-center">
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
@endsection


@push('end_js')


    <script>
        $(document).ready(function() {
            $("#emp").change(function(event) {
                var empid = $(this).val();
                $.ajax({
                    url: '{{ url('get/employee/') }}/' + empid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $("#name").val(data.emp_name)
                        $("#email").val(data.emp_mail_id)
                    }
                });
            });



            $("#salesselect").click(function(){
                $(".salesclass").each(function(){
                  $(this).prop('checked',true);
                })
            });
            $("#salesunselect").click(function(){
                $(".salesclass").each(function(){
                  $(this).prop('checked',false);
                })
            });

            $("#purchaseselect").click(function(){
                $(".purchaseclass").each(function(){
                  $(this).prop('checked',true);
                })
            });
            $("#purchaseunselect").click(function(){
                $(".purchaseclass").each(function(){
                  $(this).prop('checked',false);
                })
            });

            $("#accountsselect").click(function(){
                $(".accountsclass").each(function(){
                  $(this).prop('checked',true);
                })
            });
            $("#accountsunselect").click(function(){
                $(".accountsclass").each(function(){
                  $(this).prop('checked',false);
                })
            });


            $("#settingsselect").click(function(){
                $(".settingsclass").each(function(){
                  $(this).prop('checked',true);
                })
            });
            $("#settingsunselect").click(function(){
                $(".settingsclass").each(function(){
                  $(this).prop('checked',false);
                })
            });
            $("#marketingselect").click(function(){
                $(".marketingclass").each(function(){
                  $(this).prop('checked',true);
                })
            });
            $("#marketingunselect").click(function(){
                $(".marketingclass").each(function(){
                  $(this).prop('checked',false);
                })
            });
        });
    </script>

@endpush
