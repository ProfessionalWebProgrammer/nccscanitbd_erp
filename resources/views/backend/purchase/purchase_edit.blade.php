@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">

            <form class="floating-labels m-t-40" action="{{ Route('purchase.update') }}" method="POST">
                @csrf

                <div class="container-fluid" style="min-width: 80% !important;">
                    <div class="text-center py-4">
                        <h3 class="text-uppercase font-weight-bold">Purchase Edit </h3>
                    </div>
                    <div class="row">

                      <input type="hidden" name="invoice" value="{{ $purchasedata->invoice }}">
                        <input type="hidden" name="purchase_id"  value="{{ $purchasedata->purchase_id }}">


                        <div class="col-md-4">
                            <label class="col-form-label text-right">Date :</label>
                            <input type="date" id="data" name="date" value="{{ $purchasedata->date }}"
                                class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label text-right">Reference :</label>
                            <input type="Text" class="form-control" value="{{ $purchasedata->reference }}"
                                name="reference" placeholder="Reference">
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label text-right">Transport Vehicle: </label>
                            <input type="Text" id="vehicle" name="transport_vehicle"
                                value="{{ $purchasedata->transport_vehicle }}" class="form-control"
                                placeholder="Transport Vehicle">

                        </div>
                      <div class="col-md-2">
                            <label for="po_id" class="col-form-label text-right">PO No :</label>

                            <select class="form-control select2" name="po_no" id="po_id">
                                <option value="">Select PO No</option>
                                @foreach ($poDatas as $data)
                                    <option @if ($purchasedata->order_no == $data->order_no) selected @endif style="color:#000;font-weight:600;" value="{{ $data->order_no }}">
                                        {{ $data->order_no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label text-right" style="padding-top: 10px;"> Supplier Name</label>
                            <select class="form-control select2" name="raw_supplier_id" id="supplier_id" >
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option style="color:#000;font-weight:600;" value="{{ $supplier->id }}"
                                        @if ($purchasedata->raw_supplier_id == $supplier->id) selected @endif>
                                        {{ $supplier->supplier_name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-3">
                            <label style="padding-top: 10px;"> Warehouse Name:</label>
                            <select class="form-control select2" name="wirehouse_id" id="wirehouse" >
                                <option value="">Select Warehouse</option>
                                @foreach ($factoryes as $factorye)
                                    <option style="color:#000;font-weight:600;" value="{{ $factorye->id }}"
                                        @if ($purchasedata->wirehouse_id == $factorye->id) selected @endif>
                                        {{ $factorye->factory_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label style="padding-top: 10px;">Product Name<span id="pstock"
                                    style="color: red"></span></label>
                            <select class="form-control select2" name="rm_product_id" id="product_id" >
                                <option value="">Select Product</option>
                                @foreach ($rm_products as $rm_products)
                                    <option style="color:#000;font-weight:600;" value="{{ $rm_products->id }}"
                                        @if ($purchasedata->product_id == $rm_products->id) selected @endif>
                                        {{ $rm_products->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3" style="font-size: 14px;">
                        <div class="col-md-2">
                            <div class="form-group row">
                                <label class="col-form-label ">Supplier Chalan:</label>
                                <input type="number" step="any" class="form-control"
                                    value="{{ $purchasedata->supplier_chalan_qty }}" id="supplier_chalan_qty"
                                    name="supplier_chalan_qty" placeholder="Supplier Chalan">
                                {{-- <div class="col-md-5">
                                <br>
                                <select name="" class="form-control " id="" required="">
                                    <option value="kg">KG</option>


                                </select>
                            </div> --}}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label ">Recevie Quantity:</label>
                                <input type="number" step="any" class="form-control"
                                    value="{{ $purchasedata->receive_quantity }}" id="receive_quantity"
                                    name="receive_quantity" placeholder="Recevie Quantity">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label ">Chot Qty:</label>
                                <input type="number" step="any" class="form-control"
                                    value="{{ $purchasedata->chot_qty }}" id="chot_qty" name="chot_qty"
                                    placeholder="Chot Qty">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label ">Plastic Qty:</label>
                                <input type="number" step="any" class="form-control"
                                    value="{{ $purchasedata->plastic_qty }}" id="plastic_qty" name="plastic_qty"
                                    placeholder="Plastic Qty">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label ">Chot Waight:</label>
                                <input type="number" step="any" class="form-control"
                                    value="{{ $purchasedata->chot_waight }}" id="chot_waight" name="chot_waight"
                                    placeholder="Chot Waight">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label ">Sack Deduction For W.H:</label>
                                <input type="number" step="any" class="form-control"
                                    value="{{ $purchasedata->weight_quantity }}" id="weight_quantity"
                                    name="weight_quantity" placeholder="Sack Deduction For W.H">
                            </div>
                        </div>
                    </div>
                    <div class="p-2 rounded" style="background-color: #013f42">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label ">Chot Waight w:</label>
                                    <input type="number" step="any" class="form-control"
                                        value="{{ $purchasedata->chot_waight_w }}" id="chot_waight_w" name="chot_waight_w"
                                        placeholder="SChot Waight w">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label ">Plastic Waight w:</label>
                                    <input type="number" step="any" class="form-control"
                                        value="{{ $purchasedata->plastic_waight_w }}" id="plastic_waight_w"
                                        name="plastic_waight_w" placeholder="Plastic Waight w">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label ">Sack Deduction:</label>
                                    <input type="number" step="any" class="form-control"
                                        value="{{ $purchasedata->sack_purchase }}" id="sack_purchase" name="sack_purchase"
                                        placeholder="Sack Deduction">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label ">Moisture Percentage:</label>
                                    <input type="number" step="any" class="form-control"
                                        value="{{ $purchasedata->moisture }}" id="moisture" name="moisture"
                                        placeholder="Percentage">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label ">Deduction Qty:</label>
                                    <input type="number" step="any" class="form-control"
                                        value="{{ $purchasedata->deduction_quantity }}" id="deduction_quantity"
                                        name="deduction_quantity" placeholder="Moisture Deduction Qty">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label ">Bill Quantity:</label>
                                    <input type="number" step="any" class="form-control"
                                        value="{{ $purchasedata->bill_quantity }}" id="bill_quantity" name="bill_quantity"
                                        placeholder="Bill Quantity">
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-2"></div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label ">Purchase Rate:</label>
                                    <input type="number" step="any" class="form-control"
                                        value="{{ $purchasedata->purchase_rate }}" id="purchase_rate" name="purchase_rate"
                                        placeholder="Purchase Rate">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label ">Purchase Value:</label>
                                    <input type="number" step="any" class="form-control"
                                        value="{{ $purchasedata->purchase_value }}" id="purchase_value"
                                        name="purchase_value" placeholder="Purchase Value">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label ">Transport Fare:</label>
                                    <input type="number" step="any" class="form-control "
                                        value="{{ $purchasedata->transport_fare }}" id="transport_fare"
                                        name="transport_fare" placeholder="Transport Fare">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label ">Net Payable Amount:</label>
                                    <input type="number" step="any" class="form-control"
                                        value="{{ $purchasedata->total_payable_amount }}" id="total_payable_amount"
                                        name="total_payable_amount" placeholder="Net Payable Amount">
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                    <div class="row pb-5 pt-3">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success">Purchase</button>
                            <a class="btn btn-danger">Back</a>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </form>
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
                var fieldHTML =
                    '<div class="row fieldGroup rowname mt-2"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-2"> <select name="" class="form-control" id=""> <option value="">==Select One==</option> <option value="">BG</option> <option value="">BS</option> <option value="">SS</option> <option value="">BR</option> </select> </div><div class="col-md-2"> <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Price"> </div><div class="col-md-2"> <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Quantity"> </div><div class="col-md-2"> <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Discount"> </div><div class="col-md-2"> <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Free / Bonus"> </div><div class="col-md-2"> <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="total"> </div></div></div><div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> <a href="" class=""></a> </div><div class="col-md-2"></div></div></div></div>';
                $(this).parents('.fieldGroup:last').after(fieldHTML);
            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
            });




        });



        $(document).ready(function() {




            $("input").change(function() {

                calculation();

                sackdetuctionWVal();


            });


            function calculation() {

                var rqty = 0;
                var cq = 0;
                var sack = 0;
                $("input[name=sack_purchase]").each(function() {
                    sack = sack + parseInt($(this).val());
                })
                //var sack = document.form1.sack_purchase.value ;

                var chotqty = $('#chot_qty').val();
                var chotwaight = $('#chot_waight_w').val();

                var plasticqty = $('#plastic_qty').val();
                var plasticwaight = $('#plastic_waight_w').val();

                var sdfw1 = chotwaight * chotqty;
                var sdfw2 = plasticqty * plasticwaight;

                var murs = $('#moisture').val();
                var rqty = parseFloat($('#receive_quantity').val());
                var cq = parseFloat($('#supplier_chalan_qty').val());

                if (rqty > cq) {
                    var totalmur = (cq * murs) / 100;
                } else {
                    var totalmur = (rqty * murs) / 100;
                }

                var dq = sdfw1 + sdfw2 + totalmur;


                if (rqty > cq) {
                    // console.log(rqty)
                    var bq = cq - dq;
                    // console.log('r besi')
                    // console.log(bq);
                }
                if (rqty <= cq) {
                    // console.log(cq)
                    var bq = rqty - dq;
                    // console.log('r kom');
                    // console.log(bq);
                }


                var pret = $('#purchase_rate').val();
                var pcost = bq * pret;
                console.log(pcost);
                var trns = $('#transport_fare').val();



                var mre = $('#mremain_quantity').val();


                var netbill = pcost - trns;




                $("#sack_purchase").val(sdfw1 + sdfw2);
                $("#deduction_quantity").val(dq);
                $("#bill_quantity").val(bq);
                $("#purchase_value").val(pcost);
                $("#total_payable_amount").val(netbill);
                // $("#order_quantity").val(cq);
                // $("#remain_quantity").val(mre-cq);






                // var mur = (document.form1.receive_quantity.value * document.form1.moisture.value) / 100



                // var result = mur + sack+dq;
                // var result = mur + sack+sdfw;
                // console.log(result);
                //  $("input[name=deduction_quantity]").val(result);
            }
        });

        function sackdetuctionWVal() {
            var chotwaight = $('#chot_waight').val();
            var chotqty = $('#chot_qty').val();
            var sdfw = chotwaight * chotqty;
            $("#weight_quantity").val(sdfw);
            // console.log(sdfw);
            // document.getElementById("weight_quantity").innerHTML = sdfw;


        }
    </script>

@endpush
