<nav class="navbar navbar-light bg-white shadow-sm navbar-expand-md">
    <div class="container">
        <a href="{{route('home')}}" class="navbar-brand">
            <img src="{{asset('assets/client/images/logo.png')}}" alt="Logo"/>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#cartOrderMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="cartOrderMenu">
            <ul class="navbar-nav ml-auto" id="mainMenu">
                {{--                <li class="nav-item">--}}
                {{--                    <a href="{{route('carts')}}" class="nav-link">--}}
                {{--                        <i class="fas fa-shopping-cart"></i> <span id="cartLink" class="badge badge-secondary">0</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}
                <li class="nav-item guestLinks">
                    <a href="{{route('login')}}" class="nav-link">Login</a>
                </li>
                <li class="nav-item guestLinks">
                    <a href="{{route('register')}}" class="nav-link">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@push('custom-js')
    <script>
        fetchMe()
        fetchCarts()
    </script>
@endpush
