<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport; // Impor kelas GenericExport
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Str; // Untuk mengonversi nama model

class ExportController extends Controller
{
    /**
     * Menangani permintaan export generik (Excel atau PDF).
     *
     * @param string $type  Tipe export: 'excel' atau 'pdf'
     * @param string $model Nama model yang ingin diexport (misal: 'Presence', 'Transaction')
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function export(Request $request, $type, $model)
    {
        // Konversi nama model menjadi nama kelas model yang lengkap
        // Contoh: 'Presence' menjadi 'App\Models\Presence'
        $modelClass = 'App\\Models\\' . Str::studly($model);

        // Periksa apakah kelas model ada
        if (!class_exists($modelClass)) {
            return back()->with('error', 'Model tidak ditemukan: ' . $modelClass);
        }

        try {
            // Ambil data berdasarkan model
            // Anda bisa menambahkan logika filter/query yang lebih kompleks di sini
            // Contoh: $data = $modelClass::where('status', 'completed')->get();
            // Untuk aktivitas dan transaksi, Anda mungkin ingin menyertakan relasi:
            if ($model === 'Presence') {
                $data = $modelClass::with('member.user')->get();
            } elseif ($model === 'Transaction') {
                // Asumsi model Transaction memiliki relasi ke user atau member
                // Sesuaikan relasi sesuai dengan struktur database Anda
                $data = $modelClass::with('member', 'package')->get(); // Added 'member' and 'package'
            } else {
                $data = $modelClass::all(); // Ambil semua data untuk model lain
            }

        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data untuk model ' . $model . ' tidak ditemukan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage());
        }

        // Buat nama file yang dinamis
        $fileName = Str::kebab($model) . '_data_' . now()->format('YmdHis');

        if ($type === 'excel') {
            // Export ke Excel menggunakan kelas GenericExport
            return Excel::download(new GenericExport($data, $model), $fileName . '.xlsx');
        } elseif ($type === 'pdf') {
            // Export ke PDF menggunakan DomPDF
            // Kirim data dan judul dinamis ke view PDF
            $pdf = FacadePdf::loadView('exports.generic_pdf', [
                'data' => $data,
                'title' => 'Data ' . Str::title(str_replace('_', ' ', $model)), // Contoh: "Data Presence"
                'modelName' => $model // Kirim nama model untuk membantu penentuan header di view
            ]);
            return $pdf->download($fileName . '.pdf');
        }

        // Jika tipe export tidak valid
        return back()->with('error', 'Tipe export tidak valid.');
    }
}
