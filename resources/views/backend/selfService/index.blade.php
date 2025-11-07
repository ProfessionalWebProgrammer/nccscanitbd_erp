@extends('layouts.employee_dashboard')
<style media="screen">
.img-account-profile {
  height: 10rem;
}
.rounded-circle {
  border-radius: 50% !important;
}
.card {
  box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
}
.card .card-header {
  font-weight: 500;
}
.card-header:first-child {
  border-radius: 0.35rem 0.35rem 0 0;
}
.card-header {
  padding: 1rem 1.35rem;
  margin-bottom: 0;
  background-color: rgba(33, 40, 50, 0.03);
  border-bottom: 1px solid rgba(33, 40, 50, 0.125);
}
.form-control, .dataTable-input {
  display: block;
  width: 100%;
  padding: 0.875rem 1.125rem;
  font-size: 0.875rem;
  font-weight: 400;
  line-height: 1;
  color: #69707a;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #c5ccd6;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  border-radius: 0.35rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.nav-borders .nav-link.active {
  color: #0061f2;
  border-bottom-color: #0061f2;
}
.nav-borders .nav-link {
  color: #69707a;
  border-bottom-width: 0.125rem;
  border-bottom-style: solid;
  border-bottom-color: transparent;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  padding-left: 0;
  padding-right: 0;
  margin-left: 1rem;
  margin-right: 1rem;
}
</style>
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 911.969px;">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="py-4">
                    <div class="row">
                      <div class="col-md-4">
                          <!-- Profile picture card-->
                          <div class="card mb-4 mb-xl-0">
                              <div class="card-header bg-info">Profile Picture</div>
                              <div class="card-body text-center">
                                  <!-- Profile picture image-->
                                  <img class="img-account-profile rounded-circle mb-2" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                                  <!-- Profile picture help block-->
                                  <!-- <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div> -->
                                  <!-- Profile picture upload button-->
                                  <!-- <input type="file" name="" value="">
                                  <button class="btn btn-primary" type="button">Upload new image</button> -->
                              </div>
                          </div>
                      </div>
                      <div class="col-md-8">
                          <!-- Account details card-->
                          <div class="card mb-4">
                              <div class="card-header bg-info">My Profile</div>
                              <div class="card-body">
                                  <form>
                                      <!-- Form Group (username)-->
                                      <div class="mb-3">
                                          <label class="small mb-1" for="inputUsername">Name</label>
                                          <input class="form-control" id="inputUsername" type="text" placeholder="Enter your Name" value="Md Abdur Rahman">
                                      </div>
                                      <!-- Form Row-->
                                      <div class="row gx-3 mb-3">
                                          <!-- Form Group (first name)-->
                                          <div class="col-md-6">
                                              <label class="small mb-1" for="inputFirstName">Designation</label>
                                              <input class="form-control" id="inputFirstName" type="text" placeholder="Enter your first name" value="Marketing Officer">
                                          </div>
                                          <!-- Form Group (last name)-->
                                          <div class="col-md-6">
                                              <label class="small mb-1" for="inputLastName">Department</label>
                                              <input class="form-control" id="inputLastName" type="text" placeholder="Enter your last name" value="Sales Department">
                                          </div>
                                      </div>
                                      <!-- Form Row        -->
                                      <div class="row gx-3 mb-3">
                                          <!-- Form Group (organization name)-->
                                          <div class="col-md-6">
                                              <label class="small mb-1" for="inputOrgName">Contact No</label>
                                              <input class="form-control" id="inputOrgName" type="text" placeholder="Enter your organization name" value="01734756869">
                                          </div>
                                          <!-- Form Group (location)-->
                                          <div class="col-md-6">
                                              <label class="small mb-1" for="inputLocation">Email</label>
                                              <input class="form-control" id="inputLocation" type="email" placeholder="Enter your location" value="abdurrahman@gmail.com">
                                          </div>
                                      </div>
                                      <div class="row gx-3 mb-3">
                                          <!-- Form Group (organization name)-->
                                          <div class="col-md-6">
                                              <label class="small mb-1" for="inputOrgName">Gender</label>
                                              <input class="form-control" id="inputOrgName" type="text" placeholder="Enter your organization name" value="Male">
                                          </div>
                                          <!-- Form Group (location)-->
                                          <div class="col-md-6">
                                              <label class="small mb-1" for="inputLocation">Maritial Status</label>
                                              <input class="form-control" id="inputLocation" type="text" placeholder="Enter your location" value="Married">
                                          </div>
                                      </div>
                                      <div class="row gx-3 mb-3">
                                          <!-- Form Group (organization name)-->
                                          <div class="col-md-6">
                                              <label class="small mb-1" for="inputOrgName">Religion</label>
                                              <input class="form-control" id="inputOrgName" type="text" placeholder="Enter your organization name" value="Islam">
                                          </div>
                                          <!-- Form Group (location)-->
                                          <div class="col-md-6">
                                              <label class="small mb-1" for="inputLocation">Blood Group</label>
                                              <input class="form-control" id="inputLocation" type="text" placeholder="Enter your location" value="O+">
                                          </div>
                                      </div>
                                      <div class="row gx-3 mb-3">
                                          <!-- Form Group (organization name)-->
                                          <div class="col-md-6">
                                              <label class="small mb-1" for="inputOrgName">Nid Number</label>
                                              <input class="form-control" id="inputOrgName" type="text" placeholder="Enter your organization name" value="5768349098">
                                          </div>
                                          <!-- Form Group (location)-->
                                          <div class="col-md-6">
                                              <label class="small mb-1" for="inputLocation">Nationality</label>
                                              <input class="form-control" id="inputLocation" type="text" placeholder="Enter your location" value="Bangladeshi">
                                          </div>
                                      </div>
                                      <div class="row gx-3 mb-3">
                                          <!-- Form Group (organization name)-->
                                          <div class="col-md-6">
                                              <label class="small mb-1" for="inputOrgName">Account Number</label>
                                              <input class="form-control" id="inputOrgName" type="text" placeholder="Enter your organization name" value="4349098">
                                          </div>
                                          <!-- Form Group (location)-->
                                          <div class="col-md-6">
                                              <label class="small mb-1" for="inputLocation">Joining Date</label>
                                              <input class="form-control" id="inputLocation" type="date" placeholder="Enter your location" value="02/05/2023">
                                          </div>
                                      </div>
                                      <!-- Form Group (email address)-->
                                      <div class="mb-3">
                                          <label class="small mb-1" for="inputEmailAddress">Parmanent Address</label>
                                          <input class="form-control" id="inputEmailAddress" type="text"  value="Dhaka">
                                      </div>
                                      <div class="mb-3">
                                          <label class="small mb-1" for="inputEmailAddress">Present Address</label>
                                          <input class="form-control" id="inputEmailAddress" type="text" value="Dhaka">
                                      </div>

                                      <!-- Save changes button-->
                                      <button class="btn btn-primary" type="submit">Save changes</button>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection
