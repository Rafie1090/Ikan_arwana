@auth
<div class="container">
    <div class="role-card d-flex align-items-center mb-4">

        <div class="role-icon">
            @if (Auth::user()->role === 'client') 🐟
            @elseif (Auth::user()->role === 'staff') 🧑‍💼
            @elseif (Auth::user()->role === 'pemilik') 👑
            @endif
        </div>

        <div>
            <div class="fw-bold fs-5">
                Halo {{ ucfirst(Auth::user()->role) }}, {{ Auth::user()->name }} 👋
            </div>
            <div class="small opacity-75">Selamat datang kembali di sistem Ikan Arwana.</div>
        </div>

    </div>
</div>
@endauth
