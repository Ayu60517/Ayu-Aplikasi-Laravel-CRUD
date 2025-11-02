<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-primary">📋 Daftar Mahasiswa</h1>
    <div class="d-flex gap-2">
        <!-- Tombol Cetak Excel -->
        <a href="{{ route('mahasiswa.export') }}" class="btn btn-success btn-custom">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
        <!-- Tombol Cetak PDF -->
        <a href="{{ route('mahasiswa.cetakPDF') }}" target="_blank" class="btn btn-danger btn-custom">
            <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
        </a>
        <!-- Tombol Tambah Mahasiswa -->
        <a href="{{ route('mahasiswa.create') }}" class="btn btn-success btn-custom">
            + Tambah Mahasiswa
        </a>
    </div>
</div>


        <!-- 🔍 Form Pencarian -->
        <form action="{{ route('mahasiswa.index') }}" method="GET" class="mb-4 d-flex justify-content-end">
            <div class="input-group w-50">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama atau NIM...">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i> Cari
                </button>
                <!-- 🔄 Tombol Reset -->
                @if(request('search'))
                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Tabel Data -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Email</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswa as $index => $m)
                        <tr>
                            <td class="text-center">{{ $mahasiswa->firstItem() + $index }}</td>
                            <td>{{ $m->nama }}</td>
                            <td>{{ $m->nim }}</td>
                            <td>{{ $m->email }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('mahasiswa.edit', $m->id) }}" class="btn btn-warning btn-sm">
                                        ✏ Edit
                                    </a>
                                    <form action="{{ route('mahasiswa.destroy', $m->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                            🗑 Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data mahasiswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- 🔹 Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $mahasiswa->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
