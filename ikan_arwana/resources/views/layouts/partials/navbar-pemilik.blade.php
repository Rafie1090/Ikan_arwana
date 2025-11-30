<nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 mb-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-4" href="/">
            Ikan Arwana
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

    
                {{-- CART UNTUK CLIENT --}}
                @if(Auth::check() && Auth::user()->role == 'client')
                    @php $cartCount = count(session('cart', [])); @endphp
                    <li class="nav-item">
                        <a href="{{ route('cart.index') }}" class="btn position-relative">
                            <span class="fs-4">🛒</span>
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>
                @endif

                {{-- DASHBOARD LINK --}}
                @auth
                 
                    {{-- PROFILE --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center"
                           href="#" data-bs-toggle="dropdown">

                            <div class="rounded-circle bg-primary text-white d-flex justify-content-center
                                        align-items-center shadow-sm"
                                 style="width:42px; height:42px; font-size:18px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                        </a>

                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                            <li class="px-3 py-2">
                                <div class="fw-semibold">{{ Auth::user()->name }}</div>
                                <div class="small text-muted">{{ Auth::user()->email }}</div>
                            </li>

                            <li><hr></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger fw-semibold">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                @endauth

            </ul>
        </div>
    </div>
</nav>
