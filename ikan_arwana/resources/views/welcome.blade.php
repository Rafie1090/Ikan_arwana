<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ikan Arwana - Premium Quality</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
                        primary: '#2563eb', // Blue 600 - Modern Blue
                        primaryDark: '#1d4ed8', // Blue 700
                        secondary: '#0ea5e9', // Sky 500
                        glass: 'rgba(255, 255, 255, 0.95)',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .hero-bg {
            background-image: url('https://produkdesa.com/wp-content/uploads/2023/08/arwana-super-red.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.1);
        }
        .text-shadow {
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="antialiased text-slate-800 bg-slate-50">

    <!-- NAVBAR -->
    <nav class="fixed w-full z-50 transition-all duration-500 ease-in-out top-0" id="navbar">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 transition-all duration-300" id="navbar-container">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                    <span class="font-bold text-xl text-slate-900 tracking-tight">Ikan Arwana</span>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-sm font-semibold text-slate-700 hover:text-primary transition">Beranda</a>
                    <a href="#panduan" class="text-sm font-semibold text-slate-700 hover:text-primary transition">Panduan</a>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-full hover:bg-primaryDark transition shadow-lg shadow-blue-500/30">
                                Dashboard
                            </a>
                        @else
                            <div class="flex items-center gap-4">
                                <a href="{{ route('login') }}" class="text-sm font-bold text-slate-900 hover:text-primary transition">Log in</a>
                                <a href="{{ route('register') }}" class="px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-full hover:bg-primaryDark transition shadow-lg shadow-blue-500/30">
                                    Register
                                </a>
                            </div>
                        @endauth
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-slate-900 hover:text-primary focus:outline-none">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white/95 backdrop-blur-md border-t border-slate-100 absolute w-full left-0 top-full shadow-lg rounded-b-2xl">
            <div class="px-6 py-4 space-y-4 flex flex-col">
                <a href="#home" class="text-sm font-semibold text-slate-600 hover:text-primary transition">Beranda</a>
                <a href="#panduan" class="text-sm font-semibold text-slate-600 hover:text-primary transition">Panduan</a>
                
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-full hover:bg-primaryDark transition shadow-lg shadow-blue-500/30 text-center">
                            Dashboard
                        </a>
                    @else
                        <div class="flex flex-col gap-3 mt-2">
                            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-900 hover:text-primary transition text-center py-2">Log in</a>
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-full hover:bg-primaryDark transition shadow-lg shadow-blue-500/30 text-center">
                                Register
                            </a>
                        </div>
                    @endauth
                @endif
            </div>
        </div>
    </nav>



    <!-- HERO SECTION -->
    <main class="page-animate">
    <section id="home" class="relative h-screen flex items-center justify-center hero-bg">
        <div class="absolute inset-0 bg-gradient-to-b from-white/90 via-white/60 to-slate-50"></div>
        
        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center pt-20">
            <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 mb-6 leading-tight tracking-tight text-shadow" data-aos="zoom-in-up" data-aos-duration="1200">
                Keindahan Eksotis <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Ikan Arwana</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-700 mb-10 max-w-2xl mx-auto leading-relaxed font-medium" data-aos="fade-up" data-aos-delay="200">
                Temukan koleksi Arwana terbaik dengan kualitas premium. Simbol keberuntungan dan kemewahan untuk akuarium Anda.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4" data-aos="fade-up" data-aos-delay="400">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-primary text-white font-bold rounded-full hover:bg-primaryDark transition shadow-xl shadow-blue-500/30 w-full sm:w-auto transform hover:-translate-y-1">
                    Mulai Sekarang
                </a>
                <a href="#panduan" class="px-8 py-4 bg-white text-slate-900 font-bold rounded-full hover:bg-slate-50 transition shadow-lg border border-slate-200 w-full sm:w-auto transform hover:-translate-y-1">
                    Pelajari Cara Merawat
                </a>
            </div>
        </div>
    </section>

    <!-- PANDUAN PERAWATAN -->
    <section id="panduan" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Panduan Perawatan</h2>
                <p class="text-slate-600 max-w-2xl mx-auto font-medium">Tips penting untuk menjaga kesehatan dan keindahan ikan Arwana Anda agar tetap prima.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="glass-card p-8 rounded-3xl hover:-translate-y-2 transition duration-300 border-t-4 border-t-blue-500" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 text-2xl mb-6 shadow-sm">
                        <i class="fa-solid fa-temperature-three-quarters"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Suhu & Kualitas Air</h3>
                    <p class="text-slate-600 leading-relaxed text-sm font-medium">
                        Jaga suhu air stabil antara <span class="text-slate-900 font-bold">26-30°C</span>. pH ideal <span class="text-slate-900 font-bold">6.5-7.5</span>. Lakukan penggantian air 20-30% setiap minggu.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="glass-card p-8 rounded-3xl hover:-translate-y-2 transition duration-300 border-t-4 border-t-amber-500" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 text-2xl mb-6 shadow-sm">
                        <i class="fa-solid fa-bowl-food"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Pemberian Pakan</h3>
                    <p class="text-slate-600 leading-relaxed text-sm font-medium">
                        Berikan pakan hidup seperti jangkrik, udang, atau kelabang. Variasikan menu untuk nutrisi seimbang. Jangan overfeeding.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="glass-card p-8 rounded-3xl hover:-translate-y-2 transition duration-300 border-t-4 border-t-emerald-500" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl mb-6 shadow-sm">
                        <i class="fa-solid fa-house-water"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Ukuran Aquarium</h3>
                    <p class="text-slate-600 leading-relaxed text-sm font-medium">
                        Siapkan aquarium minimal <span class="text-slate-900 font-bold">150x60x60 cm</span> untuk dewasa. Pastikan penutup rapat karena Arwana suka melompat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- GALERI -->
    <section id="galeri" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Koleksi Eksklusif</h2>
                <p class="text-slate-600 max-w-xl mx-auto font-medium">Lihat keindahan berbagai jenis Arwana yang kami sediakan.</p>
            </div>

            <!-- Carousel Container -->
            <div class="relative" data-aos="fade-up" data-aos-delay="200">
                <div class="swiper gallerySwiper overflow-hidden">
                    <div class="swiper-wrapper">
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <div class="group relative overflow-hidden rounded-2xl aspect-[4/5] shadow-lg">
                                <img src="https://produkdesa.com/wp-content/uploads/2023/08/arwana-super-red.jpg" 
                                     class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110" alt="Super Red">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80"></div>
                                <div class="absolute bottom-0 left-0 p-6">
                                    <span class="text-white bg-red-600 px-2 py-1 rounded text-xs font-bold uppercase tracking-wider mb-2 inline-block shadow-sm">Best Seller</span>
                                    <h3 class="text-white text-xl font-bold">Super Red</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="swiper-slide">
                            <div class="group relative overflow-hidden rounded-2xl aspect-[4/5] shadow-lg">
                                <img src="https://i.ytimg.com/vi/JTpp5TZOd90/maxresdefault.jpg" 
                                     class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110" alt="Golden">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80"></div>
                                <div class="absolute bottom-0 left-0 p-6">
                                    <span class="text-white bg-amber-500 px-2 py-1 rounded text-xs font-bold uppercase tracking-wider mb-2 inline-block shadow-sm">Premium</span>
                                    <h3 class="text-white text-xl font-bold">Golden RTG</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 3 -->
                        <div class="swiper-slide">
                            <div class="group relative overflow-hidden rounded-2xl aspect-[4/5] shadow-lg">
                                <img src="https://fishesofaustralia.net.au/Images/Image/ScleropagesJardiniNeilArmstrong.jpg" 
                                     class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110" alt="Jardini">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80"></div>
                                <div class="absolute bottom-0 left-0 p-6">
                                    <span class="text-white bg-emerald-600 px-2 py-1 rounded text-xs font-bold uppercase tracking-wider mb-2 inline-block shadow-sm">Exotic</span>
                                    <h3 class="text-white text-xl font-bold">Jardini</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 4 -->
                        <div class="swiper-slide">
                            <div class="group relative overflow-hidden rounded-2xl aspect-[4/5] shadow-lg">
                                <img src="https://jagadtani.com/uploads/gallery/2021/04/arwana-5fe1aaeddd.jpg" 
                                     class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110" alt="Silver">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80"></div>
                                <div class="absolute bottom-0 left-0 p-6">
                                    <span class="text-white bg-slate-500 px-2 py-1 rounded text-xs font-bold uppercase tracking-wider mb-2 inline-block shadow-sm">Classic</span>
                                    <h3 class="text-white text-xl font-bold">Silver</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button class="swiper-button-prev absolute left-0 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-primary hover:bg-primary hover:text-white transition -ml-6">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button class="swiper-button-next absolute right-0 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-primary hover:bg-primary hover:text-white transition -mr-6">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

                <!-- Pagination -->
                <div class="swiper-pagination mt-8"></div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-slate-900 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl -ml-20 -mb-20"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto text-center px-6" data-aos="zoom-in">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Siap Memiliki Arwana Impian?</h2>
            <p class="text-slate-300 text-lg mb-10 max-w-2xl mx-auto font-medium">Bergabunglah dengan ribuan kolektor lainnya dan dapatkan Arwana berkualitas premium dengan garansi kesehatan.</p>
            <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-primary text-white font-bold rounded-full hover:bg-primaryDark transition shadow-lg shadow-blue-500/30 transform hover:-translate-y-1">
                Buat Akun Sekarang
            </a>
        </div>
    </section>
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-950 text-slate-400 py-12 border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                <span class="font-bold text-white">Ikan Arwana</span>
            </div>
            <div class="text-sm font-medium">
                &copy; {{ date('Y') }} Ikan Arwana. All rights reserved.
            </div>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white transition transform hover:scale-110"><i class="fa-brands fa-instagram text-xl"></i></a>
                <a href="#" class="hover:text-white transition transform hover:scale-110"><i class="fa-brands fa-facebook text-xl"></i></a>
                <a href="#" class="hover:text-white transition transform hover:scale-110"><i class="fa-brands fa-whatsapp text-xl"></i></a>
            </div>
        </div>
    </footer>

    <!-- Swiper JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

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
        if(mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>
    
    <script>
        // Initialize Swiper
        const swiper = new Swiper('.gallerySwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
        });
        
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: false, // Allow animation to repeat on scroll
            mirror: true, // Animate elements out while scrolling past them
            offset: 50,
        });
    </script>

</body>
</html>
