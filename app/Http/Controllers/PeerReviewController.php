<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PeerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PeerReviewController extends Controller
{
    /**
     * Menampilkan form penilaian sejawat beserta teman satu kelompok.
     */
    public function index(): View
    {
        $user = Auth::user();
        $teammates = collect(); // Default collection kosong

        // Hanya ambil teman sekelompok jika user punya kelompok
        // Dan pastikan filter ANGKATAN agar tidak tercampur dengan angkatan lain
        if ($user->kelompok) {
            $teammates = User::where('role', 'mahasiswa')
                             ->where('kelas', $user->kelas)
                             ->where('kelompok', $user->kelompok)
                             ->where('angkatan', $user->angkatan) // <-- Pastikan filter angkatan ada
                             ->where('id', '!=', $user->id) // Jangan tampilkan diri sendiri
                             ->get();
        }

        // Ambil riwayat penilaian
        $reviewHistory = PeerReview::where('reviewer_id', $user->id)
                                   ->with('reviewed')
                                   ->orderBy('minggu_ke', 'desc')
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return view('mahasiswa.penilaian_sejawat.index', [
            'teammates' => $teammates,
            'reviewHistory' => $reviewHistory
        ]);
    }

    /**
     * Menyimpan data penilaian sejawat ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'minggu_ke' => 'required|integer|min:1',
            'ratings'   => 'required|array',
            'ratings.*' => 'required|integer|min:1|max:5',
            'komentars' => 'nullable|array',
            'komentars.*' => 'nullable|string|max:500',
        ]);

        // PERBAIKAN UTAMA: Gunakan Auth::user()->id untuk mengambil ANGKA ID
        $reviewerId = Auth::user()->id;

        foreach ($request->ratings as $reviewedId => $rating) {
            PeerReview::updateOrCreate(
                [
                    'reviewer_id' => $reviewerId,
                    'reviewed_id' => $reviewedId,
                    'minggu_ke'   => $request->minggu_ke,
                ],
                [
                    'rating' => $rating,
                    'komentar' => $request->komentars[$reviewedId] ?? null,
                ]
            );
        }

        return back()->with('success', 'Penilaian untuk teman sejawat di minggu ke-' . $request->minggu_ke . ' berhasil disimpan!');
    }
}