@extends('layouts.backendbase')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-6" style="border-right: 2px solid black">

                <div class="content px-4 ">

                    <form class="floating-labels m-t-40" action="{{ Route('row.materials.category.store') }}" method="POST">
                        @csrf

                        <div class="container-fluid">
                            <div class="pt-3 text-center">
                                <h4 class="font-weight-bolder text-uppercase">Row Materials Category Create</h4>
                                <hr width="33%">
                            </div>

                            <div class="row pt-4">
                                    <div class="form-group col-md-12">
                                        <label class=" col-form-label">Category Name :</label>
                                     
                                            <input type="text" name="category_name" class="form-control"
                                            placeholder="Category Name">
                                    </div>


                             </div>
                        </div>
                        <div class="row pb-5">
                            <div class="col-md-6 mt-3">
                                <div class="text-right">
                                    <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">

                            </div>
                        </div>

                    </form>

                </div>
            </div>



            <div class="col-md-6">

                <div class="content px-4 ">
                    <div class="container-fluid">
                       <div class="py-4">
                            <div class="text-center">
                                <h5 class="text-uppercase font-weight-bold">Row Materials Category List</h5>
                                <hr>
                            </div>
                            <table id="example5" class="table table-bordered table-striped" style="font-size: 15px;">
                                <thead>
                                    <tr class="text-center">
                                        <th width="10%" >SI. No</th>
                                        <th>Title</th>
                                          <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sl = 0;
                                    @endphp

                                    @foreach ($category as $item)



                                        @php
                                            $sl++;
                                        @endphp
                                        <tr>
                                            <td class="align-middle">{{ $sl }}</td>
                                            <td>{{ $item->category_name }} </td>
                                            <td class="text-center align-middle">
                                                <a class="btn btn-xs mb-1" style="background-color: #66BB6A" href=""
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fas fa-edit"></i> </a>
                                                <a class="btn btn-xs btn-danger purchasedelete" href="" data-toggle="tooltip"
                                                    data-placement="top" title="Delete "><i
                                                        class="far fa-trash-alt"></i> </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.content-wrapper -->
    <script>
      
    </script>
@endsection
