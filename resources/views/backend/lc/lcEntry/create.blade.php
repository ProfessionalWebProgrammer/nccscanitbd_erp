@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <!-- Main content -->
        <form class="floating-labels m-t-40" action="{{ Route('lcEntry.store') }}" method="POST">
            @csrf

            <div class="content px-4 ">
                <div class="container" style="background:#ffffff; padding:0px 40px;">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">LC Create</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                      <input type="hidden" name="user_id" value="{{$data['user_id']}}">
                      <input type="hidden" name="status" value="1">
                        <div class="col-md-6">
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Date : </label>
                              <div class="col-sm-9">
                                  <input type="date" class="form-control" name="date">
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">LC Group: </label>
                              <div class="col-sm-9">
                                  <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="lc_group_id">
                                      <option value="">Select LC Group</option>
                                      @foreach ($data['lcGroup'] as $val)
                                          <option value="{{ $val->id }}">{{ $val->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">LC Ledger: </label>
                              <div class="col-sm-9">
                                  <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="lc_ledger_id">
                                      <option value="">Select LC Group</option>
                                      @foreach ($data['lcLedger'] as $val)
                                          <option value="{{ $val->id }}">{{ $val->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Issues Bank : </label>
                              <div class="col-sm-9">
                                  <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="issues_bank_id">
                                      <option value="">Select Issues Bank</option>
                                      @foreach ($data['masterBank'] as $val)
                                          <option value="{{ $val->bank_id }}">{{ $val->bank_name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Confirming Bank : </label>
                              <div class="col-sm-9">
                                  <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="confirming_bank_id">
                                      <option value="">Select Confirming Bank</option>
                                      @foreach ($data['masterBank'] as $val)
                                          <option value="{{ $val->bank_id }}">{{ $val->bank_name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Agent Bank : </label>
                              <div class="col-sm-9">
                                  <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="agent_bank_id">
                                      <option value="">Select Agent Bank</option>
                                      @foreach ($data['agentBank'] as $val)
                                          <option value="{{ $val->id }}">{{ $val->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Item : </label>
                              <div class="col-sm-9">
                                  <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="item_id">
                                      <option value="">Select Item</option>
                                      @foreach ($data['rawItem'] as $val)
                                          <option value="{{ $val->id }}">{{ $val->product_name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">LC Quantity : </label>
                              <div class="col-sm-9">
                                  <input type="number" class="form-control lc_qty" name="lc_qty" placeholder="Lc Quantity">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label" >USD Rate : </label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control usd_rate" name="usd_rate">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label" >BDT Rate : </label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control bdt_rate" name="bdt_rate">
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">CNF Name : </label>
                              <div class="col-sm-9">
                                  <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="cnf_name_id">
                                      <option value="">Select CNF Name</option>
                                      @foreach ($data['cnfName'] as $val)
                                          <option value="{{ $val->id }}">{{ $val->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Port of Entry : </label>
                              <div class="col-sm-9">
                                  <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="port_of_entry_id">
                                      <option value="">Select Port of Entry</option>
                                      @foreach ($data['portOfEntry'] as $val)
                                          <option value="{{ $val->id }}">{{ $val->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Acceptance Date : </label>
                              <div class="col-sm-9">
                                  <input type="date" class="form-control" name="acceptance_date">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Payment Bank : </label>
                              <div class="col-sm-9">
                                  <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="payment_bank_id">
                                      <option value="">Select Payment Bank</option>
                                      @foreach ($data['masterBank'] as $val)
                                          <option value="{{ $val->bank_id }}">{{ $val->bank_name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Bank Charge : </label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" name="amount">
                              </div>
                          </div>
                          </div>
                          <!-- 1st 6-col-end -->

                        <div class="col-md-6">
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">LC Number :</label>
                              <div class="col-sm-9">
                                  <input type="text" name="lc_number" class="form-control" placeholder="LC Number">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Shipment Date : </label>
                              <div class="col-sm-9">
                                  <input type="date" class="form-control" name="shipment_date">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Beneficiary Bank : </label>
                              <div class="col-sm-9">
                                  <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="beneficiary_bank_id">
                                      <option value="">Select Beneficiary Bank</option>
                                      @foreach ($data['masterBank'] as $val)
                                          <option value="{{ $val->bank_id }}">{{ $val->bank_name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Discounting Bank : </label>
                              <div class="col-sm-9">
                                  <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="discounting_bank_id">
                                      <option value="">Select Discounting Bank</option>
                                      @foreach ($data['masterBank'] as $val)
                                          <option value="{{ $val->bank_id }}">{{ $val->bank_name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Exporter Name  : </label>
                              <div class="col-sm-9">
                                  <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="exporter_id">
                                      <option value="">Select Exporter Name</option>
                                      @foreach ($data['exporterLedger'] as $val)
                                          <option value="{{ $val->id }}">{{ $val->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">H S Code :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="hs_code" class="form-control" placeholder="H S Code">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Country :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="country" class="form-control" placeholder="Country">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Receive Quantity :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="receive_qty" class="form-control" placeholder="Receive Quantity">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">USD Value : </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control usd_value" name="usd_value" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">BDT Value : </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control bdt_value" name="bdt_value" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Mother Vessel : </label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="mother_vessel_id">
                                        <option value="">Select Mother Vessel</option>
                                        @foreach ($data['motherVessel'] as $val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Port of Discharge : </label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="port_of_discharge_id">
                                        <option value="">Select Port of Discharge</option>
                                        @foreach ($data['portOfDischarge'] as $val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Payment Date : </label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="payment_date">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Remarks :</label>
                                <div class="col-sm-9">
                                  <textarea name="remarks" rows="4" cols="45%"></textarea>

                                </div>
                            </div>

                          </div>
                          <!-- 2nd 6-col-end -->
                      </div>
                      <div class="row pb-5 mt-3">
                          <div class="col-md-6 ">

                          </div>
                          <div class="col-md-3  ">
                              <div class="text-left">
                                  <button type="submit" class="btn btn-primary custom-btn-sbms-submit"> Submit </button>
                              </div>
                          </div>
                          <div class="col-md-4">

                          </div>
                      </div>
                  </div>
              </div>
            </form>
        </div>
<!-- /.content-wrapper -->
<script>
    $(document).ready(function() {
      $('.usd_rate').on('input', function() {
           var qty = $('.lc_qty').val();
           var value = $('.usd_rate').val();
           var total = qty*value;
           $('.usd_value').val(total);
         });

      $('.bdt_rate').on('input', function() {
           var qty = $('.lc_qty').val();
           var value = $('.usd_rate').val();
           var valueBDT = $('.bdt_rate').val();
           var total = qty*value*valueBDT;
           $('.bdt_value').val(total);
         });
    });
    </script>
@endsection
