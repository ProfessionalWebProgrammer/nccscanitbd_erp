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
                <form id="myForm" action="{{route('employee.attendance.store')}}" method="POST">
                          @csrf
                          <div>
                              <div class="text-center">
                                  <h5 class="text-uppercase font-weight-bold">Employee Attendance</h5>
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
                          <table id="example8" class="table table-bordered table-striped " style="font-size: 15px;">
                              <thead>
                                  <tr class="text-center">
                                      <th>Sl</th>
                                      <th>Name</th>
                                      <th style="width:70px;">Present
                                         <input type="checkbox" id="selectAllCheckbox"></th>
                                      {{-- <th style="width:70px;">Absent</th> --}}
                                      <th>Entry Time</th>
                                    	<th>Break Time</th>
                                      <th>Break Back Time</th>
                                      <th>Exit Time</th>
                                  </tr>
                              </thead>
                              <tbody >

                                 @foreach ($employee as $item)
                                      <tr>
                                          <td class="align-middle">{{ $loop->iteration }}</td>
                                          <td class="align-middle">{{ $item->emp_name }} <input type="hidden"
                                                  value="{{ $item->id }}" name="emp_id[]"></td>
                                          <td class="text-center align-middle">
                                              {{-- <input type="checkbox" name="present[]" value="1" class="form-control present-checkbox"  style="width: 20px; height: 20px;"> --}}
                                              {{-- <input type="text" class="form-control" name="present[]"> --}}
                                              <input type="hidden" name="present[{{ $item->id }}]" value="0">
                                              <input type="checkbox" name="present[{{ $item->id }}]" value="1" class="form-control present-checkbox" style="width: 20px; height: 20px;"
                                                  {{ old('present.'.$item->id, '0') == '1' ? 'checked' : '' }}>
                                            </td>
                                          {{-- <td class="text-center">
                                              <input type="text"   class="form-control" name="absent[]">
                                          </td> --}}
                                          <td>
                                            <input type="time" class="form-control" name="entry_time[]">
                                          </td>
                                          <td>
                                            <input type="time" class="form-control" name="break_time[]">
                                          </td>

                                          <td>
                                            <input type="time" class="form-control" name="break_back_time[]">
                                          </td>

                                          <td>
                                            <input type="time" class="form-control" name="exit_time[]">
                                          </td>

                                      </tr>

                                  @endforeach



                              </tbody>
                          </table>
                          <div class="row">
                              <div class="col-md-12 text-center mt-2 mb-5">
                                  <button class="btn btn-sm btn-success px-5" type="submit">Submit</button>
                              </div>
                          </div>
                      </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#selectAllCheckbox").change(function () {
                // Get the state of the "Select All" checkbox
                var isChecked = $(this).prop("checked");
                 console.log("hhhhhhhhh"+isChecked);
                // Set all checkboxes with the class "present-checkbox" to the same state
                $(".present-checkbox").prop("checked", isChecked);
            });
        });
    </script>

@endsection
