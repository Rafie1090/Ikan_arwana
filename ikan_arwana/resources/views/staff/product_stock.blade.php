@extends('layouts.staff')

@section('content')


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Kelola Stok Produk
        </h2>
    </x-slot>

    <!-- Tambahkan container / padding -->
    <div class="py-8">
        <div class="container">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h4 class="mb-4 fw-bold">Daftar Produk</h4>

                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($products as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->name }}</td>
                                    <td>Rp {{ number_format($p->price,0,',','.') }}</td>
                                    <td>{{ $p->stock }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalStok{{ $p->id }}">
                                            + Tambah Stok
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="modalStok{{ $p->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title">Tambah Stok Produk</h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                            </div>

                                            <form action="{{ route('staff.product.addStock', $p->id) }}" method="POST">
                                                @csrf

                                                <div class="modal-body">
                                                    <p class="fw-bold mb-2">{{ $p->name }}</p>

                                                    <label class="form-label">Tambah Jumlah</label>
                                                    <input type="number" name="add_stock" class="form-control" min="1" required>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button class="btn btn-success">Simpan</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </div>
@endsection
