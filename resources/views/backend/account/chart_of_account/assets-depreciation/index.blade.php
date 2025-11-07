@extends('layouts.account_dashboard')
@section('header_menu')
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  accountscontent">


        <!-- Main content -->
        <div class="content px-4 ">
          {{-- <li class="nav-item d-none d-sm-inline-block">
              <a href="{{ URL('budget/create') }}" class=" btn btn-success btn-sm mr-2 mt-1">Create New
                  Budget</a>
          </li> --}}
            <div class="container-fluid">
                <div class="text-center pt-3">
                  <h3 class="text-uppercase font-weight-bold">Assets Depreciation</h3>
                </div>
                <div class="py-4">
                    <table class="table table-bordered table-striped table-fixed text-center" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>Depreciation Formula</th>
                                <th>Depreciation Rate</th>
                                <th>Depreciation Year</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">

                            @foreach ($assetDepreciations as $data)
                                <tr>
                                    <td >{{ $loop->iteration }}</td>
                                   <td >{{ $data->depreciation_formula }}</td>
                                    <td >{{ $data->depreciation_rate }}</td>
                                    <td >{{ $data->depreciation_year }}</td>
                                    <td style="color:{{ $data->status == 1 ? 'green' : 'red' }}">{{ $data->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal-{{ $data->id }}">
                                            Setting
                                          </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="exampleModal-{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Assets Depreciation Method Setting ({{$data->depreciation_formula}})</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="{{ route('update.chat.of.account.depreciation',$data->id) }}" method="GET">
                                        <div class="modal-body">
                                           <div class="form-group">
                                                <input type="number" name="depreciation_rate" value="{{ $data->depreciation_rate }}" class="form-control" placeholder="Depreciation Rate" />
                                           </div>
                                           <div class="form-group">
                                            <input type="number" name="depreciation_year" value="{{ $data->depreciation_year }}" class="form-control" placeholder="Depreciation Year" />
                                           </div>
                                           <div class="form-group">
                                             <select name="status" class="form-control">
                                                <option value="1" {{ $data->status == 1 ? 'selected' : ''}}>Active</option>
                                                <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Inactive</option>
                                             </select>
                                           </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary">save</button>
                                        </div>
                                        </form>
                                      </div>
                                    </div>
                                </div> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
	  <!-- Modal -->


    <!-- /.modal -->
	 @push('end_js')

        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })


            $('#delete').on('show.bs.modal', function(event) {
                console.log('hello test');
                var button = $(event.relatedTarget)
                var title = button.data('mytitle')
                var id = button.data('myid')
                var modal = $(this)
                modal.find('.modal-body #mid').val(id);
            })
        </script>

    @endpush
@endsection
