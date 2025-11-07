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
                          	<h1 class="py-5 text-center">Appointment Letter</h1>
                      		<p style="margin-bottom: 8px;font-size: 20px;"><strong>{{$empdetailes->emp_name}}</strong></p>
                      		<p style="margin-bottom: 8px;font-size: 20px;">Date: {{date('d F Y')}}</p>
                          <p style="margin-bottom: 18px;font-size: 16px;">Address: </p>
                          <h5><u>Subject: Appointment Letter for the post of {{$empdetailes->designation->designation_title}}</u> </h5>

                          	<h5>Dear {{$empdetailes->emp_name}}</h5>
                            <p class="text-justify">This is in reference to your Job application followed with the rounds of Interview had with us.</p>
                            <p class="text-justify">We are pleased to appoint you to the position of <strong>{{$empdetailes->designation->designation_title}}</strong> in our organization, with effect from <b>{{date('F, Y',strtotime($empdetailes->emp_joining_date))}}</b> on the following terms and conditions:</p>
                            <p class="text-justify">1. You shall be on probation / training for one year from the date of commencement of your service which may be further extended at the discretion of the company. At the end of the probation / training period, if your services have been found satisfactory. Your appointment will be confirmed in writing by the organization. Notice period for either employer during probation will be a period of 30 days or salary in lieu of.</p>
                            <p class="text-justify">2. Notice period from either employee or company after confirmation of employment will be a period of 45 days or salary on lieu of. In the cases, probation/training or confirmed employee, company reserves the right to your emplacement till alterative person is employed. </p>
                            <p class="text-justify">3. Your employment is for ABC Company, Dhaka, but the company may, at any time, at its sole discretion, transfer you to any other department or location, as deemed necessary by requirement.</p>
                            <p class="text-justify">4. You will be subject to the Company’s rules and regulations for the time being in force and as amended from time to time.</p>
                            <p class="text-justify">5. During the period of your employment, you shall not engage yourself directly or indirectly, with or without remuneration, for any other employment without written permission from the company.</p>
                            <p class="text-justify">6. It is agreed that the company may from time to time add, modify or repeal any remuneration, benefit, facility that may have been extended to you on a review of the organization’s functioning, finances and prospects and you shall be bound by the organization’s decisions in this behalf.</p>
                            <p class="text-justify">7. You shall not disclose any information of the company or any of its customers to anyone which may come to your knowledge.</p>
                            <p class="text-justify">8. After tendering resignation from the company, an employee needs to return all company assets such as laptops etc in his/her possession. </p>
                            <p class="text-justify">9. During the tenure of your employment with the company, you may be called upon to present yourself for a medical examination and decision taken by the management based on the findings of the report by the company appointed medical practitioner shall be binding on you.</p>
                            <p class="text-justify">10. You are requested to confirm your acceptance of the terms of appointment herein above by signing and returning to us the duplicate of this letter.</p>
                            <p>I extend a warm welcome to you and wish you all the best for a successful career.</p>
                            <br>
                            <br>
                            <br>
                            <p>Your’s Faithfully.</p><br>
                            <p> <strong>ABC Company</strong></br>
                            <strong>HR Manager </strong> </p>
                            <br><hr><br>
                            <h3><u>Acceptance</u> </h3>
                            <p>I have read the terms and conditions of this appointment and confirm my acceptance of the same.</p><br>
                            <h5>{{$empdetailes->emp_name}}</h5><br>
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
