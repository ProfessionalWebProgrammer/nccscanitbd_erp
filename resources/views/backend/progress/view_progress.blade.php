@extends('layouts.crm_dashboard')


@section('header_menu')



@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#fff; min-height:85vh;">

               <li class="nav-item d-none d-sm-inline-block">
    </li>


                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div>
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Progress View</h5>
                        <hr>
                      </div>
                      <div class="row">
                          <div class="col-md-6">
								<h5>Date : <span style="font-weight:600;">{{$progressData->date}}</span></h5>
								<h5>Client Name : <span style="font-weight:600;">{{$progressData->client_name}}</span></h5>
								<h5>Contacts Person : <span style="font-weight:600;">{{$progressData->contacts_person}}</span></h5>
                          </div>
                          <div class="col-md-6">
								<h5>Reference : <span style="font-weight:600;">{{$progressData->reference}}</span></h5>
								<h5>Converted Ratio : <span style="font-weight:600;">{{$progressData->converted_ratio}}%</span></h5>
								<h5>Deal Status : <span style="font-weight:600;">{{$progressData->deal_status}}</span></h5>
                          </div>
                      </div>

                      <div class="row mt-5">
                          <div class="col-md-6">
                            	<h5> <span style="font-weight:600;">Feedback</span></h5>
								<p>{{$progressData->feedback}}</p>
                          </div>
                          <div class="col-md-6">
                            	<h5> <span style="font-weight:600;">Description</span></h5>
								<p>{{$progressData->description}}</p>
                          </div>
                      </div>
                  <div>
                    <table class="table table-bordered table-striped mt-5" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th width="3%">Sl</th>
                                <th width="37%">Subject</th>
                                <th width="40%">Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($multipedata as $item)

                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>

                                    <td class="align-middle">{{ $item->subject }}</td>
                                    <td class="align-middle">{{ $item->note }}</td>

                                </tr>

                            @endforeach
                        </tbody>
                      </table>
                  </div>
                </div>
            </div>
        </div>
    </div>


@endsection
