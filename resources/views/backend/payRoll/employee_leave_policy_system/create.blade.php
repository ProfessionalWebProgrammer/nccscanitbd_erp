@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class=" row pt-3">
                  <div class="col-md-12 text-right">
                      	<a href="{{route('emp.leave.policy.list')}}" class="btn btn-sm btn-success">Leave Policy List</a>
                  </div>
                  <div class="text-center col-md-12">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 ">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Leave Policy Create</h5>
                        <hr>
                    </div>
                        <form action="{{ route('emp.leave.policy.store') }}" method="POST">
                            @csrf
                            <div class="row offset-md-2 col-md-8">
                                <div class="form-group col-md-6">
                                    <label class="col-form-label">Leave Category</label>
                                    <input type="text" name="leave_category_name" class="form-control" placeholder="Leave Category" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="col-form-label">Leave Days</label>
                                
                                        <input type="number" name="leave_no" class="form-control" placeholder="Leave Days" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-form-label">Description</label>
                                        <textarea name="description" class="form-control" placeholder="Description"></textarea>
                                </div>
                                <div class="form-group col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>    
                </div>
            </div>
        </div>
    </div>
@endsection
