@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <form class="floating-labels m-t-40" action="{{route('dealer.update')}}" method="POST">
            @csrf

            <div class="content px-4 ">
                <div class="container">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Edit Dealer</h4>
                        <hr width="33%">
                    </div>
                    <input type="hidden" name="id" value="{{ $vendorData->id }}">
                    <div class="row pt-4">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dealer Title :</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="d_s_name" value="{{ $vendorData->d_s_name }}"
                                        class="form-control" placeholder="Vandor Title">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Proprietor Name:</label>
                                <div class="col-sm-9">
                                    <input type="Text" value="{{ $vendorData->d_proprietor_name }}"
                                        name="d_proprietor_name" class="form-control" placeholder="Proprietor Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dealer Type : </label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="dlr_type_id" required>
                                        <option value="">Select Dealer Type</option>
                                        @foreach ($dealertype as $dtype)
                                            <option value="{{ $dtype->id }}" @if ($vendorData->dlr_type_id == $dtype->id)
                                                selected
                                        @endif>{{ $dtype->type_title }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dealer OP Month : </label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="dlr_op_month">
                                        <option value="">Select Month</option>
                                        <option value="January" @if ($vendorData->dlr_op_month == 'January') selected  @endif>January</option>
                                        <option value="January" @if ($vendorData->dlr_op_month == 'February') selected  @endif>February</option>
                                        <option value="January" @if ($vendorData->dlr_op_month == 'March') selected  @endif>March</option>
                                        <option value="January" @if ($vendorData->dlr_op_month == 'April') selected  @endif>April</option>
                                        <option value="January" @if ($vendorData->dlr_op_month == 'May') selected  @endif>May</option>
                                        <option value="January" @if ($vendorData->dlr_op_month == 'June') selected  @endif>June</option>
                                        <option value="January" @if ($vendorData->dlr_op_month == 'July') selected  @endif>July</option>
                                        <option value="January" @if ($vendorData->dlr_op_month == 'August') selected  @endif>August</option>
                                        <option value="January" @if ($vendorData->dlr_op_month == 'September') selected  @endif>September</option>
                                        <option value="January" @if ($vendorData->dlr_op_month == 'October') selected  @endif>October</option>
                                        <option value="January" @if ($vendorData->dlr_op_month == 'November') selected  @endif>November </option>
                                        <option value="January" @if ($vendorData->dlr_op_month == 'November') selected  @endif>November</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dealer Area : </label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="dlr_area_id">
                                        <option value="">Select Dealer Area</option>
                                        @foreach ($dealerarea as $darea)
                                            <option value="{{ $darea->id }}" @if ($vendorData->dlr_area_id == $darea->id)
                                                selected
                                        @endif>{{ $darea->area_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dealer Region : </label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="dlr_subzone_id">
                                        <option value="">Select Dealer Region</option>
                                        @foreach ($dealersubzone as $dzone)
                                            <option value="{{ $dzone->id }}" @if ($vendorData->dlr_subzone_id == $dzone->id)
                                                selected
                                        @endif>{{ $dzone->subzone_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dealer Zone : </label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;"
                                        name="dlr_zone_id">
                                        <option value="">Select Dealer zone</option>
                                        @foreach ($dealerzone as $dzone)
                                            <option value="{{ $dzone->id }}" @if ($vendorData->dlr_zone_id == $dzone->id)
                                                selected
                                        @endif>{{ $dzone->zone_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Monthly Terget (Amount): </label>
                                <div class="col-sm-9">
                                    <input type="number" min="0"  step="any" value="{{ $vendorData->monthly_target }}"
                                        class="form-control" id="monthly_target" name="monthly_target" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Address:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="4" id="input7"
                                        name="dlr_address">{{ $vendorData->dlr_address }}</textarea>
                                    <span class="bar"></span>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dealer Email :</label>
                                <div class="col-sm-9">
                                    <input type="mail" class="form-control" value="{{ $vendorData->dlr_mail }}"
                                        id="dmail" name="dlr_mail">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Dealer Code:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="dcode"
                                        value="{{ $vendorData->dlr_code }}" name="dlr_code">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dealer OP Date : </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="totoals"
                                        value="{{ $vendorData->dlr_op_date }}" name="dlr_op_date">
                                </div>
                            </div>
                          <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dealer Closing Date : </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="totoals"
                                        value="{{ $vendorData->dlr_cl_date }}" name="dlr_cl_date">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Credit Limit:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="pstation"
                                        value="{{ $vendorData->dlr_police_station }}" name="dlr_police_station">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Dealer Mobile:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $vendorData->dlr_mobile_no }}"
                                        id="dmobile" name="dlr_mobile_no">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Opening Balance:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="dbase"
                                        value="{{ $vendorData->dlr_base }}" name="dlr_base">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Set Commission:</label>
                                <div class="col-sm-9">
                                    <input type="number" min="0" value="{{ $vendorData->dlr_commission }}"
                                        class="form-control" id="dlr_commission" name="dlr_commission">
                                </div>
                            </div>

                           <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Extra Creadit Limit:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="extra_credit_limit"
                                        value="{{ $vendorData->extra_credit_limit }}" name="extra_credit_limit">
                                </div>
                            </div>
                          {{--  <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Select Daterange: <span id="today" style="color: lime; display:inline-block">Today</span></label>
                                <div class="col-sm-9">
                                   <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date"  class="form-control float-right" value="{{ $vendorData->cl_fdate }} - {{ $vendorData->cl_tdate }}" id="daterangepicker">

                                    </div>
                                </div>
                            </div> --}}


                      {{-- Set fixed commission --}}
							<div id="fieldCom" class="col-md-12">
                              @php $n = 0; $n = count($fixedCom); @endphp
                              @if(($n > 0))
                               @foreach($fixedCom as $data)
                            	 <div class="row fieldGroupCom rowname">
                                   <div class="col-md-5">
                                                <label for="">Category Name:</label>
                                                <select class="form-control select2" data-show-subtext="true"
                                                    data-live-search="true" name="category_id[]" >
                                                    <option value=""> --Select Category-- </option>
                                                    @foreach ($category as $val)
                                                        <option value="{{ $val->id }}" @if($data->category_id == $val->id) selected  @else  @endif>{{ $val->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <label for=""> Commission :</label>
                                                <input type="text" class="form-control" name="commission[]" value="{{$data->commission}}">
                                            </div>
                                  		<div class="col-md-2">
                                                <label for="">Action :</label>
                                                <a href="javascript:void(0)" style="margin-top: 3px;"
                                                    class="btn custom-btn-sbms-add btn-sm addMoreCom"><i
                                                        class="fas fa-plus-circle"></i></a>
                                                 <a href="javascript:void(0)"
                                                    class="btn btn-sm custom-btn-sbms-remove removeCom"
                                                    style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>
                                                <a href="" class=""></a>
                                            </div>
                              	 </div>
                               @endforeach

                              @else
                              <div class="row fieldGroupCom rowname">
                                   <div class="col-md-5">
                                                <label for="">Category Name:</label>
                                                <select class="form-control select2" data-show-subtext="true"
                                                    data-live-search="true" name="category_id[]" >
                                                    <option value=""> --Select Category-- </option>
                                                    @foreach ($category as $val)
                                                        <option value="{{ $val->id }}">{{ $val->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <label for=""> Commission :</label>
                                                <input type="text" class="form-control" name="commission[]">
                                            </div>
                                  		<div class="col-md-2">
                                                <label for="">Action :</label>
                                                <a href="javascript:void(0)" style="margin-top: 3px;"
                                                    class="btn custom-btn-sbms-add btn-sm addMoreCom"><i
                                                        class="fas fa-plus-circle"></i></a>
                                                 <a href="javascript:void(0)"
                                                    class="btn btn-sm custom-btn-sbms-remove removeCom"
                                                    style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>
                                                <a href="" class=""></a>
                                            </div>
                              	 </div>
                              @endif
                              </div>
                      </div>
                    </div>
                </div>
                {{-- Multiple add button code start from here! --}}
                <div class="row mt-5">
                    <div id="field" class="col-md-12">

                        @foreach ($trscost as $item)

                        <div class="row fieldGroup rowname">
                            <div class="col-md-12 ">
                                <div class="row">
                                    <div class="col-md-12 ml-auto">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Wirehouse Name:</label>
                                                <select class="form-control select2" data-show-subtext="true"
                                                    data-live-search="true" name="warehouse[]" required>
                                                    <option value="">--Select Warehouse--</option>
                                                    @foreach ($factory as $fact)
                                                        <option value="{{ $fact->id }}" @if($item->warehouse_id == $fact->id) selected @endif>{{ $fact->factory_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for=""> Trasnsport Cost per Bag :</label>
                                                <input type="text" class="form-control" value="{{$item->transport_cost}}" name="trasport_cost[]">
                                            </div>
                                           <div class="col-md-2">
                                                <label for=""> Commission Per Ton :</label>
                                               <input type="text" class="form-control" name="commission_per_ton[]" value="{{$item->commission_per_ton}}" >
                                            </div>
                                           <div class="col-md-2">
                                                <label for=""> Commission Per Bag :</label>
                                                <input type="text" class="form-control" name="commission_per_bag[]" value="{{$item->commission_per_bag}}" >
                                            </div>
                                            <div class="col-md-1">
                                                <label for="">Action :</label></br>
                                                <a href="javascript:void(0)" style="margin-top: 3px;"
                                                    class="btn custom-btn-sbms-add btn-sm addMore"><i
                                                        class="fas fa-plus-circle"></i></a>
                                                 <a href="javascript:void(0)"
                                                    class="btn btn-sm custom-btn-sbms-remove remove"
                                                    style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>
                                                <a href="" class=""></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>
                        </div>

                        @endforeach

                    </div>
                </div>

                <div class="row pb-5">
                    <div class="col-md-6 mt-3">
                        <div class="text-right">
                            <button type="submit" class="btn custom-btn-sbms-submit"> Update </button>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">

                    </div>
                </div>


                <!-- /.container-fluid -->
            </div>

        </form>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script>
        $(document).ready(function() {

            $("#daterangepicker").change(function() {
                var a = document.getElementById("today");
               a.style.display = "none";
            });

          $("#fieldCom").on("click", ".addMoreCom", function() {
                var fieldHTML =
                    '<div class="row fieldGroupCom rowname mt-2"> <div class="col-md-5">  <select class="form-control select2" data-show-subtext="true" data-live-search="true" name="category_id[]" > <option value="">--Select Category--</option> @foreach ($category as $val) <option value="{{ $val->id }}">{{ $val->category_name }} </option> @endforeach </select> </div> <div class="col-md-5"><input type="text" class="form-control" name="commission[]"> </div> <div class="col-md-2"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMoreCom"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove removeCom" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> <a href="" class=""></a> </div> </div>';
                $(this).parents('.fieldGroupCom:last').after(fieldHTML);

                $('.select2').select2({
            theme: 'bootstrap4'
            })

            });
            //remove fields group
            $("#fieldCom").on("click", ".removeCom", function() {
                $(this).parents(".fieldGroupCom").remove();
            });


            //add more fields group
            $("body").on("click", ".addMore", function() {
                var fieldHTML =
                    '<div class="row fieldGroup rowname mt-2"> <div class="col-md-12 "> <div class="row"> <div class="col-md-12 ml-auto"> <div class="row"> <div class="col-md-4"> <select class="form-control select2" data-show-subtext="true" data-live-search="true" name="warehouse[]" required> <option value="">--Select Warehouse--</option> @foreach ($factory as $fact) <option value="{{$fact->id}}">{{$fact->factory_name}}</option> @endforeach </select> </div><div class="col-md-3"> <input type="text" class="form-control" name="trasport_cost[]"> </div><div class="col-md-2"> <input type="text" class="form-control" name="commission_per_ton[]"> </div><div class="col-md-2"> <input type="text" class="form-control" name="commission_per_bag[]"> </div><div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> <a href="" class=""></a> </div></div></div><div class="col-md-2"></div></div></div></div>';
                                     $(this).parents('.fieldGroup:last').after(fieldHTML);
                    $('.select2').select2({
                        theme: 'bootstrap4'
                        })

            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
            });
        });

    </script>
@endsection
