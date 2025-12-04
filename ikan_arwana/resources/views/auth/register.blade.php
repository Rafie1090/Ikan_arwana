<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Ikan Arwana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: {
                        primary: '#2563eb', // Blue 600
                        primaryDark: '#1d4ed8', // Blue 700
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-image: url('https://ecs7.tokopedia.net/blog-tokopedia-com/uploads/2018/08/Blog_Jenis-jenis-Ikan-Arwana-Tercantik-dan-Terpopuler-di-Dunia.jpg');
            background-size: cover;
            background-position: center;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="h-screen flex items-center justify-center p-4">

    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

    <div class="glass-card w-full max-w-md p-8 rounded-3xl relative z-10">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <h1 class="font-bold text-3xl text-slate-900 tracking-tight">Ikan Arwana</h1>
        </div>

        <h2 class="text-2xl font-bold text-center text-slate-900 mb-2">Buat Akun Baru</h2>
        <p class="text-center text-slate-600 mb-6 text-sm font-medium">Bergabunglah dengan komunitas kami</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-user text-slate-400"></i>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="pl-10 w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition text-sm placeholder-slate-400 font-medium text-slate-900"
                        placeholder="Mauskan Nama anda">
                </div>
                @error('name')
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-bold text-slate-700 mb-1.5">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-envelope text-slate-400"></i>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="pl-10 w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition text-sm placeholder-slate-400 font-medium text-slate-900"
                        placeholder="nama@email.com">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-bold text-slate-700 mb-1.5">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-slate-400"></i>
                    </div>
                    <input id="password" type="password" name="password" required
                        class="pl-10 w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition text-sm placeholder-slate-400 font-medium text-slate-900"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1.5">Konfirmasi Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-slate-400"></i>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="pl-10 w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition text-sm placeholder-slate-400 font-medium text-slate-900"
                        placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="w-full py-3 bg-primary text-white font-bold rounded-xl hover:bg-primaryDark transition shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-slate-600 font-medium">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-primary hover:text-primaryDark transition">Masuk disini</a>
            </p>
        </div>
    </div>

</body>
</html>
