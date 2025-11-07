@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <form class="floating-labels m-t-40" action="{{Route('supplier.update')}}" method="POST">
            @csrf

        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="pt-3 text-center">
                    <h4 class="font-weight-bolder text-uppercase text-danger">Supplier Edit</h4>
                    <hr width="33%">
                </div>

                <div class="row pt-4">
                    <div class="col-md-8 m-auto">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary font-weight-bold" style="font-size: 18px;">Supplier Name :</label>
                            <div class="col-sm-9">
                                <input type="text" name="supplier_name" class="form-control" value="{{$supplier->supplier_name}}">
                                <input type="hidden" name="id" class="form-control" value="{{$supplier->id}}">
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary font-weight-bold" style="font-size: 18px;">Supplier Group Category : </label>
                            <div class="col-sm-9">
                                <select name="group_category" class="form-control" id="">
                                    <option value="">Seleter Group Category</option>

                                </select>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary font-weight-bold" style="font-size: 18px;">Group Name:</label>
                            <div class="col-sm-9">
                                <select name="group_id" class="form-control select2">
                                    <option value="">Select Group Name:</option>

                                    @foreach ($suppliergroups as $item)
                                    <option value="{{$item->id}}" @if($item->id == $supplier->group_id) selected @endif>{{$item->group_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary font-weight-bold" >Contact Person :</label>
                            <div class="col-sm-9">
                                <input type="text" name="contact_person" class="form-control" value="{{$supplier->contact_person ?? ''}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary font-weight-bold" >Designation :</label>
                            <div class="col-sm-9">
                                <input type="text" name="desination" class="form-control" value="{{$supplier->desination ?? ''}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary"> Phone : </label>
                            <div class="col-sm-9">
                                <input type="Text" name="phone" class="form-control" value="{{$supplier->phone}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary"> Address : </label>
                            <div class="col-sm-9">
                                <input type="Text" name="address" class="form-control" value="{{$supplier->address}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary"> Email : </label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" value="{{$supplier->email}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-primary" style="font-size: 18px;"> Opening Balance : </label>
                            <div class="col-sm-9">
                                <input type="Text" name="opening_balance" class="form-control" value="{{$supplier->opening_balance}}">
                            </div>
                        </div>


                    </div>
                </div>
              <div class="row pb-5">
                <div class="col-md-6 mt-3">
                    <div class="text-right">
                        <button type="submit" class="btn custom-btn-sbms-submit btn-primary"> Submit </button>
                    </div>
                </div>
                <div class="col-md-6 mt-3">

                </div>
            </div>
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
            //add more fields group
            $("body").on("click", ".addMore", function() {
                var fieldHTML =
                    '<div class="row fieldGroup rowname"> <div class="col-md-12 "> <div class="row"> <div class="col-md-12 ml-auto"> <div class="row"> <div class="col-md-4"> <label for="">Wirehouse Name:</label> <select name="" class="form-control" id=""> <option value="">==Select One==</option> <option value="">Saver, Dhaka</option> <option value="">Mirpur, Dhaka</option> <option value="">Gulsan Dhaka</option> <option value="">Rangpur</option> <option value="">Pabna</option> </select> </div><div class="col-md-3"> <label for=""> Trasnsport Cost per Bag :</label> <input type="email" class="form-control" id="exampleFormControlInput1"> </div><div class="col-md-1"> <label for="">Action :</label> <a href="javascript:void(0)" style="margin-top: 3px;" class="btn custom-btn-sbms-add btn-sm addMore"><i class="fas fa-plus-circle"></i></a> <a href="javascript:void(0)" class="btn btn-sm custom-btn-sbms-remove remove" style="margin-top: 3px;"><i class="fas fa-minus-circle"></i></a> <a href="" class=""></a> </div></div></div><div class="col-md-2"></div></div></div></div>';
                $(this).parents('.fieldGroup:last').after(fieldHTML);
            });
            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
            });
        });
    </script>
@endsection
