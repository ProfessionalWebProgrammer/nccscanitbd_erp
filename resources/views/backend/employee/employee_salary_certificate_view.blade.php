@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 pb-5">
              <div class="col-md-12 pt-3" align="right" id="btndiv">
                <button class="btn btn-outline-warning"  onclick="printDiv('cardbody')"><i class="fa fa-print"
                        aria-hidden="true"> Print </i></button>
             </div>
          <dic class="row mt-3">
          <dic class="col-md-10 m-auto pb-5 bg-light">

            <div class="container-fluid" id="cardbody">
                <div class="row">
                    {{-- <div class="col-md-1"></div> --}}
                    <div class="col-md-12 mt-2">
                      	<div class="px-5">
                          	<h1 class="py-5 text-center">Salary Certificate</h1>
                      		<p style="margin-bottom: 0px;font-size: 20px;">{{date('d-M-Y')}}</p>
                          	<h4><strong>Naba Crop Care.</strong></h4></br>
                          	<p style="font-size: 22px;">This is to certify that <strong>{{$empdetailes->emp_name}}</strong> is working with our esteem company under the title
                              of <strong>{{$empdetailes->designation_title}}</strong> since {{date('F,Y',strtotime($empdetailes->emp_joining_date))}} and further it is certified that he is drawing a monthly salary of Tk. {{$empdetailes->net_salary_after_EPF}}/-.
                              We found this gentleman fully committed to his job and totally sincere toward this company.</br></br>
                              We are issuing this letter on the specific request of our employee without accepting any liability on behalf of
                              this letter or part of this letter on our company.
                              </br></br></br>Regards,</br>
                              Mohammad Alamgir</br>Managing Director</p>
                      	</div>
                    </div>
                    {{-- <div class="col-md-1"></div> --}}
                </div>
            </div>
            <!-- /.container-fluid -->
            </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
		<script>
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
			 function showButton() {
                var a = document.getElementById("button");
                   a.style.display = "block";
                }
        </script>
@endsection
