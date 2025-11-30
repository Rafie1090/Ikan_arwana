@extends('layouts.' . Auth::user()->role)

@section('content')

<div class="max-w-2xl mx-auto">

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route(Auth::user()->role . '.users.index') }}" class="text-slate-400 hover:text-primary transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Edit User</h1>
        </div>
        <p class="text-slate-500 ml-7">Edit informasi pengguna.</p>
    </div>

    <!-- Form -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <form action="{{ route(Auth::user()->role . '.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm placeholder-slate-400">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm placeholder-slate-400">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-slate-700 mb-1">Role (Peran)</label>
                <select name="role" id="role" required
                        class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm bg-white">
                    <option value="pemilik" {{ old('role', $user->role) == 'pemilik' ? 'selected' : '' }}>Pemilik (Owner)</option>
                    <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="client" {{ old('role', $user->role) == 'client' ? 'selected' : '' }}>Client (Pelanggan)</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr class="my-6 border-slate-100">
            <p class="text-xs text-slate-400 mb-4 font-medium uppercase tracking-wider">Ubah Password (Opsional)</p>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                <input type="password" name="password" id="password"
                       class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm placeholder-slate-400"
                       placeholder="Kosongkan jika tidak ingin mengubah password">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm placeholder-slate-400"
                       placeholder="Ulangi password baru">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-indigo-700 transition font-medium text-sm shadow-sm shadow-indigo-500/30">
                    Update User
                </button>
            </div>

        </form>
    </div>

</div>

@endsection
