@extends('layouts.hrPayroll_dashboard')

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
                <form action="{{route('employee.overtime.store')}}" method="POST">
                          @csrf
                          <div>
                              <div class="text-center">
                                  <h5 class="text-uppercase font-weight-bold">Employee Overtime</h5>
                                  <hr>
                              </div>
                              <div class="row">
                                  <div class="col-md-3">
                                      <div class=" form-group row">
                                          <label class="col-sm-3 col-form-label">Date :</label>
                                          <div class="col-sm-9">
                                              <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control"
                                                  placeholder="Join Date">
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <table class="table table-bordered table-striped" style="font-size: 15px;">
                              <thead>
                                  <tr class="text-center">
                                      <th>Sl</th>
                                      <th>Name</th>
                                      <th>Overtime Start</th>
                                      <th>Overtime End</th>
                                  </tr>
                              </thead>
                              <tbody>
                                 @foreach ($employee as $item)
                                      <tr>
                                          <td class="align-middle">{{ $loop->iteration }}</td>
                                          <td class="align-middle">{{ $item->emp_name }} <input type="hidden"
                                                  value="{{ $item->id }}" name="emp_id[]"></td>
                                          <td>
                                            <input type="time" class="form-control" name="ovt_start[]">
                                          </td>
                                          <td>
                                            <input type="time" class="form-control" name="ovt_end[]">
                                          </td>

                                      </tr>

                                  @endforeach



                              </tbody>
                          </table>
                          <div class="row">
                              <div class="col-md-12 text-center mt-3 pb-5">
                                  <button class="btn btn-sm btn-success px-5" type="submit">Submit</button>
                              </div>
                          </div>
                      </form>
            </div>
        </div>
    </div>
@endsection
