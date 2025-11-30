<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemilik Dashboard - {{ config('app.name') }}</title>

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        
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

    <div class="flex h-screen overflow-hidden">
        
        <!-- OVERLAY (Mobile) -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity opacity-0"></div>

        <!-- SIDEBAR -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white border-r border-slate-200 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50 md:static md:flex flex-col">
            <!-- Logo -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <span class="font-bold text-lg text-slate-900">Ikan Arwana</span>
                </div>
                <!-- Close Button (Mobile) -->
                <button id="sidebar-close" class="md:hidden text-slate-500 hover:text-red-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- User Info -->
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-primary font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-900">{{ Auth::user()->name }}</h4>
                        <p class="text-xs text-slate-500">Pemilik</p>
                    </div>
                </div>
            </div>

            <!-- Menu -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                <a href="{{ route('pemilik.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                          {{ request()->routeIs('pemilik.dashboard') ? 'bg-primary text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }}">
                    <i class="fa-solid fa-gauge-high w-5"></i> Dashboard
                </a>
                
                <a href="{{ route('pemilik.kolam') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                          {{ request()->routeIs('pemilik.kolam') ? 'bg-primary text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }}">
                    <i class="fa-solid fa-water w-5"></i> Manajemen Kolam
                </a>

                <a href="{{ route('monitoring.air') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                          {{ request()->routeIs('monitoring.air') ? 'bg-primary text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }}">
                    <i class="fa-solid fa-droplet w-5"></i> Monitoring Air
                </a>

                <a href="{{ route('manajemen.pakan.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                          {{ request()->routeIs('manajemen.pakan.index') ? 'bg-primary text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }}">
                    <i class="fa-solid fa-bowl-food w-5"></i> Manajemen Pakan
                </a>

                <a href="{{ route('pemilik.pesanan.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                          {{ request()->routeIs('pemilik.pesanan.*') ? 'bg-primary text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }}">
                    <i class="fa-solid fa-clipboard-check w-5"></i> Kelola Pesanan
                </a>

                <a href="{{ route('pemilik.product.list') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                          {{ request()->routeIs('pemilik.product.list') ? 'bg-primary text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }}">
                    <i class="fa-solid fa-box-open w-5"></i> Manajemen Produk
                </a>

                <a href="{{ route('pemilik.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                          {{ request()->routeIs('pemilik.users.*') ? 'bg-primary text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }}">
                    <i class="fa-solid fa-users w-5"></i> Manajemen Users
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex items-center gap-3 px-4 py-3 w-full rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition">
                        <i class="fa-solid fa-right-from-bracket w-5"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Topbar Mobile -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 md:hidden">
                <div class="font-bold text-lg text-slate-900">Ikan Arwana</div>
                <button id="sidebar-toggle" class="text-slate-600"><i class="fa-solid fa-bars text-xl"></i></button>
            </header>

            <!-- Content Scrollable -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8 page-animate">
                @yield('content')
            </main>
        </div>

    </div>

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

        // Sidebar Toggle Logic
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarClose = document.getElementById('sidebar-close');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
            setTimeout(() => {
                sidebarOverlay.classList.toggle('opacity-0');
            }, 10);
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }

        if (sidebarClose) {
            sidebarClose.addEventListener('click', toggleSidebar);
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', toggleSidebar);
        }
    </script>
    @stack('scripts')
</body>
</html>
