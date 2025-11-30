<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .role-card {
            background: linear-gradient(135deg, #0077b6, #00b4d8);
            color: white;
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .role-icon {
            font-size: 32px;
            margin-right: 10px;
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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="font-sans antialiased">

<div class="min-h-screen bg-light">

    @include('layouts.partials.navbar')

    @include('layouts.partials.rolecard')

    <main class="py-4 container page-animate">
        {{ $slot }}
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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

</body>
</html>
