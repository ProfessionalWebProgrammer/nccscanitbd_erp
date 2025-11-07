@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
				<div class="row py-2">
                  <div class="col-md-6 text-left">
						 <a href="{{route('purchase.ledger.index')}}" class="btn btn-sm btn-success mt-1" id="btnExport"> Purchase Ledger</a>
						 {{-- <a href="{{route('purchase.stock.ledger.index')}}" class="btn btn-sm btn-info mt-1" id="btnExport"> R. M Stock Ledger  </a>
						 <a href="{{route('purchase.bag.stock.ledger.index')}}" class="btn btn-sm btn-primary mt-1" id="btnExport"> PP Bag Stock Ledger  </a> --}}
                  </div>
                  <div class="col-md-6 text-right">
                  </div>
              </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Purchase Ledger Input</h3>
                    <hr>
                </div>
                <div id="exTab2" class="container">
                  <ul class="nav nav-tabs mt-4">
                  <li class="active">
                  <a  href="#normal" class="btn btn-sm btn-primary" data-toggle="tab">Finish Goods </a>
                  </li>
                  <li>
                    <a href="#weighted" class="btn btn-sm btn-success" data-toggle="tab">Raw Materials</a>
                  </li>

                </ul>

                  <div class="tab-content ">
                    <div class="tab-pane active mt-5" id="normal">
                      <div class="form">
                          <form class="floating-labels" action="{{ Route('purchase.ledger.view') }}" method="POST">
                              @csrf
                              <input type="hidden" name="type" value="1">
                              <div class="row">
                                  <div class="col-md-4">
                                      <h5 style="font-weight: 800;">Select Daterange: <span id="today" style="color: lime; display:inline-block">Today</span></h5>
                                      <div class="form-group m-b-40">
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                  <span class="input-group-text">
                                                      <i class="far fa-calendar-alt"></i>
                                                  </span>
                                              </div>
                                              <input type="text" name="date" value=""
                                                  class="form-control float-right" id="daterangepicker">

                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <h5 style="font-weight: 800;">Select Supplier Group</h5>
                                      <div class="form-group m-b-40">
                                          <select class="form-control selectpicker border border-secondary" data-show-subtext="true"
                                          data-live-search="true" data-actions-box="true" multiple
                                              name="supplier_group_id[]">

                                              <option value="">Select Supplier Group</option>
                                              @foreach ($suppliergroups as $data)
                                                  <option style="color: #FF0000; font-weight:bold" value="{{ $data->id }}">
                                                      {{ $data->group_name }}
                                                  </option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <h5 style="font-weight: 800;">Select Supplier </h5>
                                      <div class="form-group m-b-40">
                                          <select class="form-control selectpicker border border-secondary" data-show-subtext="true"
                                          data-live-search="true" data-actions-box="true" multiple
                                              name="supplier_id[]"  >
                                                @foreach ($suppliers as $data)
                                                  <option style="color: #FF0000; font-weight:bold" value="{{ $data->id }}">
                                                      {{ $data->supplier_name }}
                                                  </option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
                              </div>
                              <div class="class row">
                                  <div class="class col-md-4"></div>
                                  <div class="class col-md-4 px-5">
                                      <button type="submit" class="btn btn-primary" style="width: 100%;">Generate List</button>
                                  </div>
                                  <div class="class col-md-4">
                                  </div>
                              </div>
                          </form>
                    </div>
                    </div>
                    <div class="tab-pane mt-5" id="weighted">
                      <div class="form">
                          <form class="floating-labels" action="{{ Route('purchase.ledger.view') }}" method="POST">
                              @csrf
                              <input type="hidden" name="type" value="2">
                              
                              <div class="row mb-5">
                                  <div class="col-md-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_date" name="report_view_field_date" value="1">
                                            <label class="form-check-label" for="report_view_field_date">Date</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_invoice" name="report_view_field_invoice" value="1">
                                            <label class="form-check-label" for="report_view_field_invoice">Invoice</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_warehouse_bank" name="report_view_field_warehouse_bank" value="1">
                                            <label class="form-check-label" for="report_view_field_warehouse_bank">Warehouse/Bank</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_vehicle" name="report_view_field_vehicle" value="1">
                                            <label class="form-check-label" for="report_view_field_vehicle">Vehicle</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_product" name="report_view_field_product" value="1">
                                            <label class="form-check-label" for="report_view_field_product">Product</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_chalan_qty" name="report_view_field_chalan_qty" value="1">
                                            <label class="form-check-label" for="report_view_field_chalan_qty">Chalan Qty</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_order_qty" name="report_view_field_order_qty" value="1">
                                            <label class="form-check-label" for="report_view_field_order_qty">Order Qty</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_receive_qty" name="report_view_field_receive_qty" value="1">
                                            <label class="form-check-label" for="report_view_field_receive_qty">Receive Qty</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_ded_qty" name="report_view_field_ded_qty" value="1">
                                            <label class="form-check-label" for="report_view_field_ded_qty">Ded Qty</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_bill_qty" name="report_view_field_bill_qty" value="1">
                                            <label class="form-check-label" for="report_view_field_bill_qty">Bill Qty</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_rate" name="report_view_field_rate" value="1">
                                            <label class="form-check-label" for="report_view_field_rate">Rate</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_purchase_value" name="report_view_field_purchase_value" value="1">
                                            <label class="form-check-label" for="report_view_field_purchase_value">Purchase Value</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_tp_fare" name="report_view_field_tp_fare" value="1">
                                            <label class="form-check-label" for="report_view_field_tp_fare">TP Fare</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_debit" name="report_view_field_debit" value="1">
                                            <label class="form-check-label" for="report_view_field_debit">Debit</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_credit" name="report_view_field_credit" value="1">
                                            <label class="form-check-label" for="report_view_field_credit">Credit</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_balance_bdt" name="report_view_field_balance_bdt" value="1">
                                            <label class="form-check-label" for="report_view_field_balance_bdt">Balance BDT</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="report_view_field_total_ton" name="report_view_field_total_ton" value="1">
                                            <label class="form-check-label" for="report_view_field_total_ton">Total Ton</label>
                                        </div>
                                  </div>
                              </div>
                              <div class="row" >
                                  <div class="col-md-4">
                                      <h5 style="font-weight: 800;">Select Daterange: <span id="today" style="color: lime; display:inline-block">Today</span></h5>
                                      <div class="form-group m-b-40">
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                  <span class="input-group-text">
                                                      <i class="far fa-calendar-alt"></i>
                                                  </span>
                                              </div>
                                              <input type="text" name="date" value=""
                                                  class="form-control float-right" id="daterangepicker2">

                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <h5 style="font-weight: 800;">Select Supplier Group</h5>
                                      <div class="form-group m-b-40">
                                          <select class="form-control selectpicker border border-secondary" data-show-subtext="true"
                                          data-live-search="true" data-actions-box="true" multiple
                                              name="supplier_group_id[]">

                                              <option value="">Select Supplier Group</option>
                                              @foreach ($suppliergroups as $data)
                                                  <option style="color: #FF0000; font-weight:bold" value="{{ $data->id }}">
                                                      {{ $data->group_name }}
                                                  </option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <h5 style="font-weight: 800;">Select Supplier </h5>
                                      <div class="form-group m-b-40">
                                          <select class="form-control selectpicker border border-secondary" data-show-subtext="true"
                                          data-live-search="true" data-actions-box="true" multiple
                                              name="supplier_id[]"  >
                                                @foreach ($suppliers as $data)
                                                  <option style="color: #FF0000; font-weight:bold" value="{{ $data->id }}">
                                                      {{ $data->supplier_name }}
                                                  </option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
                              </div>
                              <div class="class row">
                                  <div class="class col-md-4"></div>
                                  <div class="class col-md-4 px-5">
                                      <button type="submit" class="btn btn-success" style="width: 100%;">Generate List</button>
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
            </div>



        </div>
    </div>
    </div>

@endsection

@push('end_js')

    <script>
        $(document).ready(function() {

          $('#daterangepicker2').daterangepicker({
           timePicker: false,

               locale: {
                   format: 'Y-MM-DD'
               }
           });

            $("#daterangepicker").change(function() {
                var a = document.getElementById("today");
               a.style.display = "none";
            });

            $("#daterangepicker2").change(function() {
                var a = document.getElementById("today2");
               a.style.display = "none";
            });

        });
    </script>

@endpush
