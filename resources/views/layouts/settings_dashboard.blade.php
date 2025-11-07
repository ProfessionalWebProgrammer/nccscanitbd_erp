<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NCC | V.3.5</title>



    @include('_partials_.css')

  <link rel="stylesheet" href="{{ asset('public/backend/dist/css/customcss.css') }}">

   <style>
    .hovermanue_icon{
    	display: none !important;
      }
    </style>

</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        @include('_partials_.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
          <a href="{{ URL('/') }}" class="brand-link">
                <img src="{{ asset('public/backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">SBMS | V.3.5</span>
            </a>

            <!-- Sidebar -->
         <div class="">
             <!-- Sidebar user panel (optional) -->


             @php
                 $authid = Auth::id();
                 $salesdata = DB::table('permissions')
                     ->where('head', 'Sales')
                     ->where('user_id', $authid)
                     ->pluck('name')
                     ->toArray();
                 $purchasedata = DB::table('permissions')
                     ->where('head', 'Purchase')
                     ->where('user_id', $authid)
                     ->pluck('name')
                     ->toArray();
                 $accountsdata = DB::table('permissions')
                     ->where('head', 'Accounts')
                     ->where('user_id', $authid)
                     ->pluck('name')
                     ->toArray();
                 $settingsdata = DB::table('permissions')
                     ->where('head', 'Settings')
                     ->where('user_id', $authid)
                     ->pluck('name')
                     ->toArray();

             @endphp

             <aside >
                 @include('_partials_.sidebar')
             </aside>
             <!-- Sidebar Menu -->
             <nav class="mt-2">
                 <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                     <!-- Add icons to  -->


                   <li class="nav-item">
                                               <a href="{{ URL('user/password/change/index') }}" class="nav-link">
                                                   <i class="fas fa-shopping-bag"></i>
                                                   <p>
                                                       Password Change
                                                   </p>
                                               </a>
                                           </li>



                               @if (in_array('warehouse', $settingsdata))
                                   <li class="nav-item">
                                       <a href="#" class="nav-link">
                                           <i class="fas fa-university"></i>
                                           <p>
                                               Warehouse
                                               <i class="fas fa-angle-left right"></i>
                                           </p>
                                       </a>
                                       <ul class="nav nav-treeview">
                                           <li class="nav-item">
                                               <a href="{{ URL('/warehouse/create') }}" class="nav-link">
                                                   <i class="far fa-edit"></i>
                                                   <p>Create Warehouse </p>
                                               </a>
                                           </li>
                                           <li class="nav-item">
                                               <a href="{{ URL('/warehouse/index') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Warehouse List</p>
                                               </a>
                                           </li>
                                          <li class="nav-item">
                                               <a href="{{ URL('/warehouse/index') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Create Production Factory</p>
                                               </a>
                                           </li>
                                          <li class="nav-item">
                                               <a href="{{ URL('/warehouse/index') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Production Factory List</p>
                                               </a>
                                           </li>
                                       </ul>
                                   </li>


                                   @endif


                   <li class="nav-item">
                                       <a href="#" class="nav-link">
                                           <i class="fas fa-university"></i>
                                           <p>
                                              Production Factory
                                               <i class="fas fa-angle-left right"></i>
                                           </p>
                                       </a>
                                       <ul class="nav nav-treeview">

                                          <li class="nav-item">
                                               <a href="{{ URL('/production/factory/create') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Create Production Factory</p>
                                               </a>
                                           </li>
                                          <li class="nav-item">
                                               <a href="{{ URL('/production/factory/index') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Production Factory List</p>
                                               </a>
                                           </li>
                                       </ul>
                                   </li>





                                   <li class="nav-item">
                                       <a href="#" class="nav-link">
                                           <i class="fas fa-users"></i>
                                           <p>
                                               Vehicle
                                               <i class="fas fa-angle-left right"></i>
                                           </p>
                                       </a>
                                       <ul class="nav nav-treeview">
                                           <li class="nav-item">
                                               <a href="{{ route('vehicle.create') }}" class="nav-link">
                                                   <i class="far fa-edit"></i>
                                                   <p>Vehicle Create </p>
                                               </a>
                                           </li>
                                          <li class="nav-item">
                                               <a href="{{ route('vehicle.list') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Vehicle List </p>
                                               </a>
                                           </li>
                                          <li class="nav-item">
                                               <a href="{{ route('vehicle.category') }}" class="nav-link">
                                                   <i class="far fa-edit"></i>
                                                   <p>Vehicle Category </p>
                                               </a>
                                           </li>


                                          <li class="nav-item">
                                               <a href="{{ route('driver.list') }}" class="nav-link">
                                                   <i class="far fa-edit"></i>
                                                   <p>Driver list</p>
                                               </a>
                                           </li>

                                         {{-- <li class="nav-item">
                                               <a href="{{ route('trip.demo.create')}}" class="nav-link">
                                                   <i class="fa fa-solid fa-truck-moving"></i>
                                                   <p>Demo Vehicle Expanse</p>
                                               </a>
                                           </li> --}}
                                         <li class="nav-item">
                                               <a href="{{ route('trip.create') }}" class="nav-link">
                                                   <i class="far fa-edit"></i>
                                                   <p>Trip Entry</p>
                                               </a>
                                           </li>

                                         <li class="nav-item">
                                               <a href="{{ route('trip.list') }}" class="nav-link">
                                                   <i class="far fa-edit"></i>
                                                   <p>Trip List</p>
                                               </a>
                                           </li>

                                          <li class="nav-item">
                                               <a href="{{ route('trip.report.index') }}" class="nav-link">
                                                   <i class="far fa-edit"></i>
                                                   <p>Trip Report</p>
                                               </a>
                                           </li>

                                          <li class="nav-item">
                                               <a href="{{ route('total.trip.report.index') }}" class="nav-link">
                                                   <i class="far fa-edit"></i>
                                                   <p>Total Trip Report</p>
                                               </a>
                                           </li>

                                       </ul>
                                   </li>

                              <li class="nav-item">
                                         <a href="#" class="nav-link">
                                             <i class="fas fa-users"></i>
                                             <p>
                                                 Machine
                                                 <i class="fas fa-angle-left right"></i>
                                             </p>
                                         </a>
                                         <ul class="nav nav-treeview">
                                             <li class="nav-item">
                                                 <a href="{{ route('machine.create') }}" class="nav-link">
                                                     <i class="far fa-edit"></i>
                                                     <p>Machine Create </p>
                                                 </a>
                                             </li>
                                             <li class="nav-item">
                                                 <a href="{{ route('machine.list') }}" class="nav-link">
                                                     <i class="far fa-edit"></i>
                                                     <p>Machine List </p>
                                                 </a>
                                             </li>

                                         </ul>
                                     </li>

                  			 <li class="nav-item">
                                         <a href="#" class="nav-link">
                                             <i class="fas fa-users"></i>
                                             <p>
                                                 Meter
                                                 <i class="fas fa-angle-left right"></i>
                                             </p>
                                         </a>
                                         <ul class="nav nav-treeview">

                                           <li class="nav-item">
                                                 <a href="{{ route('meter.reading.create') }}" class="nav-link">
                                                     <i class="far fa-edit"></i>
                                                     <p>Meter Reading Entry </p>
                                                 </a>
                                             </li>

                                            <li class="nav-item">
                                                 <a href="{{ route('meter.reading.list') }}" class="nav-link">
                                                     <i class="far fa-edit"></i>
                                                     <p>Meter Reading List </p>
                                                 </a>
                                             </li>
                                             <li class="nav-item">
                                                 <a href="{{ route('meter.create') }}" class="nav-link">
                                                     <i class="far fa-edit"></i>
                                                     <p>Meter Create </p>
                                                 </a>
                                             </li>
                                             <li class="nav-item">
                                                 <a href="{{ route('meter.list') }}" class="nav-link">
                                                     <i class="far fa-edit"></i>
                                                     <p>Meter List </p>
                                                 </a>
                                             </li>

                                         </ul>
                                     </li>





                                   @if (in_array('employee', $settingsdata))

                                   <li class="nav-item">
                                       <a href="#" class="nav-link">
                                           <i class="fas fa-users"></i>
                                           <p>
                                               Employee
                                               <i class="fas fa-angle-left right"></i>
                                           </p>
                                       </a>
                                       <ul class="nav nav-treeview">
                                           <li class="nav-item">
                                               <a href="{{ route('employee.create') }}" class="nav-link">
                                                   <i class="far fa-edit"></i>
                                                   <p>Create Employee </p>
                                               </a>
                                           </li>
                                           <li class="nav-item">
                                               <a href="{{ route('employee.list') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Employee List</p>
                                               </a>
                                           </li>

                                            <li class="nav-item">
                                               <a href="{{route('employee.team.list')}}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Employee Team</p>
                                               </a>
                                         	</li>

                                         <li class="nav-item">
                                               <a href="{{route('employee.team.report.list')}}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Employee Daily Report Entry</p>
                                               </a>
                                         	</li>


                                         <li class="nav-item">
                                               <a href="{{route('employee.team.report.index')}}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Employee Team Report</p>
                                               </a>
                                         	</li>



                                             <li class="nav-item">
                                               <a href="{{ route('employee.designation.create') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Employee Designation</p>
                                               </a>
                                           </li>
                                          <li class="nav-item">
                                               <a href="{{ route('employee.departments.create') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Employee Department</p>
                                               </a>
                                           </li>
                                         <li class="nav-item">
                                               <a href="{{ route('employee.stafcategory.create') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Employee Staff Category</p>
                                               </a>
                                           </li>


                                           <li class="nav-item">
                                               <a href="{{ route('employee.target.set.index') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Employee Sales Target</p>
                                               </a>
                                           </li>



                                          <li class="nav-item">
                                               <a href="{{ route('employee.attendance.form') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Employee Attendance</p>
                                               </a>
                                           </li>
                                          <li class="nav-item">
                                               <a href="{{ route('employee.overtime.create') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Employee Overtime</p>
                                               </a>
                                           </li>
                                          <li class="nav-item">
                                               <a href="{{ route('employee.attendance.list') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>E. Attendance List</p>
                                               </a>
                                           </li>
                                           <li class="nav-item">
                                               <a href="{{ route('employee.overtime.list') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>E. Overtime List</p>
                                               </a>
                                           </li>
                                          <li class="nav-item">
                                               <a href="{{ route('employee.leave.of.absent.form') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>E. Leave Of Absence</p>
                                               </a>
                                           </li>
                                          <li class="nav-item">
                                               <a href="{{ route('employee.leave.of.absent.list') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Leave Of Absence List</p>
                                               </a>
                                           </li>

                                           <li class="nav-item">
                                               <a href="{{route('employee.other.amount.pay.list')}}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Employee Other Amount </p>
                                               </a>
                                         </li>




                                         <li class="nav-item">
                                               <a href="{{route('employee.salary.pay')}}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>E. Salary Pay Form </p>
                                               </a>
                                         </li>
                                         <li class="nav-item">
                                               <a href="{{route('employee.salary.pay.list')}}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>E. Salary Pay List </p>
                                               </a>
                                         </li>

                                         <li class="nav-item">
                                               <a href="{{ route('monthly.salary.and.attendance.report') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Monthly Salary And Attendance Report </p>
                                               </a>
                                         </li>
                                         <li class="nav-item">
                                               <a href="{{ route('employee.monthly.deduction.filter') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>E. Monthly Deduction Report </p>
                                               </a>
                                         </li>
                                         <li class="nav-item">
                                               <a href="{{ route('employee.salary.certificate.form') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>E. Salary Certificate </p>
                                               </a>
                                         </li>
                                       </ul>
                                   </li>
                                   @endif


                                   @if (in_array('scalerm', $settingsdata))
                                   <li class="nav-item">
                                       <a href="#" class="nav-link">
                                           <i class="fas fa-university"></i>
                                           <p>
                                               Scale (Row Materials)
                                               <i class="fas fa-angle-left right"></i>
                                           </p>
                                       </a>
                                       <ul class="nav nav-treeview">

                                           <li class="nav-item">
                                               <a href="{{ URL('row/materials/scale/index') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Scale List</p>
                                               </a>
                                           </li>

                                           <li class="nav-item">
                                               <a href="{{ URL('row/materials/scale/entry') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Scale Entry </p>
                                               </a>
                                           </li>
                                           <li class="nav-item">
                                               <a href="{{ URL('row/materials/scale/summary') }}" class="nav-link">
                                                   <i class="far fa-list-alt"></i>
                                                   <p>Scale Summary </p>
                                               </a>
                                           </li>

                                       </ul>
                                   </li>



                                   @endif

                    	<li class="nav-item">
                                       <a href="#" class="nav-link">
                                           <i class="fas fa-university"></i>
                                           <p>
                                               Archive
                                               <i class="fas fa-angle-left right"></i>
                                           </p>
                                       </a>
                                       <ul class="nav nav-treeview">
                                           <li class="nav-item">
                                               <a href="{{ route('dealer.archive.log') }}" class="nav-link">
                                                   <i class="far fa-edit"></i>
                                                   <p>Dealer Archive List</p>
                                               </a>
                                           </li>
                                            <li class="nav-item">
                                               <a href="{{ route('reminder.archive.list') }}" class="nav-link">
                                                   <i class="far fa-edit"></i>
                                                   <p>Notification Archive List</p>
                                               </a>
                                           </li>

                                       </ul>
                                   </li>

									<li class="nav-item">
                                       <a href="{{route('gallery')}}" class="nav-link">
                                           <i class="fas fa-image"></i>
                                           <p>
                                               Gallery
                                           </p>
                                       </a>
                   				</li>

								                  <li class="nav-item">
                                       <a href="{{route('invoiceBillList')}}" class="nav-link">
                                           <i class="fas fa-file-invoice"></i>
                                           <p>
                                               Invoice Bill
                                           </p>
                                       </a>
                   				              </li>
								                  <li class="nav-item">
                                       <a href="#" class="nav-link">
                                           <i class="fas fa-file-alt"></i>
                                           <p> Requisition </p>
                                       </a>
                                       <ul class="nav nav-treeview">
                                           <li class="nav-item">
                                               <a href="{{route('user.multiFunction.requisition.list')}}" class="nav-link">
                                                   <i class="fas fa-envelope"></i>
                                                   <p> Requisition List</p>
                                               </a>
                                           </li>
                                           <li class="nav-item">
                                               <a href="{{route('user.multiFunction.requisition.create')}}" class="nav-link">
                                                   <i class="fa fa-edit"></i>
                                                   <p> Create Requisition </p>
                                               </a>
                                           </li>
                                         </ul>
                   				              </li>

                                   @if (in_array('usersetting', $settingsdata))
                                   <li class="nav-item">
                                       <a href="#" class="nav-link">
                                           <i class="fas fa-users"></i>
                                           <p>
                                               User Settings

                                           </p>
                                       </a>
                                       <ul class="nav nav-treeview">
                                           <li class="nav-item">
                                               <a href="{{ URL('user/setting/list') }}" class="nav-link">
                                                   <i class="fas fa-users"></i>
                                                   <p>
                                                       User List
                                                   </p>
                                               </a>
                                           </li>

                                           <li class="nav-item">
                                               <a href="{{ URL('user/setting/create') }}" class="nav-link">
                                                   <i class="fas fa-user"></i>
                                                   <p>
                                                       Create User
                                                   </p>
                                               </a>
                                           </li>
                                           <li class="nav-item">
                                               <a href="{{ route('user.approve.checkBox.index') }}" class="nav-link">
                                                   <i class="fas fa-edit"></i>
                                                   <p>
                                                       Requisition CheckBox Items
                                                   </p>
                                               </a>
                                           </li>

                                         {{--  <li class="nav-item">
                                               <a href="{{ URL('user/notification') }}" class="nav-link">
                                                   <i class="fas fa-shopping-bag"></i>
                                                   <p>
                                                      Notification
                                                   </p>
                                               </a>
                                           </li>  --}}






                                       </ul>
                                   </li>

                                   @endif



                               </ul>

               </nav>
               <!-- /.sidebar-menu -->
           </div>
   <!-- /.sidebar -->
        </aside>

        @yield('content')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
      @include('_partials_.notification_modal')

        @include('_partials_.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

 <script>

      $(document).ready(function() {
			$('.settingsclickable').trigger('click');
        });
  </script>

    @include('_partials_.js')






</body>

</html>
