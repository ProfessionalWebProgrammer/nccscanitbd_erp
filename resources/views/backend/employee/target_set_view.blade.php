@extends('layouts.hrPayroll_dashboard')

@section('header_menu')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ URL('/employee/terget/set/create') }}" class=" btn btn-success mr-2">Set Target</a>
    @endsection


    @section('content')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content px-4 ">
                <div class="container-fluid">
                    <div class="text-center pt-3">
                      <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                    <div class="py-4">
                        <div class="text-center">
                            <h5 class="text-uppercase font-weight-bold">Employee Sales Target</h5>
                            <hr>
                        </div>
                        <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                            <thead>
                                <tr>
                                    <th>SI. No</th>

                                  <th>Category</th>
                                    <th>Target Amount</th>

                                    <th>Action</th>
                                    <th>Created By</th>
                                    <th>Updated By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                            @foreach($lmtargets as $lmtar)

                             @php
                              $username = '';
                              if($lmtar->created_by != ''){
                                     $username = DB::table('users')->where('id',$lmtar->created_by)->value('name');
                              }
                              $updatednamename = '';
                               if($lmtar->updated_by != ''){
                                     $updatednamename = DB::table('users')->where('id',$lmtar->updated_by)->value('name');
                              }

                              $total += $lmtar->target_amount;
                            @endphp

                                <tr>
                                    <td>{{$loop->iteration}}</td>

                                     <td>{{$lmtar->category_name}}</td>
                                    <td>{{$lmtar->target_amount}}</td>


                                     <td>
                                        {{-- @if(Auth::user()->user_role->role_id==1)
                                        <a href="#" class="btn btn-danger btn-sm" data-myid="{{$lmtar->id}}" data-mytitle="" data-toggle="modal" data-target="#delete"><i class="ti-trash"></i></a>
                                        <a href="{{route('linemanager.target.getedit',$lmtar->id)}}" class="show-modal  btn btn-warning btn-sm" alt="default"><i class="ti-settings"></i></a>
                                        @elseif(Auth::user()->user_role->role_id==2)
                                        <a href="{{route('linemanager.target.getedit',$lmtar->id)}}" class="show-modal  btn btn-warning btn-sm" alt="default"><i class="ti-settings"></i></a>
                                        @endif --}}

                                    </td>
                                    <td> @if($lmtar->created_by != '') (  {{ $username }}<br>{{$lmtar->created_at}}) @endif</td>
                                   <td> @if($lmtar->updated_by != '') (  {{ $updatednamename }}<br>{{$lmtar->updated_at}}) @endif</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="text-center">
                            <h4>Total: {{ $total }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
    @endsection
