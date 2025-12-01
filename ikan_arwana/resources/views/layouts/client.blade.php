<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Ikan Arwana') }}</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2563eb', // Blue 600
                        secondary: '#0ea5e9', // Sky 500
                        dark: '#0f172a', // Slate 900
                    }
                }
            }
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        /* Page Transition */
        .page-animate {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <div class="flex min-h-screen">
        <!-- SIDEBAR (Only for Pemilik & Staff) -->
        @auth
            @if(Auth::user()->role == 'pemilik')
                @include('partials.sidebar-pemilik', ['fixedOnDesktop' => false])
            @elseif(Auth::user()->role == 'staff')
                @include('partials.sidebar-staff', ['fixedOnDesktop' => false])
            @endif
        @endauth

        <!-- MAIN CONTENT WRAPPER -->
        <div class="flex-1 flex flex-col w-full transition-all duration-300">

    <!-- NAVBAR -->
    <nav class="fixed z-50 transition-all duration-500 ease-in-out top-0 w-full" id="navbar">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 transition-all duration-300" id="navbar-container">
                <div class="flex items-center gap-3">
                    <!-- Sidebar Toggle (Only for Pemilik & Staff) -->
                    @auth
                        @if(Auth::user()->role == 'pemilik' || Auth::user()->role == 'staff')
                            <button id="sidebar-toggle-btn" class="w-10 h-10 rounded-xl bg-white/50 hover:bg-white text-slate-700 hover:text-primary flex items-center justify-center transition shadow-sm backdrop-blur-sm border border-slate-100">
                                <i class="fa-solid fa-bars text-lg"></i>
                            </button>
                        @endif
                    @endauth

                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                    <span class="font-bold text-xl tracking-tight text-slate-900">NourAlra</span>
                </div>

                @php
                    $cartCount = count(session('cart', []));
                    $activeOrders = 0;
                    if(Auth::check()) {
                        $activeOrders = \App\Models\Order::where('user_id', Auth::id())
                            ->whereIn('status', ['pending', 'processing', 'shipped'])
                            ->count();
                    }
                @endphp

                <div class="hidden md:flex items-center gap-8 font-medium text-slate-600">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary transition">Beranda</a>
                    <a href="{{ route('cart.index') }}" class="hover:text-primary transition flex items-center gap-2">
                        <i class="fa-solid fa-cart-shopping"></i>
                        Keranjang
                        @if($cartCount > 0)
                            <span class="bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('client.orders.index') }}" class="hover:text-primary transition flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-list"></i>
                        Pesanan Saya
                        @auth
                            @if($activeOrders > 0)
                                <span class="bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $activeOrders }}</span>
                            @endif
                        @endauth
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <div class="relative group hidden md:block">
                            <button class="flex items-center gap-2 px-4 py-2 rounded-full hover:bg-slate-100 transition">
                                <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden md:block font-medium text-slate-700">{{ Auth::user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                            </button>
                            <!-- Dropdown -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 border border-slate-100 hidden group-hover:block">
                                @if(Auth::user()->role == 'pemilik')
                                    <a href="{{ route('pemilik.dashboard') }}" class="block px-4 py-2 hover:bg-slate-50 text-slate-700">
                                        <i class="fa-solid fa-gauge-high w-5"></i> Dashboard
                                    </a>
                                @elseif(Auth::user()->role == 'staff')
                                    <a href="{{ route('staff.dashboard') }}" class="block px-4 py-2 hover:bg-slate-50 text-slate-700">
                                        <i class="fa-solid fa-gauge-high w-5"></i> Dashboard
                                    </a>
                                @endif

                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-slate-50 text-slate-700">
                                    <i class="fa-regular fa-user w-5"></i> Profil Saya
                                </a>
                                <a href="{{ route('client.orders.index') }}" class="block px-4 py-2 hover:bg-slate-50 text-slate-700 flex items-center justify-between">
                                    <span><i class="fa-regular fa-clipboard w-5"></i> Pesanan Saya</span>
                                    @if($activeOrders > 0)
                                        <span class="bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $activeOrders }}</span>
                                    @endif
                                </a>
                                <div class="border-t border-slate-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                        <i class="fa-solid fa-right-from-bracket w-5"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hidden md:block text-slate-600 hover:text-primary font-medium transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-primary text-white rounded-full font-medium hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
                            Daftar Sekarang
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden text-slate-600 hover:text-primary focus:outline-none relative">
                        <i class="fa-solid fa-bars text-2xl"></i>
                        @if($cartCount > 0 || $activeOrders > 0)
                            <span class="absolute -top-1 -right-1 block h-3 w-3 rounded-full ring-2 ring-white bg-red-600"></span>
                        @endif
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white/95 backdrop-blur-md border-t border-slate-100 absolute w-full left-0 top-full shadow-lg rounded-b-2xl">
            <div class="px-6 py-4 space-y-4 flex flex-col">
                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-primary transition">Beranda</a>
                <a href="{{ route('cart.index') }}" class="text-sm font-semibold text-slate-600 hover:text-primary transition flex items-center justify-between">
                    <span>Keranjang</span>
                    @if($cartCount > 0)
                        <span class="bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $cartCount }}</span>
                    @endif
                </a>
                <a href="{{ route('client.orders.index') }}" class="text-sm font-semibold text-slate-600 hover:text-primary transition flex items-center justify-between">
                    <span>Pesanan Saya</span>
                    @auth
                        @if($activeOrders > 0)
                            <span class="bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $activeOrders }}</span>
                        @endif
                    @endauth
                </a>
                
                <div class="border-t border-slate-100 my-2"></div>
                
                @auth
                    <div class="flex items-center gap-3 py-2">
                        <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="font-medium text-slate-700">{{ Auth::user()->name }}</span>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="text-sm font-semibold text-slate-600 hover:text-primary transition block py-1">Profil Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm font-bold text-red-600 hover:text-red-700 transition w-full text-left py-1">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-900 hover:text-primary transition text-center py-2">Masuk</a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-full hover:bg-primaryDark transition shadow-lg shadow-blue-500/30 text-center">
                        Daftar Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <script>
        const navbar = document.getElementById('navbar');
        const navbarContainer = document.getElementById('navbar-container');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        // Scroll Effect
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                // Scrolled State (Floating Glass)
                navbar.classList.add('bg-white/80', 'backdrop-blur-lg', 'shadow-lg', 'top-4', 'mx-4', 'rounded-full', 'max-w-7xl', 'left-0', 'right-0', 'mx-auto');
                navbar.classList.remove('w-full');
                navbarContainer.classList.remove('h-20');
                navbarContainer.classList.add('h-16'); // Smaller height
            } else {
                // Top State (Transparent)
                navbar.classList.remove('bg-white/80', 'backdrop-blur-lg', 'shadow-lg', 'top-4', 'mx-4', 'rounded-full', 'max-w-7xl', 'left-0', 'right-0', 'mx-auto');
                navbar.classList.add('w-full');
                navbarContainer.classList.add('h-20');
                navbarContainer.classList.remove('h-16');
            }
        });

        // Mobile Menu Toggle
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Sidebar Toggle Logic (For Pemilik & Staff)
        const sidebar = document.getElementById('sidebar');
        const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
        const mainContentWrapper = document.querySelector('.flex-1.flex.flex-col'); // Select the wrapper

        if (sidebar && sidebarToggleBtn) {
            sidebarToggleBtn.addEventListener('click', () => {
                // Toggle Sidebar Visibility (Overlay Mode)
                sidebar.classList.toggle('-translate-x-full');
            });
            
            // Close sidebar when clicking outside (optional but good for UX)
            document.addEventListener('click', (e) => {
                if (!sidebar.contains(e.target) && !sidebarToggleBtn.contains(e.target) && !sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        }
    </script>

    <!-- MAIN CONTENT -->
    <main class="min-h-screen pt-20 pb-12 page-animate">
        {{ $slot }}
    </main>

    <!-- FOOTER (Matching welcome.blade.php) -->
    <footer class="bg-dark text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                        <span class="font-bold text-xl">NourAlra</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Platform budidaya ikan arwana modern dengan teknologi terkini untuk hasil maksimal.
                    </p>
                </div>

                <div>
                    <h5 class="font-bold mb-4">Navigasi</h5>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('dashboard') }}" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-bold mb-4">Layanan</h5>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-white transition">Bantuan</a></li>
                        <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-white transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-bold mb-4">Ikuti Kami</h5>
                    <div class="flex gap-3 mb-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-primary flex items-center justify-center transition">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-primary flex items-center justify-center transition">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-primary flex items-center justify-center transition">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-700 pt-8 text-center text-sm text-slate-400">
                &copy; {{ date('Y') }} NourAlra. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Auto-inject AOS to main children
        document.addEventListener('DOMContentLoaded', function() {
            const mainContent = document.querySelector('main');
            if (mainContent) {
                // Add fade-up to direct children of main
                Array.from(mainContent.children).forEach((child, index) => {
                    if (!child.hasAttribute('data-aos')) {
                        child.setAttribute('data-aos', 'fade-up');
                        child.setAttribute('data-aos-delay', (index * 100).toString());
                    }
                });
            }
            
            AOS.init({
                duration: 800,
                once: true,
                offset: 50,
            });
        });
    </script>
    @stack('scripts')
    </div> <!-- End Main Content Wrapper -->
</body>
</html>
