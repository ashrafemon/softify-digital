<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">

            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand" href="{{route('home')}}">
                <!-- Logo icon -->
                <b class="logo-icon ps-2">
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="{{asset('assets/admin/images/logo-icon.png')}}" alt="homepage" class="light-logo"/>

                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="{{asset('assets/admin/images/logo-text.png')}}" alt="homepage"
                                 class="light-logo"/>
                        </span>

            </a>

            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">

            <ul class="navbar-nav float-start me-auto">
                <li class="nav-item d-none d-lg-block"><a
                        class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                        data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
            </ul>

            <ul class="navbar-nav float-end">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="#"
                       id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{asset('assets/admin/images/users/1.jpg')}}" alt="user" class="rounded-circle"
                             width="31">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" id="logoutBtn" href="javascript:void(0)"><i
                                class="fa fa-power-off me-1 ms-1"></i> Logout</a>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

@push('custom-js')
    <script>
        $('#logoutBtn').click(function () {
            $.ajax({
                url: '{{url('/api/auth/logout')}}',
                method: 'POST',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Accept', 'application/json');
                    xhr.setRequestHeader('Authorization', localStorage.getItem('authToken'));
                },
                success: function (res) {
                    console.log(res)
                    if (res.status === 'done') {
                        localStorage.removeItem('authToken')
                        window.location.href = "{{route('home')}}"
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })
        })
    </script>
@endpush
