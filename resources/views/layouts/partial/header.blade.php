<header class="main-header">

    <!-- Logo -->
    <a href="{{route('home')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>S</b>AM</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            <b>{{config('developer.appname_'.App::getLocale())}}</b>
        </span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        @php
            $siteName = app()->getLocale()=='ar'?$settings['SiteName']:$settings['SiteName_en'];
        @endphp
        <h4 class="inline" style="color: white; position: relative;top: 14px;">{{strip_tags($siteName)}}</h4>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown messages-menu">
                    <a href="{{route('changeLang',App::getLocale()=='ar'?'en':'ar')}}">
                        <i class="fa fa-globe"></i>
                        <span class="label label-success">{{App::getLocale()=='ar'?'EN':'العربية'}}</span>
                    </a>
                </li>
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-gg"></i>
                        <span class="label label-success">{{currency()->getCurrency()['symbol']??''}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <ul class="menu">
                                @foreach(currency()->getActiveCurrencies() as $currency)
                                    <li>
                                        <a href="{{request()->fullUrl()}}{{strpos(request()->fullUrl(),'?')?'&currency=':'?currency='}}{{$currency['code']}}">
                                            {{$currency['name']}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>
                {!! $notifications !!}
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img style="margin-left: 5px;" src="{{optional(auth()->user()->getFirstMedia('photo'))->getUrl()??asset('defaut.jpg')}}" class="user-image" alt="User Image">
                        <span class="hidden-xs"> {{auth()->user()->name}} </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{optional(auth()->user()->getFirstMedia('photo'))->getUrl()??asset('defaut.jpg')}}" class="img-circle" alt="User Image">

                            <p>
                                {{auth()->user()->name}}
                                <small>@lang('front.member since') {{auth()->user()->created_at->format('d-m-Y') }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                @if(auth()->user()->can('edit UsersController'))
                                    <a data-toggle="modal" data-target="#addPersonModal" href="{{ route('users.edit', auth()->user()->id) }}"
                                    class="btn btn-default btn-flat">
                                        <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                        <span class="hidden-xs">@lang('front.Profile')</span>
                                    </a>
                                @endif
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-danger btn-flat" title="@lang('front.signout')" href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                    @lang('front.signout')
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="javascript:void(0)" onclick="window.location.reload()">
                        <i class="fa fa-refresh"></i>
                    </a>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="javascript:void(0)" onclick="history.forward()">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="javascript:void(0)" onclick="history.back()">
                        <i class="fa  fa-arrow-left"></i>
                    </a>
                </li>
            </ul>
        </div>

    </nav>
</header>
