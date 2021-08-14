<div class="aside-inner">
    <nav class="sidebar" data-sidebar-anyclick-close="">
        <!-- START sidebar nav-->
        <ul class="sidebar-nav">
            <!-- START user info-->
            <li class="has-user-block">
                <div class="collapse" id="user-block">
                    <div class="item user-block">
                        <!-- User picture-->
                        <div class="user-block-picture">
                            <div class="user-block-status">
                                <img class="img-thumbnail rounded-circle" src="{{asset('theme-angle/img/admin.png')}}" alt="Avatar" width="60" height="60">
                                <div class="circle bg-success circle-lg"></div>
                            </div>
                        </div>
                        <!-- Name and Job-->
                        <div class="user-block-info">
                            <span class="user-block-name">Hello, Admin</span>
                            {{--<span class="user-block-role">Designer</span>--}}
                        </div>
                    </div>
                </div>
            </li>
            <!-- END user info-->
            <!-- Iterates over all sidebar items-->
            <li class="nav-heading ">
                <span data-localize="sidebar.heading.HEADER">Main Navigation</span>
            </li>
            <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{route('admin.dashboard')}}" title="Dashboard" >
                    {{-- <div class="float-right badge badge-success">3</div>--}}
                    <em class="icon-speedometer"></em>
                    <span>Dashboard</span>
                </a>

            </li>
            <li class="@if(Request::path() === 'admin/registrations') active @endif">
                <a href="{{url('admin/registrations')}}" title="Registrations">
                    <em class="fa fa-users"></em>
                    <span >Registrations</span>
                </a>
            </li>

            <li class="@if(Request::path() === 'admin/contactus_queries') active @endif">
                <a href="{{route('contactus_queries.contactus_query.index')}}" title="Posts">
                    <em class="fa fa-newspaper-o"></em>
                    <span >Queries</span>
                </a>
            </li>

            <li class="@if(Request::path() === 'admin/reset-password') active @endif">
                <a href="{{route('admin.resetpassword')}}" title="Posts">
                    <em class="fa fa-lock"></em>
                    <span >Reset Password</span>
                </a>
            </li>
            <li class=" ">
                <a href="{{route('admin.logout')}}" title="Logout">
                    <em class="icon-logout"></em>
                    <span >Logout</span>
                </a>
            </li>
        </ul>
        <!-- END sidebar nav-->
    </nav>
</div>