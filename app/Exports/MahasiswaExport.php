<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class MahasiswaExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Mahasiswa::select('id', 'nama', 'nim', 'email', 'created_at')->get();
    }

    // ✅ Format tiap baris di sini
    public function map($mahasiswa): array
    {
        return [
            $mahasiswa->id,
            $mahasiswa->nama,
            $mahasiswa->nim,
            $mahasiswa->email,
            Carbon::parse($mahasiswa->created_at)
                ->timezone('Asia/Makassar')
                ->format('d-m-Y H:i:s'), // tampil lebih rapi
        ];
    }

    public function headings(): array
    {
        return ['ID', 'Nama', 'NIM', 'Email', 'Tanggal Dibuat'];
    }
}
