
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <div class="container">


        <ul class="navbar-nav" style="z-index: 9999999;">
            @yield('headernavmanuname')
            <li class="nav-item">
                <a class="nav-link" id="pushnavbar" data-widget="pushmenu" href="#" role="button"><i
                        class="fas fa-bars"></i></a>
            </li>
            {{-- <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ URL('/') }}" class="nav-link">Home</a>
        </li> --}}
            @yield('header_menu')
        </ul>
        <ul class="navbar-nav hovermanue_icon">
            <li class="nav-item hovermanu">
                <a class="nav-link text-white" href="#">
                    <small>Click Here <i class="fas fa-hand-point-down"></i></small>
                </a>

            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav" style="z-index: 9999999;">


            @yield('print_menu')




           {{-- <li class="nav-item">
                <a class="nav-link text-white" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li> --}}


            <!-- Navbar Search
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li> -->

            @php
                $authid = Auth::id();

                $messages = DB::table('messagings')
                    ->where('to_user', $authid)
                    ->where('status', 2)
                    ->orderby('id', 'desc')
                    ->get();
               /* $messagescount = DB::table('messagings')
                    ->where('to_user', $authid)
                    ->where('status', 2)
                    ->count(); */

              $messagescount =  DB::table('requisitions')->leftJoin('requisition_users', 'requisitions.id', '=', 'requisition_users.requisition_id')
          						->where('requisition_users.to_user_id', $authid)->where('requisitions.status',0)
                            	->count();
              $receiveMessagesCount =  DB::table('requisition_users')->where('requisition_users.to_user_id', $authid)->where('requisition_users.status',11)->count();

            @endphp

            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">{{ $messagescount + $receiveMessagesCount }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                   <a href="{{ route('user.chat.create') }}" class="dropdown-item">

                        <span class="dropdown-item dropdown-header"><i class="fas fa-plus-circle mt-1"></i> New
                            Massage</span>
                    </a>
                    <div class="dropdown-divider"></div>

                    @foreach ($messages as $item)
                        @php
                            $fuser = DB::table('users')
                                ->where('id', $item->from_user)
                                ->value('name');
                        @endphp
                        <form id="my_form_{{ $item->id }}" action="{{ route('user.chat.seen') }}" method="post">
                            @csrf
                            <a href="javascript:{}"
                                onclick="document.getElementById('my_form_{{ $item->id }}').submit();"
                                class="dropdown-item">
                                <!-- Message Start -->
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <div class="media">

                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            {{ $fuser }}
                                            <span class="float-right text-sm text-warning"><i
                                                    class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">{{ $item->subject }}</p>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>
                                            {{ \Carbon\Carbon::createFromTimeStamp(strtotime($item->created_at))->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                        </form>
                    @endforeach
                    <div class="dropdown-divider"></div>

                  <a href="{{ route('user.chat.list') }}" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            <!-- Notifications Dropdown Menu -->

            @php

                $thistimedata = date('Y-m-d');
                $uid = Auth::id();

                $salesdata = DB::table('permissions')
                    ->where('head', 'Sales')
                    ->where('user_id', $authid)
                    ->pluck('name')
                    ->toArray();

                $orders = 0;
                $orderstime = '';

                if (in_array('order', $salesdata)) {
                    $orders = DB::table('sales_orders')
          				->where('is_active', 1)
                        ->where('order_status', 0)
                        ->count();
                    $orderstime = DB::table('sales_orders')
                        ->where('is_active', 1)
                        ->where('order_status', 0)
                        ->orderby('id', 'desc')
                        ->first();
                }
                $invoicepayment = DB::table('sales')
                    ->leftJoin('dealers', 'sales.dealer_id', '=', 'dealers.id')
                    ->where('is_active', 1)
                    ->where('payment_status', 1)
                    ->where('payment_date', '<=', $thistimedata)
                    ->get();

                 /* $invoiceDue = DB::table('payments')->select('payments.invoice')
                    ->leftJoin('sales_ledgers', 'payments.invoice', '=', 'sales_ledgers.invoice')
                    ->where('payments.payment_type','RECEIVE')->where('payments.status',1)->where('payment_date','2023-05-30')
                    ->whereNotIn('payments.amount', 'sales_ledgers.credit')->get(); */

                  $invoiceDue = DB::table('payments')->select('payments.invoice','payments.amount')
                   			 	->where('payments.payment_type','RECEIVE')->where('payments.status',1)->where('payment_date','2023-05-30')
                    			->whereNotNull('payments.amount')->get();

               // $invn = count($invoicepayment);
                $invn = 0;

                $today = date('Y-m-d');

                $reminders = DB::table('new_reminders')
                    ->select('new_reminders.*', 'dealers.d_s_name')
                    ->leftJoin('dealers', 'new_reminders.vendor_id', '=', 'dealers.id')
                  ->where('status',1)
                    ->where('date',  '<=', $thistimedata)
                    ->get();
                $totalreminder = count($reminders);
                //    dd($invn);
            @endphp


            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">{{ $orders + $invn }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                      @php
                  $datas = \App\Models\MarketingOrderItem::select('id','invoice')->where('user_id',Auth::id())->where('qcStatus',1)->where('marketing_order_items.status','!=',100)->orderby('invoice','desc')->get();
                  @endphp
                  <span class="dropdown-item dropdown-header Text-warning">  QC-Notifications</span>
                  <div class="">
                    @foreach($datas as $val)
                      <a href="{{route('marketingOrder.item.View',$val->invoice)}}" class="dropdown-item dropdown-footer"> {{$val->invoice}} - See Now</a>
                    @endforeach
                  </div>
                  @php
                  $datas = \App\Models\MarketingOrderItem::select('id','invoice')->where('user_id',Auth::id())->where('purchaseOrderStatus',1)->where('marketing_order_items.status','!=',100)->orderby('invoice','desc')->get();
                  @endphp
                  <span class="dropdown-item dropdown-header Text-warning">  PO-Notifications</span>
                  <div class="">
                    @foreach($datas as $val)
                      <a href="{{route('marketingOrder.item.View',$val->invoice)}}" class="dropdown-item dropdown-footer"> {{$val->invoice}} - See Now</a>
                    @endforeach
                  </div>

                  @php
                  $datas = \App\Models\MarketingOrderItem::select('id','invoice')->where('approved_by',Auth::id())->where('marketing_order_items.status','!=',100)->orderby('invoice','desc')->get();
                  @endphp
                  <span class="dropdown-item dropdown-header Text-warning">  MTO-Notifications</span>
                  <div class="">
                    @foreach($datas as $val)
                      <a href="{{route('marketingOrder.item.invoiceView',$val->id)}}" class="dropdown-item dropdown-footer"> {{$val->invoice}} - See Now</a>
                    @endforeach
                  </div>
                    <span class="dropdown-item dropdown-header">{{ $orders + $invn }} Notifications</span>
                    <div class="dropdown-divider"></div>
                    @if ($orders != 0)
                        <a href="{{ URL('/sales/order/list') }}" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i>{{ $orders }} order pending
                            <span
                                class="float-right text-muted text-sm">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($orderstime->updated_at))->diffForHumans() }}</span>
                        </a>
                    @endif
                  {{--  @if ($uid == 101)

                        @foreach ($invoicepayment as $data)
                            <!-- Message -->
                            <a href="{{ url('/sales/payment/date/') }}/{{ $data->invoice_no }}"
                                class="dropdown-item">
                                <div class="mail-contnet">
                                    <h6 style="color:black">{{ $data->d_s_name }} ({{ $data->payment_date }})</h6>
                                    <span class="mail-desc"
                                        style="color:black; font-size:20px;font-weight:bold">{{ $data->grand_total }}
                                        <button style="float: right;" class="btn btn-sm btn-dark">OK</button></span>
                                </div>
                            </a>
                        @endforeach
                    @endif  --}}

                    <div class="dropdown-divider"></div>
                    {{-- <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a> --}}
                   <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item dropdown-footer">See All Due Receive Invoice</a>
                  @if(!empty($invoiceDue))
                    @foreach($invoiceDue as $val)
                  		@php
                  			$invoice = DB::table('sales_ledgers')->where('invoice',$val->invoice)->whereNotIn('credit',[$val->amount])->first();
                  		@endphp
                  @if(empty($invoice))
                      <a href="{{ URL::to('/bank/receive/edit/' . $val->invoice) }}" class="dropdown-item dropdown-footer">{{$val->invoice}} - Update Now</a>
                  @endif
                    @endforeach
                  @endif
                </div>
            </li>

            {{-- Reminder --}}
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-stopwatch"></i>
                    <span class="badge badge-warning navbar-badge">{{ $totalreminder }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">{{ $totalreminder }} Reminders</span>
                    <div class="dropdown-divider"></div>

                    @if ($totalreminder != 0)

                        @foreach ($reminders as $rmndr)
                            <!-- Message -->
                            <a href="{{ url('/delete/reminder/'.$rmndr->id) }}/" class="dropdown-item">
                                <div class="mail-contnet">
                                    <h6 style="color:black">{{ $rmndr->subject }} <span class="bg-danger text-light px-2 py-1 rounded">Ok</span></h6>
                                    <span class="mail-desc"
                                        style="color:black; font-size:16px;font-weight:bold">{{ $rmndr->d_s_name }}
                                       {{-- <button style="float: right;" class="btn btn-sm btn-dark">OK</button></span> --}}
                                </div>
                            </a>
                        @endforeach
                    @endif

                    <div class="dropdown-divider"></div>
                    <div class="dropdown-divider"></div>
                    <a href="{{route('create.reminder')}}" class="dropdown-item dropdown-footer"><i class="fas fa-plus-circle"></i> Add Reminder</a>
                </div>
            </li>

            <li class="nav-item dropdown controlsidebar">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-th-large"></i>
                </a>
                @php
                    $user = Auth::id();

                    $thememood = DB::table('theme_moods')
                        ->where('user_id', $user)
                        ->value('mood');
                @endphp
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                      <form action="{{ route('user.theme.mood') }}" method="post">
                        @csrf

                        <div class="px-4">
                            <span class="dropdown-item dropdown-header">Select Mood</span>
                            <div class="dropdown-divider"></div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="defaultmood"
                                    @if ($thememood == 'defaultmood') checked @endif value="defaultmood">
                                <label class="form-check-label" for="defaultmood">
                                    Default Mood
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmood"
                                    @if ($thememood == 'lightmood' || $thememood == '') checked @endif value="lightmood">
                                <label class="form-check-label" for="lightmood">
                                    Light Mood
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmood"
                                    @if ($thememood == 'darkmood') checked @endif value="darkmood">
                                <label class="form-check-label" for="darkmood">
                                    Dark Mood
                                </label>
                            </div>

                            <button type="submit" class="dropdown-item dropdown-footer"> <span
                                    class="btn btn-sm btn-primary">Save</span></button>
                        </div>
                    </form>
                </div>

            </li>




            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset('public/backend/dist/img/avatar5.png') }}"
                        class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="{{ asset('public/backend/dist/img/avatar5.png') }}" class="img-circle elevation-2"
                            alt="User Image">

                        <p>
                            {{ Auth::user()->name }}
                            <small>Member since {{ date('F Y', strtotime(Auth::user()->created_at)) }}</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                        <div class="row">
                            <div class="col-4 text-center">
                            </div>
                            <div class="col-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-4 text-center">
                            </div>
                        </div>
                        <!-- /.row -->
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="{{ URL('/company/profile') }}" class="btn btn-default btn-flat">Profile</a>
                        <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">

                            Sign out
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>





            <!--   <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>  -->
        </ul>



    </div>

</nav>
