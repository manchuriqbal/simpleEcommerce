<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="{{ route('home') }}">Simple Ecommarce</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">All Products</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                        <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                    </ul>
                </li>
            </ul>
            @if (!auth()->check())
                <div class="menu-btn  me-2">
                    <a class="btn  btn-outline-dark" href="{{ route('login') }}">Login</a>
                </div>
                <div class="menu-btn me-2">
                    <a class="btn btn-outline-dark" href="{{ route('register') }}">Registation</a>
                </div>
            @else

                <form action="{{ route('logout') }}" method="POST" class="d-inline me-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-dark">Logout</button>
                </form>

                <div class="menu-btn me-2">
                    <a class="btn btn-outline-dark" href=""><i class="bi bi-person"></i>{{auth()->user()->name}}</a>
                </div>
            @endif
            <form class="d-flex">
                <a href="{{ route('cart') }}" class="btn btn-outline-dark">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill">{{$cartCount}}</span>
                </a>
            </form>
        </div>
    </div>
</nav>