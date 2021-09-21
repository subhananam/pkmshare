<!doctype html>
<html lang="en">


<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/pages/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2017 21:32:19 GMT -->

<head>
    <title>@yield('title') | PKM Apps</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="{{ asset('vendor/material-dashboard-pro-master/assets/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/material-dashboard-pro-master/assets/css/google-roboto-300-700.css') }}" />
</head>

<body>
    <nav class="navbar navbar-primary navbar-transparent navbar-absolute">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">PKM Apps</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class=" ">
                        <a href="/">
                            <i class="material-icons">dashboard</i> Home
                        </a>
                    </li>
                    @guest
                    <li class="@yield('login_active')">
                        <a href="{{ route('login') }}">
                            <i class="material-icons">fingerprint</i> Login
                        </a>
                    </li>
                    @if (Route::has('register'))
                    <li class="@yield('register_active')">
                        <a href="{{ route('register') }}">
                            <i class="material-icons">person_add</i> Register
                        </a>
                    </li>
                    @endif
                    @else
                    <li class="">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="material-icons">lock_open</i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" data-image="{{ asset('vendor/material-dashboard-pro-master/assets/img/login.jpg') }}">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                            <!-- <form method="#" action="#"> -->
                                <div class="card card-login card-hidden">
                                    <div class="card-header text-center" data-background-color="rose">
                                        <h4 class="card-title">@yield('title')</h4>
                                    </div>
                                    <div class="card-content">
                                        @yield('content')
                                    </div>
                                </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container">
                    <nav class="pull-left">
                        <ul>
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Portfolio
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="http://www.creative-tim.com/">Creative Tim</a>, made with love for a better web
                    </p>
                </div>
            </footer>
        </div>
    </div>
</body>
</body>
<!--   JS Files   -->
<script src="{{ asset('js/login.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $().ready(function() {
        demo.checkFullPageBackgroundImage();
        //demo.initFormExtendedDatetimepickers();
        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>


<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/pages/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2017 21:32:19 GMT -->

</html>