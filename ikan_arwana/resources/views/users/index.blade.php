@extends('layouts.' . Auth::user()->role)

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Manajemen Users</h1>
            <p class="text-slate-500">Kelola pengguna aplikasi (Pemilik, Staff, Client)</p>
        </div>
        <a href="{{ route(Auth::user()->role . '.users.create') }}" 
           class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-indigo-700 transition font-medium text-sm flex items-center gap-2 shadow-sm shadow-indigo-500/30">
            <i class="fa-solid fa-plus"></i> Tambah User
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
            <i class="fa-solid fa-circle-exclamation text-red-600"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition">
                            <!-- Name -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-slate-900">{{ $user->name }}</span>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $user->email }}
                            </td>

                            <!-- Role -->
                            <td class="px-6 py-4">
                                @php
                                    $roleColor = match($user->role) {
                                        'pemilik' => 'bg-indigo-50 text-indigo-700',
                                        'staff' => 'bg-emerald-50 text-emerald-700',
                                        'client' => 'bg-slate-100 text-slate-600',
                                        default => 'bg-slate-100 text-slate-600',
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold capitalize {{ $roleColor }}">
                                    {{ $user->role }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route(Auth::user()->role . '.users.edit', $user->id) }}" 
                                       class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition"
                                       title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    @if($user->id !== Auth::id())
                                    <form action="{{ route(Auth::user()->role . '.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition"
                                                title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                Belum ada user.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
