@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{route('test.data.store')}}" method="post">
                @csrf
                <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                    <div class="text-center py-4">
                        <h3 class="text-uppercase font-weight-bold text-danger">Create</h3>
                    </div>

                    <div class="row pt-5">
                        <input type="hidden" name="user_id" value="101">
                        <div class="col-md-4">
                            <label class="col-form-label text-right text-primary">Name: </label>
                            <input type="Text"  name="name" class="form-control" placeholder="Name">

                        </div>


                    </div>
                    

                    <div class="row py-4">
                        <div class="col-md-6 m-auto">
                            <div class="text-center">
                                <button type="submit" class="btn custom-btn-sbms-submit btn-primary"> Submit </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script>
 
        
    </script>
@endsection
