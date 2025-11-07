@extends('layouts.purchase_deshboard')

@section('content')
<style>

  .menuclass{
  display: none;
  }
  </style>

<div class="content-wrapper">
    <!-- Main content -->
    <div class="content" >
      <div class="container-fluid" style="background:#fff!important; min-height:85vh;">

       <div class="row">
        <div class="col-md-2 mt-5">
             <!-- Main Sidebar Container -->
        <aside >
            @include('_partials_.sidebar')
        </aside>
        </div>
         <div class="col-md-10">

          <div class="mb-3" >
          @php
              $authid = Auth::id();


           @endphp


        <div class="row pt-3">
            <div class="col-md-4 m-auto sales_main_button">
                <a href="{{route('rental.goods.allReports')}}" class="text-center pt-1 pb-2 py-3 btn btn-block  text-center linkbtn" >Rental Reports</a>
            </div>
        </div>

          <div class="row pt-5 px-3 text-center">

            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('rental.goods.report')}}" class="btn btn-block  text-center py-3 linkbtn">Date Wise Received</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('rental.goods.delivery.report')}}" class="btn btn-block  text-center py-3 linkbtn">Date Wise Delivery</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('rental.goods.delivery.ledger')}}" class="btn btn-block  text-center py-3 linkbtn">Delivery Leadger</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('rental.goods.collection.slip.view')}}" class="btn btn-block  text-center py-3 linkbtn">Collection Slip</a>
                </div>
            </div>

          </div>
        </div>

        </div>

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
