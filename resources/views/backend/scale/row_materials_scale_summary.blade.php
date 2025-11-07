@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Scale List</h5>
                        <hr>
                    </div>
                    <div class="my-3">

                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th>Si.No</th>
                                <th>Date</th>
                                <th>Supplier Name</th>
                                <th>Vehicle</th>
                                <th>Load W</th>
                                <th>Unload W</th>
                                <th>Status</th>
                                <th>Chalan Q</th>
                                <th>Delivery Status</th>
                                 <th>Scale No</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $data)
                        
                        @php
                      
                        if($data->delivery_status == 0){
                        $incolor = "color: red;";
                        }else{
                        $incolor = "color: green;";
                        }
                        @endphp
                        
                        <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->date}}</td>
                        <td>{{$data->supplier_name}}</td>
                        <td>{{$data->vehicle}}</td>
                        <td>{{$data->load_weight}}</td>
                        <td>{{$data->unload_weight}}</td>
                         @if($data->load_status == 0)
                        <td style="color:red">Unload</td>
                        @else
                        <td style="color:green">Load</td>
                        @endif
                        <td>{{$data->chalan_qty}}</td>
                        
                         @if($data->delivery_status == 0)
                        <td style="color:red">Undeliverd</td>
                        @else
                        <td style="color:green">Deliverd</td>
                        @endif
                        
                        <td style="{{$incolor}}" >{{$data->scale_no}}</td>
                         
                      
                        </tr>
                        
                        @endforeach
                        
                       
                        </tbody>
                    </table>
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
