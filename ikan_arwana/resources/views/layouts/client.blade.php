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
    </main>

    <!-- FOOTER (Matching welcome.blade.php) -->
    <footer class="bg-dark text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                        <span class="font-bold text-xl">Ikan Arwana</span>
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
                &copy; {{ date('Y') }} Ikan Arwana. All rights reserved.
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
</body>
</html>
