<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\MahasiswaExport;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        $mahasiswa = Mahasiswa::when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', "%$keyword%")
                      ->orWhere('nim', 'like', "%$keyword%")
                      ->orWhere('email', 'like', "%$keyword%");
            })
            ->orderBy('nama', 'asc')
            ->paginate(5); // 🔹 tampilkan 5 data per halaman

        // agar pagination tetap menyertakan kata pencarian
        $mahasiswa->appends(['search' => $keyword]);

        return view('mahasiswa.index', compact('mahasiswa', 'keyword'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas',
            'email' => 'required|email|unique:mahasiswas',
        ]);

        Mahasiswa::create($request->all());
        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas,nim,' . $mahasiswa->id,
            'email' => 'required|email|unique:mahasiswas,email,' . $mahasiswa->id,
        ]);

        $mahasiswa->update($request->all());
        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil dihapus!');
    }

    // ✅ Tambahan untuk menghindari error "undefined method show"
    public function show(Mahasiswa $mahasiswa)
    {
        // Jika kamu tidak punya halaman detail mahasiswa, bisa langsung return 404:
        abort(404);

        // Atau jika kamu nanti ingin menampilkan detail mahasiswa:
        // return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function cetakPDF()
    {
        $mahasiswas = Mahasiswa::all();
        $pdf = Pdf::loadView('mahasiswa.pdf', compact('mahasiswas'));
        return $pdf->stream('daftar_mahasiswa.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new MahasiswaExport, 'data_mahasiswa.xlsx');
    }
}
