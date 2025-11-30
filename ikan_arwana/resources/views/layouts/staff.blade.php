<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - {{ config('app.name') }}</title>

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
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

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
        @include('partials.sidebar-staff')

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- TOP BAR (Mobile) -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 md:hidden">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-primary to-secondary rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-md">
                        IA
                    </div>
                    <span class="font-bold text-lg text-slate-900">Ikan Arwana</span>
                </div>
                <button id="sidebar-toggle" class="text-slate-600 hover:text-primary">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </header>

            <!-- CONTENT AREA -->
            <main class="flex-1 overflow-y-auto p-6 page-animate">
                @yield('content')
            </main>

        </div>

    </div>

    <!-- AOS Animation -->
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
