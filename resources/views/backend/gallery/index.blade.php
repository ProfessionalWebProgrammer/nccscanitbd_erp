
@extends('layouts.settings_dashboard')
<style>
  img.gallery{
    width:150px;
    height:140px;
  }
</style>
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Gallery List</h5>
                </div>
                <div class="py-4">
                    <table id="example3" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>User</th>
                              	<th>Image</th>
                              	<th>Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">

                            @foreach ($data as $val)
                            @php 
                                  $username = DB::table('users')->where('id', $val->user_id)->value('name');
                            @endphp 
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                  	<td>{{$username}}</td>
                                    <td> <a href="{{URL::to('/public/uploads/gallery/')}}/{{$val->image}}" target="_blank"><img class="gallery" src="{{URL::to('/public/uploads/gallery/')}}/{{$val->image}}" alt="Image"></a></td>
                                    <td>{{$val->note}}</td>
                                    <td class="text-center align-middle">
                                      <a class="btn btn-sm btn-primary " href="{{URL::to('/public/uploads/gallery/')}}/{{$val->image}}" target="_blank" ><i class="fas fa-eye"></i></a>
                                      <a class="btn btn-sm btn-success " href="{{URL::to('/public/uploads/gallery/')}}/{{$val->image}}" target="_blank" download><i class="fas fa-download"></i></a>
                                        <a class="btn btn-sm btn-danger " href="" data-toggle="modal"
                                            data-target="#delete" data-myid="{{ $val->id }}"><i
                                                class="far fa-trash-alt"></i>
                                        </a>
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- /.modal -->

    <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('gallery.delete', $val->id) }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this Documant?</p>
                      <input type="hidden" id="mid" name="id">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-light">Confirm</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.modal -->

@push('end_js')

        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })


            $('#delete').on('show.bs.modal', function(event) {
               // console.log('hello test');
                var button = $(event.relatedTarget)
                var id = button.data('myid')

                var modal = $(this)

                modal.find('.modal-body #mid').val(id);
            })
        </script>

    @endpush

@endsection


