@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">

                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">F.G Stock/Production Report Input</h5>
                    <hr>
                </div>


                <div class="form">
                    <form class="floating-labels m-t-40" action="{{ Route('sales.stock.report') }}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-md-3">
                                <h5>Select Daterange: <span id="today" style="color: lime; display:inline-block">Today</span></h5>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date" 
                                            class="form-control float-right" id="daterangepicker">

                                    </div>
                                </div>
                            </div>

                           <div class="col-md-3">
                                <h5 >Select Warehouse</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true"  data-actions-box="true" multiple name="warehouse_id[]">
                                        @if($user != 169)
                                        @foreach ($wirehouses as $w)
                                            <option style="color: #FF0000" value="{{ $w->id }}" >{{ $w->factory_name }}
                                            </option>
                                        @endforeach
                                      @else 
                                      <option style="color: #FF0000" value="36" >Mymensingh Depo </option>
                                      @endif 
                                    </select>
                                </div>
                            </div> 
							<div class="col-md-3">
                                <h5 >Select Category</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true"  data-actions-box="true" name="cat_id">
                                      <option style="color: #FF0000" value="" >Select Category</option>
                                         @foreach ($categories as $cat)
                                            <option style="color: #FF0000" value="{{ $cat->id }}"
                                                >{{  $cat->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h5 >Select Product</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true"  data-actions-box="true" multiple name="product_id[]">
                                         @foreach ($products as $p)
                                            <option style="color: #FF0000" value="{{ $p->id }}"
                                                >{{ $p->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                          <div class="col-md-3">
                                <h5 >Select Unit</h5>
                                <div class="form-group m-b-40">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true"  data-actions-box="true"  name="unit">
                                      <option style="color: #FF0000" value="" >Select Unit</option>
                                            <option style="color: #FF0000" value="Kg" >Kg</option>
                                      		<option style="color: #FF0000" value="Ton" >Ton</option>
                                       		<option style="color: #FF0000" value="Bag" >Bag</option>
                                    </select>
                                </div>
                            </div>

                        </div> 

                        <div class="class row mt-2">
                            <div class="class col-md-4"></div>
                            <div class="class col-md-4 px-5">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Generate Report</button>


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

@endsection

@push('end_js')

    <script>
        $(document).ready(function() {

            $("#daterangepicker").change(function() {
                var a = document.getElementById("today");
               a.style.display = "none";
            });

            

           


        });
    </script>

@endpush
