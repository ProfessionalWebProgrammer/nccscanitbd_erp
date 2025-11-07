@extends('layouts.purchase_deshboard')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper posclass" >
        <!-- Main content -->
        <div class="content px-4 ">
          <div class="container-fluid" style="background: #ffffff;  min-height: 85vh;">
            <form action="{{route('sales.store')}}" method="post">
                @csrf
                <div class="pt-4 text-center">
                    <h4 class="font-weight-bolder text-uppercase">RFQ Order</h4>
                    <hr width="33%">
                </div>
                    <div class="row pt-4">
                      <div class="col-md-3">
                          <div class="form-group row">
                              <label class=" col-form-label col-md-4">Issue Date:</label>
                              <input type="date" name="issue_date" value="{{ date('Y-m-d') }}"
                                  class="form-control col-md-8">
                          </div>
                      </div>
                      <div class="col-md-3 ">
                        <div class="form-group row">
                          <label class=" col-form-label col-md-4">Supplier Name:</label>
                          <!-- <input type="text" name="name" class="form-control col-md-8"  > -->
                           <select name="supplier_id" class="form-control select2 col-md-8 "  id="supplier">
                              <option value="">== Select Supplier ==</option>
                              @foreach ($suppliers as $item)
                                  <option value="{{ $item->id }}">
                                      {{ $item->supplier_name }}
                                  </option>
                              @endforeach
                          </select>

                        </div>
                      </div>
                      <div class="col-md-3">
                            <div class="form-group row">
                                <label class=" col-form-label col-md-5 pl-1">Response Date:</label>
                                <input type="date" name="response_date" value="{{ date('Y-m-d') }}"
                                    class="form-control col-md-7">
                            </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group row">
                              <label class=" col-form-label col-md-4 pl-3"> Contact Name:</label>
                              <input type="text" name="contact_person" class="form-control col-md-8 contact_person"  value=""  readonly>
                          </div>
                        </div>
                        <div class="col-md-3">
                              <div class="form-group row">
                                <label class=" col-form-label col-md-4">Designation:</label>
                                <input type="text" name="designation" class="form-control col-md-8 designation"  value=""  readonly>
                              </div>
                        </div>
                        <div class="col-md-3">
                              <div class="form-group row">
                                <label class=" col-form-label col-md-4">Phone:</label>
                                <input type="text" name="phone" class="form-control col-md-8 phone" value=""  readonly >
                              </div>
                        </div>
                        <div class="col-md-3">
                              <div class="form-group row">
                                <label class=" col-form-label col-md-5">Email:</label>
                                <input type="email" name="email" class="form-control col-md-7 email" value=""  readonly >
                              </div>
                        </div>
                        <div class="col-md-3">
                              <div class="form-group row">
                                <label class=" col-form-label col-md-4">Address:</label>
                                <input type="text" name="address" class="form-control col-md-8 address"  value=""  readonly>
                              </div>
                        </div>
                    </div>



                    {{-- Multiple add button code start from here! --}}
                    <div class="row mt-5">
                        <div id="field" class="col-md-12">
                            <div class="row fieldGroup rowname">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="row">

                                                <div class="col-md-3">
                                                      <label class=" col-form-label">Product Name:</label>
                                                      <select name="item[]" class="form-control select2 orderProduct" required>
                                                          <option value="">== Select Product ==</option>
                                                                  @foreach ($products as $item)
                                                                      <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                                                  @endforeach
                                                      </select>


                                                </div>

                                                <div class="col-md-3">
                                                  <label class=" col-form-label"> Specification:</label>
                                                  <input type="text"  name="specification[]" class="form-control" placeholder="Product Specification">
                                                </div>
                                                <div class="col-md-2">
                                                  <label class=" col-form-label"> UOM (Kg):</label>
                                                  <input type="text" name="unit[]"  class="form-control orderUnit"  readonly>
                                                </div>
                                                <div class="col-md-2">
                                                  <label class=" col-form-label"> Quantity:</label>
                                                  <input type="text"  name="qty[]" required class="form-control qty" placeholder="Required Quantity">
                                                </div>
                                                <div class="col-md-2">
                                                  <label class=" col-form-label"> PR No:</label>
                                                  <select name="pr_no" class="form-control select2 orderPo" required >
                                                      <option value=""> Select Purchase Requisition </option>
                                                              @foreach ($purchaseRequisitions as $item)
                                                                  <option value="{{ $item->invoice }}">{{ $item->invoice }}</option>
                                                              @endforeach
                                                  </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label for="">Action :</label> <br>
                                            <a href="javascript:void(0)" style="margin-top: 3px;"
                                                class="btn custom-btn-sbms-add btn-light btn-sm addMore"><i
                                                    class="fas fa-plus-circle"></i></a>
                                            <a href="javascript:void(0)"  class="btn btn-danger btn-sm custom-btn-sbms-remove remove"
                                                style="margin-top: 3px;"><i class="fas  fa-minus-circle"></i></a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- multiple add end on here --}}

                    <div class="row mt-4 pb-5">
                        <div class="col-md-2  m-auto mt-3">
                            <button type="submit" class="btn custom-btn-sbms-submit w-100"> Submit </button>
                        </div>

                    </div>

                <!-- /.container-fluid -->
            </form>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>

@endsection


@push('end_js')


<script>
    $(document).ready(function() {
      $("body").on("click", ".addMore", function() {
          var fieldHTML =
              '<div class="row fieldGroup rowname mt-3"> <div class="col-md-12"> <div class="row"> <div class="col-md-11"> <div class="row"> <div class="col-md-3"> <select name="item[]" class="form-control select2 orderProduct" required> <option value="">== Select Product ==</option> @foreach ($products as $item) <option value="{{ $item->id }}">{{ $item->product_name }}</option> @endforeach </select> </div> <div class="col-md-3"> <input type="text" name="specification[]" class="form-control" placeholder="Product Specification"> </div> <div class="col-md-2"> <input type="text" name="unit[]" class="form-control orderUnit" readonly> </div> <div class="col-md-2"> <input type="text" name="qty[]" required class="form-control qty" placeholder="Required Quantity"> </div> <div class="col-md-2"> <select name="pr_no" class="form-control select2 orderPo" required > <option value=""> Select Purchase Requisition </option> @foreach ($purchaseRequisitions as $item) <option value="{{ $item->invoice }}">{{ $item->invoice }}</option> @endforeach </select> </div> </div> </div> <div class="col-md-1"> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-light btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-danger btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> </div> </div> </div> </div>';
              $(this).parents('.fieldGroup:last').after(fieldHTML);
      });
      //remove fields group
      $("body").on("click", ".remove", function() {
          $(this).parents(".fieldGroup").remove();
        //total();
      });

      $('#field').on('change','.orderProduct', function() {
     var parent = $(this).closest('.fieldGroup');
     var id = parent.find('.orderProduct').val();
     //var url = '{{ url('/settings/get/category/') }}/' + id;
   //  alert(id);
     $.ajax({
                 url: '{{ url('/get/unit/') }}/' + id,
                 type: "GET",
                 dataType: 'json',
                 success: function(data) {
                     $(data).each(function() {
                       console.log(data);
                       /*parent.find('.orderCategoryId').val(data.cat_id);
                       parent.find('.orderCategory').val(data.cat); */
                       parent.find('.orderUnit').val(data.unit);
                     });
                 }
             });

         });

         $('#supplier').on('change',function() {
           //alert('Supplier');
           var id = $('#supplier').val();
           $.ajax({
                       url: '{{ url('/get/supplier/') }}/' + id,
                       type: "GET",
                       dataType: 'json',
                       success: function(data) {
                         //console.log(data.name);
                         $('.contact_person').val(data.name);
                         $('.designation').val(data.desination);
                         $('.email').val(data.email);
                         $('.phone').val(data.phone);
                         $('.address').val(data.address);
                         /*
                           $(data).each(function() {
                             //console.log(data);
                             parent.find('.orderCategoryId').val(data.cat_id);
                             parent.find('.orderCategory').val(data.cat);
                             parent.find('.orderUnit').val(data.unit);

                           });*/
                       }
                   });
         });

});

</script>



@endpush
