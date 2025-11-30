        @php $isFixed = $fixedOnDesktop ?? true; @endphp
        <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white border-r border-slate-200 transform -translate-x-full {{ $isFixed ? 'md:translate-x-0 md:static' : '' }} transition-transform duration-300 z-50 flex flex-col">
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
                <a href="{{ url('/') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                          {{ request()->is('/') ? 'bg-primary text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }}">
                    <i class="fa-solid fa-home w-5"></i> Halaman Utama
                </a>

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
